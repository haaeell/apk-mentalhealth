<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Diagnosis;
use App\Models\MentalDisorder;
use App\Models\Symptom;

class HasilController extends Controller
{
    public function show(Diagnosis $diagnosis)
    {
        // Pastikan user hanya bisa lihat diagnosisnya sendiri
        if ($diagnosis->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $diagnosis->load(['primaryDisorder', 'user']);

        // Load semua disorder dari hasil
        $allResults = [];
        if (!empty($diagnosis->results)) {
            $disorders = MentalDisorder::whereIn('id', array_keys($diagnosis->results))->get();
            foreach ($diagnosis->results as $disorderId => $cfValue) {
                $disorder = $disorders->find($disorderId);
                if ($disorder) {
                    $allResults[] = [
                        'disorder' => $disorder,
                        'cf' => $cfValue,
                        'percentage' => round($cfValue * 100, 2),
                    ];
                }
            }
        }

        // Load gejala yang dipilih user
        $userSymptoms = [];
        if (!empty($diagnosis->answers)) {
            $symptoms = Symptom::whereIn('id', array_keys($diagnosis->answers))->get();
            foreach ($diagnosis->answers as $symptomId => $cfUser) {
                $symptom = $symptoms->find($symptomId);
                if ($symptom) {
                    $userSymptoms[] = [
                        'symptom' => $symptom,
                        'cf_user' => $cfUser,
                    ];
                }
            }
        }

        $riwayat = auth()->user()->diagnoses()
            ->with('primaryDisorder')
            ->where('id', '!=', $diagnosis->id)
            ->latest()
            ->take(3)
            ->get();

        return view('user.hasil.show', compact('diagnosis', 'allResults', 'userSymptoms', 'riwayat'));
    }

    public function riwayat()
    {
        $diagnoses = auth()->user()->diagnoses()
            ->with('primaryDisorder')
            ->latest()
            ->paginate(10);
        return view('user.hasil.riwayat', compact('diagnoses'));
    }
}
