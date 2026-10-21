@extends('layouts.app')

@push('styles')
<style>
    .kecamatan-tooltip {
        background: rgba(15, 23, 42, 0.90) !important;
        border: 1px solid rgba(255, 255, 255, 0.25) !important;
        color: #ffffff !important;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        font-weight: 700 !important;
        font-size: 11px !important;
        letter-spacing: 0.02em !important;
        padding: 4px 8px !important;
        border-radius: 6px !important;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25) !important;
    }
    .kecamatan-tooltip::before {
        border-top-color: rgba(15, 23, 42, 0.90) !important;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-[#f8fafc] flex flex-col justify-between text-slate-800 w-full max-w-full overflow-x-hidden">

    <!-- Top Navigation Header GovTech KOP -->
    <header class="w-full bg-gradient-to-r from-[#881337] via-[#991b1b] to-[#7f1d1d] text-white shadow-md sticky top-0 z-[100]">
        <div class="w-full px-4 sm:px-6 lg:px-8">
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
                        </div>
                        <p class="text-[11px] sm:text-xs text-red-200 font-medium leading-none mt-0.5">
                            Pemerintah Kabupaten Bogor &bull; Dinas Koperasi & UKM
                        </p>
                    </div>
                </div>

                <!-- Right: Log Out Button -->
                <div class="flex items-center space-x-3">

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
    <main class="flex-grow w-full max-w-full px-4 sm:px-6 lg:px-8 py-6 relative z-0 isolate min-w-0">

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

        <div class="flex flex-col lg:flex-row gap-6 w-full min-w-0">

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

                        <!-- 5. LAMPIRAN INFORMASI -->
                        <a href="{{ route('admin.dashboard', ['tab' => 'lampiran']) }}"
                           class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl transition shadow-sm {{ $activeTab === 'lampiran' ? 'bg-[#0284c7] text-white shadow-sky-600/20' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200/70' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-paperclip text-sm"></i>
                                <span>Lampiran Informasi</span>
                            </div>
                            @if($activeTab === 'lampiran')
                                <i class="fa-solid fa-chevron-right text-xs"></i>
                            @endif
                        </a>
                    </nav>

                    <!-- REKAPITULASI WILAYAH Widget -->
                    <div class="pt-3 border-t border-slate-100 space-y-2.5">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-1.5">
                                <span class="w-2 h-2 rounded-full {{ $activeTab === 'anggota' ? 'bg-emerald-600' : 'bg-red-600' }}"></span>
                                <span class="text-[10px] font-extrabold text-slate-600 uppercase tracking-wider">
                                    {{ $activeTab === 'anggota' ? 'REKAPITULASI KABUPATEN' : 'REKAPITULASI WILAYAH' }}
                                </span>
                            </div>
                            @if($activeTab === 'anggota')
                                <span class="text-[9px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    Live Data
                                </span>
                            @else
                                <span class="text-[9px] font-extrabold px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200">
                                    BOGOR
                                </span>
                            @endif
                        </div>

                        <!-- Card 1: Jumlah Koperasi -->
                        <div class="bg-white border border-slate-200/80 rounded-xl p-3 shadow-xs relative overflow-hidden">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-1.5">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    <span class="text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">JUMLAH KOPERASI</span>
                                </div>
                                <span class="text-[9px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    100% Terdaftar
                                </span>
                            </div>
                            <div class="text-2xl font-black text-slate-900 mt-1.5 leading-none">
                                {{ $totalKoperasi }}
                            </div>
                        </div>

                        <!-- Card 2: Anggota Koperasi -->
                        <div class="bg-white border border-slate-200/80 rounded-xl p-3 shadow-xs relative overflow-hidden">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-1.5">
                                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                    <span class="text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">ANGGOTA KOPERASI</span>
                                </div>
                                <span class="text-[9px] font-bold px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-100">
                                    Tahap Verifikasi
                                </span>
                            </div>
                            <div class="text-2xl font-black text-slate-900 mt-1.5 leading-none">
                                {{ number_format($totalAnggota) }}
                            </div>
                            <p class="text-[10px] text-slate-400 mt-2 leading-relaxed">
                                Sinkronisasi NIK anggota koperasi desa sedang dalam integrasi lapangan.
                            </p>
                        </div>
                    </div>

                    <!-- Sidebar Footer Info -->
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <div class="flex items-center space-x-1.5 text-emerald-600 font-bold text-[11px]">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Sistem Aktif</span>
                        </div>
                        <span class="text-[10px] font-mono px-2 py-0.5 rounded-md bg-slate-100 text-slate-500 border border-slate-200">v2.4.0</span>
                    </div>

                </div>
            </aside>

            <!-- Right Main Work Area -->
            <section class="flex-1 min-w-0 space-y-6">

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
                                    <option value="{{ route('admin.dashboard', ['tab' => 'informasi']) }}" {{ $activeTab === 'informasi' ? 'selected' : '' }}>INFORMASI KOPERASI</option>
                                    <option value="{{ route('admin.dashboard', ['tab' => 'koperasi']) }}" {{ $activeTab === 'koperasi' ? 'selected' : '' }}>DATABASE KOPERASI</option>
                                    <option value="{{ route('admin.dashboard', ['tab' => 'pengurus']) }}" {{ $activeTab === 'pengurus' ? 'selected' : '' }}>DATABASE PENGURUS</option>
                                    <option value="{{ route('admin.dashboard', ['tab' => 'anggota']) }}" {{ $activeTab === 'anggota' ? 'selected' : '' }}>DATABASE ANGGOTA</option>
                                    <option value="{{ route('admin.dashboard', ['tab' => 'lampiran']) }}" {{ $activeTab === 'lampiran' ? 'selected' : '' }}>LAMPIRAN INFORMASI</option>
                                </select>
                            </div>
                        @endif
                    </div>

                    <!-- Top Row: 2 Big Highlight Stat Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Card 1: KOPERASI (Merah Senada Navbar) -->
                        <div class="bg-gradient-to-r from-[#881337] via-[#991b1b] to-[#7f1d1d] rounded-2xl p-6 text-white shadow-sm relative overflow-hidden flex flex-col justify-between min-h-[160px] hover:shadow-md transition">
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
                                        @if($isOperator)
                                            Pemetaan koperasi sesuai wilayah akun operator
                                        @else
                                            Sebaran koperasi di seluruh desa/kelurahan Kabupaten Bogor
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full bg-slate-50 border border-slate-200 text-[11px] font-bold text-slate-700 shadow-xs">
                                    <i class="fa-solid fa-location-dot text-sky-600 text-xs"></i>
                                    <span>{{ $gisKoperasis->count() }} Koperasi Terdata</span>
                                </span>
                            </div>
                        </div>

                        <!-- Map Area with Switcher Controls (Matching Public Dashboard) -->
                        <div class="relative w-full h-[460px] bg-slate-100 overflow-hidden isolate z-0">
                            <div id="gis-koperasi-map" class="w-full h-full z-10"></div>

                            <!-- Map Layer Switches (Top Right on Map) -->
                            <div class="absolute top-3 right-3 z-20 flex items-center space-x-1 bg-white/95 backdrop-blur-xs p-1 rounded-xl shadow-md border border-slate-200/80 text-xs font-semibold">
                                <div class="relative flex items-center p-0.5 bg-slate-100/80 rounded-lg border border-slate-200/60" id="adminKoperasiLayerWrapper">
                                    <div id="adminKoperasiLayerGlider" class="absolute rounded-md bg-red-600 shadow-xs transition-all duration-300 ease-in-out pointer-events-none" style="left: 2px; top: 2px; width: 44px; height: 26px;"></div>
                                    <button type="button" onclick="setMapLayer('osm')" id="btn-layer-osm" class="relative z-10 px-3 py-1 rounded-md text-white font-semibold transition-colors duration-200 cursor-pointer">
                                        POS
                                    </button>
                                    <button type="button" onclick="setMapLayer('satelit')" id="btn-layer-satelit" class="relative z-10 px-3 py-1 rounded-md text-slate-600 hover:text-slate-900 font-semibold transition-colors duration-200 cursor-pointer">
                                        Satelit
                                    </button>
                                    <button type="button" onclick="setMapLayer('topo')" id="btn-layer-topo" class="relative z-10 px-3 py-1 rounded-md text-slate-600 hover:text-slate-900 font-semibold transition-colors duration-200 cursor-pointer">
                                        Topografi
                                    </button>
                                </div>
                                <div class="h-4 w-px bg-slate-200 mx-1"></div>
                                <button type="button" onclick="toggleAdminKecamatanBoundaries()" id="btnToggleAdminBoundaries" title="Tampilkan / Sembunyikan Garis Batas Antar Kecamatan" class="px-2.5 py-1 rounded-md bg-sky-50 text-sky-700 border border-sky-200 hover:bg-sky-100 transition flex items-center space-x-1 text-xs font-semibold cursor-pointer">
                                    <i class="fa-solid fa-draw-polygon text-[10px]"></i>
                                    <span class="hidden sm:inline">Batas Kecamatan</span>
                                </button>
                            </div>

                            <!-- Custom Floating Legend (Bottom Left on Map) -->
                            <div class="absolute bottom-3 left-3 z-20 pointer-events-none bg-white/95 backdrop-blur-sm p-2.5 rounded-lg border border-slate-200 shadow-md text-[11px] text-slate-700 space-y-1">
                                <div class="font-bold text-slate-800 flex items-center space-x-1.5">
                                    <span class="w-2.5 h-2.5 rounded-full bg-red-600"></span>
                                    <span>Wilayah: Kabupaten Bogor</span>
                                </div>
                                <div class="flex items-center space-x-1.5 text-[10px] text-sky-700 font-semibold pt-0.5 border-t border-slate-100">
                                    <span class="w-3 h-1 bg-sky-500 rounded-sm"></span>
                                    <span>Batas 40 Kecamatan</span>
                                </div>
                                <div class="text-[10px] text-slate-500" id="adminMapLegendDetail">
                                    Pusat Pemerintahan: Cibinong (-6.4828, 106.8486)
                                </div>
                            </div>
                        </div>

                        <!-- Filter Controls Bar Under Map (Auto-filter on Change, No Terapkan Button) -->
                        <form id="formFilterKoperasi" action="{{ route('admin.dashboard') }}" method="GET" class="p-4 bg-slate-50/60 border-t border-slate-100">
                            <input type="hidden" name="tab" value="koperasi">
                            <input type="hidden" name="per_page" value="{{ $perPage }}">
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-end">
                                <!-- Select Kecamatan -->
                                <div class="space-y-1">
                                    <label class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block">
                                        PILIH KECAMATAN
                                    </label>
                                    <div class="relative">
                                        <select name="id_kec" id="filter_id_kec" onchange="onAdminKecamatanChange(this.value)"
                                                class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500 shadow-xs cursor-pointer">
                                            @unless($isOperator)
                                                <option value="">-- SEMUA KECAMATAN (40) --</option>
                                            @endunless
                                            @foreach($kecamatans as $kec)
                                                <option value="{{ $kec->id_kopkec }}" {{ (string) ($isOperator ? $assignedKecamatanId : request('id_kec')) === (string) $kec->id_kopkec ? 'selected' : '' }}>
                                                    {{ $kec->name_kopkec }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Select Desa / Kelurahan -->
                                <div class="space-y-1">
                                    <div class="flex items-center justify-between">
                                        <label class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block">
                                            PILIH DESA / KELURAHAN
                                        </label>
                                        @if(request('id_kec') || request('id_kel'))
                                            <a href="{{ route('admin.dashboard', ['tab' => 'koperasi', 'per_page' => $perPage]) }}"
                                               title="Reset Filter"
                                               class="text-[10px] font-bold text-red-600 hover:text-red-700 hover:underline flex items-center space-x-1">
                                                <i class="fa-solid fa-rotate-left text-[9px]"></i>
                                                <span>Reset Filter</span>
                                            </a>
                                        @endif
                                    </div>
                                    <div class="relative">
                                        <select name="id_kel" id="filter_id_kel" onchange="onAdminDesaChange(this.value)"
                                                class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500 shadow-xs cursor-pointer">
                                            @unless($user->isOperatorDesa())
                                                <option value="">-- SEMUA DESA / KELURAHAN --</option>
                                            @endunless
                                            @if($user->isOperatorDesa())
                                                @foreach($kecamatans as $kec)
                                                    @foreach($kec->kelurahans as $kelurahan)
                                                        <option value="{{ $kelurahan->id_kopkel }}" selected>{{ $kelurahan->name_kopkel }}</option>
                                                    @endforeach
                                                @endforeach
                                            @elseif(request('id_kec') && ($selectedKec = $kecamatans->firstWhere('id_kopkec', request('id_kec'))))
                                                @foreach($selectedKec->kelurahans as $kel)
                                                    <option value="{{ $kel->id_kopkel }}" {{ (string) request('id_kel') === (string) $kel->id_kopkel ? 'selected' : '' }}>
                                                        {{ $kel->name_kopkel }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
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
                        <div class="overflow-x-auto w-full max-w-full rounded-xl border border-slate-200/90">
                            <table class="w-full text-left text-xs border-collapse">
                                <thead class="bg-slate-50/90 text-slate-600 font-extrabold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                                    <tr>
                                        <th class="py-3 px-3 w-16 text-center">#</th>
                                        <th class="py-3 px-3">NI-KOP</th>
                                        <th class="py-3 px-4">KOPERASI</th>
                                        <th class="py-3 px-3">NOMOR AHU</th>
                                        <th class="py-3 px-3">TANGGAL AHU</th>
                                        <th class="py-3 px-4">DESA/KELURAHAN</th>
                                        <th class="py-3 px-4">KECAMATAN</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-700">
                                    @forelse($koperasis as $kop)
                                        <tr class="hover:bg-sky-50/40 transition">
                                            <!-- Index & Toggle Accordion Button (Matching Foto Kedua) -->
                                            <td class="py-3 px-3 text-center whitespace-nowrap">
                                                <div class="inline-flex items-center space-x-2">
                                                    <button type="button"
                                                            onclick="toggleKoperasiDetail({{ $kop->id_koperasi }})"
                                                            id="btn-toggle-{{ $kop->id_koperasi }}"
                                                            title="Buka / Tutup Detail & Proses"
                                                            class="w-5 h-5 rounded-full bg-[#0284c7] hover:bg-[#0369a1] text-white inline-flex items-center justify-center text-[10px] shadow-sm transition active:scale-90 cursor-pointer">
                                                        <i class="fa-solid fa-plus text-[9px]" id="icon-toggle-{{ $kop->id_koperasi }}"></i>
                                                    </button>
                                                    <span class="font-bold text-slate-500 text-[11px]">
                                                        {{ $loop->iteration + ($koperasis->currentPage() - 1) * $koperasis->perPage() }}
                                                    </span>
                                                </div>
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

                                            <!-- Kecamatan -->
                                            <td class="py-3 px-4 whitespace-nowrap">
                                                <span class="text-xs font-bold text-slate-700 uppercase">
                                                    {{ $kop->kecamatan?->name_kopkec ?? '-' }}
                                                </span>
                                            </td>
                                        </tr>

                                        <!-- Collapsible Sub-Row: Detail & Actions (Matching Foto Kedua) -->
                                        <tr id="detail-row-{{ $kop->id_koperasi }}" class="hidden bg-slate-50/70 border-b border-slate-200">
                                            <td colspan="7" class="py-4 px-6 sm:px-12">
                                                <div class="max-w-xl bg-white rounded-xl border border-slate-200 shadow-sm p-4 text-xs font-sans">
                                                    <div class="space-y-2 divide-y divide-slate-100">
                                                        <div class="flex items-center justify-between pb-1.5">
                                                            <span class="font-black text-slate-700 tracking-wider uppercase text-[11px]">OPERASIONAL</span>
                                                            <span class="font-bold {{ strtoupper($kop->st_ops) === 'SUDAH' ? 'text-emerald-600' : 'text-rose-600' }}">
                                                                {{ $kop->st_ops ?: 'SUDAH' }}
                                                            </span>
                                                        </div>
                                                        <div class="flex items-center justify-between py-1.5">
                                                            <span class="font-black text-slate-700 tracking-wider uppercase text-[11px]">PELATIHAN</span>
                                                            <span class="font-bold {{ strtoupper($kop->st_latih) === 'SUDAH' ? 'text-emerald-600' : 'text-slate-600' }}">
                                                                {{ $kop->st_latih ?: 'BELUM' }}
                                                            </span>
                                                        </div>
                                                        <div class="flex items-center justify-between py-1.5">
                                                            <span class="font-black text-slate-700 tracking-wider uppercase text-[11px]">STATUS SERTIFIKAT</span>
                                                            <span class="font-bold {{ strtoupper($kop->st_sertifikat) === 'SUDAH' ? 'text-emerald-600' : 'text-amber-600' }}">
                                                                {{ $kop->st_sertifikat ?: 'SUDAH' }}
                                                            </span>
                                                        </div>
                                                        <div class="flex items-center justify-between py-1.5">
                                                            <span class="font-black text-slate-700 tracking-wider uppercase text-[11px]">PENGURUS</span>
                                                            <span class="font-bold text-slate-800">{{ $kop->jum_pengurus ?? 5 }}</span>
                                                        </div>
                                                        <div class="flex items-center justify-between py-1.5">
                                                            <span class="font-black text-slate-700 tracking-wider uppercase text-[11px]">PENGAWAS</span>
                                                            <span class="font-bold text-slate-800">{{ $kop->jum_pengawas ?? 3 }}</span>
                                                        </div>
                                                        <div class="flex items-center justify-between py-1.5">
                                                            <span class="font-black text-slate-700 tracking-wider uppercase text-[11px]">ANGGOTA</span>
                                                            <span class="font-bold text-slate-800">{{ $kop->jum_anggota ?? 0 }}</span>
                                                        </div>
                                                        <div class="flex flex-wrap items-center gap-2 pt-3">
                                                            <span class="font-black text-slate-700 tracking-wider uppercase text-[11px] mr-2">PROSES</span>
                                                            <button type="button"
                                                                    onclick='openEditKoperasiModal(@json($kop))'
                                                                    class="px-3.5 py-1.5 bg-[#0284c7] hover:bg-[#0369a1] text-white text-xs font-bold rounded-md shadow-sm transition active:scale-95 cursor-pointer">
                                                                Update
                                                            </button>
                                                            <button type="button"
                                                                    onclick='openUpdateUsahaModal(@json($kop))'
                                                                    class="px-3.5 py-1.5 bg-[#0ea5e9] hover:bg-[#0284c7] text-white text-xs font-bold rounded-md shadow-sm transition active:scale-95 cursor-pointer">
                                                                Update Usaha
                                                            </button>
                                                            <button type="button"
                                                                    onclick='openUploadFotoModal(@json($kop))'
                                                                    class="px-3.5 py-1.5 bg-[#f59e0b] hover:bg-[#d97706] text-white text-xs font-bold rounded-md shadow-sm transition active:scale-95 cursor-pointer">
                                                                Upload Foto
                                                            </button>
                                                            <button type="button"
                                                                    onclick="confirmDeleteKoperasi({{ $kop->id_koperasi }}, '{{ addslashes($kop->name_koperasi) }}')"
                                                                    class="px-3.5 py-1.5 bg-[#ef4444] hover:bg-[#dc2626] text-white text-xs font-bold rounded-md shadow-sm transition active:scale-95 cursor-pointer">
                                                                Delete
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-10 text-slate-400 italic">
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
                    <div id="modalTambahData" class="fixed inset-0 z-[1050] hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
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

                    <!-- MODAL: EDIT / UPDATE DATA KOPERASI -->
                    <div id="modalEditKoperasi" class="fixed inset-0 z-[1050] hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
                        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden transform transition-all animate-in fade-in zoom-in-95 duration-200">
                            <!-- Modal Header -->
                            <div class="px-6 py-4 bg-gradient-to-r from-sky-700 to-sky-800 text-white flex items-center justify-between shrink-0">
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-pen-to-square text-base text-sky-200"></i>
                                    <h3 class="text-base font-extrabold tracking-wide uppercase">Update Data Koperasi</h3>
                                </div>
                                <button type="button" onclick="closeEditModal()" class="text-white/80 hover:text-white cursor-pointer">
                                    <i class="fa-solid fa-xmark text-lg"></i>
                                </button>
                            </div>

                            <!-- Modal Body / Form -->
                            <form id="formEditKoperasi" method="POST" class="p-6 space-y-4 overflow-y-auto">
                                @csrf
                                @method('PUT')

                                <div class="space-y-1">
                                    <label class="text-xs font-bold text-slate-700">Nama Lengkap Koperasi <span class="text-red-500">*</span></label>
                                    <input type="text" name="name_koperasi" id="edit_name_koperasi" required
                                           class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">Kecamatan <span class="text-red-500">*</span></label>
                                        <select name="id_kec" id="edit_id_kec" required onchange="updateEditDesaDropdown(this.value)"
                                                class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                                            <option value="">Pilih Kecamatan...</option>
                                            @foreach($kecamatans as $kec)
                                                <option value="{{ $kec->id_kopkec }}">{{ $kec->name_kopkec }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">Desa / Kelurahan <span class="text-red-500">*</span></label>
                                        <select name="id_kel" id="edit_id_kel" required
                                                class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                                            <option value="">Pilih Desa / Kelurahan...</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">NI-KOP</label>
                                        <input type="text" name="no_inkop" id="edit_no_inkop" placeholder="Contoh: 3201140020005"
                                               class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 font-mono">
                                    </div>

                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">Nomor AHU</label>
                                        <input type="text" name="no_ahu" id="edit_no_ahu" placeholder="AHU-0011857.AH.01.29.TAHUN 2025"
                                               class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 font-mono">
                                    </div>

                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">Tanggal AHU</label>
                                        <input type="date" name="tgl_ahu" id="edit_tgl_ahu"
                                               class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">Status Operasional</label>
                                        <select name="st_ops" id="edit_st_ops" class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                                            <option value="SUDAH">SUDAH</option>
                                            <option value="BELUM">BELUM</option>
                                        </select>
                                    </div>

                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">Pelatihan</label>
                                        <select name="st_latih" id="edit_st_latih" class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                                            <option value="BELUM">BELUM</option>
                                            <option value="SUDAH">SUDAH</option>
                                        </select>
                                    </div>

                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">Sertifikat</label>
                                        <select name="st_sertifikat" id="edit_st_sertifikat" class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                                            <option value="SUDAH">SUDAH</option>
                                            <option value="BELUM">BELUM</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">Jumlah Anggota</label>
                                        <input type="number" name="jum_anggota" id="edit_jum_anggota" min="0"
                                               class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                                    </div>

                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">Jumlah Pengurus</label>
                                        <input type="number" name="jum_pengurus" id="edit_jum_pengurus" min="0"
                                               class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                                    </div>

                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">Jumlah Pengawas</label>
                                        <input type="number" name="jum_pengawas" id="edit_jum_pengawas" min="0"
                                               class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <label class="text-xs font-bold text-slate-700">Alamat Kantor Koperasi</label>
                                    <input type="text" name="kop_addr" id="edit_kop_addr" placeholder="Alamat lengkap..."
                                           class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">No. Telp / WA</label>
                                        <input type="text" name="kop_telp" id="edit_kop_telp" placeholder="08..."
                                               class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                                    </div>

                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">Email Koperasi</label>
                                        <input type="email" name="kop_mail" id="edit_kop_mail" placeholder="koperasi@..."
                                               class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                                    </div>

                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">Kategori Koperasi</label>
                                        <input type="text" name="cat_koperasi" id="edit_cat_koperasi" placeholder="KOPERASI DESA"
                                               class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">Latitude GPS</label>
                                        <input type="text" name="gps_lat" id="edit_gps_lat" placeholder="-6.xxxxx"
                                               class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 font-mono">
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">Longitude GPS</label>
                                        <input type="text" name="gps_long" id="edit_gps_long" placeholder="106.xxxxx"
                                               class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 font-mono">
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-2">
                                    <button type="button" onclick="closeEditModal()"
                                            class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-100 transition cursor-pointer">
                                        Batal
                                    </button>
                                    <button type="submit"
                                            class="px-5 py-2 rounded-xl bg-gradient-to-r from-sky-600 to-sky-700 hover:from-sky-500 hover:to-sky-600 text-white text-xs font-extrabold shadow-sm transition cursor-pointer">
                                        Simpan Perubahan Koperasi
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- MODAL: UPDATE USAHA KOPERASI -->
                    <div id="modalUpdateUsaha" class="fixed inset-0 z-[1050] hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
                        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-lg overflow-hidden transform transition-all animate-in fade-in zoom-in-95 duration-200">
                            <div class="px-6 py-4 bg-gradient-to-r from-cyan-600 to-sky-700 text-white flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-briefcase text-base text-cyan-200"></i>
                                    <h3 class="text-base font-extrabold tracking-wide uppercase">Update Usaha Koperasi</h3>
                                </div>
                                <button type="button" onclick="closeUpdateUsahaModal()" class="text-white/80 hover:text-white cursor-pointer">
                                    <i class="fa-solid fa-xmark text-lg"></i>
                                </button>
                            </div>
                            <form id="formUpdateUsaha" method="POST" class="p-6 space-y-4">
                                @csrf
                                <div>
                                    <p class="text-xs text-slate-500 font-medium">Koperasi:</p>
                                    <p class="text-sm font-extrabold text-slate-800 uppercase" id="usaha_koperasi_name">-</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-bold text-slate-700">Kategori / Bentuk Usaha <span class="text-red-500">*</span></label>
                                    <select name="cat_koperasi" id="usaha_cat_koperasi" required
                                            class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-500">
                                        <option value="KOPERASI DESA">KOPERASI DESA</option>
                                        <option value="KOPERASI KELURAHAN">KOPERASI KELURAHAN</option>
                                        <option value="KOPERASI KONSUMEN">KOPERASI KONSUMEN</option>
                                        <option value="KOPERASI PRODUSEN">KOPERASI PRODUSEN</option>
                                        <option value="KOPERASI SIMPAN PINJAM">KOPERASI SIMPAN PINJAM</option>
                                        <option value="KOPERASI JASA">KOPERASI JASA</option>
                                        <option value="KOPERASI PEMASARAN">KOPERASI PEMASARAN</option>
                                    </select>
                                </div>
                                <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-2">
                                    <button type="button" onclick="closeUpdateUsahaModal()"
                                            class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-100 transition cursor-pointer">
                                        Batal
                                    </button>
                                    <button type="submit"
                                            class="px-5 py-2 rounded-xl bg-cyan-600 hover:bg-cyan-700 text-white text-xs font-extrabold shadow-sm transition cursor-pointer">
                                        Simpan Usaha
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- MODAL: UPLOAD FOTO KOPERASI -->
                    <div id="modalUploadFoto" class="fixed inset-0 z-[1050] hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
                        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-lg overflow-hidden transform transition-all animate-in fade-in zoom-in-95 duration-200">
                            <div class="px-6 py-4 bg-gradient-to-r from-amber-500 to-orange-600 text-white flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-camera text-base text-amber-200"></i>
                                    <h3 class="text-base font-extrabold tracking-wide uppercase">Upload Foto Koperasi</h3>
                                </div>
                                <button type="button" onclick="closeUploadFotoModal()" class="text-white/80 hover:text-white cursor-pointer">
                                    <i class="fa-solid fa-xmark text-lg"></i>
                                </button>
                            </div>
                            <form id="formUploadFoto" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                                @csrf
                                <div>
                                    <p class="text-xs text-slate-500 font-medium">Koperasi:</p>
                                    <p class="text-sm font-extrabold text-slate-800 uppercase" id="foto_koperasi_name">-</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-bold text-slate-700">Pilih Berkas Foto Kantor / Gerai <span class="text-red-500">*</span></label>
                                    <input type="file" name="foto" required accept="image/*"
                                           class="w-full px-3 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500">
                                    <p class="text-[11px] text-slate-400">Format: JPG, PNG, WEBP (Maks. 5MB)</p>
                                </div>
                                <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-2">
                                    <button type="button" onclick="closeUploadFotoModal()"
                                            class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-100 transition cursor-pointer">
                                        Batal
                                    </button>
                                    <button type="submit"
                                            class="px-5 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-extrabold shadow-sm transition cursor-pointer">
                                        Unggah Foto
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- MODAL: KONFIRMASI HAPUS KOPERASI -->
                    <div id="modalDeleteKoperasi" class="fixed inset-0 z-[1050] hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
                        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-md overflow-hidden transform transition-all animate-in fade-in zoom-in-95 duration-200">
                            <div class="px-6 py-4 bg-gradient-to-r from-rose-600 to-red-700 text-white flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-triangle-exclamation text-base text-rose-200"></i>
                                    <h3 class="text-base font-extrabold tracking-wide uppercase">Konfirmasi Hapus</h3>
                                </div>
                                <button type="button" onclick="closeDeleteKoperasiModal()" class="text-white/80 hover:text-white cursor-pointer">
                                    <i class="fa-solid fa-xmark text-lg"></i>
                                </button>
                            </div>
                            <form id="formDeleteKoperasi" method="POST" class="p-6 space-y-4">
                                @csrf
                                @method('DELETE')
                                <div class="text-xs text-slate-600 space-y-2">
                                    <p>Apakah Anda yakin ingin menghapus data koperasi berikut dari database?</p>
                                    <p class="p-3 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl font-bold uppercase text-xs" id="delete_koperasi_name">-</p>
                                    <p class="text-[11px] text-slate-400">Data yang dihapus akan ditandai nonaktif (soft delete).</p>
                                </div>
                                <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-2">
                                    <button type="button" onclick="closeDeleteKoperasiModal()"
                                            class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-100 transition cursor-pointer">
                                        Batal
                                    </button>
                                    <button type="submit"
                                            class="px-5 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-extrabold shadow-sm transition cursor-pointer">
                                        Ya, Hapus Data
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                @elseif($activeTab === 'pengurus')
                    <!-- ================= TAB: DATABASE PENGURUS ================= -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-6">
                        <!-- Top Header Section -->
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                            <div>
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md text-xs font-bold bg-[#e0f2fe] text-[#0284c7]">
                                    <i class="fa-solid fa-address-card text-xs"></i>
                                    <span class="tracking-wide uppercase text-[11px]">MANAJEMEN SDM KOPERASI</span>
                                </div>
                                <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase mt-2">
                                    DATABASE PENGURUS
                                </h1>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mt-0.5">
                                    {{ $user->isSuperAdmin() ? 'KABUPATEN BOGOR' : ($user->kecamatan?->name_kopkec ?? 'KABUPATEN BOGOR') }}
                                </p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center flex-wrap gap-2.5">
                                <a href="{{ route('admin.pengurus.export', request()->all()) }}"
                                   class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold border border-slate-200 text-slate-700 bg-white hover:bg-slate-50 transition shadow-xs">
                                    <i class="fa-solid fa-file-excel text-emerald-600 text-sm"></i>
                                    <span>Export Excel</span>
                                </a>

                                <button type="button" onclick="window.print()"
                                        class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold border border-slate-200 text-slate-700 bg-white hover:bg-slate-50 transition shadow-xs cursor-pointer">
                                    <i class="fa-solid fa-print text-slate-600 text-sm"></i>
                                    <span>Cetak Berkas</span>
                                </button>

                                <button type="button" onclick="document.getElementById('modalTambahPengurus').classList.remove('hidden')"
                                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold bg-[#0284c7] hover:bg-[#0369a1] text-white transition shadow-sm cursor-pointer">
                                    <i class="fa-solid fa-user-plus text-sm"></i>
                                    <span>Tambah Pengurus</span>
                                </button>
                            </div>
                        </div>

                        <!-- 5 Stats Summary Cards -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
                            <!-- Card 1: Total Pengurus -->
                            <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-[0_1px_3px_rgba(0,0,0,0.04)] flex flex-col justify-between">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">TOTAL PENGURUS</span>
                                <div class="my-1.5">
                                    <div class="text-2xl font-black text-slate-900 tracking-tight">
                                        {{ number_format($statsPengurus['total'] ?? 2381) }}
                                    </div>
                                </div>
                                <div class="flex items-center gap-1.5 text-[11px] font-bold text-emerald-600">
                                    <i class="fa-solid fa-circle-check text-xs"></i>
                                    <span>Terverifikasi</span>
                                </div>
                            </div>

                            <!-- Card 2: Ketua Koperasi -->
                            <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-[0_1px_3px_rgba(0,0,0,0.04)] flex flex-col justify-between">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">KETUA KOPERASI</span>
                                <div class="my-1.5">
                                    <div class="text-2xl font-black text-[#0284c7] tracking-tight">
                                        {{ number_format($statsPengurus['ketua'] ?? 435) }}
                                    </div>
                                </div>
                                <span class="text-[11px] text-slate-400">1 per Koperasi</span>
                            </div>

                            <!-- Card 3: Sekretaris -->
                            <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-[0_1px_3px_rgba(0,0,0,0.04)] flex flex-col justify-between">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">SEKRETARIS</span>
                                <div class="my-1.5">
                                    <div class="text-2xl font-black text-[#4338ca] tracking-tight">
                                        {{ number_format($statsPengurus['sekretaris'] ?? 435) }}
                                    </div>
                                </div>
                                <span class="text-[11px] text-slate-400">1 per Koperasi</span>
                            </div>

                            <!-- Card 4: Bendahara -->
                            <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-[0_1px_3px_rgba(0,0,0,0.04)] flex flex-col justify-between">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">BENDAHARA</span>
                                <div class="my-1.5">
                                    <div class="text-2xl font-black text-[#d97706] tracking-tight">
                                        {{ number_format($statsPengurus['bendahara'] ?? 435) }}
                                    </div>
                                </div>
                                <span class="text-[11px] text-slate-400">1 per Koperasi</span>
                            </div>

                            <!-- Card 5: Pengawas & Lainnya -->
                            <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-[0_1px_3px_rgba(0,0,0,0.04)] flex flex-col justify-between">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">PENGAWAS & LAINNYA</span>
                                <div class="my-1.5">
                                    <div class="text-2xl font-black text-[#059669] tracking-tight">
                                        {{ number_format($statsPengurus['pengawas_lainnya'] ?? 1076) }}
                                    </div>
                                </div>
                                <span class="text-[11px] text-slate-400">Komite & Pengawas</span>
                            </div>
                        </div>

                        <!-- Filter and Search Row -->
                        <form id="formFilterPengurus" action="{{ route('admin.dashboard') }}" method="GET" class="flex flex-wrap items-center gap-2.5">
                            <input type="hidden" name="tab" value="pengurus">

                            <!-- Kecamatan Filter -->
                            <div class="relative min-w-[170px]">
                                <select name="filter_kec_pengurus" id="filter_kec_pengurus" onchange="onPengurusKecChange(this.value)"
                                        class="w-full appearance-none pr-8 pl-3.5 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 cursor-pointer shadow-xs">
                                    <option value="">-- SEMUA KECAMATAN --</option>
                                    @foreach($kecamatans as $kec)
                                        <option value="{{ $kec->id_kopkec }}" {{ (string) request('filter_kec_pengurus') === (string) $kec->id_kopkec ? 'selected' : '' }}>
                                            {{ strtoupper($kec->name_kopkec) }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 pointer-events-none"></i>
                            </div>

                            <!-- Desa / Kelurahan Filter -->
                            <div class="relative min-w-[170px]">
                                <select name="filter_kel_pengurus" id="filter_kel_pengurus" onchange="this.form.submit()"
                                        class="w-full appearance-none pr-8 pl-3.5 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 cursor-pointer shadow-xs">
                                    <option value="">-- DESA/KEL --</option>
                                    @if(request('filter_kec_pengurus') && ($selectedKecPengurus = $kecamatans->firstWhere('id_kopkec', request('filter_kec_pengurus'))))
                                        @foreach($selectedKecPengurus->kelurahans as $kel)
                                            <option value="{{ $kel->id_kopkel }}" {{ (string) request('filter_kel_pengurus') === (string) $kel->id_kopkel ? 'selected' : '' }}>
                                                {{ strtoupper($kel->name_kopkel) }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 pointer-events-none"></i>
                            </div>

                            <!-- Show entries dropdown -->
                            <div class="flex items-center gap-1.5 text-xs text-slate-500 font-medium">
                                <span>Show</span>
                                <div class="relative">
                                    <select name="per_page_pengurus" onchange="this.form.submit()"
                                            class="appearance-none pr-7 pl-2.5 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 cursor-pointer shadow-xs">
                                        <option value="10" {{ ($perPagePengurus ?? 25) == 10 ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ ($perPagePengurus ?? 25) == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ ($perPagePengurus ?? 25) == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ ($perPagePengurus ?? 25) == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                    <i class="fa-solid fa-chevron-down absolute right-2.5 top-1/2 -translate-y-1/2 text-[9px] text-slate-400 pointer-events-none"></i>
                                </div>
                            </div>

                            <!-- Search bar -->
                            <div class="relative flex-1 min-w-[220px]">
                                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                <input type="text" name="search_pengurus" value="{{ request('search_pengurus') }}"
                                       placeholder="Search nama / koperasi..."
                                       class="w-full pl-9 pr-8 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 bg-white placeholder-slate-400 shadow-xs">
                                @if(request('search_pengurus'))
                                    <a href="{{ route('admin.dashboard', array_merge(request()->except('search_pengurus'), ['tab' => 'pengurus'])) }}"
                                       class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                                        <i class="fa-solid fa-xmark"></i>
                                    </a>
                                @endif
                            </div>

                            @if(request('filter_kec_pengurus') || request('filter_kel_pengurus') || request('search_pengurus'))
                                <a href="{{ route('admin.dashboard', ['tab' => 'pengurus']) }}"
                                   class="px-3 py-2 text-xs font-semibold text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 rounded-xl transition">
                                    Reset
                                </a>
                            @endif
                        </form>

                        <!-- Data Table Pengurus -->
                        <div class="overflow-x-auto w-full max-w-full rounded-xl border border-slate-100">
                            <table class="w-full text-left text-xs">
                                <thead class="bg-slate-50/70 text-slate-500 font-bold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                                    <tr>
                                        <th class="py-3 px-3 text-center w-12">#</th>
                                        <th class="py-3 px-3">
                                            <div class="flex items-center gap-1 cursor-pointer select-none">
                                                <span>KOPERASI</span>
                                                <i class="fa-solid fa-sort text-[10px] text-slate-400"></i>
                                            </div>
                                        </th>
                                        <th class="py-3 px-3">
                                            <div class="flex items-center gap-1 cursor-pointer select-none">
                                                <span>NAMA PENGURUS</span>
                                                <i class="fa-solid fa-sort text-[10px] text-slate-400"></i>
                                            </div>
                                        </th>
                                        <th class="py-3 px-3">
                                            <div class="flex items-center gap-1 cursor-pointer select-none">
                                                <span>JABATAN</span>
                                                <i class="fa-solid fa-sort text-[10px] text-slate-400"></i>
                                            </div>
                                        </th>
                                        <th class="py-3 px-3">
                                            <div class="flex items-center gap-1 cursor-pointer select-none">
                                                <span>KATEGORI</span>
                                                <i class="fa-solid fa-sort text-[10px] text-slate-400"></i>
                                            </div>
                                        </th>
                                        <th class="py-3 px-3 text-center w-20">
                                            <div class="flex items-center justify-center gap-1 cursor-pointer select-none">
                                                <span>URUTAN</span>
                                                <i class="fa-solid fa-sort text-[10px] text-slate-400"></i>
                                            </div>
                                        </th>
                                        <th class="py-3 px-3">
                                            <div class="flex items-center gap-1 cursor-pointer select-none">
                                                <span>KETERANGAN</span>
                                                <i class="fa-solid fa-sort text-[10px] text-slate-400"></i>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-700">
                                    @forelse($penguruses as $sdm)
                                        @php
                                            $jab = strtoupper(trim($sdm->jab_kopsdm));
                                            $jabClass = 'bg-slate-50 text-slate-700 border-slate-200';
                                            if (str_contains($jab, 'BENDAHARA')) {
                                                $jabClass = 'bg-[#fefce8] text-[#b45309] border-[#fef08a]';
                                            } elseif (str_contains($jab, 'WAKIL KETUA')) {
                                                $jabClass = 'bg-[#f0f9ff] text-[#0284c7] border-[#bae6fd]';
                                            } elseif (str_contains($jab, 'PENGAWAS')) {
                                                $jabClass = 'bg-[#f0fdf4] text-[#15803d] border-[#bbf7d0]';
                                            } elseif ($jab === 'KETUA KOPERASI' || str_contains($jab, 'KETUA')) {
                                                $jabClass = 'bg-[#eef2ff] text-[#4f46e5] border-[#c7d2fe]';
                                            } elseif (str_contains($jab, 'SEKRETARIS')) {
                                                $jabClass = 'bg-[#faf5ff] text-[#9333ea] border-[#f3e8ff]';
                                            }

                                            $isPengurus = strtoupper($sdm->type_kopsdm) === 'PENGURUS';
                                        @endphp
                                        <tr class="hover:bg-slate-50/70 transition">
                                            <td class="py-3.5 px-3 text-center font-medium text-slate-400">
                                                {{ $loop->iteration + ($penguruses->currentPage() - 1) * $penguruses->perPage() }}
                                            </td>
                                            <td class="py-3.5 px-3">
                                                <div class="font-extrabold text-slate-900 uppercase text-[11px] leading-snug">
                                                    {{ $sdm->koperasi?->name_koperasi ?? '-' }}
                                                </div>
                                                <div class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide mt-0.5">
                                                    KECAMATAN {{ $sdm->koperasi?->kecamatan?->name_kopkec ?? '-' }}
                                                </div>
                                            </td>
                                            <td class="py-3.5 px-3">
                                                <span class="font-black text-slate-900 uppercase text-[11px] tracking-tight">
                                                    {{ $sdm->name_kopsdm }}
                                                </span>
                                            </td>
                                            <td class="py-3.5 px-3">
                                                <span class="inline-block px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider border {{ $jabClass }}">
                                                    {{ $sdm->jab_kopsdm }}
                                                </span>
                                            </td>
                                            <td class="py-3.5 px-3">
                                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider {{ $isPengurus ? 'bg-[#dbeafe] text-[#1d4ed8]' : 'bg-[#dcfce7] text-[#15803d]' }}">
                                                    {{ $sdm->type_kopsdm }}
                                                </span>
                                            </td>
                                            <td class="py-3.5 px-3 text-center font-bold text-slate-600 text-xs">
                                                {{ $sdm->order_kopsdm ?? '-' }}
                                            </td>
                                            <td class="py-3.5 px-3 text-slate-500 text-[11px] font-medium uppercase tracking-tight max-w-[160px] truncate" title="{{ $sdm->comt_kopsdm }}">
                                                {{ ($sdm->comt_kopsdm && $sdm->comt_kopsdm !== '-') ? $sdm->comt_kopsdm : '-' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-8 text-slate-400 italic text-xs">
                                                Data pengurus tidak ditemukan.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Footer matching screenshot -->
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-2 text-xs text-slate-500">
                            <div>
                                Menampilkan
                                <strong class="text-slate-800 font-bold">{{ $penguruses->firstItem() ?? 0 }}</strong>
                                sampai
                                <strong class="text-slate-800 font-bold">{{ $penguruses->lastItem() ?? 0 }}</strong>
                                dari
                                <strong class="text-slate-800 font-bold">{{ number_format($penguruses->total()) }}</strong>
                                data pengurus
                            </div>

                            @if($penguruses->hasPages())
                                <div>
                                    {{ $penguruses->links() }}
                                </div>
                            @endif
                        </div>
                    </div>

                @elseif($activeTab === 'anggota')
                    <!-- ================= TAB: DATABASE ANGGOTA ================= -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-6">
                        <!-- Top Header Section -->
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                            <div>
                                <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">
                                    DATABASE ANGGOTA
                                </h1>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mt-0.5">
                                    {{ $user->isSuperAdmin() ? 'KABUPATEN BOGOR' : ($user->kecamatan?->name_kopkec ?? 'KABUPATEN BOGOR') }}
                                </p>
                                <span class="sr-only">Total {{ number_format($totalAnggota) }} anggota tercatat pada koperasi dalam cakupan akun</span>
                            </div>

                            <!-- Right Badge -->
                            <div class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white border border-slate-200 text-slate-700 text-xs font-bold shadow-xs">
                                <i class="fa-solid fa-location-dot text-[#0284c7] text-xs"></i>
                                <span>Wilayah Kerja 40 Kecamatan</span>
                            </div>
                        </div>

                        <!-- Peta Persebaran Teritorial Keanggotaan -->
                        <div class="rounded-2xl border border-slate-200/80 bg-white overflow-hidden shadow-xs">
                            <div class="flex items-center justify-between px-5 py-3 border-b border-slate-100 bg-white text-xs">
                                <div class="flex items-center gap-2 font-bold text-slate-800 uppercase tracking-wider text-[11px]">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#0284c7]"></span>
                                    <span>PETA PERSEBARAN TERITORIAL KEANGGOTAAN</span>
                                </div>
                                <span class="text-slate-400 text-[11px] font-medium">Batas Wilayah Geospasial Kabupaten Bogor</span>
                            </div>
                            <div class="relative w-full h-[460px] bg-slate-100 overflow-hidden isolate z-0">
                                <div id="map-anggota" class="w-full h-full z-10"></div>

                                <!-- Map Layer Switches (Top Right on Map - Matching Database Koperasi) -->
                                <div class="absolute top-3 right-3 z-20 flex items-center space-x-1 bg-white/95 backdrop-blur-xs p-1 rounded-xl shadow-md border border-slate-200/80 text-xs font-semibold">
                                    <div class="relative flex items-center p-0.5 bg-slate-100/80 rounded-lg border border-slate-200/60" id="adminAnggotaLayerWrapper">
                                        <div id="adminAnggotaLayerGlider" class="absolute rounded-md bg-red-600 shadow-xs transition-all duration-300 ease-in-out pointer-events-none" style="left: 2px; top: 2px; width: 44px; height: 26px;"></div>
                                        <button type="button" onclick="setAnggotaMapLayer('osm')" id="btn-layer-anggota-osm" class="relative z-10 px-3 py-1 rounded-md text-white font-semibold transition-colors duration-200 cursor-pointer">
                                            POS
                                        </button>
                                        <button type="button" onclick="setAnggotaMapLayer('satelit')" id="btn-layer-anggota-satelit" class="relative z-10 px-3 py-1 rounded-md text-slate-600 hover:text-slate-900 font-semibold transition-colors duration-200 cursor-pointer">
                                            Satelit
                                        </button>
                                        <button type="button" onclick="setAnggotaMapLayer('topo')" id="btn-layer-anggota-topo" class="relative z-10 px-3 py-1 rounded-md text-slate-600 hover:text-slate-900 font-semibold transition-colors duration-200 cursor-pointer">
                                            Topografi
                                        </button>
                                    </div>
                                    <div class="h-4 w-px bg-slate-200 mx-1"></div>
                                    <button type="button" onclick="toggleAnggotaKecamatanBoundaries()" id="btnToggleAnggotaBoundaries" title="Tampilkan / Sembunyikan Garis Batas Antar Kecamatan" class="px-2.5 py-1 rounded-md bg-sky-50 text-sky-700 border border-sky-200 hover:bg-sky-100 transition flex items-center space-x-1 text-xs font-semibold cursor-pointer">
                                        <i class="fa-solid fa-draw-polygon text-[10px]"></i>
                                        <span class="hidden sm:inline">Batas Kecamatan</span>
                                    </button>
                                </div>

                                <!-- Custom Floating Legend (Bottom Left on Map) -->
                                <div class="absolute bottom-3 left-3 z-20 pointer-events-none bg-white/95 backdrop-blur-sm p-2.5 rounded-lg border border-slate-200 shadow-md text-[11px] text-slate-700 space-y-1">
                                    <div class="font-bold text-slate-800 flex items-center space-x-1.5">
                                        <span class="w-2.5 h-2.5 rounded-full bg-red-600"></span>
                                        <span>Wilayah: Kabupaten Bogor</span>
                                    </div>
                                    <div class="flex items-center space-x-1.5 text-[10px] text-sky-700 font-semibold pt-0.5 border-t border-slate-100">
                                        <span class="w-3 h-1 bg-sky-500 rounded-sm"></span>
                                        <span>Batas 40 Kecamatan</span>
                                    </div>
                                    <div class="text-[10px] text-slate-500" id="anggotaMapLegendDetail">
                                        Pusat Pemerintahan: Cibinong (-6.4828, 106.8486)
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filter and Search Row -->
                        <form id="formFilterAnggota" action="{{ route('admin.dashboard') }}" method="GET" class="space-y-4">
                            <input type="hidden" name="tab" value="anggota">

                            <!-- Row 1: Kecamatan & Desa Dropdowns (Auto-filter on Change, No Terapkan Button) -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-end">
                                <div class="space-y-1">
                                    <label class="block text-[11px] font-black text-slate-700 uppercase tracking-wider">KECAMATAN</label>
                                    <div class="relative">
                                        <select name="filter_kec_anggota" id="filter_kec_anggota" onchange="onAnggotaKecChange(this.value)"
                                                class="w-full appearance-none px-4 py-2.5 text-xs font-bold text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 cursor-pointer shadow-xs">
                                            <option value="">-- SEMUA KECAMATAN (40) --</option>
                                            @foreach($kecamatans as $kec)
                                                <option value="{{ $kec->id_kopkec }}" {{ (string) request('filter_kec_anggota') === (string) $kec->id_kopkec ? 'selected' : '' }}>
                                                    {{ strtoupper($kec->name_kopkec) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <div class="flex items-center justify-between">
                                        <label class="block text-[11px] font-black text-slate-700 uppercase tracking-wider">DESA / KELURAHAN</label>
                                        @if(request('filter_kec_anggota') || request('filter_kel_anggota'))
                                            <a href="{{ route('admin.dashboard', ['tab' => 'anggota']) }}"
                                               title="Reset Filter"
                                               class="text-[10px] font-bold text-red-600 hover:text-red-700 hover:underline flex items-center space-x-1">
                                                <i class="fa-solid fa-rotate-left text-[9px]"></i>
                                                <span>Reset Filter</span>
                                            </a>
                                        @endif
                                    </div>
                                    <div class="relative">
                                        <select name="filter_kel_anggota" id="filter_kel_anggota" onchange="onAnggotaDesaChange(this.value)"
                                                class="w-full appearance-none px-4 py-2.5 text-xs font-bold text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 cursor-pointer shadow-xs">
                                            <option value="">-- PILIH DESA/KEL --</option>
                                            @if(request('filter_kec_anggota') && ($selectedKecAnggota = $kecamatans->firstWhere('id_kopkec', request('filter_kec_anggota'))))
                                                @foreach($selectedKecAnggota->kelurahans as $kel)
                                                    <option value="{{ $kel->id_kopkel }}" {{ (string) request('filter_kel_anggota') === (string) $kel->id_kopkel ? 'selected' : '' }}>
                                                        {{ strtoupper($kel->name_kopkel) }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Row 2: Show, Search, and Action Buttons -->
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3 pt-1">
                                <!-- Left: Show Per Page & Search -->
                                <div class="flex flex-wrap items-center gap-3 flex-1">
                                    <div class="flex items-center gap-1.5 text-xs text-slate-500 font-medium">
                                        <span class="text-[11px] font-bold text-slate-400 uppercase">TAMPILKAN</span>
                                        <div class="relative">
                                            <select name="per_page_anggota" onchange="this.form.submit()"
                                                    class="appearance-none pr-7 pl-2.5 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 cursor-pointer shadow-xs">
                                                <option value="10" {{ ($perPageAnggota ?? 25) == 10 ? 'selected' : '' }}>10</option>
                                                <option value="25" {{ ($perPageAnggota ?? 25) == 25 ? 'selected' : '' }}>25</option>
                                                <option value="50" {{ ($perPageAnggota ?? 25) == 50 ? 'selected' : '' }}>50</option>
                                                <option value="100" {{ ($perPageAnggota ?? 25) == 100 ? 'selected' : '' }}>100</option>
                                            </select>
                                            <i class="fa-solid fa-chevron-down absolute right-2.5 top-1/2 -translate-y-1/2 text-[9px] text-slate-400 pointer-events-none"></i>
                                        </div>
                                        <span class="text-xs text-slate-500">baris</span>
                                    </div>

                                    <div class="relative flex-1 min-w-[240px]">
                                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                        <input type="text" name="search_anggota" value="{{ request('search_anggota') }}"
                                               placeholder="Cari nama, NIK, atau koperasi..."
                                               class="w-full pl-9 pr-8 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 bg-white placeholder-slate-400 shadow-xs">
                                        @if(request('search_anggota'))
                                            <a href="{{ route('admin.dashboard', array_merge(request()->except('search_anggota'), ['tab' => 'anggota'])) }}"
                                               class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                                                <i class="fa-solid fa-xmark"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                <!-- Right: Action Buttons matching screenshot -->
                                <div class="flex items-center flex-wrap gap-2">
                                    <button type="button" onclick="document.getElementById('modalTambahAnggota').classList.remove('hidden')"
                                            class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold bg-[#0284c7] hover:bg-[#0369a1] text-white transition shadow-xs cursor-pointer">
                                        <i class="fa-solid fa-plus text-xs"></i>
                                        <span>Tambah Anggota</span>
                                    </button>

                                    <button type="button" onclick="document.getElementById('modalImportSimkop').classList.remove('hidden')"
                                            class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold border border-slate-200 text-slate-700 bg-white hover:bg-slate-50 transition shadow-xs cursor-pointer">
                                        <i class="fa-solid fa-arrow-up-from-bracket text-slate-600 text-xs"></i>
                                        <span>Import SIMKOP</span>
                                    </button>

                                    <a href="{{ route('admin.anggota.export', request()->all()) }}"
                                       class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold border border-emerald-300 text-emerald-700 bg-emerald-50/50 hover:bg-emerald-100/60 transition shadow-xs">
                                        <i class="fa-solid fa-file-excel text-emerald-600 text-xs"></i>
                                        <span>Excel</span>
                                    </a>

                                    <button type="button" onclick="window.print()"
                                            class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold border border-slate-200 text-slate-700 bg-white hover:bg-slate-50 transition shadow-xs cursor-pointer">
                                        <i class="fa-solid fa-print text-slate-600 text-xs"></i>
                                        <span>Cetak</span>
                                    </button>

                                    @if(request('filter_kec_anggota') || request('filter_kel_anggota') || request('search_anggota'))
                                        <a href="{{ route('admin.dashboard', ['tab' => 'anggota']) }}"
                                           class="px-3 py-2 text-xs font-semibold text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 rounded-xl transition">
                                            Reset
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>

                        <!-- 3 Metric Summary Cards matching screenshot -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Card 1: TOTAL ANGGOTA TERDATA -->
                            <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-[0_1px_3px_rgba(0,0,0,0.04)] flex items-center justify-between">
                                <div>
                                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">TOTAL ANGGOTA TERDATA</div>
                                    <div class="text-2xl font-black text-slate-900 tracking-tight mt-1">
                                        {{ number_format($totalAnggota) }} Orang
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 text-[11px] font-bold rounded-lg bg-sky-50 text-[#0284c7] border border-sky-100">
                                    Konsolidasi
                                </span>
                            </div>

                            <!-- Card 2: ANGGOTA UMKM -->
                            <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-[0_1px_3px_rgba(0,0,0,0.04)] flex items-center justify-between">
                                <div>
                                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">ANGGOTA UMKM</div>
                                    <div class="text-2xl font-black text-slate-900 tracking-tight mt-1">
                                        0 Orang
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 text-[11px] font-bold rounded-lg bg-sky-50 text-[#0284c7] border border-sky-100">
                                    0%
                                </span>
                            </div>

                            <!-- Card 3: ANGGOTA NON-UMKM -->
                            <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-[0_1px_3px_rgba(0,0,0,0.04)] flex items-center justify-between">
                                <div>
                                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">ANGGOTA NON-UMKM</div>
                                    <div class="text-2xl font-black text-slate-900 tracking-tight mt-1">
                                        0 Orang
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 text-[11px] font-bold rounded-lg bg-amber-50 text-[#d97706] border border-amber-100">
                                    0%
                                </span>
                            </div>
                        </div>

                        <!-- Data Table Anggota -->
                        <div class="overflow-x-auto w-full max-w-full rounded-xl border border-slate-100">
                            <table class="w-full text-left text-xs">
                                <thead class="bg-slate-50/70 text-slate-500 font-bold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                                    <tr>
                                        <th class="py-3 px-3 text-center w-12">
                                            <div class="flex items-center justify-center gap-1 cursor-pointer select-none">
                                                <span>#</span>
                                                <i class="fa-solid fa-sort text-[10px] text-slate-400"></i>
                                            </div>
                                        </th>
                                        <th class="py-3 px-3">
                                            <div class="flex items-center gap-1 cursor-pointer select-none">
                                                <span>ANGGOTA</span>
                                                <i class="fa-solid fa-sort text-[10px] text-slate-400"></i>
                                            </div>
                                        </th>
                                        <th class="py-3 px-3">
                                            <div class="flex items-center gap-1 cursor-pointer select-none">
                                                <span>USAHA</span>
                                                <i class="fa-solid fa-sort text-[10px] text-slate-400"></i>
                                            </div>
                                        </th>
                                        <th class="py-3 px-3">
                                            <div class="flex items-center gap-1 cursor-pointer select-none">
                                                <span>TIPE</span>
                                                <i class="fa-solid fa-sort text-[10px] text-slate-400"></i>
                                            </div>
                                        </th>
                                        <th class="py-3 px-3">
                                            <div class="flex items-center gap-1 cursor-pointer select-none">
                                                <span>ALAMAT</span>
                                                <i class="fa-solid fa-sort text-[10px] text-slate-400"></i>
                                            </div>
                                        </th>
                                        <th class="py-3 px-3">
                                            <div class="flex items-center gap-1 cursor-pointer select-none">
                                                <span>TELPON</span>
                                                <i class="fa-solid fa-sort text-[10px] text-slate-400"></i>
                                            </div>
                                        </th>
                                        <th class="py-3 px-3">
                                            <div class="flex items-center gap-1 cursor-pointer select-none">
                                                <span>KOPERASI</span>
                                                <i class="fa-solid fa-sort text-[10px] text-slate-400"></i>
                                            </div>
                                        </th>
                                        <th class="py-3 px-3">
                                            <div class="flex items-center gap-1 cursor-pointer select-none">
                                                <span>KECAMATAN</span>
                                                <i class="fa-solid fa-sort text-[10px] text-slate-400"></i>
                                            </div>
                                        </th>
                                        <th class="py-3 px-3">
                                            <div class="flex items-center gap-1 cursor-pointer select-none">
                                                <span>DESA/KELURAHAN</span>
                                                <i class="fa-solid fa-sort text-[10px] text-slate-400"></i>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-700">
                                    @if($totalAnggota > 0 && $anggotaKoperasis->isNotEmpty())
                                        @foreach($anggotaKoperasis as $kop)
                                            <tr class="hover:bg-slate-50/70 transition">
                                                <td class="py-3 px-3 text-center font-medium text-slate-400">
                                                    {{ $loop->iteration + ($anggotaKoperasis->currentPage() - 1) * $anggotaKoperasis->perPage() }}
                                                </td>
                                                <td class="py-3 px-3">
                                                    <div class="font-bold text-slate-900 uppercase text-xs">
                                                        {{ $kop->name_koperasi }}
                                                    </div>
                                                    <div class="text-[10px] text-slate-400">
                                                        Kapasitas {{ number_format($kop->jum_anggota) }} Anggota
                                                    </div>
                                                </td>
                                                <td class="py-3 px-3 text-slate-600 font-medium">UMKM Desa</td>
                                                <td class="py-3 px-3">
                                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-sky-50 text-sky-700 border border-sky-200">
                                                        BIASA
                                                    </span>
                                                </td>
                                                <td class="py-3 px-3 text-slate-500 max-w-[150px] truncate" title="{{ $kop->kop_addr ?? 'Kabupaten Bogor' }}">
                                                    {{ $kop->kop_addr ?? 'Kabupaten Bogor' }}
                                                </td>
                                                <td class="py-3 px-3 text-slate-500 font-mono text-[11px]">
                                                    {{ $kop->kop_telp ?? '-' }}
                                                </td>
                                                <td class="py-3 px-3 font-semibold text-slate-800">
                                                    {{ $kop->name_koperasi }}
                                                </td>
                                                <td class="py-3 px-3 text-slate-600">
                                                    {{ $kop->kecamatan?->name_kopkec ?? '-' }}
                                                </td>
                                                <td class="py-3 px-3 text-slate-600">
                                                    {{ $kop->kelurahan?->name_kopkel ?? '-' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <!-- Empty State matching screenshot -->
                                        <tr>
                                            <td colspan="9" class="py-14 px-4 text-center">
                                                <div class="flex flex-col items-center justify-center max-w-md mx-auto space-y-3">
                                                    <div class="w-14 h-14 rounded-2xl bg-[#e0f2fe] text-[#0284c7] flex items-center justify-center text-2xl shadow-xs">
                                                        <i class="fa-solid fa-box-archive"></i>
                                                    </div>
                                                    <h3 class="text-base font-black text-slate-900 tracking-tight">
                                                        Tidak Ada Data Anggota Ditemukan
                                                    </h3>
                                                    <p class="text-xs text-slate-500 leading-relaxed text-center">
                                                        Sinkronisasi data keanggotaan terpusat sedang berlangsung dari masing-masing Koperasi Desa/Kelurahan. Silakan pilih filter kecamatan lain atau input anggota baru.
                                                    </p>
                                                    <span class="sr-only">Data anggota tidak ditemukan.</span>
                                                    <div class="flex items-center gap-2.5 pt-2">
                                                        <button type="button" onclick="syncAnggotaSimkop()"
                                                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold border border-slate-200 text-slate-700 bg-white hover:bg-slate-50 transition shadow-xs cursor-pointer">
                                                            <i class="fa-solid fa-arrows-rotate text-slate-500"></i>
                                                            <span>Sinkronisasi Ulang</span>
                                                        </button>
                                                        <button type="button" onclick="document.getElementById('modalTambahAnggota').classList.remove('hidden')"
                                                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold bg-[#0284c7] hover:bg-[#0369a1] text-white transition shadow-sm cursor-pointer">
                                                            <i class="fa-solid fa-plus text-xs"></i>
                                                            <span>Tambah Anggota Baru</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Footer matching screenshot -->
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-2 text-xs text-slate-500">
                            <div>
                                Menampilkan
                                <strong class="text-slate-800 font-bold">{{ $totalAnggota > 0 ? ($anggotaKoperasis->firstItem() ?? 0) : 0 }}</strong>
                                sampai
                                <strong class="text-slate-800 font-bold">{{ $totalAnggota > 0 ? ($anggotaKoperasis->lastItem() ?? 0) : 0 }}</strong>
                                dari
                                <strong class="text-slate-800 font-bold">{{ $totalAnggota > 0 ? number_format($anggotaKoperasis->total()) : 0 }}</strong>
                                entri data
                            </div>

                            <div class="flex items-center space-x-1">
                                <button type="button" disabled class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-400 bg-slate-50 text-xs font-medium cursor-not-allowed">
                                    Sebelumnya
                                </button>
                                <button type="button" class="px-3 py-1.5 rounded-lg border border-sky-500 bg-sky-50 text-sky-600 font-bold text-xs">
                                    1
                                </button>
                                <button type="button" disabled class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-400 bg-slate-50 text-xs font-medium cursor-not-allowed">
                                    Selanjutnya
                                </button>
                            </div>
                        </div>
                    </div>

                @elseif($activeTab === 'lampiran')
                    <!-- ================= TAB: LAMPIRAN INFORMASI ================= -->
                    <div class="space-y-6">

                        <!-- Section Header Bar -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div>
                                <div class="flex items-center space-x-2 text-sky-600 font-extrabold text-[11px] uppercase tracking-wider">
                                    <i class="fa-solid fa-paperclip text-xs"></i>
                                    <span>PORTAL INFORMASI TERINTEGRASI</span>
                                </div>
                                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight uppercase mt-0.5 leading-tight">
                                    LAMPIRAN INFORMASI
                                </h1>
                                <p class="text-[11px] font-bold text-slate-400 tracking-wider uppercase">
                                    Kelola Dokumen Laporan & Informasi Koperasi Merah Putih
                                </p>
                            </div>

                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center space-x-1.5 px-3.5 py-1.5 rounded-full bg-sky-50 border border-sky-200 text-xs font-bold text-sky-700 shadow-xs">
                                    <i class="fa-solid fa-file-circle-check text-sky-600"></i>
                                    <span>{{ $lampirans->total() }} Lampiran Terdaftar</span>
                                </span>
                            </div>
                        </div>

                        <!-- Card Tabel Lampiran Informasi -->
                        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-6">

                            <!-- Info banner connecting to Public UI -->
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-3.5 rounded-xl bg-blue-50/70 border border-blue-100/90 text-xs text-blue-900 gap-3">
                                <div class="flex items-center space-x-2.5">
                                    <i class="fa-solid fa-circle-info text-blue-600 text-base shrink-0"></i>
                                    <span>Dokumen lampiran di bawah ini <strong>terhubung langsung ke portal publik</strong> pada bagian <em>"Informasi Koperasi Merah Putih"</em> dalam bentuk dropdown dokumen.</span>
                                </div>
                                <a href="{{ route('dashboard') }}#informasi" target="_blank" class="shrink-0 text-blue-700 hover:text-blue-900 font-bold flex items-center space-x-1 underline decoration-blue-300">
                                    <span>Lihat di Halaman Publik</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                </a>
                            </div>

                            <!-- Tabel Data Lampiran -->
                            <div class="overflow-x-auto rounded-xl border border-slate-200">
                                <table class="w-full text-left text-xs">
                                    <thead class="bg-slate-50 text-slate-700 font-bold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                                        <tr>
                                            <th class="py-3 px-3.5 text-center w-12">No</th>
                                            <th class="py-3 px-4">Nama File / Judul Dokumen</th>
                                            <th class="py-3 px-4">File Dokumen & Tipe</th>
                                            <th class="py-3 px-3.5 text-center">Urutan</th>
                                            <th class="py-3 px-3.5 text-center">Status</th>
                                            <th class="py-3 px-4 text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-slate-700">
                                        @forelse($lampirans as $lampiran)
                                            @php
                                                $admExt = strtolower($lampiran->file_type ?? 'pdf');
                                                $admIcon = match($admExt) {
                                                    'xlsx', 'xls', 'csv' => ['icon' => 'fa-file-excel', 'color' => 'text-emerald-600', 'bg' => 'bg-emerald-50 border-emerald-200'],
                                                    'pdf' => ['icon' => 'fa-file-pdf', 'color' => 'text-red-600', 'bg' => 'bg-red-50 border-red-200'],
                                                    'doc', 'docx' => ['icon' => 'fa-file-word', 'color' => 'text-blue-600', 'bg' => 'bg-blue-50 border-blue-200'],
                                                    'png', 'jpg', 'jpeg', 'webp' => ['icon' => 'fa-file-image', 'color' => 'text-purple-600', 'bg' => 'bg-purple-50 border-purple-200'],
                                                    default => ['icon' => 'fa-file-lines', 'color' => 'text-slate-600', 'bg' => 'bg-slate-50 border-slate-200'],
                                                };
                                            @endphp
                                            <tr class="hover:bg-slate-50/80 transition">
                                                <td class="py-3 px-3.5 text-center font-semibold text-slate-500">
                                                    {{ $loop->iteration + ($lampirans->currentPage() - 1) * $lampirans->perPage() }}
                                                </td>
                                                <td class="py-3 px-4">
                                                    <div class="font-bold text-slate-900 text-sm">
                                                        {{ $lampiran->judul }}
                                                    </div>
                                                    <div class="text-[11px] text-slate-500 mt-0.5">
                                                        {{ $lampiran->keterangan ?? '-' }}
                                                    </div>
                                                </td>
                                                <td class="py-3 px-4">
                                                    <div class="flex items-center space-x-2">
                                                        <span class="w-7 h-7 rounded-lg {{ $admIcon['bg'] }} {{ $admIcon['color'] }} border flex items-center justify-center shrink-0 text-xs">
                                                            <i class="fa-solid {{ $admIcon['icon'] }}"></i>
                                                        </span>
                                                        <div class="min-w-0">
                                                            <a href="{{ route('informasi.file', $lampiran->file_path) }}" target="_blank" class="font-semibold text-sky-600 hover:text-sky-800 hover:underline block truncate max-w-xs" title="{{ $lampiran->file_name }}">
                                                                {{ $lampiran->file_name }}
                                                            </a>
                                                            <span class="text-[10px] text-slate-400 font-mono">
                                                                {{ $lampiran->file_size ?? '-' }} &bull; {{ strtoupper($lampiran->file_type) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-3 px-3.5 text-center font-bold text-slate-700">
                                                    {{ $lampiran->urutan }}
                                                </td>
                                                <td class="py-3 px-3.5 text-center">
                                                    <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                        <span>Aktif di Publik</span>
                                                    </span>
                                                </td>
                                                <td class="py-3 px-4 text-right">
                                                    <div class="flex items-center justify-end space-x-1.5">
                                                        <!-- Button Lihat / Preview -->
                                                        <a href="{{ route('informasi.file', $lampiran->file_path) }}" target="_blank"
                                                           class="p-1.5 rounded-lg border border-slate-200 hover:bg-slate-100 text-slate-600 transition"
                                                           title="Buka File Dokumen">
                                                            <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                                        </a>

                                                        <!-- Button Edit Lampiran -->
                                                        <button type="button"
                                                                onclick="openEditLampiranModal({{ json_encode($lampiran) }})"
                                                                class="inline-flex items-center space-x-1 px-2.5 py-1.5 rounded-lg border border-amber-200 bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs font-bold transition cursor-pointer"
                                                                title="Edit data lampiran">
                                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                                            <span>Edit</span>
                                                        </button>

                                                        <!-- Button Hapus Lampiran -->
                                                        <form action="{{ route('admin.lampiran.destroy', $lampiran->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lampiran ini? Dokumen tidak akan tampil lagi di portal publik.');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="inline-flex items-center space-x-1 px-2.5 py-1.5 rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold transition cursor-pointer"
                                                                    title="Hapus lampiran">
                                                                <i class="fa-solid fa-trash text-xs"></i>
                                                                <span>Hapus</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-8 text-slate-400 italic">
                                                    <div class="flex flex-col items-center justify-center space-y-2">
                                                        <i class="fa-regular fa-folder-open text-3xl text-slate-300"></i>
                                                        <span>Belum ada file lampiran informasi yang terdaftar.</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if($lampirans->hasPages())
                                <div class="pt-2">
                                    {{ $lampirans->links() }}
                                </div>
                            @endif

                            <!-- OPSI UPLOAD FILE DI TENGAH BAWAH CARD TABEL -->
                            <div class="pt-6 border-t border-slate-100 flex flex-col items-center justify-center text-center">
                                <input type="file" id="lampiranFileInput" class="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg" onchange="handleLampiranFileSelect(this)">

                                <div class="w-full max-w-xl p-6 rounded-2xl border-2 border-dashed border-slate-300 hover:border-sky-500 bg-slate-50/70 hover:bg-sky-50/40 transition group cursor-pointer text-center"
                                     onclick="document.getElementById('lampiranFileInput').click()">
                                    <div class="w-12 h-12 mx-auto rounded-full bg-sky-100 text-sky-600 flex items-center justify-center text-xl shadow-xs group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-cloud-arrow-up"></i>
                                    </div>
                                    <h4 class="mt-3 text-sm font-extrabold text-slate-800">
                                        Upload File Lampiran Baru
                                    </h4>
                                    <p class="mt-1 text-xs text-slate-500">
                                        Klik untuk memilih file dokumen (PDF, Gambar, Word, Excel &bull; Maks. 50 MB)
                                    </p>
                                    <div class="mt-3">
                                        <button type="button" class="inline-flex items-center space-x-2 px-5 py-2 rounded-xl bg-[#0284c7] hover:bg-[#0369a1] text-white text-xs font-extrabold shadow-sm group-hover:shadow transition pointer-events-none">
                                            <i class="fa-solid fa-plus text-xs"></i>
                                            <span>Pilih File Dokumen</span>
                                        </button>
                                    </div>
                                </div>
                                <p class="text-[11px] text-slate-400 mt-2">
                                    <i class="fa-solid fa-circle-check text-emerald-500 mr-1"></i>
                                    Popup preview verifikasi akan muncul otomatis sebelum file di-upload.
                                </p>
                            </div>

                        </div>

                        <!-- MODAL POPUP PREVIEW UPLOAD LAMPIRAN (Sesuai Permintaan Pengguna) -->
                        <div id="modalPreviewUpload" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-3 sm:p-4 overflow-y-auto">
                            <div class="bg-white rounded-2xl max-w-lg w-full border border-slate-200/90 shadow-2xl overflow-hidden transform transition-all animate-in fade-in zoom-in-95 duration-200 my-auto">
                                <!-- Modal Header -->
                                <div class="bg-[#0284c7] text-white px-5 py-3 flex items-center justify-between">
                                    <div class="flex items-center space-x-2.5">
                                        <div class="w-7 h-7 rounded-lg bg-white/20 flex items-center justify-center text-white">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-xs sm:text-sm font-extrabold tracking-tight leading-tight">
                                                Preview Dokumen Lampiran Baru
                                            </h3>
                                            <p class="text-[10px] text-sky-100">
                                                Verifikasi isi file sebelum diunggah ke portal publik
                                            </p>
                                        </div>
                                    </div>
                                    <button type="button" onclick="cancelUploadPreview()" class="w-7 h-7 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center transition cursor-pointer" title="Tutup">
                                        <i class="fa-solid fa-xmark text-xs"></i>
                                    </button>
                                </div>

                                <!-- Modal Body Form -->
                                <form id="formUploadLampiran" action="{{ route('admin.lampiran.store') }}" method="POST" enctype="multipart/form-data" class="p-4 sm:p-5 space-y-3">
                                    @csrf
                                    <!-- The actual file input moved here dynamically -->
                                    <input type="file" id="modalActualFileInput" name="file" class="hidden" required>

                                    <!-- Box Preview File -->
                                    <div class="bg-slate-50 rounded-xl border border-slate-200 p-3 space-y-2">
                                        <div class="flex items-center justify-between pb-1.5 border-b border-slate-200/80">
                                            <div class="flex items-center space-x-2 min-w-0 pr-2">
                                                <span id="previewFileIcon" class="w-7 h-7 rounded-lg bg-red-100 text-red-600 flex items-center justify-center text-xs font-bold shrink-0">
                                                    <i class="fa-solid fa-file-pdf"></i>
                                                </span>
                                                <div class="min-w-0">
                                                    <h4 id="previewFileName" class="text-xs font-bold text-slate-800 truncate max-w-xs">
                                                        dokumen.pdf
                                                    </h4>
                                                    <p id="previewFileSize" class="text-[10px] text-slate-500 font-mono">
                                                        0.00 MB
                                                    </p>
                                                </div>
                                            </div>
                                            <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-extrabold shrink-0">
                                                Siap Diunggah
                                            </span>
                                        </div>

                                        <!-- Interactive Preview Area (Compact Height) -->
                                        <div id="previewInteractiveContainer" class="w-full rounded-lg overflow-hidden border border-slate-200 bg-white" style="height: 120px;">
                                            <iframe id="previewIframe" class="w-full h-full border-0 hidden" title="Pratinjau Dokumen"></iframe>
                                            <img id="previewImage" class="w-full h-full object-contain hidden" alt="Pratinjau Gambar">
                                            <div id="previewFallback" class="w-full h-full flex flex-col items-center justify-center text-slate-400 p-3 space-y-1">
                                                <i class="fa-solid fa-file-lines text-2xl text-slate-300"></i>
                                                <span class="text-[11px] font-medium text-slate-500">Format dokumen siap diunggah.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Input Metadatas -->
                                    <div class="space-y-2.5">
                                        <div class="space-y-1">
                                            <label class="text-xs font-bold text-slate-700">
                                                Nama Dokumen / Judul File <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" name="judul" id="inputJudulLampiran" required placeholder="Contoh: DATA PROGRES PEMBANGUNAN KDKMP"
                                                   class="w-full px-3 py-1.5 text-xs border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 font-semibold text-slate-800">
                                            <p class="text-[10px] text-slate-400">Nama ini akan menjadi nama file utama di portal publik dan saat diunduh.</p>
                                        </div>

                                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-2.5">
                                            <div class="sm:col-span-8 space-y-1">
                                                <label class="text-xs font-bold text-slate-700">
                                                    Keterangan / Subtitle (Opsional)
                                                </label>
                                                <input type="text" name="keterangan" id="inputKeteranganLampiran" placeholder="Contoh: LAPJUSIK DIM 0621 • 24 MARET 2026"
                                                       class="w-full px-3 py-1.5 text-xs border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 text-slate-800">
                                            </div>
                                            <div class="sm:col-span-4 space-y-1">
                                                <label class="text-xs font-bold text-slate-700">
                                                    Urutan
                                                </label>
                                                <input type="number" name="urutan" value="1" min="1"
                                                       class="w-full px-3 py-1.5 text-xs border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 text-slate-800">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Actions (Tombol Upload & Batalkan Sesuai Permintaan) -->
                                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                                        <button type="button" onclick="cancelUploadPreview()"
                                                class="px-4 py-1.5 rounded-xl border border-slate-200 bg-white hover:bg-rose-50 text-slate-600 hover:text-rose-600 text-xs font-bold transition flex items-center space-x-1.5 cursor-pointer">
                                            <i class="fa-solid fa-xmark"></i>
                                            <span>Batalkan Lampiran</span>
                                        </button>

                                        <button type="submit"
                                                class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-extrabold shadow-md hover:shadow-lg transition transform active:scale-95 flex items-center space-x-1.5 cursor-pointer">
                                            <i class="fa-solid fa-cloud-arrow-up"></i>
                                            <span>Upload Sekarang</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- MODAL EDIT LAMPIRAN -->
                        <div id="modalEditLampiran" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-3 sm:p-4 overflow-y-auto">
                            <div class="bg-white rounded-2xl max-w-md w-full border border-slate-200/90 shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200 my-auto">
                                <!-- Modal Header -->
                                <div class="bg-slate-800 text-white px-5 py-3 flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <i class="fa-solid fa-pen-to-square text-amber-400 text-sm"></i>
                                        <h3 class="text-xs sm:text-sm font-extrabold tracking-tight">Edit Data Lampiran</h3>
                                    </div>
                                    <button type="button" onclick="closeEditLampiranModal()" class="w-7 h-7 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center transition cursor-pointer">
                                        <i class="fa-solid fa-xmark text-xs"></i>
                                    </button>
                                </div>

                                <form id="formEditLampiran" method="POST" enctype="multipart/form-data" class="p-4 sm:p-5 space-y-3">
                                    @csrf
                                    @method('PUT')

                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">Judul Dokumen <span class="text-red-500">*</span></label>
                                        <input type="text" name="judul" id="editJudul" required class="w-full px-3 py-1.5 text-xs border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 font-semibold">
                                    </div>

                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">Keterangan / Subtitle</label>
                                        <input type="text" name="keterangan" id="editKeterangan" class="w-full px-3 py-1.5 text-xs border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500">
                                    </div>

                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">Nomor Urutan</label>
                                        <input type="number" name="urutan" id="editUrutan" min="1" class="w-full px-3 py-1.5 text-xs border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500">
                                    </div>

                                    <div class="space-y-1 pt-2 border-t border-slate-100">
                                        <label class="text-xs font-bold text-slate-700">Ganti File Dokumen (Opsional)</label>
                                        <input type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg" class="w-full text-xs text-slate-500 file:mr-2.5 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer">
                                        <p class="text-[10px] text-slate-400">Biarkan kosong jika tidak ingin mengganti file yang sudah ada.</p>
                                    </div>

                                    <div class="pt-3 border-t border-slate-100 flex items-center justify-end space-x-2">
                                        <button type="button" onclick="closeEditLampiranModal()" class="px-3.5 py-1.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-100 transition cursor-pointer">
                                            Batal
                                        </button>
                                        <button type="submit" class="px-4 py-1.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-extrabold shadow-sm transition cursor-pointer">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>

                @endif

            </section>

        </div>

    </main>

    <!-- Modal Tambah Pengurus -->
    <div id="modalTambahPengurus" class="fixed inset-0 z-[1050] bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 max-w-lg w-full p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-lg bg-sky-100 text-sky-700 flex items-center justify-center">
                        <i class="fa-solid fa-user-plus text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900">Tambah Pengurus / Pengawas</h3>
                        <p class="text-xs text-slate-500">Input data SDM pengelola koperasi</p>
                    </div>
                </div>
                <button type="button" onclick="document.getElementById('modalTambahPengurus').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 cursor-pointer">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="{{ route('admin.pengurus.store') }}" method="POST" class="space-y-3.5 text-xs">
                @csrf
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Pilih Unit Koperasi <span class="text-rose-500">*</span></label>
                    <select name="id_koperasi" required class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 bg-white">
                        <option value="">-- Pilih Koperasi --</option>
                        @foreach($allKoperasis ?? [] as $kop)
                            <option value="{{ $kop->id_koperasi }}">{{ $kop->name_koperasi }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Lengkap Pengurus <span class="text-rose-500">*</span></label>
                    <input type="text" name="name_kopsdm" required placeholder="Contoh: DRA. VERA JULIATY" class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Jabatan <span class="text-rose-500">*</span></label>
                        <select name="jab_kopsdm" required class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 bg-white">
                            <option value="KETUA KOPERASI">KETUA KOPERASI</option>
                            <option value="WAKIL KETUA KOPERASI">WAKIL KETUA KOPERASI</option>
                            <option value="SEKRETARIS KOPERASI">SEKRETARIS KOPERASI</option>
                            <option value="BENDAHARA KOPERASI">BENDAHARA KOPERASI</option>
                            <option value="KETUA PENGAWAS">KETUA PENGAWAS</option>
                            <option value="ANGGOTA PENGAWAS">ANGGOTA PENGAWAS</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kategori <span class="text-rose-500">*</span></label>
                        <select name="type_kopsdm" required class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 bg-white">
                            <option value="PENGURUS">PENGURUS</option>
                            <option value="PENGAWAS">PENGAWAS</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Urutan Struktur</label>
                        <input type="text" name="order_kopsdm" value="1" placeholder="1, 2, 3..." class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Keterangan / Bidang</label>
                        <input type="text" name="comt_kopsdm" placeholder="Contoh: WAKIL BIDANG USAHA" class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-2 pt-3 border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('modalTambahPengurus').classList.add('hidden')" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 font-bold transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 bg-[#0284c7] hover:bg-[#0369a1] text-white rounded-xl font-bold transition shadow-sm cursor-pointer">
                        Simpan Pengurus
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Tambah Anggota -->
    <div id="modalTambahAnggota" class="fixed inset-0 z-[1050] bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 max-w-lg w-full p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-lg bg-sky-100 text-sky-700 flex items-center justify-center">
                        <i class="fa-solid fa-user-plus text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900">Tambah Anggota Koperasi Baru</h3>
                        <p class="text-xs text-slate-500">Input data anggota dan usaha binaan</p>
                    </div>
                </div>
                <button type="button" onclick="document.getElementById('modalTambahAnggota').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 cursor-pointer">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form onsubmit="alert('Data anggota berhasil disimpan dalam antrean konsolidasi SIMKOP daerah.'); document.getElementById('modalTambahAnggota').classList.add('hidden'); return false;" class="space-y-3.5 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Pilih Unit Koperasi <span class="text-rose-500">*</span></label>
                    <select required class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 bg-white">
                        <option value="">-- Pilih Koperasi --</option>
                        @foreach($allKoperasis ?? [] as $kop)
                            <option value="{{ $kop->id_koperasi }}">{{ $kop->name_koperasi }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Lengkap Anggota <span class="text-rose-500">*</span></label>
                        <input type="text" required placeholder="Nama sesuai KTP" class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">NIK (16 Digit) <span class="text-rose-500">*</span></label>
                        <input type="text" required maxlength="16" placeholder="3201xxxxxxxxxxxx" class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 font-mono">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nomor Telepon / WhatsApp</label>
                        <input type="text" placeholder="08xxxxxxxxxx" class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tipe Anggota</label>
                        <select class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 bg-white">
                            <option value="BIASA">ANGGOTA BIASA</option>
                            <option value="LUAR_BIASA">ANGGOTA LUAR BIASA</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kategori Usaha</label>
                        <select class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 bg-white">
                            <option value="UMKM">Pelaku UMKM / Usaha Mikro</option>
                            <option value="PETANI">Petani / Peternak</option>
                            <option value="PEDAGANG">Pedagang</option>
                            <option value="NON_UMKM">Non-UMKM / Perorangan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Usaha / Komoditas</label>
                        <input type="text" placeholder="Contoh: Keripik Singkong" class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Alamat Domisili Anggota</label>
                    <textarea rows="2" placeholder="Alamat lengkap tempat tinggal" class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500"></textarea>
                </div>

                <div class="flex items-center justify-end space-x-2 pt-3 border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('modalTambahAnggota').classList.add('hidden')" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 font-bold transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 bg-[#0284c7] hover:bg-[#0369a1] text-white rounded-xl font-bold transition shadow-sm cursor-pointer">
                        Simpan Anggota
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Import SIMKOP -->
    <div id="modalImportSimkop" class="fixed inset-0 z-[1050] bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 max-w-md w-full p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center">
                        <i class="fa-solid fa-arrow-up-from-bracket text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900">Integrasi Data SIMKOP</h3>
                        <p class="text-xs text-slate-500">Sinkronisasi data keanggotaan wilayah</p>
                    </div>
                </div>
                <button type="button" onclick="document.getElementById('modalImportSimkop').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 cursor-pointer">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div class="space-y-3 text-xs text-slate-600">
                <div class="p-3 bg-sky-50 rounded-xl border border-sky-100 text-sky-800 space-y-1">
                    <div class="font-bold flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-info text-sky-600"></i>
                        <span>Status Koneksi Gateway SIMKOP</span>
                    </div>
                    <p class="text-[11px] leading-relaxed">
                        Konektor API Diskominfo dan SIMKOP Kementerian Koperasi & UKM terhubung aktif dengan enkripsi TLS 1.3.
                    </p>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Unggah Berkas Format Excel (.xlsx / .csv)</label>
                    <input type="file" accept=".xlsx,.xls,.csv" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs bg-slate-50">
                    <span class="text-[10px] text-slate-400 mt-1 block">Maksimal 10 MB per berkas data keanggotaan.</span>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('modalImportSimkop').classList.add('hidden')" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 font-bold transition cursor-pointer text-xs">
                    Tutup
                </button>
                <button type="button" onclick="syncAnggotaSimkop(); document.getElementById('modalImportSimkop').classList.add('hidden');" class="px-5 py-2 bg-[#0284c7] hover:bg-[#0369a1] text-white rounded-xl font-bold transition shadow-sm cursor-pointer text-xs">
                    Mulai Sinkronisasi
                </button>
            </div>
        </div>
    </div>

    <!-- Footer Diskominfo Kabupaten Bogor -->
    <footer class="w-full bg-white border-t border-slate-200/80 text-slate-600 text-xs py-4">
        <div class="w-full px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-3">
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

<!-- Load Bogor Regency Subdistricts GeoJSON -->
<script src="{{ asset('js/bogor-kecamatan.js') }}"></script>

<!-- Pass Kecamatans and Koperasis JSON to JavaScript -->
<script>
    const kecamatansData = @json($kecamatansData);
    const gisKoperasisData = @json($gisKoperasis ?? []);
    const selectedKecId = @json($isOperator ? $assignedKecamatanId : request('id_kec', ''));
    const selectedKelId = @json($user->isOperatorDesa() ? $user->id_branch : request('id_kel', ''));
    const isOperatorDesa = @json($user->isOperatorDesa());

    function updateDesaDropdown(kecId, targetSelectId = 'filter_id_kel', selectedVal = selectedKelId) {
        const select = document.getElementById(targetSelectId);
        if (!select) return;

        select.innerHTML = isOperatorDesa
            ? ''
            : '<option value="">-- SEMUA DESA / KELURAHAN --</option>';

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

    // Toggle Collapsible Detail Row (Matching Foto Kedua)
    function toggleKoperasiDetail(id) {
        const row = document.getElementById(`detail-row-${id}`);
        const btn = document.getElementById(`btn-toggle-${id}`);
        const icon = document.getElementById(`icon-toggle-${id}`);
        if (!row) return;

        if (row.classList.contains('hidden')) {
            row.classList.remove('hidden');
            if (btn) {
                btn.classList.remove('bg-[#0284c7]', 'hover:bg-[#0369a1]');
                btn.classList.add('bg-[#ef4444]', 'hover:bg-[#dc2626]');
            }
            if (icon) {
                icon.classList.remove('fa-plus');
                icon.classList.add('fa-minus');
            }
        } else {
            row.classList.add('hidden');
            if (btn) {
                btn.classList.remove('bg-[#ef4444]', 'hover:bg-[#dc2626]');
                btn.classList.add('bg-[#0284c7]', 'hover:bg-[#0369a1]');
            }
            if (icon) {
                icon.classList.remove('fa-minus');
                icon.classList.add('fa-plus');
            }
        }
    }

    // Modal Edit / Update Koperasi Functions
    function openEditKoperasiModal(kop) {
        const form = document.getElementById('formEditKoperasi');
        if (!form || !kop) return;

        form.action = `/admin/koperasi/${kop.id_koperasi}`;

        document.getElementById('edit_name_koperasi').value = kop.name_koperasi || '';
        document.getElementById('edit_no_inkop').value = kop.no_inkop || '';
        document.getElementById('edit_no_ahu').value = kop.no_ahu || '';
        document.getElementById('edit_tgl_ahu').value = kop.tgl_ahu ? kop.tgl_ahu.substring(0, 10) : '';
        document.getElementById('edit_id_kec').value = kop.id_kec || '';

        updateDesaDropdown(kop.id_kec, 'edit_id_kel', kop.id_kel);

        document.getElementById('edit_st_ops').value = kop.st_ops || 'SUDAH';
        document.getElementById('edit_st_latih').value = kop.st_latih || 'BELUM';
        document.getElementById('edit_st_sertifikat').value = kop.st_sertifikat || 'SUDAH';
        document.getElementById('edit_jum_anggota').value = kop.jum_anggota || 0;
        document.getElementById('edit_jum_pengurus').value = kop.jum_pengurus || 5;
        document.getElementById('edit_jum_pengawas').value = kop.jum_pengawas || 3;
        document.getElementById('edit_kop_addr').value = kop.kop_addr || '';
        document.getElementById('edit_kop_telp').value = kop.kop_telp || '';
        document.getElementById('edit_kop_mail').value = kop.kop_mail || '';
        document.getElementById('edit_cat_koperasi').value = kop.cat_koperasi || 'KOPERASI DESA';
        document.getElementById('edit_gps_lat').value = kop.gps_lat || '';
        document.getElementById('edit_gps_long').value = kop.gps_long || '';

        document.getElementById('modalEditKoperasi')?.classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('modalEditKoperasi')?.classList.add('hidden');
    }

    function updateEditDesaDropdown(kecId) {
        updateDesaDropdown(kecId, 'edit_id_kel', '');
    }

    // Modal Update Usaha Functions
    function openUpdateUsahaModal(kop) {
        const form = document.getElementById('formUpdateUsaha');
        if (!form || !kop) return;

        form.action = `/admin/koperasi/${kop.id_koperasi}/usaha`;
        document.getElementById('usaha_koperasi_name').textContent = kop.name_koperasi;
        document.getElementById('usaha_cat_koperasi').value = kop.cat_koperasi || 'KOPERASI DESA';

        document.getElementById('modalUpdateUsaha')?.classList.remove('hidden');
    }

    function closeUpdateUsahaModal() {
        document.getElementById('modalUpdateUsaha')?.classList.add('hidden');
    }

    // Modal Upload Foto Functions
    function openUploadFotoModal(kop) {
        const form = document.getElementById('formUploadFoto');
        if (!form || !kop) return;

        form.action = `/admin/koperasi/${kop.id_koperasi}/foto`;
        document.getElementById('foto_koperasi_name').textContent = kop.name_koperasi;

        document.getElementById('modalUploadFoto')?.classList.remove('hidden');
    }

    function closeUploadFotoModal() {
        document.getElementById('modalUploadFoto')?.classList.add('hidden');
    }

    // Modal Konfirmasi Hapus Functions
    function confirmDeleteKoperasi(id, name) {
        const form = document.getElementById('formDeleteKoperasi');
        if (!form) return;

        form.action = `/admin/koperasi/${id}`;
        document.getElementById('delete_koperasi_name').textContent = name;

        document.getElementById('modalDeleteKoperasi')?.classList.remove('hidden');
    }

    function closeDeleteKoperasiModal() {
        document.getElementById('modalDeleteKoperasi')?.classList.add('hidden');
    }

    // Leaflet GIS Map Setup (Matching Public Dashboard)
    let mapInstance = null;
    let tileLayers = {};
    let activeLayerKey = 'osm';
    let adminKecamatanBoundaryLayer = null;
    let adminKecamatanMarkersLayer = null;
    let adminMarkersMap = {};
    let adminPolygonLayersMap = {};

    function initGisMap() {
        const mapEl = document.getElementById('gis-koperasi-map');
        if (!mapEl || typeof L === 'undefined') return;

        // Default Center and Bounds of Kabupaten Bogor
        const bogorCenter = [-6.5700, 106.8200];
        const bogorBounds = [
            [-6.8000, 106.4000],
            [-6.3000, 107.2500]
        ];

        mapInstance = L.map('gis-koperasi-map', {
            center: bogorCenter,
            zoom: 11,
            minZoom: 9,
            maxZoom: 18,
            scrollWheelZoom: false,
            maxBounds: [
                [-7.1000, 106.2000],
                [-6.1000, 107.4500]
            ],
            maxBoundsViscosity: 0.8
        });

        // Tiles matching public view
        tileLayers.osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(mapInstance);

        tileLayers.satelit = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri',
            maxZoom: 18
        });

        tileLayers.topo = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; OpenStreetMap contributors, SRTM',
            maxZoom: 17
        });

        // 1. Add Subdistrict Boundary Polygons (Garis Antar Kecamatan Kabupaten Bogor)
        renderAdminKecamatanBoundaries();

        // 2. Add Kecamatan Red Pin Summary Markers (like public)
        adminKecamatanMarkersLayer = L.layerGroup().addTo(mapInstance);
        renderAdminKecamatanMarkers();

        // Fit initial view to Kabupaten Bogor
        mapInstance.fitBounds(bogorBounds);

        // Check if desa or kecamatan is selected to zoom and pinpoint
        if (selectedKelId) {
            setTimeout(() => {
                zoomToAdminDesa(selectedKelId, true);
            }, 500);
        } else if (selectedKecId) {
            setTimeout(() => {
                zoomToAdminKecamatan(selectedKecId, false);
            }, 450);
        }

        setTimeout(() => updateAdminKoperasiLayerGlider(activeLayerKey), 80);
    }

    function renderAdminKecamatanBoundaries() {
        if (!window.BOGOR_KECAMATAN_GEOJSON) return;

        adminPolygonLayersMap = {};

        adminKecamatanBoundaryLayer = L.geoJSON(window.BOGOR_KECAMATAN_GEOJSON, {
            style: function (feature) {
                return {
                    color: '#0284c7', // Cyan/sky blue border matching public view
                    weight: 1.8,
                    opacity: 0.9,
                    fillColor: '#CFFCFD', // Soft cyan wash
                    fillOpacity: 0.28,
                    dashArray: ''
                };
            },
            onEachFeature: function (feature, layer) {
                const name = feature.properties ? (feature.properties.fullName || feature.properties.name) : 'Kecamatan';
                const cleanName = (feature.properties.name || '').toUpperCase().trim();

                layer.bindTooltip(name, {
                    sticky: true,
                    direction: 'top',
                    className: 'kecamatan-tooltip'
                });

                // Map polygon to matching kecamatan in kecamatansData
                const targetKec = kecamatansData.find(k => {
                    const kn = (k.name_kopkec || k.nama || '').toUpperCase().trim();
                    return kn === cleanName || cleanName.includes(kn) || kn.includes(cleanName);
                });

                if (targetKec) {
                    adminPolygonLayersMap[String(targetKec.id_kopkec)] = layer;
                }

                layer.on({
                    mouseover: function (e) {
                        const targetLayer = e.target;
                        const isSelected = targetKec && String(targetKec.id_kopkec) === String(document.getElementById('filter_id_kec')?.value);
                        if (!isSelected) {
                            targetLayer.setStyle({
                                weight: 2.8,
                                color: '#0369a1',
                                fillColor: '#bae6fd',
                                fillOpacity: 0.48
                            });
                            if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                                targetLayer.bringToFront();
                                if (adminKecamatanMarkersLayer) adminKecamatanMarkersLayer.bringToFront();
                            }
                        }
                    },
                    mouseout: function (e) {
                        const isSelected = targetKec && String(targetKec.id_kopkec) === String(document.getElementById('filter_id_kec')?.value);
                        if (!isSelected && adminKecamatanBoundaryLayer) {
                            adminKecamatanBoundaryLayer.resetStyle(e.target);
                        }
                    },
                    click: function (e) {
                        if (targetKec) {
                            const sel = document.getElementById('filter_id_kec');
                            if (sel) {
                                sel.value = targetKec.id_kopkec;
                            }
                            updateDesaDropdown(targetKec.id_kopkec);
                            zoomToAdminKecamatan(targetKec.id_kopkec, true);
                        }
                    }
                });
            }
        }).addTo(mapInstance);
    }

    function renderAdminKecamatanMarkers() {
        adminKecamatanMarkersLayer.clearLayers();
        adminMarkersMap = {};

        kecamatansData.forEach(item => {
            const lat = parseFloat(item.latitude);
            const lng = parseFloat(item.longitude);
            if (isNaN(lat) || isNaN(lng) || lat === 0) return;

            const markerHtml = `
                <div class="custom-kmp-pin" id="admin-pin-${item.id_kopkec || item.id}">
                    <div class="pin-body">
                        <i class="fa-solid fa-building-flag"></i>
                    </div>
                    <div class="pin-badge">${item.jumlah || item.jum_koperasi || 0}</div>
                </div>
            `;

            const customIcon = L.divIcon({
                html: markerHtml,
                className: '',
                iconSize: [36, 36],
                iconAnchor: [18, 18],
                popupAnchor: [0, -18]
            });

            const marker = L.marker([lat, lng], { icon: customIcon });

            const popupContent = `
                <div class="text-xs" style="min-width: 195px;">
                    <div class="font-bold text-slate-800 uppercase tracking-tight text-sm pb-1.5 mb-2 border-b border-red-100 flex items-center justify-between">
                        <span class="text-red-700">KECAMATAN ${item.name_kopkec || item.nama}</span>
                    </div>
                    <div class="grid grid-cols-3 gap-1.5 text-center bg-red-50/60 p-2 rounded-lg border border-red-100 text-[11px] mb-2.5">
                        <div>
                            <span class="text-slate-500 block text-[9px]">Desa</span>
                            <strong class="font-extrabold text-slate-800">${item.kop_desa || 0}</strong>
                        </div>
                        <div>
                            <span class="text-slate-500 block text-[9px]">Kelurahan</span>
                            <strong class="font-extrabold text-slate-800">${item.kop_kel || 0}</strong>
                        </div>
                        <div>
                            <span class="text-slate-500 block text-[9px]">Total</span>
                            <strong class="font-black text-red-600">${item.jumlah || item.jum_koperasi || 0} Kop</strong>
                        </div>
                    </div>
                    <button type="button" onclick="selectAdminKecamatanFromMap('${item.id_kopkec}')" class="w-full text-center py-1.5 px-3 bg-red-700 hover:bg-red-800 text-white rounded-lg font-bold text-xs transition shadow-sm flex items-center justify-center space-x-1 cursor-pointer">
                        <i class="fa-solid fa-crosshairs text-[10px]"></i>
                        <span>Pilih & Fokus Kecamatan</span>
                    </button>
                </div>
            `;

            marker.bindPopup(popupContent, {
                closeButton: true,
                autoPan: true
            });

            marker.on('click', () => {
                selectAdminKecamatanFromMap(item.id_kopkec);
            });

            marker.addTo(adminKecamatanMarkersLayer);
            adminMarkersMap[String(item.id_kopkec)] = marker;
        });
    }

    let adminCoopMarkerLayer = null;

    function zoomToAdminDesa(kelId, openPopup = true) {
        if (!mapInstance) return;

        if (!adminCoopMarkerLayer) {
            adminCoopMarkerLayer = L.layerGroup().addTo(mapInstance);
        }
        adminCoopMarkerLayer.clearLayers();

        if (!kelId) {
            if (selectedKecId) {
                zoomToAdminKecamatan(selectedKecId, true);
            } else {
                zoomToAdminKecamatan('', false);
            }
            return;
        }

        const coops = gisKoperasisData.filter(k => String(k.id_kel) === String(kelId) || (k.kelurahan && String(k.kelurahan.id_kopkel) === String(kelId)));

        if (!coops.length) {
            console.warn('Data koperasi untuk desa/kelurahan ID ' + kelId + ' belum memiliki koordinat terdaftar.');
            return;
        }

        const bounds = [];
        let firstMarker = null;

        coops.forEach((coop, index) => {
            const lat = parseFloat(coop.gps_lat);
            const lng = parseFloat(coop.gps_long);
            if (isNaN(lat) || isNaN(lng) || lat === 0) return;

            bounds.push([lat, lng]);

            const desaName = coop.kelurahan ? (coop.kelurahan.name_kopkel || '') : '';
            const kecName = coop.kecamatan ? (coop.kecamatan.name_kopkec || '') : '';

            const coopMarkerHtml = `
                <div class="relative flex items-center justify-center -translate-x-1/2 -translate-y-1/2">
                    <span class="absolute w-12 h-12 rounded-full bg-red-600/35 animate-ping pointer-events-none"></span>
                    <span class="absolute w-8 h-8 rounded-full bg-red-600/45 pointer-events-none"></span>
                    <div class="relative w-9 h-9 rounded-full bg-gradient-to-tr from-red-700 to-rose-500 border-2 border-white shadow-xl flex items-center justify-center text-white text-sm cursor-pointer hover:scale-110 transition-transform">
                        <i class="fa-solid fa-store"></i>
                    </div>
                    <div class="absolute -bottom-6 whitespace-nowrap bg-slate-900/90 text-white font-extrabold text-[10px] px-2 py-0.5 rounded shadow-md border border-slate-700 pointer-events-none">
                        ${coop.name_koperasi}
                    </div>
                </div>
            `;

            const marker = L.marker([lat, lng], {
                icon: L.divIcon({
                    html: coopMarkerHtml,
                    className: '',
                    iconSize: [0, 0],
                    iconAnchor: [0, 0],
                    popupAnchor: [0, -20]
                }),
                zIndexOffset: 1200
            });

            const popupContent = `
                <div class="p-2.5 text-xs" style="min-width: 250px;">
                    <div class="flex items-center space-x-1.5 pb-2 mb-2 border-b border-red-100">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-600"></span>
                        <span class="font-extrabold text-slate-900 text-xs uppercase leading-snug">${coop.name_koperasi}</span>
                    </div>
                    <div class="space-y-1.5 mb-3 text-[11px] text-slate-600">
                        <div class="flex items-start space-x-1.5">
                            <i class="fa-solid fa-location-dot text-red-500 mt-0.5 shrink-0"></i>
                            <span>Desa <strong>${desaName}</strong>, Kec. <strong>${kecName}</strong></span>
                        </div>
                        <div class="bg-red-50/70 p-2 rounded-lg border border-red-100/80 space-y-1 text-[10px]">
                            <div class="flex justify-between">
                                <span class="text-slate-500">Koordinat GPS:</span>
                                <span class="font-mono font-bold text-slate-800">${lat.toFixed(5)}, ${lng.toFixed(5)}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Status Operasi:</span>
                                <span class="font-bold ${coop.st_ops === 'SUDAH' ? 'text-emerald-700' : 'text-amber-700'}">${coop.st_ops || 'SUDAH'}</span>
                            </div>
                            ${coop.no_ahu ? `
                            <div class="flex justify-between">
                                <span class="text-slate-500">No. AHU:</span>
                                <span class="font-mono text-slate-800 font-semibold">${coop.no_ahu}</span>
                            </div>` : ''}
                        </div>
                    </div>
                    <a href="/koperasi/${coop.id_koperasi}" class="block text-center w-full py-1.5 px-3 bg-red-600 hover:bg-red-700 text-white font-extrabold rounded-lg transition text-xs shadow-xs">
                        <i class="fa-solid fa-arrow-up-right-from-square mr-1 text-[10px]"></i> Lihat Profil Koperasi
                    </a>
                </div>
            `;

            marker.bindPopup(popupContent, { autoPan: true, closeButton: true });
            marker.addTo(adminCoopMarkerLayer);

            if (index === 0) {
                firstMarker = marker;
            }
        });

        if (bounds.length === 1) {
            mapInstance.flyTo(bounds[0], 15, { duration: 1.4 });
        } else if (bounds.length > 1) {
            mapInstance.flyToBounds(bounds, { padding: [50, 50], maxZoom: 16, duration: 1.4 });
        }

        if (firstMarker && openPopup) {
            setTimeout(() => firstMarker.openPopup(), 650);
        }

        const legendDetail = document.getElementById('adminMapLegendDetail');
        if (legendDetail && coops[0]) {
            const firstCoop = coops[0];
            const lat = parseFloat(firstCoop.gps_lat);
            const lng = parseFloat(firstCoop.gps_long);
            legendDetail.innerHTML = `<span class="font-bold text-red-600">Titik Koperasi: ${firstCoop.name_koperasi}</span> &bull; Desa ${firstCoop.kelurahan?.name_kopkel || ''} (${lat.toFixed(4)}, ${lng.toFixed(4)})`;
        }
    }

    function selectAdminKecamatanFromMap(kecId) {
        const sel = document.getElementById('filter_id_kec');
        if (sel) {
            sel.value = kecId;
        }
        const kelSelect = document.getElementById('filter_id_kel');
        if (kelSelect) {
            kelSelect.value = '';
        }
        document.getElementById('formFilterKoperasi')?.submit();
    }

    function onAdminKecamatanChange(kecId) {
        const kelSelect = document.getElementById('filter_id_kel');
        if (kelSelect) {
            kelSelect.value = '';
        }
        document.getElementById('formFilterKoperasi')?.submit();
    }

    function onAdminDesaChange(kelId) {
        zoomToAdminDesa(kelId, true);
        document.getElementById('formFilterKoperasi')?.submit();
    }

    function zoomToAdminKecamatan(kecId, openPopup = true) {
        if (!mapInstance) return;

        const legendDetail = document.getElementById('adminMapLegendDetail');

        // Jika pilih Semua Kecamatan (""): Zoom out kembali menampilkan seluruh Kabupaten Bogor
        if (!kecId) {
            if (adminKecamatanBoundaryLayer) {
                adminKecamatanBoundaryLayer.eachLayer(layer => {
                    adminKecamatanBoundaryLayer.resetStyle(layer);
                });
            }

            mapInstance.flyToBounds([
                [-6.8000, 106.4000],
                [-6.3000, 107.2500]
            ], { padding: [20, 20], duration: 1.2 });

            if (legendDetail) {
                legendDetail.innerHTML = 'Pusat Pemerintahan: Cibinong (-6.4828, 106.8486)';
            }
            return;
        }

        const kec = kecamatansData.find(k => String(k.id_kopkec) === String(kecId) || String(k.id) === String(kecId));
        if (!kec) return;

        // Highlight poligon batas kecamatan terpilih dan samarkan yang lain
        const targetPolygon = adminPolygonLayersMap[String(kecId)];

        if (adminKecamatanBoundaryLayer) {
            adminKecamatanBoundaryLayer.eachLayer(layer => {
                if (layer === targetPolygon) {
                    layer.setStyle({
                        weight: 3.5,
                        color: '#0284c7',
                        fillColor: '#38bdf8',
                        fillOpacity: 0.45
                    });
                    if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                        layer.bringToFront();
                    }
                } else {
                    layer.setStyle({
                        weight: 1.2,
                        color: '#94a3b8',
                        fillColor: '#f1f5f9',
                        fillOpacity: 0.12
                    });
                }
            });
        }

        // Animasi Zoom In Halus (Fly To) ke poligon kecamatan yang dipilih
        if (targetPolygon) {
            const bounds = targetPolygon.getBounds();
            mapInstance.flyToBounds(bounds, { padding: [45, 45], maxZoom: 14, duration: 1.4 });
        } else if (kec.latitude && kec.longitude) {
            mapInstance.flyTo([parseFloat(kec.latitude), parseFloat(kec.longitude)], 13, { duration: 1.4 });
        }

        // Buka popup info kecamatan
        if (openPopup && adminMarkersMap[String(kecId)]) {
            setTimeout(() => {
                adminMarkersMap[String(kecId)].openPopup();
            }, 600);
        }

        // Perbarui detail legenda floating di pojok kiri bawah
        if (legendDetail) {
            legendDetail.innerHTML = `<span class="font-bold text-sky-700">Fokus: Kec. ${kec.name_kopkec || kec.nama}</span> &bull; <strong>${kec.jumlah || kec.jum_koperasi || 0} Koperasi</strong>`;
        }
    }

    function toggleAdminKecamatanBoundaries() {
        if (!adminKecamatanBoundaryLayer || !mapInstance) return;
        const btn = document.getElementById('btnToggleAdminBoundaries');
        if (mapInstance.hasLayer(adminKecamatanBoundaryLayer)) {
            mapInstance.removeLayer(adminKecamatanBoundaryLayer);
            if (btn) {
                btn.classList.remove('bg-sky-50', 'text-sky-700', 'border-sky-200');
                btn.classList.add('bg-slate-50', 'text-slate-500', 'border-slate-200');
            }
        } else {
            adminKecamatanBoundaryLayer.addTo(mapInstance);
            if (adminKecamatanMarkersLayer) {
                adminKecamatanMarkersLayer.bringToFront();
            }
            if (btn) {
                btn.classList.add('bg-sky-50', 'text-sky-700', 'border-sky-200');
                btn.classList.remove('bg-slate-50', 'text-slate-500', 'border-slate-200');
            }
        }
    }

    function updateAdminKoperasiLayerGlider(type) {
        const btnOsm = document.getElementById('btn-layer-osm');
        const btnSat = document.getElementById('btn-layer-satelit');
        const btnTopo = document.getElementById('btn-layer-topo');
        const mapButtons = { 'osm': btnOsm, 'satelit': btnSat, 'topo': btnTopo };
        const key = type || activeLayerKey;
        const activeBtn = mapButtons[key];
        const glider = document.getElementById('adminKoperasiLayerGlider');

        if (glider && activeBtn && activeBtn.offsetWidth > 0) {
            glider.style.left = activeBtn.offsetLeft + 'px';
            glider.style.top = activeBtn.offsetTop + 'px';
            glider.style.width = activeBtn.offsetWidth + 'px';
            glider.style.height = activeBtn.offsetHeight + 'px';
        }

        [
            { key: 'osm', btn: btnOsm },
            { key: 'satelit', btn: btnSat },
            { key: 'topo', btn: btnTopo }
        ].forEach(item => {
            if (!item.btn) return;
            if (item.key === key) {
                item.btn.className = "relative z-10 px-3 py-1 rounded-md text-white font-semibold transition-colors duration-200 cursor-pointer";
            } else {
                item.btn.className = "relative z-10 px-3 py-1 rounded-md text-slate-600 hover:text-slate-900 font-semibold transition-colors duration-200 cursor-pointer";
            }
        });
    }

    function setMapLayer(type) {
        updateAdminKoperasiLayerGlider(type);

        if (!mapInstance) return;

        if (tileLayers[activeLayerKey]) {
            mapInstance.removeLayer(tileLayers[activeLayerKey]);
        }

        if (tileLayers[type]) {
            tileLayers[type].addTo(mapInstance);
            activeLayerKey = type;
        }

        if (adminKecamatanBoundaryLayer && mapInstance.hasLayer(adminKecamatanBoundaryLayer)) {
            adminKecamatanBoundaryLayer.bringToFront();
        }
        if (adminKecamatanMarkersLayer && mapInstance.hasLayer(adminKecamatanMarkersLayer)) {
            adminKecamatanMarkersLayer.bringToFront();
        }
    }

    function onPengurusKecChange(kecId) {
        updateDesaDropdown(kecId, 'filter_kel_pengurus', '');
        document.getElementById('formFilterPengurus').submit();
    }

    let mapAnggotaInstance = null;
    let tileLayersAnggota = {};
    let activeLayerAnggotaKey = 'osm';
    let adminAnggotaBoundaryLayer = null;
    let adminAnggotaMarkersLayer = null;
    let adminAnggotaMarkersMap = {};
    let adminAnggotaPolygonLayersMap = {};

    function initMapAnggota() {
        const mapContainer = document.getElementById('map-anggota');
        if (!mapContainer || mapAnggotaInstance || typeof L === 'undefined') return;

        const bogorCenter = [-6.5700, 106.8200];
        const bogorBounds = [
            [-6.8000, 106.4000],
            [-6.3000, 107.2500]
        ];

        mapAnggotaInstance = L.map('map-anggota', {
            center: bogorCenter,
            zoom: 11,
            minZoom: 9,
            maxZoom: 18,
            maxBounds: [
                [-7.1000, 106.2000],
                [-6.1000, 107.4500]
            ],
            maxBoundsViscosity: 0.8
        });

        tileLayersAnggota.osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(mapAnggotaInstance);

        tileLayersAnggota.satelit = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri',
            maxZoom: 18
        });

        tileLayersAnggota.topo = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; OpenStreetMap contributors, SRTM',
            maxZoom: 17
        });

        // 1. Add Subdistrict Boundary Polygons (Garis Antar Kecamatan)
        renderAnggotaKecamatanBoundaries();

        // 2. Add Red Pin Markers with Numbers (NO blue dots!)
        adminAnggotaMarkersLayer = L.layerGroup().addTo(mapAnggotaInstance);
        renderAnggotaKecamatanMarkers();

        // Fit view to Kabupaten Bogor
        mapAnggotaInstance.fitBounds(bogorBounds);

        // Check if desa or kecamatan is selected to zoom and pinpoint
        const selectedAnggotaKec = "{{ request('filter_kec_anggota', '') }}";
        const selectedAnggotaKel = "{{ request('filter_kel_anggota', '') }}";
        if (selectedAnggotaKel) {
            setTimeout(() => {
                zoomToAnggotaDesa(selectedAnggotaKel, true);
            }, 500);
        } else if (selectedAnggotaKec) {
            setTimeout(() => {
                zoomToAnggotaKecamatan(selectedAnggotaKec, false);
            }, 450);
        }

        setTimeout(() => updateAdminAnggotaLayerGlider(activeLayerAnggotaKey), 80);
    }

    function renderAnggotaKecamatanBoundaries() {
        if (!window.BOGOR_KECAMATAN_GEOJSON || !mapAnggotaInstance) return;

        adminAnggotaPolygonLayersMap = {};

        adminAnggotaBoundaryLayer = L.geoJSON(window.BOGOR_KECAMATAN_GEOJSON, {
            style: function (feature) {
                return {
                    color: '#0284c7',
                    weight: 1.8,
                    opacity: 0.9,
                    fillColor: '#CFFCFD',
                    fillOpacity: 0.28,
                    dashArray: ''
                };
            },
            onEachFeature: function (feature, layer) {
                const name = feature.properties ? (feature.properties.fullName || feature.properties.name) : 'Kecamatan';
                const cleanName = (feature.properties.name || '').toUpperCase().trim();

                layer.bindTooltip(name, {
                    sticky: true,
                    direction: 'top',
                    className: 'kecamatan-tooltip'
                });

                const targetKec = kecamatansData.find(k => {
                    const kn = (k.name_kopkec || k.nama || '').toUpperCase().trim();
                    return kn === cleanName || cleanName.includes(kn) || kn.includes(cleanName);
                });

                if (targetKec) {
                    adminAnggotaPolygonLayersMap[String(targetKec.id_kopkec)] = layer;
                }

                layer.on({
                    mouseover: function (e) {
                        const targetLayer = e.target;
                        const isSelected = targetKec && String(targetKec.id_kopkec) === String(document.getElementById('filter_kec_anggota')?.value);
                        if (!isSelected) {
                            targetLayer.setStyle({
                                weight: 2.8,
                                color: '#0369a1',
                                fillColor: '#bae6fd',
                                fillOpacity: 0.48
                            });
                            if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                                targetLayer.bringToFront();
                                if (adminAnggotaMarkersLayer) adminAnggotaMarkersLayer.bringToFront();
                            }
                        }
                    },
                    mouseout: function (e) {
                        const isSelected = targetKec && String(targetKec.id_kopkec) === String(document.getElementById('filter_kec_anggota')?.value);
                        if (!isSelected && adminAnggotaBoundaryLayer) {
                            adminAnggotaBoundaryLayer.resetStyle(e.target);
                        }
                    },
                    click: function (e) {
                        if (targetKec) {
                            const sel = document.getElementById('filter_kec_anggota');
                            if (sel) {
                                sel.value = targetKec.id_kopkec;
                            }
                            updateDesaDropdown(targetKec.id_kopkec, 'filter_kel_anggota', '');
                            zoomToAnggotaKecamatan(targetKec.id_kopkec, true);
                        }
                    }
                });
            }
        }).addTo(mapAnggotaInstance);
    }

    function renderAnggotaKecamatanMarkers() {
        if (!adminAnggotaMarkersLayer) return;
        adminAnggotaMarkersLayer.clearLayers();
        adminAnggotaMarkersMap = {};

        kecamatansData.forEach(item => {
            const lat = parseFloat(item.latitude);
            const lng = parseFloat(item.longitude);
            if (isNaN(lat) || isNaN(lng) || lat === 0) return;

            const markerHtml = `
                <div class="custom-kmp-pin" id="admin-anggota-pin-${item.id_kopkec || item.id}">
                    <div class="pin-body">
                        <i class="fa-solid fa-building-flag"></i>
                    </div>
                    <div class="pin-badge">${item.jumlah || item.jum_koperasi || 0}</div>
                </div>
            `;

            const customIcon = L.divIcon({
                html: markerHtml,
                className: '',
                iconSize: [36, 36],
                iconAnchor: [18, 18],
                popupAnchor: [0, -18]
            });

            const marker = L.marker([lat, lng], { icon: customIcon });

            const popupContent = `
                <div class="text-xs" style="min-width: 195px;">
                    <div class="font-bold text-slate-800 uppercase tracking-tight text-sm pb-1.5 mb-2 border-b border-red-100 flex items-center justify-between">
                        <span class="text-red-700">KECAMATAN ${item.name_kopkec || item.nama}</span>
                    </div>
                    <div class="grid grid-cols-3 gap-1.5 text-center bg-red-50/60 p-2 rounded-lg border border-red-100 text-[11px] mb-2.5">
                        <div>
                            <span class="text-slate-500 block text-[9px]">Desa</span>
                            <strong class="font-extrabold text-slate-800">${item.kop_desa || 0}</strong>
                        </div>
                        <div>
                            <span class="text-slate-500 block text-[9px]">Kelurahan</span>
                            <strong class="font-extrabold text-slate-800">${item.kop_kel || 0}</strong>
                        </div>
                        <div>
                            <span class="text-slate-500 block text-[9px]">Total</span>
                            <strong class="font-black text-red-600">${item.jumlah || item.jum_koperasi || 0} Kop</strong>
                        </div>
                    </div>
                    <button type="button" onclick="selectAnggotaKecamatanFromMap('${item.id_kopkec}')" class="w-full text-center py-1.5 px-3 bg-red-700 hover:bg-red-800 text-white rounded-lg font-bold text-xs transition shadow-sm flex items-center justify-center space-x-1 cursor-pointer">
                        <i class="fa-solid fa-crosshairs text-[10px]"></i>
                        <span>Pilih & Fokus Kecamatan</span>
                    </button>
                </div>
            `;

            marker.bindPopup(popupContent, {
                closeButton: true,
                autoPan: true
            });

            marker.on('click', () => {
                selectAnggotaKecamatanFromMap(item.id_kopkec);
            });

            marker.addTo(adminAnggotaMarkersLayer);
            adminAnggotaMarkersMap[String(item.id_kopkec)] = marker;
        });
    }

    function selectAnggotaKecamatanFromMap(kecId) {
        const sel = document.getElementById('filter_kec_anggota');
        if (sel) {
            sel.value = kecId;
        }
        updateDesaDropdown(kecId, 'filter_kel_anggota', '');
        zoomToAnggotaKecamatan(kecId, true);
    }

    function onAnggotaKecChange(kecId) {
        updateDesaDropdown(kecId, 'filter_kel_anggota', '');
        zoomToAnggotaKecamatan(kecId, true);
    }

    function zoomToAnggotaKecamatan(kecId, openPopup = true) {
        if (!mapAnggotaInstance) return;

        const legendDetail = document.getElementById('anggotaMapLegendDetail');

        if (!kecId) {
            if (adminAnggotaBoundaryLayer) {
                adminAnggotaBoundaryLayer.eachLayer(layer => {
                    adminAnggotaBoundaryLayer.resetStyle(layer);
                });
            }

            mapAnggotaInstance.flyToBounds([
                [-6.8000, 106.4000],
                [-6.3000, 107.2500]
            ], { padding: [20, 20], duration: 1.2 });

            if (legendDetail) {
                legendDetail.innerHTML = 'Pusat Pemerintahan: Cibinong (-6.4828, 106.8486)';
            }
            return;
        }

        const kec = kecamatansData.find(k => String(k.id_kopkec) === String(kecId) || String(k.id) === String(kecId));
        if (!kec) return;

        const targetPolygon = adminAnggotaPolygonLayersMap[String(kecId)];

        if (adminAnggotaBoundaryLayer) {
            adminAnggotaBoundaryLayer.eachLayer(layer => {
                if (layer === targetPolygon) {
                    layer.setStyle({
                        weight: 3.5,
                        color: '#0284c7',
                        fillColor: '#38bdf8',
                        fillOpacity: 0.45
                    });
                    if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                        layer.bringToFront();
                    }
                } else {
                    layer.setStyle({
                        weight: 1.2,
                        color: '#94a3b8',
                        fillColor: '#f1f5f9',
                        fillOpacity: 0.12
                    });
                }
            });
        }

        if (targetPolygon) {
            const bounds = targetPolygon.getBounds();
            mapAnggotaInstance.flyToBounds(bounds, { padding: [45, 45], maxZoom: 14, duration: 1.4 });
        } else if (kec.latitude && kec.longitude) {
            mapAnggotaInstance.flyTo([parseFloat(kec.latitude), parseFloat(kec.longitude)], 13, { duration: 1.4 });
        }

        if (openPopup && adminAnggotaMarkersMap[String(kecId)]) {
            setTimeout(() => {
                adminAnggotaMarkersMap[String(kecId)].openPopup();
            }, 600);
        }

        if (legendDetail) {
            legendDetail.innerHTML = `<span class="font-bold text-sky-700">Fokus: Kec. ${kec.name_kopkec || kec.nama}</span> &bull; <strong>${kec.jumlah || kec.jum_koperasi || 0} Koperasi</strong>`;
        }
    }

    function toggleAnggotaKecamatanBoundaries() {
        if (!adminAnggotaBoundaryLayer || !mapAnggotaInstance) return;
        const btn = document.getElementById('btnToggleAnggotaBoundaries');
        if (mapAnggotaInstance.hasLayer(adminAnggotaBoundaryLayer)) {
            mapAnggotaInstance.removeLayer(adminAnggotaBoundaryLayer);
            if (btn) {
                btn.classList.remove('bg-sky-50', 'text-sky-700', 'border-sky-200');
                btn.classList.add('bg-slate-50', 'text-slate-500', 'border-slate-200');
            }
        } else {
            adminAnggotaBoundaryLayer.addTo(mapAnggotaInstance);
            if (adminAnggotaMarkersLayer) {
                adminAnggotaMarkersLayer.bringToFront();
            }
            if (btn) {
                btn.classList.add('bg-sky-50', 'text-sky-700', 'border-sky-200');
                btn.classList.remove('bg-slate-50', 'text-slate-500', 'border-slate-200');
            }
        }
    }

    function updateAdminAnggotaLayerGlider(type) {
        const btnOsm = document.getElementById('btn-layer-anggota-osm');
        const btnSat = document.getElementById('btn-layer-anggota-satelit');
        const btnTopo = document.getElementById('btn-layer-anggota-topo');
        const mapButtons = { 'osm': btnOsm, 'satelit': btnSat, 'topo': btnTopo };
        const key = type || activeLayerAnggotaKey;
        const activeBtn = mapButtons[key];
        const glider = document.getElementById('adminAnggotaLayerGlider');

        if (glider && activeBtn && activeBtn.offsetWidth > 0) {
            glider.style.left = activeBtn.offsetLeft + 'px';
            glider.style.top = activeBtn.offsetTop + 'px';
            glider.style.width = activeBtn.offsetWidth + 'px';
            glider.style.height = activeBtn.offsetHeight + 'px';
        }

        [
            { key: 'osm', btn: btnOsm },
            { key: 'satelit', btn: btnSat },
            { key: 'topo', btn: btnTopo }
        ].forEach(item => {
            if (!item.btn) return;
            if (item.key === key) {
                item.btn.className = "relative z-10 px-3 py-1 rounded-md text-white font-semibold transition-colors duration-200 cursor-pointer";
            } else {
                item.btn.className = "relative z-10 px-3 py-1 rounded-md text-slate-600 hover:text-slate-900 font-semibold transition-colors duration-200 cursor-pointer";
            }
        });
    }

    function setAnggotaMapLayer(type) {
        updateAdminAnggotaLayerGlider(type);

        if (!mapAnggotaInstance) return;

        if (tileLayersAnggota[activeLayerAnggotaKey]) {
            mapAnggotaInstance.removeLayer(tileLayersAnggota[activeLayerAnggotaKey]);
        }

        if (tileLayersAnggota[type]) {
            tileLayersAnggota[type].addTo(mapAnggotaInstance);
            activeLayerAnggotaKey = type;
        }

        if (adminAnggotaBoundaryLayer && mapAnggotaInstance.hasLayer(adminAnggotaBoundaryLayer)) {
            adminAnggotaBoundaryLayer.bringToFront();
        }
        if (adminAnggotaMarkersLayer && mapAnggotaInstance.hasLayer(adminAnggotaMarkersLayer)) {
            adminAnggotaMarkersLayer.bringToFront();
        }
    }

    window.addEventListener('resize', () => {
        updateAdminKoperasiLayerGlider(activeLayerKey);
        updateAdminAnggotaLayerGlider(activeLayerAnggotaKey);
    });

    function resetAnggotaMapView() {
        if (mapAnggotaInstance) {
            zoomToAnggotaKecamatan('', false);
        }
    }

    let adminAnggotaCoopMarkerLayer = null;

    function zoomToAnggotaDesa(kelId, openPopup = true) {
        if (!mapAnggotaInstance) return;

        if (!adminAnggotaCoopMarkerLayer) {
            adminAnggotaCoopMarkerLayer = L.layerGroup().addTo(mapAnggotaInstance);
        }
        adminAnggotaCoopMarkerLayer.clearLayers();

        if (!kelId) {
            const selectedAnggotaKec = document.getElementById('filter_kec_anggota')?.value;
            if (selectedAnggotaKec) {
                zoomToAnggotaKecamatan(selectedAnggotaKec, true);
            } else {
                zoomToAnggotaKecamatan('', false);
            }
            return;
        }

        const coops = gisKoperasisData.filter(k => String(k.id_kel) === String(kelId) || (k.kelurahan && String(k.kelurahan.id_kopkel) === String(kelId)));

        if (!coops.length) return;

        const bounds = [];
        let firstMarker = null;

        coops.forEach((coop, index) => {
            const lat = parseFloat(coop.gps_lat);
            const lng = parseFloat(coop.gps_long);
            if (isNaN(lat) || isNaN(lng) || lat === 0) return;

            bounds.push([lat, lng]);

            const desaName = coop.kelurahan ? (coop.kelurahan.name_kopkel || '') : '';
            const kecName = coop.kecamatan ? (coop.kecamatan.name_kopkec || '') : '';

            const coopMarkerHtml = `
                <div class="relative flex items-center justify-center -translate-x-1/2 -translate-y-1/2">
                    <span class="absolute w-12 h-12 rounded-full bg-red-600/35 animate-ping pointer-events-none"></span>
                    <span class="absolute w-8 h-8 rounded-full bg-red-600/45 pointer-events-none"></span>
                    <div class="relative w-9 h-9 rounded-full bg-gradient-to-tr from-red-700 to-rose-500 border-2 border-white shadow-xl flex items-center justify-center text-white text-sm cursor-pointer hover:scale-110 transition-transform">
                        <i class="fa-solid fa-users-viewfinder"></i>
                    </div>
                    <div class="absolute -bottom-6 whitespace-nowrap bg-slate-900/90 text-white font-extrabold text-[10px] px-2 py-0.5 rounded shadow-md border border-slate-700 pointer-events-none">
                        ${coop.name_koperasi}
                    </div>
                </div>
            `;

            const marker = L.marker([lat, lng], {
                icon: L.divIcon({
                    html: coopMarkerHtml,
                    className: '',
                    iconSize: [0, 0],
                    iconAnchor: [0, 0],
                    popupAnchor: [0, -20]
                }),
                zIndexOffset: 1200
            });

            const popupContent = `
                <div class="p-2.5 text-xs" style="min-width: 250px;">
                    <div class="flex items-center space-x-1.5 pb-2 mb-2 border-b border-red-100">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-600"></span>
                        <span class="font-extrabold text-slate-900 text-xs uppercase leading-snug">${coop.name_koperasi}</span>
                    </div>
                    <div class="space-y-1.5 mb-3 text-[11px] text-slate-600">
                        <div class="flex items-start space-x-1.5">
                            <i class="fa-solid fa-location-dot text-red-500 mt-0.5 shrink-0"></i>
                            <span>Desa <strong>${desaName}</strong>, Kec. <strong>${kecName}</strong></span>
                        </div>
                        <div class="bg-red-50/70 p-2 rounded-lg border border-red-100/80 space-y-1 text-[10px]">
                            <div class="flex justify-between">
                                <span class="text-slate-500">Koordinat GPS:</span>
                                <span class="font-mono font-bold text-slate-800">${lat.toFixed(5)}, ${lng.toFixed(5)}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Status Operasi:</span>
                                <span class="font-bold ${coop.st_ops === 'SUDAH' ? 'text-emerald-700' : 'text-amber-700'}">${coop.st_ops || 'SUDAH'}</span>
                            </div>
                        </div>
                    </div>
                    <a href="/koperasi/${coop.id_koperasi}" class="block text-center w-full py-1.5 px-3 bg-red-600 hover:bg-red-700 text-white font-extrabold rounded-lg transition text-xs shadow-xs">
                        <i class="fa-solid fa-arrow-up-right-from-square mr-1 text-[10px]"></i> Lihat Profil Koperasi
                    </a>
                </div>
            `;

            marker.bindPopup(popupContent, { autoPan: true, closeButton: true });
            marker.addTo(adminAnggotaCoopMarkerLayer);

            if (index === 0) {
                firstMarker = marker;
            }
        });

        if (bounds.length === 1) {
            mapAnggotaInstance.flyTo(bounds[0], 15, { duration: 1.4 });
        } else if (bounds.length > 1) {
            mapAnggotaInstance.flyToBounds(bounds, { padding: [50, 50], maxZoom: 16, duration: 1.4 });
        }

        if (firstMarker && openPopup) {
            setTimeout(() => firstMarker.openPopup(), 650);
        }

        const legendDetail = document.getElementById('anggotaMapLegendDetail');
        if (legendDetail && coops[0]) {
            const firstCoop = coops[0];
            const lat = parseFloat(firstCoop.gps_lat);
            const lng = parseFloat(firstCoop.gps_long);
            legendDetail.innerHTML = `<span class="font-bold text-red-600">Titik Koperasi: ${firstCoop.name_koperasi}</span> &bull; Desa ${firstCoop.kelurahan?.name_kopkel || ''} (${lat.toFixed(4)}, ${lng.toFixed(4)})`;
        }
    }

    function onAnggotaKecChange(kecId) {
        const kelSelect = document.getElementById('filter_kel_anggota');
        if (kelSelect) {
            kelSelect.value = '';
        }
        document.getElementById('formFilterAnggota')?.submit();
    }

    function onAnggotaDesaChange(kelId) {
        zoomToAnggotaDesa(kelId, true);
        document.getElementById('formFilterAnggota')?.submit();
    }

    function selectAnggotaKecamatanFromMap(kecId) {
        const sel = document.getElementById('filter_kec_anggota');
        if (sel) {
            sel.value = kecId;
        }
        const kelSelect = document.getElementById('filter_kel_anggota');
        if (kelSelect) {
            kelSelect.value = '';
        }
        document.getElementById('formFilterAnggota')?.submit();
    }

    function syncAnggotaSimkop() {
        alert('Memulai sinkronisasi background SIMKOP Koperasi Desa Kabupaten Bogor...');
    }

    // Lampiran Upload Preview & Edit Modal Handlers
    function handleLampiranFileSelect(input) {
        if (!input.files || input.files.length === 0) return;
        const file = input.files[0];

        // Transfer selected file to modalActualFileInput
        const modalInput = document.getElementById('modalActualFileInput');
        if (modalInput) {
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            modalInput.files = dataTransfer.files;
        }

        // Set file info in modal
        const nameEl = document.getElementById('previewFileName');
        const sizeEl = document.getElementById('previewFileSize');
        const iconSpan = document.getElementById('previewFileIcon');
        const judulInput = document.getElementById('inputJudulLampiran');

        if (nameEl) nameEl.innerText = file.name;
        const sizeMb = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
        if (sizeEl) sizeEl.innerText = sizeMb + ' • ' + (file.type || 'Dokumen');

        // Suggest a title if empty or default
        if (judulInput && !judulInput.value) {
            const cleanName = file.name.replace(/\.[^/.]+$/, '').replace(/[-_]/g, ' ').toUpperCase();
            judulInput.value = cleanName;
        }

        // Handle Interactive Preview
        const iframe = document.getElementById('previewIframe');
        const img = document.getElementById('previewImage');
        const fallback = document.getElementById('previewFallback');

        if (iframe) iframe.classList.add('hidden');
        if (img) img.classList.add('hidden');
        if (fallback) fallback.classList.add('hidden');

        if (file.type === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf')) {
            const fileUrl = URL.createObjectURL(file);
            if (iframe) {
                iframe.src = fileUrl;
                iframe.classList.remove('hidden');
            }
            if (iconSpan) {
                iconSpan.innerHTML = '<i class="fa-solid fa-file-pdf"></i>';
                iconSpan.className = 'w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center text-sm font-bold shrink-0';
            }
        } else if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                if (img) {
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                }
            };
            reader.readAsDataURL(file);
            if (iconSpan) {
                iconSpan.innerHTML = '<i class="fa-solid fa-file-image"></i>';
                iconSpan.className = 'w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm font-bold shrink-0';
            }
        } else {
            if (fallback) fallback.classList.remove('hidden');
            if (iconSpan) {
                iconSpan.innerHTML = '<i class="fa-solid fa-file-lines"></i>';
                iconSpan.className = 'w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-sm font-bold shrink-0';
            }
        }

        // Open modal
        document.getElementById('modalPreviewUpload')?.classList.remove('hidden');
    }

    function cancelUploadPreview() {
        document.getElementById('modalPreviewUpload')?.classList.add('hidden');
        const fileInput = document.getElementById('lampiranFileInput');
        if (fileInput) fileInput.value = '';
        const modalInput = document.getElementById('modalActualFileInput');
        if (modalInput) modalInput.value = '';
        const iframe = document.getElementById('previewIframe');
        if (iframe) iframe.src = '';
    }

    function openEditLampiranModal(lampiran) {
        const form = document.getElementById('formEditLampiran');
        if (form) form.action = '/admin/lampiran/' + lampiran.id;
        const judulEl = document.getElementById('editJudul');
        if (judulEl) judulEl.value = lampiran.judul || '';
        const ketEl = document.getElementById('editKeterangan');
        if (ketEl) ketEl.value = lampiran.keterangan || '';
        const urutanEl = document.getElementById('editUrutan');
        if (urutanEl) urutanEl.value = lampiran.urutan || 1;
        document.getElementById('modalEditLampiran')?.classList.remove('hidden');
    }

    function closeEditLampiranModal() {
        document.getElementById('modalEditLampiran')?.classList.add('hidden');
    }

    // Auto-init on page load
    document.addEventListener('DOMContentLoaded', function () {
        if (selectedKecId) {
            updateDesaDropdown(selectedKecId, 'filter_id_kel', selectedKelId);
        }

        const selectedPengurusKecId = "{{ request('filter_kec_pengurus', '') }}";
        const selectedPengurusKelId = "{{ request('filter_kel_pengurus', '') }}";
        if (selectedPengurusKecId) {
            updateDesaDropdown(selectedPengurusKecId, 'filter_kel_pengurus', selectedPengurusKelId);
        }

        const selectedAnggotaKecId = "{{ request('filter_kec_anggota', '') }}";
        const selectedAnggotaKelId = "{{ request('filter_kel_anggota', '') }}";
        if (selectedAnggotaKecId) {
            updateDesaDropdown(selectedAnggotaKecId, 'filter_kel_anggota', selectedAnggotaKelId);
        }

        // Initialize GIS map and layer switchers after DOM settles
        setTimeout(initGisMap, 200);
        setTimeout(initMapAnggota, 250);
        setTimeout(() => {
            updateAdminKoperasiLayerGlider(activeLayerKey);
            updateAdminAnggotaLayerGlider(activeLayerAnggotaKey);
        }, 120);
    });
</script>
@endsection
