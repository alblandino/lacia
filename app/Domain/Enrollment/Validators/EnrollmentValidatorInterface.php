<?php

namespace App\Domain\Enrollment\Validators;

use App\Models\Course;
use App\Models\Student;

/**
 * Interface para validadores - Patron Strategy
 * Permite multiples estrategias de validacion
 */
interface EnrollmentValidatorInterface
{
    public function validate(Course $course, Student $student): void;
}
