<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnrollStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => [
                'required',
                'integer',
                'exists:students,id'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.required' => 'El ID del estudiante es obligatorio.',
            'student_id.integer' => 'El ID del estudiante debe ser un numero entero.',
            'student_id.exists' => 'El estudiante no existe.',
        ];
    }
}
