<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Fallback dashboard route to redirect to correct role dashboard
Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    return match ($role) {
        'operator' => redirect()->route('operator.dashboard'),
        'kasubag_tu' => redirect()->route('kasubag.dashboard'),
        'pegawai' => redirect()->route('pegawai.dashboard'),
        default => abort(403),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

// Operator Routes
Route::middleware(['auth', 'verified', 'role:operator'])->prefix('operator')->name('operator.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Operator\DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('pengguna', \App\Http\Controllers\Operator\UserController::class)->except(['show']);
    Route::post('pengguna/{pengguna}/toggle-active', [\App\Http\Controllers\Operator\UserController::class, 'toggleActive'])->name('pengguna.toggle_active');
    
    Route::get('aset/import', [\App\Http\Controllers\Operator\AsetController::class, 'importForm'])->name('aset.import_form');
    Route::post('aset/import', [\App\Http\Controllers\Operator\AsetController::class, 'import'])->name('aset.import');
    Route::resource('aset', \App\Http\Controllers\Operator\AsetController::class);
    Route::resource('ruangan', \App\Http\Controllers\Operator\RuanganController::class)->except(['show']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Kasubag TU Routes
Route::middleware(['auth', 'verified', 'role:kasubag_tu'])->prefix('kasubag')->name('kasubag.')->group(function () {
    Route::get('/dashboard', function () {
        return view('kasubag.dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Pegawai Routes
Route::middleware(['auth', 'verified', 'role:pegawai'])->prefix('pegawai')->name('pegawai.')->group(function () {
    Route::get('/dashboard', function () {
        return view('pegawai.dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
