<?php

namespace App\Http\Controllers\Api;

use App\Domain\Enrollment\Contracts\CourseRepositoryInterface;
use App\Domain\Enrollment\Exceptions\CourseNotActiveException;
use App\Domain\Enrollment\Exceptions\CourseNotFoundException;
use App\Domain\Enrollment\Exceptions\StudentAlreadyEnrolledException;
use App\Domain\Enrollment\Exceptions\StudentNotFoundException;
use App\Domain\Enrollment\Services\EnrollStudentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\EnrollStudentRequest;
use App\Http\Resources\EnrollmentResource;
use App\Http\Resources\StudentResource;
use App\Services\TenantContext;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Controller para gestionar inscripciones de cursos
 * Principio de responsabilidad unica: Solo maneja el HTTP y le deja la logica al servicio
 */
class CourseController extends Controller
{
    public function __construct(
        private readonly EnrollStudentService $enrollStudentService,
        private readonly CourseRepositoryInterface $courseRepository,
        private readonly TenantContext $tenantContext
    ) {}

    /**
     * Registra un estudiante en un curso
     * 
     * @param int $id ID del curso
     * @param EnrollStudentRequest $request
     * @return JsonResponse
     */
    public function enroll(int $id, EnrollStudentRequest $request): JsonResponse
    {
        try {
            $tenantId = $this->tenantContext->getTenant();
            
            $enrollment = $this->enrollStudentService->execute(
                courseId: $id,
                studentId: $request->validated('student_id'),
                tenantId: $tenantId
            );

            return response()->json([
                'message' => 'Estudiante registrado exitosamente',
                'data' => new EnrollmentResource($enrollment)
            ], 201);

        } catch (CourseNotFoundException $e) {
            return response()->json([
                'error' => 'Curso no encontrado',
                'message' => $e->getMessage()
            ], 404);

        } catch (StudentNotFoundException $e) {
            return response()->json([
                'error' => 'Estudiante no encontrado',
                'message' => $e->getMessage()
            ], 404);

        } catch (CourseNotActiveException $e) {
            return response()->json([
                'error' => 'Curso inactivo',
                'message' => $e->getMessage()
            ], 422);

        } catch (StudentAlreadyEnrolledException $e) {
            return response()->json([
                'error' => 'Ya esta regoistrado',
                'message' => $e->getMessage()
            ], 409);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error interno del servidor',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Retorna los estudiantes regoistrados en un curso
     * 
     * @param int $id ID del curso
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function students(int $id): AnonymousResourceCollection|JsonResponse
    {
        try {
            $tenantId = $this->tenantContext->getTenant();

            // verificar que el curso pertenezca al tenant
            $course = $this->courseRepository->findByIdForTenant($id, $tenantId);
            
            if (!$course) {
                return response()->json([
                    'error' => 'Curso no encontrado',
                    'message' => "El curso con ID {$id} no fue encontrado para este tenant."
                ], 404);
            }

            $students = $this->courseRepository->getStudentsByCourse($id);

            return StudentResource::collection($students);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error interno del servidor',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
