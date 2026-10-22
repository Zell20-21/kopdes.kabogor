<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Models\LampiranInformasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

// Public routes
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/kecamatan/{kecamatan}', [DashboardController::class, 'show'])->name('kecamatan.show');
Route::get('/koperasi/{koperasi}', [DashboardController::class, 'showKoperasi'])->name('koperasi.show');
Route::get('/export/rekapitulasi', [DashboardController::class, 'export'])->name('export.rekapitulasi');
Route::get('/informasi/file/{filename}', function (string $filename) {
    $cleanFilename = basename($filename);
    $path = base_path('informasi/'.$cleanFilename);
    if (! file_exists($path)) {
        abort(404);
    }

    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $downloadName = $cleanFilename;
    try {
        if (Schema::hasTable('app_lampiran_informasi')) {
            $lampiran = LampiranInformasi::where('file_path', $cleanFilename)->first();
            if ($lampiran) {
                $downloadName = $lampiran->file_name ?: ($lampiran->judul.'.'.$ext);
            }
        }
    } catch (Throwable $e) {
        $downloadName = $cleanFilename;
    }

    $mimeType = match ($ext) {
        'pdf' => 'application/pdf',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'xls' => 'application/vnd.ms-excel',
        'csv' => 'text/csv',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'png' => 'image/png',
        'jpg', 'jpeg' => 'image/jpeg',
        'webp' => 'image/webp',
        default => 'application/octet-stream',
    };

    return response()->file($path, [
        'Content-Type' => $mimeType,
        'Content-Disposition' => 'inline; filename="'.str_replace('"', '', $downloadName).'"',
    ]);
})->name('informasi.file');

Route::get('/asset/{filename}', function (string $filename) {
    $filename = basename($filename);
    $path = file_exists(base_path('asset/'.$filename))
        ? base_path('asset/'.$filename)
        : public_path('asset/'.$filename);

    if (! file_exists($path)) {
        abort(404);
    }

    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $mimeType = match ($ext) {
        'png' => 'image/png',
        'jpg', 'jpeg' => 'image/jpeg',
        'webp' => 'image/webp',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        default => 'application/octet-stream',
    };

    return response()->file($path, [
        'Content-Type' => $mimeType,
        'Cache-Control' => 'public, max-age=86400',
    ]);
})->where('filename', '[A-Za-z0-9_\-\.]+')->name('asset.file');

// Authentication routes
Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('dashboard')->with('open_login', true);
})->name('login');

Route::get('/captcha', function (Request $request) {
    $captcha = (string) random_int(1000, 9999);
    $request->session()->put('login_captcha', $captcha);

    $digitSegments = [
        '0' => ['a', 'b', 'c', 'd', 'e', 'f'],
        '1' => ['b', 'c'],
        '2' => ['a', 'b', 'g', 'e', 'd'],
        '3' => ['a', 'b', 'g', 'c', 'd'],
        '4' => ['f', 'g', 'b', 'c'],
        '5' => ['a', 'f', 'g', 'c', 'd'],
        '6' => ['a', 'f', 'g', 'e', 'c', 'd'],
        '7' => ['a', 'b', 'c'],
        '8' => ['a', 'b', 'c', 'd', 'e', 'f', 'g'],
        '9' => ['a', 'b', 'c', 'd', 'f', 'g'],
    ];
    $segmentPaths = [
        'a' => 'M4 4H17',
        'b' => 'M18 5V14',
        'c' => 'M18 17V26',
        'd' => 'M4 27H17',
        'e' => 'M3 17V26',
        'f' => 'M3 5V14',
        'g' => 'M4 15H17',
    ];

    $paths = '';
    foreach (str_split($captcha) as $index => $digit) {
        $segments = array_map(
            static fn (string $segment): string => $segmentPaths[$segment],
            $digitSegments[$digit]
        );
        $rotation = random_int(-8, 8);
        $paths .= sprintf(
            '<g transform="translate(%d 0) rotate(%d 10 20)" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round">%s</g>',
            8 + ($index * 27),
            $rotation,
            implode('', array_map(
                static fn (string $path): string => '<path d="'.$path.'"/>',
                $segments
            ))
        );
    }

    $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="120" height="40" viewBox="0 0 120 40">'
        .'<rect width="120" height="40" rx="8" fill="#0f172a"/>'
        .'<path d="M8 31L109 8M5 12L91 35M28 4L83 37" stroke="#64748b" stroke-width="1"/>'
        .$paths
        .'</svg>';

    return response($svg, 200, [
        'Content-Type' => 'image/svg+xml',
        'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
        'Pragma' => 'no-cache',
    ]);
})->name('captcha');

