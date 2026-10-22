@extends('layouts.app')

@section('title', match(request()->query('page')) {
    'database-anggota' => 'Database Anggota | Kabupaten Bogor',
    'database-pengurus' => 'Database Pengurus | Kabupaten Bogor',
    default => 'Dashboard Operator Desa | Kabupaten Bogor',
})

@section('content')
<div class="min-h-screen bg-slate-50 text-slate-800">
    <header class="bg-gradient-to-r from-[#881337] via-[#991b1b] to-[#7f1d1d] text-white shadow-lg">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-x-6 gap-y-4 px-4 py-4 sm:px-6 lg:px-8">
            <div class="flex items-center space-x-2 sm:space-x-3.5 min-w-0 pr-1">
                <img src="{{ asset('images/logo-kabupaten-bogor.png') }}" alt="Lambang Kabupaten Bogor" class="h-8 sm:h-11 w-auto object-contain drop-shadow shrink-0">
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

            <div class="flex w-full items-center justify-between gap-3 sm:w-auto sm:justify-end">
                <nav aria-label="Navigasi halaman" class="flex min-w-0 items-center gap-1 overflow-x-auto text-sm font-semibold sm:gap-2">
                    <a href="{{ route('admin.dashboard') }}#jenis-usaha" class="shrink-0 rounded-lg px-3 py-2 transition hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/70">Jenis usaha</a>
                    <a href="{{ route('admin.dashboard') }}#lokasi-koperasi" class="shrink-0 rounded-lg px-3 py-2 transition hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/70">Foto lokasi</a>
                    <a href="{{ route('admin.dashboard', ['page' => 'database-pengurus']) }}#foto-pengurus" class="shrink-0 rounded-lg px-3 py-2 transition hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/70">Foto pengurus</a>
                </nav>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl border border-white/30 px-3 py-2 text-sm font-bold transition hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/70 sm:px-4">
                        <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="mx-auto flex w-full max-w-7xl flex-col gap-8 px-4 py-6 sm:gap-10 sm:px-6 sm:py-8 lg:px-8">
        @if(session('success'))
            <div role="status" class="flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div role="alert" class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                <p class="font-bold">Mohon periksa kembali data yang dimasukkan.</p>
                <ul class="mt-2 list-inside list-disc space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(request()->query('page') === 'database-anggota')
            <div class="grid min-w-0 gap-6 lg:grid-cols-[15rem_minmax(0,1fr)] lg:items-start lg:gap-8">
                @include('admin.partials.operator-database-sidebar')
                @include('admin.operator.database-anggota')
            </div>
        @elseif(request()->query('page') === 'database-pengurus')
            <div class="grid min-w-0 gap-6 lg:grid-cols-[15rem_minmax(0,1fr)] lg:items-start lg:gap-8">
                @include('admin.partials.operator-database-sidebar')
                @include('admin.operator.database-pengurus')
            </div>
        @else
        <div class="grid min-w-0 gap-6 lg:grid-cols-[15rem_minmax(0,1fr)] lg:items-start lg:gap-8">
            @include('admin.partials.operator-database-sidebar')
            <div class="flex min-w-0 flex-col gap-8 sm:gap-10">
        <section id="profil" aria-labelledby="ringkasan-heading" class="flex flex-col gap-5 scroll-mt-6">
            <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-end">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full border border-rose-200 bg-rose-50 px-3 py-1 text-xs font-bold text-rose-700">
                        <span class="h-2 w-2 rounded-full bg-rose-600"></span>
                        Profil Koperasi Desa / Kelurahan
                    </div>
                    <h2 id="ringkasan-heading" class="mt-2 text-2xl font-black tracking-tight text-slate-900 sm:text-3xl">
                        Selamat datang, {{ $user->name }}
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">Lengkapi identitas, keanggotaan, struktur, dan pilihan jenis usaha koperasi.</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-bold text-slate-700 shadow-xs">
                        <i class="fa-solid fa-shield-halved text-rose-600"></i>
                        Operator Desa / Kelurahan
                    </span>
                </div>
            </div>

            <div class="grid gap-4">
                @forelse($operatorKoperasiProfiles as $profile)
                    @php($koperasi = $profile['koperasi'])
                    <article class="rounded-3xl border border-rose-100 bg-gradient-to-br from-white via-white to-rose-50/70 p-5 shadow-xs sm:p-7">
                        <div class="flex flex-col justify-between gap-5 md:flex-row md:items-start">
                            <div class="flex min-w-0 items-start gap-4">
                                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-rose-100 text-rose-800">
                                    <i class="fa-solid fa-building-columns text-xl"></i>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-rose-700">Identitas koperasi</p>
                                    <h3 class="mt-1 break-words text-xl font-black tracking-tight text-slate-900 sm:text-2xl">{{ $koperasi->name_koperasi }}</h3>
                                    <p class="mt-1 flex flex-wrap items-center gap-x-2 gap-y-1 text-sm text-slate-600">
                                        <span><i class="fa-solid fa-location-dot mr-1 text-rose-600"></i>{{ $koperasi->kelurahan?->name_kopkel ?: 'Desa / kelurahan belum tercatat' }}</span>
                                        @if(filled($koperasi->kecamatan?->name_kopkec))
                                            <span aria-hidden="true" class="text-slate-300">·</span>
                                            <span>Kecamatan {{ $koperasi->kecamatan->name_kopkec }}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-2 md:justify-end">
                                @if(filled($koperasi->no_inkop) && trim((string) $koperasi->no_inkop) !== '-')
                                    <span class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700">
                                        NI-KOP <span class="ml-1 font-mono font-bold">{{ $koperasi->no_inkop }}</span>
                                    </span>
                                @endif
                                @if(filled($koperasi->no_ahu) && trim((string) $koperasi->no_ahu) !== '-')
                                    <span class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700">
                                        AHU <span class="ml-1 font-mono font-bold">{{ $koperasi->no_ahu }}</span>
                                    </span>
                                @endif
                                @if(blank($koperasi->no_inkop) || trim((string) $koperasi->no_inkop) === '-')
                                    <span class="rounded-xl border border-amber-200 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-800">NI-KOP belum tercatat</span>
                                @endif
                                @if(blank($koperasi->no_ahu) || trim((string) $koperasi->no_ahu) === '-')
                                    <span class="rounded-xl border border-amber-200 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-800">Nomor AHU belum tercatat</span>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-7 text-center">
                        <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-xl text-slate-400"><i class="fa-solid fa-building"></i></span>
                        <p class="mt-3 font-bold text-slate-800">Profil koperasi belum tersedia</p>
                        <p class="mt-1 text-sm text-slate-500">Belum ada data koperasi yang terhubung dengan desa / kelurahan akun ini.</p>
                    </div>
                @endforelse
            </div>

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <article class="group relative flex min-h-36 flex-col justify-between rounded-2xl border-t-4 border-t-red-700 border-x border-b border-slate-200/90 bg-white p-5 shadow-xs transition duration-200 hover:-translate-y-1 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Anggota</span>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-rose-100/70 text-rose-800 shadow-2xs transition group-hover:scale-105">
                            <i class="fa-solid fa-users text-base"></i>
                        </span>
                    </div>
                    <div>
                        <p data-dashboard-stat="members" data-value="{{ (int) $totalAnggota }}" class="mt-3 text-3xl font-black text-slate-900">{{ number_format($totalAnggota) }}</p>
                        <p class="mt-1 flex items-center gap-1.5 text-xs text-slate-500">
                            <i class="fa-regular fa-circle-check text-emerald-600"></i>
                            Anggota pada koperasi di desa Anda
                        </p>
                    </div>
                </article>

                <article class="group relative flex min-h-36 flex-col justify-between rounded-2xl border-t-4 border-t-amber-500 border-x border-b border-slate-200/90 bg-white p-5 shadow-xs transition duration-200 hover:-translate-y-1 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Pengawas Koperasi</span>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-700 shadow-2xs transition group-hover:scale-105">
                            <i class="fa-solid fa-user-shield text-base"></i>
                        </span>
                    </div>
                    <div>
                        <p data-dashboard-stat="supervisors" data-value="{{ $totalPengawasKoperasi }}" class="mt-3 text-3xl font-black text-slate-900">{{ number_format($totalPengawasKoperasi) }}</p>
                        <p class="mt-1 flex items-center gap-1.5 text-xs text-slate-500">
                            <i class="fa-regular fa-circle-check text-emerald-600"></i>
                            Pengawas aktif di desa Anda
                        </p>
                    </div>
                </article>

                <article class="group relative flex min-h-36 flex-col justify-between rounded-2xl border-t-4 border-t-sky-600 border-x border-b border-slate-200/90 bg-white p-5 shadow-xs transition duration-200 hover:-translate-y-1 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Pengurus Koperasi</span>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-sky-50 text-sky-700 shadow-2xs transition group-hover:scale-105">
                            <i class="fa-solid fa-user-tie text-base"></i>
                        </span>
                    </div>
                    <div>
                        <p data-dashboard-stat="officers" data-value="{{ $totalPengurusKoperasi }}" class="mt-3 text-3xl font-black text-slate-900">{{ number_format($totalPengurusKoperasi) }}</p>
                        <p class="mt-1 flex items-center gap-1.5 text-xs text-slate-500">
                            <i class="fa-regular fa-circle-check text-emerald-600"></i>
                            Pengurus aktif di desa Anda
                        </p>
                    </div>
                </article>

                <article class="group relative flex min-h-36 flex-col justify-between rounded-2xl border-t-4 border-t-violet-600 border-x border-b border-slate-200/90 bg-white p-5 shadow-xs transition duration-200 hover:-translate-y-1 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Jenis Usaha Terpilih</span>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-50 text-violet-700 shadow-2xs transition group-hover:scale-105">
                            <i class="fa-solid fa-list-check text-base"></i>
                        </span>
                    </div>
                    <div>
                        <p data-dashboard-stat="business-types" data-value="{{ $totalJenisUsaha }}" class="mt-3 text-3xl font-black text-slate-900">{{ number_format($totalJenisUsaha) }}</p>
                        <p class="mt-1 flex items-center gap-1.5 text-xs text-slate-500">
                            <i class="fa-regular fa-circle-check text-violet-600"></i>
                            Pilihan pada profil koperasi
                        </p>
                    </div>
                </article>
            </div>
        </section>

        <section aria-labelledby="kelengkapan-heading" class="flex flex-col gap-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.16em] text-rose-700">Data yang perlu diperiksa</p>
                <h2 id="kelengkapan-heading" class="mt-1 text-xl font-black tracking-tight text-slate-900 sm:text-2xl">Kelengkapan profil</h2>
                <p class="mt-1 text-sm text-slate-500">Status berikut mengikuti data yang tersimpan. Sistem belum menetapkan persentase kelengkapan profil.</p>
            </div>
            <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                @foreach([
                    ['label' => 'Anggota', 'count' => $totalAnggota, 'anchor' => route('admin.dashboard', ['page' => 'database-anggota']), 'icon' => 'fa-users'],
                    ['label' => 'Pengurus', 'count' => $totalPengurusKoperasi, 'anchor' => route('admin.dashboard', ['page' => 'database-pengurus']), 'icon' => 'fa-user-tie'],
                    ['label' => 'Pengawas', 'count' => $totalPengawasKoperasi, 'anchor' => route('admin.dashboard', ['page' => 'database-pengurus']), 'icon' => 'fa-user-shield'],
                    ['label' => 'Jenis usaha', 'count' => $totalJenisUsaha, 'anchor' => '#jenis-usaha', 'icon' => 'fa-list-check'],
                ] as $item)
                    <a href="{{ $item['anchor'] }}" class="flex min-w-0 items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-2xs transition hover:border-rose-200 hover:shadow-xs focus:outline-none focus:ring-2 focus:ring-rose-300">
                        <span class="flex min-w-0 items-center gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-600"><i class="fa-solid {{ $item['icon'] }}"></i></span>
                            <span class="min-w-0">
                                <span class="block truncate text-sm font-bold text-slate-800">{{ $item['label'] }}</span>
                                <span class="mt-0.5 block text-xs {{ $item['count'] > 0 ? 'text-emerald-700' : 'text-amber-700' }}">
                                    {{ $item['count'] > 0 ? 'Sudah tercatat' : 'Belum ada data' }}
                                </span>
                            </span>
                        </span>
                        <i class="fa-solid fa-arrow-right shrink-0 text-xs text-slate-400"></i>
                    </a>
                @endforeach
            </div>
        </section>

        <section id="jenis-usaha" aria-labelledby="jenis-usaha-heading" class="scroll-mt-6">
            <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-violet-700">Profil usaha koperasi</p>
                    <h2 id="jenis-usaha-heading" class="text-xl font-black tracking-tight text-slate-900 sm:text-2xl">Jenis usaha yang dimiliki atau direncanakan</h2>
                    <p class="mt-1 max-w-2xl text-sm text-slate-500">Pilih satu atau beberapa kategori. Pilihan disimpan pada profil koperasi dan dapat diperbarui kapan saja.</p>
                </div>
            </div>

            <div class="grid gap-5">
                @forelse($operatorKoperasiProfiles as $profile)
                    @php($koperasi = $profile['koperasi'])
                    <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xs">
                        <div class="flex flex-col justify-between gap-3 border-b border-slate-100 bg-slate-50/70 px-5 py-4 sm:flex-row sm:items-center sm:px-6">
                            <div class="min-w-0">
                                <h3 class="break-words font-black text-slate-900">{{ $koperasi->name_koperasi }}</h3>
                                <p class="mt-0.5 text-xs text-slate-500">Centang seluruh kategori yang sesuai dengan profil koperasi.</p>
                                @if($profile['selected_usaha_ids'] === [])
                                    <p class="mt-1 text-xs font-semibold text-amber-700">Belum ada jenis usaha yang dipilih.</p>
                                @else
                                    <p class="mt-1 break-words text-xs text-violet-800">
                                        Terpilih: {{ collect($jenisUsahaOptions)->whereIn('id', $profile['selected_usaha_ids'])->pluck('name')->join(', ') }}
                                    </p>
                                @endif
                            </div>
                            <span class="inline-flex w-fit shrink-0 items-center gap-1.5 rounded-full border border-violet-200 bg-violet-50 px-3 py-1.5 text-xs font-bold text-violet-800">
                                <i class="fa-solid fa-list-check"></i>
                                {{ count($profile['selected_usaha_ids']) }} terpilih
                            </span>
                        </div>

                        <form action="{{ route('admin.koperasi.usaha', $koperasi->id_koperasi) }}" method="POST" class="flex flex-col gap-4 p-5 sm:p-6">
                            @csrf
                            <input type="hidden" name="has_types_input" value="1">
                            <div class="grid gap-2 sm:grid-cols-2 xl:grid-cols-3">
                                @foreach($jenisUsahaOptions as $usaha)
                                    <label for="usaha-{{ $koperasi->id_koperasi }}-{{ $usaha['id'] }}" class="flex min-h-12 cursor-pointer items-start gap-3 rounded-xl border border-slate-200 bg-white p-3 transition hover:border-violet-300 hover:bg-violet-50/40 focus-within:ring-2 focus-within:ring-violet-200">
                                        <input id="usaha-{{ $koperasi->id_koperasi }}-{{ $usaha['id'] }}" name="id_koperasitype{{ $usaha['id'] }}" type="checkbox" value="Yes" @checked(in_array($usaha['id'], $profile['selected_usaha_ids'], true)) class="mt-0.5 h-4 w-4 shrink-0 rounded border-slate-300 text-violet-700 focus:ring-violet-500">
                                        <span class="flex min-w-0 items-start gap-2">
                                            <i class="fa-solid {{ $usaha['icon'] }} mt-0.5 w-4 shrink-0 text-center text-xs text-violet-700"></i>
                                            <span class="text-xs font-bold leading-relaxed text-slate-700">{{ $usaha['name'] }}</span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>

                            <p class="text-xs text-slate-500"><i class="fa-solid fa-globe mr-1 text-violet-600"></i>Akun Microsite merupakan fasilitas digital, bukan gerai fisik.</p>

                            <div class="flex flex-col gap-3 border-t border-slate-100 pt-4 sm:flex-row sm:items-center sm:justify-between">
                                <p class="text-xs text-slate-500">Perubahan berlaku setelah disimpan.</p>
                                <div class="flex flex-col gap-2 sm:flex-row">
                                    <button type="submit" name="reset_types" value="1" class="inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-xl border border-rose-200 bg-white px-5 py-2.5 text-sm font-bold text-rose-700 transition hover:border-rose-300 hover:bg-rose-50 focus:outline-none focus:ring-2 focus:ring-rose-300 focus:ring-offset-2 sm:w-auto">
                                        <i class="fa-solid fa-rotate-left"></i>
                                        Reset semua pilihan
                                    </button>
                                    <button type="submit" class="inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-xl bg-violet-700 px-5 py-2.5 text-sm font-bold text-white shadow-xs transition hover:bg-violet-800 focus:outline-none focus:ring-2 focus:ring-violet-400 focus:ring-offset-2 sm:w-auto">
                                        <i class="fa-solid fa-floppy-disk"></i>
                                        Simpan jenis usaha
                                    </button>
                                </div>
                            </div>
                        </form>
                    </article>
                @empty
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-8 text-center">
                        <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-xl text-slate-400"><i class="fa-solid fa-list-check"></i></span>
                        <p class="mt-3 font-bold text-slate-800">Pilihan jenis usaha belum tersedia</p>
                        <p class="mt-1 text-sm text-slate-500">Lengkapi data koperasi terlebih dahulu agar jenis usaha dapat disimpan.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Dokumentasi & Foto Lokasi Koperasi (Tata Letak Responsif & Berimbang) -->
        <section id="lokasi-koperasi" aria-labelledby="lokasi-koperasi-heading" class="scroll-mt-6">
            <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-rose-700">Dokumentasi Koperasi</p>
                    <h2 id="lokasi-koperasi-heading" class="text-xl sm:text-2xl font-black tracking-tight text-slate-900">Foto lokasi koperasi</h2>
                    <p class="mt-0.5 max-w-2xl text-xs sm:text-sm leading-relaxed text-slate-500">Simpan foto tampak depan atau area koperasi untuk melengkapi profil lokasi.</p>
                </div>
                <span class="inline-flex w-fit shrink-0 items-center gap-1.5 rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-bold text-slate-600 shadow-2xs">
                    <i class="fa-solid fa-building text-rose-600"></i>
                    {{ $locationPhotoKoperasis->count() }} koperasi
                </span>
            </div>

            <div class="grid min-w-0 items-stretch gap-5 {{ $locationPhotoKoperasis->count() === 1 ? 'grid-cols-1' : 'sm:grid-cols-2 xl:grid-cols-3' }}">
                @forelse($locationPhotoKoperasis as $koperasi)
                    <article data-location-photo-card class="group flex min-w-0 flex-col {{ $locationPhotoKoperasis->count() === 1 ? 'lg:flex-row lg:items-stretch' : '' }} overflow-hidden rounded-3xl border border-slate-200/90 bg-white shadow-xs transition duration-200 hover:border-rose-200 hover:shadow-md">
                        <!-- Area Pratinjau Foto -->
                        <div class="relative {{ $locationPhotoKoperasis->count() === 1 ? 'lg:w-5/12 xl:w-1/2 aspect-[16/10] lg:aspect-auto min-h-[240px]' : 'aspect-[16/10] w-full' }} overflow-hidden bg-gradient-to-br from-rose-50 via-slate-100 to-orange-50 shrink-0">
                            @if(filled($koperasi->foto_lokasi))
                                <img data-location-photo-preview data-saved-src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($koperasi->foto_lokasi) }}" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($koperasi->foto_lokasi) }}" alt="Foto lokasi {{ $koperasi->name_koperasi }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                <div data-location-photo-empty class="hidden h-full w-full flex-col items-center justify-center gap-3 text-slate-400 p-6 text-center">
                                    <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-2xl text-rose-500 shadow-sm"><i class="fa-solid fa-camera"></i></span>
                                    <span class="text-sm font-semibold">Pratinjau foto lokasi</span>
                                </div>
                            @else
                                <img data-location-photo-preview data-saved-src="" alt="Pratinjau foto lokasi {{ $koperasi->name_koperasi }}" class="hidden h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                <div data-location-photo-empty class="flex h-full w-full flex-col items-center justify-center gap-2.5 text-slate-400 p-6 text-center min-h-[220px]">
                                    <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-2xl text-rose-400 shadow-xs"><i class="fa-solid fa-camera"></i></span>
                                    <span class="text-sm font-bold text-slate-600">Belum ada foto lokasi</span>
                                    <p class="text-xs text-slate-400 max-w-xs leading-relaxed">Unggah foto tampak depan atau gedung kantor koperasi Anda agar mudah diverifikasi.</p>
                                </div>
                            @endif
                            <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-slate-950/45 via-transparent to-transparent"></div>
                            <span data-location-photo-badge class="absolute bottom-3 left-3 inline-flex items-center gap-1.5 rounded-full border border-white/70 bg-white/95 px-3 py-1.5 text-xs font-bold text-slate-700 shadow-sm backdrop-blur-xs">
                                <i class="fa-solid {{ filled($koperasi->foto_lokasi) ? 'fa-circle-check text-emerald-600' : 'fa-circle-exclamation text-amber-500' }}"></i>
                                {{ filled($koperasi->foto_lokasi) ? 'Foto tersimpan' : 'Belum ada foto' }}
                            </span>
                            <button type="button" data-location-photo-view @if(!filled($koperasi->foto_lokasi)) hidden @endif aria-label="Perbesar foto lokasi {{ $koperasi->name_koperasi }}" title="Perbesar foto" class="absolute right-3 top-3 inline-flex h-9 w-9 items-center justify-center rounded-xl border border-white/70 bg-white/95 text-slate-700 shadow-sm transition hover:bg-white hover:text-rose-700 focus:outline-none focus:ring-2 focus:ring-white cursor-pointer">
                                <i class="fa-solid fa-up-right-and-down-left-from-center text-xs"></i>
                            </button>
                        </div>

                        <!-- Area Formulir & Status Koperasi -->
                        <div class="flex min-w-0 flex-1 flex-col justify-between gap-4 p-5 sm:p-6 lg:p-7">
                            <div class="flex min-w-0 items-start gap-3.5">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-700 border border-rose-100 shadow-2xs">
                                    <i class="fa-solid fa-building text-lg"></i>
                                </span>
                                <div class="min-w-0 flex-1">
                                    <h3 class="break-words font-black text-lg sm:text-xl leading-snug text-slate-900">{{ $koperasi->name_koperasi }}</h3>
                                    <p data-location-photo-status class="mt-1 text-xs sm:text-sm text-slate-500 leading-relaxed">{{ filled($koperasi->foto_lokasi) ? 'Foto lokasi siap ditampilkan.' : 'Tambahkan foto agar lokasi lebih mudah dikenali.' }}</p>
                                </div>
                            </div>

                            <form data-location-photo-form action="{{ route('admin.koperasi.foto-lokasi', $koperasi->id_koperasi) }}" method="POST" enctype="multipart/form-data" class="mt-auto flex min-w-0 flex-col gap-3 rounded-2xl border border-slate-200/80 bg-slate-50/70 p-4">
                                @csrf
                                <label for="foto-lokasi-{{ $koperasi->id_koperasi }}" class="flex min-w-0 cursor-pointer items-center gap-3 rounded-xl border border-dashed border-slate-300 bg-white px-3.5 py-3 transition hover:border-rose-400 hover:bg-rose-50/30 focus-within:border-rose-400 focus-within:ring-2 focus-within:ring-rose-100">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-rose-50 text-rose-700">
                                        <i class="fa-solid fa-arrow-up-from-bracket"></i>
                                    </span>
                                    <span class="min-w-0 flex-1">
                                        <span class="block text-sm font-bold text-slate-800">Pilih foto</span>
                                        <span data-location-photo-filename class="block truncate text-xs text-slate-500" aria-live="polite">JPG, PNG, WebP · Maks. 5 MB</span>
                                    </span>
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-rose-700 bg-rose-50 px-2 py-1 rounded-md shrink-0">
                                        <i class="fa-regular fa-folder-open text-[11px]"></i> Jelajahi
                                    </span>
                                    <input id="foto-lokasi-{{ $koperasi->id_koperasi }}" data-location-photo-input name="foto_lokasi" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" required class="sr-only">
                                </label>
                                <div class="flex min-w-0 flex-wrap items-center justify-between gap-2.5 pt-1">
                                    <button type="button" data-location-photo-clear hidden class="inline-flex min-h-10 items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-bold text-slate-600 transition hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-300 cursor-pointer">
                                        <i class="fa-solid fa-xmark"></i>
                                        Batalkan pilihan
                                    </button>
                                    <button type="submit" data-location-photo-submit disabled class="inline-flex min-h-11 flex-1 items-center justify-center gap-2 rounded-xl bg-rose-700 px-4 py-2.5 text-sm font-bold text-white shadow-xs transition hover:bg-rose-800 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:ring-offset-2 disabled:cursor-not-allowed disabled:bg-slate-200 disabled:text-slate-400 disabled:shadow-none cursor-pointer">
                                        <i data-location-photo-submit-icon class="fa-solid fa-cloud-arrow-up"></i>
                                        <span data-location-photo-submit-label>{{ filled($koperasi->foto_lokasi) ? 'Ganti foto lokasi' : 'Unggah foto lokasi' }}</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </article>
                @empty
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-8 text-center sm:col-span-2 xl:col-span-3">
                        <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-xl text-slate-400"><i class="fa-solid fa-map-location-dot"></i></span>
                        <p class="mt-3 font-bold text-slate-700">Belum ada koperasi</p>
                        <p class="mt-1 text-sm text-slate-500">Koperasi yang terdaftar di wilayah desa Anda akan tampil di sini.</p>
                    </div>
                @endforelse
            </div>

            <!-- Dialog Modal Pratinjau Foto Lokasi -->
            <dialog data-location-photo-dialog aria-labelledby="location-photo-dialog-title" class="w-[min(92vw,64rem)] max-w-none rounded-3xl bg-transparent p-0 backdrop:bg-slate-950/80">
                <div class="overflow-hidden rounded-3xl border border-white/15 bg-slate-950 shadow-2xl">
                    <div class="flex items-center justify-between gap-4 px-4 py-3 text-white sm:px-5">
                        <h3 id="location-photo-dialog-title" data-location-photo-dialog-title class="min-w-0 truncate text-sm font-bold sm:text-base">Foto lokasi koperasi</h3>
                        <button type="button" data-location-photo-dialog-close aria-label="Tutup pratinjau foto" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-white/80 transition hover:bg-white/10 hover:text-white focus:outline-none focus:ring-2 focus:ring-white cursor-pointer">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>
                    <img data-location-photo-dialog-image alt="" class="max-h-[78vh] w-full bg-black object-contain">
                </div>
            </dialog>
        </section>

        <footer class="border-t border-slate-200 py-4 text-center text-xs text-slate-500">
            Portal Koperasi Desa & Kelurahan Merah Putih · Kabupaten Bogor
        </footer>
            </div>
        </div>
        @endif
    </main>
