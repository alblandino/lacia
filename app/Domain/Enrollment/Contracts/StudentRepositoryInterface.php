<?php

namespace App\Domain\Enrollment\Contracts;

use App\Models\Student;

/**
 * Principio de Inversion de Dependencias
 */
interface StudentRepositoryInterface
{
    public function findById(int $id): ?Student;
    
    public function findByIdForTenant(int $id, int $tenantId): ?Student;
}
