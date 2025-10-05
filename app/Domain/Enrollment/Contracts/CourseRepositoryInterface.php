<?php

namespace App\Domain\Enrollment\Contracts;

use App\Models\Course;
use App\Models\Student;

/**
 * Principio de Inversion de Dependencias
 */
interface CourseRepositoryInterface
{
    public function findById(int $id): ?Course;
    
    public function findByIdForTenant(int $id, int $tenantId): ?Course;
    
    public function getStudentsByCourse(int $courseId): iterable;
}
