@extends('layouts.app')

@section('title', 'Informasi Koperasi | GovTech KOP Kabupaten Bogor')

@section('content')
<div class="min-h-screen bg-[#f8fafc] flex flex-col justify-between text-slate-800">

    <!-- Top Navigation Header GovTech KOP -->
    <header class="bg-gradient-to-r from-[#881337] via-[#991b1b] to-[#7f1d1d] text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Left: Logo KOP DES KEL MERAH PUTIH & GovTech KOP Brand -->
                <div class="flex items-center space-x-3">
                    <div class="h-10 w-10 sm:h-11 sm:w-11 rounded-xl bg-white p-1 flex items-center justify-center shadow-md shrink-0">
                        <img src="{{ asset('images/logo-kopdeskel-clean.png') }}" alt="Logo KOP DES KEL Merah Putih" class="h-full w-auto object-contain">
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <h1 class="text-base sm:text-lg font-black tracking-wide text-white uppercase leading-none">
                                KOPERASI MERAH PUTIH
                            </h1>
                            <span class="text-[9px] sm:text-[10px] font-extrabold px-2 py-0.5 rounded-full border border-white/30 text-white/95 bg-white/10 uppercase tracking-wider">
                                GOVTECH KOP
                            </span>
                        </div>
                        <p class="text-xs text-red-200 font-medium leading-none mt-1">
                            Pemerintah Kabupaten Bogor &bull; Dinas Koperasi & UKM
                        </p>
                    </div>
                </div>

                <!-- Right: Public Link & Log Out Button -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('dashboard') }}" class="hidden sm:inline-flex items-center space-x-1.5 text-xs font-semibold px-3 py-1.5 rounded-full bg-white/10 hover:bg-white/20 text-white transition border border-white/20">
                        <i class="fa-solid fa-globe text-[11px]"></i>
                        <span>Lihat Web Publik</span>
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center space-x-2 bg-white/10 hover:bg-white/20 border border-white/25 text-white px-4 py-1.5 rounded-full text-xs sm:text-sm font-bold shadow-sm transition-all duration-200 hover:shadow transform active:scale-95 cursor-pointer">
                            <span>Log Out</span>
                            <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Container with Sidebar -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <!-- Flash Notice if any -->
        @if(session('success'))
            <div class="mb-5 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-circle-check text-emerald-600"></i>
                    <span class="text-xs sm:text-sm font-bold">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-6">

            <!-- Left Sidebar Navigation Card -->
            <aside class="w-full lg:w-64 shrink-0">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-4 space-y-4 sticky top-22">
                    
                    <!-- Profile Header Box -->
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-50 border border-emerald-200 flex items-center justify-center text-emerald-600 shadow-sm shrink-0">
                            <i class="fa-solid fa-shield-halved text-base"></i>
                        </div>
                        <div class="leading-tight overflow-hidden">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">
                                @if(isset($user) && $user->isOperatorDesa())
                                    DESK KOP DESA
                                @elseif(isset($user) && $user->isOperatorKecamatan())
                                    DESK KOP KECAMATAN
                                @else
                                    DESK KOP
                                @endif
                            </span>
                            <strong class="text-sm font-extrabold text-slate-900 tracking-tight block truncate" title="{{ $user->name_user ?? 'KABUPATEN BOGOR' }}">
                                @if(isset($user) && $user->isOperatorDesa())
                                    {{ $user->kelurahan?->name_kopkel ?? $user->name_user ?? 'DESA' }}
                                @elseif(isset($user) && $user->isOperatorKecamatan())
                                    {{ $user->kecamatan?->name_kopkec ?? $user->name_user ?? 'KECAMATAN' }}
                                @else
                                    KABUPATEN BOGOR
                                @endif
                            </strong>
                        </div>
                    </div>

                    <!-- Navigation Menu Items -->
                    <nav class="space-y-1.5 text-xs font-bold">
                        <!-- 1. INFORMASI -->
                        <a href="{{ route('admin.dashboard', ['tab' => 'informasi']) }}"
                           class="w-full flex items-center space-x-3 px-4 py-2.5 rounded-xl transition shadow-sm {{ $activeTab === 'informasi' ? 'bg-[#0284c7] text-white shadow-sky-600/20' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200/70' }}">
                            <i class="fa-solid fa-circle-info text-sm"></i>
                            <span>INFORMASI</span>
                        </a>

                        <!-- 2. DATABASE KOPERASI -->
                        <a href="{{ route('admin.dashboard', ['tab' => 'koperasi']) }}"
                           class="w-full flex items-center space-x-3 px-4 py-2.5 rounded-xl transition shadow-sm {{ $activeTab === 'koperasi' ? 'bg-[#0284c7] text-white shadow-sky-600/20' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200/70' }}">
                            <i class="fa-regular fa-building text-sm"></i>
                            <span>DATABASE KOPERASI</span>
                        </a>

                        <!-- 3. DATABASE PENGURUS -->
                        <a href="{{ route('admin.dashboard', ['tab' => 'pengurus']) }}"
                           class="w-full flex items-center space-x-3 px-4 py-2.5 rounded-xl transition shadow-sm {{ $activeTab === 'pengurus' ? 'bg-[#0284c7] text-white shadow-sky-600/20' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200/70' }}">
                            <i class="fa-solid fa-users text-sm"></i>
                            <span>DATABASE PENGURUS</span>
                        </a>

                        <!-- 4. DATABASE ANGGOTA -->
                        <a href="{{ route('admin.dashboard', ['tab' => 'anggota']) }}"
                           class="w-full flex items-center space-x-3 px-4 py-2.5 rounded-xl transition shadow-sm {{ $activeTab === 'anggota' ? 'bg-[#0284c7] text-white shadow-sky-600/20' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200/70' }}">
                            <i class="fa-regular fa-id-card text-sm"></i>
                            <span>DATABASE ANGGOTA</span>
                        </a>
                    </nav>

                    <!-- Sidebar Footer Info -->
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <div class="flex items-center space-x-1.5 text-emerald-600 font-bold text-[11px]">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Sistem Aktif</span>
                        </div>
                        <span class="text-[11px] font-mono text-slate-400">v2.4.0</span>
                    </div>

                    <!-- User Meta Box -->
                    @if(isset($user))
                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 text-[11px] space-y-1">
                            <div class="text-slate-400 font-medium">Masuk Sebagai:</div>
                            <div class="font-bold text-slate-800 truncate">{{ $user->name_user }}</div>
                            <div class="text-[10px] text-sky-700 font-semibold uppercase">{{ $user->role_label }}</div>
                        </div>
                    @endif

                </div>
            </aside>

            <!-- Right Main Work Area -->
            <section class="flex-1 space-y-6">

                @if($activeTab === 'informasi')
                    <!-- ================= TAB: INFORMASI KOPERASI ================= -->

                    <!-- Section Header Bar -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight uppercase leading-tight">
                                INFORMASI KOPERASI
                            </h2>
                            <p class="text-xs font-bold text-slate-400 italic tracking-wider uppercase">
                                @if(isset($user) && $user->isOperatorDesa())
                                    {{ $user->koperasi?->name_koperasi ?? ($user->kelurahan?->name_kopkel . ' - KECAMATAN ' . ($user->kecamatan?->name_kopkec ?? '')) }}
                                @elseif(isset($user) && $user->isOperatorKecamatan())
                                    KECAMATAN {{ $user->kecamatan?->name_kopkec }}
                                @else
                                    KABUPATEN BOGOR
                                @endif
                            </p>
                        </div>

                        <!-- Dropdown Select Header -->
                        <div class="relative">
                            <select onchange="window.location.href=this.value"
                                    class="bg-white border border-slate-300 rounded-xl px-4 py-2 text-xs font-extrabold text-slate-700 uppercase tracking-wider focus:outline-none focus:ring-2 focus:ring-sky-500 shadow-sm cursor-pointer pr-9">
                                <option value="{{ route('admin.dashboard', ['tab' => 'informasi']) }}" selected>INFORMASI KOPERASI</option>
                                <option value="{{ route('admin.dashboard', ['tab' => 'koperasi']) }}">DATABASE KOPERASI</option>
                                <option value="{{ route('admin.dashboard', ['tab' => 'pengurus']) }}">DATABASE PENGURUS</option>
                                <option value="{{ route('admin.dashboard', ['tab' => 'anggota']) }}">DATABASE ANGGOTA</option>
                            </select>
                        </div>
                    </div>

                    <!-- Top Row: 2 Big Highlight Stat Cards (435 Koperasi & 0 Anggota) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Card 1: KOPERASI (Coral/Terracotta Red) -->
                        <div class="bg-[#b85d4f] rounded-2xl p-6 text-white shadow-sm relative overflow-hidden flex flex-col justify-between min-h-[160px] hover:shadow-md transition">
                            <div class="z-10">
                                <div class="text-5xl font-black text-white leading-none tracking-tight">
                                    {{ $totalKoperasi }}
                                </div>
                                <div class="text-sm font-bold italic tracking-wider uppercase mt-1 text-white/95">
                                    KOPERASI
                                </div>
                            </div>
                            <div class="z-10 text-xs text-white/90 flex items-center space-x-1.5 mt-4">
                                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                <span>
                                    @if(isset($user) && $user->isOperatorDesa())
                                        Desa/Kelurahan {{ $user->kelurahan?->name_kopkel ?? '' }} (Kec. {{ $user->kecamatan?->name_kopkec ?? '' }})
                                    @elseif(isset($user) && $user->isOperatorKecamatan())
                                        Wilayah Kecamatan {{ $user->kecamatan?->name_kopkec ?? '' }}
                                    @else
                                        Tersebar di 40 Kecamatan Kabupaten Bogor
                                    @endif
                                </span>
                            </div>

                            <!-- Watermark Map Pin Icon -->
                            <i class="fa-solid fa-location-dot absolute right-4 top-1/2 -translate-y-1/2 text-8xl text-white/15 pointer-events-none"></i>
                        </div>

                        <!-- Card 2: 0 Anggota Koperasi (Teal/Emerald Green) -->
                        <div class="bg-[#0f9488] rounded-2xl p-6 text-white shadow-sm relative overflow-hidden flex flex-col justify-between min-h-[160px] hover:shadow-md transition">
                            <div class="z-10">
                                <div class="text-5xl font-black text-white leading-none tracking-tight">
                                    {{ $totalAnggota }}
                                </div>
                                <div class="text-sm font-bold italic tracking-wide mt-1 text-white/95">
                                    Anggota Koperasi
                                </div>
                            </div>
                            <div class="z-10 text-xs text-white/90 flex items-center space-x-1.5 mt-4">
                                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                <span>Jumlah anggota terdata sesuai cakupan akun</span>
                            </div>

                            <!-- Watermark House Icon -->
                            <i class="fa-solid fa-house-chimney absolute right-4 top-1/2 -translate-y-1/2 text-8xl text-white/15 pointer-events-none"></i>
                        </div>

                    </div>

                    <!-- Bottom Row: 2 Columns (3 Progress Cards on Left, Anggota UMKM Panel on Right) -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">

                        <!-- Left Column: 3 Progress Indicator Cards -->
                        <div class="space-y-6">

                            <!-- 1. Card OPERASIONAL -->
                            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm space-y-4">
                                <div class="text-center">
                                    <span class="inline-block px-4 py-1 rounded-full bg-slate-100/90 text-slate-700 text-xs font-extrabold uppercase tracking-widest border border-slate-200/60">
                                        OPERASIONAL
                                    </span>
                                </div>

                                <div class="space-y-3">
                                    <!-- Bar 1: Sudah Operasional (Green Bar) -->
                                    <div>
                                        <div class="w-full bg-slate-100 rounded-lg overflow-hidden h-7 p-0.5 border border-slate-200/60 relative">
                                            <div class="bg-[#10b981] h-full rounded-md flex items-center justify-center text-white text-xs font-black shadow-inner transition-all duration-500"
                                                 style="width: {{ $opsSudahPersen }}%;">
                                                {{ $opsSudahPersen }} %
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between text-xs mt-1.5 px-0.5">
                                            <span class="font-bold text-slate-800">
                                                <strong class="font-black">{{ $opsSudah }}</strong> Koperasi Sudah Operasional
                                            </span>
                                            <span class="font-black text-[#10b981]">{{ $opsSudahPersen }}%</span>
                                        </div>
                                    </div>

                                    <!-- Bar 2: Belum Operasional (Yellow Bar) -->
                                    <div>
                                        <div class="w-full bg-slate-100 rounded-lg overflow-hidden h-6 p-0.5 border border-slate-200/60 relative">
                                            <div class="bg-[#facc15] h-full rounded-md flex items-center justify-center text-slate-900 text-[10px] font-black shadow-inner transition-all duration-500 min-w-[45px]"
                                                 style="width: {{ max($opsBelumPersen, 3) }}%;">
                                                {{ $opsBelumPersen }}%
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between text-xs mt-1.5 px-0.5">
                                            <span class="font-semibold text-slate-700">
                                                <strong class="font-black text-slate-800">{{ $opsBelum }}</strong> Koperasi Belum Operasional
                                            </span>
                                            <span class="font-bold text-slate-400">{{ $opsBelumPersen }}%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Card PELATIHAN -->
                            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm space-y-4">
                                <div class="text-center">
                                    <span class="inline-block px-4 py-1 rounded-full bg-slate-100/90 text-slate-700 text-xs font-extrabold uppercase tracking-widest border border-slate-200/60">
                                        PELATIHAN
                                    </span>
                                </div>

                                <div class="space-y-3">
                                    <!-- Bar 1: Sudah Pelatihan (Blue Bar) -->
                                    <div>
                                        <div class="w-full bg-slate-100 rounded-lg overflow-hidden h-6 p-0.5 border border-slate-200/60 relative">
                                            <div class="bg-[#0284c7] h-full rounded-md flex items-center justify-center text-white text-[10px] font-black shadow-inner transition-all duration-500 min-w-[45px]"
                                                 style="width: {{ max($latihSudahPersen, 3) }}%;">
                                                {{ $latihSudahPersen }}%
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between text-xs mt-1.5 px-0.5">
                                            <span class="font-semibold text-slate-700">
                                                <strong class="font-black text-slate-800">{{ $latihSudah }}</strong> Sudah Pelatihan
                                            </span>
                                            <span class="font-bold text-slate-400">{{ $latihSudahPersen }}%</span>
                                        </div>
                                    </div>

                                    <!-- Bar 2: Sebagian Pelatihan (Light Slate) -->
                                    <div>
                                        <div class="w-full bg-slate-100 rounded-lg overflow-hidden h-6 p-0.5 border border-slate-200/60 relative">
                                            <div class="bg-slate-200 h-full rounded-md" style="width: 0%;"></div>
                                        </div>
                                        <div class="flex items-center justify-between text-xs mt-1.5 px-0.5">
                                            <span class="font-semibold text-slate-700">
                                                <strong class="font-black text-slate-800">{{ $latihSebagian }}</strong> Sebagian Pelatihan
                                            </span>
                                            <span class="font-bold text-slate-400">{{ number_format($latihSebagianPersen, 2) }}%</span>
                                        </div>
                                    </div>

                                    <!-- Bar 3: Belum Pelatihan (Red Bar) -->
                                    <div>
                                        <div class="w-full bg-slate-100 rounded-lg overflow-hidden h-7 p-0.5 border border-slate-200/60 relative">
                                            <div class="bg-[#e11d48] h-full rounded-md flex items-center justify-center text-white text-xs font-black shadow-inner transition-all duration-500"
                                                 style="width: {{ $latihBelumPersen }}%;">
                                                {{ $latihBelumPersen }} %
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between text-xs mt-1.5 px-0.5">
                                            <span class="font-bold text-slate-800">
                                                <strong class="font-black text-rose-600">{{ $latihBelum }}</strong> Belum Pelatihan
                                            </span>
                                            <span class="font-black text-rose-600">{{ $latihBelumPersen }}%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Card SERTIFIKAT -->
                            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm space-y-4">
                                <div class="text-center">
                                    <span class="inline-block px-4 py-1 rounded-full bg-slate-100/90 text-slate-700 text-xs font-extrabold uppercase tracking-widest border border-slate-200/60">
                                        SERTIFIKAT
                                    </span>
                                </div>

                                <div class="space-y-3">
                                    <!-- Bar 1: Sudah Sertifikat (Olive Gold Bar) -->
                                    <div>
                                        <div class="w-full bg-slate-100 rounded-lg overflow-hidden h-7 p-0.5 border border-slate-200/60 relative">
                                            <div class="bg-[#856c1f] h-full rounded-md flex items-center justify-center text-white text-xs font-black shadow-inner transition-all duration-500"
                                                 style="width: {{ $sertifikatSudahPersen }}%;">
                                                {{ $sertifikatSudahPersen }} %
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between text-xs mt-1.5 px-0.5">
                                            <span class="font-bold text-slate-800">
                                                <strong class="font-black">{{ $sertifikatSudah }}</strong> Koperasi Sudah Sertifikat
                                            </span>
                                            <span class="font-black text-[#856c1f]">{{ $sertifikatSudahPersen }}%</span>
                                        </div>
                                    </div>

                                    <!-- Bar 2: Belum Sertifikat (Yellow Bar) -->
                                    <div>
                                        <div class="w-full bg-slate-100 rounded-lg overflow-hidden h-6 p-0.5 border border-slate-200/60 relative">
                                            <div class="bg-[#facc15] h-full rounded-md flex items-center justify-center text-slate-900 text-[10px] font-black shadow-inner transition-all duration-500 min-w-[45px]"
                                                 style="width: {{ max($sertifikatBelumPersen, 3) }}%;">
                                                {{ $sertifikatBelumPersen }}%
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between text-xs mt-1.5 px-0.5">
                                            <span class="font-semibold text-slate-700">
                                                <strong class="font-black text-slate-800">{{ $sertifikatBelum }}</strong> Koperasi Belum Sertifikat
                                            </span>
                                            <span class="font-bold text-slate-400">{{ $sertifikatBelumPersen }}%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Right Column: Anggota UMKM Panel -->
                        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-6">

                            <!-- Top Legends -->
                            <div class="flex items-center justify-end space-x-6 text-xs font-bold">
                                <div class="flex items-center space-x-2">
                                    <span class="w-4 h-3 bg-[#0369a1] rounded-sm"></span>
                                    <span class="text-slate-800">Anggota UMKM</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="w-4 h-3 bg-[#b48c48] rounded-sm"></span>
                                    <span class="text-slate-800">Lainnya</span>
                                </div>
                            </div>

                            <!-- Aggregates with Percentage Bars -->
                            <div class="space-y-4 pt-2">
                                <!-- Row 1: Anggota UMKM -->
                                <div class="flex items-center justify-between text-xs font-bold text-slate-800">
                                    <span>Anggota UMKM</span>
                                    <div class="flex items-center space-x-4">
                                        <span class="text-sm font-extrabold">0</span>
                                        <div class="w-36 bg-[#0369a1] text-white text-center py-1.5 rounded-md text-xs font-bold shadow-sm">
                                            0%
                                        </div>
                                    </div>
                                </div>

                                <!-- Row 2: Lainnya -->
                                <div class="flex items-center justify-between text-xs font-bold text-slate-800">
                                    <span>Lainnya</span>
                                    <div class="flex items-center space-x-4">
                                        <span class="text-sm font-extrabold">0</span>
                                        <div class="w-36 bg-[#b48c48] text-white text-center py-1.5 rounded-md text-xs font-bold shadow-sm">
                                            0%
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Inner Panel: Detail Klasifikasi Anggota -->
                            <div class="rounded-xl border border-slate-200/80 divide-y divide-slate-100 bg-slate-50/40 p-1 text-xs">
                                @foreach($klasifikasiAnggota as $item)
                                    <div class="py-2.5 px-3 flex items-center justify-between">
                                        <span class="font-bold text-slate-700 {{ $item['accent'] }}">{{ $item['nama'] }}</span>
                                        <span class="font-extrabold text-slate-600">{{ $item['jumlah'] }} Orang</span>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Blue Information Callout Note Box -->
                            <div class="bg-sky-50 border border-sky-100 rounded-xl p-3.5 flex items-start space-x-2.5 text-xs text-sky-900 leading-relaxed shadow-sm">
                                <i class="fa-solid fa-circle-info text-sky-600 mt-0.5 text-sm shrink-0"></i>
                                <p class="text-[11px] leading-relaxed">
                                    Pengisian agregat klasifikasi anggota koperasi diperbarui secara periodik berdasarkan sinkronisasi SIMKOP dan pendataan lapangan Diskop UKM.
                                </p>
                            </div>

                        </div>

                    </div>

                @elseif($activeTab === 'koperasi')
                    <!-- ================= TAB: DATABASE KOPERASI ================= -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-4 border-b border-slate-100">
                            <div>
                                <h2 class="text-xl font-black text-slate-900 tracking-tight uppercase">
                                    DATABASE KOPERASI
                                </h2>
                                <p class="text-xs text-slate-500">
                                    Total {{ $koperasis->total() }} Koperasi terdata resmi dalam SIMKOP
                                </p>
                            </div>

                            <!-- Filter Search Form -->
                            <form action="{{ route('admin.dashboard') }}" method="GET" class="flex flex-wrap items-center gap-2">
                                <input type="hidden" name="tab" value="koperasi">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama koperasi / AHU..."
                                       class="px-3 py-1.5 text-xs border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 w-56">
                                <select name="status_ops" class="px-3 py-1.5 text-xs border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500">
                                    <option value="">Semua Status Ops</option>
                                    <option value="SUDAH" {{ request('status_ops') === 'SUDAH' ? 'selected' : '' }}>Sudah Operasional</option>
                                    <option value="BELUM" {{ request('status_ops') === 'BELUM' ? 'selected' : '' }}>Belum Operasional</option>
                                </select>
                                <button type="submit" class="px-3.5 py-1.5 bg-sky-600 hover:bg-sky-700 text-white rounded-lg text-xs font-bold shadow-sm cursor-pointer">
                                    Cari
                                </button>
                                @if(request('search') || request('status_ops'))
                                    <a href="{{ route('admin.dashboard', ['tab' => 'koperasi']) }}" class="px-2 py-1.5 text-xs text-slate-500 hover:text-slate-800">
                                        Reset
                                    </a>
                                @endif
                            </form>
                        </div>

                        <!-- Data Table -->
                        <div class="overflow-x-auto rounded-xl border border-slate-200">
                            <table class="w-full text-left text-xs">
                                <thead class="bg-slate-50 text-slate-700 font-bold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                                    <tr>
                                        <th class="py-2.5 px-3">No</th>
                                        <th class="py-2.5 px-3">Nama Koperasi</th>
                                        <th class="py-2.5 px-3">Kecamatan</th>
                                        <th class="py-2.5 px-3">Desa / Kelurahan</th>
                                        <th class="py-2.5 px-3">Status Operasional</th>
                                        <th class="py-2.5 px-3">Pelatihan</th>
                                        <th class="py-2.5 px-3">Sertifikat</th>
                                        <th class="py-2.5 px-3">No. AHU</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-700">
                                    @forelse($koperasis as $kop)
                                        <tr class="hover:bg-slate-50 transition">
                                            <td class="py-2.5 px-3 font-semibold text-slate-500">{{ $loop->iteration + ($koperasis->currentPage() - 1) * $koperasis->perPage() }}</td>
                                            <td class="py-2.5 px-3 font-bold text-slate-900">{{ $kop->name_koperasi }}</td>
                                            <td class="py-2.5 px-3">{{ $kop->kecamatan?->name_kopkec ?? '-' }}</td>
                                            <td class="py-2.5 px-3">{{ $kop->kelurahan?->name_kopkel ?? '-' }}</td>
                                            <td class="py-2.5 px-3">
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $kop->st_ops === 'SUDAH' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                                    {{ $kop->st_ops }}
                                                </span>
                                            </td>
                                            <td class="py-2.5 px-3">
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $kop->st_latih === 'SUDAH' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                                    {{ $kop->st_latih }}
                                                </span>
                                            </td>
                                            <td class="py-2.5 px-3">
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $kop->st_sertifikat === 'SUDAH' ? 'bg-amber-50 text-amber-800 border border-amber-200' : 'bg-slate-100 text-slate-600' }}">
                                                    {{ $kop->st_sertifikat }}
                                                </span>
                                            </td>
                                            <td class="py-2.5 px-3 font-mono text-[11px] text-slate-600">{{ $kop->no_ahu ?: '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-6 text-slate-400 italic">Data koperasi tidak ditemukan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="pt-2">
                            {{ $koperasis->links() }}
                        </div>
                    </div>

                @elseif($activeTab === 'pengurus')
                    <!-- ================= TAB: DATABASE PENGURUS ================= -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-4 border-b border-slate-100">
                            <div>
                                <h2 class="text-xl font-black text-slate-900 tracking-tight uppercase">
                                    DATABASE PENGURUS & PENGAWAS
                                </h2>
                                <p class="text-xs text-slate-500">
                                    Total {{ $penguruses->total() }} Pengurus & Pengawas terdaftar di SIMKOP
                                </p>
                            </div>

                            <!-- Search Pengurus -->
                            <form action="{{ route('admin.dashboard') }}" method="GET" class="flex items-center gap-2">
                                <input type="hidden" name="tab" value="pengurus">
                                <input type="text" name="search_pengurus" value="{{ request('search_pengurus') }}" placeholder="Cari nama pengurus / jabatan..."
                                       class="px-3 py-1.5 text-xs border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 w-56">
                                <button type="submit" class="px-3.5 py-1.5 bg-sky-600 hover:bg-sky-700 text-white rounded-lg text-xs font-bold shadow-sm cursor-pointer">
                                    Cari
                                </button>
                                @if(request('search_pengurus'))
                                    <a href="{{ route('admin.dashboard', ['tab' => 'pengurus']) }}" class="px-2 py-1.5 text-xs text-slate-500 hover:text-slate-800">
                                        Reset
                                    </a>
                                @endif
                            </form>
                        </div>

                        <!-- Data Table Pengurus -->
                        <div class="overflow-x-auto rounded-xl border border-slate-200">
                            <table class="w-full text-left text-xs">
                                <thead class="bg-slate-50 text-slate-700 font-bold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                                    <tr>
                                        <th class="py-2.5 px-3">No</th>
                                        <th class="py-2.5 px-3">Nama Lengkap</th>
                                        <th class="py-2.5 px-3">Jabatan</th>
                                        <th class="py-2.5 px-3">Kategori</th>
                                        <th class="py-2.5 px-3">Unit Koperasi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-700">
                                    @forelse($penguruses as $sdm)
                                        <tr class="hover:bg-slate-50 transition">
                                            <td class="py-2.5 px-3 font-semibold text-slate-500">{{ $loop->iteration + ($penguruses->currentPage() - 1) * $penguruses->perPage() }}</td>
                                            <td class="py-2.5 px-3 font-bold text-slate-900">{{ $sdm->name_kopsdm }}</td>
                                            <td class="py-2.5 px-3 font-semibold">{{ $sdm->jab_kopsdm }}</td>
                                            <td class="py-2.5 px-3">
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $sdm->type_kopsdm === 'PENGURUS' ? 'bg-sky-50 text-sky-700 border border-sky-200' : 'bg-emerald-50 text-emerald-700 border border-emerald-200' }}">
                                                    {{ $sdm->type_kopsdm }}
                                                </span>
                                            </td>
                                            <td class="py-2.5 px-3 text-slate-600 max-w-xs truncate" title="{{ $sdm->koperasi?->name_koperasi }}">
                                                {{ $sdm->koperasi?->name_koperasi ?? '-' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-6 text-slate-400 italic">Data pengurus tidak ditemukan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="pt-2">
                            {{ $penguruses->links() }}
                        </div>
                    </div>

                @elseif($activeTab === 'anggota')
                    <!-- ================= TAB: DATABASE ANGGOTA ================= -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-4 border-b border-slate-100">
                            <h2 class="text-xl font-black text-slate-900 tracking-tight uppercase">
                                DATABASE ANGGOTA KOPERASI
                            </h2>
                            <p class="text-xs text-slate-500">
                                Total {{ number_format($totalAnggota) }} anggota tercatat pada koperasi dalam cakupan akun
                            </p>
                        </div>

                        <p class="text-xs text-slate-500">
                            Database hanya menyediakan jumlah anggota per koperasi, belum data anggota perorangan.
                        </p>

                        <div class="overflow-x-auto rounded-xl border border-slate-200">
                            <table class="w-full text-left text-xs">
                                <thead class="bg-slate-50 text-slate-700 font-bold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                                    <tr>
                                        <th class="py-2.5 px-3">No</th>
                                        <th class="py-2.5 px-3">Nama Koperasi</th>
                                        <th class="py-2.5 px-3">Kecamatan</th>
                                        <th class="py-2.5 px-3">Desa / Kelurahan</th>
                                        <th class="py-2.5 px-3">Jumlah Anggota</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-700">
                                    @forelse($anggotaKoperasis as $kop)
                                        <tr class="hover:bg-slate-50 transition">
                                            <td class="py-2.5 px-3 font-semibold text-slate-500">{{ $loop->iteration + ($anggotaKoperasis->currentPage() - 1) * $anggotaKoperasis->perPage() }}</td>
                                            <td class="py-2.5 px-3 font-bold text-slate-900">{{ $kop->name_koperasi }}</td>
                                            <td class="py-2.5 px-3">{{ $kop->kecamatan?->name_kopkec ?? '-' }}</td>
                                            <td class="py-2.5 px-3">{{ $kop->kelurahan?->name_kopkel ?? '-' }}</td>
                                            <td class="py-2.5 px-3 font-semibold">{{ number_format($kop->jum_anggota) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-6 text-slate-400 italic">Data anggota tidak ditemukan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="pt-2">
                            {{ $anggotaKoperasis->links() }}
                        </div>
                    </div>

                @endif

            </section>

        </div>

    </main>

    <!-- Footer Diskominfo Kabupaten Bogor -->
    <footer class="bg-white border-t border-slate-200/80 text-slate-600 text-xs py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div>
                <strong class="text-slate-800 font-bold">Diskominfo &copy; 2026</strong> &bull; Pemerintah Daerah Kabupaten Bogor
            </div>
            <div class="flex items-center space-x-6 text-[11px] text-slate-500">
                <a href="#" class="hover:text-slate-900 transition">Kebijakan Privasi</a>
                <a href="#" class="hover:text-slate-900 transition">Pusat Bantuan</a>
                <a href="#" class="hover:text-slate-900 transition">Status Layanan</a>
            </div>
        </div>
    </footer>

</div>
@endsection
