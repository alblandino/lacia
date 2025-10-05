<?php

namespace App\Domain\Enrollment\Exceptions;

use Exception;

class StudentNotFoundException extends Exception
{
    public function __construct(int $studentId)
    {
        parent::__construct("Estudiante con ID {$studentId} no encontrado.");
    }
}
