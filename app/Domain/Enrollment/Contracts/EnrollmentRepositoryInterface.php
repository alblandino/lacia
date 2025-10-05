<?php

namespace App\Domain\Enrollment\Contracts;

use App\Models\Enrollment;

/**
 * Principio de Inversion de Dependencias
 */
interface EnrollmentRepositoryInterface
{
    public function create(int $courseId, int $studentId): Enrollment;
    
    public function exists(int $courseId, int $studentId): bool;
}
