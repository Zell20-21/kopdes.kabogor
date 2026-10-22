@extends('layouts.app')

@section('title', 'Ringkasan Koperasi | Kabupaten Bogor')

@section('content')
<div class="min-h-screen bg-slate-50 text-slate-800">
    <header class="bg-gradient-to-r from-[#881337] via-[#991b1b] to-[#7f1d1d] text-white shadow-lg">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-x-6 gap-y-4 px-4 py-4 sm:px-6 lg:px-8">
            <div class="flex min-w-0 items-center gap-2.5 sm:gap-3">
                <img src="{{ asset('images/logo-kabupaten-bogor.png') }}" alt="Kabupaten Bogor" class="h-9 w-auto shrink-0 object-contain sm:h-11">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-full border border-white/40 bg-white p-1 sm:h-12 sm:w-12">
                    <img src="{{ asset('images/logo-kopdeskel-clean.png') }}" alt="Koperasi Merah Putih" class="h-full w-full object-contain">
                </div>
                <div class="min-w-0">
                    <p class="truncate text-[10px] font-bold uppercase tracking-[0.12em] text-red-100 sm:text-xs sm:tracking-[0.18em]">Portal Koperasi Desa & Kelurahan</p>
                    <h1 class="text-base font-extrabold leading-tight sm:text-xl">Kabupaten Bogor</h1>
                </div>
            </div>

            <div class="flex w-full items-center justify-between gap-3 sm:w-auto sm:justify-end">
                <nav aria-label="Navigasi halaman" class="flex min-w-0 items-center gap-1 overflow-x-auto text-sm font-semibold sm:gap-2">
                    <a href="#anggota" class="shrink-0 rounded-lg px-3 py-2 transition hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/70">Anggota</a>
                    <a href="#pengurus" class="shrink-0 rounded-lg px-3 py-2 transition hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/70">Pengurus</a>
                    <a href="#lokasi-koperasi" class="shrink-0 rounded-lg px-3 py-2 transition hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/70">Lokasi</a>
                    <a href="#foto-pengurus" class="shrink-0 rounded-lg px-3 py-2 transition hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/70">Foto</a>
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

        <!-- Ringkasan Pengelolaan Koperasi -->
        <section aria-labelledby="ringkasan-heading" class="flex flex-col gap-5">
            <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-end">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full border border-rose-200 bg-rose-50 px-3 py-1 text-xs font-bold text-rose-700">
                        <span class="h-2 w-2 rounded-full bg-rose-600 animate-pulse"></span>
                        Ringkasan Pengelolaan Wilayah
                    </div>
                    <h2 id="ringkasan-heading" class="mt-2 text-2xl font-black tracking-tight text-slate-900 sm:text-3xl">
                        Selamat datang, {{ $user->name_user ?? 'Admin' }}
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">Informasi dan pengelolaan anggota serta pengurus koperasi dalam satu halaman.</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-bold text-slate-700 shadow-xs">
                        <i class="fa-solid fa-shield-halved text-rose-600"></i>
                        Operator Desa / Kelurahan
                    </span>
                </div>
            </div>

            <!-- 3 Kartu Metrik Terpadu & Interaktif -->
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <article class="group relative flex min-h-36 flex-col justify-between rounded-2xl border-t-4 border-t-rose-600 border-x border-b border-slate-200/90 bg-white p-5 shadow-xs transition duration-200 hover:-translate-y-1 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Koperasi</span>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-rose-50 text-rose-700 shadow-2xs transition group-hover:scale-105">
                            <i class="fa-solid fa-building text-base"></i>
                        </span>
                    </div>
                    <div>
                        <p class="mt-3 text-3xl font-black text-slate-900">{{ number_format($totalKoperasi) }}</p>
                        <p class="mt-1 flex items-center gap-1.5 text-xs text-slate-500">
                            <i class="fa-regular fa-circle-check text-emerald-600"></i>
                            Dalam wilayah akun Anda
                        </p>
                    </div>
                </article>

                <article class="group relative flex min-h-36 flex-col justify-between rounded-2xl border-t-4 border-t-red-700 border-x border-b border-slate-200/90 bg-white p-5 shadow-xs transition duration-200 hover:-translate-y-1 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Anggota</span>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-rose-100/70 text-rose-800 shadow-2xs transition group-hover:scale-105">
                            <i class="fa-solid fa-users text-base"></i>
                        </span>
                    </div>
                    <div>
                        <p class="mt-3 text-3xl font-black text-slate-900">{{ number_format($totalAnggota) }}</p>
                        <p class="mt-1 flex items-center gap-1.5 text-xs text-slate-500">
                            <i class="fa-regular fa-circle-check text-emerald-600"></i>
                            Anggota terdata pada koperasi
                        </p>
                    </div>
                </article>

                <article class="group relative flex min-h-36 flex-col justify-between rounded-2xl border-t-4 border-t-sky-600 border-x border-b border-slate-200/90 bg-white p-5 shadow-xs transition duration-200 hover:-translate-y-1 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Pengurus Koperasi</span>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-sky-50 text-sky-700 shadow-2xs transition group-hover:scale-105">
                            <i class="fa-solid fa-user-tie text-base"></i>
                        </span>
                    </div>
                    <div>
                        <p class="mt-3 text-3xl font-black text-slate-900">{{ number_format($statsPengurus['total'] ?? 0) }}</p>
                        <p class="mt-1 flex items-center gap-1.5 text-xs text-slate-500">
                            <i class="fa-regular fa-circle-check text-emerald-600"></i>
                            Pengurus dan pengawas aktif
                        </p>
                    </div>
                </article>
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

        <!-- Keanggotaan: Data & Pendaftaran Anggota -->
        <section id="anggota" aria-labelledby="anggota-heading" class="scroll-mt-6">
            <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-rose-700">Keanggotaan</p>
                    <h2 id="anggota-heading" class="text-xl sm:text-2xl font-black tracking-tight text-slate-900">Data anggota koperasi</h2>
                    <p class="mt-0.5 text-xs sm:text-sm text-slate-500">Kelola dan daftarkan anggota perorangan koperasi di desa / kelurahan Anda.</p>
                </div>
                <span class="inline-flex w-fit items-center gap-1.5 rounded-full bg-rose-50 px-3.5 py-1.5 text-xs font-bold text-rose-700 border border-rose-200 shadow-2xs">
                    <i class="fa-solid fa-users text-rose-600"></i>
                    {{ number_format($totalAnggota) }} anggota
                </span>
            </div>

            <div class="grid items-start gap-5 lg:grid-cols-[minmax(19rem,0.8fr)_minmax(0,1.2fr)]">
                <!-- Form Tambah Anggota -->
                <form action="{{ route('admin.anggota.store') }}" method="POST" class="flex flex-col gap-4 rounded-3xl border border-slate-200/90 bg-white p-5 sm:p-6 shadow-xs hover:shadow-sm transition-shadow">
                    @csrf
                    <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-700 shadow-2xs">
                            <i class="fa-solid fa-user-plus"></i>
                        </span>
                        <div>
                            <h3 class="text-base font-extrabold text-slate-900 leading-tight">Tambah anggota</h3>
                            <p class="text-xs text-slate-500">Daftarkan anggota baru koperasi.</p>
                        </div>
                    </div>

                    <div>
                        <label for="anggota-koperasi" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600">Koperasi</label>
                        <select id="anggota-koperasi" name="id_koperasi" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200 transition">
                            <option value="">Pilih koperasi</option>
                            @foreach($allKoperasis as $koperasi)
                                <option value="{{ $koperasi->id_koperasi }}" @selected((string) old('id_koperasi') === (string) $koperasi->id_koperasi)>
                                    {{ $koperasi->name_koperasi }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_koperasi')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="anggota-nama" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600">Nama lengkap</label>
                        <input id="anggota-nama" name="name_kopang" type="text" placeholder="Masukkan nama lengkap anggota" value="{{ old('name_kopang') }}" required maxlength="255" autocomplete="name" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200 transition">
                        @error('name_kopang')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="anggota-tipe" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600">Kategori</label>
                        <select id="anggota-tipe" name="id_kopangtype" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200 transition">
                            <option value="">Pilih kategori</option>
                            @foreach($koperasiTypes as $type)
                                <option value="{{ $type->id_kopangtype }}" @selected((string) old('id_kopangtype') === (string) $type->id_kopangtype)>{{ $type->name_kopangtype }}</option>
                            @endforeach
                        </select>
                        @error('id_kopangtype')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="anggota-usaha" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600">Nama usaha <span class="font-normal lowercase text-slate-400">(opsional)</span></label>
                        <input id="anggota-usaha" name="kopang_usaha" type="text" placeholder="Contoh: Warung Sembako Barokah" value="{{ old('kopang_usaha') }}" maxlength="255" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200 transition">
                        @error('kopang_usaha')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="mt-2 inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-xl bg-rose-700 px-4 py-3 text-sm font-bold text-white shadow-xs transition hover:bg-rose-800 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:ring-offset-2 cursor-pointer active:scale-98">
                        <i class="fa-solid fa-user-plus"></i>
                        Simpan anggota
                    </button>
                </form>

                <!-- Tabel Anggota Terbaru -->
                <div class="overflow-hidden rounded-3xl border border-slate-200/90 bg-white shadow-xs hover:shadow-sm transition-shadow">
                    <div class="flex items-center justify-between gap-3 border-b border-slate-100 px-5 py-4">
                        <div>
                            <h3 class="font-black text-slate-900 text-base">Anggota terbaru</h3>
                            <p class="mt-0.5 text-xs text-slate-500 leading-snug">Total anggota mengikuti data koperasi; daftar ini berisi anggota perorangan yang tercatat. NIK tidak ditampilkan.</p>
                        </div>
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-700 shadow-2xs">
                            <i class="fa-solid fa-users text-lg"></i>
                        </span>
                    </div>
                    <div class="overflow-x-auto focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-[-2px] focus-visible:outline-rose-500" role="region" aria-label="Daftar anggota; geser secara horizontal untuk melihat semua kolom" tabindex="0">
                        <table class="w-full min-w-[520px] table-fixed text-left text-sm">
                            <thead class="bg-slate-50/80 text-xs uppercase tracking-wider text-slate-500 border-b border-slate-100">
                                <tr>
                                    <th scope="col" class="w-[36%] px-5 py-3.5 font-bold">Nama</th>
                                    <th scope="col" class="w-[38%] px-5 py-3.5 font-bold">Koperasi</th>
                                    <th scope="col" class="w-[26%] px-5 py-3.5 font-bold">Kategori</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($anggotaRecords as $anggota)
                                    <tr class="hover:bg-rose-50/20 transition">
                                        <td class="px-5 py-3.5">
                                            <p class="break-words font-bold text-slate-800">{{ $anggota->name_kopang }}</p>
                                            <p class="mt-0.5 break-words text-xs text-slate-500 flex items-center gap-1">
                                                <i class="fa-solid fa-phone text-[10px] text-slate-400"></i>
                                                {{ $anggota->kopang_telp ?: 'Telepon belum dicatat' }}
                                            </p>
                                        </td>
                                        <td class="break-words px-5 py-3.5 text-slate-600 text-xs">{{ $anggota->koperasi?->name_koperasi ?? 'Koperasi tidak tersedia' }}</td>
                                        <td class="break-words px-5 py-3.5">
                                            <span class="inline-block px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700">
                                                {{ $anggota->type?->name_kopangtype ?? 'Belum dikategorikan' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-5 py-8">
                                            <div class="flex min-h-48 flex-col items-center justify-center text-center text-sm text-slate-500">
                                                <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mb-3">
                                                    <i class="fa-regular fa-address-card" aria-hidden="true"></i>
                                                </div>
                                                <p class="font-bold text-slate-700">Belum ada data anggota perorangan.</p>
                                                <p class="mt-1 text-xs text-slate-400">Tambahkan anggota baru melalui formulir di sebelah kiri.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($anggotaRecords->hasPages())
                        <div class="border-t border-slate-100 px-5 py-3.5 bg-slate-50/50">{{ $anggotaRecords->links() }}</div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Struktur Organisasi & Pengurus Koperasi -->
        <section id="pengurus" aria-labelledby="pengurus-heading" class="scroll-mt-6">
            <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-rose-700">Struktur Organisasi</p>
                    <h2 id="pengurus-heading" class="text-xl sm:text-2xl font-black tracking-tight text-slate-900">Pengurus koperasi</h2>
                    <p class="mt-0.5 text-xs sm:text-sm text-slate-500">Daftar jajaran pengurus dan pengawas yang bertugas mengelola koperasi.</p>
                </div>
                <span class="inline-flex w-fit items-center gap-1.5 rounded-full bg-sky-50 px-3.5 py-1.5 text-xs font-bold text-sky-700 border border-sky-200 shadow-2xs">
                    <i class="fa-solid fa-user-tie text-sky-600"></i>
                    {{ number_format($statsPengurus['total'] ?? 0) }} pengurus
                </span>
            </div>

            <!-- Kartu Tambah Pengurus (Collapsible Accordion yang Rapi) -->
            <details class="group mb-5 rounded-3xl border border-slate-200/90 bg-white shadow-xs overflow-hidden">
                <summary class="flex cursor-pointer list-none items-center justify-between gap-3 p-5 sm:px-6 transition hover:bg-slate-50/80 focus:outline-none">
                    <div class="flex items-center gap-3.5">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-700 shadow-2xs">
                            <i class="fa-solid fa-user-plus text-base"></i>
                        </span>
                        <div>
                            <span class="block font-black text-slate-900 text-base">Tambah pengurus</span>
                            <span class="mt-0.5 block text-xs sm:text-sm text-slate-500">Tambahkan pengurus atau pengawas koperasi baru.</span>
                        </div>
                    </div>
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-500 group-open:rotate-180 transition-transform duration-200">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </span>
                </summary>
                <form action="{{ route('admin.pengurus.store') }}" method="POST" class="grid gap-4 border-t border-slate-100 p-5 sm:p-6 sm:grid-cols-2 bg-slate-50/40">
                    @csrf
                    <div class="sm:col-span-2">
                        <label for="pengurus-koperasi" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600">Koperasi</label>
                        <select id="pengurus-koperasi" name="id_koperasi" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200 transition">
                            <option value="">Pilih koperasi</option>
                            @foreach($allKoperasis as $koperasi)
                                <option value="{{ $koperasi->id_koperasi }}" @selected((string) old('id_koperasi') === (string) $koperasi->id_koperasi)>{{ $koperasi->name_koperasi }}</option>
                            @endforeach
                        </select>
                        @error('id_koperasi')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="pengurus-nama" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600">Nama lengkap</label>
                        <input id="pengurus-nama" name="name_kopsdm" type="text" placeholder="Masukkan nama pengurus" value="{{ old('name_kopsdm') }}" maxlength="255" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200 transition">
                        @error('name_kopsdm')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="pengurus-jabatan" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600">Jabatan</label>
                        <select id="pengurus-jabatan" name="jab_kopsdm" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200 transition">
                            <option value="KETUA KOPERASI">Ketua koperasi</option>
                            <option value="WAKIL KETUA KOPERASI">Wakil ketua koperasi</option>
                            <option value="SEKRETARIS KOPERASI">Sekretaris koperasi</option>
                            <option value="BENDAHARA KOPERASI">Bendahara koperasi</option>
                            <option value="KETUA PENGAWAS">Ketua pengawas</option>
                            <option value="ANGGOTA PENGAWAS">Anggota pengawas</option>
                        </select>
                    </div>
                    <div>
                        <label for="pengurus-kategori" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600">Kategori</label>
                        <select id="pengurus-kategori" name="type_kopsdm" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200 transition">
                            <option value="PENGURUS">Pengurus</option>
                            <option value="PENGAWAS">Pengawas</option>
                        </select>
                    </div>
                    <div>
                        <label for="pengurus-urutan" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600">Urutan struktur</label>
                        <input id="pengurus-urutan" name="order_kopsdm" type="text" value="{{ old('order_kopsdm', '1') }}" maxlength="10" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200 transition">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="pengurus-keterangan" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600">Keterangan <span class="font-normal lowercase text-slate-400">(opsional)</span></label>
                        <input id="pengurus-keterangan" name="comt_kopsdm" type="text" placeholder="Keterangan tambahan" value="{{ old('comt_kopsdm') }}" maxlength="255" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200 transition">
                    </div>
                    @error('jab_kopsdm')<p class="text-xs text-rose-600">{{ $message }}</p>@enderror
                    @error('type_kopsdm')<p class="text-xs text-rose-600">{{ $message }}</p>@enderror
                    <div class="sm:col-span-2 pt-2">
                        <button type="submit" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-rose-700 px-6 py-2.5 text-sm font-bold text-white shadow-xs transition hover:bg-rose-800 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:ring-offset-2 cursor-pointer active:scale-98">
                            <i class="fa-solid fa-user-plus"></i>
                            Simpan pengurus
                        </button>
                    </div>
                </form>
            </details>

            <!-- Grid Kartu Pengurus yang Rapi & Proporsional -->
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($penguruses as $pengurus)
                    <article class="group relative overflow-hidden rounded-2xl border border-slate-200/90 bg-white p-4 sm:p-5 shadow-2xs transition duration-200 hover:-translate-y-0.5 hover:border-rose-300 hover:shadow-md">
                        <div class="flex items-start gap-3.5">
                            @if(filled($pengurus->foto_kopsdm))
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($pengurus->foto_kopsdm) }}" alt="Foto {{ $pengurus->name_kopsdm }}" class="h-16 w-16 sm:h-18 sm:w-18 shrink-0 rounded-2xl object-cover border border-slate-200 shadow-2xs">
                            @else
                                <div class="flex h-16 w-16 sm:h-18 sm:w-18 shrink-0 items-center justify-center rounded-2xl bg-slate-100 text-2xl text-slate-400 border border-slate-200/60">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <h3 class="break-words font-black text-sm sm:text-base leading-snug text-slate-900 group-hover:text-rose-700 transition">{{ $pengurus->name_kopsdm }}</h3>
                                <span class="mt-1 inline-block text-[11px] font-bold px-2.5 py-0.5 rounded-md bg-rose-50 text-rose-700 border border-rose-100">
                                    {{ $pengurus->jab_kopsdm }}
                                </span>
                                <p class="mt-1.5 break-words text-xs text-slate-500 leading-tight truncate">{{ $pengurus->koperasi?->name_koperasi ?? 'Koperasi tidak tersedia' }}</p>

                                <button type="button" onclick="selectPengurusForPhoto({{ $pengurus->id_kopsdm }})" class="mt-2.5 text-[11px] font-bold text-rose-600 hover:text-rose-800 inline-flex items-center gap-1 group/btn cursor-pointer">
                                    <i class="fa-solid fa-camera text-[10px]"></i>
                                    <span>{{ filled($pengurus->foto_kopsdm) ? 'Ganti Foto' : 'Unggah Foto' }}</span>
                                    <i class="fa-solid fa-arrow-down text-[9px] group-hover/btn:translate-y-0.5 transition-transform"></i>
                                </button>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-8 text-center text-sm text-slate-500 sm:col-span-2 lg:col-span-3">
                        Belum ada data pengurus pada wilayah ini.
                    </div>
                @endforelse
            </div>

            @if($penguruses->hasPages())
                <div class="mt-4">{{ $penguruses->links() }}</div>
            @endif
        </section>

        <!-- Kelengkapan Profil: Unggah Foto Pengurus -->
        <section id="foto-pengurus" aria-labelledby="foto-pengurus-heading" class="scroll-mt-6">
            <div class="mb-4">
                <p class="text-xs font-bold uppercase tracking-[0.16em] text-rose-700">Kelengkapan Profil</p>
                <h2 id="foto-pengurus-heading" class="text-xl sm:text-2xl font-black tracking-tight text-slate-900">Unggah foto pengurus</h2>
                <p class="mt-0.5 text-xs sm:text-sm text-slate-500">Pilih pengurus yang fotonya ingin ditambahkan atau diperbarui.</p>
            </div>

            @if($pengurusFotoOptions->isNotEmpty())
                <form action="{{ route('admin.pengurus.foto.operator') }}" method="POST" enctype="multipart/form-data" class="rounded-3xl border border-slate-200/90 bg-white p-5 sm:p-7 shadow-xs hover:shadow-sm transition-all">
                    @csrf
                    <div class="grid gap-6 md:grid-cols-2">
                        <!-- Kolom Kiri: Pilihan Pengurus & Pratinjau -->
                        <div class="flex flex-col gap-4">
                            <div>
                                <label for="pengurus-foto-id" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600">Pilih pengurus</label>
                                <select id="pengurus-foto-id" name="id_kopsdm" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200 transition">
                                    <option value="">Pilih pengurus</option>
                                    @foreach($pengurusFotoOptions as $pengurus)
                                        <option value="{{ $pengurus->id_kopsdm }}" @selected(old('id_kopsdm') == $pengurus->id_kopsdm)>
                                            {{ $pengurus->name_kopsdm }} — {{ $pengurus->jab_kopsdm }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_kopsdm')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                            </div>

                            <div id="pengurus-foto-preview" class="hidden items-center gap-4 rounded-2xl border border-slate-200 bg-slate-50/80 p-3.5">
                                <img id="pengurus-foto-preview-image" alt="Pratinjau foto yang dipilih" class="h-20 w-20 shrink-0 rounded-xl object-cover shadow-2xs border border-white">
                                <div class="min-w-0">
                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200">
                                        <i class="fa-solid fa-eye text-[10px]"></i> Pratinjau Siap
                                    </span>
                                    <p class="text-xs text-slate-500 mt-1">Foto baru akan disimpan saat Anda menekan tombol "Unggah foto".</p>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan: Input Berkas Foto -->
                        <div class="flex flex-col justify-between gap-4">
                            <div>
                                <label for="pengurus-foto-file" class="block text-xs font-bold uppercase tracking-wider text-slate-600">
                                    Foto (JPG, PNG, atau WebP; maks. 5 MB)
                                </label>
                                <div class="mt-1.5 rounded-2xl border border-dashed border-slate-300 bg-slate-50/50 p-4 transition hover:border-rose-400 hover:bg-rose-50/20">
                                    <input id="pengurus-foto-file" type="file" name="foto" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" required class="block w-full text-xs text-slate-600 file:mr-3 file:rounded-xl file:border-0 file:bg-rose-50 file:px-3.5 file:py-2 file:font-bold file:text-rose-700 hover:file:bg-rose-100 focus:outline-none cursor-pointer">
                                    <span id="pengurus-foto-name" class="mt-2 block break-all text-xs font-normal text-slate-500" aria-live="polite">Belum ada file dipilih</span>
                                </div>
                                @error('foto')<span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>@enderror
                            </div>

                            <div class="pt-1">
                                <button type="submit" class="inline-flex min-h-11 w-full sm:w-auto items-center justify-center gap-2 rounded-xl bg-rose-700 px-6 py-2.5 text-sm font-bold text-white shadow-xs transition hover:bg-rose-800 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:ring-offset-2 cursor-pointer active:scale-98">
                                    <i class="fa-solid fa-upload"></i>
                                    Unggah foto
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            @else
                <div class="rounded-3xl border border-dashed border-emerald-200 bg-emerald-50 p-8 text-center text-sm font-semibold text-emerald-800">
                    Belum ada data pengurus yang dapat dipilih.
                </div>
            @endif
        </section>

        <footer class="border-t border-slate-200 py-4 text-center text-xs text-slate-500">
            Portal Koperasi Desa & Kelurahan Merah Putih · Kabupaten Bogor
        </footer>
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
