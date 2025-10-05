<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Enrollment\Contracts\EnrollmentRepositoryInterface;
use App\Models\Enrollment;

/**
 * Implementacion de Repository Pattern
 * Principio de responsabilidad unica
 */
class EloquentEnrollmentRepository implements EnrollmentRepositoryInterface
{
    public function create(int $courseId, int $studentId): Enrollment
    {
        return Enrollment::create([
            'course_id' => $courseId,
            'student_id' => $studentId,
            'enrolled_at' => now(),
        ]);
    }

    public function exists(int $courseId, int $studentId): bool
    {
        return Enrollment::where('course_id', $courseId)
            ->where('student_id', $studentId)
            ->exists();
    }
}
