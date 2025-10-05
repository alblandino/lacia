<?php

namespace App\Domain\Enrollment\Exceptions;

use Exception;

class StudentAlreadyEnrolledException extends Exception
{
    public function __construct(int $studentId, int $courseId)
    {
        parent::__construct("Estudiante con ID {$studentId} ya esta inscrito en curso con ID {$courseId}.");
    }
}
