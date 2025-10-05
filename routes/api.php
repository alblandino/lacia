<?php

use App\Http\Controllers\Api\CourseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas de la API
|--------------------------------------------------------------------------
| todas las rutas API estan protegidas por el middleware tenant
| que requiere el header X-Tenant-ID para que los datos sean por tenant.
*/
Route::middleware(['tenant'])->group(function () {
    Route::post('/courses/{id}/enroll', [CourseController::class, 'enroll'])
        ->name('courses.enroll');

    Route::get('/courses/{id}/students', [CourseController::class, 'students'])
        ->name('courses.students');
});
