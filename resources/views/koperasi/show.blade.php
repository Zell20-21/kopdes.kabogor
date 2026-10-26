@extends('layouts.app')

@section('title', 'Profil Koperasi - ' . $koperasi->name_koperasi . ' | Dashboard KMP')

@section('content')
<div class="min-h-screen bg-[#f8fafc] flex flex-col justify-between">

    <!-- Top Navigation Header -->
    <header class="bg-gradient-to-r from-[#881337] via-[#991b1b] to-[#7f1d1d] text-white shadow-md sticky top-0 z-[100]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14 sm:h-16">
                <!-- Brand / Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2.5 sm:space-x-3.5 group">
                    <img src="{{ asset('images/logo-kabupaten-bogor.png') }}" alt="Lambang Kabupaten Bogor" class="h-8 sm:h-10 w-auto object-contain drop-shadow shrink-0 transition-transform group-hover:scale-105">
                    <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-full bg-white flex items-center justify-center p-0.5 sm:p-1 shadow-md shrink-0 border border-white/60 overflow-hidden">
                        <img src="{{ asset('images/logo-kopdeskel-clean.png') }}" alt="Logo KOP DES KEL Merah Putih" class="w-full h-full object-contain scale-105">
                    </div>
                    <div class="flex items-baseline space-x-1.5 sm:space-x-2">
                        <span class="font-black text-white text-base sm:text-2xl tracking-tight leading-none group-hover:text-red-100 transition-colors">
                            Dashboard
                        </span>
                        <span class="text-xs sm:text-base font-semibold text-red-100 tracking-tight leading-none">
                            KMP
                        </span>
                    </div>
                </a>

                <!-- Back button / Kembali -->
                <a href="{{ route('kecamatan.show', $koperasi->id_kec) }}" class="flex items-center space-x-2 text-xs sm:text-sm font-semibold text-white/95 hover:text-white bg-white/10 hover:bg-white/20 active:scale-95 px-4 py-1.5 rounded-full border border-white/20 transition-all shadow-sm">
                    <i class="fa-solid fa-arrow-left text-xs transition-transform group-hover:-translate-x-0.5"></i>
                    <span>Kembali ke Kecamatan</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Header Decorative Wave & Title Banner -->
    <div class="relative bg-gradient-to-b from-slate-100/60 to-transparent pt-6 pb-5 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h1 class="text-2xl sm:text-3xl font-black text-amber-600 tracking-wider uppercase">
                PROFIL KOPERASI
            </h1>
        </div>
    </div>

    <!-- Main Container -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12 w-full flex-grow space-y-7">

        <!-- Top Section: Info Card + Pengurus & Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- Left Info Card (Data Legalitas & Identitas) -->
            <div class="lg:col-span-5 bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5 sm:p-6">
                <!-- Title Koperasi Header -->
                <div class="text-center pb-4 mb-4 border-b border-slate-200">
                    <h2 class="text-sm sm:text-base font-black text-slate-900 uppercase leading-snug tracking-tight">
                        {{ $koperasi->name_koperasi }}
                    </h2>
                    <p class="text-xs font-bold text-slate-600 mt-1">
                        Desa {{ $koperasi->kelurahan?->name_kopkel ?: '-' }}, Kec. {{ $koperasi->kecamatan?->name_kopkec ?: '-' }}
                    </p>
                </div>

                <!-- Attributes Table with Interactive Quick Copy -->
                <div class="overflow-hidden text-xs">
                    <table class="w-full">
                        <tbody class="divide-y divide-slate-100">
                            <!-- Jenis -->
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-2.5 pr-2 font-bold text-slate-700 w-36 flex items-center space-x-1.5">
                                    <i class="fa-solid fa-tag text-slate-500 text-[11px]"></i>
                                    <span>Jenis</span>
                                </td>
                                <td class="py-2.5 pl-2 font-black text-slate-900 uppercase">{{ $koperasi->cat_koperasi ?: 'KOPERASI DESA' }}</td>
                            </tr>

                            <!-- Nomor Induk -->
                            <tr class="hover:bg-slate-50/70 transition-colors group/row">
                                <td class="py-2.5 pr-2 font-bold text-slate-700 flex items-center space-x-1.5">
                                    <i class="fa-solid fa-barcode text-slate-500 text-[11px]"></i>
                                    <span>Nomor Induk</span>
                                </td>
                                <td class="py-2.5 pl-2 font-black text-slate-900 flex items-center justify-between">
                                    <span>{{ $koperasi->no_inkop ?: '-' }}</span>
                                    @if($koperasi->no_inkop)
                                        <button type="button" onclick="copyToClipboard('{{ $koperasi->no_inkop }}', 'Nomor Induk')" class="text-slate-400 hover:text-red-600 opacity-0 group-hover/row:opacity-100 transition-opacity text-xs" title="Salin Nomor Induk">
                                            <i class="fa-regular fa-copy"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>

                            <!-- No AHU -->
                            <tr class="hover:bg-slate-50/70 transition-colors group/row">
                                <td class="py-2.5 pr-2 font-bold text-slate-700 flex items-center space-x-1.5">
                                    <i class="fa-solid fa-file-shield text-slate-500 text-[11px]"></i>
                                    <span>No AHU</span>
                                </td>
                                <td class="py-2.5 pl-2 font-black text-slate-900 flex items-center justify-between">
                                    <span class="break-all">{{ $koperasi->no_ahu ?: '-' }}</span>
                                    @if($koperasi->no_ahu)
                                        <button type="button" onclick="copyToClipboard('{{ $koperasi->no_ahu }}', 'Nomor AHU')" class="text-slate-400 hover:text-red-600 opacity-0 group-hover/row:opacity-100 transition-opacity text-xs shrink-0 ml-1" title="Salin No AHU">
                                            <i class="fa-regular fa-copy"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>

                            <!-- Tanggal AHU -->
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-2.5 pr-2 font-bold text-slate-700 flex items-center space-x-1.5">
                                    <i class="fa-regular fa-calendar text-slate-500 text-[11px]"></i>
                                    <span>Tanggal AHU</span>
                                </td>
                                <td class="py-2.5 pl-2 font-black text-slate-900">
                                    {{ $koperasi->tgl_ahu ? date('d F Y', strtotime($koperasi->tgl_ahu)) : '-' }}
                                </td>
                            </tr>

                            <!-- Alamat -->
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-2.5 pr-2 font-bold text-slate-700 flex items-start space-x-1.5 pt-3">
                                    <i class="fa-solid fa-location-dot text-slate-500 text-[11px] mt-0.5"></i>
                                    <span>Alamat</span>
                                </td>
                                <td class="py-2.5 pl-2 font-black text-slate-900 uppercase leading-relaxed">
                                    {{ $koperasi->kop_addr ?: '-' }}
                                    @if($koperasi->kop_addr)
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($koperasi->name_koperasi . ' ' . $koperasi->kop_addr) }}" target="_blank" class="block text-[11px] font-bold text-blue-600 hover:underline mt-1">
                                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px] mr-1"></i>Buka di Google Maps
                                        </a>
                                    @endif
                                </td>
                            </tr>

                            <!-- Desa/Kelurahan -->
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-2.5 pr-2 font-bold text-slate-700 flex items-center space-x-1.5">
                                    <i class="fa-solid fa-tree-city text-slate-500 text-[11px]"></i>
                                    <span>Desa/Kelurahan</span>
                                </td>
                                <td class="py-2.5 pl-2 font-black text-slate-900 uppercase">{{ $koperasi->kelurahan?->name_kopkel ?: '-' }}</td>
                            </tr>

                            <!-- Kecamatan -->
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-2.5 pr-2 font-bold text-slate-700 flex items-center space-x-1.5">
                                    <i class="fa-solid fa-city text-slate-500 text-[11px]"></i>
                                    <span>Kecamatan</span>
                                </td>
                                <td class="py-2.5 pl-2 font-black text-slate-900 uppercase">{{ $koperasi->kecamatan?->name_kopkec ?: '-' }}</td>
                            </tr>

                            <!-- Telp -->
                            <tr class="hover:bg-slate-50/70 transition-colors group/row">
                                <td class="py-2.5 pr-2 font-bold text-slate-700 flex items-center space-x-1.5">
                                    <i class="fa-solid fa-phone text-slate-500 text-[11px]"></i>
                                    <span>Telp</span>
                                </td>
                                <td class="py-2.5 pl-2 font-black text-slate-900 flex items-center justify-between">
                                    @if($koperasi->kop_telp)
                                        <a href="tel:{{ $koperasi->kop_telp }}" class="text-blue-600 hover:underline">
                                            {{ $koperasi->kop_telp }}
                                        </a>
                                        <button type="button" onclick="copyToClipboard('{{ $koperasi->kop_telp }}', 'Nomor Telepon')" class="text-slate-400 hover:text-red-600 opacity-0 group-hover/row:opacity-100 transition-opacity text-xs" title="Salin Telepon">
                                            <i class="fa-regular fa-copy"></i>
                                        </button>
                                    @else
                                        <span>-</span>
                                    @endif
                                </td>
                            </tr>

                            <!-- Website -->
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-2.5 pr-2 font-bold text-slate-700 flex items-center space-x-1.5">
                                    <i class="fa-solid fa-globe text-slate-500 text-[11px]"></i>
                                    <span>Website</span>
                                </td>
                                <td class="py-2.5 pl-2 font-bold text-blue-600 truncate max-w-[210px]">
                                    @if($koperasi->kop_web)
                                        <a href="{{ str_starts_with($koperasi->kop_web, 'http') ? $koperasi->kop_web : 'https://' . $koperasi->kop_web }}" target="_blank" class="hover:underline flex items-center space-x-1">
                                            <span class="truncate">{{ $koperasi->kop_web }}</span>
                                            <i class="fa-solid fa-arrow-up-right-from-square text-[9px] shrink-0"></i>
                                        </a>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                            </tr>

                            <!-- Email -->
                            <tr class="hover:bg-slate-50/70 transition-colors group/row">
                                <td class="py-2.5 pr-2 font-bold text-slate-700 flex items-center space-x-1.5">
                                    <i class="fa-regular fa-envelope text-slate-500 text-[11px]"></i>
                                    <span>Email</span>
                                </td>
                                <td class="py-2.5 pl-2 font-black text-slate-900 flex items-center justify-between">
                                    @if($koperasi->kop_mail && $koperasi->kop_mail !== '-')
                                        <a href="mailto:{{ $koperasi->kop_mail }}" class="text-blue-600 hover:underline truncate max-w-[190px]">
                                            {{ $koperasi->kop_mail }}
                                        </a>
                                        <button type="button" onclick="copyToClipboard('{{ $koperasi->kop_mail }}', 'Email')" class="text-slate-400 hover:text-red-600 opacity-0 group-hover/row:opacity-100 transition-opacity text-xs shrink-0" title="Salin Email">
                                            <i class="fa-regular fa-copy"></i>
                                        </button>
                                    @else
                                        <span>-</span>
                                    @endif
                                </td>
                            </tr>

                            <!-- Operasional Badge -->
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-2.5 pr-2 font-bold text-slate-700 flex items-center space-x-1.5">
                                    <i class="fa-solid fa-gears text-slate-500 text-[11px]"></i>
                                    <span>Operasional</span>
                                </td>
                                <td class="py-2.5 pl-2">
                                    <span class="inline-block px-2.5 py-0.5 rounded text-[11px] font-black uppercase {{ strtoupper($koperasi->st_ops) === 'SUDAH' ? 'bg-emerald-600 text-white' : 'bg-red-600 text-white' }}">
                                        {{ $koperasi->st_ops ?: 'BELUM' }}
                                    </span>
                                </td>
                            </tr>

                            <!-- Sertifikat Badge -->
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-2.5 pr-2 font-bold text-slate-700 flex items-center space-x-1.5">
                                    <i class="fa-solid fa-stamp text-slate-500 text-[11px]"></i>
                                    <span>Sertifikat</span>
                                </td>
                                <td class="py-2.5 pl-2">
                                    <span class="inline-block px-2.5 py-0.5 rounded text-[11px] font-black uppercase {{ strtoupper($koperasi->st_sertifikat) === 'SUDAH' ? 'bg-emerald-600 text-white' : 'bg-red-600 text-white' }}">
                                        {{ $koperasi->st_sertifikat ?: 'BELUM' }}
                                    </span>
                                </td>
                            </tr>

                            <!-- Pelatihan Badge -->
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-2.5 pr-2 font-bold text-slate-700 flex items-center space-x-1.5">
                                    <i class="fa-solid fa-graduation-cap text-slate-500 text-[11px]"></i>
                                    <span>Pelatihan</span>
                                </td>
                                <td class="py-2.5 pl-2">
                                    <span class="inline-block px-2.5 py-0.5 rounded text-[11px] font-black uppercase {{ strtoupper($koperasi->st_latih) === 'SUDAH' ? 'bg-emerald-600 text-white' : 'bg-red-600 text-white' }}">
                                        {{ $koperasi->st_latih ?: 'BELUM' }}
                                    </span>
                                </td>
                            </tr>

                            <!-- Sosial Media Links -->
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-2.5 pr-2 font-bold text-slate-700 flex items-center space-x-1.5">
                                    <i class="fa-solid fa-share-nodes text-slate-500 text-[11px]"></i>
                                    <span>Sosial Media</span>
                                </td>
                                <td class="py-2.5 pl-2">
                                    <div class="flex items-center space-x-2 text-base">
                                        <a href="{{ $koperasi->media_fb ?: '#' }}" target="{{ $koperasi->media_fb ? '_blank' : '_self' }}" class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white hover:scale-110 transition-all shadow-sm" title="Facebook">
                                            <i class="fa-brands fa-facebook-f text-xs"></i>
                                        </a>
                                        <a href="{{ $koperasi->media_ig ?: '#' }}" target="{{ $koperasi->media_ig ? '_blank' : '_self' }}" class="w-7 h-7 rounded-lg bg-pink-50 text-pink-600 flex items-center justify-center hover:bg-gradient-to-tr hover:from-amber-500 hover:to-pink-600 hover:text-white hover:scale-110 transition-all shadow-sm" title="Instagram">
                                            <i class="fa-brands fa-instagram text-xs"></i>
                                        </a>
                                        <a href="{{ $koperasi->media_yt ?: '#' }}" target="{{ $koperasi->media_yt ? '_blank' : '_self' }}" class="w-7 h-7 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white hover:scale-110 transition-all shadow-sm" title="YouTube">
                                            <i class="fa-brands fa-youtube text-xs"></i>
                                        </a>
                                        <a href="{{ $koperasi->media_x ?: '#' }}" target="{{ $koperasi->media_x ? '_blank' : '_self' }}" class="w-7 h-7 rounded-lg bg-slate-100 text-slate-800 flex items-center justify-center hover:bg-black hover:text-white hover:scale-110 transition-all shadow-sm" title="Twitter / X">
                                            <i class="fa-brands fa-x-twitter text-xs"></i>
                                        </a>
                                        <a href="{{ $koperasi->media_tiktok ?: '#' }}" target="{{ $koperasi->media_tiktok ? '_blank' : '_self' }}" class="w-7 h-7 rounded-lg bg-slate-100 text-slate-900 flex items-center justify-center hover:bg-black hover:text-white hover:scale-110 transition-all shadow-sm" title="TikTok">
                                            <i class="fa-brands fa-tiktok text-xs"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Section: Pengurus Photos & Stat Badges -->
            <div class="lg:col-span-7 space-y-5">
                
                <!-- Photos Row (Ketua & Sekretaris) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    
                    <!-- Card Ketua -->
                    <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-4 sm:p-5 flex flex-col items-center text-center group hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                        <div class="relative w-full max-w-[210px] aspect-[3/4] rounded-xl overflow-hidden shadow-md border-2 border-slate-200 bg-slate-100 cursor-pointer" onclick="openLightbox('{{ $fotoKetua }}', '{{ $ketua?->name_kopsdm ?? 'IDRUS FIRDAUS' }}', 'Ketua Koperasi')">
                            <img src="{{ $fotoKetua }}" alt="Ketua Koperasi" onerror="this.onerror=null; this.src='{{ asset('asset/kakop_0.png') }}';" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center pb-2">
                                <span class="text-[10px] font-black text-white bg-black/60 px-2.5 py-1 rounded-full backdrop-blur-sm flex items-center space-x-1">
                                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                                    <span>Perbesar Foto</span>
                                </span>
                            </div>
                        </div>
                        <h4 class="font-black text-slate-900 text-sm mt-3 uppercase tracking-tight">
                            {{ $ketua?->name_kopsdm ?? 'IDRUS FIRDAUS' }}
                        </h4>
                        <p class="text-xs text-slate-700 font-bold mt-0.5">Ketua Koperasi</p>
                    </div>

                    <!-- Card Sekretaris -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-4 sm:p-5 flex flex-col items-center text-center group hover:shadow-md transition-all duration-200">
                        <div class="relative w-full max-w-[210px] aspect-[3/4] rounded-xl overflow-hidden shadow-sm border border-slate-200 bg-slate-100 cursor-pointer" onclick="openLightbox('{{ $fotoSekretaris }}', '{{ $sekretaris?->name_kopsdm ?? 'HJ. NENENG ASRIAH, S.PD.I' }}', 'Sekretaris')">
                            <img src="{{ $fotoSekretaris }}" alt="Sekretaris" onerror="this.onerror=null; this.src='{{ asset('asset/sekkop_0.png') }}';" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center pb-2">
                                <span class="text-[10px] font-black text-white bg-black/60 px-2.5 py-1 rounded-full backdrop-blur-sm">
                                    <i class="fa-solid fa-magnifying-glass-plus mr-1"></i>Perbesar Foto
                                </span>
                            </div>
                        </div>
                        <h4 class="font-black text-slate-900 text-sm mt-3 uppercase tracking-tight">
                            {{ $sekretaris?->name_kopsdm ?? 'HJ. NENENG ASRIAH, S.PD.I' }}
                        </h4>
                        <p class="text-xs text-slate-700 font-bold mt-0.5">Sekretaris</p>
                    </div>

                </div>

                <!-- Row Bendahara & First Stat Card -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 items-stretch">
                    
                    <!-- Card Bendahara -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-4 sm:p-5 flex flex-col items-center text-center group hover:shadow-md transition-all duration-200">
                        <div class="relative w-full max-w-[210px] aspect-[3/4] rounded-xl overflow-hidden shadow-sm border border-slate-200 bg-slate-100 cursor-pointer" onclick="openLightbox('{{ $fotoBendahara }}', '{{ $bendahara?->name_kopsdm ?? 'FAHRIZI' }}', 'Bendahara')">
                            <img src="{{ $fotoBendahara }}" alt="Bendahara" onerror="this.onerror=null; this.src='{{ asset('asset/benkop_0.png') }}';" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center pb-2">
                                <span class="text-[10px] font-black text-white bg-black/60 px-2.5 py-1 rounded-full backdrop-blur-sm">
                                    <i class="fa-solid fa-magnifying-glass-plus mr-1"></i>Perbesar Foto
                                </span>
                            </div>
                        </div>
                        <h4 class="font-black text-slate-900 text-sm mt-3 uppercase tracking-tight">
                            {{ $bendahara?->name_kopsdm ?? 'FAHRIZI' }}
                        </h4>
                        <p class="text-xs text-slate-700 font-bold mt-0.5">Bendahara</p>
                    </div>

                    <!-- Stat Card: Pengurus Koperasi -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 flex flex-col justify-center items-start group hover:shadow-md transition-all duration-200">
                        <i class="fa-solid fa-users text-emerald-600 text-xl mb-3"></i>
                        <div class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight counter-val" data-target="{{ $koperasi->jum_pengurus ?? 7 }}">
                            0
                        </div>
                        <p class="text-xs font-black text-slate-800 uppercase tracking-wide mt-1">Pengurus Koperasi</p>
                    </div>

                </div>

                <!-- Stats Grid Row 2: Pengawas & Anggota -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    
                    <!-- Pengawas Koperasi -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 flex flex-col justify-center items-start group hover:shadow-md transition-all duration-200">
                        <i class="fa-solid fa-user-shield text-amber-600 text-xl mb-3"></i>
                        <div class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight counter-val" data-target="{{ $koperasi->jum_pengawas ?? 3 }}">
                            0
                        </div>
                        <p class="text-xs font-black text-slate-800 uppercase tracking-wide mt-1">Pengawas Koperasi</p>
                    </div>

                    <!-- Anggota Koperasi -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 flex flex-col justify-center items-start group hover:shadow-md transition-all duration-200">
                        <i class="fa-solid fa-people-group text-rose-600 text-xl mb-3"></i>
                        <div class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight counter-val" data-target="{{ $koperasi->jum_anggota ?? 20 }}">
                            0
                        </div>
                        <p class="text-xs font-black text-slate-800 uppercase tracking-wide mt-1">Anggota Koperasi</p>
                    </div>

                </div>

                <!-- Stats Grid Row 3: Simpanan Pokok & Wajib -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    
                    <!-- Simpanan Pokok -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 flex flex-col justify-center items-start group hover:shadow-md transition-all duration-200">
                        <i class="fa-solid fa-cart-shopping text-emerald-600 text-xl mb-3"></i>
                        <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight counter-money" data-target="{{ $koperasi->jum_sim_pokok ?? 500000 }}">
                            Rp 0
                        </div>
                        <p class="text-xs font-black text-slate-800 uppercase tracking-wide mt-1">Simpanan Pokok (Rp)</p>
                    </div>

                    <!-- Simpanan Wajib -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 flex flex-col justify-center items-start group hover:shadow-md transition-all duration-200">
                        <i class="fa-solid fa-clipboard-check text-rose-600 text-xl mb-3"></i>
                        <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight counter-money" data-target="{{ $koperasi->jum_sim_wajib ?? 200000 }}">
                            Rp 0
                        </div>
                        <p class="text-xs font-black text-slate-800 uppercase tracking-wide mt-1">Simpanan Wajib (Rp)</p>
                    </div>

                </div>

            </div>

        </div>

        <!-- Bottom Section: Jenis Usaha & Gallery -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- Left Column: Jenis Usaha (13 Items) Clean -->
            <div class="lg:col-span-5 bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5 sm:p-6">
                <h3 class="font-black text-slate-900 text-center text-sm sm:text-base uppercase tracking-wider mb-4 pb-3 border-b-2 border-slate-200">
                    JENIS USAHA
                </h3>
                
                <!-- Clean List Items (Matching Screenshot 3) -->
                <div class="divide-y divide-slate-100 text-xs">
                    @foreach ($jenisUsahaList as $usaha)
                        <div class="py-2.5 flex items-center justify-between hover:bg-slate-50 px-1 rounded transition-colors">
                            <span class="font-bold text-slate-900 tracking-tight pr-2">
                                {{ $usaha['nama'] }}
                            </span>
                            @if($usaha['status'])
                                <span class="px-2.5 py-0.5 rounded text-[11px] font-black uppercase bg-emerald-600 text-white shrink-0">
                                    Sudah
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded text-[11px] font-black uppercase bg-slate-500 text-white shrink-0">
                                    Tidak
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right Column: Interactive Gallery & Building View Clean -->
            <div class="lg:col-span-7 bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5 sm:p-6 flex flex-col">
                <h3 class="font-black text-slate-900 text-center text-sm sm:text-base uppercase tracking-wider mb-4 pb-3 border-b-2 border-slate-200">
                    GALLERY
                </h3>

                <!-- Main Foto Gedung / Landmark with Lightbox Click -->
                <div class="relative w-full bg-slate-50 rounded-xl overflow-hidden border border-slate-200 flex items-center justify-center min-h-[350px] sm:min-h-[420px] p-2 shadow-inner group cursor-pointer" onclick="openLightbox('{{ $fotoGedung }}', 'Foto Gedung / Kantor {{ $koperasi->name_koperasi }}', 'Gallery Dokumentasi')">
                    <img id="mainGalleryImg" src="{{ $fotoGedung }}" alt="Foto Gedung Koperasi" onerror="this.onerror=null; this.src='{{ asset('asset/kop_0.png') }}';" class="max-h-[420px] w-auto max-w-full object-contain rounded-lg transition-transform duration-300 group-hover:scale-[1.01]">
                    
                    <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <span class="px-3.5 py-1.5 rounded-lg bg-white/95 text-slate-900 font-black text-xs shadow flex items-center space-x-1.5">
                            <i class="fa-solid fa-expand text-slate-800"></i>
                            <span>Buka Layar Penuh</span>
                        </span>
                    </div>
                </div>

                <!-- Additional Gallery Thumbs (if available) -->
                @if(!empty($additionalGallery))
                    <div class="mt-4 pt-3 border-t border-slate-100">
                        <p class="text-xs font-bold text-slate-600 mb-2">Dokumentasi Tambahan:</p>
                        <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                            <!-- Main thumb -->
                            <div class="aspect-video bg-slate-100 rounded-xl overflow-hidden border-2 border-red-500 shadow-sm cursor-pointer hover:opacity-90 transition-all p-0.5" onclick="selectThumbnail('{{ $fotoGedung }}')">
                                <img src="{{ $fotoGedung }}" alt="Gedung Utama" class="w-full h-full object-cover rounded-lg">
                            </div>
                            @foreach ($additionalGallery as $img)
                                <div class="aspect-video bg-slate-100 rounded-xl overflow-hidden border border-slate-200 shadow-sm cursor-pointer hover:opacity-90 hover:border-red-400 transition-all p-0.5" onclick="selectThumbnail('{{ $img }}')">
                                    <img src="{{ $img }}" alt="Gallery Tambahan" class="w-full h-full object-cover rounded-lg">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer class="py-6 text-center text-xs text-slate-500 border-t border-slate-200 bg-white">
        <p class="font-medium text-slate-600">Dashboard Koperasi Merah Putih Kabupaten Bogor</p>
        <p class="mt-1 text-slate-400">Diskominfo &copy; 2025</p>
    </footer>

