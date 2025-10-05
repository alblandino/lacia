<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear 2 tenants (universidades)
        $tenant1 = Tenant::create([
            'name' => 'Universidad Autonoma de Santo Domingo',
            'subdomain' => 'uasd',
            'active' => true,
        ]);

        $tenant2 = Tenant::create([
            'name' => 'Pontificia Universidad Catolica Madre y Maestra',
            'subdomain' => 'pucmm',
            'active' => true,
        ]);

        // === TENANT 1: UASD ===
        // Cursos para UASD
        $uasdCourses = [
            Course::create([
                'tenant_id' => $tenant1->id,
                'name' => 'Programacion I',
                'status' => 'active',
                'description' => 'Introduccion a la programacion con Python',
            ]),
            Course::create([
                'tenant_id' => $tenant1->id,
                'name' => 'Base de Datos',
                'status' => 'active',
                'description' => 'Diseño y gestion de bases de datos relacionales',
            ]),
            Course::create([
                'tenant_id' => $tenant1->id,
                'name' => 'Matematicas Discretas',
                'status' => 'inactive',
                'description' => 'Fundamentos matematicos para ciencias de la computacion',
            ]),
            Course::create([
                'tenant_id' => $tenant1->id,
                'name' => 'Algoritmos y Estructuras de Datos',
                'status' => 'active',
                'description' => 'Estudio de algoritmos eficientes y estructuras de datos',
            ]),
        ];

        // Estudiantes para UASD
        $uasdStudents = [
            Student::create([
                'tenant_id' => $tenant1->id,
                'name' => 'Juan Carlos Perez',
                'email' => 'juan.perez@uasd.edu.do',
            ]),
            Student::create([
                'tenant_id' => $tenant1->id,
                'name' => 'Maria Rodriguez',
                'email' => 'maria.rodriguez@uasd.edu.do',
            ]),
            Student::create([
                'tenant_id' => $tenant1->id,
                'name' => 'Pedro Garcia',
                'email' => 'pedro.garcia@uasd.edu.do',
            ]),
            Student::create([
                'tenant_id' => $tenant1->id,
                'name' => 'Ana Martinez',
                'email' => 'ana.martinez@uasd.edu.do',
            ]),
            Student::create([
                'tenant_id' => $tenant1->id,
                'name' => 'Luis Fernandez',
                'email' => 'luis.fernandez@uasd.edu.do',
            ]),
        ];

        // Registros para UASD
        Enrollment::create([
            'course_id' => $uasdCourses[0]->id,
            'student_id' => $uasdStudents[0]->id,
            'enrolled_at' => now(),
        ]);
        Enrollment::create([
            'course_id' => $uasdCourses[1]->id,
            'student_id' => $uasdStudents[0]->id,
            'enrolled_at' => now(),
        ]);
        Enrollment::create([
            'course_id' => $uasdCourses[0]->id,
            'student_id' => $uasdStudents[1]->id,
            'enrolled_at' => now(),
        ]);
        Enrollment::create([
            'course_id' => $uasdCourses[1]->id,
            'student_id' => $uasdStudents[2]->id,
            'enrolled_at' => now(),
        ]);
        Enrollment::create([
            'course_id' => $uasdCourses[3]->id,
            'student_id' => $uasdStudents[2]->id,
            'enrolled_at' => now(),
        ]);

        // === TENANT 2: PUCMM ===
        // Cursos para PUCMM
        $pucmmCourses = [
            Course::create([
                'tenant_id' => $tenant2->id,
                'name' => 'Desarrollo Web',
                'status' => 'active',
                'description' => 'Desarrollo de aplicaciones web modernas',
            ]),
            Course::create([
                'tenant_id' => $tenant2->id,
                'name' => 'Ingenieria de Software',
                'status' => 'active',
                'description' => 'Metodologias y practicas de desarrollo de software',
            ]),
            Course::create([
                'tenant_id' => $tenant2->id,
                'name' => 'Inteligencia Artificial',
                'status' => 'inactive',
                'description' => 'Fundamentos de IA y Machine Learning',
            ]),
            Course::create([
                'tenant_id' => $tenant2->id,
                'name' => 'Redes de Computadoras',
                'status' => 'active',
                'description' => 'Arquitectura y protocolos de redes',
            ]),
        ];

        // Estudiantes para PUCMM
        $pucmmStudents = [
            Student::create([
                'tenant_id' => $tenant2->id,
                'name' => 'Carlos Sanchez',
                'email' => 'carlos.sanchez@pucmm.edu.do',
            ]),
            Student::create([
                'tenant_id' => $tenant2->id,
                'name' => 'Sofia Lopez',
                'email' => 'sofia.lopez@pucmm.edu.do',
            ]),
            Student::create([
                'tenant_id' => $tenant2->id,
                'name' => 'Miguel Torres',
                'email' => 'miguel.torres@pucmm.edu.do',
            ]),
            Student::create([
                'tenant_id' => $tenant2->id,
                'name' => 'Isabella Ramirez',
                'email' => 'isabella.ramirez@pucmm.edu.do',
            ]),
            Student::create([
                'tenant_id' => $tenant2->id,
                'name' => 'Jose Vargas',
                'email' => 'jose.vargas@pucmm.edu.do',
            ]),
        ];

        // Registros para PUCMM
        Enrollment::create([
            'course_id' => $pucmmCourses[0]->id,
            'student_id' => $pucmmStudents[0]->id,
            'enrolled_at' => now(),
        ]);
        Enrollment::create([
            'course_id' => $pucmmCourses[1]->id,
            'student_id' => $pucmmStudents[0]->id,
            'enrolled_at' => now(),
        ]);
        Enrollment::create([
            'course_id' => $pucmmCourses[0]->id,
            'student_id' => $pucmmStudents[1]->id,
            'enrolled_at' => now(),
        ]);
        Enrollment::create([
            'course_id' => $pucmmCourses[3]->id,
            'student_id' => $pucmmStudents[1]->id,
            'enrolled_at' => now(),
        ]);
        Enrollment::create([
            'course_id' => $pucmmCourses[1]->id,
            'student_id' => $pucmmStudents[2]->id,
            'enrolled_at' => now(),
        ]);

        $this->command->info('Base de datos creada exitosamente!');
        $this->command->info('Creado:');
        $this->command->info('   - 2 Tenants (Universidades)');
        $this->command->info('   - 8 Cursos (4 por tenant)');
        $this->command->info('   - 10 Estudiantes (5 por tenant)');
        $this->command->info('   - 12 Inscripciones');
        $this->command->newLine();
        $this->command->info('IDs de Tenants:');
        $this->command->info("   - UASD: {$tenant1->id}");
        $this->command->info("   - PUCMM: {$tenant2->id}");
    }
}
