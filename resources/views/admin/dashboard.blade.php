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
@php
    $isOperatorKecamatan = $user->isOperatorKecamatan();
@endphp
<div data-dashboard-shell="{{ $isOperatorKecamatan ? 'operator-kecamatan' : 'default' }}" class="min-h-screen {{ $isOperatorKecamatan ? 'bg-slate-50' : 'bg-[#f8fafc]' }} flex flex-col justify-between text-slate-800 w-full max-w-full">

    <!-- Top Navigation Header GovTech KOP -->
    <header class="{{ $isOperatorKecamatan ? 'bg-gradient-to-r from-[#881337] via-[#991b1b] to-[#7f1d1d] shadow-lg' : 'fixed top-0 inset-x-0 w-full bg-gradient-to-r from-[#881337] via-[#991b1b] to-[#7f1d1d] shadow-md z-[100]' }} text-white">
        <div class="{{ $isOperatorKecamatan ? 'mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8' : 'w-full px-4 sm:px-6 lg:px-8' }}">
            <div class="{{ $isOperatorKecamatan ? 'flex flex-wrap items-center justify-between gap-x-6 gap-y-4 py-4' : 'flex items-center justify-between h-16' }}">
                <!-- Left: Lambang Kabupaten Bogor & Logo KOPDES Bulat (Sesuai Bagian Publik) -->
                <div class="flex items-center space-x-2 sm:space-x-3.5 min-w-0 pr-1">
                    <!-- Lambang Kabupaten Bogor (Tegar Beriman) -->
                    <img src="{{ asset('images/logo-kabupaten-bogor.png') }}" alt="Lambang Kabupaten Bogor" class="h-8 sm:h-11 w-auto object-contain drop-shadow shrink-0">

                    <!-- Logo KOPDES Bulat (Sesuai Desain Asli) -->
                    <div class="w-8 h-8 sm:w-11 sm:h-11 rounded-full bg-white flex items-center justify-center p-1 sm:p-1.5 shadow-md shrink-0 border border-white/50 overflow-hidden">
                        <img src="{{ asset('images/logo-kopdeskel-clean.png') }}" alt="Logo KOP DES KEL Merah Putih" class="w-full h-full object-contain">
                    </div>

                    <div class="flex flex-col justify-center min-w-0">
                        <div class="flex items-baseline space-x-1 sm:space-x-1.5">
                            <span class="text-base sm:text-2xl font-bold tracking-tight text-white leading-tight">
                                Dashboard
                            </span>
                            <span class="hidden sm:inline text-sm sm:text-base font-semibold text-red-100">
                                {{ $isOperatorKecamatan ? 'KMP Kab. Bogor' : 'KOPERASI MERAH PUTIH' }}
                            </span>
                            <span class="sr-only">KOPERASI MERAH PUTIH</span>
                        </div>
                        <p class="text-[10px] sm:text-xs text-red-200 font-medium leading-none mt-0.5 truncate max-w-[140px] xs:max-w-[210px] sm:max-w-none">
                            Pemerintah Daerah Kabupaten Bogor
                        </p>
                    </div>
                </div>

                <!-- Right: Log Out Button -->
                <div class="flex items-center space-x-3">

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="{{ $isOperatorKecamatan ? 'inline-flex items-center justify-center gap-2 rounded-xl border border-white/30 px-3 py-2 text-sm font-bold transition hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/70 sm:px-4' : 'flex items-center space-x-2 bg-gradient-to-r from-red-600 to-rose-700 hover:from-red-500 hover:to-rose-600 border border-white/20 text-white px-4 py-1.5 rounded-full text-xs sm:text-sm font-bold shadow-sm transition-all duration-200 hover:shadow transform active:scale-95 cursor-pointer' }}">
                            <span>{{ $isOperatorKecamatan ? 'Keluar' : 'Log Out' }}</span>
                            <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Container with Sidebar -->
    <main class="{{ $isOperatorKecamatan ? 'mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8' : 'flex-grow w-full max-w-full px-4 sm:px-6 lg:px-8 pt-20 pb-6' }} relative z-0 isolate min-w-0">

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

        <div class="{{ $isOperatorKecamatan ? 'grid min-w-0 gap-6 lg:grid-cols-[15rem_minmax(0,1fr)] lg:items-start lg:gap-8' : 'flex flex-col lg:flex-row gap-6 w-full min-w-0' }}">

            <!-- Left Sidebar Navigation Card -->
            <aside class="{{ $isOperatorKecamatan ? 'min-w-0' : 'w-full lg:w-64 shrink-0' }}">
                <div class="bg-white rounded-2xl border border-slate-200/80 {{ $isOperatorKecamatan ? 'p-3 shadow-xs lg:sticky lg:top-6' : 'p-4 shadow-sm sticky top-20' }} space-y-4">
                    
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
                           class="group w-full flex items-center justify-between px-4 py-2.5 rounded-xl transition shadow-sm {{ $activeTab === 'informasi' ? ($isOperatorKecamatan ? 'bg-rose-800 text-white shadow-rose-900/20' : 'bg-[#0284c7] text-white shadow-sky-600/20') : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200/70' }}">
                            <span>Informasi</span>
                            <i class="fa-solid fa-chevron-right text-xs {{ $activeTab === 'informasi' ? 'text-white' : 'text-slate-300 group-hover:text-slate-500' }} transition-colors"></i>
                        </a>

                        <!-- 2. DATABASE KOPERASI -->
                        <a href="{{ route('admin.dashboard', ['tab' => 'koperasi']) }}"
                           class="group w-full flex items-center justify-between px-4 py-2.5 rounded-xl transition shadow-sm {{ $activeTab === 'koperasi' ? ($isOperatorKecamatan ? 'bg-rose-800 text-white shadow-rose-900/20' : 'bg-[#0284c7] text-white shadow-sky-600/20') : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200/70' }}">
                            <span>Database Koperasi</span>
                            <i class="fa-solid fa-chevron-right text-xs {{ $activeTab === 'koperasi' ? 'text-white' : 'text-slate-300 group-hover:text-slate-500' }} transition-colors"></i>
                        </a>

                        <!-- 3. DATABASE PENGURUS -->
                        <a href="{{ route('admin.dashboard', ['tab' => 'pengurus']) }}"
                           class="group w-full flex items-center justify-between px-4 py-2.5 rounded-xl transition shadow-sm {{ $activeTab === 'pengurus' ? ($isOperatorKecamatan ? 'bg-rose-800 text-white shadow-rose-900/20' : 'bg-[#0284c7] text-white shadow-sky-600/20') : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200/70' }}">
                            <span>Database Pengurus</span>
                            <i class="fa-solid fa-chevron-right text-xs {{ $activeTab === 'pengurus' ? 'text-white' : 'text-slate-300 group-hover:text-slate-500' }} transition-colors"></i>
                        </a>

                        <!-- 4. DATABASE ANGGOTA -->
                        <a href="{{ route('admin.dashboard', ['tab' => 'anggota']) }}"
                           class="group w-full flex items-center justify-between px-4 py-2.5 rounded-xl transition shadow-sm {{ $activeTab === 'anggota' ? ($isOperatorKecamatan ? 'bg-rose-800 text-white shadow-rose-900/20' : 'bg-[#0284c7] text-white shadow-sky-600/20') : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200/70' }}">
                            <span>Database Anggota</span>
                            <i class="fa-solid fa-chevron-right text-xs {{ $activeTab === 'anggota' ? 'text-white' : 'text-slate-300 group-hover:text-slate-500' }} transition-colors"></i>
                        </a>

                        @unless($user->isOperatorKecamatan())
                            <!-- 5. LAMPIRAN INFORMASI -->
                            <a href="{{ route('admin.dashboard', ['tab' => 'lampiran']) }}"
                               class="group w-full flex items-center justify-between px-4 py-2.5 rounded-xl transition shadow-sm {{ $activeTab === 'lampiran' ? 'bg-[#0284c7] text-white shadow-sky-600/20' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200/70' }}">
                                <span>Lampiran Informasi</span>
                                <i class="fa-solid fa-chevron-right text-xs {{ $activeTab === 'lampiran' ? 'text-white' : 'text-slate-300 group-hover:text-slate-500' }} transition-colors"></i>
                            </a>
                        @endunless
                    </nav>

                    <!-- REKAPITULASI WILAYAH Widget -->
                    <div class="pt-3 border-t border-slate-100 space-y-2.5">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-extrabold text-slate-600 uppercase tracking-wider">
                                {{ $activeTab === 'anggota' ? 'REKAPITULASI KABUPATEN' : 'REKAPITULASI WILAYAH' }}
                            </span>
                            @if($activeTab === 'anggota')
                                <span class="text-[9px] font-bold px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200">
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
                            <div class="text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">JUMLAH KOPERASI</div>
                            <div class="text-2xl font-black text-slate-900 mt-1.5 leading-none">
                                {{ $totalKoperasi }}
                            </div>
                        </div>

                        <!-- Card 2: Anggota Koperasi -->
                        <div class="bg-white border border-slate-200/80 rounded-xl p-3 shadow-xs relative overflow-hidden">
                            <div class="text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">ANGGOTA KOPERASI</div>
                            <div class="text-2xl font-black text-slate-900 mt-1.5 leading-none">
                                {{ number_format($totalAnggota) }}
                            </div>
                            <p class="text-[10px] text-slate-400 mt-2 leading-relaxed">
                                Sinkronisasi NIK anggota koperasi desa sedang dalam integrasi lapangan.
                            </p>
                        </div>
                    </div>

                </div>
            </aside>

            <!-- Right Main Work Area -->
            <section class="flex-1 min-w-0 space-y-6">

                @if($activeTab === 'informasi')
                    <!-- ================= TAB: INFORMASI KOPERASI & REKAPITULASI ================= -->

                    <!-- Section Header Bar -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight uppercase leading-tight">
                                @if(str_starts_with($rekapSubtab, 'rekap_ang_'))
                                    ANGGOTA KOPERASI KABUPATEN BOGOR
                                @elseif($rekapSubtab === 'info')
                                    INFORMASI KOPERASI
                                @else
                                    KOPERASI KABUPATEN BOGOR
                                @endif
                            </h2>
                            <p class="text-xs font-bold text-slate-500 italic tracking-wider uppercase mt-0.5">
                                @if($rekapSubtab === 'rekap_kop_kec' || $rekapSubtab === 'rekap_ang_kec')
                                    PER KECAMATAN
                                @elseif($rekapSubtab === 'info')
                                    KABUPATEN BOGOR
                                @else
                                    PER DESA / KELURAHAN
                                @endif
                            </p>
                            <span class="sr-only">Anggota Koperasi Anggota UMKM</span>
                        </div>

                        <!-- Dropdown Select Rekapitulasi (Matching kdkmp.bogorkab.go.id) -->
                        <div class="relative">
                            <select onchange="window.location.href=this.value"
                                    class="bg-white border border-slate-300 rounded-lg px-3 py-2 text-xs font-extrabold text-slate-700 uppercase tracking-wider focus:outline-none focus:ring-2 focus:ring-sky-500 shadow-xs cursor-pointer pr-8">
                                <option value="">-- PILIH --</option>
                                <option value="{{ route('admin.dashboard', ['tab' => 'informasi', 'subtab' => 'info']) }}" {{ $rekapSubtab === 'info' ? 'selected' : '' }}>INFORMASI KOPERASI</option>
                                <option value="{{ route('admin.dashboard', ['tab' => 'informasi', 'subtab' => 'rekap_kop_kec']) }}" {{ $rekapSubtab === 'rekap_kop_kec' ? 'selected' : '' }}>REKAP KOPERASI PER KECAMATAN</option>
                                <option value="{{ route('admin.dashboard', ['tab' => 'informasi', 'subtab' => 'rekap_kop_desa']) }}" {{ $rekapSubtab === 'rekap_kop_desa' ? 'selected' : '' }}>REKAP KOPERASI PER DESA</option>
                                <option value="{{ route('admin.dashboard', ['tab' => 'informasi', 'subtab' => 'rekap_ang_kec']) }}" {{ $rekapSubtab === 'rekap_ang_kec' ? 'selected' : '' }}>REKAP ANGGOTA PER KECAMATAN</option>
                                <option value="{{ route('admin.dashboard', ['tab' => 'informasi', 'subtab' => 'rekap_ang_desa']) }}" {{ $rekapSubtab === 'rekap_ang_desa' ? 'selected' : '' }}>REKAP ANGGOTA PER DESA</option>
                            </select>
                        </div>
                    </div>

                    @if($rekapSubtab !== 'info')
                        <!-- ================= VIEW: REKAPITULASI (PERSIS SESUAI FOTO) ================= -->

                        <!-- Peta Choropleth Sebaran Rekapitulasi -->
                        <div class="rounded-xl border border-slate-200 bg-white overflow-hidden shadow-xs relative">
                            <div class="relative w-full h-[460px] bg-slate-100 isolate z-0">
                                <div id="map-rekap" class="w-full h-full z-10"></div>

                                <!-- [Klik pada peta] Top-Right Banner matching reference -->
                                <div class="absolute top-3 right-3 z-20 px-3 py-1 rounded bg-white/90 backdrop-blur-xs border border-slate-200 text-[11px] font-bold text-slate-600 shadow-xs pointer-events-none">
                                    [Klik pada peta]
                                </div>

                                <!-- Legend Bottom-Right matching reference -->
                                <div class="absolute bottom-4 right-3 z-20 bg-white/95 backdrop-blur-xs p-2.5 rounded-lg border border-slate-200 shadow-md text-[10px] space-y-1">
                                    <div class="flex items-center gap-1.5 font-bold text-slate-700">
                                        <span class="w-4 h-3 rounded-xs border border-slate-300" style="background-color: #fff7bc;"></span>
                                        <span>1–5</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 font-bold text-slate-700">
                                        <span class="w-4 h-3 rounded-xs border border-slate-300" style="background-color: #fee391;"></span>
                                        <span>5–10</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 font-bold text-slate-700">
                                        <span class="w-4 h-3 rounded-xs border border-slate-300" style="background-color: #fec44f;"></span>
                                        <span>10–15</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 font-bold text-slate-700">
                                        <span class="w-4 h-3 rounded-xs border border-slate-300" style="background-color: #fe9929;"></span>
                                        <span>15–20</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 font-bold text-slate-700">
                                        <span class="w-4 h-3 rounded-xs border border-slate-300" style="background-color: #ec7014;"></span>
                                        <span>20–25</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 font-bold text-slate-700">
                                        <span class="w-4 h-3 rounded-xs border border-slate-300" style="background-color: #cc4c02;"></span>
                                        <span>25–50</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 font-bold text-slate-700">
                                        <span class="w-4 h-3 rounded-xs border border-slate-300" style="background-color: #990000;"></span>
                                        <span>50–60</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 font-bold text-slate-700">
                                        <span class="w-4 h-3 rounded-xs border border-slate-300" style="background-color: #660000;"></span>
                                        <span>60+</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Two Columns Layout: Left Stat Cards + Right Rekap Table -->
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

                            <!-- Left Column (col-span-5): 2 Cards -->
                            <div class="lg:col-span-5 space-y-6">

                                <!-- Card 1: DATABASE KOPERASI -->
                                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-xs">
                                    <div class="bg-[#b47b74] text-white text-center font-bold text-xs uppercase tracking-wider py-2">
                                        {{ str_starts_with($rekapSubtab, 'rekap_ang_') ? 'DATABASE ANGGOTA' : 'DATABASE KOPERASI' }}
                                    </div>
                                    <div class="p-6 text-center space-y-4">
                                        <div>
                                            <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                                                {{ str_starts_with($rekapSubtab, 'rekap_ang_') ? 'TOTAL ANGGOTA' : 'TOTAL KOPERASI' }}
                                            </div>
                                            <div class="text-5xl font-black text-slate-800 my-1">
                                                {{ str_starts_with($rekapSubtab, 'rekap_ang_') ? number_format($totalAnggota) : $totalKoperasi }}
                                            </div>
                                            <div class="text-xs font-black text-sky-600 italic tracking-wider uppercase">
                                                KABUPATEN BOGOR
                                            </div>
                                        </div>

                                        <div class="border-t border-slate-100 pt-4 space-y-3">
                                            <div>
                                                <div class="text-xs font-extrabold text-slate-700 uppercase tracking-wider">
                                                    TERTINGGI
                                                </div>
                                                <div class="text-2xl font-black text-slate-800 my-0.5">
                                                    {{ $rekapTertinggiNilai }}
                                                </div>
                                                <div class="text-xs font-bold text-emerald-600 italic uppercase">
                                                    {{ $rekapTertinggiNama }}
                                                </div>
                                            </div>

                                            <div class="pt-2">
                                                <div class="text-xs font-extrabold text-slate-700 uppercase tracking-wider">
                                                    TERENDAH
                                                </div>
                                                <div class="text-2xl font-black text-slate-800 my-0.5">
                                                    {{ $rekapTerendahNilai }}
                                                </div>
                                                <div class="text-xs font-bold text-emerald-600 italic uppercase">
                                                    {{ $rekapTerendahNama }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 2: STATUS KOPERASI KABUPATEN BOGOR -->
                                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-xs">
                                    <div class="bg-[#b0b4b8] text-white text-center font-bold text-xs uppercase tracking-wider py-2">
                                        STATUS KOPERASI KABUPATEN BOGOR
                                    </div>
                                    <div class="p-4 space-y-2.5 text-xs">
                                        <!-- Sudah Operasional -->
                                        <div class="flex items-center justify-between py-1 border-b border-slate-100">
                                            <span class="font-bold text-slate-700 italic">SUDAH OPERASIONAL</span>
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-slate-800">{{ $opsSudah }} Koperasi</span>
                                                <span class="bg-[#10b981] text-white font-bold text-[11px] px-2 py-0.5 rounded shadow-xs">{{ $opsSudahPersen }} %</span>
                                            </div>
                                        </div>

                                        <!-- Belum Operasional -->
                                        <div class="flex items-center justify-between py-1 border-b border-slate-100">
                                            <span class="font-bold text-slate-700 italic">BELUM OPERASIONAL</span>
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-slate-800">{{ $opsBelum }} Koperasi</span>
                                                <span class="bg-slate-100 text-slate-500 font-bold text-[11px] px-2 py-0.5 rounded border border-slate-200">{{ $opsBelumPersen }} %</span>
                                            </div>
                                        </div>

                                        <!-- Sudah Pelatihan -->
                                        <div class="flex items-center justify-between py-1 border-b border-slate-100">
                                            <span class="font-bold text-slate-700 italic">SUDAH PELATIHAN</span>
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-slate-800">{{ $latihSudah }} Koperasi</span>
                                                <span class="bg-sky-500 text-white font-bold text-[11px] px-2 py-0.5 rounded shadow-xs">{{ $latihSudahPersen }} %</span>
                                            </div>
                                        </div>

                                        <!-- Sebagian Pelatihan -->
                                        <div class="flex items-center justify-between py-1 border-b border-slate-100">
                                            <span class="font-bold text-slate-700 italic">SEBAGIAN PELATIHAN</span>
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-slate-800">{{ $latihSebagian }} Koperasi</span>
                                                <span class="bg-slate-100 text-slate-400 font-bold text-[11px] px-2 py-0.5 rounded border border-slate-200">{{ number_format($latihSebagianPersen, 2) }} %</span>
                                            </div>
                                        </div>

                                        <!-- Belum Pelatihan -->
                                        <div class="flex items-center justify-between py-1 border-b border-slate-100">
                                            <span class="font-bold text-slate-700 italic">BELUM PELATIHAN</span>
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-slate-800">{{ $latihBelum }} Koperasi</span>
                                                <span class="bg-[#e11d48] text-white font-bold text-[11px] px-2 py-0.5 rounded shadow-xs">{{ $latihBelumPersen }} %</span>
                                            </div>
                                        </div>

                                        <!-- Sudah Sertifikat -->
                                        <div class="flex items-center justify-between py-1 border-b border-slate-100">
                                            <span class="font-bold text-slate-700 italic">SUDAH SERTIFIKAT</span>
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-slate-800">{{ $sertifikatSudah }} Koperasi</span>
                                                <span class="bg-[#10b981] text-white font-bold text-[11px] px-2 py-0.5 rounded shadow-xs">{{ $sertifikatSudahPersen }} %</span>
                                            </div>
                                        </div>

                                        <!-- Belum Sertifikat -->
                                        <div class="flex items-center justify-between py-1">
                                            <span class="font-bold text-slate-700 italic">BELUM SERTIFIKAT</span>
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-slate-800">{{ $sertifikatBelum }} Koperasi</span>
                                                <span class="bg-slate-100 text-slate-500 font-bold text-[11px] px-2 py-0.5 rounded border border-slate-200">{{ $sertifikatBelumPersen }} %</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Right Column (col-span-7): Table KOPERASI BERDASARKAN WILAYAH -->
                            <div class="lg:col-span-7">
                                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-xs">
                                    <div class="bg-[#78b5d3] text-white text-center font-bold text-xs uppercase tracking-wider py-2">
                                        {{ str_starts_with($rekapSubtab, 'rekap_ang_') ? 'ANGGOTA BERDASARKAN WILAYAH' : 'KOPERASI BERDASARKAN WILAYAH' }}
                                    </div>

                                    <div class="p-4 space-y-4">
                                        <!-- Controls: Show entries & Search -->
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs">
                                            <div class="flex items-center gap-1.5 font-bold text-slate-600">
                                                <span>Show</span>
                                                <select id="rekapPageSize" onchange="changeRekapPageSize(this.value)" class="border border-slate-300 rounded px-2 py-1 bg-white focus:outline-none focus:ring-1 focus:ring-sky-500">
                                                    <option value="10">10</option>
                                                    <option value="25" selected>25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                            </div>

                                            <div class="flex items-center gap-1.5 font-bold text-slate-600">
                                                <span>Search:</span>
                                                <input type="text" id="rekapSearchInput" oninput="onRekapSearch(this.value)" placeholder="Cari wilayah..." class="border border-slate-300 rounded px-2.5 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-sky-500 w-48">
                                            </div>
                                        </div>

                                        <!-- Table Area -->
                                        <div class="overflow-x-auto border border-slate-200 rounded-lg">
                                            <table class="w-full text-xs text-left" id="rekapTable">
                                                <thead class="bg-slate-50 text-slate-700 font-extrabold uppercase tracking-wider border-b border-slate-200">
                                                    <tr>
                                                        <th class="py-2.5 px-3 cursor-pointer select-none hover:bg-slate-100" onclick="sortRekap('name')">
                                                            <div class="flex items-center justify-between">
                                                                <span>{{ in_array($rekapSubtab, ['rekap_kop_kec', 'rekap_ang_kec']) ? 'KECAMATAN' : 'DESA/KELURAHAN' }}</span>
                                                                <span class="text-slate-400">⇅</span>
                                                            </div>
                                                        </th>
                                                        <th class="py-2.5 px-3 text-center cursor-pointer select-none hover:bg-slate-100" onclick="sortRekap('jum')">
                                                            <div class="flex items-center justify-center gap-1">
                                                                <span>{{ str_starts_with($rekapSubtab, 'rekap_ang_') ? 'JUM ANGGOTA' : 'JUM KOPERASI' }}</span>
                                                                <span class="text-slate-400">⇅</span>
                                                            </div>
                                                        </th>
                                                        <th class="py-2.5 px-3 text-center cursor-pointer select-none hover:bg-slate-100" onclick="sortRekap('sudah_ops')">
                                                            <div class="flex items-center justify-center gap-1">
                                                                <span>SUDAH OPS</span>
                                                                <span class="text-slate-400">⇅</span>
                                                            </div>
                                                        </th>
                                                        <th class="py-2.5 px-3 text-center cursor-pointer select-none hover:bg-slate-100" onclick="sortRekap('belum_ops')">
                                                            <div class="flex items-center justify-center gap-1">
                                                                <span>BELUM OPS</span>
                                                                <span class="text-slate-400">⇅</span>
                                                            </div>
                                                        </th>
                                                        <th class="py-2.5 px-3 text-center cursor-pointer select-none hover:bg-slate-100" onclick="sortRekap('sudah_sertifikat')">
                                                            <div class="flex items-center justify-center gap-1">
                                                                <span>SUDAH SERTIFIKAT</span>
                                                                <span class="text-slate-400">⇅</span>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="rekapTableBody" class="divide-y divide-slate-100 text-slate-800">
                                                    <!-- Dynamic rows rendered by JS -->
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Table Footer: info, Export & Pagination -->
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs pt-1">
                                            <div id="rekapTableInfo" class="font-medium text-slate-600">
                                                Showing 1 to 25 of 435 entries
                                            </div>

                                            <div class="flex items-center gap-2">
                                                <button type="button" onclick="exportRekapExcel()" class="bg-white hover:bg-slate-50 border border-slate-300 text-slate-700 px-3 py-1 rounded font-bold shadow-2xs transition cursor-pointer">
                                                    Excel
                                                </button>
                                                <button type="button" onclick="printRekapTable()" class="bg-white hover:bg-slate-50 border border-slate-300 text-slate-700 px-3 py-1 rounded font-bold shadow-2xs transition cursor-pointer">
                                                    Cetak
                                                </button>
                                            </div>

                                            <div id="rekapPagination" class="flex items-center space-x-1 font-bold text-slate-700 select-none">
                                                <!-- Pagination buttons rendered by JS -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @else
                        <!-- ================= VIEW: INFORMASI KOPERASI SUMMARY (ORIGINAL) ================= -->

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
                    @endif

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
                                                        <div class="flex items-center justify-between py-1.5">
                                                            <span class="font-black text-slate-700 tracking-wider uppercase text-[11px]">SIMPANAN POKOK</span>
                                                            <span class="font-bold text-slate-800">Rp {{ number_format($kop->jum_sim_pokok ?? 0, 0, ',', '.') }}</span>
                                                        </div>
                                                        <div class="flex items-center justify-between py-1.5">
                                                            <span class="font-black text-slate-700 tracking-wider uppercase text-[11px]">SIMPANAN WAJIB</span>
                                                            <span class="font-bold text-slate-800">Rp {{ number_format($kop->jum_sim_wajib ?? 0, 0, ',', '.') }}</span>
                                                        </div>
                                                        <div class="flex items-center justify-between py-1.5">
                                                            <span class="font-black text-slate-700 tracking-wider uppercase text-[11px]">WEBSITE</span>
                                                            <span class="font-bold text-sky-600 truncate max-w-[200px]">{{ $kop->kop_web ?: '-' }}</span>
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
                        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-2xl max-h-[85vh] flex flex-col overflow-hidden my-auto transform transition-all animate-in fade-in zoom-in-95 duration-200">
                            <!-- Modal Header -->
                            <div class="px-6 py-4 bg-gradient-to-r from-sky-700 to-sky-800 text-white flex items-center justify-between shrink-0">
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-plus-circle text-base text-sky-200"></i>
                                    <h3 class="text-base font-extrabold tracking-wide uppercase">Tambah Data Koperasi Baru</h3>
                                </div>
                                <button type="button" onclick="closeTambahModal()" class="text-white/80 hover:text-white cursor-pointer">
                                    <i class="fa-solid fa-xmark text-lg"></i>
                                </button>
                            </div>

                            <!-- Modal Body / Form -->
                            <form action="{{ route('admin.koperasi.store') }}" method="POST" class="flex flex-col flex-1 min-h-0 overflow-hidden">
                                @csrf

                                <div class="p-6 space-y-4 overflow-y-auto flex-1 min-h-0">

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

                                </div>

                                <!-- Form Actions -->
                                <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-200 flex items-center justify-end space-x-2 shrink-0">
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
                        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-3xl max-h-[85vh] flex flex-col overflow-hidden my-auto transform transition-all animate-in fade-in zoom-in-95 duration-200">
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
                            <form id="formEditKoperasi" method="POST" class="flex flex-col flex-1 min-h-0 overflow-hidden">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="has_types_input" value="1">

                                <!-- Scrollable Form Content -->
                                <div class="p-6 space-y-5 overflow-y-auto flex-1 min-h-0">

                                <!-- SECTION 1: IDENTITAS & WILAYAH -->
                                <div class="space-y-3 pb-3 border-b border-slate-100">
                                    <h4 class="text-xs font-bold text-slate-700">Identitas & Wilayah Koperasi</h4>

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

                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-700">Alamat Kantor Koperasi</label>
                                        <input type="text" name="kop_addr" id="edit_kop_addr" placeholder="Alamat lengkap kantor..."
                                               class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <div class="space-y-1">
                                            <label class="text-xs font-bold text-slate-700">Kategori Koperasi</label>
                                            <input type="text" name="cat_koperasi" id="edit_cat_koperasi" placeholder="KOPERASI DESA"
                                                   class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                                        </div>
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
                                </div>

                                <!-- SECTION 2: LEGALITAS & STATUS -->
                                <div class="space-y-3 pb-3 border-b border-slate-100">
                                    <h4 class="text-xs font-bold text-slate-700">Legalitas & Status Operasional</h4>

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
                                </div>

                                <!-- SECTION 3: KELEMBAGAAN & FINANSIAL -->
                                <div class="space-y-3 pb-3 border-b border-slate-100">
                                    <h4 class="text-xs font-bold text-slate-700">Kelembagaan & Finansial (Simpanan)</h4>

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

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div class="space-y-1">
                                            <label class="text-xs font-bold text-slate-700">Simpanan Pokok (Rp)</label>
                                            <input type="number" name="jum_sim_pokok" id="edit_jum_sim_pokok" min="0" step="1000" placeholder="Contoh: 50000"
                                                   class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 font-mono">
                                        </div>

                                        <div class="space-y-1">
                                            <label class="text-xs font-bold text-slate-700">Simpanan Wajib (Rp)</label>
                                            <input type="number" name="jum_sim_wajib" id="edit_jum_sim_wajib" min="0" step="1000" placeholder="Contoh: 10000"
                                                   class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 font-mono">
                                        </div>
                                    </div>
                                </div>

                                <!-- SECTION 4: KONTAK, WEBSITE & MEDIA SOSIAL -->
                                <div class="space-y-3 pb-3 border-b border-slate-100">
                                    <h4 class="text-xs font-bold text-slate-700">Kontak, Website & Media Sosial</h4>

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
                                            <label class="text-xs font-bold text-slate-700">Website Resmi</label>
                                            <input type="text" name="kop_web" id="edit_kop_web" placeholder="namadesa.kop.id"
                                                   class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                                        <div class="space-y-1">
                                            <label class="text-[11px] font-bold text-slate-600 flex items-center space-x-1">
                                                <i class="fa-brands fa-facebook text-blue-600"></i>
                                                <span>Facebook</span>
                                            </label>
                                            <input type="text" name="media_fb" id="edit_media_fb" placeholder="Username/Link"
                                                   class="w-full px-2.5 py-1.5 text-xs border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500">
                                        </div>

                                        <div class="space-y-1">
                                            <label class="text-[11px] font-bold text-slate-600 flex items-center space-x-1">
                                                <i class="fa-brands fa-instagram text-pink-600"></i>
                                                <span>Instagram</span>
                                            </label>
                                            <input type="text" name="media_ig" id="edit_media_ig" placeholder="@username"
                                                   class="w-full px-2.5 py-1.5 text-xs border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500">
                                        </div>

                                        <div class="space-y-1">
                                            <label class="text-[11px] font-bold text-slate-600 flex items-center space-x-1">
                                                <i class="fa-brands fa-youtube text-red-600"></i>
                                                <span>YouTube</span>
                                            </label>
                                            <input type="text" name="media_yt" id="edit_media_yt" placeholder="Channel"
                                                   class="w-full px-2.5 py-1.5 text-xs border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500">
                                        </div>

                                        <div class="space-y-1">
                                            <label class="text-[11px] font-bold text-slate-600 flex items-center space-x-1">
                                                <i class="fa-brands fa-x-twitter text-slate-800"></i>
                                                <span>Twitter / X</span>
                                            </label>
                                            <input type="text" name="media_x" id="edit_media_x" placeholder="@username"
                                                   class="w-full px-2.5 py-1.5 text-xs border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500">
                                        </div>

                                        <div class="space-y-1 col-span-2 sm:col-span-1">
                                            <label class="text-[11px] font-bold text-slate-600 flex items-center space-x-1">
                                                <i class="fa-brands fa-tiktok text-slate-900"></i>
                                                <span>TikTok</span>
                                            </label>
                                            <input type="text" name="media_tiktok" id="edit_media_tiktok" placeholder="@username"
                                                   class="w-full px-2.5 py-1.5 text-xs border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500">
                                        </div>
                                    </div>
                                </div>

                                <!-- SECTION 5: 13 GERAI / UNIT USAHA TERDAFTAR -->
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-xs font-bold text-slate-700">13 Gerai / Unit Usaha Terdaftar</h4>
                                        <span class="text-[11px] text-slate-400 font-medium">Centang usaha yang aktif</span>
                                    </div>

                                    @php
                                        $daftarGerai13 = [
                                            1 => ['nama' => 'Gerai Sembako', 'icon' => 'fa-store'],
                                            2 => ['nama' => 'Gerai Apotek Desa', 'icon' => 'fa-prescription-bottle-medical'],
                                            3 => ['nama' => 'Gerai Kantor Koperasi', 'icon' => 'fa-building-columns'],
                                            4 => ['nama' => 'Unit Usaha Simpan Pinjam', 'icon' => 'fa-hand-holding-dollar'],
                                            5 => ['nama' => 'Gerai Klinik Desa', 'icon' => 'fa-kit-medical'],
                                            6 => ['nama' => 'Gerai Cold Storage', 'icon' => 'fa-snowflake'],
                                            7 => ['nama' => 'Gerai Logistik (Distribusi)', 'icon' => 'fa-truck-ramp-box'],
                                            8 => ['nama' => 'Gerai Usaha Lainnya (KBLI)', 'icon' => 'fa-boxes-stacked'],
                                            9 => ['nama' => 'Gerai Kios Pupuk', 'icon' => 'fa-seedling'],
                                            10 => ['nama' => 'Gerai Pangkalan LPG', 'icon' => 'fa-fire-flame-simple'],
                                            11 => ['nama' => 'Gerai Agen Pos Indonesia', 'icon' => 'fa-envelope-open-text'],
                                            12 => ['nama' => 'Gerai Agen Laku Pandai', 'icon' => 'fa-wallet'],
                                            13 => ['nama' => 'Akun Microsite', 'icon' => 'fa-globe'],
                                        ];
                                    @endphp

                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2.5 p-3 bg-slate-50/80 rounded-xl border border-slate-200">
                                        @foreach($daftarGerai13 as $nomor => $g)
                                            <label class="flex items-center space-x-2 p-2 rounded-lg bg-white border border-slate-200/80 hover:border-sky-300 hover:bg-sky-50/40 transition cursor-pointer select-none text-xs">
                                                <input type="checkbox" name="id_koperasitype{{ $nomor }}" id="edit_id_koperasitype{{ $nomor }}" value="Yes"
                                                       class="w-4 h-4 text-sky-600 rounded border-slate-300 focus:ring-sky-500 cursor-pointer">
                                                <i class="fa-solid {{ $g['icon'] }} text-slate-500 text-[11px] w-4 text-center"></i>
                                                <span class="text-[11px] font-bold text-slate-700 truncate">{{ $g['nama'] }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Pinned Form Actions -->
                                <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-200 flex items-center justify-end space-x-2 shrink-0">
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
                    <div class="space-y-6">
                        <!-- Top Header Section matching other database tabs -->
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                            <div>
                                <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">
                                    DATABASE PENGURUS
                                </h1>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mt-0.5">
                                    {{ $user->isSuperAdmin() ? 'KABUPATEN BOGOR' : ($user->kecamatan?->name_kopkec ?? 'KABUPATEN BOGOR') }}
                                </p>
                            </div>

                            <!-- Right Badge -->
                            <div class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white border border-slate-200 text-slate-700 text-xs font-bold shadow-xs">
                                <i class="fa-solid fa-users text-[#0284c7] text-xs"></i>
                                <span>Manajemen SDM Pengurus & Pengawas</span>
                            </div>
                        </div>

                        <!-- Main Content Box -->
                        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-5">
                            <!-- VIEW 1: DATA TABLE PENGURUS (Foto 1) -->
                            <div id="pengurusTableView" class="space-y-4">
                                <form id="formFilterPengurus" action="{{ route('admin.dashboard') }}" method="GET">
                                    <input type="hidden" name="tab" value="pengurus">

                                    <!-- Top Cascading Dropdowns: -- KECAMATAN -- and -- DESA/KEL -- -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div class="space-y-1">
                                            <label class="block text-[11px] font-black text-slate-700 uppercase tracking-wider">KECAMATAN</label>
                                            <div class="relative">
                                                <select name="filter_kec_pengurus" id="filter_kec_pengurus" onchange="onPengurusKecChange(this.value)"
                                                        class="w-full appearance-none px-4 py-2.5 text-xs font-bold text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 cursor-pointer shadow-xs">
                                                    <option value="">-- KECAMATAN --</option>
                                                    @foreach($kecamatans as $kec)
                                                        <option value="{{ $kec->id_kopkec }}" {{ (string) request('filter_kec_pengurus') === (string) $kec->id_kopkec ? 'selected' : '' }}>
                                                            {{ strtoupper($kec->name_kopkec) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
                                            </div>
                                        </div>

                                        <div class="space-y-1">
                                            <label class="block text-[11px] font-black text-slate-700 uppercase tracking-wider">DESA / KELURAHAN</label>
                                            <div class="relative">
                                                <select name="filter_kel_pengurus" id="filter_kel_pengurus" onchange="this.form.submit()"
                                                        class="w-full appearance-none px-4 py-2.5 text-xs font-bold text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 cursor-pointer shadow-xs">
                                                    <option value="">-- DESA/KEL --</option>
                                                    @if(request('filter_kec_pengurus') && ($selectedKecPengurus = $kecamatans->firstWhere('id_kopkec', request('filter_kec_pengurus'))))
                                                        @foreach($selectedKecPengurus->kelurahans as $kel)
                                                            <option value="{{ $kel->id_kopkel }}" {{ (string) request('filter_kel_pengurus') === (string) $kel->id_kopkel ? 'selected' : '' }}>
                                                                {{ strtoupper($kel->name_kopkel) }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Controls Bar: Show entries & Search -->
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-1 text-xs text-slate-600">
                                        <div class="flex items-center space-x-1.5 text-xs text-slate-500 font-medium">
                                            <span class="text-[11px] font-bold text-slate-400 uppercase">Show</span>
                                            <div class="relative">
                                                <select name="per_page_pengurus" onchange="this.form.submit()"
                                                        class="appearance-none pr-7 pl-2.5 py-1.5 text-xs font-bold text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 cursor-pointer shadow-xs">
                                                    <option value="10" {{ ($perPagePengurus ?? 25) == 10 ? 'selected' : '' }}>10</option>
                                                    <option value="25" {{ ($perPagePengurus ?? 25) == 25 ? 'selected' : '' }}>25</option>
                                                    <option value="50" {{ ($perPagePengurus ?? 25) == 50 ? 'selected' : '' }}>50</option>
                                                    <option value="100" {{ ($perPagePengurus ?? 25) == 100 ? 'selected' : '' }}>100</option>
                                                </select>
                                                <i class="fa-solid fa-chevron-down absolute right-2.5 top-1/2 -translate-y-1/2 text-[9px] text-slate-400 pointer-events-none"></i>
                                            </div>
                                            <span class="text-xs text-slate-500">entries</span>
                                        </div>

                                        <div class="relative w-full sm:w-72">
                                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                            <input type="text" name="search_pengurus" value="{{ request('search_pengurus') }}"
                                                   onkeydown="if(event.key==='Enter'){this.form.submit();}"
                                                   placeholder="Search nama, jabatan, koperasi..."
                                                   class="w-full pl-9 pr-8 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 bg-white placeholder-slate-400 shadow-xs font-medium text-slate-800">
                                            @if(request('search_pengurus'))
                                                <a href="{{ route('admin.dashboard', array_merge(request()->except('search_pengurus'), ['tab' => 'pengurus'])) }}"
                                                   class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </form>

                                <!-- Table: # | KOPERASI | NAMA | JABATAN | KATEGORI | URUTAN | KETERANGAN | PROSES -->
                                <div class="overflow-x-auto w-full max-w-full rounded-xl border border-slate-200/90">
                                    <table class="w-full text-left text-xs border-collapse">
                                        <thead class="bg-slate-50/90 text-slate-600 font-extrabold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                                            <tr>
                                                <th class="py-3 px-3 text-center border-r border-slate-200 w-12 font-bold text-slate-500">
                                                    <div class="flex items-center justify-center gap-1 cursor-pointer select-none">
                                                        <span>#</span>
                                                        <i class="fa-solid fa-sort text-[10px] text-slate-400"></i>
                                                    </div>
                                                </th>
                                                <th class="py-3 px-3 border-r border-slate-200 font-extrabold text-slate-700">
                                                    <div class="flex items-center justify-between cursor-pointer select-none">
                                                        <span>KOPERASI</span>
                                                        <i class="fa-solid fa-sort text-[10px] text-slate-400"></i>
                                                    </div>
                                                </th>
                                                <th class="py-3 px-3 border-r border-slate-200 font-extrabold text-slate-700">
                                                    <div class="flex items-center justify-between cursor-pointer select-none">
                                                        <span>NAMA</span>
                                                        <i class="fa-solid fa-sort text-[10px] text-slate-400"></i>
                                                    </div>
                                                </th>
                                                <th class="py-3 px-3 border-r border-slate-200 font-extrabold text-slate-700">
                                                    <div class="flex items-center justify-between cursor-pointer select-none">
                                                        <span>JABATAN</span>
                                                        <i class="fa-solid fa-sort text-[10px] text-slate-400"></i>
                                                    </div>
                                                </th>
                                                <th class="py-3 px-3 border-r border-slate-200 font-extrabold text-slate-700">
                                                    <div class="flex items-center justify-between cursor-pointer select-none">
                                                        <span>KATEGORI</span>
                                                        <i class="fa-solid fa-sort text-[10px] text-slate-400"></i>
                                                    </div>
                                                </th>
                                                <th class="py-3 px-3 border-r border-slate-200 font-extrabold text-slate-700 w-20 text-center">
                                                    <div class="flex items-center justify-center gap-1 cursor-pointer select-none">
                                                        <span>URUTAN</span>
                                                        <i class="fa-solid fa-sort text-[10px] text-slate-400"></i>
                                                    </div>
                                                </th>
                                                <th class="py-3 px-3 border-r border-slate-200 font-extrabold text-slate-700">
                                                    <div class="flex items-center justify-between cursor-pointer select-none">
                                                        <span>KETERANGAN</span>
                                                        <i class="fa-solid fa-sort text-[10px] text-slate-400"></i>
                                                    </div>
                                                </th>
                                                <th class="py-3 px-3 text-center font-extrabold text-slate-700 w-28">
                                                    <div class="flex items-center justify-center gap-1 cursor-pointer select-none">
                                                        <span>PROSES</span>
                                                        <i class="fa-solid fa-sort text-[10px] text-slate-400"></i>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100 text-slate-700">
                                            @forelse($penguruses as $sdm)
                                                <tr class="hover:bg-sky-50/40 transition">
                                                    <td class="py-3 px-3 text-center border-r border-slate-100 font-bold text-slate-500 text-[11px]">
                                                        {{ $loop->iteration + ($penguruses->currentPage() - 1) * $penguruses->perPage() }}
                                                    </td>
                                                    <td class="py-3 px-3 border-r border-slate-100 font-extrabold text-slate-900 uppercase text-xs leading-snug">
                                                        {{ $sdm->koperasi?->name_koperasi ?? '-' }}
                                                    </td>
                                                    <td class="py-3 px-3 border-r border-slate-100 font-black text-slate-900 uppercase text-xs tracking-tight">
                                                        {{ $sdm->name_kopsdm }}
                                                    </td>
                                                    <td class="py-3 px-3 border-r border-slate-100 font-bold text-slate-700 uppercase text-[11px] tracking-wider">
                                                        {{ $sdm->jab_kopsdm }}
                                                    </td>
                                                    <td class="py-3 px-3 border-r border-slate-100 font-extrabold uppercase tracking-wider text-[11px] {{ strtoupper($sdm->type_kopsdm) === 'PENGURUS' ? 'text-sky-700' : 'text-emerald-700' }}">
                                                        {{ $sdm->type_kopsdm }}
                                                    </td>
                                                    <td class="py-3 px-3 border-r border-slate-100 font-bold text-slate-700 text-xs text-center">
                                                        {{ $sdm->order_kopsdm ?? '-' }}
                                                    </td>
                                                    <td class="py-3 px-3 border-r border-slate-100 font-medium text-slate-600 uppercase text-[11px]">
                                                        {{ ($sdm->comt_kopsdm && $sdm->comt_kopsdm !== '-') ? $sdm->comt_kopsdm : '-' }}
                                                    </td>
                                                    <td class="py-3 px-3 text-center whitespace-nowrap">
                                                        <div class="flex flex-col gap-1 items-center justify-center">
                                                            <button type="button"
                                                                    onclick="openEditPengurus({{ json_encode([
                                                                        'id_kopsdm' => $sdm->id_kopsdm,
                                                                        'name_kopsdm' => $sdm->name_kopsdm,
                                                                        'id_koperasi' => $sdm->id_koperasi,
                                                                        'id_kec' => $sdm->koperasi?->id_kec,
                                                                        'jab_kopsdm' => $sdm->jab_kopsdm,
                                                                        'type_kopsdm' => $sdm->type_kopsdm,
                                                                        'order_kopsdm' => $sdm->order_kopsdm,
                                                                        'comt_kopsdm' => $sdm->comt_kopsdm,
                                                                    ]) }})"
                                                                    class="w-16 py-1 px-2 text-[11px] font-bold text-white bg-[#0284c7] hover:bg-[#0369a1] rounded-lg shadow-2xs transition active:scale-95 cursor-pointer">
                                                                Update
                                                            </button>
                                                            <button type="button"
                                                                    onclick="confirmDeletePengurus({{ $sdm->id_kopsdm }}, '{{ addslashes($sdm->name_kopsdm) }}')"
                                                                    class="w-16 py-1 px-2 text-[11px] font-bold text-white bg-rose-600 hover:bg-rose-700 rounded-lg shadow-2xs transition active:scale-95 cursor-pointer">
                                                                Delete
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center py-8 text-slate-400 italic text-xs">
                                                        Data pengurus tidak ditemukan.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Footer Bar: Showing entries, Excel/Cetak/Tambah buttons, Pagination -->
                                <div class="flex flex-col md:flex-row items-center justify-between gap-4 pt-2 text-xs text-slate-600">
                                    <div class="text-xs text-slate-500 font-medium">
                                        Showing <strong class="font-bold text-slate-800">{{ $penguruses->firstItem() ?? 0 }}</strong> to <strong class="font-bold text-slate-800">{{ $penguruses->lastItem() ?? 0 }}</strong> of <strong class="font-bold text-slate-800">{{ number_format($penguruses->total()) }}</strong> entries
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.pengurus.export', request()->all()) }}"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 bg-white hover:bg-slate-50 transition shadow-xs">
                                            <i class="fa-regular fa-file-excel text-emerald-600"></i>
                                            <span>Excel</span>
                                        </a>
                                        <button type="button" onclick="window.print()"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 bg-white hover:bg-slate-50 transition shadow-xs cursor-pointer">
                                            <i class="fa-solid fa-print text-slate-500"></i>
                                            <span>Cetak</span>
                                        </button>
                                        <button type="button" onclick="openTambahPengurus()"
                                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-bold text-white bg-[#0284c7] hover:bg-[#0369a1] transition shadow-xs cursor-pointer">
                                            <i class="fa-solid fa-plus text-xs"></i>
                                            <span>Tambah</span>
                                        </button>
                                    </div>

                                    <div>
                                        {{ $penguruses->appends(request()->except('page'))->links() }}
                                    </div>
                                </div>
                            </div>

                            <!-- VIEW 2: EDIT DATA PENGURUS (Foto 2) -->
                            <div id="pengurusEditView" class="hidden">
                                <h2 class="text-center text-lg sm:text-xl font-black text-slate-900 uppercase mb-6 tracking-tight">
                                    EDIT DATA PENGURUS
                                </h2>

                                <form id="formEditPengurus" method="POST" action="">
                                    @csrf
                                    @method('PUT')

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-xs">
                                        <!-- Kecamatan -->
                                        <div class="space-y-1">
                                            <label class="block text-[11px] font-black text-slate-700 uppercase tracking-wider">Kecamatan</label>
                                            <select id="edit_pengurus_kec" onchange="onEditPengurusKecChange(this.value)"
                                                    class="w-full px-3.5 py-2.5 text-xs font-bold text-slate-800 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 bg-white shadow-xs">
                                                <option value="">-- Pilih Kecamatan --</option>
                                                @foreach($kecamatans as $kec)
                                                    <option value="{{ $kec->id_kopkec }}">{{ strtoupper($kec->name_kopkec) }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Nama Koperasi -->
                                        <div class="space-y-1">
                                            <label class="block text-[11px] font-black text-slate-700 uppercase tracking-wider">Nama Koperasi</label>
                                            <select name="id_koperasi" id="edit_pengurus_koperasi" required
                                                    class="w-full px-3.5 py-2.5 text-xs font-bold text-slate-800 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 bg-white shadow-xs">
                                                <option value="">-- Pilih Koperasi --</option>
                                                @foreach($allKoperasis as $kop)
                                                    <option value="{{ $kop->id_koperasi }}" data-kec="{{ $kop->id_kec }}">{{ $kop->name_koperasi }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Nama Pengurus -->
                                        <div class="space-y-1">
                                            <label class="block text-[11px] font-black text-slate-700 uppercase tracking-wider">Nama Pengurus</label>
                                            <input type="text" name="name_kopsdm" id="edit_pengurus_name" required
                                                   class="w-full px-3.5 py-2.5 text-xs font-bold text-slate-800 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 bg-white shadow-xs">
                                        </div>

                                        <!-- Jabatan -->
                                        <div class="space-y-1">
                                            <label class="block text-[11px] font-black text-slate-700 uppercase tracking-wider">Jabatan</label>
                                            <select name="jab_kopsdm" id="edit_pengurus_jab" required
                                                    class="w-full px-3.5 py-2.5 text-xs font-bold text-slate-800 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 bg-white shadow-xs">
                                                <option value="KETUA KOPERASI">KETUA KOPERASI</option>
                                                <option value="WAKIL KETUA KOPERASI">WAKIL KETUA KOPERASI</option>
                                                <option value="SEKRETARIS KOPERASI">SEKRETARIS KOPERASI</option>
                                                <option value="WAKIL SEKRETARIS">WAKIL SEKRETARIS</option>
                                                <option value="BENDAHARA KOPERASI">BENDAHARA KOPERASI</option>
                                                <option value="WAKIL BENDAHARA">WAKIL BENDAHARA</option>
                                                <option value="KETUA PENGAWAS">KETUA PENGAWAS</option>
                                                <option value="ANGGOTA PENGAWAS">ANGGOTA PENGAWAS</option>
                                                <option value="ANGGOTA PENGURUS">ANGGOTA PENGURUS</option>
                                            </select>
                                        </div>

                                        <!-- Kategori -->
                                        <div class="space-y-1">
                                            <label class="block text-[11px] font-black text-slate-700 uppercase tracking-wider">Kategori</label>
                                            <select name="type_kopsdm" id="edit_pengurus_type" required
                                                    class="w-full px-3.5 py-2.5 text-xs font-bold text-slate-800 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 bg-white shadow-xs">
                                                <option value="PENGURUS">PENGURUS</option>
                                                <option value="PENGAWAS">PENGAWAS</option>
                                            </select>
                                        </div>

                                        <!-- Keterangan -->
                                        <div class="space-y-1">
                                            <label class="block text-[11px] font-black text-slate-700 uppercase tracking-wider">Keterangan</label>
                                            <input type="text" name="comt_kopsdm" id="edit_pengurus_comt"
                                                   class="w-full px-3.5 py-2.5 text-xs font-bold text-slate-800 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 bg-white shadow-xs">
                                        </div>

                                        <!-- Urutan -->
                                        <div class="space-y-1">
                                            <label class="block text-[11px] font-black text-slate-700 uppercase tracking-wider">Urutan</label>
                                            <input type="text" name="order_kopsdm" id="edit_pengurus_order"
                                                   class="w-full px-3.5 py-2.5 text-xs font-bold text-slate-800 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 bg-white shadow-xs">
                                        </div>

                                        <div></div>
                                    </div>

                                    <!-- Form Action Buttons -->
                                    <div class="flex items-center gap-2 mt-6">
                                        <button type="submit"
                                                class="px-6 py-2.5 text-xs font-extrabold text-white bg-[#0284c7] hover:bg-[#0369a1] rounded-xl shadow-sm cursor-pointer tracking-wider uppercase transition">
                                            SIMPAN
                                        </button>
                                        <button type="button" onclick="closeEditPengurus()"
                                                class="px-5 py-2.5 text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded-xl transition cursor-pointer">
                                            Kembali
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- VIEW 3: TAMBAH DATA PENGURUS (Foto 1) -->
                            <div id="pengurusTambahView" class="hidden">
                                <h2 class="text-center text-lg sm:text-xl font-bold text-slate-700 uppercase mb-8 tracking-wider">
                                    TAMBAH DATA PENGURUS
                                </h2>

                                <form id="formTambahPengurus" method="POST" action="{{ route('admin.pengurus.store') }}">
                                    @csrf

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5 text-xs sm:text-sm">
                                        <!-- Row 1: Kecamatan & Nama Koperasi -->
                                        <div>
                                            <label class="block font-bold text-slate-700 mb-1.5">Kecamatan</label>
                                            <select id="tambah_pengurus_kec" onchange="onTambahPengurusKecChange(this.value)"
                                                    class="w-full px-3.5 py-2 text-xs sm:text-sm text-slate-700 border border-slate-300 rounded focus:outline-none focus:ring-1 focus:ring-sky-500 bg-white">
                                                <option value="">--- PILIH ---</option>
                                                @foreach($kecamatans as $kec)
                                                    <option value="{{ $kec->id_kopkec }}">{{ strtoupper($kec->name_kopkec) }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block font-bold text-slate-700 mb-1.5">Nama Koperasi</label>
                                            <select name="id_koperasi" id="tambah_pengurus_koperasi" required
                                                    class="w-full px-3.5 py-2 text-xs sm:text-sm text-slate-700 border border-slate-300 rounded focus:outline-none focus:ring-1 focus:ring-sky-500 bg-white">
                                                <option value="">--- PILIH ---</option>
                                                @foreach($allKoperasis as $kop)
                                                    <option value="{{ $kop->id_koperasi }}" data-kec="{{ $kop->id_kec }}">{{ $kop->name_koperasi }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Row 2: Nama Pengurus & Jabatan -->
                                        <div>
                                            <label class="block font-bold text-slate-700 mb-1.5">Nama Pengurus</label>
                                            <input type="text" name="name_kopsdm" required placeholder="Nama Pengurus"
                                                   class="w-full px-3.5 py-2 text-xs sm:text-sm text-slate-800 placeholder-slate-400 border border-slate-300 rounded focus:outline-none focus:ring-1 focus:ring-sky-500 bg-white">
                                        </div>

                                        <div>
                                            <label class="block font-bold text-slate-700 mb-1.5">Jabatan</label>
                                            <select name="jab_kopsdm" required
                                                    class="w-full px-3.5 py-2 text-xs sm:text-sm text-slate-700 border border-slate-300 rounded focus:outline-none focus:ring-1 focus:ring-sky-500 bg-white">
                                                <option value="">--- PILIH ---</option>
                                                <option value="KETUA KOPERASI">KETUA KOPERASI</option>
                                                <option value="WAKIL KETUA KOPERASI">WAKIL KETUA KOPERASI</option>
                                                <option value="SEKRETARIS KOPERASI">SEKRETARIS KOPERASI</option>
                                                <option value="WAKIL SEKRETARIS">WAKIL SEKRETARIS</option>
                                                <option value="BENDAHARA KOPERASI">BENDAHARA KOPERASI</option>
                                                <option value="WAKIL BENDAHARA">WAKIL BENDAHARA</option>
                                                <option value="KETUA PENGAWAS">KETUA PENGAWAS</option>
                                                <option value="ANGGOTA PENGAWAS">ANGGOTA PENGAWAS</option>
                                                <option value="ANGGOTA PENGURUS">ANGGOTA PENGURUS</option>
                                            </select>
                                        </div>

                                        <!-- Row 3: Kategori & Keterangan -->
                                        <div>
                                            <label class="block font-bold text-slate-700 mb-1.5">Kategori</label>
                                            <select name="type_kopsdm" required
                                                    class="w-full px-3.5 py-2 text-xs sm:text-sm text-slate-700 border border-slate-300 rounded focus:outline-none focus:ring-1 focus:ring-sky-500 bg-white">
                                                <option value="">--- PILIH ---</option>
                                                <option value="PENGURUS">PENGURUS</option>
                                                <option value="PENGAWAS">PENGAWAS</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block font-bold text-slate-700 mb-1.5">Keterangan</label>
                                            <input type="text" name="comt_kopsdm" placeholder="Keterangan"
                                                   class="w-full px-3.5 py-2 text-xs sm:text-sm text-slate-800 placeholder-slate-400 border border-slate-300 rounded focus:outline-none focus:ring-1 focus:ring-sky-500 bg-white">
                                        </div>

                                        <!-- Row 4: Urutan & Empty Column -->
                                        <div>
                                            <label class="block font-bold text-slate-700 mb-1.5">Urutan</label>
                                            <input type="text" name="order_kopsdm" placeholder="Urutan"
                                                   class="w-full px-3.5 py-2 text-xs sm:text-sm text-slate-800 placeholder-slate-400 border border-slate-300 rounded focus:outline-none focus:ring-1 focus:ring-sky-500 bg-white">
                                        </div>

                                        <div></div>
                                    </div>

                                    <!-- Form Action Buttons matching Foto 1 -->
                                    <div class="flex items-center gap-2 mt-6">
                                        <button type="submit"
                                                class="px-6 py-2.5 text-xs font-bold text-white bg-[#00a65a] hover:bg-[#008d4c] rounded shadow-xs cursor-pointer tracking-wider uppercase transition">
                                            SIMPAN
                                        </button>
                                        <button type="button" onclick="closeTambahPengurus()"
                                                class="px-5 py-2.5 text-xs font-medium text-slate-700 bg-[#f4f4f4] hover:bg-slate-200 border border-[#d2d6de] rounded transition cursor-pointer">
                                            Kembali
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Hidden Delete Form -->
                            <form id="formDeletePengurus" method="POST" action="" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
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

                        <!-- CARD PEMETAAN GIS KOPERASIDESA MERAH PUTIH -->
                        <div class="rounded-2xl border border-slate-200/80 bg-white overflow-hidden shadow-xs">
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

                            <!-- Row 2: Show Per Page -->
                            <div class="flex items-center gap-1.5 text-xs text-slate-500 font-medium pt-1">
                                <span class="text-[11px] font-bold text-slate-400 uppercase">TAMPILKAN</span>
                                <div class="relative">
                                    <select name="per_page_anggota" onchange="this.form.submit()"
                                            class="appearance-none pr-7 pl-2.5 py-1.5 text-xs font-bold text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 cursor-pointer shadow-xs">
                                        <option value="10" {{ ($perPageAnggota ?? 25) == 10 ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ ($perPageAnggota ?? 25) == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ ($perPageAnggota ?? 25) == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ ($perPageAnggota ?? 25) == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                    <i class="fa-solid fa-chevron-down absolute right-2.5 top-1/2 -translate-y-1/2 text-[9px] text-slate-400 pointer-events-none"></i>
                                </div>
                                <span class="text-xs text-slate-500">baris</span>
                            </div>

                            <!-- Row 3: Search Bar on the Left & Action Buttons on the Right (Sejajar) -->
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-1">
                                <!-- Left: Search Bar -->
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

                                <!-- Right: Action Buttons (Sejajar horizontal dengan Search Bar) -->
                                <div class="flex items-center flex-wrap gap-2 shrink-0">
                                    <button type="button" onclick="openTambahAnggotaModal()"
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
                                                        <button type="button" onclick="openTambahAnggotaModal()"
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

    <!-- Modal Tambah Anggota (Sesuai Referensi Sistem Asli) -->
    <div id="modalTambahAnggota" class="fixed inset-0 z-[1050] bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 max-w-2xl w-full max-h-[88vh] flex flex-col overflow-hidden my-auto transform transition-all animate-in fade-in zoom-in-95 duration-200">
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-gradient-to-r from-sky-700 to-sky-800 text-white flex items-center justify-between shrink-0">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-user-plus text-base text-sky-200"></i>
                    <h3 class="text-base font-extrabold tracking-wide uppercase">TAMBAH DATA ANGGOTA</h3>
                </div>
                <button type="button" onclick="closeTambahAnggotaModal()" class="text-white/80 hover:text-white cursor-pointer">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="{{ route('admin.anggota.store') }}" method="POST" class="flex flex-col flex-1 min-h-0 overflow-hidden">
                @csrf
                <input type="hidden" name="redirect_tab" value="anggota">

                <!-- Scrollable Body -->
                <div class="p-6 space-y-4 overflow-y-auto flex-1 min-h-0 text-xs">

                    <!-- SECTION 1: IDENTITAS -->
                    <div class="w-full py-2 px-3 bg-slate-100 text-slate-700 font-extrabold text-center text-xs tracking-wider rounded-lg uppercase">
                        IDENTITAS
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div class="space-y-1">
                            <label class="block font-bold text-slate-700">Kecamatan</label>
                            <select name="id_kec" id="anggota_id_kec" onchange="updateAnggotaKecamatan(this.value)"
                                    class="w-full px-3 py-2 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 bg-white">
                                <option value="">--- PILIH ---</option>
                                @foreach($kecamatans as $kec)
                                    <option value="{{ $kec->id_kopkec }}">{{ $kec->name_kopkec }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label class="block font-bold text-slate-700">Desa / Kelurahan</label>
                            <select name="id_kel" id="anggota_id_kel" onchange="updateAnggotaKelurahan(this.value)"
                                    class="w-full px-3 py-2 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 bg-white">
                                <option value="">--- PILIH ---</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div class="space-y-1">
                            <label class="block font-bold text-slate-700">Nama Koperasi <span class="text-rose-500">*</span></label>
                            <select name="id_koperasi" id="anggota_id_koperasi" required onchange="onSelectAnggotaKoperasi(this.value)"
                                    class="w-full px-3 py-2 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 bg-white">
                                <option value="">--- PILIH ---</option>
                                @foreach($allKoperasis ?? [] as $kop)
                                    <option value="{{ $kop->id_koperasi }}" data-kec="{{ $kop->id_kec }}" data-kel="{{ $kop->id_kel }}" data-lat="{{ $kop->gps_lat }}" data-long="{{ $kop->gps_long }}">
                                        {{ $kop->name_koperasi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label class="block font-bold text-slate-700">Nama Anggota <span class="text-rose-500">*</span></label>
                            <input type="text" name="name_kopang" id="anggota_name_kopang" required placeholder="Nama Anggota"
                                   class="w-full px-3 py-2 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div class="space-y-1">
                            <label class="block font-bold text-slate-700">Jenis Anggota</label>
                            <select name="id_kopangtype" id="anggota_id_kopangtype"
                                    class="w-full px-3 py-2 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 bg-white">
                                <option value="">--- PILIH ---</option>
                                @foreach($koperasiTypes ?? [] as $t)
                                    <option value="{{ $t->id_kopangtype }}">{{ $t->name_kopangtype }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label class="block font-bold text-slate-700">Nama Usaha</label>
                            <input type="text" name="kopang_usaha" id="anggota_kopang_usaha" placeholder="Nama Usaha"
                                   class="w-full px-3 py-2 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div class="space-y-1">
                            <label class="block font-bold text-slate-700">Alamat</label>
                            <input type="text" name="kopang_addr" id="anggota_kopang_addr" placeholder="Alamat"
                                   class="w-full px-3 py-2 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>

                        <div class="space-y-1">
                            <label class="block font-bold text-slate-700">Telpon</label>
                            <input type="text" name="kopang_telp" id="anggota_kopang_telp" placeholder="Telpon"
                                   class="w-full px-3 py-2 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="block font-bold text-slate-700">Keterangan</label>
                        <input type="text" name="comt_kopang" id="anggota_comt_kopang" placeholder="Keterangan"
                               class="w-full px-3 py-2 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>

                    <!-- SECTION 2: KOORDINAT -->
                    <div class="w-full py-2 px-3 bg-slate-100 text-slate-700 font-extrabold text-center text-xs tracking-wider rounded-lg uppercase mt-2">
                        KOORDINAT
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 items-end">
                        <div class="space-y-1">
                            <label class="block font-bold text-slate-700">GPS-Lat</label>
                            <input type="text" name="gps_lat" id="anggota_gps_lat" value="0" placeholder="0"
                                   class="w-full px-3 py-2 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 font-mono">
                        </div>

                        <div class="space-y-1">
                            <label class="block font-bold text-slate-700">GPS-Long</label>
                            <input type="text" name="gps_long" id="anggota_gps_long" value="0" placeholder="0"
                                   class="w-full px-3 py-2 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 font-mono">
                        </div>

                        <div>
                            <button type="button" onclick="cekKoordinatAnggota()"
                                    class="w-full px-3.5 py-2.5 bg-[#f59e0b] hover:bg-[#d97706] text-white font-extrabold rounded-xl shadow-xs transition flex items-center justify-center space-x-1.5 cursor-pointer">
                                <i class="fa-solid fa-location-crosshairs text-xs"></i>
                                <span>Cek Koordinat!</span>
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Pinned Footer Buttons -->
                <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-200 flex items-center space-x-2 shrink-0">
                    <button type="submit"
                            class="px-6 py-2 bg-[#10b981] hover:bg-[#059669] text-white text-xs font-black uppercase tracking-wider rounded-xl shadow-sm transition transform active:scale-95 cursor-pointer">
                        SIMPAN
                    </button>
                    <button type="button" onclick="closeTambahAnggotaModal()"
                            class="px-5 py-2 border border-slate-200 text-slate-600 bg-white hover:bg-slate-100 rounded-xl font-bold transition cursor-pointer text-xs">
                        Kembali
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

    // Modal Tambah Anggota Functions
    const allKoperasisList = @json($allKoperasis ?? []);

    function openTambahAnggotaModal() {
        document.getElementById('modalTambahAnggota')?.classList.remove('hidden');
    }

    function closeTambahAnggotaModal() {
        document.getElementById('modalTambahAnggota')?.classList.add('hidden');
    }

    function updateAnggotaKecamatan(kecId) {
        const select = document.getElementById('anggota_id_kel');
        if (select) {
            select.innerHTML = '<option value="">--- PILIH ---</option>';
            if (kecId) {
                const kec = kecamatansData.find(k => String(k.id_kopkec) === String(kecId));
                if (kec && kec.kelurahans) {
                    kec.kelurahans.forEach(kel => {
                        const opt = document.createElement('option');
                        opt.value = kel.id_kopkel;
                        opt.textContent = kel.name_kopkel;
                        select.appendChild(opt);
                    });
                }
            }
        }
        filterAnggotaKoperasiDropdown(kecId, '');
    }

    function updateAnggotaKelurahan(kelId) {
        const kecId = document.getElementById('anggota_id_kec')?.value || '';
        filterAnggotaKoperasiDropdown(kecId, kelId);
    }

    function filterAnggotaKoperasiDropdown(kecId, kelId) {
        const select = document.getElementById('anggota_id_koperasi');
        if (!select) return;

        const currentVal = select.value;
        select.innerHTML = '<option value="">--- PILIH ---</option>';

        let filtered = allKoperasisList;
        if (kecId) {
            filtered = filtered.filter(k => String(k.id_kec) === String(kecId));
        }
        if (kelId) {
            filtered = filtered.filter(k => String(k.id_kel) === String(kelId));
        }

        filtered.forEach(k => {
            const opt = document.createElement('option');
            opt.value = k.id_koperasi;
            opt.textContent = k.name_koperasi;
            opt.dataset.kec = k.id_kec || '';
            opt.dataset.kel = k.id_kel || '';
            opt.dataset.lat = k.gps_lat || '';
            opt.dataset.long = k.gps_long || '';
            if (currentVal && String(currentVal) === String(k.id_koperasi)) {
                opt.selected = true;
            }
            select.appendChild(opt);
        });
    }

    function onSelectAnggotaKoperasi(kopId) {
        if (!kopId) return;
        const kop = allKoperasisList.find(k => String(k.id_koperasi) === String(kopId));
        if (!kop) return;

        const kecSelect = document.getElementById('anggota_id_kec');
        const kelSelect = document.getElementById('anggota_id_kel');

        if (kop.id_kec && kecSelect && !kecSelect.value) {
            kecSelect.value = kop.id_kec;
            const selectKel = document.getElementById('anggota_id_kel');
            if (selectKel) {
                selectKel.innerHTML = '<option value="">--- PILIH ---</option>';
                const kec = kecamatansData.find(k => String(k.id_kopkec) === String(kop.id_kec));
                if (kec && kec.kelurahans) {
                    kec.kelurahans.forEach(kel => {
                        const opt = document.createElement('option');
                        opt.value = kel.id_kopkel;
                        opt.textContent = kel.name_kopkel;
                        if (String(kel.id_kopkel) === String(kop.id_kel)) {
                            opt.selected = true;
                        }
                        selectKel.appendChild(opt);
                    });
                }
            }
        } else if (kop.id_kel && kelSelect && !kelSelect.value) {
            kelSelect.value = kop.id_kel;
        }

        const latInput = document.getElementById('anggota_gps_lat');
        const longInput = document.getElementById('anggota_gps_long');
        if (latInput && (latInput.value === '0' || !latInput.value) && kop.gps_lat) {
            latInput.value = kop.gps_lat;
        }
        if (longInput && (longInput.value === '0' || !longInput.value) && kop.gps_long) {
            longInput.value = kop.gps_long;
        }
    }

    function cekKoordinatAnggota() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude.toFixed(6);
                    const long = position.coords.longitude.toFixed(6);
                    document.getElementById('anggota_gps_lat').value = lat;
                    document.getElementById('anggota_gps_long').value = long;
                    alert(`Koordinat GPS terdeteksi:\nLat: ${lat}\nLong: ${long}`);
                },
                (error) => {
                    const kopId = document.getElementById('anggota_id_koperasi')?.value;
                    const kop = allKoperasisList.find(k => String(k.id_koperasi) === String(kopId));
                    if (kop && kop.gps_lat && kop.gps_long) {
                        document.getElementById('anggota_gps_lat').value = kop.gps_lat;
                        document.getElementById('anggota_gps_long').value = kop.gps_long;
                        alert(`Menggunakan koordinat Koperasi ${kop.name_koperasi}:\nLat: ${kop.gps_lat}\nLong: ${kop.gps_long}`);
                    } else {
                        alert('Tidak dapat mendeteksi koordinat perangkat secara otomatis. Silakan masukkan nilai koordinat atau pilih Nama Koperasi.');
                    }
                },
                { enableHighAccuracy: true, timeout: 8000, maximumAge: 0 }
            );
        } else {
            alert('Fitur geolokasi browser tidak didukung.');
        }
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

        // Finansial
        document.getElementById('edit_jum_sim_pokok').value = kop.jum_sim_pokok ?? 0;
        document.getElementById('edit_jum_sim_wajib').value = kop.jum_sim_wajib ?? 0;

        // Website & Media Sosial
        document.getElementById('edit_kop_web').value = kop.kop_web || '';
        document.getElementById('edit_media_fb').value = (kop.media_fb && kop.media_fb !== '-') ? kop.media_fb : '';
        document.getElementById('edit_media_ig').value = (kop.media_ig && kop.media_ig !== '-') ? kop.media_ig : '';
        document.getElementById('edit_media_yt').value = (kop.media_yt && kop.media_yt !== '-') ? kop.media_yt : '';
        document.getElementById('edit_media_x').value = (kop.media_x && kop.media_x !== '-') ? kop.media_x : '';
        document.getElementById('edit_media_tiktok').value = (kop.media_tiktok && kop.media_tiktok !== '-') ? kop.media_tiktok : '';

        // 13 Jenis Usaha / Gerai
        for (let i = 1; i <= 13; i++) {
            const cb = document.getElementById(`edit_id_koperasitype${i}`);
            if (cb) {
                const val = String(kop[`id_koperasitype${i}`] || '').toLowerCase();
                cb.checked = (val === 'yes' || val === '1' || val === 'true');
            }
        }

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
            }, 350);
        } else if (selectedKecId) {
            setTimeout(() => {
                zoomToAdminKecamatan(selectedKecId, true);
            }, 300);
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
                    adminPolygonLayersMap[String(targetKec.id)] = layer;
                    adminPolygonLayersMap[cleanName] = layer;
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
                            selectAdminKecamatanFromMap(targetKec.id_kopkec);
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
        if (kecId) {
            updateDesaDropdown(kecId);
            zoomToAdminKecamatan(kecId, true);
        }
        document.getElementById('formFilterKoperasi')?.submit();
    }

    function onAdminKecamatanChange(kecId) {
        const kelSelect = document.getElementById('filter_id_kel');
        if (kelSelect) {
            kelSelect.value = '';
        }
        if (kecId) {
            updateDesaDropdown(kecId);
            zoomToAdminKecamatan(kecId, true);
        }
        document.getElementById('formFilterKoperasi')?.submit();
    }

    function onAdminDesaChange(kelId) {
        zoomToAdminDesa(kelId, true);
        document.getElementById('formFilterKoperasi')?.submit();
    }

    function renderAdminKecamatanCoops(kecId) {
        if (!adminCoopMarkerLayer || !gisKoperasisData) return;
        adminCoopMarkerLayer.clearLayers();

        if (!kecId) return;

        const coops = gisKoperasisData.filter(k => String(k.id_kec) === String(kecId));
        if (!coops.length) return;

        coops.forEach((coop) => {
            const lat = parseFloat(coop.gps_lat);
            const lng = parseFloat(coop.gps_long);
            if (isNaN(lat) || isNaN(lng) || lat === 0) return;

            const desaName = coop.kelurahan ? (coop.kelurahan.name_kopkel || '') : '';
            const kecName = coop.kecamatan ? (coop.kecamatan.name_kopkec || '') : '';

            const coopMarkerHtml = `
                <div class="relative flex items-center justify-center -translate-x-1/2 -translate-y-1/2">
                    <span class="absolute w-8 h-8 rounded-full bg-red-600/35 pointer-events-none"></span>
                    <div class="relative w-8 h-8 rounded-full bg-gradient-to-tr from-red-700 to-rose-500 border-2 border-white shadow-xl flex items-center justify-center text-white text-xs cursor-pointer hover:scale-110 transition-transform">
                        <i class="fa-solid fa-store"></i>
                    </div>
                    <div class="absolute -bottom-5 whitespace-nowrap bg-slate-900/90 text-white font-extrabold text-[9px] px-1.5 py-0.5 rounded shadow-sm border border-slate-700 pointer-events-none max-w-[120px] truncate">
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
                    popupAnchor: [0, -18]
                }),
                zIndexOffset: 1200
            });

            const popupContent = `
                <div class="p-2.5 text-xs" style="min-width: 230px;">
                    <div class="flex items-center space-x-1.5 pb-2 mb-2 border-b border-red-100">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-600"></span>
                        <span class="font-extrabold text-slate-900 text-xs uppercase leading-snug">${coop.name_koperasi}</span>
                    </div>
                    <div class="space-y-1.5 mb-2.5 text-[11px] text-slate-600">
                        <div class="flex items-start space-x-1.5">
                            <i class="fa-solid fa-location-dot text-red-500 mt-0.5 shrink-0"></i>
                            <span>Desa <strong>${desaName}</strong>, Kec. <strong>${kecName}</strong></span>
                        </div>
                        <div class="bg-red-50/70 p-2 rounded-lg border border-red-100/80 space-y-1 text-[10px]">
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
            marker.addTo(adminCoopMarkerLayer);
        });
    }

    function zoomToAdminKecamatan(kecId, openPopup = true) {
        if (!mapInstance) return;

        const legendDetail = document.getElementById('adminMapLegendDetail');

        // Jika pilih Semua Kecamatan (""): Zoom out kembali menampilkan seluruh Kabupaten Bogor
        if (!kecId) {
            if (adminCoopMarkerLayer) {
                adminCoopMarkerLayer.clearLayers();
            }
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
        const cleanKecName = (kec.name_kopkec || kec.nama || '').toUpperCase().trim();
        const targetPolygon = adminPolygonLayersMap[String(kecId)] || adminPolygonLayersMap[cleanKecName];

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

        // Tampilkan titik-titik koperasi di kecamatan terpilih pada peta
        renderAdminKecamatanCoops(kecId);

        // Animasi Zoom In Halus (Fly To) ke poligon kecamatan yang dipilih
        if (targetPolygon) {
            const bounds = targetPolygon.getBounds();
            mapInstance.flyToBounds(bounds, { padding: [40, 40], maxZoom: 14, duration: 1.2 });
        } else if (kec.latitude && kec.longitude) {
            mapInstance.flyTo([parseFloat(kec.latitude), parseFloat(kec.longitude)], 13, { duration: 1.2 });
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

    const allPengurusKoperasisList = @json($allKoperasis->map(fn($k) => ['id' => $k->id_koperasi, 'name' => $k->name_koperasi, 'id_kec' => $k->id_kec]));

    function onPengurusKecChange(kecId) {
        updateDesaDropdown(kecId, 'filter_kel_pengurus', '');
        document.getElementById('formFilterPengurus').submit();
    }

    function onEditPengurusKecChange(kecId, selectedKoperasiId = null) {
        const kopSelect = document.getElementById('edit_pengurus_koperasi');
        if (!kopSelect) return;
        kopSelect.innerHTML = '<option value="">--- PILIH ---</option>';

        const filtered = kecId
            ? allPengurusKoperasisList.filter(k => String(k.id_kec) === String(kecId))
            : allPengurusKoperasisList;

        filtered.forEach(k => {
            const opt = document.createElement('option');
            opt.value = k.id;
            opt.textContent = k.name;
            if (selectedKoperasiId && String(k.id) === String(selectedKoperasiId)) {
                opt.selected = true;
            }
            kopSelect.appendChild(opt);
        });
    }

    function onTambahPengurusKecChange(kecId, selectedKoperasiId = null) {
        const kopSelect = document.getElementById('tambah_pengurus_koperasi');
        if (!kopSelect) return;
        kopSelect.innerHTML = '<option value="">--- PILIH ---</option>';

        const filtered = kecId
            ? allPengurusKoperasisList.filter(k => String(k.id_kec) === String(kecId))
            : allPengurusKoperasisList;

        filtered.forEach(k => {
            const opt = document.createElement('option');
            opt.value = k.id;
            opt.textContent = k.name;
            if (selectedKoperasiId && String(k.id) === String(selectedKoperasiId)) {
                opt.selected = true;
            }
            kopSelect.appendChild(opt);
        });
    }

    function openEditPengurus(data) {
        const tableView = document.getElementById('pengurusTableView');
        const editView = document.getElementById('pengurusEditView');
        const tambahView = document.getElementById('pengurusTambahView');

        if (tableView) tableView.classList.add('hidden');
        if (tambahView) tambahView.classList.add('hidden');
        if (editView) editView.classList.remove('hidden');

        const form = document.getElementById('formEditPengurus');
        if (form) {
            form.action = '/admin/pengurus/' + data.id_kopsdm;
        }

        const kecSelect = document.getElementById('edit_pengurus_kec');
        if (kecSelect) {
            kecSelect.value = data.id_kec || '';
        }
        onEditPengurusKecChange(data.id_kec, data.id_koperasi);

        const nameInput = document.getElementById('edit_pengurus_name');
        if (nameInput) nameInput.value = data.name_kopsdm || '';

        const jabSelect = document.getElementById('edit_pengurus_jab');
        if (jabSelect) jabSelect.value = data.jab_kopsdm || 'KETUA KOPERASI';

        const typeSelect = document.getElementById('edit_pengurus_type');
        if (typeSelect) typeSelect.value = data.type_kopsdm || 'PENGURUS';

        const comtInput = document.getElementById('edit_pengurus_comt');
        if (comtInput) comtInput.value = data.comt_kopsdm || '-';

        const orderInput = document.getElementById('edit_pengurus_order');
        if (orderInput) orderInput.value = data.order_kopsdm || '1';

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function closeEditPengurus() {
        const tableView = document.getElementById('pengurusTableView');
        const editView = document.getElementById('pengurusEditView');
        const tambahView = document.getElementById('pengurusTambahView');

        if (editView) editView.classList.add('hidden');
        if (tambahView) tambahView.classList.add('hidden');
        if (tableView) tableView.classList.remove('hidden');

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function openTambahPengurus() {
        const tableView = document.getElementById('pengurusTableView');
        const editView = document.getElementById('pengurusEditView');
        const tambahView = document.getElementById('pengurusTambahView');

        if (tableView) tableView.classList.add('hidden');
        if (editView) editView.classList.add('hidden');
        if (tambahView) {
            tambahView.classList.remove('hidden');
            const form = document.getElementById('formTambahPengurus');
            if (form) {
                form.reset();
            }
            const defaultKec = document.getElementById('tambah_pengurus_kec')?.value;
            onTambahPengurusKecChange(defaultKec || '');
        } else {
            document.getElementById('modalTambahPengurus')?.classList.remove('hidden');
        }

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function closeTambahPengurus() {
        const tableView = document.getElementById('pengurusTableView');
        const editView = document.getElementById('pengurusEditView');
        const tambahView = document.getElementById('pengurusTambahView');

        if (tambahView) tambahView.classList.add('hidden');
        if (editView) editView.classList.add('hidden');
        if (tableView) tableView.classList.remove('hidden');

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function confirmDeletePengurus(id, name) {
        if (confirm('Apakah Anda yakin ingin menghapus data pengurus ' + name + '?')) {
            const form = document.getElementById('formDeletePengurus');
            form.action = '/admin/pengurus/' + id;
            form.submit();
        }
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
            scrollWheelZoom: false,
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
                    adminAnggotaPolygonLayersMap[String(targetKec.id)] = layer;
                    adminAnggotaPolygonLayersMap[cleanName] = layer;
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

        const cleanKecName = (kec.name_kopkec || kec.nama || '').toUpperCase().trim();
        const targetPolygon = adminAnggotaPolygonLayersMap[String(kecId)] || adminAnggotaPolygonLayersMap[cleanKecName];

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

    // Rekapitulasi Data & Logic
    const rawRekapData = @json($activeTab === 'informasi' ? (in_array($rekapSubtab ?? 'info', ['rekap_kop_kec', 'rekap_ang_kec']) ? ($rekapKecamatanData ?? []) : ($rekapDesaData ?? [])) : []);
    const rekapMode = @json($rekapSubtab ?? 'info');

    let currentRekapPage = 1;
    let rekapPageSize = 25;
    let rekapSearchQuery = '';
    let rekapSortCol = 'name';
    let rekapSortDir = 'asc';
    let filteredRekapData = [];

    let mapRekapInstance = null;
    let rekapGeoJsonLayer = null;

    function getRekapColor(val) {
        if (val > 60) return '#660000';
        if (val > 50) return '#990000';
        if (val > 25) return '#cc4c02';
        if (val > 20) return '#ec7014';
        if (val > 15) return '#fe9929';
        if (val > 10) return '#fec44f';
        if (val > 5) return '#fee391';
        return '#fff7bc';
    }

    function initMapRekap() {
        const mapEl = document.getElementById('map-rekap');
        if (!mapEl || mapRekapInstance || typeof L === 'undefined') return;

        const bogorCenter = [-6.5700, 106.8200];
        const bogorBounds = [
            [-6.8000, 106.4000],
            [-6.3000, 107.2500]
        ];

        mapRekapInstance = L.map('map-rekap', {
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

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(mapRekapInstance);

        if (window.BOGOR_KECAMATAN_GEOJSON) {
            const kecCountMap = {};
            const isAnggota = rekapMode.startsWith('rekap_ang_');
            if (rawRekapData && rawRekapData.length) {
                rawRekapData.forEach(item => {
                    const kecName = (item.nama_kecamatan || '').toUpperCase().trim();
                    const val = isAnggota ? (item.jum_anggota || 0) : (item.jum_koperasi || 0);
                    kecCountMap[kecName] = (kecCountMap[kecName] || 0) + val;
                });
            }

            rekapGeoJsonLayer = L.geoJSON(window.BOGOR_KECAMATAN_GEOJSON, {
                style: function (feature) {
                    const name = (feature.properties?.name || '').toUpperCase().trim();
                    const val = kecCountMap[name] || 1;
                    return {
                        fillColor: getRekapColor(val),
                        weight: 1.5,
                        opacity: 1,
                        color: '#ffffff',
                        dashArray: '',
                        fillOpacity: 0.85
                    };
                },
                onEachFeature: function (feature, layer) {
                    const name = feature.properties ? (feature.properties.fullName || feature.properties.name) : 'Kecamatan';
                    const cleanName = (feature.properties?.name || '').toUpperCase().trim();
                    const val = kecCountMap[cleanName] || 1;
                    const label = isAnggota ? `${val} Anggota` : `${val} Koperasi`;

                    layer.bindTooltip(`<strong>${name}</strong><br>${label}`, {
                        sticky: true,
                        direction: 'top'
                    });

                    layer.on({
                        mouseover: function (e) {
                            const l = e.target;
                            l.setStyle({
                                weight: 3,
                                color: '#0284c7',
                                fillOpacity: 0.95
                            });
                            l.bringToFront();
                        },
                        mouseout: function (e) {
                            rekapGeoJsonLayer.resetStyle(e.target);
                        },
                        click: function () {
                            const searchInput = document.getElementById('rekapSearchInput');
                            if (searchInput) {
                                searchInput.value = cleanName;
                                onRekapSearch(cleanName);
                                document.getElementById('rekapTable')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                            }
                        }
                    });
                }
            }).addTo(mapRekapInstance);

            mapRekapInstance.fitBounds(bogorBounds);
        }
    }

    function renderRekapTable() {
        const tbody = document.getElementById('rekapTableBody');
        const infoEl = document.getElementById('rekapTableInfo');
        const pagEl = document.getElementById('rekapPagination');
        if (!tbody) return;

        // Filter
        const q = rekapSearchQuery.toLowerCase().trim();
        filteredRekapData = rawRekapData.filter(item => {
            if (!q) return true;
            const desa = (item.nama_desa || '').toLowerCase();
            const kec = (item.nama_kecamatan || '').toLowerCase();
            const kop = (item.koperasi_nama || '').toLowerCase();
            return desa.includes(q) || kec.includes(q) || kop.includes(q);
        });

        // Sort
        filteredRekapData.sort((a, b) => {
            let valA, valB;
            if (rekapSortCol === 'name') {
                valA = (a.nama_desa || a.nama_kecamatan || '').toLowerCase();
                valB = (b.nama_desa || b.nama_kecamatan || '').toLowerCase();
            } else if (rekapSortCol === 'jum') {
                valA = rekapMode.startsWith('rekap_ang_') ? a.jum_anggota : a.jum_koperasi;
                valB = rekapMode.startsWith('rekap_ang_') ? b.jum_anggota : b.jum_koperasi;
            } else if (rekapSortCol === 'sudah_ops') {
                valA = a.sudah_ops;
                valB = b.sudah_ops;
            } else if (rekapSortCol === 'belum_ops') {
                valA = a.belum_ops;
                valB = b.belum_ops;
            } else if (rekapSortCol === 'sudah_sertifikat') {
                valA = a.sudah_sertifikat;
                valB = b.sudah_sertifikat;
            }
            if (valA < valB) return rekapSortDir === 'asc' ? -1 : 1;
            if (valA > valB) return rekapSortDir === 'asc' ? 1 : -1;
            return 0;
        });

        const total = filteredRekapData.length;
        const totalPages = Math.ceil(total / rekapPageSize) || 1;
        if (currentRekapPage > totalPages) currentRekapPage = totalPages;
        if (currentRekapPage < 1) currentRekapPage = 1;

        const startIdx = (currentRekapPage - 1) * rekapPageSize;
        const endIdx = Math.min(startIdx + rekapPageSize, total);
        const pageData = filteredRekapData.slice(startIdx, endIdx);

        tbody.innerHTML = '';
        if (pageData.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" class="py-6 text-center text-slate-400 font-bold">Data wilayah tidak ditemukan</td></tr>`;
        } else {
            pageData.forEach((row, i) => {
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-slate-50/80 transition-colors';

                const isKecView = ['rekap_kop_kec', 'rekap_ang_kec'].includes(rekapMode);
                const jumVal = rekapMode.startsWith('rekap_ang_') ? Number(row.jum_anggota).toLocaleString() : row.jum_koperasi;

                let col1Html = '';
                if (isKecView) {
                    col1Html = `
                        <div class="py-1">
                            <span class="font-bold text-slate-900 uppercase">${row.nama_kecamatan}</span>
                            <div class="text-[11px] text-slate-400 font-medium">${row.jum_desa || 0} Desa/Kelurahan</div>
                        </div>
                    `;
                } else {
                    col1Html = `
                        <div class="flex items-start gap-2 py-0.5">
                            <button type="button" onclick="toggleRekapChildRow(${row.id_kopkel})"
                                    class="w-4 h-4 rounded-full bg-sky-500 hover:bg-sky-600 text-white flex items-center justify-center shrink-0 mt-0.5 cursor-pointer shadow-xs transition">
                                <i class="fa-solid fa-plus text-[8px]" id="rekap-icon-${row.id_kopkel}"></i>
                            </button>
                            <div>
                                <span class="font-extrabold text-slate-900 uppercase">${row.nama_desa}</span>
                                <div class="text-[11px] font-bold text-sky-600">#${row.nama_kecamatan}</div>
                            </div>
                        </div>
                    `;
                }

                tr.innerHTML = `
                    <td class="py-2.5 px-3">${col1Html}</td>
                    <td class="py-2.5 px-3 text-center font-bold text-slate-800">${jumVal}</td>
                    <td class="py-2.5 px-3 text-center font-bold text-slate-800">${row.sudah_ops}</td>
                    <td class="py-2.5 px-3 text-center font-bold text-slate-800">${row.belum_ops}</td>
                    <td class="py-2.5 px-3 text-center font-bold text-slate-800">${row.sudah_sertifikat}</td>
                `;
                tbody.appendChild(tr);

                if (!isKecView) {
                    const childTr = document.createElement('tr');
                    childTr.id = `rekap-child-${row.id_kopkel}`;
                    childTr.className = 'hidden bg-sky-50/50';
                    childTr.innerHTML = `
                        <td colspan="5" class="py-2.5 px-6 text-xs text-slate-700 border-l-4 border-sky-400">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px]">
                                <div><strong class="text-slate-900">Nama Koperasi:</strong> ${row.koperasi_nama || '-'}</div>
                                <div><strong class="text-slate-900">Status Operasional:</strong> <span class="${row.sudah_ops ? 'text-emerald-600 font-bold' : 'text-slate-500'}">${row.sudah_ops ? 'SUDAH' : 'BELUM'}</span></div>
                                <div><strong class="text-slate-900">No AHU:</strong> ${row.no_ahu || '-'}</div>
                                <div><strong class="text-slate-900">Status Sertifikat:</strong> <span class="${row.sudah_sertifikat ? 'text-emerald-600 font-bold' : 'text-slate-500'}">${row.sudah_sertifikat ? 'SUDAH' : 'BELUM'}</span></div>
                                <div><strong class="text-slate-900">No INKOP:</strong> ${row.no_inkop || '-'}</div>
                                <div><strong class="text-slate-900">Jumlah Anggota:</strong> ${Number(row.jum_anggota || 0).toLocaleString()} orang</div>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(childTr);
                }
            });
        }

        // Info text matching screenshot: "Showing 1 to 25 of 435 entries"
        if (infoEl) {
            if (total === 0) {
                infoEl.textContent = 'Showing 0 to 0 of 0 entries';
            } else {
                infoEl.textContent = `Showing ${startIdx + 1} to ${endIdx} of ${total} entries`;
            }
        }

        // Pagination buttons
        if (pagEl) {
            pagEl.innerHTML = '';

            const prevBtn = document.createElement('button');
            prevBtn.type = 'button';
            prevBtn.textContent = 'Previous';
            prevBtn.className = `px-2.5 py-1 rounded text-xs transition ${currentRekapPage === 1 ? 'text-slate-300 cursor-not-allowed' : 'text-slate-700 hover:bg-slate-100 cursor-pointer'}`;
            prevBtn.disabled = currentRekapPage === 1;
            prevBtn.onclick = () => { if (currentRekapPage > 1) { currentRekapPage--; renderRekapTable(); } };
            pagEl.appendChild(prevBtn);

            // Render page numbers (with ellipsis if large)
            let pagesToShow = [];
            if (totalPages <= 7) {
                for (let p = 1; p <= totalPages; p++) pagesToShow.push(p);
            } else {
                pagesToShow.push(1);
                if (currentRekapPage > 3) pagesToShow.push('...');
                let start = Math.max(2, currentRekapPage - 1);
                let end = Math.min(totalPages - 1, currentRekapPage + 1);
                for (let p = start; p <= end; p++) pagesToShow.push(p);
                if (currentRekapPage < totalPages - 2) pagesToShow.push('...');
                pagesToShow.push(totalPages);
            }

            pagesToShow.forEach(p => {
                if (p === '...') {
                    const span = document.createElement('span');
                    span.className = 'px-1.5 py-1 text-slate-400 text-xs';
                    span.textContent = '...';
                    pagEl.appendChild(span);
                } else {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.textContent = p;
                    btn.className = `px-2.5 py-1 rounded text-xs transition cursor-pointer ${p === currentRekapPage ? 'bg-sky-600 text-white font-bold shadow-xs' : 'text-slate-700 hover:bg-slate-100'}`;
                    btn.onclick = () => { currentRekapPage = p; renderRekapTable(); };
                    pagEl.appendChild(btn);
                }
            });

            const nextBtn = document.createElement('button');
            nextBtn.type = 'button';
            nextBtn.textContent = 'Next';
            nextBtn.className = `px-2.5 py-1 rounded text-xs transition ${currentRekapPage === totalPages ? 'text-slate-300 cursor-not-allowed' : 'text-slate-700 hover:bg-slate-100 cursor-pointer'}`;
            nextBtn.disabled = currentRekapPage === totalPages;
            nextBtn.onclick = () => { if (currentRekapPage < totalPages) { currentRekapPage++; renderRekapTable(); } };
            pagEl.appendChild(nextBtn);
        }
    }

    function toggleRekapChildRow(id) {
        const row = document.getElementById(`rekap-child-${id}`);
        const icon = document.getElementById(`rekap-icon-${id}`);
        if (!row) return;
        const isHidden = row.classList.contains('hidden');
        if (isHidden) {
            row.classList.remove('hidden');
            if (icon) {
                icon.classList.remove('fa-plus');
                icon.classList.add('fa-minus');
            }
        } else {
            row.classList.add('hidden');
            if (icon) {
                icon.classList.remove('fa-minus');
                icon.classList.add('fa-plus');
            }
        }
    }

    function onRekapSearch(val) {
        rekapSearchQuery = val;
        currentRekapPage = 1;
        renderRekapTable();
    }

    function changeRekapPageSize(size) {
        rekapPageSize = parseInt(size, 10) || 25;
        currentRekapPage = 1;
        renderRekapTable();
    }

    function sortRekap(col) {
        if (rekapSortCol === col) {
            rekapSortDir = rekapSortDir === 'asc' ? 'desc' : 'asc';
        } else {
            rekapSortCol = col;
            rekapSortDir = 'asc';
        }
        renderRekapTable();
    }

    function exportRekapExcel() {
        if (typeof XLSX === 'undefined') {
            alert('Pustaka SheetJS belum selesai dimuat.');
            return;
        }
        const dataToExport = filteredRekapData.map((item, idx) => {
            const isKec = ['rekap_kop_kec', 'rekap_ang_kec'].includes(rekapMode);
            return {
                'No': idx + 1,
                'Wilayah': isKec ? item.nama_kecamatan : `${item.nama_desa} (#${item.nama_kecamatan})`,
                'Jumlah': rekapMode.startsWith('rekap_ang_') ? item.jum_anggota : item.jum_koperasi,
                'Sudah Operasional': item.sudah_ops,
                'Belum Operasional': item.belum_ops,
                'Sudah Sertifikat': item.sudah_sertifikat,
                'Nama Koperasi': item.koperasi_nama || '-'
            };
        });
        const ws = XLSX.utils.json_to_sheet(dataToExport);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Rekapitulasi");
        XLSX.writeFile(wb, `Rekapitulasi_${rekapMode}.xlsx`);
    }

    function printRekapTable() {
        window.print();
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

        // Initialize GIS map, Anggota map, and Rekap map after DOM settles
        setTimeout(initGisMap, 200);
        setTimeout(initMapAnggota, 250);
        setTimeout(initMapRekap, 300);
        renderRekapTable();

        setTimeout(() => {
            updateAdminKoperasiLayerGlider(activeLayerKey);
            updateAdminAnggotaLayerGlider(activeLayerAnggotaKey);
        }, 120);
    });
</script>
@endsection
