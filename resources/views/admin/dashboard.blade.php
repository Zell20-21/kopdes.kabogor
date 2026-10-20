@extends('layouts.app')

@section('title', 'Database Koperasi | GovTech KOP Kabupaten Bogor')

@section('content')
<div class="min-h-screen bg-[#f8fafc] flex flex-col justify-between text-slate-800">

    <!-- Top Navigation Header GovTech KOP -->
    <header class="bg-gradient-to-r from-[#881337] via-[#991b1b] to-[#7f1d1d] text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Left: Lambang Kabupaten Bogor & Logo KOPDES Bulat (Sesuai Desain Referensi) -->
                <div class="flex items-center space-x-2.5 sm:space-x-3.5">
                    <!-- Lambang Kabupaten Bogor (Tegar Beriman) -->
                    <img src="{{ asset('images/logo-kabupaten-bogor.png') }}" alt="Lambang Kabupaten Bogor" class="h-11 sm:h-13 w-auto object-contain drop-shadow shrink-0">

                    <!-- Logo KOPDES Bulat (Di-gedein dan bulat sesuai gambar referensi) -->
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-white flex items-center justify-center p-1.5 shadow-md shrink-0 border border-white/50 overflow-hidden">
                        <img src="{{ asset('images/logo-kopdeskel-clean.png') }}" alt="Logo KOP DES KEL Merah Putih" class="w-full h-full object-contain">
                    </div>

                    <div class="flex flex-col justify-center">
                        <div class="flex items-center space-x-2">
                            <span class="text-xl sm:text-2xl font-bold tracking-tight text-white leading-tight">
                                Dashboard
                            </span>
                            <span class="hidden sm:inline text-sm font-black tracking-wide text-red-100 uppercase">
                                KOPERASI MERAH PUTIH
                            </span>
                            <span class="text-[9px] sm:text-[10px] font-extrabold px-2 py-0.5 rounded-full border border-white/30 text-white/95 bg-white/10 uppercase tracking-wider">
                                GOVERNMENT
                            </span>
                        </div>
                        <p class="text-[11px] sm:text-xs text-red-200 font-medium leading-none mt-0.5">
                            Pemerintah Kabupaten Bogor &bull; Dinas Koperasi & UKM
                        </p>
                    </div>
                </div>

                <!-- Right: Status Server & Log Out Button -->
                <div class="flex items-center space-x-3">
                    <div class="hidden sm:flex items-center space-x-2 px-3 py-1.5 rounded-full bg-black/20 border border-white/10 text-emerald-300 text-xs font-semibold shadow-inner">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Server Bogor Terhubung</span>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center space-x-2 bg-gradient-to-r from-red-600 to-rose-700 hover:from-red-500 hover:to-rose-600 border border-white/20 text-white px-4 py-1.5 rounded-full text-xs sm:text-sm font-bold shadow-sm transition-all duration-200 hover:shadow transform active:scale-95 cursor-pointer">
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
                            <span class="text-[10px] text-slate-500 block">Layanan Resmi Daerah</span>
                        </div>
                    </div>

                    <!-- Navigation Menu Items -->
                    <nav class="space-y-1.5 text-xs font-bold">
                        <!-- 1. INFORMASI -->
                        <a href="{{ route('admin.dashboard', ['tab' => 'informasi']) }}"
                           class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl transition shadow-sm {{ $activeTab === 'informasi' ? 'bg-[#0284c7] text-white shadow-sky-600/20' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200/70' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-circle-info text-sm"></i>
                                <span>Informasi</span>
                            </div>
                            @if($activeTab === 'informasi')
                                <i class="fa-solid fa-chevron-right text-xs"></i>
                            @endif
                        </a>

                        <!-- 2. DATABASE KOPERASI -->
                        <a href="{{ route('admin.dashboard', ['tab' => 'koperasi']) }}"
                           class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl transition shadow-sm {{ $activeTab === 'koperasi' ? 'bg-[#0284c7] text-white shadow-sky-600/20' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200/70' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-regular fa-building text-sm"></i>
                                <span>Database Koperasi</span>
                            </div>
                            @if($activeTab === 'koperasi')
                                <i class="fa-solid fa-chevron-right text-xs"></i>
                            @endif
                        </a>

                        <!-- 3. DATABASE PENGURUS -->
                        <a href="{{ route('admin.dashboard', ['tab' => 'pengurus']) }}"
                           class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl transition shadow-sm {{ $activeTab === 'pengurus' ? 'bg-[#0284c7] text-white shadow-sky-600/20' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200/70' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-user-tie text-sm"></i>
                                <span>Database Pengurus</span>
                            </div>
                            @if($activeTab === 'pengurus')
                                <i class="fa-solid fa-chevron-right text-xs"></i>
                            @endif
                        </a>

                        <!-- 4. DATABASE ANGGOTA -->
                        <a href="{{ route('admin.dashboard', ['tab' => 'anggota']) }}"
                           class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl transition shadow-sm {{ $activeTab === 'anggota' ? 'bg-[#0284c7] text-white shadow-sky-600/20' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200/70' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-users text-sm"></i>
                                <span>Database Anggota</span>
                            </div>
                            @if($activeTab === 'anggota')
                                <i class="fa-solid fa-chevron-right text-xs"></i>
                            @endif
                        </a>
                    </nav>

                    <!-- REKAPITULASI WILAYAH Widget -->
                    <div class="pt-3 border-t border-slate-100 space-y-2.5">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-1.5">
                                <span class="w-2 h-2 rounded-full bg-red-600"></span>
                                <span class="text-[10px] font-extrabold text-slate-600 uppercase tracking-wider">REKAPITULASI WILAYAH</span>
                            </div>
                            <span class="text-[9px] font-extrabold px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200">
                                BOGOR
                            </span>
                        </div>

                        <!-- Card 1: Jumlah Koperasi (Warm Peach) -->
                        <div class="bg-[#fffbeb] border border-amber-200/80 rounded-xl p-3 shadow-xs relative overflow-hidden">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-extrabold text-amber-800 uppercase tracking-wider">JUMLAH KOPERASI</span>
                                <div class="w-6 h-6 rounded-md bg-amber-100 flex items-center justify-center text-amber-700">
                                    <i class="fa-solid fa-building text-xs"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-black text-amber-950 mt-1 leading-none">
                                {{ $totalKoperasi }}
                            </div>
                            <div class="text-[10px] font-semibold text-amber-800/90 mt-2 flex items-center space-x-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                <span>Tersebar di 40 Kecamatan</span>
                            </div>
                        </div>

                        <!-- Card 2: Anggota Koperasi (Mint Green) -->
                        <div class="bg-[#ecfdf5] border border-emerald-200/80 rounded-xl p-3 shadow-xs relative overflow-hidden">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-extrabold text-emerald-800 uppercase tracking-wider">ANGGOTA KOPERASI</span>
                                <div class="w-6 h-6 rounded-md bg-emerald-100 flex items-center justify-center text-emerald-700">
                                    <i class="fa-solid fa-users text-xs"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-black text-emerald-950 mt-1 leading-none">
                                {{ number_format($totalAnggota) }}
                            </div>
                            <div class="text-[10px] font-semibold text-emerald-800/90 mt-2 flex items-center space-x-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                <span>Terkonsolidasi Lapangan</span>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Footer Info -->
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <div class="flex items-center space-x-1.5 text-emerald-600 font-bold text-[11px]">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Sistem Aktif</span>
                        </div>
                        <span class="text-[10px] font-mono px-2 py-0.5 rounded-md bg-slate-100 text-slate-500 border border-slate-200">v3.4.0</span>
                    </div>

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

                        @if(! $user->isOperatorDesa() && ! $user->isOperatorKecamatan())
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
                        @endif
                    </div>

                    <!-- Top Row: 2 Big Highlight Stat Cards -->
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

                            <i class="fa-solid fa-location-dot absolute right-4 top-1/2 -translate-y-1/2 text-8xl text-white/15 pointer-events-none"></i>
                        </div>

                        <!-- Card 2: Anggota Koperasi (Teal/Emerald Green) -->
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

                            <i class="fa-solid fa-house-chimney absolute right-4 top-1/2 -translate-y-1/2 text-8xl text-white/15 pointer-events-none"></i>
                        </div>

                    </div>

                    <!-- Bottom Row: 2 Columns -->
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
                                <div class="flex items-center justify-between text-xs font-bold text-slate-800">
                                    <span>Anggota UMKM</span>
                                    <div class="flex items-center space-x-4">
                                        <span class="text-sm font-extrabold">0</span>
                                        <div class="w-36 bg-[#0369a1] text-white text-center py-1.5 rounded-md text-xs font-bold shadow-sm">
                                            0%
                                        </div>
                                    </div>
                                </div>

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

                            <div class="bg-sky-50 border border-sky-100 rounded-xl p-3.5 flex items-start space-x-2.5 text-xs text-sky-900 leading-relaxed shadow-sm">
                                <i class="fa-solid fa-circle-info text-sky-600 mt-0.5 text-sm shrink-0"></i>
                                <p class="text-[11px] leading-relaxed">
                                    Pengisian agregat klasifikasi anggota koperasi diperbarui secara periodik berdasarkan sinkronisasi SIMKOP dan pendataan lapangan Diskop UKM.
                                </p>
                            </div>

                        </div>

                    </div>

                @elseif($activeTab === 'koperasi')
                    <!-- ================= TAB: DATABASE KOPERASI (PERSIS SESUAI FOTO) ================= -->

                    <!-- Section Header Bar -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <div class="flex items-center space-x-2 text-sky-600 font-extrabold text-[11px] uppercase tracking-wider">
                                <i class="fa-regular fa-folder-open text-xs"></i>
                                <span>DIREKTORI TERINTEGRASI</span>
                            </div>
                            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight uppercase mt-0.5 leading-tight">
                                DATABASE KOPERASI
                            </h1>
                            <p class="text-[11px] font-bold text-slate-400 tracking-wider uppercase">
                                KABUPATEN BOGOR &bull; PROVINSI JAWA BARAT
                            </p>
                        </div>

                        <!-- Right Action Buttons: Refresh & Tambah Data -->
                        <div class="flex items-center space-x-2.5 shrink-0">
                            <a href="{{ route('admin.dashboard', ['tab' => 'koperasi']) }}"
                               class="inline-flex items-center space-x-2 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 px-3.5 py-2 rounded-xl text-xs font-bold shadow-sm transition hover:shadow cursor-pointer">
                                <i class="fa-solid fa-rotate text-slate-500 text-xs"></i>
                                <span>Refresh</span>
                            </a>

                            <button type="button"
                                    onclick="openTambahModal()"
                                    class="inline-flex items-center space-x-2 bg-[#0284c7] hover:bg-[#0369a1] text-white px-4 py-2 rounded-xl text-xs font-extrabold shadow-sm hover:shadow transition transform active:scale-95 cursor-pointer">
                                <i class="fa-solid fa-plus text-xs"></i>
                                <span>Tambah Data</span>
                            </button>
                        </div>
                    </div>

                    <!-- CARD 1: PEMETAAN GIS KOPERASIDESA MERAH PUTIH -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                        <!-- Card Header -->
                        <div class="p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 border-b border-slate-100">
                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-sky-50 border border-sky-100 flex items-center justify-center text-sky-600 shrink-0 shadow-xs">
                                    <i class="fa-solid fa-map-location-dot text-base"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm sm:text-base font-extrabold text-slate-900 tracking-tight uppercase leading-snug">
                                        PEMETAAN GIS KOPERASIDESA MERAH PUTIH
                                    </h3>
                                    <p class="text-xs text-slate-500 mt-0.5">
                                        Sebaran 435 titik koperasi di seluruh desa/kelurahan Kabupaten Bogor
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full bg-slate-50 border border-slate-200 text-[11px] font-bold text-slate-700 shadow-xs">
                                    <i class="fa-solid fa-location-dot text-sky-600 text-xs"></i>
                                    <span>435 Titik Koordinat Aktif</span>
                                </span>
                            </div>
                        </div>

                        <!-- Map Area with Switcher Controls -->
                        <div class="relative w-full h-[400px] bg-slate-100">
                            <div id="gis-koperasi-map" class="w-full h-full z-10"></div>

                            <!-- Map Layer Switcher (Top Right on Map) -->
                            <div class="absolute top-3 right-3 z-[400] bg-white/95 backdrop-blur-xs p-1 rounded-xl shadow-md border border-slate-200/80 flex items-center space-x-1 text-xs font-bold">
                                <button type="button" id="btn-layer-osm" onclick="setMapLayer('osm')"
                                        class="px-3 py-1.5 rounded-lg transition bg-[#0284c7] text-white shadow-xs flex items-center space-x-1.5">
                                    <i class="fa-solid fa-map text-[11px]"></i>
                                    <span>OpenStreetMap</span>
                                </button>
                                <button type="button" id="btn-layer-satelit" onclick="setMapLayer('satelit')"
                                        class="px-3 py-1.5 rounded-lg transition text-slate-700 hover:bg-slate-100 flex items-center space-x-1.5">
                                    <i class="fa-solid fa-satellite text-[11px]"></i>
                                    <span>Satelit</span>
                                </button>
                            </div>
                        </div>

                        <!-- Filter Controls Bar Under Map -->
                        <form action="{{ route('admin.dashboard') }}" method="GET" class="p-4 bg-slate-50/60 border-t border-slate-100">
                            <input type="hidden" name="tab" value="koperasi">
                            <input type="hidden" name="per_page" value="{{ $perPage }}">
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                                <!-- Select Kecamatan -->
                                <div class="md:col-span-5 space-y-1">
                                    <label class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block">
                                        PILIH KECAMATAN
                                    </label>
                                    <div class="relative">
                                        <select name="id_kec" id="filter_id_kec" onchange="updateDesaDropdown(this.value)"
                                                class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2 text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500 shadow-xs cursor-pointer">
                                            <option value="">-- SEMUA KECAMATAN (40) --</option>
                                            @foreach($kecamatans as $kec)
                                                <option value="{{ $kec->id_kopkec }}" {{ (string) request('id_kec') === (string) $kec->id_kopkec ? 'selected' : '' }}>
                                                    {{ $kec->name_kopkec }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Select Desa / Kelurahan -->
                                <div class="md:col-span-5 space-y-1">
                                    <label class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block">
                                        PILIH DESA / KELURAHAN
                                    </label>
                                    <div class="relative">
                                        <select name="id_kel" id="filter_id_kel"
                                                class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2 text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500 shadow-xs cursor-pointer">
                                            <option value="">-- SEMUA DESA / KELURAHAN --</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Terapkan Button -->
                                <div class="md:col-span-2 flex items-center space-x-2">
                                    <button type="submit"
                                            class="w-full bg-[#0f172a] hover:bg-black text-white px-4 py-2.5 rounded-xl text-xs font-extrabold shadow-sm hover:shadow transition flex items-center justify-center space-x-2 cursor-pointer">
                                        <i class="fa-solid fa-filter text-xs"></i>
                                        <span>Terapkan</span>
                                    </button>

                                    @if(request('id_kec') || request('id_kel'))
                                        <a href="{{ route('admin.dashboard', ['tab' => 'koperasi', 'per_page' => $perPage]) }}"
                                           title="Reset Filter"
                                           class="px-3 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-bold transition">
                                            <i class="fa-solid fa-rotate-left"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- CARD 2: TABEL DATA KOPERASI -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 space-y-4">

                        <!-- Table Toolbar -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            
                            <!-- Left: Show entries & Action Export Buttons -->
                            <div class="flex flex-wrap items-center gap-2">
                                <!-- Show entries dropdown -->
                                <div class="flex items-center space-x-1.5 text-xs text-slate-500 font-medium mr-2">
                                    <span>Show</span>
                                    <select onchange="changePerPage(this.value)"
                                            class="bg-white border border-slate-200 rounded-lg px-2 py-1 text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500 shadow-xs cursor-pointer">
                                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                    <span>entries</span>
                                </div>

                                <!-- Excel Export Button -->
                                <a href="{{ route('admin.koperasi.export', request()->only(['id_kec', 'id_kel', 'search'])) }}"
                                   class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-extrabold transition shadow-2xs">
                                    <i class="fa-regular fa-file-excel text-emerald-600"></i>
                                    <span>Excel</span>
                                </a>

                                <!-- Print Button -->
                                <button type="button" onclick="window.print()"
                                        class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg bg-slate-50 hover:bg-slate-100 text-slate-700 border border-slate-200 text-xs font-extrabold transition shadow-2xs cursor-pointer">
                                    <i class="fa-solid fa-print text-slate-500"></i>
                                    <span>Cetak</span>
                                </button>

                                <!-- Generic Export Button -->
                                <a href="{{ route('admin.koperasi.export', request()->only(['id_kec', 'id_kel', 'search'])) }}"
                                   class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg bg-sky-50 hover:bg-sky-100 text-sky-700 border border-sky-200 text-xs font-extrabold transition shadow-2xs">
                                    <i class="fa-solid fa-file-arrow-down text-sky-600"></i>
                                    <span>Ekspor</span>
                                </a>
                            </div>

                            <!-- Right: Live Search Box -->
                            <form action="{{ route('admin.dashboard') }}" method="GET" class="relative w-full sm:w-72">
                                <input type="hidden" name="tab" value="koperasi">
                                <input type="hidden" name="per_page" value="{{ $perPage }}">
                                @if(request('id_kec'))
                                    <input type="hidden" name="id_kec" value="{{ request('id_kec') }}">
                                @endif
                                @if(request('id_kel'))
                                    <input type="hidden" name="id_kel" value="{{ request('id_kel') }}">
                                @endif

                                <div class="relative">
                                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                           placeholder="Search nama, NI-KOP, AHU..."
                                           class="w-full bg-slate-50/70 border border-slate-200 rounded-xl pl-9 pr-8 py-1.5 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white shadow-2xs">
                                    @if(request('search'))
                                        <a href="{{ route('admin.dashboard', ['tab' => 'koperasi', 'per_page' => $perPage, 'id_kec' => request('id_kec'), 'id_kel' => request('id_kel')]) }}"
                                           class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                            <i class="fa-solid fa-xmark text-xs"></i>
                                        </a>
                                    @endif
                                </div>
                            </form>

                        </div>

                        <!-- Table Container -->
                        <div class="overflow-x-auto rounded-xl border border-slate-200/90">
                            <table class="w-full text-left text-xs border-collapse">
                                <thead class="bg-slate-50/90 text-slate-600 font-extrabold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                                    <tr>
                                        <th class="py-3 px-3 w-12 text-center">#</th>
                                        <th class="py-3 px-3">NI-KOP</th>
                                        <th class="py-3 px-4">KOPERASI</th>
                                        <th class="py-3 px-3">NOMOR AHU</th>
                                        <th class="py-3 px-3">TANGGAL AHU</th>
                                        <th class="py-3 px-4">DESA/KELURAHAN</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-700">
                                    @forelse($koperasis as $kop)
                                        <tr class="hover:bg-sky-50/40 transition">
                                            <!-- Index -->
                                            <td class="py-3 px-3 text-center font-bold text-slate-400 text-[11px]">
                                                {{ $loop->iteration + ($koperasis->currentPage() - 1) * $koperasis->perPage() }}
                                            </td>

                                            <!-- NI-KOP Pill -->
                                            <td class="py-3 px-3 whitespace-nowrap">
                                                <span class="inline-block px-2.5 py-1 rounded-md text-[11px] font-mono font-bold bg-[#e0f2fe] text-[#0369a1] border border-sky-200">
                                                    {{ $kop->no_inkop ?: '-' }}
                                                </span>
                                            </td>

                                            <!-- Koperasi Full Name -->
                                            <td class="py-3 px-4">
                                                <div class="font-extrabold text-slate-900 leading-tight uppercase">
                                                    {{ $kop->name_koperasi }}
                                                </div>
                                            </td>

                                            <!-- Nomor AHU with Green Dot -->
                                            <td class="py-3 px-3 whitespace-nowrap">
                                                <div class="flex items-center space-x-1.5 font-mono text-[11px] text-slate-700">
                                                    <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                                                    <span>{{ $kop->no_ahu ?: '-' }}</span>
                                                </div>
                                            </td>

                                            <!-- Tanggal AHU -->
                                            <td class="py-3 px-3 whitespace-nowrap text-slate-600 text-[11px] font-medium">
                                                {{ $kop->tgl_ahu ? date('d/m/Y', strtotime($kop->tgl_ahu)) : '-' }}
                                            </td>

                                            <!-- Desa / Kelurahan -->
                                            <td class="py-3 px-4 whitespace-nowrap">
                                                <span class="text-xs font-bold text-slate-800 uppercase">
                                                    {{ $kop->kelurahan?->name_kopkel ?? '-' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-10 text-slate-400 italic">
                                                <div class="flex flex-col items-center justify-center space-y-2">
                                                    <i class="fa-solid fa-database text-2xl text-slate-300"></i>
                                                    <span>Tidak ada data koperasi yang sesuai dengan filter pencarian.</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Table Footer: Showing Entries & Custom Pagination matching the screenshot -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-2 text-xs">
                            <div class="text-slate-500 font-medium">
                                Showing <span class="font-bold text-slate-800">{{ $koperasis->firstItem() ?? 0 }}</span>
                                to <span class="font-bold text-slate-800">{{ $koperasis->lastItem() ?? 0 }}</span>
                                of <span class="font-bold text-slate-800">{{ $koperasis->total() }}</span> entries
                            </div>

                            @if($koperasis->hasPages())
                                <nav class="flex items-center space-x-1">
                                    {{-- Previous Page Link --}}
                                    @if ($koperasis->onFirstPage())
                                        <span class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-300 text-xs font-bold cursor-not-allowed">
                                            Previous
                                        </span>
                                    @else
                                        <a href="{{ $koperasis->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-100 text-xs font-bold transition">
                                            Previous
                                        </a>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($koperasis->getUrlRange(1, $koperasis->lastPage()) as $page => $url)
                                        @if ($page == $koperasis->currentPage())
                                            <span class="px-3 py-1.5 rounded-lg bg-[#0284c7] text-white text-xs font-black shadow-xs">
                                                {{ $page }}
                                            </span>
                                        @elseif ($page <= 5 || $page == $koperasis->lastPage() || abs($page - $koperasis->currentPage()) <= 1)
                                            <a href="{{ $url }}" class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-100 text-xs font-bold transition">
                                                {{ $page }}
                                            </a>
                                        @elseif ($page == 6 && $koperasis->lastPage() > 7)
                                            <span class="px-2 py-1.5 text-slate-400">...</span>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($koperasis->hasMorePages())
                                        <a href="{{ $koperasis->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-100 text-xs font-bold transition">
                                            Next
                                        </a>
                                    @else
                                        <span class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-300 text-xs font-bold cursor-not-allowed">
                                            Next
                                        </span>
                                    @endif
                                </nav>
                            @endif
                        </div>

                    </div>

                    <!-- MODAL: TAMBAH DATA KOPERASI -->
                    <div id="modalTambahData" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
                        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-2xl overflow-hidden transform transition-all animate-in fade-in zoom-in-95 duration-200">
                            <!-- Modal Header -->
                            <div class="px-6 py-4 bg-gradient-to-r from-sky-700 to-sky-800 text-white flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-plus-circle text-base text-sky-200"></i>
                                    <h3 class="text-base font-extrabold tracking-wide uppercase">Tambah Data Koperasi Baru</h3>
                                </div>
                                <button type="button" onclick="closeTambahModal()" class="text-white/80 hover:text-white cursor-pointer">
                                    <i class="fa-solid fa-xmark text-lg"></i>
                                </button>
                            </div>

                            <!-- Modal Body / Form -->
                            <form action="{{ route('admin.koperasi.store') }}" method="POST" class="p-6 space-y-4">
                                @csrf

                                <div class="space-y-1">
                                    <label class="text-xs font-bold text-slate-700">Nama Lengkap Koperasi <span class="text-red-500">*</span></label>
                                    <input type="text" name="name_koperasi" required placeholder="Contoh: KOPERASI DESA MERAH PUTIH BOJONG GEDE KECAMATAN BOJONGGEDE"
                                           class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">Kecamatan <span class="text-red-500">*</span></label>
                                        <select name="id_kec" id="modal_id_kec" required onchange="updateModalDesaDropdown(this.value)"
                                                class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                                            <option value="">Pilih Kecamatan...</option>
                                            @foreach($kecamatans as $kec)
                                                <option value="{{ $kec->id_kopkec }}">{{ $kec->name_kopkec }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">Desa / Kelurahan <span class="text-red-500">*</span></label>
                                        <select name="id_kel" id="modal_id_kel" required
                                                class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                                            <option value="">Pilih Desa / Kelurahan...</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">NI-KOP</label>
                                        <input type="text" name="no_inkop" placeholder="Contoh: 3201140020005"
                                               class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 font-mono">
                                    </div>

                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">Nomor AHU</label>
                                        <input type="text" name="no_ahu" placeholder="AHU-0011857.AH.01.29.TAHUN 2025"
                                               class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 font-mono">
                                    </div>

                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">Tanggal AHU</label>
                                        <input type="date" name="tgl_ahu" value="{{ date('Y-m-d') }}"
                                               class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">Status Operasional</label>
                                        <select name="st_ops" class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                                            <option value="SUDAH" selected>SUDAH</option>
                                            <option value="BELUM">BELUM</option>
                                        </select>
                                    </div>

                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">Pelatihan</label>
                                        <select name="st_latih" class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                                            <option value="BELUM" selected>BELUM</option>
                                            <option value="SUDAH">SUDAH</option>
                                        </select>
                                    </div>

                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">Sertifikat</label>
                                        <select name="st_sertifikat" class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                                            <option value="SUDAH" selected>SUDAH</option>
                                            <option value="BELUM">BELUM</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-2">
                                    <button type="button" onclick="closeTambahModal()"
                                            class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-100 transition cursor-pointer">
                                        Batal
                                    </button>
                                    <button type="submit"
                                            class="px-5 py-2 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-extrabold shadow-sm transition cursor-pointer">
                                        Simpan Data Koperasi
                                    </button>
                                </div>
                            </form>
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

<!-- Pass Kecamatans and Koperasis JSON to JavaScript -->
<script>
    const kecamatansData = @json($kecamatans);
    const gisKoperasisData = @json($gisKoperasis ?? []);
    const selectedKecId = "{{ request('id_kec', '') }}";
    const selectedKelId = "{{ request('id_kel', '') }}";

    function updateDesaDropdown(kecId, targetSelectId = 'filter_id_kel', selectedVal = selectedKelId) {
        const select = document.getElementById(targetSelectId);
        if (!select) return;

        select.innerHTML = '<option value="">-- SEMUA DESA / KELURAHAN --</option>';

        if (!kecId) return;

        const kec = kecamatansData.find(k => String(k.id_kopkec) === String(kecId));
        if (kec && kec.kelurahans) {
            kec.kelurahans.forEach(kel => {
                const opt = document.createElement('option');
                opt.value = kel.id_kopkel;
                opt.textContent = kel.name_kopkel;
                if (String(kel.id_kopkel) === String(selectedVal)) {
                    opt.selected = true;
                }
                select.appendChild(opt);
            });
        }
    }

    function updateModalDesaDropdown(kecId) {
        updateDesaDropdown(kecId, 'modal_id_kel', '');
    }

    function changePerPage(perPage) {
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', perPage);
        url.searchParams.set('tab', 'koperasi');
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }

    function openTambahModal() {
        document.getElementById('modalTambahData')?.classList.remove('hidden');
    }

    function closeTambahModal() {
        document.getElementById('modalTambahData')?.classList.add('hidden');
    }

    // Leaflet GIS Map Setup
    let mapInstance = null;
    let osmLayer = null;
    let satelliteLayer = null;

    function initGisMap() {
        const mapEl = document.getElementById('gis-koperasi-map');
        if (!mapEl || typeof L === 'undefined') return;

        // Default Center of Kabupaten Bogor
        const bogorCenter = [-6.5500, 106.8200];
        mapInstance = L.map('gis-koperasi-map', {
            center: bogorCenter,
            zoom: 10,
            zoomControl: true,
            scrollWheelZoom: false
        });

        // Tiles
        osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(mapInstance);

        satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            maxZoom: 18,
            attribution: 'Tiles &copy; Esri'
        });

        // Add Cluster Visual Highlights like in the screenshot (Babakan Madang, Bojong Gede, Ciawi & Megamendung, Caringin)
        const clusterCenters = [
            { name: 'Babakan Madang', count: 14, lat: -6.5516, lng: 106.8797, color: '#0284c7' },
            { name: 'Bojong Gede', count: 20, lat: -6.4958, lng: 106.7972, color: '#0369a1' },
            { name: 'Ciawi & Megamendung', count: '19, 45', lat: -6.6575, lng: 106.8800, color: '#0284c7', alert: true },
            { name: 'Caringin', count: 16, lat: -6.6975, lng: 106.8378, color: '#0d9488' },
        ];

        clusterCenters.forEach(c => {
            // Light transparent cluster circle radius
            L.circle([c.lat, c.lng], {
                radius: 4000,
                color: c.alert ? '#dc2626' : c.color,
                weight: 1.5,
                dashArray: '4, 4',
                fillColor: c.alert ? '#fee2e2' : '#e0f2fe',
                fillOpacity: 0.25
            }).addTo(mapInstance);

            // Cluster Label Badge Marker
            const badgeHtml = `
                <div class="flex items-center space-x-1 px-2.5 py-1 rounded-full text-white font-extrabold text-[10px] shadow-lg tracking-wider"
                     style="background: ${c.alert ? '#b91c1c' : '#0369a1'}; white-space: nowrap; transform: translate(-50%, -50%);">
                    <i class="fa-solid fa-layer-group text-[9px]"></i>
                    <span>${c.name} (${c.count})</span>
                </div>
            `;
            const icon = L.divIcon({
                html: badgeHtml,
                className: '',
                iconSize: [0, 0]
            });
            L.marker([c.lat, c.lng], { icon }).addTo(mapInstance);
        });

        // Add 435 Active Coordinate Markers
        const markersGroup = L.featureGroup();

        gisKoperasisData.forEach(kop => {
            const lat = parseFloat(kop.gps_lat);
            const lng = parseFloat(kop.gps_long);
            if (!isNaN(lat) && !isNaN(lng)) {
                const marker = L.circleMarker([lat, lng], {
                    radius: 5,
                    fillColor: '#0284c7',
                    color: '#ffffff',
                    weight: 1.5,
                    opacity: 1,
                    fillOpacity: 0.9
                });

                const popupHtml = `
                    <div class="p-2 space-y-1 text-slate-800 text-xs">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-sky-100 text-sky-800">${kop.cat_koperasi || 'KOPERASI'}</span>
                        <h4 class="font-bold text-slate-900 leading-tight mt-1">${kop.name_koperasi}</h4>
                        <div class="text-[11px] text-slate-500 font-mono">NI-KOP: <strong>${kop.no_inkop || '-'}</strong></div>
                        <div class="text-[11px] text-slate-500 font-mono">AHU: <strong>${kop.no_ahu || '-'}</strong></div>
                        <div class="text-[10px] text-emerald-700 font-semibold pt-1">
                            <i class="fa-solid fa-circle-check text-[9px]"></i> Status Ops: ${kop.st_ops}
                        </div>
                    </div>
                `;
                marker.bindPopup(popupHtml);
                markersGroup.addLayer(marker);
            }
        });

        markersGroup.addTo(mapInstance);
    }

    function setMapLayer(type) {
        if (!mapInstance) return;
        const btnOsm = document.getElementById('btn-layer-osm');
        const btnSat = document.getElementById('btn-layer-satelit');

        if (type === 'satelit') {
            mapInstance.removeLayer(osmLayer);
            mapInstance.addLayer(satelliteLayer);
            btnSat.className = "px-3 py-1.5 rounded-lg transition bg-[#0284c7] text-white shadow-xs flex items-center space-x-1.5";
            btnOsm.className = "px-3 py-1.5 rounded-lg transition text-slate-700 hover:bg-slate-100 flex items-center space-x-1.5";
        } else {
            mapInstance.removeLayer(satelliteLayer);
            mapInstance.addLayer(osmLayer);
            btnOsm.className = "px-3 py-1.5 rounded-lg transition bg-[#0284c7] text-white shadow-xs flex items-center space-x-1.5";
            btnSat.className = "px-3 py-1.5 rounded-lg transition text-slate-700 hover:bg-slate-100 flex items-center space-x-1.5";
        }
    }

    // Auto-init on page load
    document.addEventListener('DOMContentLoaded', function () {
        if (selectedKecId) {
            updateDesaDropdown(selectedKecId, 'filter_id_kel', selectedKelId);
        }

        // Initialize GIS map after DOM settles
        setTimeout(initGisMap, 200);
    });
</script>
@endsection
