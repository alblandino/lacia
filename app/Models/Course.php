<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'name',
        'status',
        'description',
    ];

    protected $casts = [
        'tenant_id' => 'integer',
    ];

    /**
     * obtiene el tenant dueño del curso
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * obtiene todos los estudiantes inscritos en este curso
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'enrollments')
            ->withTimestamps()
            ->withPivot('enrolled_at');
    }

    /**
     * scope para incluir solo cursos activos
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    /**
     * scope para filtrar por tenant
     */
    public function scopeForTenant(Builder $query, int $tenantId): Builder
    {
        return $query->where('tenant_id', $tenantId);
    }

    /**
     * verifica si el curso esta activo
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * verifica si un estudiante ya esta inscrito
     */
    public function hasStudent(int $studentId): bool
    {
        return $this->students()->where('student_id', $studentId)->exists();
    }
}
