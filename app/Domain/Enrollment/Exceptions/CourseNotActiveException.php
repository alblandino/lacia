<?php

namespace App\Domain\Enrollment\Exceptions;

use Exception;

class CourseNotActiveException extends Exception
{
    public function __construct(int $courseId)
    {
        parent::__construct("Curso con ID {$courseId} no esta activo.");
    }
}
