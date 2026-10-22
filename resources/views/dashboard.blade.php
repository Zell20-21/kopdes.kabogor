@extends('layouts.app')

@section('title', 'Dashboard KMP Kabupaten Bogor | Koperasi Desa & Kelurahan Merah Putih')

@section('content')
<div class="min-h-screen bg-slate-50 flex flex-col justify-between">

    <!-- Top Navigation Header -->
    <header class="bg-gradient-to-r from-[#881337] via-[#991b1b] to-[#7f1d1d] text-white shadow-md sticky top-0 z-[100]">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14 sm:h-16">
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
                                KMP Kab. Bogor
                            </span>
                        </div>
                        <p class="text-[10px] sm:text-xs text-red-200 font-medium leading-none mt-0.5 truncate max-w-[140px] xs:max-w-[210px] sm:max-w-none">
                            Pemerintah Daerah Kabupaten Bogor
                        </p>
                    </div>
                </div>

                <!-- Nav Menu Links (Scrollspy enabled) -->
                <nav id="publicNav" class="hidden md:flex items-center space-x-1 lg:space-x-2 text-sm font-medium">
                    <a href="#beranda" id="nav-beranda" class="nav-link px-3.5 py-1.5 rounded-full bg-white/20 text-white shadow-sm font-bold transition-all duration-200">
                        Beranda
                    </a>
                    <a href="#informasi" id="nav-informasi" class="nav-link px-3.5 py-1.5 rounded-full text-red-100 hover:text-white hover:bg-white/10 font-medium transition-all duration-200">
                        Informasi
                    </a>
                    <a href="#sebaran" id="nav-sebaran" class="nav-link px-3.5 py-1.5 rounded-full text-red-100 hover:text-white hover:bg-white/10 font-medium transition-all duration-200">
                        Sebaran
                    </a>
                </nav>

                <!-- Actions: TA & Login (Clean & Compact on Mobile) -->
                <div class="flex items-center space-x-2 sm:space-x-3 shrink-0">
                    <div class="hidden sm:flex items-center space-x-1.5 text-xs font-semibold px-3 py-1.5 rounded-full bg-black/25 text-red-100 border border-white/10">
                        <i class="fa-regular fa-calendar-check text-red-300"></i>
                        <span>TA 2025/2026</span>
                    </div>

                    <!-- Clean & Compact Login Button on Mobile -->
                    <button type="button" onclick="openLoginModal()" class="flex items-center space-x-1 sm:space-x-1.5 bg-white text-red-700 hover:bg-red-50 px-2.5 sm:px-4 py-1 sm:py-1.5 rounded-full text-xs sm:text-sm font-bold shadow-sm transition-all duration-200 hover:shadow-md transform active:scale-95 cursor-pointer shrink-0">
                        <i class="fa-solid fa-arrow-right-to-bracket text-[11px] sm:text-xs"></i>
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
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#991b1b] tracking-tight uppercase">
                    KOPERASI DESA MERAH PUTIH
                </h1>
                <p class="mt-2 text-sm sm:text-base text-slate-600 font-medium max-w-3xl mx-auto">
                    Koperasi Desa Merah Putih Kabupaten Bogor
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

            <!-- Section 1A: Card Utama Full-Width (Koperasi Merah Putih & Timeline Foto Geser) -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-7 hover:shadow-md transition-shadow">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-center">
                    <!-- Kolom Kiri: Tentang Program, Penjelasan & Regulasi -->
                    <div class="lg:col-span-7 flex flex-col justify-between space-y-4">
                        <div>
                            <div class="flex items-center pb-3 border-b border-slate-100">
                                <div class="flex items-center space-x-2.5">
                                    <span class="w-3 h-3 rounded-full bg-red-600 animate-pulse"></span>
                                    <h3 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">
                                        Koperasi Merah Putih
                                    </h3>
                                </div>
                            </div>

                            <p class="mt-4 text-xs sm:text-sm text-slate-600 leading-relaxed text-justify">
                                Koperasi Desa Merah Putih adalah program pemerintah yang bertujuan membentuk koperasi di tingkat desa dan kelurahan di seluruh Indonesia guna meningkatkan kesejahteraan ekonomi masyarakat melalui prinsip gotong royong dan kekeluargaan. Program ini menjadi wadah ekonomi rakyat untuk mengembangkan usaha, seperti menjual hasil pertanian, menyediakan kebutuhan pokok, dan layanan simpan pinjam, serta dapat juga mencakup layanan kesehatan dan pendidikan.
                            </p>

                            <!-- Quote Box Undang-Undang 1945 Pasal 33 -->
                            <div class="mt-4 p-3.5 rounded-xl bg-blue-50/70 border border-blue-100/80 text-xs text-blue-900 leading-relaxed relative flex items-start space-x-2.5">
                                <i class="fa-solid fa-quote-left text-blue-500 text-base mt-0.5 shrink-0"></i>
                                <div>
                                    <span class="font-bold text-blue-950">Undang-Undang 1945 Pasal 33</span> menegaskan bahwa perekonomian Indonesia disusun atas usaha bersama yang didasarkan pada asas kekeluargaan. Pada aspek konsensus kelembagaan, direncanakan mendukung 100.000 koperasi desa serentak.
                                </div>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between text-xs text-slate-500 gap-2">
                            <div class="flex items-center space-x-2">
                                <i class="fa-regular fa-calendar-check text-red-600"></i>
                                <span>Launching Nasional: <strong class="text-slate-800 font-bold">19 Juli 2025</strong></span>
                            </div>
                            <button type="button" onclick="openRegulasiModal()" class="text-red-600 hover:text-red-700 font-bold inline-flex items-center space-x-1.5 group cursor-pointer">
                                <span>Pelajari Regulasi & Landasan Hukum</span>
                                <i class="fa-solid fa-arrow-right text-[10px] transform group-hover:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Timeline Slider Foto Kegiatan & Pembangunan KDKMP -->
                    <div class="lg:col-span-5 flex flex-col">
                        <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-100">
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-timeline text-red-600"></i>
                                <span class="text-xs font-bold text-slate-800 uppercase tracking-wide">
                                    Timeline Foto KDKMP
                                </span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span id="slideCounter" class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[10px] font-extrabold">
                                    1 / {{ count($timelineSlides) }}
                                </span>
                            </div>
                        </div>

                        <!-- Slider Frame with Aspect Ratio -->
                        <div
                            id="timelineSliderContainer"
                            onmouseenter="stopSlideAutoPlay()"
                            onmouseleave="startSlideAutoPlay()"
                            class="relative rounded-2xl overflow-hidden border border-slate-200/90 shadow-md bg-slate-900 group select-none cursor-grab active:cursor-grabbing"
                            style="min-height: 250px; height: 270px;"
                        >
                            @foreach($timelineSlides as $index => $slide)
                                <div class="timeline-slide-item {{ $index === 0 ? 'block opacity-100' : 'hidden opacity-0' }} transition-opacity duration-500 absolute inset-0 w-full h-full">
                                    <img src="{{ $slide['foto'] }}" alt="{{ $slide['judul'] }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/50 to-transparent"></div>

                                    <!-- Bottom Info -->
                                    <div class="absolute bottom-3 left-3 right-3 text-white space-y-1">
                                        <div class="flex items-center space-x-1.5 text-[11px] text-red-300 font-bold">
                                            <i class="fa-solid fa-location-dot text-red-400 text-xs"></i>
                                            <span class="truncate">{{ $slide['lokasi'] }}</span>
                                            <span class="text-slate-400 font-normal">&bull;</span>
                                            <span class="text-slate-300 font-medium">{{ $slide['tanggal'] }}</span>
                                        </div>
                                        <h4 class="text-sm font-extrabold text-white leading-tight drop-shadow-xs">
                                            {{ $slide['judul'] }}
                                        </h4>
                                        <p class="text-[11px] text-slate-300 line-clamp-2 leading-snug drop-shadow-2xs">
                                            {{ $slide['deskripsi'] }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Navigation Arrow Buttons (Floating Glassmorphic) -->
                            <button
                                type="button"
                                onclick="prevSlide()"
                                aria-label="Foto Sebelumnya"
                                class="absolute left-2.5 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white/80 hover:bg-white text-slate-800 hover:text-red-700 shadow-md flex items-center justify-center transition-all duration-200 transform hover:scale-110 active:scale-95 cursor-pointer z-10"
                            >
                                <i class="fa-solid fa-chevron-left text-xs"></i>
                            </button>
                            <button
                                type="button"
                                onclick="nextSlide()"
                                aria-label="Foto Selanjutnya"
                                class="absolute right-2.5 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white/80 hover:bg-white text-slate-800 hover:text-red-700 shadow-md flex items-center justify-center transition-all duration-200 transform hover:scale-110 active:scale-95 cursor-pointer z-10"
                            >
                                <i class="fa-solid fa-chevron-right text-xs"></i>
                            </button>
                        </div>

                        <!-- Interactive Slide Dots Indicator (Bisa diklik & digeser) -->
                        <div class="flex items-center justify-center space-x-2 mt-3 py-1">
                            @foreach($timelineSlides as $index => $slide)
                                <button
                                    type="button"
                                    onclick="goToSlide({{ $index }})"
                                    class="timeline-step-btn h-2 rounded-full transition-all duration-300 cursor-pointer focus:outline-none {{ $index === 0 ? 'w-7 bg-red-600 shadow-xs' : 'w-2 bg-slate-300 hover:bg-slate-400' }}"
                                    aria-label="Slide {{ $index + 1 }}: {{ $slide['fase'] }}"
                                    title="{{ $slide['fase'] }}: {{ $slide['judul'] }}"
                                ></button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 1B: Card Capaian Agregat Kabupaten Bogor & Filter Gerai Geospasial -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-7 hover:shadow-md transition-shadow">
                <!-- Header Capaian Agregat -->
                <div class="pb-4 border-b border-slate-100">
                    <span class="text-[10px] sm:text-[11px] font-bold text-red-600 uppercase tracking-wider block">
                        KOPERASI DESA / KELURAHAN MERAH PUTIH
                    </span>
                    <h3 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight">
                        Capaian Agregat Kabupaten Bogor
                    </h3>
                </div>

                <!-- 4 Stats Cards Grid -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mt-5">
                    <!-- Target 2025 -->
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-xs font-semibold text-slate-500 block">Target 2025</span>
                        <div class="mt-2 text-2xl font-black text-slate-800">
                            {{ $totalKoperasi }} Koperasi
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1 leading-snug">
                            Total Koperasi resmi di seluruh wilayah Kab. Bogor
                        </p>
                    </div>

                    <!-- Tingkat Keaktifan -->
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-xs font-semibold text-slate-500 block">Tingkat Keaktifan</span>
                        <div class="mt-2 text-2xl font-black text-slate-800">
                            100% Aktif
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1 leading-snug">
                            Seluruh 435 Koperasi memiliki gedung & anggota tetap
                        </p>
                    </div>

                    <!-- Wilayah Administratif -->
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-xs font-semibold text-slate-500 block">Wilayah Sebaran</span>
                        <div class="mt-2 text-2xl font-black text-slate-800">
                            {{ $totalDesa }} Desa & {{ $totalKelurahan }} Kel
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1 leading-snug">
                            Menjangkau seluruh pemukiman warga desa
                        </p>
                    </div>

                    <!-- SDM Penggerak -->
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-xs font-semibold text-slate-500 block">SDM Penggerak</span>
                        <div class="mt-2 text-2xl font-black text-slate-800">
                            {{ number_format($totalSdm) }} Jiwa
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1 leading-snug">
                            Pengurus, Pengawas, & Anggota Koperasi
                        </p>
                    </div>
                </div>

                <!-- Trigger Button: Lihat Detail Fasilitas (Di Bawah Card Capaian Agregat) -->
                @php
                    $totalUnitFasilitas = array_sum(array_column($fasilitasOptions, 'count'));
                @endphp
                <div class="mt-5 pt-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-center space-x-2.5 text-xs text-slate-600">
                        <span class="w-7 h-7 rounded-lg bg-red-100 text-red-600 flex items-center justify-center font-bold text-xs shrink-0">
                            <i class="fa-solid fa-shop"></i>
                        </span>
                        <div>
                            <span class="font-bold text-slate-800">Fasilitas & Gerai KDKMP:</span>
                            <span class="text-slate-500 ml-1">13 Fasilitas ({{ $totalUnitFasilitas }} Unit Tersebar di Kab. Bogor)</span>
                        </div>
                    </div>
                    <button
                        type="button"
                        onclick="toggleFacilitiesCard()"
                        id="btnToggleFacilities"
                        class="inline-flex items-center space-x-2 px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-sm hover:shadow transition-all duration-200 active:scale-95 cursor-pointer self-start sm:self-auto shrink-0"
                    >
                        <span id="labelToggleFacilities">Lihat Detail Fasilitas</span>
                        <i id="iconToggleFacilities" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300"></i>
                    </button>
                </div>

                <!-- Section Fasilitas & Gerai KDKMP (Dropdown Turun ke Bawah, Hidden by Default) -->
                <div id="facilitiesDropdownWrapper" class="hidden mt-4 pt-4 border-t border-dashed border-slate-200 space-y-3 transition-all duration-300 ease-in-out">
                    <div class="mb-3">
                        <h4 class="text-xs sm:text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center space-x-2">
                            <i class="fa-solid fa-shop text-red-600"></i>
                            <span>Jenis Fasilitas & Gerai KDKMP Kabupaten Bogor:</span>
                        </h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">
                            Klik tombol gerai di bawah untuk memfilter dan menampilkan sebaran titik lokasinya langsung di peta wilayah:
                        </p>
                    </div>

                    <!-- 6 Featured Facility Buttons -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2.5">
                        @foreach(array_filter($fasilitasOptions, fn($f) => $f['featured']) as $item)
                            <button
                                type="button"
                                onclick="filterMapByFacility({{ json_encode($item['type_ids']) }}, '{{ $item['nama'] }}', '{{ $item['bg'] }}', this)"
                                class="facility-filter-btn group p-3 rounded-xl border flex flex-col justify-between text-left {{ $item['bg'] }} transition-all duration-200 hover:shadow-md transform active:scale-95 cursor-pointer relative"
                                data-type-ids="{{ json_encode($item['type_ids']) }}"
                                data-name="{{ $item['nama'] }}"
                                title="Klik untuk memfilter {{ $item['nama'] }} di Peta"
                            >
                                <div class="flex items-center justify-between w-full mb-1">
                                    <i class="{{ $item['icon'] }} text-base"></i>
                                    <span class="text-[10px] font-black px-2 py-0.5 rounded-full {{ $item['badge'] }} text-white shadow-2xs">
                                        {{ $item['count'] }} Unit
                                    </span>
                                </div>
                                <div>
                                    <div class="font-bold text-xs truncate leading-tight">{{ $item['nama'] }}</div>
                                    <span class="text-[10px] opacity-75 group-hover:opacity-100 flex items-center space-x-1 mt-0.5 font-medium">
                                        <span>Lihat di Peta</span>
                                        <i class="fa-solid fa-arrow-down text-[9px] transform group-hover:translate-y-0.5 transition-transform"></i>
                                    </span>
                                </div>
                            </button>
                        @endforeach
                    </div>

                    <!-- Opsi Gerai Tambahan & Layanan Khusus Lainnya (7 Fasilitas, Langsung Ditampilkan Semua) -->
                    <div class="mt-3 pt-3 border-t border-dashed border-slate-200 space-y-2">
                        <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">
                            Opsi Gerai Tambahan & Layanan Khusus Lainnya:
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-2.5">
                            @foreach(array_filter($fasilitasOptions, fn($f) => !$f['featured']) as $item)
                                <button
                                    type="button"
                                    onclick="filterMapByFacility({{ json_encode($item['type_ids']) }}, '{{ $item['nama'] }}', '{{ $item['bg'] }}', this)"
                                    class="facility-filter-btn group p-2.5 rounded-xl border flex flex-col justify-between text-left {{ $item['bg'] }} transition-all duration-200 hover:shadow-md transform active:scale-95 cursor-pointer"
                                    data-type-ids="{{ json_encode($item['type_ids']) }}"
                                    data-name="{{ $item['nama'] }}"
                                    title="Klik untuk memfilter {{ $item['nama'] }} di Peta"
                                >
                                    <div class="flex items-center justify-between w-full mb-1">
                                        <i class="{{ $item['icon'] }} text-sm"></i>
                                        <span class="text-[10px] font-black px-1.5 py-0.2 rounded-full {{ $item['badge'] }} text-white">
                                            {{ $item['count'] }} Unit
                                        </span>
                                    </div>
                                    <div>
                                        <div class="font-bold text-[11px] truncate leading-tight">{{ $item['nama'] }}</div>
                                        <span class="text-[9px] opacity-75 group-hover:opacity-100 flex items-center space-x-1 mt-0.5 font-medium">
                                            <span>Lihat di Peta</span>
                                            <i class="fa-solid fa-arrow-down text-[8px]"></i>
                                        </span>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Card Footer Status -->
                <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span>Visi Nyata Ekonomi Berdikari</span>
                    <span class="font-medium text-slate-600">Merah Putih untuk Indonesia Maju</span>
                </div>
            </div>

            <!-- Section 2: Informasi Koperasi Merah Putih (Potensi, Jenis Usaha, SDM Koperasi & Dokumen Progres) -->
            <section id="informasi" class="space-y-5 scroll-mt-20">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-2 border-b border-slate-200/70">
                    <div>
                        <h3 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight">
                            Informasi Koperasi Merah Putih
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500 font-medium">
                            Kabupaten Bogor &bull; Data Progres Pembangunan, Agregat Potensi & Sumber Daya
                        </p>
                    </div>

                    <!-- Rounded Buttons Trigger Open File / Dropdown (Sesuai Permintaan & Gambar Referensi) -->
                    <div class="relative inline-block text-left">
                        @php
                            $defaultFile = !empty($informasiFiles) ? $informasiFiles[0] : [
                                'url' => route('informasi.file', 'kdkp_maret_2026.pdf'),
                                'title' => 'DATA PROGRES PEMBANGUNAN KDKMP',
                                'subtitle' => 'LAPJUSIK DIM 0621 &bull; 24 MARET 2026',
                                'size' => '5.47 MB',
                                'ext' => 'pdf',
                                'filename' => 'DATA PROGRES PEMBANGUNAN KDKMP.pdf',
                            ];
                            $fileCount = !empty($informasiFiles) ? count($informasiFiles) : 1;

                            $getFileIcon = function($ext) {
                                return match(strtolower($ext)) {
                                    'xlsx', 'xls', 'csv' => 'fa-solid fa-file-excel text-emerald-600',
                                    'pdf' => 'fa-solid fa-file-pdf text-red-600',
                                    'doc', 'docx' => 'fa-solid fa-file-word text-blue-600',
                                    'png', 'jpg', 'jpeg', 'webp' => 'fa-solid fa-file-image text-purple-600',
                                    default => 'fa-solid fa-file-lines text-slate-600',
                                };
                            };

                            $getFileBadgeBg = function($ext) {
                                return match(strtolower($ext)) {
                                    'xlsx', 'xls', 'csv' => 'bg-emerald-100 text-emerald-700',
                                    'pdf' => 'bg-red-100 text-red-700',
                                    'doc', 'docx' => 'bg-blue-100 text-blue-700',
                                    'png', 'jpg', 'jpeg', 'webp' => 'bg-purple-100 text-purple-700',
                                    default => 'bg-slate-100 text-slate-700',
                                };
                            };
                        @endphp

                        <!-- Tombol Utama Rounded Sesuai Gambar 2 -->
                        <button
                            type="button"
                            id="btnMainTriggerDoc"
                            onclick="toggleLampiranDropdown()"
                            class="btn-trigger-doc group inline-flex items-center space-x-2.5 px-4 py-2 rounded-full bg-white border border-slate-300 hover:border-blue-500 text-slate-700 hover:text-blue-700 shadow-sm hover:shadow-md transition-all duration-300 transform active:scale-95 cursor-pointer text-xs font-bold"
                            title="Klik untuk memilih dokumen laporan lampiran"
                        >
                            <span id="mainDocIconWrapper" class="w-6 h-6 rounded-full {{ $getFileBadgeBg($defaultFile['ext']) }} flex items-center justify-center text-xs transition shrink-0">
                                <i id="mainDocIcon" class="{{ $getFileIcon($defaultFile['ext']) }}"></i>
                            </span>
                            <span id="labelCurrentDocTitle" class="tracking-tight truncate max-w-[200px] sm:max-w-xs">
                                {{ $defaultFile['title'] }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full bg-slate-100 group-hover:bg-blue-100 text-[10px] font-extrabold text-slate-600 group-hover:text-blue-800 flex items-center space-x-1.5 shrink-0 transition">
                                <span id="labelCurrentDocAction">Lihat Detail</span>
                                <i id="iconCurrentDocChevron" class="fa-solid fa-chevron-down text-[9px] transition-transform duration-300"></i>
                            </span>
                        </button>

                        <!-- Dropdown Menu Pilihan File yang Turun Langsung di Bawah Tombol -->
                        <div
                            id="dropdownMenuLampiran"
                            class="hidden absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-slate-200/90 z-40 p-3 space-y-2 animate-in fade-in slide-in-from-top-2 duration-200"
                        >
                            <div class="px-2 py-1.5 border-b border-slate-100 flex items-center justify-between text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">
                                <span>PILIH DOKUMEN LAMPIRAN</span>
                                <span class="px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 text-[10px] font-bold">
                                    {{ $fileCount }} Dokumen Tersedia
                                </span>
                            </div>

                            <div class="space-y-2 max-h-72 overflow-y-auto pr-1">
                                @if(!empty($informasiFiles))
                                    @foreach($informasiFiles as $index => $file)
                                        <!-- Setiap file dibungkus rounded card tersendiri dengan opsi 'Lihat Detail Informasi' di kanan -->
                                        <div class="group/item flex items-center justify-between p-2.5 rounded-xl border border-slate-200/80 hover:border-blue-400 bg-white hover:bg-blue-50/40 shadow-2xs hover:shadow-xs transition">
                                            <div class="flex items-center space-x-2.5 min-w-0 pr-2">
                                                <span class="w-8 h-8 rounded-lg {{ $getFileBadgeBg($file['ext']) }} flex items-center justify-center text-xs shrink-0 group-hover/item:scale-105 transition-transform">
                                                    <i class="{{ $getFileIcon($file['ext']) }}"></i>
                                                </span>
                                                <div class="min-w-0">
                                                    <div class="text-xs font-bold text-slate-800 truncate group-hover/item:text-blue-700 transition" title="{{ $file['title'] }}">
                                                        {{ $file['title'] }}
                                                    </div>
                                                    <div class="text-[10px] text-slate-400 truncate">
                                                        {!! $file['subtitle'] !!} &bull; {{ $file['size'] }}
                                                    </div>
                                                </div>
                                            </div>

                                            <button
                                                type="button"
                                                onclick="selectLampiranDoc('{{ $file['url'] }}', '{{ addslashes($file['title']) }}', '{{ addslashes($file['subtitle']) }}', '{{ $file['ext'] }}', '{{ addslashes($file['filename']) }}', {{ $index }})"
                                                class="shrink-0 px-3 py-1.5 rounded-full bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white border border-blue-200 hover:border-blue-600 text-[11px] font-extrabold transition shadow-2xs flex items-center space-x-1.5 cursor-pointer"
                                                title="Lihat detail dokumen ini"
                                            >
                                                <span>Lihat Detail Informasi</span>
                                                <i class="fa-solid fa-arrow-down text-[9px]"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="group/item flex items-center justify-between p-2.5 rounded-xl border border-slate-200/80 hover:border-blue-400 bg-white hover:bg-blue-50/40 shadow-2xs hover:shadow-xs transition">
                                        <div class="flex items-center space-x-2.5 min-w-0 pr-2">
                                            <span class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center text-xs shrink-0">
                                                <i class="fa-solid fa-file-pdf"></i>
                                            </span>
                                            <div class="min-w-0">
                                                <div class="text-xs font-bold text-slate-800 truncate">
                                                    DATA PROGRES PEMBANGUNAN KDKMP
                                                </div>
                                                <div class="text-[10px] text-slate-400 truncate">
                                                    LAPJUSIK DIM 0621 &bull; 5.47 MB
                                                </div>
                                            </div>
                                        </div>

                                        <button
                                            type="button"
                                            onclick="selectLampiranDoc('{{ route('informasi.file', 'kdkp_maret_2026.pdf') }}', 'DATA PROGRES PEMBANGUNAN KDKMP', 'LAPJUSIK DIM 0621 &bull; 24 MARET 2026', 'pdf', 'kdkp_maret_2026.pdf', 0)"
                                            class="shrink-0 px-3 py-1.5 rounded-full bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white border border-blue-200 hover:border-blue-600 text-[11px] font-extrabold transition shadow-2xs flex items-center space-x-1.5 cursor-pointer"
                                        >
                                            <span>Lihat Detail Informasi</span>
                                            <i class="fa-solid fa-arrow-down text-[9px]"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Collapsible Expanding Card File (Dropdown turun kebawah & melebar kebawah sesuai gambar referensi) -->
                <div id="progresDocCard" class="hidden transition-all duration-500 ease-in-out border border-slate-200/90 rounded-2xl shadow-xl bg-white overflow-hidden">
                    <!-- Bar Biru Sesuai Screenshot Lampiran Pengguna -->
                    <div class="bg-[#0284c7] text-white px-5 py-3.5 flex flex-wrap items-center justify-between gap-3 shadow-sm">
                        <div class="flex items-center space-x-3">
                            <div id="docCardIcon" class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center text-white shrink-0 text-sm">
                                <i class="{{ $getFileIcon($defaultFile['ext']) }}"></i>
                            </div>
                            <div>
                                <h4 id="docCardTitle" class="text-xs sm:text-sm font-extrabold tracking-wider uppercase leading-none">
                                    {{ $defaultFile['title'] }}
                                </h4>
                                <p id="docCardSubtitle" class="text-[10px] sm:text-[11px] text-blue-100 font-medium leading-none mt-1">
                                    {!! $defaultFile['subtitle'] !!}
                                </p>
                            </div>
                        </div>

                        <!-- Quick Document Switcher Tabs if Multiple Files Exist -->
                        @if(!empty($informasiFiles) && count($informasiFiles) > 1)
                            <div id="docSwitcherTabs" class="flex items-center space-x-1.5 bg-black/20 p-1 rounded-xl">
                                @foreach($informasiFiles as $idx => $f)
                                    <button
                                        type="button"
                                        id="docSwitcherBtn_{{ $idx }}"
                                        onclick="selectLampiranDoc('{{ $f['url'] }}', '{{ addslashes($f['title']) }}', '{{ addslashes($f['subtitle']) }}', '{{ $f['ext'] }}', '{{ addslashes($f['filename']) }}', {{ $idx }})"
                                        class="doc-switcher-btn px-2.5 py-1 rounded-lg text-[11px] font-bold transition {{ $idx === 0 ? 'bg-white text-blue-900 shadow-xs' : 'text-white/80 hover:bg-white/10 hover:text-white' }} cursor-pointer truncate max-w-[120px]"
                                        title="{{ $f['title'] }}"
                                    >
                                        Dokumen {{ $idx + 1 }}
                                    </button>
                                @endforeach
                            </div>
                        @endif

                        <div class="flex items-center space-x-2 text-xs">
                            <a id="btnDocDownload" href="{{ $defaultFile['url'] }}" download="{{ $defaultFile['filename'] ?? ($defaultFile['title'].'.'.$defaultFile['ext']) }}" class="inline-flex items-center space-x-1.5 px-3.5 py-1.5 rounded-full bg-white/20 hover:bg-white/30 text-white font-semibold transition shadow-sm">
                                <i class="fa-solid fa-download text-xs"></i>
                                <span id="btnDocDownloadLabel" class="hidden sm:inline">
                                    Unduh {{ in_array($defaultFile['ext'], ['xlsx', 'xls']) ? 'Excel' : ($defaultFile['ext'] === 'pdf' ? 'PDF' : 'File') }}
                                </span>
                            </a>
                            <a id="btnDocExternal" href="{{ $defaultFile['url'] }}" target="_blank" class="inline-flex items-center space-x-1.5 px-3.5 py-1.5 rounded-full bg-white/20 hover:bg-white/30 text-white font-semibold transition shadow-sm">
                                <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                <span class="hidden sm:inline">Layar Penuh</span>
                            </a>
                            <button type="button" onclick="closeProgresDocCard()" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center transition cursor-pointer" title="Tutup / Ciutkan File">
                                <i class="fa-solid fa-xmark text-sm"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Viewer Container yang responsive dan melebar kebawah -->
                    <div class="relative bg-slate-900 w-full overflow-hidden" style="min-height: 650px; height: 80vh;">
                        <!-- PDF Viewer Iframe -->
                        <iframe
                            id="docViewerIframe"
                            src=""
                            class="w-full h-full border-0 hidden"
                            title="Viewer Dokumen Lampiran"
                        ></iframe>

                        <!-- Spreadsheet / Excel Interactive Viewer (SheetJS) -->
                        <div id="docViewerSpreadsheet" class="w-full h-full flex flex-col bg-slate-50 hidden">
                            <!-- Top Toolbar Excel -->
                            <div class="bg-emerald-800 text-white px-4 py-2 flex flex-wrap items-center justify-between gap-2 border-b border-emerald-900 shadow-xs shrink-0">
                                <div class="flex items-center space-x-2 min-w-0">
                                    <span class="w-6 h-6 rounded bg-emerald-700 flex items-center justify-center text-xs font-bold shrink-0">
                                        <i class="fa-solid fa-file-excel"></i>
                                    </span>
                                    <span id="sheetDocName" class="text-xs font-bold truncate max-w-xs sm:max-w-md">Lembar Kerja Excel</span>
                                    <span id="sheetActiveNameBadge" class="px-2 py-0.5 rounded-full bg-emerald-900/80 text-[10px] font-mono text-emerald-200 shrink-0"></span>
                                </div>
                                <!-- Sheet Tabs Switcher if multiple sheets -->
                                <div id="spreadsheetSheetTabs" class="flex items-center space-x-1 overflow-x-auto max-w-md py-0.5">
                                    <!-- Populated dynamically via JS -->
                                </div>
                                <div class="text-[11px] text-emerald-200 flex items-center space-x-2 shrink-0">
                                    <span id="sheetStatsInfo"></span>
                                </div>
                            </div>

                            <!-- Spreadsheet Table Body -->
                            <div id="spreadsheetTableContainer" class="flex-1 overflow-auto p-4 bg-white select-text">
                                <!-- Table rendered here -->
                            </div>
                        </div>

                        <!-- Image Viewer -->
                        <div id="docViewerImage" class="w-full h-full flex items-center justify-center p-4 bg-slate-950 hidden">
                            <img id="imgViewerElement" src="" alt="Preview Lampiran" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">
                        </div>

                        <!-- Generic Document Fallback -->
                        <div id="docViewerFallback" class="w-full h-full flex flex-col items-center justify-center p-8 bg-slate-900 text-white space-y-4 hidden text-center">
                            <div class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center text-3xl text-sky-400 shadow-inner">
                                <i class="fa-solid fa-file-lines"></i>
                            </div>
                            <div class="max-w-md space-y-1">
                                <h4 id="fallbackDocTitle" class="text-base font-bold text-white">Nama Dokumen</h4>
                                <p class="text-xs text-slate-400">File ini siap dilihat atau diunduh untuk dibuka dengan aplikasi terkait.</p>
                            </div>
                            <div class="flex items-center space-x-3 pt-2">
                                <a id="fallbackDownloadBtn" href="#" download class="px-4 py-2 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs shadow-md transition flex items-center space-x-2">
                                    <i class="fa-solid fa-download"></i>
                                    <span>Unduh File Dokumen</span>
                                </a>
                                <a id="fallbackOpenBtn" href="#" target="_blank" class="px-4 py-2 rounded-xl bg-white/15 hover:bg-white/25 text-white font-bold text-xs transition flex items-center space-x-2">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    <span>Buka di Tab Baru</span>
                                </a>
                            </div>
                        </div>

                        <!-- Loading State -->
                        <div id="docViewerLoading" class="absolute inset-0 bg-slate-900/80 backdrop-blur-xs flex flex-col items-center justify-center text-white space-y-3 z-30 hidden">
                            <div class="w-10 h-10 border-4 border-sky-400 border-t-transparent rounded-full animate-spin"></div>
                            <span class="text-xs font-semibold tracking-wide text-slate-200">Memuat pratinjau dokumen...</span>
                        </div>
                    </div>
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
            <section id="sebaran" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-4 scroll-mt-20">
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

                <!-- Map Active Filter Status Banner (Appears when facility is filtered) -->
                <div id="mapFilterAlert" class="hidden items-center justify-between p-3 rounded-xl bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 text-xs shadow-xs transition-all duration-300">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-7 h-7 rounded-full bg-red-600 text-white flex items-center justify-center text-xs shrink-0 shadow-xs">
                            <i class="fa-solid fa-filter"></i>
                        </span>
                        <div>
                            <div class="font-bold text-slate-800 flex items-center space-x-2">
                                <span>Filter Gerai Aktif:</span>
                                <span id="filterAlertName" class="px-2 py-0.5 rounded-md bg-red-600 text-white font-black text-xs">Klinik & Apotek</span>
                            </div>
                            <p class="text-[11px] text-slate-600 mt-0.5">
                                Menampilkan <strong id="filterAlertCount" class="text-red-700 font-extrabold">0</strong> titik koperasi dengan fasilitas ini.
                            </p>
                        </div>
                    </div>
                    <button
                        type="button"
                        onclick="resetMapFacilityFilter()"
                        class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg bg-white border border-red-300 hover:bg-red-600 hover:text-white text-red-700 font-bold text-xs shadow-2xs transition-all cursor-pointer"
                    >
                        <i class="fa-solid fa-rotate-left text-[11px]"></i>
                        <span>Reset / Tampilkan Semua</span>
                    </button>
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

                        <!-- Dropdown Filter Fasilitas Langsung di Peta -->
                        <div class="relative inline-block">
                            <select id="facilityFilterSelect" onchange="onFacilitySelectChange(this)" class="bg-white text-xs font-semibold text-slate-700 border border-slate-300 rounded-lg pl-3 pr-8 py-1.5 focus:outline-none focus:ring-2 focus:ring-red-500 cursor-pointer shadow-sm">
                                <option value="all">Fasilitas Gerai (Semua)</option>
                                @foreach($fasilitasOptions as $opt)
                                    <option value="{{ json_encode($opt['type_ids']) }}" data-name="{{ $opt['nama'] }}">
                                        {{ $opt['nama'] }} ({{ $opt['count'] }} Unit)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <span id="mapActivePointsBadge" class="inline-flex items-center space-x-1.5 text-xs text-slate-600 font-semibold bg-white px-3 py-1.5 rounded-lg border border-slate-200 shadow-sm">
                            <i class="fa-solid fa-map-pin text-red-500"></i>
                            <span id="mapPointCounterText">435 Titik Koperasi Aktif</span>
                        </span>
                    </div>

                    <!-- Map Layer Switches -->
                    <div class="flex items-center space-x-1 bg-white p-1 rounded-lg border border-slate-200 shadow-sm text-xs font-semibold">
                        <div class="relative flex items-center p-0.5 bg-slate-100/80 rounded-lg border border-slate-200/60" id="publicLayerWrapper">
                            <div id="publicLayerGlider" class="absolute rounded-md bg-red-600 shadow-xs transition-all duration-300 ease-in-out pointer-events-none" style="left: 2px; top: 2px; width: 44px; height: 26px;"></div>
                            <button type="button" onclick="switchMapLayer('osm')" id="btnLayerOsm" class="relative z-10 px-3 py-1 rounded-md text-white font-semibold transition-colors duration-200 cursor-pointer">
                                POS
                            </button>
                            <button type="button" onclick="switchMapLayer('satellite')" id="btnLayerSat" class="relative z-10 px-3 py-1 rounded-md text-slate-600 hover:text-slate-900 font-semibold transition-colors duration-200 cursor-pointer">
                                Satelit
                            </button>
                            <button type="button" onclick="switchMapLayer('topo')" id="btnLayerTopo" class="relative z-10 px-3 py-1 rounded-md text-slate-600 hover:text-slate-900 font-semibold transition-colors duration-200 cursor-pointer">
                                Topografi
                            </button>
                        </div>
                        <div class="h-4 w-px bg-slate-200 mx-1"></div>
                        <button type="button" onclick="toggleKecamatanBoundaries()" id="btnToggleBoundaries" title="Tampilkan / Sembunyikan Garis Batas Antar Kecamatan" class="px-2.5 py-1 rounded-md bg-sky-50 text-sky-700 border border-sky-200 hover:bg-sky-100 transition flex items-center space-x-1 text-xs">
                            <i class="fa-solid fa-draw-polygon text-[10px]"></i>
                            <span class="hidden sm:inline">Batas Kecamatan</span>
                        </button>
                    </div>
                </div>

                <!-- Leaflet Map Container -->
                <div class="relative w-full h-[460px] rounded-xl overflow-hidden border border-slate-200 shadow-inner">
                    <div id="bogorMap" class="w-full h-full z-10"></div>

                    <!-- Custom Floating Legend -->
                    <div class="absolute bottom-3 left-3 z-20 pointer-events-none bg-white/95 backdrop-blur-sm p-2.5 rounded-lg border border-slate-200 shadow-md text-[11px] text-slate-700 space-y-1">
                        <div class="font-bold text-slate-800 flex items-center space-x-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-600"></span>
                            <span>Wilayah: Kabupaten Bogor</span>
                        </div>
                        <div class="flex items-center space-x-1.5 text-[10px] text-sky-700 font-semibold pt-0.5 border-t border-slate-100">
                            <span class="w-3 h-1 bg-sky-500 rounded-sm"></span>
                            <span>Batas 40 Kecamatan</span>
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
                                    <tr id="row-kec-{{ $item->id_kopkec }}"
                                        onclick="window.location.href='{{ route('kecamatan.show', $item->id_kopkec) }}'"
                                        class="cursor-pointer group transition-all duration-150 hover:bg-red-50/80 hover:text-red-700">
                                        <td class="py-2 px-3 font-semibold text-slate-500 group-hover:text-red-700">{{ $item->nomor_urut }}</td>
                                        <td class="py-2 px-3 font-bold text-slate-800 group-hover:text-red-700">
                                            <a href="{{ route('kecamatan.show', $item->id_kopkec) }}" class="inline-flex items-center space-x-1.5 hover:underline">
                                                <span>{{ $item->nama }}</span>
                                                <i class="fa-solid fa-arrow-up-right-from-square text-[9px] opacity-0 group-hover:opacity-100 transition-opacity text-red-500"></i>
                                            </a>
                                        </td>
                                        <td class="py-2 px-2 text-center font-medium">{{ $item->kop_desa }}</td>
                                        <td class="py-2 px-2 text-center font-medium">{{ $item->kop_kel }}</td>
                                        <td class="py-2 px-3 text-right font-black text-slate-900 group-hover:text-red-700">
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
                                    <tr id="row-kec-{{ $item->id_kopkec }}"
                                        onclick="window.location.href='{{ route('kecamatan.show', $item->id_kopkec) }}'"
                                        class="cursor-pointer group transition-all duration-150 hover:bg-red-50/80 hover:text-red-700">
                                        <td class="py-2 px-3 font-semibold text-slate-500 group-hover:text-red-700">{{ $item->nomor_urut }}</td>
                                        <td class="py-2 px-3 font-bold text-slate-800 group-hover:text-red-700">
                                            <a href="{{ route('kecamatan.show', $item->id_kopkec) }}" class="inline-flex items-center space-x-1.5 hover:underline">
                                                <span>{{ $item->nama }}</span>
                                                <i class="fa-solid fa-arrow-up-right-from-square text-[9px] opacity-0 group-hover:opacity-100 transition-opacity text-red-500"></i>
                                            </a>
                                        </td>
                                        <td class="py-2 px-2 text-center font-medium">{{ $item->kop_desa }}</td>
                                        <td class="py-2 px-2 text-center font-medium">{{ $item->kop_kel }}</td>
                                        <td class="py-2 px-3 text-right font-black text-slate-900 group-hover:text-red-700">
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
                        <img src="{{ asset('images/logo-kabupaten-bogor.png') }}" alt="Lambang Kabupaten Bogor" class="h-11 sm:h-12 w-auto object-contain drop-shadow shrink-0">
                        <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-white p-1.5 flex items-center justify-center shadow-lg shrink-0 border border-white/50 overflow-hidden">
                            <img src="{{ asset('images/logo-kopdeskel-clean.png') }}" alt="Logo KOP DES KEL" class="w-full h-full object-contain">
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
    <div class="bg-white rounded-2xl max-w-xl w-full p-5 sm:p-6 shadow-2xl border border-slate-100 flex flex-col max-h-[90vh]">
        <div class="flex items-center justify-between pb-3.5 border-b border-slate-100 shrink-0">
            <div class="flex items-center space-x-2.5 text-red-700 font-bold">
                <span class="w-9 h-9 rounded-xl bg-red-50 text-red-700 flex items-center justify-center shadow-2xs">
                    <i class="fa-solid fa-scale-balanced text-base"></i>
                </span>
                <div>
                    <h4 class="text-base font-extrabold text-slate-900 leading-tight">Landasan Hukum & Regulasi KMP</h4>
                    <p class="text-[11px] text-slate-500 font-normal">Klik peraturan untuk membuka rincian teks & pemahaman</p>
                </div>
            </div>
            <button type="button" onclick="closeRegulasiModal()" aria-label="Tutup Modal" class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-700 flex items-center justify-center transition cursor-pointer">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="mt-4 space-y-3 text-xs text-slate-600 overflow-y-auto pr-1 flex-1">
            <!-- 1. UUD 1945 Pasal 33 Ayat 1 -->
            <div class="rounded-2xl border border-red-200/90 bg-red-50/40 overflow-hidden transition-all duration-200 shadow-2xs">
                <button
                    type="button"
                    onclick="toggleRegulasiAccordion('accordion-uud-1945')"
                    class="w-full text-left p-3.5 sm:p-4 flex items-center justify-between gap-3 hover:bg-red-100/50 transition cursor-pointer"
                >
                    <div class="flex items-start gap-2.5">
                        <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-red-600 text-white font-black text-xs">
                            1
                        </span>
                        <div>
                            <strong class="text-red-950 font-bold text-sm block">Undang-Undang Dasar 1945 Pasal 33 Ayat (1)</strong>
                            <p class="mt-0.5 text-slate-600 text-[11px] leading-snug">"Perekonomian disusun sebagai usaha bersama berdasar atas asas kekeluargaan."</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 shrink-0 text-red-700 text-xs font-semibold">
                        <span class="hidden sm:inline text-[11px] text-red-600/80">Keterangan</span>
                        <i id="accordion-icon-accordion-uud-1945" class="fa-solid fa-chevron-down text-xs transition-transform duration-300"></i>
                    </div>
                </button>
                <div id="accordion-uud-1945" class="px-3.5 sm:px-4 pb-4 pt-1 border-t border-red-100/80 space-y-2.5 text-slate-700 text-xs">
                    <div class="p-3 rounded-xl bg-white/95 border border-red-100 space-y-1.5">
                        <span class="font-bold text-red-900 block text-xs uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fa-solid fa-quote-left text-red-500"></i> Bunyi & Amanat Konstitusi
                        </span>
                        <blockquote class="italic text-slate-800 font-medium pl-2.5 border-l-2 border-red-500 text-[11px]">
                            "Perekonomian disusun sebagai usaha bersama berdasar atas asas kekeluargaan."
                        </blockquote>
                        <p class="text-[10px] text-slate-400">UUD 1945 Bab XIV: Perekonomian Nasional dan Kesejahteraan Sosial</p>
                    </div>

                    <div class="p-3 rounded-xl bg-white/95 border border-red-100 space-y-1">
                        <span class="font-bold text-slate-900 block text-xs flex items-center gap-1.5">
                            <i class="fa-solid fa-book-open-reader text-red-600"></i> Pemahaman & Filosofi Demokrasi Ekonomi
                        </span>
                        <p class="leading-relaxed text-slate-600 text-[11px]">
                            Pasal 33 dirumuskan oleh para pendiri bangsa (khususnya Drs. Mohammad Hatta) dengan tujuan menegakkan demokrasi ekonomi. Perekonomian nasional tidak boleh dibangun atas persaingan bebas yang mematikan atau penguasaan modal segelintir korporasi, melainkan ditujukan untuk kemakmuran bersama seluruh rakyat secara adil dan bergotong royong.
                        </p>
                    </div>

                    <div class="p-3 rounded-xl bg-white/95 border border-red-100 space-y-1">
                        <span class="font-bold text-slate-900 block text-xs flex items-center gap-1.5">
                            <i class="fa-solid fa-hands-holding-circle text-red-600"></i> Koperasi Sebagai Bangun Usaha Konstitusional
                        </span>
                        <p class="leading-relaxed text-slate-600 text-[11px]">
                            Koperasi adalah bangun usaha yang paling tepat dan diamanatkan konstitusi. Berbeda dengan korporasi modal di mana suara ditentukan oleh besaran modal uang, di dalam koperasi setiap anggota adalah pemilik sekaligus pengguna jasa dengan kedudukan setara (<em>one member, one vote</em>).
                        </p>
                    </div>

                    <div class="p-3 rounded-xl bg-red-100/60 border border-red-200 text-[11px] text-red-950 space-y-1">
                        <span class="font-bold block text-red-900 flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-check text-red-600"></i> Relevansi dengan KMP Kabupaten Bogor
                        </span>
                        <p class="leading-relaxed text-slate-700">
                            Program Koperasi Merah Putih (KMP) di 435 Desa & Kelurahan mewujudkan amanat Pasal 33 ini hingga ke tingkat desa: memotong mata rantai tengkulak, membangun gerai kebutuhan pokok warga, dan mengembalikan keuntungan usaha ke masyarakat melalui Sisa Hasil Usaha (SHU).
                        </p>
                    </div>
                </div>
            </div>

            <!-- 2. UU No. 25 Tahun 1992 -->
            <div class="rounded-2xl border border-slate-200 bg-slate-50/60 overflow-hidden transition-all duration-200 shadow-2xs">
                <button
                    type="button"
                    onclick="toggleRegulasiAccordion('accordion-uu-25-1992')"
                    class="w-full text-left p-3.5 sm:p-4 flex items-center justify-between gap-3 hover:bg-slate-100/70 transition cursor-pointer"
                >
                    <div class="flex items-start gap-2.5">
                        <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-slate-700 text-white font-black text-xs">
                            2
                        </span>
                        <div>
                            <strong class="text-slate-950 font-bold text-sm block">Undang-Undang No. 25 Tahun 1992 tentang Perkoperasian</strong>
                            <p class="mt-0.5 text-slate-600 text-[11px] leading-snug">Tata kelola kelembagaan, permodalan, dan legalitas badan hukum koperasi nasional.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 shrink-0 text-slate-600 text-xs font-semibold">
                        <span class="hidden sm:inline text-[11px] text-slate-500">Keterangan</span>
                        <i id="accordion-icon-accordion-uu-25-1992" class="fa-solid fa-chevron-down text-xs transition-transform duration-300 -rotate-90"></i>
                    </div>
                </button>
                <div id="accordion-uu-25-1992" class="hidden px-3.5 sm:px-4 pb-4 pt-1 border-t border-slate-200/80 space-y-2.5 text-slate-700 text-xs">
                    <div class="p-3 rounded-xl bg-white border border-slate-200 space-y-1">
                        <span class="font-bold text-slate-900 block text-xs flex items-center gap-1.5">
                            <i class="fa-solid fa-gavel text-slate-600"></i> Dasar Hukum Badan Usaha & AD/ART
                        </span>
                        <p class="leading-relaxed text-slate-600 text-[11px]">
                            UU No. 25 Tahun 1992 mengatur syarat pendirian, pengesahan akta notaris, anggaran dasar (AD/ART), keanggotaan sukarela terbuka, serta pengawasan operasional oleh dinas koperasi.
                        </p>
                    </div>

                    <div class="p-3 rounded-xl bg-white border border-slate-200 space-y-1">
                        <span class="font-bold text-slate-900 block text-xs flex items-center gap-1.5">
                            <i class="fa-solid fa-users-gear text-slate-600"></i> Rapat Anggota Tahunan (RAT)
                        </span>
                        <p class="leading-relaxed text-slate-600 text-[11px]">
                            Menegaskan Rapat Anggota sebagai pemegang kekuasaan tertinggi dalam koperasi untuk menetapkan kebijakan, memilih pengurus dan pengawas, serta mengesahkan pertanggungjawaban keuangan tahunan.
                        </p>
                    </div>

                    <div class="p-3 rounded-xl bg-white border border-slate-200 space-y-1">
                        <span class="font-bold text-slate-900 block text-xs flex items-center gap-1.5">
                            <i class="fa-solid fa-coins text-slate-600"></i> Permodalan & Pembagian SHU
                        </span>
                        <p class="leading-relaxed text-slate-600 text-[11px]">
                            Modal bersumber dari simpanan pokok, simpanan wajib, dana cadangan, dan hibah. Keuntungan atau Sisa Hasil Usaha (SHU) dibagikan secara adil sebanding dengan keaktifan dan partisipasi transaksi anggota.
                        </p>
                    </div>
                </div>
            </div>

            <!-- 3. Keputusan Terpadu KMP Bogor -->
            <div class="rounded-2xl border border-slate-200 bg-slate-50/60 overflow-hidden transition-all duration-200 shadow-2xs">
                <button
                    type="button"
                    onclick="toggleRegulasiAccordion('accordion-kmp-bogor')"
                    class="w-full text-left p-3.5 sm:p-4 flex items-center justify-between gap-3 hover:bg-slate-100/70 transition cursor-pointer"
                >
                    <div class="flex items-start gap-2.5">
                        <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-slate-700 text-white font-black text-xs">
                            3
                        </span>
                        <div>
                            <strong class="text-slate-950 font-bold text-sm block">Keputusan Terpadu KMP Kabupaten Bogor TA 2025/2026</strong>
                            <p class="mt-0.5 text-slate-600 text-[11px] leading-snug">Implementasi percepatan pembentukan 435 unit Koperasi Desa & Kelurahan se-Kabupaten Bogor.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 shrink-0 text-slate-600 text-xs font-semibold">
                        <span class="hidden sm:inline text-[11px] text-slate-500">Keterangan</span>
                        <i id="accordion-icon-accordion-kmp-bogor" class="fa-solid fa-chevron-down text-xs transition-transform duration-300 -rotate-90"></i>
                    </div>
                </button>
                <div id="accordion-kmp-bogor" class="hidden px-3.5 sm:px-4 pb-4 pt-1 border-t border-slate-200/80 space-y-2.5 text-slate-700 text-xs">
                    <div class="p-3 rounded-xl bg-white border border-slate-200 space-y-1">
                        <span class="font-bold text-slate-900 block text-xs flex items-center gap-1.5">
                            <i class="fa-solid fa-bullseye text-slate-600"></i> Target Percepatan 435 Unit Koperasi
                        </span>
                        <p class="leading-relaxed text-slate-600 text-[11px]">
                            Menginstruksikan percepatan pendirian dan legalisasi Koperasi Desa & Kelurahan Merah Putih di seluruh 416 Desa dan 19 Kelurahan di 40 Kecamatan se-Kabupaten Bogor.
                        </p>
                    </div>

                    <div class="p-3 rounded-xl bg-white border border-slate-200 space-y-1">
                        <span class="font-bold text-slate-900 block text-xs flex items-center gap-1.5">
                            <i class="fa-solid fa-laptop-code text-slate-600"></i> Digitalisasi SIMKOP & Pelatihan SDM
                        </span>
                        <p class="leading-relaxed text-slate-600 text-[11px]">
                            Penyediaan platform Sistem Informasi Manajemen Koperasi (SIMKOP) untuk pelaporan terpadu, verifikasi anggota, dan pelatihan kapasitas manajerial pengurus koperasi di lapangan.
                        </p>
                    </div>

                    <div class="p-3 rounded-xl bg-white border border-slate-200 space-y-1">
                        <span class="font-bold text-slate-900 block text-xs flex items-center gap-1.5">
                            <i class="fa-solid fa-store text-slate-600"></i> Fasilitasi Gerai & Rantai Pasok Pangan
                        </span>
                        <p class="leading-relaxed text-slate-600 text-[11px]">
                            Kolaborasi lintas instansi untuk penyediaan pasokan komoditas pangan pokok murah, fasilitas gerai fisik, dan akses permodalan usaha bagi koperasi desa.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between shrink-0">
            <span class="text-[11px] text-slate-400">Pusat Informasi Regulasi & KDKMP</span>
            <button type="button" onclick="closeRegulasiModal()" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-semibold cursor-pointer shadow-xs transition active:scale-95">
                Mengerti
            </button>
        </div>
    </div>
</div>

<!-- Modal: Login Petugas & Admin -->
<div id="loginModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-100 transform transition-all">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center space-x-2.5">
                <img src="{{ asset('images/logo-kabupaten-bogor.png') }}" alt="Lambang Kabupaten Bogor" class="h-9 w-auto object-contain shrink-0">
                <div class="w-10 h-10 rounded-full bg-white p-1 flex items-center justify-center border border-slate-200 shadow-sm shrink-0 overflow-hidden">
                    <img src="{{ asset('images/logo-kopdeskel-clean.png') }}" alt="Logo KOP DES KEL" class="w-full h-full object-contain">
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

@push('styles')
<style>
    @keyframes slideDownFade {
        from {
            opacity: 0;
            transform: translateY(-12px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-slide-down {
        animation: slideDownFade 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
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

@push('scripts')
<script src="{{ asset('js/bogor-kecamatan.js') }}"></script>
<script src="{{ asset('js/xlsx.full.min.js') }}"></script>
<script>
    // Data from Laravel Backend
    const kecamatansData = @json($kecamatans);
    const allKoperasiPoints = @json($koperasiMapPoints);
    const timelineSlides = @json($timelineSlides);

    let map;
    let markersLayer;
    let kecamatanBoundaryLayer;
    let tileLayers = {};
    let activeLayerKey = 'osm';
    let currentFacilityFilter = null;

    document.addEventListener('DOMContentLoaded', function () {
        initBogorMap();
        initTimelineSlider();
    });

    // ==========================================
    // 1. TIMELINE SLIDER JAVASCRIPT LOGIC
    // ==========================================
    let currentSlide = 0;
    let slideTimer = null;

    function initTimelineSlider() {
        showSlide(0);
        startSlideAutoPlay();
        initSliderDragAndSwipe();
    }

    function showSlide(index) {
        const slides = document.querySelectorAll('.timeline-slide-item');
        const dots = document.querySelectorAll('.timeline-step-btn');
        if (!slides || slides.length === 0) return;

        currentSlide = (index + slides.length) % slides.length;

        slides.forEach((slide, idx) => {
            if (idx === currentSlide) {
                slide.classList.remove('hidden', 'opacity-0');
                slide.classList.add('block', 'opacity-100');
            } else {
                slide.classList.add('hidden', 'opacity-0');
                slide.classList.remove('block', 'opacity-100');
            }
        });

        dots.forEach((dot, idx) => {
            if (idx === currentSlide) {
                dot.className = 'timeline-step-btn h-2 w-7 bg-red-600 rounded-full shadow-xs transition-all duration-300 cursor-pointer focus:outline-none';
            } else {
                dot.className = 'timeline-step-btn h-2 w-2 bg-slate-300 hover:bg-slate-400 rounded-full transition-all duration-300 cursor-pointer focus:outline-none';
            }
        });

        const counter = document.getElementById('slideCounter');
        if (counter) {
            counter.innerText = `${currentSlide + 1} / ${slides.length}`;
        }
    }

    function nextSlide() {
        showSlide(currentSlide + 1);
    }

    function prevSlide() {
        showSlide(currentSlide - 1);
    }

    function goToSlide(index) {
        showSlide(index);
        stopSlideAutoPlay();
        startSlideAutoPlay();
    }

    function startSlideAutoPlay() {
        stopSlideAutoPlay();
        slideTimer = setInterval(nextSlide, 4500);
    }

    function stopSlideAutoPlay() {
        if (slideTimer) {
            clearInterval(slideTimer);
            slideTimer = null;
        }
    }

    function initSliderDragAndSwipe() {
        const sliderContainer = document.getElementById('timelineSliderContainer');
        if (!sliderContainer) return;

        let startX = 0;
        let isDown = false;
        let diffX = 0;

        // Touch events (Mobile swipe)
        sliderContainer.addEventListener('touchstart', (e) => {
            if (!e.touches || e.touches.length === 0) return;
            startX = e.touches[0].clientX;
            stopSlideAutoPlay();
        }, { passive: true });

        sliderContainer.addEventListener('touchend', (e) => {
            if (!e.changedTouches || e.changedTouches.length === 0) return;
            const endX = e.changedTouches[0].clientX;
            const delta = endX - startX;
            if (Math.abs(delta) > 35) {
                if (delta < 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
            }
            startSlideAutoPlay();
        }, { passive: true });

        // Mouse drag events (Desktop geser)
        sliderContainer.addEventListener('mousedown', (e) => {
            isDown = true;
            startX = e.clientX;
            diffX = 0;
            sliderContainer.classList.add('cursor-grabbing');
            sliderContainer.classList.remove('cursor-grab');
            stopSlideAutoPlay();
        });

        window.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            diffX = e.clientX - startX;
        });

        window.addEventListener('mouseup', () => {
            if (!isDown) return;
            isDown = false;
            sliderContainer.classList.remove('cursor-grabbing');
            sliderContainer.classList.add('cursor-grab');
            if (Math.abs(diffX) > 35) {
                if (diffX < 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
            }
            startSlideAutoPlay();
        });
    }

    // Toggle Card Jenis Fasilitas & Gerai (Dropdown Turun Kebawah Memunculkan Kartu Fasilitas)
    function toggleFacilitiesCard() {
        const wrapper = document.getElementById('facilitiesDropdownWrapper');
        const label = document.getElementById('labelToggleFacilities');
        const icon = document.getElementById('iconToggleFacilities');
        const btn = document.getElementById('btnToggleFacilities');

        if (!wrapper || !label || !icon) return;

        if (wrapper.classList.contains('hidden')) {
            wrapper.classList.remove('hidden');
            wrapper.classList.add('animate-slide-down');
            label.innerText = 'Tutup Detail Fasilitas';
            icon.classList.add('rotate-180');
            if (btn) {
                btn.classList.add('bg-slate-800', 'hover:bg-slate-900');
                btn.classList.remove('bg-red-600', 'hover:bg-red-700');
            }
        } else {
            wrapper.classList.add('hidden');
            wrapper.classList.remove('animate-slide-down');
            label.innerText = 'Lihat Detail Fasilitas';
            icon.classList.remove('rotate-180');
            if (btn) {
                btn.classList.remove('bg-slate-800', 'hover:bg-slate-900');
                btn.classList.add('bg-red-600', 'hover:bg-red-700');
            }
        }
    }

    // ==========================================
    // 2. LEAFLET MAP & GEOSPATIAL LOGIC
    // ==========================================
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
            maxZoom: 18,
            scrollWheelZoom: false,
            dragging: true,
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

        // Add Subdistrict Boundary Polygons (Garis Antar Kecamatan Kabupaten Bogor)
        renderKecamatanBoundaries();

        // Markers group
        markersLayer = L.layerGroup().addTo(map);

        renderKecamatanMarkers();

        // Layer Control matching kdkmp.bogorkab.go.id screenshot
        const baseMaps = {
            "OpenStreetMap": tileLayers.osm,
            "Satelit": tileLayers.satellite,
            "Topografi": tileLayers.topo
        };
        const overlayMaps = {
            "Batas Kecamatan": kecamatanBoundaryLayer,
            "Sebaran Koperasi": markersLayer
        };
        L.control.layers(baseMaps, overlayMaps, { position: 'topright' }).addTo(map);

        // Fit to Kabupaten Bogor
        map.fitBounds(bogorBounds);

        // Open Cisarua popup by default as in screenshot
        const cisarua = kecamatansData.find(k => k.nama === 'CISARUA');
        if (cisarua) {
            setTimeout(() => {
                focusMarker(cisarua.id, false);
            }, 500);
        }

        setTimeout(() => updatePublicLayerGlider(activeLayerKey), 60);
    }

    function renderKecamatanBoundaries() {
        if (!window.BOGOR_KECAMATAN_GEOJSON) {
            console.warn('Data GeoJSON batas kecamatan belum tersedia.');
            return;
        }

        kecamatanBoundaryLayer = L.geoJSON(window.BOGOR_KECAMATAN_GEOJSON, {
            style: function (feature) {
                return {
                    color: '#0284c7', // Cyan/sky blue border matching kdkmp.bogorkab.go.id
                    weight: 1.8,
                    opacity: 0.9,
                    fillColor: '#CFFCFD', // Soft cyan wash
                    fillOpacity: 0.28,
                    dashArray: ''
                };
            },
            onEachFeature: function (feature, layer) {
                const name = feature.properties ? (feature.properties.fullName || feature.properties.name) : 'Kecamatan';

                layer.bindTooltip(name, {
                    sticky: true,
                    direction: 'top',
                    className: 'kecamatan-tooltip'
                });

                layer.on({
                    mouseover: function (e) {
                        const targetLayer = e.target;
                        targetLayer.setStyle({
                            weight: 2.8,
                            color: '#0369a1',
                            fillColor: '#bae6fd',
                            fillOpacity: 0.48
                        });
                        if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                            targetLayer.bringToFront();
                            if (markersLayer) markersLayer.bringToFront();
                        }
                    },
                    mouseout: function (e) {
                        if (kecamatanBoundaryLayer) {
                            kecamatanBoundaryLayer.resetStyle(e.target);
                        }
                    },
                    click: function (e) {
                        const cleanName = (feature.properties.name || '').toUpperCase().trim();
                        const targetKec = kecamatansData.find(k => {
                            const kn = k.nama.toUpperCase().trim();
                            return kn === cleanName || cleanName.includes(kn) || kn.includes(cleanName);
                        });
                        if (targetKec) {
                            focusMarker(targetKec.id, true);
                        }
                    }
                });
            }
        }).addTo(map);
    }

    function toggleKecamatanBoundaries() {
        if (!kecamatanBoundaryLayer) return;
        const btn = document.getElementById('btnToggleBoundaries');
        if (map.hasLayer(kecamatanBoundaryLayer)) {
            map.removeLayer(kecamatanBoundaryLayer);
            if (btn) {
                btn.classList.remove('bg-sky-50', 'text-sky-700', 'border-sky-200');
                btn.classList.add('bg-slate-50', 'text-slate-500', 'border-slate-200');
            }
        } else {
            kecamatanBoundaryLayer.addTo(map);
            if (markersLayer) {
                markersLayer.bringToFront();
            }
            if (btn) {
                btn.classList.add('bg-sky-50', 'text-sky-700', 'border-sky-200');
                btn.classList.remove('bg-slate-50', 'text-slate-500', 'border-slate-200');
            }
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
                    <a href="/kecamatan/${item.id}" style="color: #ffffff !important;" class="w-full text-center py-2 px-3 bg-red-700 hover:bg-red-800 !text-white rounded-lg font-black text-xs transition shadow-sm flex items-center justify-center space-x-1.5 cursor-pointer">
                        <span style="color: #ffffff !important;" class="!text-white font-black">Lihat Profil Kecamatan</span>
                        <i class="fa-solid fa-arrow-right text-[10px]" style="color: #ffffff !important;"></i>
                    </a>
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

    // ==========================================
    // 3. FILTER GERAI / FASILITAS PADA PETA
    // ==========================================
    function filterMapByFacility(typeIds, facilityName, bgClass, btnElement) {
        currentFacilityFilter = { typeIds, facilityName };

        // Highlight active filter button
        document.querySelectorAll('.facility-filter-btn').forEach(btn => {
            btn.classList.remove('ring-4', 'ring-red-500', 'shadow-lg', 'scale-[1.03]');
        });
        if (btnElement) {
            btnElement.classList.add('ring-4', 'ring-red-500', 'shadow-lg', 'scale-[1.03]');
        }

        // Smooth scroll ke section peta (#sebaran)
        const sebaranSection = document.getElementById('sebaran');
        if (sebaranSection) {
            const offset = 90;
            const bodyRect = document.body.getBoundingClientRect().top;
            const elementRect = sebaranSection.getBoundingClientRect().top;
            const elementPosition = elementRect - bodyRect;
            const offsetPosition = elementPosition - offset;

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }

        // Filter koperasi points berdasarkan typeIds
        const filteredPoints = allKoperasiPoints.filter(k => {
            if (!k.types || !Array.isArray(k.types)) return false;
            return typeIds.some(tid => k.types.includes(tid));
        });

        // Update Alert Banner di atas peta
        const alertBanner = document.getElementById('mapFilterAlert');
        const alertName = document.getElementById('filterAlertName');
        const alertCount = document.getElementById('filterAlertCount');
        const badgeText = document.getElementById('mapPointCounterText');

        if (alertBanner && alertName && alertCount) {
            alertName.innerText = facilityName;
            alertCount.innerText = filteredPoints.length;
            alertBanner.classList.remove('hidden');
            alertBanner.classList.add('flex');
        }

        if (badgeText) {
            badgeText.innerText = `${filteredPoints.length} Titik ${facilityName}`;
        }

        // Synchronize select dropdown jika ada
        const select = document.getElementById('facilityFilterSelect');
        if (select) {
            for (let i = 0; i < select.options.length; i++) {
                if (select.options[i].getAttribute('data-name') === facilityName) {
                    select.selectedIndex = i;
                    break;
                }
            }
        }

        // Render marker titik-titik gerai yang terfilter
        renderFilteredFacilityMarkers(filteredPoints, facilityName);
    }

    function onFacilitySelectChange(selectElement) {
        const val = selectElement.value;
        if (val === 'all') {
            resetMapFacilityFilter();
            return;
        }

        try {
            const typeIds = JSON.parse(val);
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const facilityName = selectedOption.getAttribute('data-name') || selectedOption.innerText;
            filterMapByFacility(typeIds, facilityName, '', null);
        } catch (e) {
            console.error('Error parsing facility type IDs:', e);
        }
    }

    function resetMapFacilityFilter() {
        currentFacilityFilter = null;

        // Reset highlight buttons
        document.querySelectorAll('.facility-filter-btn').forEach(btn => {
            btn.classList.remove('ring-4', 'ring-red-500', 'shadow-lg', 'scale-[1.03]');
        });

        // Sembunyikan alert banner
        const alertBanner = document.getElementById('mapFilterAlert');
        if (alertBanner) {
            alertBanner.classList.add('hidden');
            alertBanner.classList.remove('flex');
        }

        // Reset badge text
        const badgeText = document.getElementById('mapPointCounterText');
        if (badgeText) {
            badgeText.innerText = '435 Titik Koperasi Aktif';
        }

        // Reset select dropdown
        const select = document.getElementById('facilityFilterSelect');
        if (select) {
            select.value = 'all';
        }

        // Restore default kecamatan markers & zoom
        renderKecamatanMarkers();
        map.fitBounds([
            [-6.8000, 106.4000],
            [-6.3000, 107.2500]
        ]);
    }

    function renderFilteredFacilityMarkers(points, facilityName) {
        markersLayer.clearLayers();

        if (points.length === 0) {
            return;
        }

        const bounds = [];

        points.forEach((k, idx) => {
            if (!k.lat || !k.lng || k.lat === 0) return;

            bounds.push([k.lat, k.lng]);

            // Eye-catching pin with pulsing beacon
            const markerHtml = `
                <div class="custom-facility-pin" title="${k.nama}">
                    <div class="pin-facility-core">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div class="pin-facility-pulse"></div>
                </div>
            `;

            const customIcon = L.divIcon({
                html: markerHtml,
                className: '',
                iconSize: [36, 36],
                iconAnchor: [18, 34],
                popupAnchor: [0, -32]
            });

            const marker = L.marker([k.lat, k.lng], { icon: customIcon });

            const popupContent = `
                <div class="text-xs" style="min-width: 220px; max-width: 280px;">
                    <div class="font-bold text-slate-800 text-xs pb-1.5 mb-1.5 border-b border-red-100 flex items-center justify-between">
                        <span class="text-red-700 truncate pr-1">${k.nama}</span>
                    </div>
                    <div class="flex items-center space-x-1.5 text-[10px] text-slate-600 mb-1.5">
                        <span class="px-2 py-0.5 rounded-full bg-slate-100 font-bold text-slate-700">Kec. ${k.kecamatan}</span>
                        <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-semibold border border-emerald-100">Desa ${k.desa}</span>
                    </div>
                    <div class="p-2 rounded-lg bg-red-50/70 border border-red-100 text-[11px] mb-2 space-y-1">
                        <div class="text-slate-600 line-clamp-2">
                            <i class="fa-solid fa-map-pin text-red-500 mr-1"></i>
                            <span>${k.alamat || 'Alamat kantor terdaftar di wilayah desa.'}</span>
                        </div>
                        ${k.telp && k.telp !== '-' ? `<div class="text-slate-600"><i class="fa-solid fa-phone text-blue-500 mr-1"></i><span>${k.telp}</span></div>` : ''}
                    </div>
                    <div class="flex items-center justify-between pt-1">
                        <span class="text-[10px] font-extrabold text-red-700 uppercase tracking-wide">
                            <i class="fa-solid fa-check text-emerald-600 mr-0.5"></i> ${facilityName}
                        </span>
                        <a href="https://www.google.com/maps/search/?api=1&query=${k.lat},${k.lng}" target="_blank" class="px-2.5 py-1 rounded bg-red-700 hover:bg-red-800 text-white font-bold text-[10px] transition inline-flex items-center space-x-1 shadow-2xs">
                            <span>Buka Maps</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[8px]"></i>
                        </a>
                    </div>
                </div>
            `;

            marker.bindPopup(popupContent, {
                closeButton: true,
                autoPan: true
            });

            marker.addTo(markersLayer);
        });

        if (bounds.length > 0) {
            map.fitBounds(bounds, { padding: [50, 50], maxZoom: 14 });
            // Buka popup marker pertama secara otomatis
            const layers = markersLayer.getLayers();
            if (layers.length > 0) {
                setTimeout(() => layers[0].openPopup(), 400);
            }
        }
    }

    function updatePublicLayerGlider(layerName) {
        const key = layerName || activeLayerKey;
        const keyMap = {
            'osm': 'btnLayerOsm',
            'satellite': 'btnLayerSat',
            'topo': 'btnLayerTopo'
        };
        const activeBtn = document.getElementById(keyMap[key]);
        const glider = document.getElementById('publicLayerGlider');
        if (glider && activeBtn && activeBtn.offsetWidth > 0) {
            glider.style.left = activeBtn.offsetLeft + 'px';
            glider.style.top = activeBtn.offsetTop + 'px';
            glider.style.width = activeBtn.offsetWidth + 'px';
            glider.style.height = activeBtn.offsetHeight + 'px';
        }

        ['btnLayerOsm', 'btnLayerSat', 'btnLayerTopo'].forEach(btnId => {
            const btn = document.getElementById(btnId);
            if (!btn) return;
            if (activeBtn && btnId === activeBtn.id) {
                btn.className = "relative z-10 px-3 py-1 rounded-md text-white font-semibold transition-colors duration-200 cursor-pointer";
            } else {
                btn.className = "relative z-10 px-3 py-1 rounded-md text-slate-600 hover:text-slate-900 font-semibold transition-colors duration-200 cursor-pointer";
            }
        });
    }

    function switchMapLayer(layerName) {
        updatePublicLayerGlider(layerName);

        if (layerName === activeLayerKey) return;

        if (map && tileLayers[activeLayerKey] && tileLayers[layerName]) {
            map.removeLayer(tileLayers[activeLayerKey]);
            tileLayers[layerName].addTo(map);
            activeLayerKey = layerName;
        }
    }

    window.addEventListener('resize', () => {
        updatePublicLayerGlider(activeLayerKey);
    });

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

    function toggleRegulasiAccordion(id) {
        const content = document.getElementById(id);
        const icon = document.getElementById('accordion-icon-' + id);
        if (!content) return;

        const isHidden = content.classList.contains('hidden');
        if (isHidden) {
            content.classList.remove('hidden');
            if (icon) {
                icon.classList.remove('-rotate-90');
                icon.classList.add('rotate-0');
            }
        } else {
            content.classList.add('hidden');
            if (icon) {
                icon.classList.add('-rotate-90');
                icon.classList.remove('rotate-0');
            }
        }
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

    // Scrollspy Handler untuk Navbar Indikator Status ON
    const navItems = {
        beranda: document.getElementById('nav-beranda'),
        informasi: document.getElementById('nav-informasi'),
        sebaran: document.getElementById('nav-sebaran'),
    };

    function updateScrollspy() {
        const scrollY = window.scrollY || window.pageYOffset;
        const offset = 140; // Offset untuk navbar sticky

        const berandaSec = document.getElementById('beranda');
        const infoSec = document.getElementById('informasi');
        const sebaranSec = document.getElementById('sebaran');

        const infoTop = infoSec ? infoSec.offsetTop - offset : 999999;
        const sebaranTop = sebaranSec ? sebaranSec.offsetTop - offset : 999999;

        let active = 'beranda';
        if (scrollY >= sebaranTop) {
            active = 'sebaran';
        } else if (scrollY >= infoTop) {
            active = 'informasi';
        } else {
            active = 'beranda';
        }

        Object.keys(navItems).forEach(key => {
            const el = navItems[key];
            if (!el) return;
            if (key === active) {
                el.className = 'nav-link px-3.5 py-1.5 rounded-full bg-white/20 text-white shadow-sm font-bold transition-all duration-200';
            } else {
                el.className = 'nav-link px-3.5 py-1.5 rounded-full text-red-100 hover:text-white hover:bg-white/10 font-medium transition-all duration-200';
            }
        });
    }

    window.addEventListener('scroll', updateScrollspy, { passive: true });
    window.addEventListener('load', updateScrollspy);

    // Document Card, Spreadsheet Viewer & Dropdown Handler (Dropdown turun kebawah & melebar kebawah sesuai gambar referensi)
    let currentSelectedDoc = {
        url: '{{ $defaultFile['url'] }}',
        title: '{{ addslashes($defaultFile['title']) }}',
        subtitle: '{!! addslashes($defaultFile['subtitle']) !!}',
        ext: '{{ $defaultFile['ext'] }}',
        filename: '{{ addslashes($defaultFile['filename'] ?? ($defaultFile['title'].'.'.$defaultFile['ext'])) }}',
        index: 0
    };

    function getDocTypeInfo(ext) {
        switch ((ext || '').toLowerCase()) {
            case 'xlsx':
            case 'xls':
            case 'csv':
                return { icon: 'fa-solid fa-file-excel', color: 'text-emerald-600', badge: 'bg-emerald-100 text-emerald-700', label: 'Excel' };
            case 'pdf':
                return { icon: 'fa-solid fa-file-pdf', color: 'text-red-600', badge: 'bg-red-100 text-red-700', label: 'PDF' };
            case 'doc':
            case 'docx':
                return { icon: 'fa-solid fa-file-word', color: 'text-blue-600', badge: 'bg-blue-100 text-blue-700', label: 'Word' };
            case 'png':
            case 'jpg':
            case 'jpeg':
            case 'webp':
                return { icon: 'fa-solid fa-file-image', color: 'text-purple-600', badge: 'bg-purple-100 text-purple-700', label: 'Gambar' };
            default:
                return { icon: 'fa-solid fa-file-lines', color: 'text-slate-600', badge: 'bg-slate-100 text-slate-700', label: 'Dokumen' };
        }
    }

    function toggleLampiranDropdown() {
        const dropdown = document.getElementById('dropdownMenuLampiran');
        const card = document.getElementById('progresDocCard');
        const chevron = document.getElementById('iconCurrentDocChevron');
        const totalFiles = {{ !empty($informasiFiles) ? count($informasiFiles) : 1 }};

        // Jika dokumen card sedang terbuka, klik tombol utama akan menutupnya
        if (card && !card.classList.contains('hidden') && dropdown && dropdown.classList.contains('hidden')) {
            closeProgresDocCard();
            return;
        }

        if (totalFiles > 1) {
            // Jika ada lebih dari 1 file, buka/tutup menu dropdown opsi file
            const isHidden = dropdown.classList.contains('hidden');
            if (isHidden) {
                dropdown.classList.remove('hidden');
                if (chevron) chevron.classList.add('rotate-180');
            } else {
                dropdown.classList.add('hidden');
                if (chevron) chevron.classList.remove('rotate-180');
            }
        } else {
            // Jika hanya 1 file, langsung toggle buka/tutup viewer dokumen
            toggleProgresDocCard(currentSelectedDoc.url, currentSelectedDoc.title, currentSelectedDoc.subtitle, currentSelectedDoc.ext, currentSelectedDoc.filename);
        }
    }

    function selectLampiranDoc(url, title, subtitle, ext, filename, idx = 0) {
        currentSelectedDoc = { url, title, subtitle, ext, filename, index: idx };

        // Update teks judul dan icon di tombol utama
        const titleEl = document.getElementById('labelCurrentDocTitle');
        if (titleEl) titleEl.innerText = title;

        const typeInfo = getDocTypeInfo(ext);
        const iconWrapper = document.getElementById('mainDocIconWrapper');
        const iconEl = document.getElementById('mainDocIcon');
        if (iconWrapper && iconEl) {
            iconWrapper.className = `w-6 h-6 rounded-full ${typeInfo.badge} flex items-center justify-center text-xs transition shrink-0`;
            iconEl.className = `${typeInfo.icon} ${typeInfo.color}`;
        }

        // Update active style di switcher tabs (Dokumen 1, Dokumen 2, dst)
        const switcherBtns = document.querySelectorAll('.doc-switcher-btn');
        switcherBtns.forEach((btn, bIdx) => {
            if (bIdx === idx) {
                btn.className = 'doc-switcher-btn px-2.5 py-1 rounded-lg text-[11px] font-bold transition bg-white text-blue-900 shadow-xs cursor-pointer truncate max-w-[120px]';
            } else {
                btn.className = 'doc-switcher-btn px-2.5 py-1 rounded-lg text-[11px] font-bold transition text-white/80 hover:bg-white/10 hover:text-white cursor-pointer truncate max-w-[120px]';
            }
        });

        // Tutup dropdown menu
        const dropdown = document.getElementById('dropdownMenuLampiran');
        if (dropdown) dropdown.classList.add('hidden');

        // Buka kartu viewer dengan file yang dipilih
        toggleProgresDocCard(url, title, subtitle, ext, filename, true);
    }

    function toggleProgresDocCard(url, title, subtitle, ext, filename, forceOpen = false) {
        const card = document.getElementById('progresDocCard');
        if (!card) return;

        const mainBtn = document.getElementById('btnMainTriggerDoc');
        const actionLabel = document.getElementById('labelCurrentDocAction');
        const chevron = document.getElementById('iconCurrentDocChevron');

        if (!forceOpen && !card.classList.contains('hidden')) {
            closeProgresDocCard();
            return;
        }

        const typeInfo = getDocTypeInfo(ext);

        // Header Card Info
        const titleEl = document.getElementById('docCardTitle');
        const subtitleEl = document.getElementById('docCardSubtitle');
        const iconEl = document.getElementById('docCardIcon');
        if (titleEl) titleEl.innerText = title;
        if (subtitleEl) subtitleEl.innerHTML = subtitle;
        if (iconEl) iconEl.innerHTML = `<i class="${typeInfo.icon} text-base"></i>`;

        // Action Buttons
        const dlBtn = document.getElementById('btnDocDownload');
        const dlLabel = document.getElementById('btnDocDownloadLabel');
        const extBtn = document.getElementById('btnDocExternal');
        if (dlBtn) {
            dlBtn.href = url;
            dlBtn.setAttribute('download', filename || (title + '.' + ext));
        }
        if (dlLabel) dlLabel.innerText = `Unduh ${typeInfo.label}`;
        if (extBtn) extBtn.href = url;

        // Container references
        const iframe = document.getElementById('docViewerIframe');
        const spreadsheetContainer = document.getElementById('docViewerSpreadsheet');
        const imgContainer = document.getElementById('docViewerImage');
        const imgEl = document.getElementById('imgViewerElement');
        const fallbackContainer = document.getElementById('docViewerFallback');

        // Reset visibility
        if (iframe) iframe.classList.add('hidden');
        if (spreadsheetContainer) spreadsheetContainer.classList.add('hidden');
        if (imgContainer) imgContainer.classList.add('hidden');
        if (fallbackContainer) fallbackContainer.classList.add('hidden');

        const cleanExt = (ext || '').toLowerCase();

        if (cleanExt === 'xlsx' || cleanExt === 'xls' || cleanExt === 'csv') {
            // Excel Spreadsheet Mode (Render inside interactive table without auto-download)
            if (iframe) iframe.src = 'about:blank';
            if (spreadsheetContainer) spreadsheetContainer.classList.remove('hidden');
            renderSpreadsheet(url, filename || title);
        } else if (cleanExt === 'pdf') {
            // PDF Mode (Native browser PDF reader in iframe)
            if (iframe) {
                iframe.classList.remove('hidden');
                const viewerUrl = url.includes('#') ? url : `${url}#toolbar=1&navpanes=0&scrollbar=1&view=FitH`;
                if (iframe.src !== viewerUrl) {
                    iframe.src = viewerUrl;
                }
            }
        } else if (['png', 'jpg', 'jpeg', 'webp', 'gif', 'svg'].includes(cleanExt)) {
            // Image Mode
            if (iframe) iframe.src = 'about:blank';
            if (imgContainer && imgEl) {
                imgEl.src = url;
                imgContainer.classList.remove('hidden');
            }
        } else {
            // Generic Document Mode
            if (iframe) iframe.src = 'about:blank';
            if (fallbackContainer) {
                fallbackContainer.classList.remove('hidden');
                const fbTitle = document.getElementById('fallbackDocTitle');
                if (fbTitle) fbTitle.innerText = title;
                const fbDl = document.getElementById('fallbackDownloadBtn');
                if (fbDl) {
                    fbDl.href = url;
                    fbDl.setAttribute('download', filename || (title + '.' + ext));
                }
                const fbOpen = document.getElementById('fallbackOpenBtn');
                if (fbOpen) fbOpen.href = url;
            }
        }

        // Active button styling
        if (mainBtn) {
            mainBtn.classList.add('border-blue-600', 'bg-blue-50', 'text-blue-700');
            mainBtn.classList.remove('bg-white', 'text-slate-700', 'border-slate-300');
        }
        if (actionLabel) actionLabel.innerText = 'Tutup Detail';
        if (chevron) chevron.classList.add('rotate-180');

        // Reveal card with smooth slide down
        card.classList.remove('hidden');
        card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function closeProgresDocCard() {
        const card = document.getElementById('progresDocCard');
        if (card) card.classList.add('hidden');

        // Clear iframe to stop background activity
        const iframe = document.getElementById('docViewerIframe');
        if (iframe) iframe.src = 'about:blank';

        const mainBtn = document.getElementById('btnMainTriggerDoc');
        if (mainBtn) {
            mainBtn.classList.remove('border-blue-600', 'bg-blue-50', 'text-blue-700');
            mainBtn.classList.add('bg-white', 'text-slate-700', 'border-slate-300');
        }
        const actionLabel = document.getElementById('labelCurrentDocAction');
        if (actionLabel) actionLabel.innerText = 'Lihat Detail';

        const chevron = document.getElementById('iconCurrentDocChevron');
        if (chevron) chevron.classList.remove('rotate-180');
    }

    // Render interactive Excel sheet via SheetJS
    function renderSpreadsheet(url, filename) {
        const loading = document.getElementById('docViewerLoading');
        const container = document.getElementById('spreadsheetTableContainer');
        const tabsContainer = document.getElementById('spreadsheetSheetTabs');
        const nameEl = document.getElementById('sheetDocName');
        const statsEl = document.getElementById('sheetStatsInfo');
        const activeBadge = document.getElementById('sheetActiveNameBadge');

        if (loading) loading.classList.remove('hidden');
        if (nameEl) nameEl.innerText = filename;
        if (container) container.innerHTML = '<div class="p-8 text-center text-slate-400">Membaca file Excel...</div>';
        if (tabsContainer) tabsContainer.innerHTML = '';

        if (typeof XLSX === 'undefined') {
            if (loading) loading.classList.add('hidden');
            if (container) {
                container.innerHTML = `
                    <div class="p-8 text-center space-y-3">
                        <div class="w-12 h-12 mx-auto rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-file-excel"></i>
                        </div>
                        <h4 class="text-sm font-bold text-slate-800">Dokumen Spreadsheet Siap Diunduh</h4>
                        <p class="text-xs text-slate-500 max-w-md mx-auto">Klik tombol di bawah untuk mengunduh dan membuka file dengan Microsoft Excel atau spreadsheet viewer.</p>
                        <a href="${url}" download class="inline-flex items-center space-x-2 px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition shadow-sm">
                            <i class="fa-solid fa-download"></i>
                            <span>Unduh File Excel</span>
                        </a>
                    </div>
                `;
            }
            return;
        }

        fetch(url)
            .then(res => {
                if (!res.ok) throw new Error('Gagal mengunduh file spreadsheet');
                return res.arrayBuffer();
            })
            .then(buffer => {
                const workbook = XLSX.read(buffer, { type: 'array' });
                if (!workbook || !workbook.SheetNames || workbook.SheetNames.length === 0) {
                    throw new Error('Tidak ada lembar kerja pada file ini.');
                }

                function displaySheet(sheetName) {
                    const sheet = workbook.Sheets[sheetName];
                    if (!sheet) return;

                    if (activeBadge) activeBadge.innerText = sheetName;

                    // Update active button tabs
                    tabsContainer.querySelectorAll('.sheet-tab-btn').forEach(btn => {
                        if (btn.getAttribute('data-sheet') === sheetName) {
                            btn.className = 'sheet-tab-btn px-2.5 py-1 rounded bg-white text-emerald-900 text-[11px] font-bold shadow-xs cursor-pointer';
                        } else {
                            btn.className = 'sheet-tab-btn px-2.5 py-1 rounded bg-emerald-900/60 hover:bg-emerald-900 text-emerald-100 text-[11px] font-medium cursor-pointer transition';
                        }
                    });

                    // Generate HTML Table from Sheet
                    const html = XLSX.utils.sheet_to_html(sheet, {
                        id: 'excelRenderedTable',
                        editable: false
                    });

                    container.innerHTML = `
                        <div class="overflow-auto border border-slate-200 rounded-lg shadow-2xs">
                            ${html}
                        </div>
                    `;

                    // Style the rendered table
                    const table = container.querySelector('table');
                    if (table) {
                        table.className = 'min-w-full border-collapse text-xs text-slate-800 text-left bg-white';
                        table.querySelectorAll('tr').forEach((tr, rIdx) => {
                            if (rIdx === 0) {
                                tr.className = 'bg-slate-100 font-bold border-b border-slate-300';
                            } else {
                                tr.className = 'hover:bg-blue-50/30 border-b border-slate-200';
                            }
                            tr.querySelectorAll('td, th').forEach(cell => {
                                cell.className += ' px-3 py-2 border-r border-slate-200 whitespace-nowrap text-xs';
                            });
                        });

                        const rowCount = table.querySelectorAll('tr').length;
                        if (statsEl) statsEl.innerText = `${rowCount} Baris Data`;
                    }
                }

                // Create sheet tabs
                workbook.SheetNames.forEach((sName) => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'sheet-tab-btn px-2.5 py-1 rounded text-[11px] cursor-pointer';
                    btn.setAttribute('data-sheet', sName);
                    btn.innerText = sName;
                    btn.onclick = () => displaySheet(sName);
                    tabsContainer.appendChild(btn);
                });

                // Display first sheet
                displaySheet(workbook.SheetNames[0]);
                if (loading) loading.classList.add('hidden');
            })
            .catch(err => {
                console.error('Spreadsheet preview error:', err);
                if (loading) loading.classList.add('hidden');
                if (container) {
                    container.innerHTML = `
                        <div class="p-8 text-center space-y-3">
                            <div class="w-12 h-12 mx-auto rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl">
                                <i class="fa-solid fa-file-excel"></i>
                            </div>
                            <h4 class="text-sm font-bold text-slate-800">Dokumen Spreadsheet</h4>
                            <p class="text-xs text-slate-500 max-w-md mx-auto">File spreadsheet dapat diunduh langsung untuk dibuka di Microsoft Excel atau Google Spreadsheet.</p>
                            <a href="${url}" download class="inline-flex items-center space-x-2 px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition">
                                <i class="fa-solid fa-download"></i>
                                <span>Unduh File Excel</span>
                            </a>
                        </div>
                    `;
                }
            });
    }

    // Close dropdown on click outside
    document.addEventListener('click', function (e) {
        const dropdown = document.getElementById('dropdownMenuLampiran');
        const mainBtn = document.getElementById('btnMainTriggerDoc');
        if (dropdown && !dropdown.classList.contains('hidden')) {
            if (!dropdown.contains(e.target) && (!mainBtn || !mainBtn.contains(e.target))) {
                dropdown.classList.add('hidden');
                const chevron = document.getElementById('iconCurrentDocChevron');
                if (chevron && document.getElementById('progresDocCard')?.classList.contains('hidden')) {
                    chevron.classList.remove('rotate-180');
                }
            }
        }
    });

    @if(session('open_login') || $errors->any())
        openLoginModal();
    @endif
</script>
@endpush
