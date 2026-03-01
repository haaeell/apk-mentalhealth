<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Diagnosis;
use App\Models\MentalDisorder;
use App\Models\Symptom;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalDiagnoses = Diagnosis::count();
        $totalDisorders = MentalDisorder::where('is_active', true)->count();
        $totalSymptoms = Symptom::where('is_active', true)->count();

        $recentDiagnoses = Diagnosis::with(['user', 'primaryDisorder'])
            ->latest()
            ->take(10)
            ->get();

        // Statistik gangguan terbanyak terdiagnosa
        $topDisorders = MentalDisorder::withCount(['diagnoses as diagnosis_count'])
            ->orderBy('diagnosis_count', 'desc')
            ->take(5)
            ->get();

        // Data grafik per bulan (6 bulan terakhir)
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyData[] = [
                'month' => $date->format('M Y'),
                'count' => Diagnosis::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count()
            ];
        }

        // Distribusi severity
        $severityStats = [
            'ringan' => Diagnosis::whereHas('primaryDisorder', fn($q) => $q->where('severity', 'ringan'))->count(),
            'sedang' => Diagnosis::whereHas('primaryDisorder', fn($q) => $q->where('severity', 'sedang'))->count(),
            'berat' => Diagnosis::whereHas('primaryDisorder', fn($q) => $q->where('severity', 'berat'))->count(),
        ];

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalDiagnoses',
            'totalDisorders',
            'totalSymptoms',
            'recentDiagnoses',
            'topDisorders',
            'monthlyData',
            'severityStats'
        ));
    }
}