</div>
@endsection

@push('scripts')
    <script>
        (() => {
            document.querySelectorAll('[data-location-photo-card]').forEach((card) => {
                const input = card.querySelector('[data-location-photo-input]');
                const image = card.querySelector('[data-location-photo-preview]');
                const emptyState = card.querySelector('[data-location-photo-empty]');
                const filename = card.querySelector('[data-location-photo-filename]');
                const status = card.querySelector('[data-location-photo-status]');
                const badge = card.querySelector('[data-location-photo-badge]');
                const viewButton = card.querySelector('[data-location-photo-view]');
                const clearButton = card.querySelector('[data-location-photo-clear]');
                const form = card.querySelector('[data-location-photo-form]');
                const submitButton = card.querySelector('[data-location-photo-submit]');
                const submitIcon = card.querySelector('[data-location-photo-submit-icon]');
                const submitLabel = card.querySelector('[data-location-photo-submit-label]');
                const dialog = document.querySelector('[data-location-photo-dialog]');
                const dialogImage = dialog?.querySelector('[data-location-photo-dialog-image]');
                const dialogTitle = dialog?.querySelector('[data-location-photo-dialog-title]');
                let previewUrl = null;

                if (!input || !image || !emptyState || !filename || !status || !badge || !viewButton || !clearButton || !form || !submitButton || !submitIcon || !submitLabel) {
                    return;
                }

                const clearPreviewUrl = () => {
                    if (previewUrl) {
                        URL.revokeObjectURL(previewUrl);
                        previewUrl = null;
                    }
                };

                const openPhotoDialog = () => {
                    if (!dialog || !dialogImage || !image.src) {
                        return;
                    }

                    dialogImage.src = image.src;
                    dialogImage.alt = image.alt;
                    if (dialogTitle) {
                        dialogTitle.textContent = card.querySelector('h3')?.textContent?.trim() ?? 'Foto lokasi koperasi';
                    }
                    dialog.showModal();
                };

                viewButton.addEventListener('click', openPhotoDialog);

                input.addEventListener('change', () => {
                    const file = input.files?.[0];
                    if (!file) {
                        return;
                    }

                    if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type) || file.size > 5 * 1024 * 1024) {
                        input.value = '';
                        filename.textContent = 'Gunakan JPG, PNG, atau WebP maksimal 5 MB.';
                        status.textContent = 'File tidak sesuai format atau ukuran yang diizinkan.';
                        submitButton.disabled = true;
                        return;
                    }

                    clearPreviewUrl();
                    previewUrl = URL.createObjectURL(file);
                    image.src = previewUrl;
                    image.classList.remove('hidden');
                    emptyState.classList.add('hidden');
                    filename.textContent = file.name;
                    status.textContent = 'Pratinjau foto baru. Simpan untuk menerapkan perubahan.';
                    badge.innerHTML = '<i class="fa-solid fa-eye text-sky-600"></i> Pratinjau baru';
                    viewButton.hidden = false;
                    clearButton.hidden = false;
                    submitButton.disabled = false;
                });

                clearButton.addEventListener('click', () => {
                    input.value = '';
                    clearPreviewUrl();
                    const savedSrc = image.dataset.savedSrc;

                    if (savedSrc) {
                        image.src = savedSrc;
                        image.classList.remove('hidden');
                        emptyState.classList.add('hidden');
                        viewButton.hidden = false;
                        status.textContent = 'Foto lokasi siap ditampilkan.';
                        badge.innerHTML = '<i class="fa-solid fa-circle-check text-emerald-600"></i> Foto tersimpan';
                    } else {
                        image.removeAttribute('src');
                        image.classList.add('hidden');
                        emptyState.classList.remove('hidden');
                        viewButton.hidden = true;
                        status.textContent = 'Tambahkan foto agar lokasi lebih mudah dikenali.';
                        badge.innerHTML = '<i class="fa-solid fa-circle-exclamation text-amber-500"></i> Belum ada foto';
                    }

                    filename.textContent = 'JPG, PNG, WebP · Maks. 5 MB';
                    clearButton.hidden = true;
                    submitButton.disabled = true;
                });

                form.addEventListener('submit', () => {
                    submitButton.disabled = true;
                    submitIcon.className = 'fa-solid fa-spinner fa-spin';
                    submitLabel.textContent = 'Mengunggah foto...';
                });
            });

            const locationPhotoDialog = document.querySelector('[data-location-photo-dialog]');
            const locationPhotoDialogClose = locationPhotoDialog?.querySelector('[data-location-photo-dialog-close]');
            const locationPhotoDialogImage = locationPhotoDialog?.querySelector('[data-location-photo-dialog-image]');

            locationPhotoDialogClose?.addEventListener('click', () => locationPhotoDialog.close());
            locationPhotoDialog?.addEventListener('click', (event) => {
                if (event.target === locationPhotoDialog) {
                    locationPhotoDialog.close();
                }
            });
            locationPhotoDialog?.addEventListener('close', () => {
                if (locationPhotoDialogImage) {
                    locationPhotoDialogImage.removeAttribute('src');
                }
            });

            const fotoPengurusInput = document.getElementById('pengurus-foto-file');
            const namaFotoPengurus = document.getElementById('pengurus-foto-name');
            const pratinjauFotoPengurus = document.getElementById('pengurus-foto-preview');
            const gambarPratinjauFotoPengurus = document.getElementById('pengurus-foto-preview-image');
            let urlPratinjauFotoPengurus = null;

            if (fotoPengurusInput && namaFotoPengurus && pratinjauFotoPengurus && gambarPratinjauFotoPengurus) {
                fotoPengurusInput.addEventListener('change', () => {
                    if (urlPratinjauFotoPengurus) {
                        URL.revokeObjectURL(urlPratinjauFotoPengurus);
                        urlPratinjauFotoPengurus = null;
                    }

                    const fileFotoPengurus = fotoPengurusInput.files?.[0];
                    namaFotoPengurus.textContent = fileFotoPengurus?.name ?? 'Belum ada file dipilih';

                    if (!fileFotoPengurus || !fileFotoPengurus.type.startsWith('image/')) {
                        pratinjauFotoPengurus.classList.add('hidden');
                        gambarPratinjauFotoPengurus.removeAttribute('src');
                        return;
                    }

                    urlPratinjauFotoPengurus = URL.createObjectURL(fileFotoPengurus);
                    gambarPratinjauFotoPengurus.src = urlPratinjauFotoPengurus;
                    pratinjauFotoPengurus.classList.remove('hidden');
                    pratinjauFotoPengurus.classList.add('flex');
                });
            }

            window.selectPengurusForPhoto = (id) => {
                const select = document.getElementById('pengurus-foto-id');
                const section = document.getElementById('foto-pengurus');
                if (select) {
                    select.value = String(id);
                }
                if (section) {
                    section.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    const form = section.querySelector('form');
                    if (form) {
                        form.classList.add('ring-4', 'ring-rose-200');
                        setTimeout(() => form.classList.remove('ring-4', 'ring-rose-200'), 1400);
                    }
                }
            };
        })();
    </script>
@endpush
