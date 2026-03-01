<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisorderSymptom extends Model
{
    use HasFactory;

    protected $fillable = [
        'mental_disorder_id',
        'symptom_id',
        'mb',
        'md'
    ];

    protected $casts = [
        'mb' => 'decimal:3',
        'md' => 'decimal:3',
    ];

    public function disorder()
    {
        return $this->belongsTo(MentalDisorder::class, 'mental_disorder_id');
    }

    public function symptom()
    {
        return $this->belongsTo(Symptom::class);
    }
}