</div>

<!-- Interactive Lightbox Modal Component -->
<div id="lightboxModal" class="hidden fixed inset-0 z-[9999] bg-black/85 backdrop-blur-md flex items-center justify-center p-4 transition-opacity duration-300">
    <div class="relative max-w-4xl w-full bg-slate-900 rounded-2xl overflow-hidden shadow-2xl border border-white/20 flex flex-col">
        <!-- Close Button -->
        <button type="button" onclick="closeLightbox()" class="absolute top-3 right-3 z-20 w-9 h-9 rounded-full bg-white/20 hover:bg-white text-white hover:text-slate-900 flex items-center justify-center transition-all">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>

        <!-- Image Container -->
        <div class="w-full max-h-[75vh] flex items-center justify-center bg-black/50 p-4">
            <img id="lightboxImg" src="" alt="Preview Foto" class="max-h-[70vh] w-auto max-w-full object-contain rounded-lg shadow-lg">
        </div>

        <!-- Caption Footer -->
        <div class="p-4 bg-slate-900/95 border-t border-white/10 text-center">
            <h4 id="lightboxTitle" class="text-white font-extrabold text-base uppercase tracking-wide"></h4>
            <p id="lightboxSubtitle" class="text-slate-400 text-xs font-medium mt-0.5"></p>
        </div>
    </div>
