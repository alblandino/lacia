<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Enrollment\Contracts\StudentRepositoryInterface;
use App\Models\Student;

/**
 * Implementacion de Repository Pattern
 * Principio de responsabilidad unica
 */
class EloquentStudentRepository implements StudentRepositoryInterface
{
    public function findById(int $id): ?Student
    {
        return Student::find($id);
    }

    public function findByIdForTenant(int $id, int $tenantId): ?Student
    {
        return Student::where('id', $id)
            ->where('tenant_id', $tenantId)
            ->first();
    }
}
