<?php

namespace App\Domain\Enrollment\Validators;

use App\Domain\Enrollment\Exceptions\StudentAlreadyEnrolledException;
use App\Models\Course;
use App\Models\Student;

/**
 * Validador para verificar que el estudiante no este registrado
 * Principio de responsabilidad unica
 */
class DuplicateEnrollmentValidator implements EnrollmentValidatorInterface
{
    public function validate(Course $course, Student $student): void
    {
        if ($course->hasStudent($student->id)) {
            throw new StudentAlreadyEnrolledException($student->id, $course->id);
        }
    }
}
