<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Redirect berdasarkan role setelah login
Auth::routes();

Route::get('/', [User\HomeController::class, 'landing'])->name('landing');

// Redirect setelah login
Route::get('/home', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.home');
})->middleware('auth')->name('home');

// ========================
// ADMIN ROUTES
// ========================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Gangguan Mental
    Route::resource('disorders', Admin\DisorderController::class);

    // Gejala
    Route::resource('symptoms', Admin\SymptomController::class)->except(['show', 'create', 'edit']);

    // Users
    Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [Admin\UserController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [Admin\UserController::class, 'destroy'])->name('users.destroy');

    // Lihat detail diagnosis
    Route::get('/diagnoses/{diagnosis}', [User\HasilController::class, 'show'])->name('diagnoses.show');
});

// ========================
// USER ROUTES
// ========================
Route::middleware(['auth', 'role:user'])->name('user.')->group(function () {
    Route::get('/beranda', [User\HomeController::class, 'home'])->name('home');
    Route::get('/diagnosa', [User\DiagnosaController::class, 'index'])->name('diagnosa');
    Route::post('/diagnosa/proses', [User\DiagnosaController::class, 'process'])->name('diagnosa.process');
    Route::get('/hasil/{diagnosis}', [User\HasilController::class, 'show'])->name('hasil');
    Route::get('/riwayat', [User\HasilController::class, 'riwayat'])->name('riwayat');
});
