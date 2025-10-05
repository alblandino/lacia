<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Enrollment\Contracts\CourseRepositoryInterface;
use App\Models\Course;
use Illuminate\Support\Collection;

/**
 * Implementacion de Repository Pattern
 * Principio de responsabilidad unica
 */
class EloquentCourseRepository implements CourseRepositoryInterface
{
    public function findById(int $id): ?Course
    {
        return Course::find($id);
    }

    public function findByIdForTenant(int $id, int $tenantId): ?Course
    {
        return Course::where('id', $id)
            ->where('tenant_id', $tenantId)
            ->first();
    }

    public function getStudentsByCourse(int $courseId): iterable
    {
        $course = Course::with('students')->find($courseId);
        
        return $course ? $course->students : collect([]);
    }
}
