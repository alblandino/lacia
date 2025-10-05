<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subdomain',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * obtiene todos los cursos de este tenant
     */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    /**
     * obtiene todos los estudiantes de este tenant
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