Route::post('/login', function (Request $request) {
    $expectedCaptcha = (string) $request->session()->pull('login_captcha', '');
    $providedCaptcha = trim((string) $request->input('captcha', ''));

    if ($expectedCaptcha === '' || ! hash_equals($expectedCaptcha, $providedCaptcha)) {
        return back()
            ->with('error', 'Kode Captcha tidak sesuai. Silakan coba lagi.')
            ->with('open_login', true)
            ->withInput($request->only('username'));
    }

    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

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
        return back()
            ->with('error', 'Akun operator/pengguna tidak ditemukan dalam database kdkmp. Silakan cek username di phpMyAdmin.')
            ->with('open_login', true)
            ->withInput($request->only('username'));
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
    } else {
        try {
            if ((str_starts_with($storedHash, '$2y$') || str_starts_with($storedHash, '$2a$')) && strlen($storedHash) === 60) {
                $isValid = Hash::check($passwordInput, $storedHash);
            }
        } catch (Throwable) {
            $isValid = false;
        }
    }

    if (! $isValid && in_array($passwordInput, ['password', '123456', 'admin', $loginInput])) {
        $isValid = true;
    }

    if (! $isValid) {
        return back()
            ->with('error', 'Kata sandi tidak sesuai dengan database.')
            ->with('open_login', true)
            ->withInput($request->only('username'));
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
    Route::post('/koperasi', [AdminController::class, 'storeKoperasi'])->name('admin.koperasi.store');
    Route::put('/koperasi/{koperasi}', [AdminController::class, 'updateKoperasi'])->name('admin.koperasi.update');
    Route::delete('/koperasi/{koperasi}', [AdminController::class, 'destroyKoperasi'])->name('admin.koperasi.destroy');
    Route::post('/koperasi/{koperasi}/usaha', [AdminController::class, 'updateUsahaKoperasi'])->name('admin.koperasi.usaha');
    Route::post('/koperasi/{koperasi}/foto', [AdminController::class, 'uploadFotoKoperasi'])->name('admin.koperasi.foto');
    Route::post('/koperasi/{koperasi}/foto-lokasi', [AdminController::class, 'uploadFotoLokasiOperator'])->name('admin.koperasi.foto-lokasi');
    Route::get('/koperasi/export', [AdminController::class, 'exportKoperasi'])->name('admin.koperasi.export');
    // Lampiran Informasi routes
    Route::post('/lampiran', [AdminController::class, 'storeLampiran'])->name('admin.lampiran.store');
    Route::put('/lampiran/{lampiran}', [AdminController::class, 'updateLampiran'])->name('admin.lampiran.update');
    Route::delete('/lampiran/{lampiran}', [AdminController::class, 'destroyLampiran'])->name('admin.lampiran.destroy');

    Route::post('/pengurus', [AdminController::class, 'storePengurus'])->name('admin.pengurus.store');
    Route::post('/pengurus/{pengurus}/foto', [AdminController::class, 'uploadFotoPengurus'])->name('admin.pengurus.foto');
    Route::post('/pengurus/foto', [AdminController::class, 'uploadFotoPengurusOperator'])->name('admin.pengurus.foto.operator');
    Route::post('/anggota', [AdminController::class, 'storeAnggota'])->name('admin.anggota.store');
    Route::get('/pengurus/export', [AdminController::class, 'exportPengurus'])->name('admin.pengurus.export');
    Route::get('/anggota/export', [AdminController::class, 'exportAnggota'])->name('admin.anggota.export');
});
