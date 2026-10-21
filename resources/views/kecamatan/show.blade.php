@extends('layouts.app')

@section('title', 'Koperasi Merah Putih Kecamatan ' . $kecamatan->nama . ' | Dashboard KMP')

@section('content')
<div class="min-h-screen bg-[#f8fafc] flex flex-col justify-between">

    <!-- Top Navigation Header -->
    <header class="bg-gradient-to-r from-[#881337] via-[#991b1b] to-[#7f1d1d] text-white shadow-md sticky top-0 z-[100]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14 sm:h-16">
                <!-- Brand / Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 sm:space-x-3.5 group">
                    <img src="{{ asset('images/logo-kabupaten-bogor.png') }}" alt="Lambang Kabupaten Bogor" class="h-8 sm:h-10 w-auto object-contain drop-shadow shrink-0 transition-transform group-hover:scale-105">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-white flex items-center justify-center p-1 shadow-md shrink-0 border border-white/50 overflow-hidden">
                        <img src="{{ asset('images/logo-kopdeskel-clean.png') }}" alt="Logo KOP DES KEL Merah Putih" class="w-full h-full object-contain">
                    </div>
                    <div class="flex flex-col">
                        <span class="text-base sm:text-xl font-bold tracking-tight text-white group-hover:text-red-100 transition-colors leading-tight">
                            Dashboard KMP
                        </span>
                        <span class="text-[10px] sm:text-xs text-red-200 font-medium">Kabupaten Bogor</span>
                    </div>
                </a>

                <!-- Back button / Kembali -->
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 text-xs sm:text-sm font-semibold text-white/95 hover:text-white bg-white/10 hover:bg-white/20 active:scale-95 px-4 py-1.5 rounded-full border border-white/20 transition-all shadow-sm">
                    <i class="fa-solid fa-arrow-left text-xs transition-transform group-hover:-translate-x-0.5"></i>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Header Decorative Wave & Title Banner -->
    <div class="relative bg-gradient-to-b from-slate-100/60 to-transparent pt-7 pb-6 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight uppercase">
                KOPERASI MERAH PUTIH
            </h1>
            <h2 class="text-xl sm:text-2xl font-black text-slate-800 mt-1 tracking-wide uppercase">
                KECAMATAN {{ $kecamatan->nama }}
            </h2>

            <!-- Quick Summary Badges (Strong & Bold) -->
            <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3 mt-4 text-xs font-bold">
                <span class="inline-flex items-center px-3.5 py-1.5 rounded-xl bg-white shadow-sm border border-slate-300 text-slate-800">
                    <i class="fa-solid fa-building-flag text-slate-600 mr-1.5"></i>
                    Total: <strong class="ml-1 text-slate-950 font-black">{{ $koperasis->count() }} Koperasi</strong>
                </span>
                <span class="inline-flex items-center px-3.5 py-1.5 rounded-xl bg-white shadow-sm border border-slate-300 text-slate-800">
                    <i class="fa-solid fa-tree-city text-slate-600 mr-1.5"></i>
                    Kop. Desa: <strong class="ml-1 text-slate-950 font-black">{{ $koperasis->where('cat_koperasi', 'KOPERASI DESA')->count() }}</strong>
                </span>
                <span class="inline-flex items-center px-3.5 py-1.5 rounded-xl bg-white shadow-sm border border-slate-300 text-slate-800">
                    <i class="fa-solid fa-city text-slate-600 mr-1.5"></i>
                    Kop. Kelurahan: <strong class="ml-1 text-slate-950 font-black">{{ $koperasis->where('cat_koperasi', 'KOPERASI KELURAHAN')->count() }}</strong>
                </span>
                <span class="inline-flex items-center px-3.5 py-1.5 rounded-xl bg-white shadow-sm border border-slate-300 text-slate-800">
                    <i class="fa-solid fa-users text-slate-600 mr-1.5"></i>
                    Total Anggota: <strong class="ml-1 text-slate-950 font-black">{{ number_format($koperasis->sum('jum_anggota') ?: ($koperasis->count() * 20)) }}</strong>
                </span>
            </div>
        </div>
    </div>

    <!-- Main Content Container -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12 w-full flex-grow">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-4 sm:p-6 lg:p-7">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">
                
                <!-- Left Column: Interactive Leaflet Map -->
                <div class="lg:col-span-5 flex flex-col">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-base sm:text-lg font-black text-slate-950 flex items-center space-x-2">
                            <i class="fa-solid fa-location-dot text-red-600"></i>
                            <span>Sebaran Koperasi Merah Putih</span>
                        </h3>
                        <!-- Reset Map Button -->
                        <button type="button" id="btnResetMap" class="text-xs font-black text-slate-800 hover:text-red-700 bg-slate-100 hover:bg-red-50 border border-slate-300 px-3 py-1 rounded-lg transition-colors flex items-center space-x-1 shadow-sm" title="Kembalikan posisi peta ke batas kecamatan">
                            <i class="fa-solid fa-arrows-rotate text-[11px]"></i>
                            <span>Reset Peta</span>
                        </button>
                    </div>

                    <!-- Map Container with Layer Control & Loading Indicator -->
                    <div class="relative w-full rounded-2xl border-2 border-slate-200 overflow-hidden shadow-inner bg-slate-100 h-[460px] sm:h-[520px] lg:h-[560px] group">
                        <div id="kecamatanMap" class="w-full h-full z-10"></div>
                        
                        <!-- Floating Map Legend -->
                        <div class="absolute bottom-3 left-3 z-20 bg-white/95 backdrop-blur-sm px-3.5 py-2 rounded-xl shadow-md border border-slate-300 text-xs pointer-events-none">
                            <div class="flex items-center space-x-2 font-black text-slate-950">
                                <span class="w-3 h-3 rounded-full bg-blue-600 border-2 border-white shadow-sm inline-block"></span>
                                <span>{{ $koperasis->count() }} Titik Terdaftar</span>
                            </div>
                        </div>

                        <!-- Map loading fallback indicator -->
                        <div id="mapLoading" class="absolute inset-0 bg-white/80 flex items-center justify-center z-30 transition-opacity duration-300 pointer-events-none">
                            <div class="flex items-center space-x-2.5 text-xs font-black text-slate-900 bg-white px-4 py-2.5 rounded-xl shadow-lg border border-slate-300">
                                <i class="fa-solid fa-circle-notch fa-spin text-red-600 text-base"></i>
                                <span>Memuat peta wilayah kecamatan...</span>
                            </div>
                        </div>
                    </div>

                    <p class="text-xs text-slate-700 mt-2.5 text-center flex items-center justify-center space-x-1 font-bold">
                        <i class="fa-solid fa-hand-pointer text-blue-600 text-xs"></i>
                        <span>Arahkan kursor atau klik pin di peta untuk melihat detail koperasi</span>
                    </p>
                </div>

                <!-- Right Column: Interactive Table with Live Search -->
                <div class="lg:col-span-7 flex flex-col">
                    
                    <!-- Search & Filter Controls -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 mb-4">
                        <!-- Search Box -->
                        <div class="relative flex-grow">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            </div>
                            <input type="text" id="koperasiSearch" placeholder="Cari nama koperasi atau desa..." class="w-full pl-9 pr-8 py-2.5 bg-slate-50 focus:bg-white text-xs sm:text-sm font-bold rounded-xl border-2 border-slate-300 focus:border-slate-700 focus:ring-2 focus:ring-slate-200 outline-none transition-all placeholder:text-slate-400 text-slate-900 shadow-sm">
                            <button type="button" id="clearSearch" class="hidden absolute inset-y-0 right-0 pr-3 flex items-center text-slate-500 hover:text-slate-800 text-xs">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        <!-- Filter Status Pills -->
                        <div class="flex items-center space-x-1.5 shrink-0 text-xs">
                            <button type="button" data-filter="all" class="filter-btn active px-3.5 py-2 rounded-xl font-black uppercase tracking-wide bg-slate-950 text-white shadow-sm transition-all">
                                Semua
                            </button>
                            <button type="button" data-filter="sudah" class="filter-btn px-3 py-2 rounded-xl font-black uppercase tracking-wide bg-slate-100 hover:bg-slate-200 text-slate-900 border border-slate-300 transition-all">
                                Operasional
                            </button>
                            <button type="button" data-filter="ahu" class="filter-btn px-3 py-2 rounded-xl font-black uppercase tracking-wide bg-slate-100 hover:bg-slate-200 text-slate-900 border border-slate-300 transition-all">
                                Ber-AHU
                            </button>
                        </div>
                    </div>

                    <!-- Table Container -->
                    <div class="overflow-x-auto rounded-2xl border-2 border-slate-200 shadow-sm bg-white">
                        <table class="w-full text-left text-sm" id="tableKoperasi">
                            <thead class="bg-slate-100 text-slate-950 font-black text-xs uppercase tracking-wider border-b-2 border-slate-300">
                                <tr>
                                    <th scope="col" class="py-3.5 px-3 text-center w-12 font-black">#</th>
                                    <th scope="col" class="py-3.5 px-4 font-black">KOPERASI</th>
                                    <th scope="col" class="py-3.5 px-3 text-center w-28 font-black">OPERASIONAL</th>
                                    <th scope="col" class="py-3.5 px-3 text-left font-black">SERTIFIKAT</th>
                                    <th scope="col" class="py-3.5 px-3 text-center w-20 font-black">ANGGOTA</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200/80" id="tableBody">
                                @forelse ($koperasis as $index => $item)
                                    <tr class="koperasi-row hover:bg-blue-50/50 transition-all duration-150 cursor-pointer group"
                                        id="koperasi-row-{{ $item->id_koperasi }}"
                                        data-id="{{ $item->id_koperasi }}"
                                        data-name="{{ strtolower($item->name_koperasi) }}"
                                        data-desa="{{ strtolower($item->kelurahan?->name_kopkel ?? '') }}"
                                        data-ops="{{ strtolower($item->st_ops ?? 'sudah') }}"
                                        data-ahu="{{ !empty($item->no_ahu) && $item->no_ahu !== 'BELUM' ? '1' : '0' }}">
                                        
                                        <!-- Number -->
                                        <td class="py-3.5 px-3 text-center text-slate-900 font-black text-xs sm:text-sm">
                                             {{ $index + 1 }}
                                        </td>

                                        <!-- Koperasi Name & Link -->
                                        <td class="py-3.5 px-4">
                                            <a href="{{ route('koperasi.show', $item->id_koperasi) }}" class="text-[#1d4ed8] hover:text-[#1e40af] font-black text-xs sm:text-sm hover:underline leading-snug block tracking-tight">
                                                {{ $item->name_koperasi }}
                                            </a>
                                            @if($item->kelurahan)
                                                <span class="text-[11px] text-slate-700 block mt-1 font-bold">
                                                    Desa/Kelurahan: <span class="font-black text-slate-950">{{ $item->kelurahan->name_kopkel }}</span>
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Status Operasional Text (Strong) -->
                                        <td class="py-3.5 px-3 text-center">
                                            <span class="text-xs sm:text-sm font-black uppercase text-slate-950 tracking-wide">
                                                {{ $item->st_ops ?? 'SUDAH' }}
                                            </span>
                                        </td>

                                        <!-- Sertifikat AHU (Strong) -->
                                        <td class="py-3.5 px-3 text-xs sm:text-sm font-black text-slate-900 leading-tight">
                                            {{ $item->no_ahu ?: 'BELUM' }}
                                        </td>

                                        <!-- Anggota (Strong) -->
                                        <td class="py-3.5 px-3 text-center font-black text-slate-950 text-sm sm:text-base">
                                            {{ number_format($item->jum_anggota ?? 20) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-10 text-center text-slate-500 text-sm">
                                            <i class="fa-solid fa-folder-open text-3xl text-slate-300 block mb-2"></i>
                                            Belum ada data koperasi untuk kecamatan ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- No Results Match State -->
                    <div id="noResults" class="hidden py-8 text-center bg-slate-50 rounded-xl border border-dashed border-slate-200 mt-2">
                        <i class="fa-solid fa-circle-exclamation text-amber-500 text-2xl mb-1"></i>
                        <p class="text-xs font-semibold text-slate-700">Tidak ada koperasi yang cocok dengan pencarian.</p>
                        <button type="button" onclick="resetSearchFilter()" class="mt-2 text-xs font-bold text-red-600 hover:underline">
                            Reset Pencarian
                        </button>
                    </div>

                    <!-- Result Counter Footer -->
                    <div class="mt-3 text-right text-xs text-slate-500 font-medium">
                        Menampilkan <span id="visibleCount" class="font-bold text-slate-800">{{ $koperasis->count() }}</span> dari {{ $koperasis->count() }} Koperasi
                    </div>

                </div>

            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-6 text-center text-xs text-slate-500 border-t border-slate-200 bg-white">
        <p class="font-medium text-slate-600">Dashboard Koperasi Merah Putih Kabupaten Bogor</p>
        <p class="mt-1 text-slate-400">Diskominfo &copy; 2025</p>
    </footer>

</div>
@endsection

@push('styles')
<style>
    .custom-kec-marker {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        background: linear-gradient(135deg, #0284c7, #0369a1);
        border: 2.5px solid #ffffff;
        border-radius: 50%;
        color: #ffffff;
        font-size: 13px;
        box-shadow: 0 4px 10px rgba(2, 132, 199, 0.45);
        cursor: pointer;
        transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.2s ease, background 0.2s ease;
    }
    .custom-kec-marker:hover, .custom-kec-marker.active-pin {
        transform: scale(1.3);
        background: linear-gradient(135deg, #dc2626, #991b1b);
        box-shadow: 0 6px 16px rgba(220, 38, 38, 0.6);
        z-index: 9999 !important;
    }
    .filter-btn.active {
        background-color: #dc2626 !important;
        color: #ffffff !important;
    }
    .highlight-row {
        background-color: #eff6ff !important;
        box-shadow: inset 4px 0 0 #2563eb;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const points = @json($koperasiPoints);
    const loadingElem = document.getElementById('mapLoading');
    const searchInput = document.getElementById('koperasiSearch');
    const clearBtn = document.getElementById('clearSearch');
    const filterBtns = document.querySelectorAll('.filter-btn');
    const rows = document.querySelectorAll('.koperasi-row');
    const noResults = document.getElementById('noResults');
    const visibleCount = document.getElementById('visibleCount');
    const btnResetMap = document.getElementById('btnResetMap');

    // Default center Kabupaten Bogor
    let defaultLat = -6.4828;
    let defaultLng = 106.8486;

    const map = L.map('kecamatanMap', {
        zoomControl: true,
        scrollWheelZoom: true
    }).setView([defaultLat, defaultLng], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    const bounds = [];
    const markersMap = {}; // mapping id -> marker

    if (Array.isArray(points) && points.length > 0) {
        points.forEach(p => {
            const lat = parseFloat(p.lat);
            const lng = parseFloat(p.lng);

            if (!isNaN(lat) && !isNaN(lng) && lat !== 0 && lng !== 0) {
                bounds.push([lat, lng]);

                // Create custom pin with house icon
                const icon = L.divIcon({
                    className: 'kec-icon-container',
                    html: `<div class="custom-kec-marker" id="pin-${p.id}"><i class="fa-solid fa-house"></i></div>`,
                    iconSize: [34, 34],
                    iconAnchor: [17, 17],
                    popupAnchor: [0, -18]
                });

                const popupHtml = `
                    <div class="p-1 min-w-[190px]">
                        <span class="inline-block px-2 py-0.5 bg-blue-100 text-blue-800 text-[10px] font-extrabold rounded-full mb-1">
                            ${p.desa ? 'Desa ' + p.desa : 'Koperasi Merah Putih'}
                        </span>
                        <h4 class="font-extrabold text-slate-900 text-xs sm:text-sm leading-tight mb-1">
                            ${p.nama}
                        </h4>
                        ${p.alamat ? `<p class="text-[11px] text-slate-600 line-clamp-2 mb-2.5"><i class="fa-solid fa-location-dot text-red-500 mr-1"></i>${p.alamat}</p>` : ''}
                        <a href="/koperasi/${p.id}" class="inline-flex items-center justify-center space-x-1.5 w-full px-3 py-1.5 bg-[#2563eb] hover:bg-[#1d4ed8] text-white rounded-lg text-xs font-bold transition-all shadow-sm hover:shadow">
                            <span>Buka Profil Koperasi</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                `;

                const marker = L.marker([lat, lng], { icon: icon })
                    .addTo(map)
                    .bindPopup(popupHtml);

                markersMap[p.id] = marker;

                // When user clicks marker, highlight and scroll to row in table
                marker.on('click', function () {
                    highlightRow(p.id);
                });
            }
        });
    }

    if (bounds.length > 0) {
        map.fitBounds(bounds, { padding: [40, 40], maxZoom: 14 });
    }

    // Reset Map View
    if (btnResetMap && bounds.length > 0) {
        btnResetMap.addEventListener('click', function () {
            map.fitBounds(bounds, { padding: [40, 40], maxZoom: 14 });
            map.closePopup();
            document.querySelectorAll('.custom-kec-marker').forEach(el => el.classList.remove('active-pin'));
        });
    }

    // Two-way interaction: Hover/Click row in table highlights pin on map
    rows.forEach(row => {
        const id = row.getAttribute('data-id');

        row.addEventListener('mouseenter', function () {
            const pin = document.getElementById('pin-' + id);
            if (pin) pin.classList.add('active-pin');
        });

        row.addEventListener('mouseleave', function () {
            const pin = document.getElementById('pin-' + id);
            if (pin) pin.classList.remove('active-pin');
        });

        row.addEventListener('click', function (e) {
            // If clicked directly on the anchor link, allow normal navigation
            if (e.target.closest('a')) return;

            const marker = markersMap[id];
            if (marker) {
                map.flyTo(marker.getLatLng(), 15, { duration: 0.8 });
                marker.openPopup();
                highlightRow(id);
            } else {
                // Navigate to koperasi profile if no coords on map
                window.location.href = '/koperasi/' + id;
            }
        });
    });

    function highlightRow(id) {
        rows.forEach(r => r.classList.remove('highlight-row'));
        const targetRow = document.getElementById('koperasi-row-' + id);
        if (targetRow) {
            targetRow.classList.add('highlight-row');
            targetRow.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }

    // Live Instant Search & Filter Logic
    let currentFilter = 'all';

    function applySearchAndFilter() {
        const query = (searchInput.value || '').trim().toLowerCase();
        let matched = 0;

        if (clearBtn) {
            clearBtn.classList.toggle('hidden', query.length === 0);
        }

        rows.forEach(row => {
            const name = row.getAttribute('data-name') || '';
            const desa = row.getAttribute('data-desa') || '';
            const ops = row.getAttribute('data-ops') || '';
            const hasAhu = row.getAttribute('data-ahu') === '1';

            const matchesQuery = query === '' || name.includes(query) || desa.includes(query);

            let matchesFilter = true;
            if (currentFilter === 'sudah') {
                matchesFilter = (ops === 'sudah');
            } else if (currentFilter === 'ahu') {
                matchesFilter = hasAhu;
            }

            if (matchesQuery && matchesFilter) {
                row.style.display = '';
                matched++;
            } else {
                row.style.display = 'none';
            }
        });

        if (visibleCount) visibleCount.textContent = matched;
        if (noResults) {
            noResults.classList.toggle('hidden', matched > 0);
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', applySearchAndFilter);
    }

    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            searchInput.value = '';
            applySearchAndFilter();
            searchInput.focus();
        });
    }

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            filterBtns.forEach(b => b.classList.remove('active', 'bg-red-600', 'text-white'));
            filterBtns.forEach(b => b.classList.add('bg-slate-100', 'text-slate-600'));
            
            this.classList.add('active', 'bg-red-600', 'text-white');
            this.classList.remove('bg-slate-100', 'text-slate-600');

            currentFilter = this.getAttribute('data-filter');
            applySearchAndFilter();
        });
    });

    window.resetSearchFilter = function () {
        if (searchInput) searchInput.value = '';
        currentFilter = 'all';
        filterBtns.forEach(b => {
            if (b.getAttribute('data-filter') === 'all') {
                b.click();
            }
        });
        applySearchAndFilter();
    };

    if (loadingElem) {
        loadingElem.style.opacity = '0';
        setTimeout(() => loadingElem.remove(), 300);
    }
});
</script>
@endpush
