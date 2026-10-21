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

        <section aria-labelledby="ringkasan-heading" class="flex flex-col gap-5">
            <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-end">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.16em] text-rose-700">Ringkasan pengelolaan</p>
                    <h2 id="ringkasan-heading" class="mt-1 text-2xl font-black tracking-tight text-slate-900 sm:text-3xl">
                        Selamat datang, {{ $user->name_user ?? 'Admin' }}
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">Informasi dan pengelolaan anggota serta pengurus koperasi dalam satu halaman.</p>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <article class="flex min-h-40 flex-col justify-between rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-semibold text-slate-500">Total koperasi</p>
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-50 text-rose-700"><i class="fa-solid fa-building"></i></span>
                    </div>
                    <div>
                        <p class="mt-4 text-3xl font-black text-slate-900">{{ number_format($totalKoperasi) }}</p>
                        <p class="mt-1 text-xs text-slate-500">Dalam wilayah akun Anda</p>
                    </div>
                </article>
                <article class="flex min-h-40 flex-col justify-between rounded-2xl border border-rose-200 bg-rose-700 p-5 text-white shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-semibold text-rose-100">Total anggota</p>
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/15"><i class="fa-solid fa-users"></i></span>
                    </div>
                    <div>
                        <p class="mt-4 text-3xl font-black">{{ number_format($totalAnggota) }}</p>
                        <p class="mt-1 text-xs text-rose-100">Anggota terdata pada koperasi</p>
                    </div>
                </article>
                <article class="flex min-h-40 flex-col justify-between rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-semibold text-slate-500">Pengurus</p>
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-50 text-sky-700"><i class="fa-solid fa-user-tie"></i></span>
                    </div>
                    <div>
                        <p class="mt-4 text-3xl font-black text-slate-900">{{ number_format($statsPengurus['total'] ?? 0) }}</p>
                        <p class="mt-1 text-xs text-slate-500">Pengurus dan pengawas aktif</p>
                    </div>
                </article>
            </div>
        </section>

        <section id="anggota" aria-labelledby="anggota-heading" class="scroll-mt-6">
            <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.16em] text-rose-700">Keanggotaan</p>
                    <h2 id="anggota-heading" class="text-2xl font-black tracking-tight text-slate-900">Data anggota koperasi</h2>
                </div>
                <span class="rounded-full bg-rose-50 px-3 py-1 text-sm font-bold text-rose-700">{{ number_format($totalAnggota) }} anggota</span>
            </div>

            <div class="grid items-start gap-4 lg:grid-cols-[minmax(19rem,0.78fr)_minmax(0,1.22fr)] lg:gap-5">
                <form action="{{ route('admin.anggota.store') }}" method="POST" class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                    @csrf
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900">Tambah anggota</h3>
                        <p class="mt-1 text-sm text-slate-500">NIK disimpan dalam bentuk terenkripsi.</p>
                    </div>

                    <div>
                        <label for="anggota-koperasi" class="mb-1.5 block text-sm font-semibold text-slate-700">Koperasi</label>
                        <select id="anggota-koperasi" name="id_koperasi" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
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
                        <label for="anggota-nama" class="mb-1.5 block text-sm font-semibold text-slate-700">Nama lengkap</label>
                        <input id="anggota-nama" name="name_kopang" type="text" value="{{ old('name_kopang') }}" required maxlength="255" autocomplete="name" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
                        @error('name_kopang')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="anggota-nik" class="mb-1.5 block text-sm font-semibold text-slate-700">NIK (16 digit)</label>
                        <input id="anggota-nik" name="nik_kopang" type="text" inputmode="numeric" pattern="[0-9]{16}" maxlength="16" minlength="16" required autocomplete="off" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 font-mono text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
                        @error('nik_kopang')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="anggota-telepon" class="mb-1.5 block text-sm font-semibold text-slate-700">Telepon</label>
                            <input id="anggota-telepon" name="kopang_telp" type="tel" value="{{ old('kopang_telp') }}" maxlength="255" autocomplete="tel" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
                        </div>
                        <div>
                            <label for="anggota-tipe" class="mb-1.5 block text-sm font-semibold text-slate-700">Kategori</label>
                            <select id="anggota-tipe" name="id_kopangtype" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
                                <option value="">Pilih kategori</option>
                                @foreach($koperasiTypes as $type)
                                    <option value="{{ $type->id_kopangtype }}" @selected((string) old('id_kopangtype') === (string) $type->id_kopangtype)>{{ $type->name_kopangtype }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="anggota-usaha" class="mb-1.5 block text-sm font-semibold text-slate-700">Nama usaha <span class="font-normal text-slate-400">(opsional)</span></label>
                        <input id="anggota-usaha" name="kopang_usaha" type="text" value="{{ old('kopang_usaha') }}" maxlength="255" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
                    </div>

                    <div>
                        <label for="anggota-alamat" class="mb-1.5 block text-sm font-semibold text-slate-700">Alamat <span class="font-normal text-slate-400">(opsional)</span></label>
                        <textarea id="anggota-alamat" name="kopang_addr" rows="2" maxlength="255" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">{{ old('kopang_addr') }}</textarea>
                    </div>

                    <button type="submit" class="mt-1 inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-xl bg-rose-700 px-4 py-3 text-sm font-bold text-white transition hover:bg-rose-800 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:ring-offset-2">
                        <i class="fa-solid fa-user-plus"></i>
                        Simpan anggota
                    </button>
                </form>

                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="flex items-center justify-between gap-3 border-b border-slate-100 px-4 py-4 sm:px-5">
                        <div>
                            <h3 class="font-extrabold text-slate-900">Anggota terbaru</h3>
                            <p class="mt-0.5 text-xs text-slate-500">Total anggota mengikuti data koperasi; daftar ini berisi anggota perorangan yang tercatat. NIK tidak ditampilkan.</p>
                        </div>
                        <i class="fa-solid fa-users text-xl text-rose-600"></i>
                    </div>
                    <div class="overflow-x-auto focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-[-2px] focus-visible:outline-rose-500" role="region" aria-label="Daftar anggota; geser secara horizontal untuk melihat semua kolom" tabindex="0">
                        <table class="w-full min-w-[520px] table-fixed text-left text-sm">
                            <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                                <tr>
                                    <th scope="col" class="w-[34%] px-5 py-3 font-bold">Nama</th>
                                    <th scope="col" class="w-[40%] px-5 py-3 font-bold">Koperasi</th>
                                    <th scope="col" class="w-[26%] px-5 py-3 font-bold">Kategori</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($anggotaRecords as $anggota)
                                    <tr>
                                        <td class="px-5 py-3.5">
                                            <p class="break-words font-bold text-slate-800">{{ $anggota->name_kopang }}</p>
                                            <p class="mt-0.5 break-words text-xs text-slate-500">{{ $anggota->kopang_telp ?: 'Telepon belum dicatat' }}</p>
                                        </td>
                                        <td class="break-words px-5 py-3.5 text-slate-600">{{ $anggota->koperasi?->name_koperasi ?? 'Koperasi tidak tersedia' }}</td>
                                        <td class="break-words px-5 py-3.5 text-slate-600">{{ $anggota->type?->name_kopangtype ?? 'Belum dikategorikan' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-5 py-5">
                                            <div class="flex min-h-48 flex-col items-center justify-center text-center text-sm text-slate-500">
                                                <i class="fa-regular fa-address-card mb-2 text-2xl text-slate-300" aria-hidden="true"></i>
                                                <p>Belum ada data anggota perorangan.</p>
                                                <p class="mt-1 text-xs text-slate-400">Tambahkan anggota melalui formulir.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($anggotaRecords->hasPages())
                        <div class="border-t border-slate-100 px-5 py-3">{{ $anggotaRecords->links() }}</div>
                    @endif
                </div>
            </div>
        </section>

        <section id="pengurus" aria-labelledby="pengurus-heading" class="scroll-mt-6">
            <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.16em] text-rose-700">Struktur organisasi</p>
                    <h2 id="pengurus-heading" class="text-2xl font-black tracking-tight text-slate-900">Pengurus koperasi</h2>
                </div>
                <span class="rounded-full bg-sky-50 px-3 py-1 text-sm font-bold text-sky-700">{{ number_format($statsPengurus['total'] ?? 0) }} pengurus</span>
            </div>

            <details class="mb-5 rounded-2xl border border-slate-200 bg-white shadow-sm">
                <summary class="flex cursor-pointer list-none items-center justify-between gap-3 rounded-2xl px-4 py-4 transition hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-rose-400 sm:px-5">
                    <span>
                        <span class="block font-extrabold text-slate-900">Tambah pengurus</span>
                        <span class="mt-1 block text-sm text-slate-500">Tambahkan pengurus atau pengawas koperasi.</span>
                    </span>
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-700">
                        <i class="fa-solid fa-user-plus"></i>
                    </span>
                </summary>
                <form action="{{ route('admin.pengurus.store') }}" method="POST" class="grid gap-4 border-t border-slate-100 p-4 sm:grid-cols-2 sm:p-5">
                    @csrf
                    <div class="sm:col-span-2">
                        <label for="pengurus-koperasi" class="mb-1.5 block text-sm font-semibold text-slate-700">Koperasi</label>
                        <select id="pengurus-koperasi" name="id_koperasi" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
                            <option value="">Pilih koperasi</option>
                            @foreach($allKoperasis as $koperasi)
                                <option value="{{ $koperasi->id_koperasi }}" @selected((string) old('id_koperasi') === (string) $koperasi->id_koperasi)>{{ $koperasi->name_koperasi }}</option>
                            @endforeach
                        </select>
                        @error('id_koperasi')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="pengurus-nama" class="mb-1.5 block text-sm font-semibold text-slate-700">Nama lengkap</label>
                        <input id="pengurus-nama" name="name_kopsdm" type="text" value="{{ old('name_kopsdm') }}" maxlength="255" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
                        @error('name_kopsdm')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="pengurus-jabatan" class="mb-1.5 block text-sm font-semibold text-slate-700">Jabatan</label>
                        <select id="pengurus-jabatan" name="jab_kopsdm" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
                            <option value="KETUA KOPERASI">Ketua koperasi</option>
                            <option value="WAKIL KETUA KOPERASI">Wakil ketua koperasi</option>
                            <option value="SEKRETARIS KOPERASI">Sekretaris koperasi</option>
                            <option value="BENDAHARA KOPERASI">Bendahara koperasi</option>
                            <option value="KETUA PENGAWAS">Ketua pengawas</option>
                            <option value="ANGGOTA PENGAWAS">Anggota pengawas</option>
                        </select>
                    </div>
                    <div>
                        <label for="pengurus-kategori" class="mb-1.5 block text-sm font-semibold text-slate-700">Kategori</label>
                        <select id="pengurus-kategori" name="type_kopsdm" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
                            <option value="PENGURUS">Pengurus</option>
                            <option value="PENGAWAS">Pengawas</option>
                        </select>
                    </div>
                    <div>
                        <label for="pengurus-urutan" class="mb-1.5 block text-sm font-semibold text-slate-700">Urutan struktur</label>
                        <input id="pengurus-urutan" name="order_kopsdm" type="text" value="{{ old('order_kopsdm', '1') }}" maxlength="10" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="pengurus-keterangan" class="mb-1.5 block text-sm font-semibold text-slate-700">Keterangan <span class="font-normal text-slate-400">(opsional)</span></label>
                        <input id="pengurus-keterangan" name="comt_kopsdm" type="text" value="{{ old('comt_kopsdm') }}" maxlength="255" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
                    </div>
                    @error('jab_kopsdm')<p class="text-xs text-rose-600">{{ $message }}</p>@enderror
                    @error('type_kopsdm')<p class="text-xs text-rose-600">{{ $message }}</p>@enderror
                    <button type="submit" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-rose-700 px-4 py-3 text-sm font-bold text-white transition hover:bg-rose-800 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:ring-offset-2 sm:col-span-2 sm:justify-self-start sm:px-6">
                        <i class="fa-solid fa-user-plus"></i>
                        Simpan pengurus
                    </button>
                </form>
            </details>

            <div class="grid gap-3 sm:grid-cols-2 sm:gap-4 lg:grid-cols-3">
                @forelse($penguruses as $pengurus)
                    <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:border-slate-300 hover:shadow-md">
                        <div class="flex min-w-0 items-center gap-4 p-4 sm:p-5">
                            @if(filled($pengurus->foto_kopsdm))
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($pengurus->foto_kopsdm) }}" alt="Foto {{ $pengurus->name_kopsdm }}" class="h-20 w-20 shrink-0 rounded-2xl object-cover">
                            @else
                                <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-2xl bg-slate-100 text-3xl text-slate-400">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <h3 class="break-words font-extrabold leading-snug text-slate-900">{{ $pengurus->name_kopsdm }}</h3>
                                <p class="mt-1 break-words text-sm font-semibold leading-snug text-rose-700">{{ $pengurus->jab_kopsdm }}</p>
                                <p class="mt-2 break-words text-xs leading-relaxed text-slate-500">{{ $pengurus->koperasi?->name_koperasi ?? 'Koperasi tidak tersedia' }}</p>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center text-sm text-slate-500 sm:col-span-2 lg:col-span-3">
                        Belum ada data pengurus pada wilayah ini.
                    </div>
                @endforelse
            </div>

            @if($penguruses->hasPages())
                <div class="mt-4">{{ $penguruses->links() }}</div>
            @endif
        </section>

        <section id="foto-pengurus" aria-labelledby="foto-pengurus-heading" class="scroll-mt-6">
            <div class="mb-4">
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-rose-700">Kelengkapan profil</p>
                <h2 id="foto-pengurus-heading" class="text-2xl font-black tracking-tight text-slate-900">Unggah foto pengurus</h2>
                <p class="mt-1 text-sm text-slate-500">Pilih pengurus yang fotonya ingin ditambahkan atau diperbarui.</p>
            </div>
            @if($pengurusFotoOptions->isNotEmpty())
                <form action="{{ route('admin.pengurus.foto.operator') }}" method="POST" enctype="multipart/form-data" class="grid gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:grid-cols-2 sm:p-5">
                    @csrf
                    <div>
                        <label for="pengurus-foto-id" class="mb-1.5 block text-sm font-semibold text-slate-700">Pilih pengurus</label>
                        <select id="pengurus-foto-id" name="id_kopsdm" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
                            <option value="">Pilih pengurus</option>
                            @foreach($pengurusFotoOptions as $pengurus)
                                <option value="{{ $pengurus->id_kopsdm }}" @selected(old('id_kopsdm') == $pengurus->id_kopsdm)>
                                    {{ $pengurus->name_kopsdm }} — {{ $pengurus->jab_kopsdm }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kopsdm')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>
                    <label for="pengurus-foto-file" class="block text-sm font-semibold text-slate-700">
                        Foto (JPG, PNG, atau WebP; maks. 5 MB)
                        <input id="pengurus-foto-file" type="file" name="foto" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" required class="mt-1.5 block w-full rounded-lg border border-slate-200 bg-white p-2 text-xs text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:font-bold file:text-slate-700 hover:file:bg-slate-200 focus:outline-none focus:ring-2 focus:ring-rose-400">
                        <span id="pengurus-foto-name" class="mt-2 block break-all text-xs font-normal text-slate-500" aria-live="polite">Belum ada file dipilih</span>
                        <span id="pengurus-foto-preview" class="mt-3 hidden items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <img id="pengurus-foto-preview-image" alt="Pratinjau foto yang dipilih" class="h-20 w-20 shrink-0 rounded-lg object-cover">
                            <span class="text-xs font-medium text-slate-600">Pratinjau foto</span>
                        </span>
                        @error('foto')<span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>@enderror
                    </label>
                    <button type="submit" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-rose-700 px-4 py-3 text-sm font-bold text-white transition hover:bg-rose-800 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:ring-offset-2 sm:col-span-2 sm:justify-self-start sm:px-6">
                        <i class="fa-solid fa-upload"></i>
                        Unggah foto
                    </button>
                </form>
            @else
                <div class="rounded-2xl border border-dashed border-emerald-200 bg-emerald-50 p-8 text-center text-sm font-semibold text-emerald-800">
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
        })();
    </script>
@endpush
