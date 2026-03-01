<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'question',
        'category',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function disorders()
    {
        return $this->belongsToMany(MentalDisorder::class, 'disorder_symptoms')
            ->withPivot('mb', 'md')
            ->withTimestamps();
    }

    public function disorderSymptoms()
    {
        return $this->hasMany(DisorderSymptom::class);
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'emosi' => '🧡 Emosi',
            'perilaku' => '🟢 Perilaku',
            'fisik' => '🔵 Fisik',
            'kognitif' => '🟣 Kognitif',
            default => '⚪ Umum'
        };
    }
}
