@extends('layouts.app')

@section('title', 'Dashboard KMP Kabupaten Bogor | Koperasi Desa & Kelurahan Merah Putih')

@section('content')
<div class="min-h-screen bg-slate-50 flex flex-col justify-between">

    <!-- Top Navigation Header -->
    <header class="bg-gradient-to-r from-[#881337] via-[#991b1b] to-[#7f1d1d] text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-3">
                    <div class="h-10 w-10 sm:h-11 sm:w-11 rounded-xl bg-white p-1 flex items-center justify-center shadow-md shrink-0">
                        <img src="{{ asset('images/logo-kopdeskel-clean.png') }}" alt="Logo KOP DES KEL Merah Putih" class="h-full w-auto object-contain">
                    </div>
                    <div>
                        <h1 class="text-base sm:text-lg font-bold tracking-tight text-white leading-tight">
                            Dashboard KMP Kabupaten Bogor
                        </h1>
                        <p class="text-xs text-red-200 font-medium leading-none">
                            Pemerintah Daerah Kabupaten Bogor
                        </p>
                    </div>
                </div>

                <!-- Nav Menu Links -->
                <nav class="hidden md:flex items-center space-x-1 lg:space-x-2 text-sm font-medium">
                    <a href="#beranda" class="px-3.5 py-1.5 rounded-full bg-white/15 text-white shadow-sm hover:bg-white/20 transition-all duration-200">
                        Beranda
                    </a>
                    <a href="#informasi" class="px-3.5 py-1.5 rounded-full text-red-100 hover:text-white hover:bg-white/10 transition-all duration-200">
                        Informasi
                    </a>
                    <a href="#sebaran" class="px-3.5 py-1.5 rounded-full text-red-100 hover:text-white hover:bg-white/10 transition-all duration-200">
                        Sebaran
                    </a>
                </nav>

                <!-- Actions: TA & Login -->
                <div class="flex items-center space-x-3">
                    <div class="hidden sm:flex items-center space-x-1.5 text-xs font-semibold px-3 py-1.5 rounded-full bg-black/25 text-red-100 border border-white/10">
                        <i class="fa-regular fa-calendar-check text-red-300"></i>
                        <span>TA 2025/2026</span>
                    </div>

                    <button type="button" onclick="openLoginModal()" class="flex items-center space-x-2 bg-white text-red-700 hover:bg-red-50 px-4 py-1.5 rounded-full text-xs sm:text-sm font-bold shadow transition-all duration-200 hover:shadow-md transform active:scale-95 cursor-pointer">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        <span>Login</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-grow pb-12">

        <!-- Hero Welcome Banner -->
        <section id="beranda" class="pt-8 pb-6 bg-gradient-to-b from-red-50/80 via-red-50/30 to-slate-50 border-b border-red-100/60">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-red-100/80 border border-red-200 text-red-700 text-xs font-semibold uppercase tracking-wider mb-3">
                    <i class="fa-solid fa-location-dot text-red-600"></i>
                    <span>PROVINSI JAWA BARAT | TERPADU</span>
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#991b1b] tracking-tight uppercase">
                    SELAMAT DATANG
                </h2>
                <p class="mt-2 text-sm sm:text-base text-slate-600 font-medium max-w-3xl mx-auto">
                    Dashboard Koperasi Desa / Kelurahan Merah Putih (KDKMP) Kabupaten Bogor
                </p>
            </div>
        </section>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 mt-6">

            <!-- Flash Alert Messages if any -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-circle-check text-emerald-600"></i>
                        <span class="text-sm font-semibold">{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                        <span class="text-sm font-semibold">{{ session('error') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            <!-- Section 1: Dua Card Utama (Koperasi Merah Putih & Capaian Agregat) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Left Card: Koperasi Merah Putih -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div>
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <h3 class="text-lg font-bold text-slate-800 tracking-tight">
                                Koperasi Merah Putih
                            </h3>
                            <span class="px-2.5 py-1 text-xs font-semibold bg-indigo-50 text-indigo-700 rounded-full border border-indigo-100">
                                Tentang Program
                            </span>
                        </div>

                        <p class="mt-4 text-xs sm:text-sm text-slate-600 leading-relaxed text-justify">
                            Koperasi Desa Merah Putih adalah program pemerintah yang bertujuan membentuk koperasi di tingkat desa dan kelurahan di seluruh Indonesia guna meningkatkan kesejahteraan ekonomi masyarakat melalui prinsip gotong royong dan kekeluargaan. Program ini menjadi wadah ekonomi rakyat untuk mengembangkan usaha, seperti menjual hasil pertanian, menyediakan kebutuhan pokok, dan layanan simpan pinjam, serta dapat juga mencakup layanan kesehatan dan pendidikan.
                        </p>

                        <!-- Quote Box Undang-Undang 1945 Pasal 33 -->
                        <div class="mt-4 p-3.5 rounded-xl bg-blue-50/70 border border-blue-100/80 text-xs text-blue-900 leading-relaxed relative">
                            <span class="font-bold text-blue-950">Undang-Undang 1945 Pasal 33</span> menegaskan bahwa perekonomian Indonesia disusun atas usaha bersama yang didasarkan pada asas kekeluargaan. Pada aspek konsensus kelembagaan, direncanakan mendukung 100.000 koperasi desa serentak.
                        </div>
                    </div>

                    <div class="mt-6 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                        <span>Launching Nasional: <strong class="text-slate-700">19 Juli 2025</strong></span>
                        <button type="button" onclick="openRegulasiModal()" class="text-red-600 hover:text-red-700 font-semibold inline-flex items-center space-x-1 group">
                            <span>Pelajari Regulasi</span>
                            <i class="fa-solid fa-arrow-right text-[10px] transform group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </div>
                </div>

                <!-- Right Card: Capaian Agregat Kabupaten Bogor -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div>
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div>
                                <span class="text-[10px] font-bold text-red-600 uppercase tracking-wider block">
                                    KOPERASI DESA / KELURAHAN MERAH PUTIH
                                </span>
                                <h3 class="text-lg font-bold text-slate-800 tracking-tight">
                                    Capaian Agregat Kabupaten Bogor
                                </h3>
                            </div>
                            <span class="px-2.5 py-1 text-xs font-semibold bg-emerald-50 text-emerald-700 rounded-full border border-emerald-200 flex items-center space-x-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span>435 Koperasi Terbentuk</span>
                            </span>
                        </div>

                        <!-- 2 Stats Cards -->
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <!-- Target 2025 -->
                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                                <div class="flex items-center justify-between text-xs text-slate-500">
                                    <span>Target 2025</span>
                                    <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 font-bold text-[10px]">Tercapai 100%</span>
                                </div>
                                <div class="mt-2 text-xl sm:text-2xl font-extrabold text-slate-800">
                                    {{ $totalKoperasi }} Koperasi
                                </div>
                                <p class="text-[11px] text-slate-500 mt-1 leading-snug">
                                    Total Koperasi resmi di seluruh wilayah Kab Bogor
                                </p>
                            </div>

                            <!-- Tingkat Keaktifan 2025 -->
                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                                <div class="flex items-center justify-between text-xs text-slate-500">
                                    <span>Tingkat Keaktifan 2025</span>
                                    <span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 font-bold text-[10px]">Maksimal</span>
                                </div>
                                <div class="mt-2 text-xl sm:text-2xl font-extrabold text-slate-800">
                                    100% Aktif
                                </div>
                                <p class="text-[11px] text-slate-500 mt-1 leading-snug">
                                    Seluruh 435 Koperasi memiliki gedung & anggota tetap
                                </p>
                            </div>
                        </div>

                        <!-- Jenis Fasilitas KDKMP Kabupaten Bogor -->
                        <div class="mt-4">
                            <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Jenis Fasilitas KDKMP Kabupaten Bogor:
                            </h4>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                                @foreach($fasilitas as $item)
                                    <div class="p-2.5 rounded-lg border flex items-center space-x-2.5 text-xs font-semibold {{ $item['bg'] }} transition hover:scale-[1.02]">
                                        <i class="{{ $item['icon'] }} text-sm"></i>
                                        <span class="truncate">{{ $item['nama'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                        <span>Visi Nyata Ekonomi Berdikari</span>
                        <span class="font-medium text-slate-600">Merah Putih untuk Indonesia Maju</span>
                    </div>
                </div>
            </div>

            <!-- Section 2: Informasi Koperasi Merah Putih (Potensi, Jenis Usaha, SDM Koperasi) -->
            <section id="informasi" class="space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 tracking-tight">
                            Informasi Koperasi Merah Putih
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500">
                            Data agregat potensi, diversifikasi unit usaha, dan demografi sumber daya manusia
                        </p>
                    </div>
                    <span class="self-start sm:self-auto px-3 py-1 rounded-full bg-slate-200/80 text-slate-700 font-bold text-xs border border-slate-300/60 uppercase tracking-wider">
                        DATA PROGRES PEMBANGUNAN 2025
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- Card 1: Potensi -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 flex flex-col justify-between hover:shadow-md transition">
                        <div>
                            <div class="flex items-center space-x-2 text-slate-800 font-bold text-base pb-3 border-b border-slate-100">
                                <i class="fa-solid fa-chart-pie text-red-600"></i>
                                <span>Potensi</span>
                            </div>
                            <p class="mt-3 text-xs text-slate-500 leading-relaxed">
                                Potensi Koperasi Merah Putih Kabupaten Bogor membawahi semua satuan administratif wilayah:
                            </p>

                            <!-- Mini table potensi -->
                            <div class="mt-3 border rounded-xl overflow-hidden border-slate-200 text-xs">
                                <table class="w-full text-left">
                                    <thead class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200">
                                        <tr>
                                            <th class="py-1.5 px-3">Unit</th>
                                            <th class="py-1.5 px-3 text-right">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-slate-700">
                                        <tr>
                                            <td class="py-1.5 px-3">Desa</td>
                                            <td class="py-1.5 px-3 text-right font-semibold">{{ $totalDesa }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1.5 px-3">Kelurahan</td>
                                            <td class="py-1.5 px-3 text-right font-semibold">{{ $totalKelurahan }}</td>
                                        </tr>
                                        <tr class="bg-red-50/50 font-bold text-red-900">
                                            <td class="py-1.5 px-3">Total</td>
                                            <td class="py-1.5 px-3 text-right">{{ $totalKoperasi }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pembentukan Koperasi Pertahun -->
                            <div class="mt-4">
                                <h5 class="text-xs font-bold text-slate-700 mb-1.5">Pembentukan Koperasi Pertahun</h5>
                                <div class="space-y-2 text-xs">
                                    <div>
                                        <div class="flex justify-between text-slate-600 mb-1">
                                            <span>Tahun 2023</span>
                                            <span class="font-bold text-slate-800">434 Kop (99.77%)</span>
                                        </div>
                                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                            <div class="bg-emerald-500 h-2 rounded-full" style="width: 99.77%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between text-slate-600 mb-1">
                                            <span>Tahun 2024</span>
                                            <span class="font-bold text-slate-800">1 Kop (0.23%)</span>
                                        </div>
                                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                            <div class="bg-blue-500 h-2 rounded-full" style="width: 2%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                            <span>Status Sertifikasi: OK</span>
                            <span class="font-semibold text-emerald-600">100% Selesai</span>
                        </div>
                    </div>

                    <!-- Card 2: Jenis Usaha -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 flex flex-col justify-between hover:shadow-md transition">
                        <div>
                            <div class="flex items-center space-x-2 text-slate-800 font-bold text-base pb-3 border-b border-slate-100">
                                <i class="fa-solid fa-store text-emerald-600"></i>
                                <span>Jenis Usaha</span>
                            </div>
                            <p class="mt-3 text-xs text-slate-500 leading-relaxed">
                                Rata-rata diversifikasi unit usaha Koperasi Merah Putih:
                            </p>

                            <!-- List breakdown jenis usaha with progress bars -->
                            <div class="mt-3 space-y-2.5 text-xs">
                                @foreach($jenisUsaha as $usaha)
                                    <div>
                                        <div class="flex justify-between items-center text-slate-700 mb-1">
                                            <span class="font-medium truncate pr-2">{{ $usaha['nama'] }}</span>
                                            <span class="font-bold text-slate-800 shrink-0">{{ $usaha['jumlah'] }} KMP ({{ number_format($usaha['persentase'], 2) }}%)</span>
                                        </div>
                                        <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                            <div class="{{ $usaha['color'] }} h-1.5 rounded-full" style="width: {{ min(100, max(2, $usaha['persentase'])) }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                            <span>Fasilitas Terdaftar</span>
                            <span class="font-semibold text-slate-700">250 Unit Operasional</span>
                        </div>
                    </div>

                    <!-- Card 3: SDM Koperasi -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 flex flex-col justify-between hover:shadow-md transition">
                        <div>
                            <div class="flex items-center space-x-2 text-slate-800 font-bold text-base pb-3 border-b border-slate-100">
                                <i class="fa-solid fa-users text-blue-600"></i>
                                <span>SDM Koperasi</span>
                            </div>
                            <p class="mt-3 text-xs text-slate-500 leading-relaxed">
                                Distribusi personil dan sumber daya manusia penggerak:
                            </p>

                            <!-- SDM Table -->
                            <div class="mt-3 border rounded-xl overflow-hidden border-slate-200 text-xs">
                                <table class="w-full text-left">
                                    <thead class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200">
                                        <tr>
                                            <th class="py-1.5 px-2">#</th>
                                            <th class="py-1.5 px-2">Kategori</th>
                                            <th class="py-1.5 px-2 text-right">Jumlah</th>
                                            <th class="py-1.5 px-2 text-right">(%)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-slate-700">
                                        @foreach($sdmKoperasi as $sdm)
                                            <tr>
                                                <td class="py-1.5 px-2 font-medium">{{ $sdm['no'] }}</td>
                                                <td class="py-1.5 px-2">{{ $sdm['kategori'] }}</td>
                                                <td class="py-1.5 px-2 text-right font-semibold">{{ number_format($sdm['jumlah']) }}</td>
                                                <td class="py-1.5 px-2 text-right text-slate-500">{{ $sdm['persen'] }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="bg-slate-100/80 font-bold text-slate-900">
                                            <td colspan="2" class="py-1.5 px-2">TOTAL</td>
                                            <td class="py-1.5 px-2 text-right">{{ number_format($totalSdm) }}</td>
                                            <td class="py-1.5 px-2 text-right">100%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Callout Gedung Layang Masyarakat -->
                            <div class="mt-4 p-3 rounded-xl bg-emerald-50/80 border border-emerald-200 text-xs text-emerald-900 flex items-start space-x-2.5">
                                <div class="w-7 h-7 rounded-full bg-emerald-200/80 flex items-center justify-center shrink-0 text-emerald-800 text-sm">
                                    <i class="fa-solid fa-users-gear"></i>
                                </div>
                                <div class="leading-tight">
                                    <span class="font-bold block text-emerald-950">Gedung Layang Masyarakat</span>
                                    <span class="text-[11px] text-emerald-800">Kader relawan aktif siap melayani warga desa.</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                            <span>Rata-rata Anggota / Kop</span>
                            <span class="font-semibold text-slate-700">~45 Anggota</span>
                        </div>
                    </div>

                </div>
            </section>

            <!-- Section 3: PEMETAAN GEOSPASIAL WILAYAH (Khusus Kabupaten Bogor) -->
            <section id="sebaran" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3 pb-3 border-b border-slate-100">
                    <div>
                        <span class="text-[11px] font-bold text-red-600 tracking-wider uppercase block">
                            PEMETAAN GEOSPASIAL WILAYAH
                        </span>
                        <h3 class="text-xl font-bold text-slate-800 tracking-tight">
                            Sebaran Koperasi Merah Putih Kabupaten Bogor
                        </h3>
                    </div>

                    <div class="flex flex-wrap items-center gap-2.5">
                        <span class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-full bg-slate-100 text-slate-700 text-xs font-semibold border border-slate-200">
                            <span class="w-2 h-2 rounded-full bg-red-600"></span>
                            <span>435 Kecamatan/Desa Terdata</span>
                        </span>

                        <a href="{{ route('export.rekapitulasi') }}" class="inline-flex items-center space-x-2 bg-red-700 hover:bg-red-800 text-white px-4 py-1.5 rounded-lg text-xs font-bold shadow-sm transition hover:shadow">
                            <i class="fa-solid fa-file-arrow-down"></i>
                            <span>Export ODK / XLS</span>
                        </a>
                    </div>
                </div>

                <!-- Map Filter Bar -->
                <div class="flex flex-wrap items-center justify-between gap-3 bg-slate-50 p-2.5 rounded-xl border border-slate-200/70">
                    <div class="flex flex-wrap items-center gap-2.5">
                        <!-- Dropdown Filter Kecamatan -->
                        <div class="relative inline-block">
                            <select id="kecamatanFilterSelect" onchange="zoomToKecamatan(this.value)" class="bg-white text-xs font-semibold text-slate-700 border border-slate-300 rounded-lg pl-3 pr-8 py-1.5 focus:outline-none focus:ring-2 focus:ring-red-500 cursor-pointer shadow-sm">
                                <option value="all">Kecamatan (Semua)</option>
                                @foreach($kecamatans as $item)
                                    <option value="{{ $item->id }}" {{ $item->nama === 'CISARUA' ? 'selected' : '' }}>
                                        {{ $item->nomor_urut }}. {{ $item->nama }} ({{ $item->jumlah }} Kop)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <span class="inline-flex items-center space-x-1.5 text-xs text-slate-600 font-semibold bg-white px-3 py-1.5 rounded-lg border border-slate-200 shadow-sm">
                            <i class="fa-solid fa-map-pin text-red-500"></i>
                            <span>435 Titik Koperasi Aktif</span>
                        </span>
                    </div>

                    <!-- Map Layer Switches -->
                    <div class="flex items-center space-x-1 bg-white p-1 rounded-lg border border-slate-200 shadow-sm text-xs font-semibold">
                        <button type="button" onclick="switchMapLayer('osm')" id="btnLayerOsm" class="px-3 py-1 rounded-md bg-red-600 text-white transition">
                            POS
                        </button>
                        <button type="button" onclick="switchMapLayer('satellite')" id="btnLayerSat" class="px-3 py-1 rounded-md text-slate-600 hover:text-slate-900 transition">
                            Satelit
                        </button>
                        <button type="button" onclick="switchMapLayer('topo')" id="btnLayerTopo" class="px-3 py-1 rounded-md text-slate-600 hover:text-slate-900 transition">
                            Topografi
                        </button>
                    </div>
                </div>

                <!-- Leaflet Map Container -->
                <div class="relative w-full h-[460px] rounded-xl overflow-hidden border border-slate-200 shadow-inner">
                    <div id="bogorMap" class="w-full h-full z-10"></div>

                    <!-- Custom Floating Legend -->
                    <div class="absolute bottom-3 left-3 z-[1000] bg-white/95 backdrop-blur-sm p-2.5 rounded-lg border border-slate-200 shadow-md text-[11px] text-slate-700 space-y-1">
                        <div class="font-bold text-slate-800 flex items-center space-x-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-600"></span>
                            <span>Wilayah: Kabupaten Bogor</span>
                        </div>
                        <div class="text-[10px] text-slate-500">
                            Pusat Pemerintahan: Cibinong (-6.4828, 106.8486)
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 4: Rekapitulasi Sebaran Per Kecamatan (40 Kecamatan Split Table) -->
            <section class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-3 border-b border-slate-100">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 tracking-tight">
                            Rekapitulasi Sebaran Per Kecamatan
                        </h3>
                        <p class="text-xs text-slate-500">
                            Rincian 40 Kecamatan di Kabupaten Bogor (Desa, Kelurahan, dan Titik Terbentuk)
                        </p>
                    </div>

                    <!-- Search Input -->
                    <div class="relative w-full sm:w-72">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-xs text-slate-400"></i>
                        <input
                            type="text"
                            id="tableSearchInput"
                            onkeyup="filterKecamatanTable()"
                            placeholder="Cari nama kecamatan..."
                            class="w-full pl-8 pr-3 py-1.5 text-xs border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 bg-slate-50 focus:bg-white transition"
                        >
                    </div>
                </div>

                <!-- 2 Parallel Columns Table matching screenshot -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <!-- Column 1: Kecamatan 1 - 20 -->
                    <div class="overflow-x-auto rounded-xl border border-slate-200">
                        <table class="w-full text-left text-xs" id="tableCol1">
                            <thead class="bg-slate-50 text-slate-600 font-bold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                                <tr>
                                    <th class="py-2 px-3 w-8">#</th>
                                    <th class="py-2 px-3">Kecamatan</th>
                                    <th class="py-2 px-2 text-center">Kop. Desa</th>
                                    <th class="py-2 px-2 text-center">Kop. Kel</th>
                                    <th class="py-2 px-3 text-right">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                @foreach($kecamatans->slice(0, 20) as $item)
                                    <tr id="row-kec-{{ $item->id }}"
                                        onclick="highlightAndZoom({{ $item->id }})"
                                        class="cursor-pointer transition-colors duration-150 {{ $item->nama === 'CISARUA' ? 'bg-red-50 font-semibold text-red-900 border-l-4 border-l-red-600' : 'hover:bg-slate-50' }}">
                                        <td class="py-1.5 px-3 font-semibold text-slate-500">{{ $item->nomor_urut }}</td>
                                        <td class="py-1.5 px-3 font-bold">{{ $item->nama }}</td>
                                        <td class="py-1.5 px-2 text-center font-medium">{{ $item->kop_desa }}</td>
                                        <td class="py-1.5 px-2 text-center font-medium">{{ $item->kop_kel }}</td>
                                        <td class="py-1.5 px-3 text-right font-black {{ $item->nama === 'CISARUA' ? 'text-red-700' : 'text-slate-900' }}">
                                            {{ $item->jumlah }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Column 2: Kecamatan 21 - 40 -->
                    <div class="overflow-x-auto rounded-xl border border-slate-200">
                        <table class="w-full text-left text-xs" id="tableCol2">
                            <thead class="bg-slate-50 text-slate-600 font-bold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                                <tr>
                                    <th class="py-2 px-3 w-8">#</th>
                                    <th class="py-2 px-3">Kecamatan</th>
                                    <th class="py-2 px-2 text-center">Kop. Desa</th>
                                    <th class="py-2 px-2 text-center">Kop. Kel</th>
                                    <th class="py-2 px-3 text-right">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                @foreach($kecamatans->slice(20, 20) as $item)
                                    <tr id="row-kec-{{ $item->id }}"
                                        onclick="highlightAndZoom({{ $item->id }})"
                                        class="cursor-pointer transition-colors duration-150 hover:bg-slate-50">
                                        <td class="py-1.5 px-3 font-semibold text-slate-500">{{ $item->nomor_urut }}</td>
                                        <td class="py-1.5 px-3 font-bold">{{ $item->nama }}</td>
                                        <td class="py-1.5 px-2 text-center font-medium">{{ $item->kop_desa }}</td>
                                        <td class="py-1.5 px-2 text-center font-medium">{{ $item->kop_kel }}</td>
                                        <td class="py-1.5 px-3 text-right font-black text-slate-900">
                                            {{ $item->jumlah }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Total Keseluruhan Footer Bar -->
                <div class="bg-red-50/70 border border-red-200/80 rounded-xl p-3 flex flex-col sm:flex-row items-center justify-between text-xs gap-2">
                    <span class="font-extrabold text-slate-800 uppercase tracking-wider">
                        TOTAL KESELURUHAN (KABUPATEN BOGOR)
                    </span>
                    <div class="flex items-center space-x-4 font-bold text-slate-700">
                        <span>Kop. Desa: <span class="text-red-700 font-black">{{ $totalDesa }}</span></span>
                        <span>|</span>
                        <span>Kop. Kelurahan: <span class="text-red-700 font-black">{{ $totalKelurahan }}</span></span>
                        <span>|</span>
                        <span class="text-sm text-red-700 font-extrabold">Total: {{ $totalKoperasi }} Koperasi</span>
                    </div>
                </div>
            </section>

        </div>
    </main>

    <!-- Footer Berdasarkan Referensi RAPID Pemerintah Kabupaten Bogor (Warna Senada Navbar) -->
    <footer class="bg-gradient-to-r from-[#881337] via-[#991b1b] to-[#7f1d1d] text-red-100 pt-12 pb-8 border-t border-red-950/40 shadow-inner">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
                <!-- Col 1: Brand & Narasi RAPID / KMP -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="h-11 w-11 rounded-xl bg-white p-1 flex items-center justify-center shadow-lg shrink-0">
                            <img src="{{ asset('images/logo-kopdeskel-clean.png') }}" alt="Logo KOP DES KEL" class="h-full w-auto object-contain">
                        </div>
                        <div>
                            <h4 class="text-base font-extrabold text-white tracking-wide uppercase">
                                KMP BOGOR
                            </h4>
                            <p class="text-[10px] text-red-200 font-semibold uppercase tracking-wider leading-none">
                                Koperasi Merah Putih Terpadu
                            </p>
                        </div>
                    </div>
                    <p class="text-xs text-red-100/90 leading-relaxed text-justify">
                        Memfasilitasi pemberdayaan dan kemandirian ekonomi desa/kelurahan di Kabupaten Bogor melalui penguatan kelembagaan koperasi gotong royong yang berdaya saing, modern, dan terintegrasi.
                    </p>
                    <div class="flex items-center space-x-3 pt-1">
                        <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-lg bg-white/10 border border-white/20 flex items-center justify-center text-red-100 hover:text-white hover:bg-white/20 transition">
                            <i class="fa-brands fa-instagram text-sm"></i>
                        </a>
                        <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-lg bg-white/10 border border-white/20 flex items-center justify-center text-red-100 hover:text-white hover:bg-white/20 transition">
                            <i class="fa-brands fa-facebook-f text-xs"></i>
                        </a>
                        <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-lg bg-white/10 border border-white/20 flex items-center justify-center text-red-100 hover:text-white hover:bg-white/20 transition">
                            <i class="fa-brands fa-youtube text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Col 2: Layanan -->
                <div class="space-y-3">
                    <h5 class="text-sm font-bold text-white tracking-wider">Layanan</h5>
                    <ul class="space-y-2 text-xs text-red-200/90">
                        <li>
                            <a href="#sebaran" class="hover:text-white transition flex items-center space-x-2">
                                <span>Pendaftaran Akun Koperasi</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://wa.me/628111111111" target="_blank" rel="noopener noreferrer" class="hover:text-white transition flex items-center space-x-2">
                                <span>Formulir Pengaduan</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://wa.me/628111111111" target="_blank" rel="noopener noreferrer" class="hover:text-white transition flex items-center space-x-2">
                                <span>Helpdesk & Konsultasi 24/7</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Col 3: Tautan -->
                <div class="space-y-3">
                    <h5 class="text-sm font-bold text-white tracking-wider">Tautan</h5>
                    <ul class="space-y-2 text-xs text-red-200/90">
                        <li>
                            <a href="#beranda" class="hover:text-white transition">Beranda</a>
                        </li>
                        <li>
                            <a href="#informasi" class="hover:text-white transition">Informasi Program</a>
                        </li>
                        <li>
                            <a href="#sebaran" class="hover:text-white transition">Sebaran Data 40 Kecamatan</a>
                        </li>
                        <li>
                            <button type="button" onclick="openRegulasiModal()" class="hover:text-white transition text-left cursor-pointer">Dokumen Regulasi (UU / SK)</button>
                        </li>
                        <li>
                            <a href="{{ route('export.rekapitulasi') }}" class="hover:text-white transition">Ekspor Rekapitulasi Data</a>
                        </li>
                    </ul>
                </div>

                <!-- Col 4: Kontak Kami -->
                <div class="space-y-3">
                    <h5 class="text-sm font-bold text-white tracking-wider">Kontak Kami</h5>
                    <div class="space-y-3 text-xs text-red-100/90">
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-white/10 border border-white/20 flex items-center justify-center shrink-0 text-white mt-0.5">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <span class="leading-relaxed">Jl. Tegar Beriman No.1, Pakansari, Kec. Cibinong, Kabupaten Bogor, Jawa Barat 16914</span>
                        </div>

                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-white/10 border border-white/20 flex items-center justify-center shrink-0 text-white">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <span>(021) 8758605</span>
                        </div>

                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-white/10 border border-white/20 flex items-center justify-center shrink-0 text-white">
                                <i class="fa-regular fa-envelope"></i>
                            </div>
                            <span>diskop@bogorkab.go.id</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Divider, Copyright & Button Login Admin -->
            <div class="pt-6 border-t border-white/15 flex flex-col items-center justify-center space-y-3 text-center">
                <p class="text-xs text-red-200/90">
                    &copy; 2026 KMP - Pemerintah Kabupaten Bogor. Hak cipta dilindungi.
                </p>
                <button type="button" onclick="openLoginModal()" class="px-5 py-2 rounded-full bg-white text-red-800 hover:bg-red-50 text-xs font-bold shadow-md transition flex items-center space-x-2 cursor-pointer">
                    <i class="fa-solid fa-lock text-[11px] text-red-700"></i>
                    <span>Login Admin</span>
                </button>
            </div>
        </div>
    </footer>

</div>

<!-- Modal: Detail Desa / Kelurahan Per Kecamatan -->
<div id="detailDesaModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 transform transition-all">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div>
                <span class="text-[10px] font-bold text-red-600 uppercase tracking-wider block">Rincian Wilayah KMP</span>
                <h4 id="modalKecamatanTitle" class="text-lg font-bold text-slate-800">Kecamatan Cisarua</h4>
            </div>
            <button type="button" onclick="closeDetailModal()" class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 flex items-center justify-center">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="mt-4">
            <div class="grid grid-cols-3 gap-2 text-center p-3 rounded-xl bg-slate-50 border border-slate-100 text-xs mb-4">
                <div>
                    <span class="text-slate-500 block text-[10px]">Kop. Desa</span>
                    <strong id="modalKopDesa" class="text-sm font-extrabold text-slate-800">9</strong>
                </div>
                <div>
                    <span class="text-slate-500 block text-[10px]">Kop. Kelurahan</span>
                    <strong id="modalKopKel" class="text-sm font-extrabold text-slate-800">1</strong>
                </div>
                <div>
                    <span class="text-slate-500 block text-[10px]">Total Koperasi</span>
                    <strong id="modalTotalKop" class="text-sm font-extrabold text-red-600">10</strong>
                </div>
            </div>

            <h5 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Daftar Titik Desa & Kelurahan:</h5>
            <div id="modalDesaList" class="max-h-60 overflow-y-auto space-y-1.5 pr-1 text-xs">
                <!-- Injected via JavaScript -->
            </div>
        </div>

        <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-end">
            <button type="button" onclick="closeDetailModal()" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-xs font-semibold">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- Modal: Regulasi & Dokumen Hukum -->
<div id="regulasiModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-xl w-full p-6 shadow-2xl border border-slate-100">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div class="flex items-center space-x-2 text-red-700 font-bold">
                <i class="fa-solid fa-scale-balanced text-lg"></i>
                <h4 class="text-base font-bold text-slate-800">Landasan Hukum & Regulasi KMP</h4>
            </div>
            <button type="button" onclick="closeRegulasiModal()" class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 flex items-center justify-center">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="mt-4 space-y-3 text-xs text-slate-600 max-h-80 overflow-y-auto pr-1">
            <div class="p-3 bg-red-50/60 rounded-xl border border-red-100">
                <strong class="text-red-900 block font-bold text-sm">1. Undang-Undang Dasar 1945 Pasal 33 Ayat (1)</strong>
                <p class="mt-1 text-slate-700">"Perekonomian disusun sebagai usaha bersama berdasar atas asas kekeluargaan." Koperasi adalah bangun usaha yang paling sesuai dengan amanat konstitusi.</p>
            </div>

            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                <strong class="text-slate-900 block font-bold text-sm">2. Undang-Undang No. 25 Tahun 1992 tentang Perkoperasian</strong>
                <p class="mt-1 text-slate-700">Pengaturan mengenai pembentukan, kepengurusan, permodalan, serta pembinaan koperasi primer dan sekunder.</p>
            </div>

            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                <strong class="text-slate-900 block font-bold text-sm">3. Keputusan Terpadu KMP Kabupaten Bogor TA 2025/2026</strong>
                <p class="mt-1 text-slate-700">Implementasi program percepatan pembentukan 435 unit Koperasi Desa & Kelurahan Merah Putih di 40 Kecamatan se-Kabupaten Bogor.</p>
            </div>
        </div>

        <div class="mt-6 pt-3 border-t border-slate-100 flex justify-end">
            <button type="button" onclick="closeRegulasiModal()" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-xs font-semibold">
                Mengerti
            </button>
        </div>
    </div>
</div>

<!-- Modal: Login Petugas & Admin -->
<div id="loginModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-100 transform transition-all">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center space-x-3">
                <div class="h-10 w-10 rounded-xl bg-red-50 p-1 flex items-center justify-center border border-red-100 shadow-sm shrink-0">
                    <img src="{{ asset('images/logo-kopdeskel-clean.png') }}" alt="Logo KOP DES KEL" class="h-full w-auto object-contain">
                </div>
                <div>
                    <h4 class="text-sm sm:text-base font-bold text-slate-900 leading-tight">Login Operator Desa & Admin</h4>
                    <span class="text-[10px] text-slate-400 font-medium">SIMKOP &bull; KDKMP Kabupaten Bogor</span>
                </div>
            </div>
            <button type="button" onclick="closeLoginModal()" class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 flex items-center justify-center cursor-pointer">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="{{ route('portal.login') }}" method="POST" class="mt-4 space-y-3.5 text-xs">
            @csrf
            <div>
                <label class="block font-semibold text-slate-700 mb-1">Username Operator / Akun:</label>
                <input
                    type="text"
                    name="username"
                    required
                    value="{{ old('username') }}"
                    placeholder="cth: kop.pond2108 / kopmp.cibinong / admin..."
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 bg-slate-50 focus:bg-white text-xs"
                >
            </div>

            <div>
                <label class="block font-semibold text-slate-700 mb-1">Password:</label>
                <input
                    type="password"
                    name="password"
                    required
                    placeholder="••••••••"
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 bg-slate-50 focus:bg-white text-xs"
                >
            </div>

            <div>
                <label class="block font-semibold text-slate-700 mb-1">Captcha:</label>
                <input
                    type="text"
                    name="captcha"
                    required
                    placeholder="Tulis kode di samping..."
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 bg-slate-50 focus:bg-white text-xs"
                >
            </div>

            <div class="flex items-center justify-between pt-1">
                <div class="flex items-center space-x-2">
                    <span class="text-[11px] text-slate-500">Captcha:</span>
                    <img id="loginCaptchaImage" alt="Kode captcha" class="h-10 w-[120px] rounded-lg border border-slate-200 bg-slate-900">
                    <button type="button" onclick="refreshLoginCaptcha()" title="Muat ulang kode" aria-label="Muat ulang kode captcha" class="text-slate-400 hover:text-slate-600 text-xs">
                        <i class="fa-solid fa-rotate-right"></i>
                    </button>
                </div>

                <button type="submit" class="bg-red-700 hover:bg-red-800 text-white font-bold px-6 py-2 rounded-lg text-xs shadow-sm hover:shadow transition cursor-pointer">
                    Masuk
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Data Kecamatan from Laravel
    const kecamatansData = @json($kecamatans);

    let map;
    let markersLayer;
    let tileLayers = {};
    let activeLayerKey = 'osm';

    document.addEventListener('DOMContentLoaded', function () {
        initBogorMap();
    });

    function initBogorMap() {
        // Center strictly on Kabupaten Bogor (-6.5897, 106.7914)
        const bogorCenter = [-6.5700, 106.8200];
        
        // Define bounding box for Kabupaten Bogor
        const bogorBounds = [
            [-6.8000, 106.4000], // Southwest
            [-6.3000, 107.2500]  // Northeast
        ];

        map = L.map('bogorMap', {
            center: bogorCenter,
            zoom: 11,
            minZoom: 10,
            maxZoom: 17,
            maxBounds: [
                [-7.1000, 106.2000],
                [-6.1000, 107.4500]
            ],
            maxBoundsViscosity: 0.8
        });

        // Map Tile Layers - Official OpenStreetMap
        tileLayers.osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a> contributors',
            maxZoom: 19
        });

        tileLayers.satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
            maxZoom: 18
        });

        tileLayers.topo = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data: &copy; OpenStreetMap contributors, SRTM | Map style: &copy; OpenTopoMap (CC-BY-SA)',
            maxZoom: 17
        });

        // Add default layer (OSM Positron / Voyager)
        tileLayers.osm.addTo(map);

        // Add subtle polygon boundary for Kabupaten Bogor visualization
        const bogorPolygon = [
            [-6.350, 106.500],
            [-6.340, 106.650],
            [-6.380, 106.850],
            [-6.380, 107.000],
            [-6.450, 107.160],
            [-6.650, 107.220],
            [-6.750, 107.100],
            [-6.780, 106.920],
            [-6.760, 106.800],
            [-6.730, 106.600],
            [-6.650, 106.420],
            [-6.450, 106.420],
            [-6.350, 106.500]
        ];

        L.polygon(bogorPolygon, {
            color: '#dc2626',
            weight: 2,
            opacity: 0.5,
            dashArray: '6, 6',
            fillColor: '#fee2e2',
            fillOpacity: 0.08
        }).addTo(map);

        // Markers group
        markersLayer = L.layerGroup().addTo(map);

        renderKecamatanMarkers();

        // Fit to Kabupaten Bogor
        map.fitBounds(bogorBounds);

        // Open Cisarua popup by default as in screenshot
        const cisarua = kecamatansData.find(k => k.nama === 'CISARUA');
        if (cisarua) {
            setTimeout(() => {
                focusMarker(cisarua.id, false);
            }, 500);
        }
    }

    const markersMap = {};

    function renderKecamatanMarkers() {
        markersLayer.clearLayers();

        kecamatansData.forEach(item => {
            // Custom HTML Marker matching the screenshot design
            const markerHtml = `
                <div class="custom-kmp-pin" id="pin-${item.id}">
                    <div class="pin-body">
                        <i class="fa-solid fa-building-flag"></i>
                    </div>
                    <div class="pin-badge">${item.jumlah}</div>
                </div>
            `;

            const customIcon = L.divIcon({
                html: markerHtml,
                className: '',
                iconSize: [36, 36],
                iconAnchor: [18, 18],
                popupAnchor: [0, -18]
            });

            const marker = L.marker([item.latitude, item.longitude], { icon: customIcon });

            // Popup content exactly matching the screenshot popup card
            const popupContent = `
                <div class="text-xs" style="min-width: 190px;">
                    <div class="font-bold text-slate-800 uppercase tracking-tight text-sm pb-1.5 mb-2 border-b border-red-100 flex items-center justify-between">
                        <span class="text-red-700">KECAMATAN ${item.nama}</span>
                    </div>
                    <div class="grid grid-cols-3 gap-1.5 text-center bg-red-50/60 p-2 rounded-lg border border-red-100 text-[11px] mb-2.5">
                        <div>
                            <span class="text-slate-500 block text-[9px]">Desa</span>
                            <strong class="font-extrabold text-slate-800">${item.kop_desa}</strong>
                        </div>
                        <div>
                            <span class="text-slate-500 block text-[9px]">Kelurahan</span>
                            <strong class="font-extrabold text-slate-800">${item.kop_kel}</strong>
                        </div>
                        <div>
                            <span class="text-slate-500 block text-[9px]">Total</span>
                            <strong class="font-black text-red-600">${item.jumlah} Kop</strong>
                        </div>
                    </div>
                    <button type="button" onclick="showKecamatanDetail(${item.id})" class="w-full text-center py-1.5 px-3 bg-red-700 hover:bg-red-800 text-white rounded-lg font-bold text-xs transition shadow-sm flex items-center justify-center space-x-1">
                        <span>Lihat Rincian Desa</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </button>
                </div>
            `;

            marker.bindPopup(popupContent, {
                closeButton: true,
                autoPan: true
            });

            marker.on('click', () => {
                highlightTableRow(item.id);
            });

            marker.addTo(markersLayer);
            markersMap[item.id] = marker;
        });
    }

    function switchMapLayer(layerName) {
        if (layerName === activeLayerKey) return;

        map.removeLayer(tileLayers[activeLayerKey]);
        tileLayers[layerName].addTo(map);
        activeLayerKey = layerName;

        // Update button styles
        ['Osm', 'Sat', 'Topo'].forEach(key => {
            const btn = document.getElementById('btnLayer' + key);
            if (key.toLowerCase() === (layerName === 'satellite' ? 'sat' : layerName)) {
                btn.className = "px-3 py-1 rounded-md bg-red-600 text-white transition";
            } else {
                btn.className = "px-3 py-1 rounded-md text-slate-600 hover:text-slate-900 transition";
            }
        });
    }

    function zoomToKecamatan(kecId) {
        if (kecId === 'all') {
            map.fitBounds([
                [-6.8000, 106.4000],
                [-6.3000, 107.2500]
            ]);
            return;
        }

        focusMarker(parseInt(kecId), true);
        highlightTableRow(parseInt(kecId));
    }

    function focusMarker(id, shouldZoom = true) {
        const marker = markersMap[id];
        if (marker) {
            const latLng = marker.getLatLng();
            if (shouldZoom) {
                map.flyTo(latLng, 14, { duration: 1 });
            } else {
                map.panTo(latLng);
            }
            marker.openPopup();
        }
    }

    function highlightTableRow(id) {
        document.querySelectorAll('tr[id^="row-kec-"]').forEach(tr => {
            tr.classList.remove('bg-red-50', 'font-semibold', 'text-red-900', 'border-l-4', 'border-l-red-600');
        });

        const row = document.getElementById('row-kec-' + id);
        if (row) {
            row.classList.add('bg-red-50', 'font-semibold', 'text-red-900', 'border-l-4', 'border-l-red-600');
            row.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        // Also update select dropdown
        const select = document.getElementById('kecamatanFilterSelect');
        if (select) {
            select.value = id;
        }
    }

    function highlightAndZoom(id) {
        focusMarker(id, true);
        highlightTableRow(id);
    }

    // Modal Handler for Detail Desa
    function showKecamatanDetail(id) {
        const item = kecamatansData.find(k => k.id === id);
        if (!item) return;

        document.getElementById('modalKecamatanTitle').innerText = 'Kecamatan ' + item.nama;
        document.getElementById('modalKopDesa').innerText = item.kop_desa;
        document.getElementById('modalKopKel').innerText = item.kop_kel;
        document.getElementById('modalTotalKop').innerText = item.jumlah + ' Koperasi';

        const listContainer = document.getElementById('modalDesaList');
        listContainer.innerHTML = '';

        if (Array.isArray(item.daftar_desa) && item.daftar_desa.length > 0) {
            item.daftar_desa.forEach((desa, idx) => {
                const isKelurahan = desa.toLowerCase().includes('kel.');
                const div = document.createElement('div');
                div.className = "flex items-center justify-between p-2 rounded-lg bg-slate-50 border border-slate-100 hover:bg-red-50/50 transition";
                div.innerHTML = `
                    <div class="flex items-center space-x-2">
                        <span class="w-5 h-5 rounded-full ${isKelurahan ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700'} flex items-center justify-center font-bold text-[10px]">
                            ${idx + 1}
                        </span>
                        <span class="font-medium text-slate-800">${desa}</span>
                    </div>
                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full ${isKelurahan ? 'bg-blue-50 text-blue-600 border border-blue-200' : 'bg-emerald-50 text-emerald-600 border border-emerald-200'}">
                        ${isKelurahan ? 'Kelurahan' : 'Desa'}
                    </span>
                `;
                listContainer.appendChild(div);
            });
        } else {
            listContainer.innerHTML = '<div class="text-slate-400 italic py-2">Daftar desa tidak tersedia.</div>';
        }

        const modal = document.getElementById('detailDesaModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDetailModal() {
        const modal = document.getElementById('detailDesaModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Modal Handler for Regulasi
    function openRegulasiModal() {
        const modal = document.getElementById('regulasiModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeRegulasiModal() {
        const modal = document.getElementById('regulasiModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Filter table live search
    function filterKecamatanTable() {
        const query = document.getElementById('tableSearchInput').value.toLowerCase().trim();
        const rows = document.querySelectorAll('tr[id^="row-kec-"]');

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            if (text.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Modal Handler for Login Petugas & Admin
    function openLoginModal() {
        const modal = document.getElementById('loginModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        refreshLoginCaptcha();
    }

    function refreshLoginCaptcha() {
        const captchaImage = document.getElementById('loginCaptchaImage');
        const captchaInput = document.querySelector('#loginModal input[name="captcha"]');
        captchaImage.src = `{{ route('captcha') }}?refresh=${Date.now()}`;
        captchaInput.value = '';
    }

    function closeLoginModal() {
        const modal = document.getElementById('loginModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    @if(session('open_login') || $errors->any())
        openLoginModal();
    @endif
</script>
@endpush
