<?php

namespace App\Domain\Enrollment\Services;

use App\Domain\Enrollment\Contracts\CourseRepositoryInterface;
use App\Domain\Enrollment\Contracts\EnrollmentRepositoryInterface;
use App\Domain\Enrollment\Contracts\StudentRepositoryInterface;
use App\Domain\Enrollment\Exceptions\CourseNotFoundException;
use App\Domain\Enrollment\Exceptions\StudentNotFoundException;
use App\Domain\Enrollment\Validators\EnrollmentValidatorInterface;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;

/**
 * Servicio de dominio para el registo de estudiantes
 * 
 * Aplica los siguientes principios:
 * - unica responsabilidad: solo se encarga de la logica de registro
 * - Abierto y Cerrado
 * - Inversion de Dependencias: depende de interfaces no de implementaciones
 * 
 * Patron Strategy: Los validadores pueden ser intercambiados
 */
class EnrollStudentService
{
    /**
     * @var EnrollmentValidatorInterface[]
     */
    private array $validators;

    public function __construct(
        private readonly CourseRepositoryInterface $courseRepository,
        private readonly StudentRepositoryInterface $studentRepository,
        private readonly EnrollmentRepositoryInterface $enrollmentRepository,
        EnrollmentValidatorInterface ...$validators
    ) {
        $this->validators = $validators;
    }

    /**
     * Registra un estudiante en un curso     * 
     * @throws CourseNotFoundException Si el curso no existe
     * @throws StudentNotFoundException Si el estudiante no existe
     * @throws CourseNotActiveException Si el curso no esta activo
     * @throws StudentAlreadyEnrolledException Si el estudiante ya esta registrado
     */
    public function execute(int $courseId, int $studentId, int $tenantId): Enrollment
    {
        // buscar el curso y estudiante verificando que pertenezcan al tenant
        $course = $this->courseRepository->findByIdForTenant($courseId, $tenantId);
        if (!$course) {
            throw new CourseNotFoundException($courseId);
        }

        $student = $this->studentRepository->findByIdForTenant($studentId, $tenantId);
        if (!$student) {
            throw new StudentNotFoundException($studentId);
        }

        // ejecutar todas las validaciones usando el patron strategy
        foreach ($this->validators as $validator) {
            $validator->validate($course, $student);
        }

        // crear la inscripcion en una transaccion
        return DB::transaction(function () use ($courseId, $studentId) {
            return $this->enrollmentRepository->create($courseId, $studentId);
        });
    }
}
