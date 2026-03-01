<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MentalDisorder extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'recommendation',
        'severity',
        'color_code',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function symptoms()
    {
        return $this->belongsToMany(Symptom::class, 'disorder_symptoms')
            ->withPivot('mb', 'md')
            ->withTimestamps();
    }

    public function disorderSymptoms()
    {
        return $this->hasMany(DisorderSymptom::class);
    }

    public function diagnoses()
    {
        return $this->hasMany(Diagnosis::class, 'primary_disorder_id');
    }

    public function getSeverityLabelAttribute(): string
    {
        return match ($this->severity) {
            'ringan' => 'Ringan',
            'sedang' => 'Sedang',
            'berat' => 'Berat',
            default => 'Tidak Diketahui'
        };
    }

    public function getSeverityColorAttribute(): string
    {
        return match ($this->severity) {
            'ringan' => 'green',
            'sedang' => 'yellow',
            'berat' => 'red',
            default => 'gray'
        };
    }
}
