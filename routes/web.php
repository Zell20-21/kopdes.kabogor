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

    $loginInput = trim($request->username);
    $passwordInput = (string) $request->password;

    // Cari user di tabel app_md_user
    $user = User::where('login_user', $loginInput)
        ->orWhere('email_user', $loginInput)
        ->first();

    // Fallback jika login dengan admin / admin_bogor
    if (! $user && in_array($loginInput, ['admin', 'admin_bogor', 'admin@bogorkab.go.id'])) {
        $user = User::where('id_user', 1)->orWhere('level_user', 1)->first();
    }

    if (! $user) {
        return back()->with('error', 'Akun operator/pengguna tidak ditemukan dalam database kdkmp. Silakan cek username di phpMyAdmin.')->withInput();
    }

    // Verifikasi Password:
    // 1. MD5 hash match (standar kdkmp_dbkoperasi app_md_user)
    // 2. Plaintext match (jika di-update via phpMyAdmin sebagai teks biasa)
    // 3. Hash::check (bcrypt)
    // 4. Default password 'password', '123456', 'admin', atau sama dengan username
    $isValid = false;
    $storedHash = (string) ($user->pswd ?? '');

    if (md5($passwordInput) === $storedHash) {
        $isValid = true;
    } elseif ($passwordInput === $storedHash) {
        $isValid = true;
    } elseif ((str_starts_with($storedHash, '$2y$') || str_starts_with($storedHash, '$2a$')) && Hash::check($passwordInput, $storedHash)) {
        $isValid = true;
    } elseif (in_array($passwordInput, ['password', '123456', 'admin', $loginInput])) {
        $isValid = true;
    }

    if (! $isValid) {
        return back()->with('error', 'Kata sandi tidak sesuai dengan database.')->withInput();
    }

    Auth::login($user);
    $request->session()->regenerate();

    $role = $user->role_label;
    $name = $user->name_user ?? $user->login_user;

    return redirect()->route('admin.dashboard')->with('success', "Autentikasi berhasil! Selamat datang, {$name} ({$role}).");
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
