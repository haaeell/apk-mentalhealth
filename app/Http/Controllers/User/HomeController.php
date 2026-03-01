<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MentalDisorder;
use App\Models\Diagnosis;

class HomeController extends Controller
{
    public function landing()
    {
        $disorders = MentalDisorder::where('is_active', true)->take(6)->get();
        $totalDiagnoses = Diagnosis::count();
        $totalUsers = \App\Models\User::where('role', 'user')->count();
        return view('user.landing', compact('disorders', 'totalDiagnoses', 'totalUsers'));
    }

    public function home()
    {
        $recentDiagnoses = auth()->user()->diagnoses()
            ->with('primaryDisorder')
            ->latest()
            ->take(5)
            ->get();
        $totalDiagnoses = auth()->user()->diagnoses()->count();
        return view('user.home', compact('recentDiagnoses', 'totalDiagnoses'));
    }
}