</div>

<!-- Toast Notification Component -->
<div id="toastNotification" class="fixed bottom-5 right-5 z-[99999] hidden items-center space-x-2 px-4 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-bold shadow-2xl border border-white/10 transition-all duration-300 transform translate-y-3">
    <i class="fa-solid fa-circle-check text-emerald-400 text-sm"></i>
    <span id="toastMessage">Tersalin ke papan klip!</span>
</div>
@endsection

@push('scripts')
<script>
// Animated Number Counters on Page Load
document.addEventListener('DOMContentLoaded', function () {
    // Standard counters
    document.querySelectorAll('.counter-val').forEach(el => {
        const target = parseInt(el.getAttribute('data-target')) || 0;
        let count = 0;
        const duration = 1200;
        const stepTime = 25;
        const totalSteps = duration / stepTime;
        const increment = target / totalSteps;

        const timer = setInterval(() => {
            count += increment;
            if (count >= target) {
                el.textContent = target.toLocaleString('id-ID');
                clearInterval(timer);
            } else {
                el.textContent = Math.floor(count).toLocaleString('id-ID');
            }
        }, stepTime);
    });

    // Money counters
    document.querySelectorAll('.counter-money').forEach(el => {
        const target = parseInt(el.getAttribute('data-target')) || 0;
        let count = 0;
        const duration = 1400;
        const stepTime = 25;
        const totalSteps = duration / stepTime;
        const increment = target / totalSteps;

        const timer = setInterval(() => {
            count += increment;
            if (count >= target) {
                el.textContent = 'Rp ' + target.toLocaleString('id-ID');
                clearInterval(timer);
            } else {
                el.textContent = 'Rp ' + Math.floor(count).toLocaleString('id-ID');
            }
        }, stepTime);
    });
});

