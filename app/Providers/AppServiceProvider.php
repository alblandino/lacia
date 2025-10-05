<?php

namespace App\Providers;

use App\Domain\Enrollment\Contracts\CourseRepositoryInterface;
use App\Domain\Enrollment\Contracts\EnrollmentRepositoryInterface;
use App\Domain\Enrollment\Contracts\StudentRepositoryInterface;
use App\Domain\Enrollment\Services\EnrollStudentService;
use App\Domain\Enrollment\Validators\CourseActiveValidator;
use App\Domain\Enrollment\Validators\DuplicateEnrollmentValidator;
use App\Infrastructure\Repositories\EloquentCourseRepository;
use App\Infrastructure\Repositories\EloquentEnrollmentRepository;
use App\Infrastructure\Repositories\EloquentStudentRepository;
use App\Services\TenantContext;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // registrar TenantContext como singleton
        $this->app->singleton(TenantContext::class);

        $this->app->bind(
            CourseRepositoryInterface::class,
            EloquentCourseRepository::class
        );

        $this->app->bind(
            StudentRepositoryInterface::class,
            EloquentStudentRepository::class
        );

        $this->app->bind(
            EnrollmentRepositoryInterface::class,
            EloquentEnrollmentRepository::class
        );

        // registrar el servicio de dominio con sus validadores
        $this->app->bind(EnrollStudentService::class, function ($app) {
            return new EnrollStudentService(
                $app->make(CourseRepositoryInterface::class),
                $app->make(StudentRepositoryInterface::class),
                $app->make(EnrollmentRepositoryInterface::class),
                // validadores usando patron strategy
                new CourseActiveValidator(),
                new DuplicateEnrollmentValidator()
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
