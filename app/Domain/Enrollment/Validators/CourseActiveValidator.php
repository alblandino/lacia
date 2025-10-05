<?php

namespace App\Domain\Enrollment\Validators;

use App\Domain\Enrollment\Exceptions\CourseNotActiveException;
use App\Models\Course;
use App\Models\Student;

/**
 * Validador para verificar que el curso este activo
 * Principio de responsabilidad unica
 */
class CourseActiveValidator implements EnrollmentValidatorInterface
{
    public function validate(Course $course, Student $student): void
    {
        if (!$course->isActive()) {
            throw new CourseNotActiveException($course->id);
        }
    }
}
