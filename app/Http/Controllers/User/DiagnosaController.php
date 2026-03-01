<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Symptom;
use App\Models\MentalDisorder;
use App\Models\Diagnosis;
use App\Services\CertaintyFactorService;
use Illuminate\Http\Request;

class DiagnosaController extends Controller
{
    public function index()
    {
        $symptoms = Symptom::where('is_active', true)->get()->groupBy('category');
        $cfScale = CertaintyFactorService::cfUserScale();
        $totalSymptoms = Symptom::where('is_active', true)->count();

        return view('user.diagnosa.index', compact('symptoms', 'cfScale', 'totalSymptoms'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'answers' => 'required|array|min:1',
            'answers.*' => 'numeric|min:0|max:1',
        ]);

        $answers = array_filter($request->answers, fn($v) => $v > 0);

        if (empty($answers)) {
            return back()->with('error', 'Silakan pilih minimal satu gejala yang Anda alami.');
        }

        // Hitung Certainty Factor
        $results = CertaintyFactorService::processAnswers($answers);

        if (empty($results)) {
            // Tidak ada gangguan terdeteksi - mungkin sehat
            $diagnosis = Diagnosis::create([
                'user_id' => auth()->id(),
                'answers' => $answers,
                'results' => [],
                'primary_disorder_id' => null,
                'cf_final' => 0,
                'status' => 'completed',
            ]);

            return redirect()->route('user.hasil', $diagnosis->id);
        }

        // Ambil gangguan utama (CF tertinggi)
        $primaryDisorderId = array_key_first($results);
        $cfFinal = $results[$primaryDisorderId];

        $diagnosis = Diagnosis::create([
            'user_id' => auth()->id(),
            'answers' => $answers,
            'results' => $results,
            'primary_disorder_id' => $primaryDisorderId,
            'cf_final' => $cfFinal,
            'status' => 'completed',
        ]);

        return redirect()->route('user.hasil', $diagnosis->id);
    }
}
