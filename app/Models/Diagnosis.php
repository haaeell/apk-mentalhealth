<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'answers',
        'results',
        'primary_disorder_id',
        'cf_final',
        'status',
        'notes'
    ];

    protected $casts = [
        'answers' => 'array',
        'results' => 'array',
        'cf_final' => 'decimal:4',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function primaryDisorder()
    {
        return $this->belongsTo(MentalDisorder::class, 'primary_disorder_id');
    }

    public function getCfPercentageAttribute(): float
    {
        return round(($this->cf_final ?? 0) * 100, 2);
    }

    public function getConfidenceLabelAttribute(): string
    {
        $cf = $this->cf_final ?? 0;
        if ($cf >= 0.8) return 'Sangat Tinggi';
        if ($cf >= 0.6) return 'Tinggi';
        if ($cf >= 0.4) return 'Sedang';
        if ($cf >= 0.2) return 'Rendah';
        return 'Sangat Rendah';
    }
}
