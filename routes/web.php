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

    Route::get('peminjaman', [\App\Http\Controllers\Operator\PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('peminjaman/{peminjaman}', [\App\Http\Controllers\Operator\PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::post('peminjaman/{peminjaman}/serah-terima', [\App\Http\Controllers\Operator\PeminjamanController::class, 'prosesSerahTerima'])->name('peminjaman.serah_terima');
    Route::post('peminjaman/{peminjaman}/dikembalikan', [\App\Http\Controllers\Operator\PeminjamanController::class, 'konfirmasiDikembalikan'])->name('peminjaman.dikembalikan');
    Route::post('peminjaman/{peminjaman}/reminder', [\App\Http\Controllers\Operator\PeminjamanController::class, 'kirimReminder'])->name('peminjaman.reminder');

    Route::get('pemeliharaan', [\App\Http\Controllers\Operator\PemeliharaanController::class, 'index'])->name('pemeliharaan.index');
    Route::get('pemeliharaan/create', [\App\Http\Controllers\Operator\PemeliharaanController::class, 'create'])->name('pemeliharaan.create');
    Route::post('pemeliharaan', [\App\Http\Controllers\Operator\PemeliharaanController::class, 'store'])->name('pemeliharaan.store');
    Route::get('pemeliharaan/{pemeliharaan}', [\App\Http\Controllers\Operator\PemeliharaanController::class, 'show'])->name('pemeliharaan.show');
    Route::post('pemeliharaan/{pemeliharaan}/proses', [\App\Http\Controllers\Operator\PemeliharaanController::class, 'proses'])->name('pemeliharaan.proses');
    Route::post('pemeliharaan/{pemeliharaan}/selesai', [\App\Http\Controllers\Operator\PemeliharaanController::class, 'selesai'])->name('pemeliharaan.selesai');

    Route::get('laporan', [\App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');
    Route::post('laporan/generate', [\App\Http\Controllers\LaporanController::class, 'generate'])->name('laporan.generate');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Kasubag TU Routes
Route::middleware(['auth', 'verified', 'role:kasubag_tu'])->prefix('kasubag')->name('kasubag.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Kasubag\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('aset', \App\Http\Controllers\Kasubag\AsetController::class)->only(['index', 'show']);
    Route::resource('ruangan', \App\Http\Controllers\Kasubag\RuanganController::class)->only(['index']);

    Route::get('persetujuan-peminjaman', [\App\Http\Controllers\Kasubag\PersetujuanPeminjamanController::class, 'index'])->name('persetujuan.index');
    Route::get('persetujuan-peminjaman/{peminjaman}', [\App\Http\Controllers\Kasubag\PersetujuanPeminjamanController::class, 'show'])->name('persetujuan.show');
    Route::post('persetujuan-peminjaman/{peminjaman}/approve', [\App\Http\Controllers\Kasubag\PersetujuanPeminjamanController::class, 'approve'])->name('persetujuan.approve');
    Route::post('persetujuan-peminjaman/{peminjaman}/reject', [\App\Http\Controllers\Kasubag\PersetujuanPeminjamanController::class, 'reject'])->name('persetujuan.reject');

    Route::get('persetujuan-pemeliharaan', [\App\Http\Controllers\Kasubag\PersetujuanPemeliharaanController::class, 'index'])->name('persetujuan_pemeliharaan.index');
    Route::get('persetujuan-pemeliharaan/{pemeliharaan}', [\App\Http\Controllers\Kasubag\PersetujuanPemeliharaanController::class, 'show'])->name('persetujuan_pemeliharaan.show');
    Route::post('persetujuan-pemeliharaan/{pemeliharaan}/approve', [\App\Http\Controllers\Kasubag\PersetujuanPemeliharaanController::class, 'approve'])->name('persetujuan_pemeliharaan.approve');
    Route::post('persetujuan-pemeliharaan/{pemeliharaan}/reject', [\App\Http\Controllers\Kasubag\PersetujuanPemeliharaanController::class, 'reject'])->name('persetujuan_pemeliharaan.reject');

    Route::get('laporan', [\App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');
    Route::post('laporan/generate', [\App\Http\Controllers\LaporanController::class, 'generate'])->name('laporan.generate');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Pegawai Routes
Route::middleware(['auth', 'verified', 'role:pegawai'])->prefix('pegawai')->name('pegawai.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Pegawai\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('katalog-aset', \App\Http\Controllers\Pegawai\KatalogAsetController::class)->only(['index', 'show'])->names('katalog_aset');
    Route::resource('peminjaman', \App\Http\Controllers\Pegawai\PeminjamanController::class)->only(['index', 'create', 'store', 'show']);
    Route::resource('laporan-kerusakan', \App\Http\Controllers\Pegawai\LaporanKerusakanController::class)->only(['index', 'create', 'store', 'show'])->names('laporan_kerusakan');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
