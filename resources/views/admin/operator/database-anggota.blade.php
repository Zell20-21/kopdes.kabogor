<div class="flex min-w-0 flex-col gap-6">
    <header class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-rose-700">Keanggotaan</p>
            <h1 class="mt-1 text-2xl font-black tracking-tight text-slate-900 sm:text-3xl">Data Anggota Koperasi</h1>
            <p class="mt-1 max-w-2xl text-sm text-slate-500">Kelola dan daftarkan anggota perorangan koperasi di desa atau kelurahan Anda.</p>
        </div>
        <span class="inline-flex w-fit items-center gap-2 rounded-full border border-rose-200 bg-rose-50 px-4 py-2 text-sm font-bold text-rose-800">
            <i class="fa-solid fa-users text-rose-600" aria-hidden="true"></i>
            {{ number_format($totalAnggota) }} anggota tercatat
        </span>
    </header>

    <div class="grid min-w-0 items-start gap-5 xl:grid-cols-[minmax(19rem,0.8fr)_minmax(0,1.2fr)]">
        <form action="{{ route('admin.anggota.store') }}" method="POST" class="flex min-w-0 flex-col gap-4 rounded-3xl border border-slate-200/90 bg-white p-5 shadow-xs sm:p-6">
            @csrf
            <div class="flex items-center gap-3 border-b border-slate-100 pb-3">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-700">
                    <i class="fa-solid fa-user-plus" aria-hidden="true"></i>
                </span>
                <div>
                    <h2 class="text-base font-extrabold leading-tight text-slate-900">Tambah Anggota</h2>
                    <p class="text-xs text-slate-500">Kolom bertanda <span class="text-rose-600">*</span> wajib diisi.</p>
                </div>
            </div>

            <div>
                <label for="anggota-koperasi" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600">Koperasi <span class="text-rose-600">*</span></label>
                <select id="anggota-koperasi" name="id_koperasi" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
                    <option value="">Pilih koperasi</option>
                    @foreach($allKoperasis as $koperasi)
                        <option value="{{ $koperasi->id_koperasi }}" @selected((string) old('id_koperasi') === (string) $koperasi->id_koperasi)>{{ $koperasi->name_koperasi }}</option>
                    @endforeach
                </select>
                @error('id_koperasi')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="anggota-nama" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600">Nama lengkap <span class="text-rose-600">*</span></label>
                <input id="anggota-nama" name="name_kopang" type="text" placeholder="Masukkan nama lengkap anggota" value="{{ old('name_kopang') }}" required maxlength="255" autocomplete="name" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
                @error('name_kopang')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="anggota-tipe" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600">Kategori anggota <span class="text-rose-600">*</span></label>
                <select id="anggota-tipe" name="id_kopangtype" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
                    <option value="">Pilih kategori</option>
                    @foreach($koperasiTypes as $type)
                        <option value="{{ $type->id_kopangtype }}" @selected((string) old('id_kopangtype') === (string) $type->id_kopangtype)>{{ $type->name_kopangtype }}</option>
                    @endforeach
                </select>
                @error('id_kopangtype')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="anggota-usaha" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600">Nama usaha <span class="font-normal lowercase text-slate-400">(opsional)</span></label>
                <input id="anggota-usaha" name="kopang_usaha" type="text" placeholder="Nama usaha anggota (jika ada)" value="{{ old('kopang_usaha') }}" maxlength="255" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
                @error('kopang_usaha')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="mt-1 inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-xl bg-rose-700 px-4 py-3 text-sm font-bold text-white shadow-xs transition hover:bg-rose-800 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:ring-offset-2">
                <i class="fa-solid fa-user-plus" aria-hidden="true"></i>
                Simpan Anggota
            </button>
        </form>

        <section aria-labelledby="anggota-list-heading" class="min-w-0 overflow-hidden rounded-3xl border border-slate-200/90 bg-white shadow-xs">
            <div class="flex items-center justify-between gap-3 border-b border-slate-100 px-5 py-4">
                <div>
                    <h2 id="anggota-list-heading" class="text-base font-black text-slate-900">Daftar anggota</h2>
                    <p class="mt-0.5 text-xs text-slate-500">Anggota yang tercatat pada koperasi dalam wilayah Anda.</p>
                </div>
                <i class="fa-solid fa-users text-xl text-rose-700" aria-hidden="true"></i>
            </div>

            @if($anggotaRecords->isEmpty())
                <div class="flex min-h-56 flex-col items-center justify-center px-5 py-8 text-center">
                    <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-2xl text-slate-400"><i class="fa-regular fa-address-card" aria-hidden="true"></i></span>
                    <p class="mt-3 font-bold text-slate-800">Belum ada data anggota perorangan.</p>
                    <p class="mt-1 max-w-sm text-sm text-slate-500">Tambahkan anggota melalui formulir ini. Data akan tampil setelah berhasil disimpan.</p>
                </div>
            @else
                <div class="overflow-x-auto" role="region" aria-label="Daftar anggota koperasi" tabindex="0">
                    <table class="w-full min-w-[460px] table-fixed text-left text-sm">
                        <thead class="border-b border-slate-100 bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                            <tr>
                                <th scope="col" class="w-[38%] px-5 py-3 font-bold">Nama</th>
                                <th scope="col" class="w-[37%] px-5 py-3 font-bold">Koperasi</th>
                                <th scope="col" class="w-[25%] px-5 py-3 font-bold">Kategori</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($anggotaRecords as $anggota)
                                <tr class="hover:bg-rose-50/30">
                                    <td class="break-words px-5 py-3.5 font-semibold text-slate-800">{{ $anggota->name_kopang }}</td>
                                    <td class="break-words px-5 py-3.5 text-xs text-slate-600">{{ $anggota->koperasi?->name_koperasi ?? 'Koperasi tidak tersedia' }}</td>
                                    <td class="break-words px-5 py-3.5">
                                        <span class="inline-block rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700">{{ $anggota->type?->name_kopangtype ?? 'Belum dikategorikan' }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($anggotaRecords->hasPages())
                    <div class="border-t border-slate-100 bg-slate-50/50 px-5 py-3">{{ $anggotaRecords->links() }}</div>
                @endif
            @endif
        </section>
    </div>
</div>
