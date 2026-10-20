<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/kecamatan/{kecamatan}', [DashboardController::class, 'show'])->name('kecamatan.show');
Route::get('/export/rekapitulasi', [DashboardController::class, 'export'])->name('export.rekapitulasi');

Route::post('/login', function (Request $request) {
    $request->validate([
        'username' => 'required',
        'password' => 'required',
        'captcha' => 'required',
    ]);

    if ($request->captcha !== '2842') {
        return back()->with('error', 'Kode Captcha tidak sesuai. Silakan coba lagi.')->withInput();
    }

    return back()->with('success', 'Autentikasi simulasi berhasil! Selamat datang di Portal Petugas & Pengurus KMP.');
})->name('portal.login');
