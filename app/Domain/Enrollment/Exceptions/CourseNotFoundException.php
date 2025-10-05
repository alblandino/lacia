<?php

namespace App\Domain\Enrollment\Exceptions;

use Exception;

class CourseNotFoundException extends Exception
{
    public function __construct(int $courseId)
    {
        parent::__construct("Curso con ID {$courseId} no encontrado.");
    }
}
