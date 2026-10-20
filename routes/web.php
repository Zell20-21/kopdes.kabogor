<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/kecamatan/{kecamatan}', [DashboardController::class, 'show'])->name('kecamatan.show');
Route::get('/export/rekapitulasi', [DashboardController::class, 'export'])->name('export.rekapitulasi');

// Authentication routes
Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('dashboard')->with('open_login', true);
})->name('login');

Route::post('/login', function (Request $request) {
    $request->validate([
        'username' => 'required',
        'password' => 'required',
        'captcha' => 'required',
    ]);

    if ($request->captcha !== '2842') {
        return back()->with('error', 'Kode Captcha tidak sesuai. Silakan coba lagi.')->withInput();
    }

    // Authenticate admin user
    $user = User::firstOrCreate(
        ['email' => 'admin@bogorkab.go.id'],
        [
            'name' => 'Administrator KMP',
            'password' => Hash::make('password'),
        ]
    );

    Auth::login($user);
    $request->session()->regenerate();

    return redirect()->route('admin.dashboard')->with('success', 'Autentikasi berhasil! Selamat datang di Panel Admin Koperasi Merah Putih.');
})->name('portal.login');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('dashboard')->with('success', 'Anda telah berhasil keluar (Log Out).');
})->name('logout');

// Admin protected routes
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
});
