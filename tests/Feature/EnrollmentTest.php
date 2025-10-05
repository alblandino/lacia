<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Student;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnrollmentTest extends TestCase
{
    use RefreshDatabase;

    protected Tenant $tenant;
    protected Course $activeCourse;
    protected Course $inactiveCourse;
    protected Student $student;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear tenant y datos de prueba
        $this->tenant = Tenant::create([
            'name' => 'Universidad de prueba',
            'subdomain' => 'test',
            'active' => true,
        ]);

        $this->activeCourse = Course::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Curso Activo de Prueba',
            'status' => 'active',
            'description' => 'Curso de prueba',
        ]);

        $this->inactiveCourse = Course::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Curso Inactivo de Prueba',
            'status' => 'inactive',
            'description' => 'Curso inactivo de prueba',
        ]);

        $this->student = Student::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Estudiante de Prueba',
            'email' => 'joel@test.com',
        ]);
    }

    public function test_no_se_puede_inscribir_sin_header_de_tenant(): void
    {
        $response = $this->postJson("/api/courses/{$this->activeCourse->id}/enroll", [
            'student_id' => $this->student->id,
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'error' => 'Tenant ID obligatorio',
            ]);
    }

    public function test_se_puede_inscribir_estudiante_en_curso_activo(): void
    {
        $response = $this->withHeader('X-Tenant-ID', $this->tenant->id)
            ->postJson("/api/courses/{$this->activeCourse->id}/enroll", [
                'student_id' => $this->student->id,
            ]);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Estudiante registrado exitosamente',
            ]);

        $this->assertDatabaseHas('enrollments', [
            'course_id' => $this->activeCourse->id,
            'student_id' => $this->student->id,
        ]);
    }

    public function test_no_se_puede_inscribir_estudiante_en_curso_inactivo(): void
    {
        $response = $this->withHeader('X-Tenant-ID', $this->tenant->id)
            ->postJson("/api/courses/{$this->inactiveCourse->id}/enroll", [
                'student_id' => $this->student->id,
            ]);

        $response->assertStatus(422)
            ->assertJson([
                'error' => 'Curso inactivo',
            ]);
    }

    public function test_no_se_puede_inscribir_estudiante_dos_veces_en_mismo_curso(): void
    {
        // Primera inscripcion
        $this->withHeader('X-Tenant-ID', $this->tenant->id)
            ->postJson("/api/courses/{$this->activeCourse->id}/enroll", [
                'student_id' => $this->student->id,
            ]);

        // Segunda inscripcion (debe fallar)
        $response = $this->withHeader('X-Tenant-ID', $this->tenant->id)
            ->postJson("/api/courses/{$this->activeCourse->id}/enroll", [
                'student_id' => $this->student->id,
            ]);

        $response->assertStatus(409)
            ->assertJson([
                'error' => 'Ya esta regoistrado',
            ]);
    }

    public function test_se_pueden_obtener_estudiantes_de_curso(): void
    {
        // Inscribir estudiante
        $this->activeCourse->students()->attach($this->student->id);

        $response = $this->withHeader('X-Tenant-ID', $this->tenant->id)
            ->getJson("/api/courses/{$this->activeCourse->id}/students");

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment([
                'id' => $this->student->id,
                'name' => $this->student->name,
                'email' => $this->student->email,
            ]);
    }

    public function test_aislamiento_de_tenant_en_inscripcion(): void
    {
        // Crear otro tenant con su curso y estudiante
        $otherTenant = Tenant::create([
            'name' => 'Otra Universidad',
            'subdomain' => 'otra',
            'active' => true,
        ]);

        $otherCourse = Course::create([
            'tenant_id' => $otherTenant->id,
            'name' => 'Otro Curso',
            'status' => 'active',
            'description' => 'Otro Curso',
        ]);

        // Intentar inscribir estudiante del tenant 1 en curso del tenant 2
        $response = $this->withHeader('X-Tenant-ID', $this->tenant->id)
            ->postJson("/api/courses/{$otherCourse->id}/enroll", [
                'student_id' => $this->student->id,
            ]);

        $response->assertStatus(404)
            ->assertJson([
                'error' => 'Curso no encontrado',
            ]);
    }

    public function test_aislamiento_de_tenant_al_obtener_estudiantes(): void
    {
        // Crear otro tenant con su curso
        $otherTenant = Tenant::create([
            'name' => 'Otra Universidad',
            'subdomain' => 'otra',
            'active' => true,
        ]);

        $otherCourse = Course::create([
            'tenant_id' => $otherTenant->id,
            'name' => 'Otro Curso',
            'status' => 'active',
            'description' => 'Otro Curso',
        ]);

        // Intentar obtener estudiantes de curso de otro tenant
        $response = $this->withHeader('X-Tenant-ID', $this->tenant->id)
            ->getJson("/api/courses/{$otherCourse->id}/students");

        $response->assertStatus(404)
            ->assertJson([
                'error' => 'Curso no encontrado',
            ]);
    }
}