// Interactive Lightbox
function openLightbox(src, title, subtitle) {
    const modal = document.getElementById('lightboxModal');
    const img = document.getElementById('lightboxImg');
    const titleEl = document.getElementById('lightboxTitle');
    const subEl = document.getElementById('lightboxSubtitle');

    img.src = src;
    titleEl.textContent = title || '';
    subEl.textContent = subtitle || '';

    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    const modal = document.getElementById('lightboxModal');
    modal.classList.add('hidden');
    document.body.style.overflow = '';
}

// Close on backdrop or Esc key
document.getElementById('lightboxModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeLightbox();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeLightbox();
});

// Thumbnail switcher for Gallery
function selectThumbnail(src) {
    const mainImg = document.getElementById('mainGalleryImg');
    if (mainImg) {
        mainImg.src = src;
    }
}

// Jenis Usaha Filter
function filterUsaha(status, btn) {
    document.querySelectorAll('.btn-usaha-filter').forEach(b => {
        b.classList.remove('active', 'bg-slate-800', 'text-white');
        b.classList.add('bg-slate-100', 'text-slate-600');
    });

    btn.classList.add('active', 'bg-slate-800', 'text-white');
    btn.classList.remove('bg-slate-100', 'text-slate-600');

    document.querySelectorAll('.usaha-item').forEach(item => {
        const itemStatus = item.getAttribute('data-status');
        if (status === 'all' || itemStatus === status) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
}

// Copy to Clipboard with Toast Notification
function copyToClipboard(text, label) {
    if (!text || text === '-') return;
    navigator.clipboard.writeText(text).then(() => {
        showToast((label || 'Data') + ' berhasil disalin!');
    }).catch(() => {
        showToast('Gagal menyalin teks');
    });
}

function showToast(msg) {
    const toast = document.getElementById('toastNotification');
    const msgEl = document.getElementById('toastMessage');
    if (!toast) return;

    msgEl.textContent = msg;
    toast.classList.remove('hidden');
    toast.classList.remove('translate-y-3');

    setTimeout(() => {
        toast.classList.add('translate-y-3');
        setTimeout(() => toast.classList.add('hidden'), 300);
    }, 2400);
}
</script>
@endpush
