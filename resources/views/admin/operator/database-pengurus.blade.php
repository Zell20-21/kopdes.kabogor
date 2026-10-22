<div class="flex min-w-0 flex-col gap-6">
    <header class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-rose-700">Struktur Organisasi</p>
            <h1 class="mt-1 text-2xl font-black tracking-tight text-slate-900 sm:text-3xl">Pengurus dan Pengawas Koperasi</h1>
            <p class="mt-1 max-w-2xl text-sm text-slate-500">Kelola data struktur organisasi koperasi di desa atau kelurahan Anda.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <span class="inline-flex items-center gap-2 rounded-full border border-sky-200 bg-sky-50 px-3.5 py-2 text-sm font-bold text-sky-800">
                <i class="fa-solid fa-user-tie" aria-hidden="true"></i>{{ number_format($totalPengurusKoperasi) }} pengurus
            </span>
            <span class="inline-flex items-center gap-2 rounded-full border border-amber-200 bg-amber-50 px-3.5 py-2 text-sm font-bold text-amber-800">
                <i class="fa-solid fa-user-shield" aria-hidden="true"></i>{{ number_format($totalPengawasKoperasi) }} pengawas
            </span>
        </div>
    </header>

    <details class="group overflow-hidden rounded-3xl border border-slate-200/90 bg-white shadow-xs" @if($errors->any()) open @endif>
        <summary class="flex cursor-pointer list-none items-center justify-between gap-3 p-5 transition hover:bg-slate-50 sm:px-6">
            <span class="flex items-center gap-3.5">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-700"><i class="fa-solid fa-user-plus" aria-hidden="true"></i></span>
                <span>
                    <span class="block font-black text-slate-900">Tambah Pengurus</span>
                    <span class="mt-0.5 block text-xs text-slate-500">Tambahkan pengurus atau pengawas koperasi.</span>
                </span>
            </span>
            <i class="fa-solid fa-chevron-down text-xs text-slate-500 transition group-open:rotate-180" aria-hidden="true"></i>
        </summary>
        <form action="{{ route('admin.pengurus.store') }}" method="POST" class="grid gap-4 border-t border-slate-100 bg-slate-50/40 p-5 sm:grid-cols-2 sm:p-6">
            @csrf
            <div class="sm:col-span-2">
                <label for="pengurus-koperasi" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600">Koperasi <span class="text-rose-600">*</span></label>
                <select id="pengurus-koperasi" name="id_koperasi" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
                    <option value="">Pilih koperasi</option>
                    @foreach($allKoperasis as $koperasi)
                        <option value="{{ $koperasi->id_koperasi }}" @selected((string) old('id_koperasi') === (string) $koperasi->id_koperasi)>{{ $koperasi->name_koperasi }}</option>
                    @endforeach
                </select>
                @error('id_koperasi')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="pengurus-nama" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600">Nama lengkap <span class="text-rose-600">*</span></label>
                <input id="pengurus-nama" name="name_kopsdm" type="text" placeholder="Masukkan nama lengkap" value="{{ old('name_kopsdm') }}" maxlength="255" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
                @error('name_kopsdm')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="pengurus-jabatan" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600">Jabatan <span class="text-rose-600">*</span></label>
                <select id="pengurus-jabatan" name="jab_kopsdm" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
                    <option value="KETUA KOPERASI" @selected(old('jab_kopsdm') === 'KETUA KOPERASI')>Ketua koperasi</option>
                    <option value="WAKIL KETUA KOPERASI" @selected(old('jab_kopsdm') === 'WAKIL KETUA KOPERASI')>Wakil ketua koperasi</option>
                    <option value="SEKRETARIS KOPERASI" @selected(old('jab_kopsdm') === 'SEKRETARIS KOPERASI')>Sekretaris koperasi</option>
                    <option value="BENDAHARA KOPERASI" @selected(old('jab_kopsdm') === 'BENDAHARA KOPERASI')>Bendahara koperasi</option>
                    <option value="KETUA PENGAWAS" @selected(old('jab_kopsdm') === 'KETUA PENGAWAS')>Ketua pengawas</option>
                    <option value="ANGGOTA PENGAWAS" @selected(old('jab_kopsdm') === 'ANGGOTA PENGAWAS')>Anggota pengawas</option>
                </select>
                @error('jab_kopsdm')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="pengurus-kategori" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600">Kategori struktur <span class="text-rose-600">*</span></label>
                <select id="pengurus-kategori" name="type_kopsdm" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
                    <option value="PENGURUS" @selected(old('type_kopsdm', 'PENGURUS') === 'PENGURUS')>Pengurus</option>
                    <option value="PENGAWAS" @selected(old('type_kopsdm') === 'PENGAWAS')>Pengawas</option>
                </select>
                @error('type_kopsdm')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="pengurus-urutan" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600">Urutan struktur</label>
                <input id="pengurus-urutan" name="order_kopsdm" type="text" value="{{ old('order_kopsdm', '1') }}" maxlength="10" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
            </div>
            <div class="sm:col-span-2">
                <label for="pengurus-keterangan" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600">Keterangan <span class="font-normal lowercase text-slate-400">(opsional)</span></label>
                <input id="pengurus-keterangan" name="comt_kopsdm" type="text" placeholder="Keterangan tambahan" value="{{ old('comt_kopsdm') }}" maxlength="255" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
            </div>
            <div class="sm:col-span-2">
                <button type="submit" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-rose-700 px-6 py-2.5 text-sm font-bold text-white shadow-xs transition hover:bg-rose-800 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:ring-offset-2">
                    <i class="fa-solid fa-user-plus" aria-hidden="true"></i>
                    Simpan Pengurus
                </button>
            </div>
        </form>
    </details>

    @foreach([
        ['label' => 'Pengurus', 'records' => $operatorPengurus, 'empty' => 'Belum ada data pengurus yang tercatat.'],
        ['label' => 'Pengawas', 'records' => $operatorPengawas, 'empty' => 'Belum ada data pengawas yang tercatat.'],
    ] as $group)
        <section aria-label="Daftar {{ strtolower($group['label']) }}" class="flex flex-col gap-3">
            <div class="flex items-center justify-between gap-3">
                <h2 class="text-lg font-black text-slate-900">{{ $group['label'] }}</h2>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">{{ $group['records']->count() }} data</span>
            </div>
            <div class="grid min-w-0 gap-4 sm:grid-cols-2 2xl:grid-cols-3">
                @forelse($group['records'] as $pengurus)
                    <article class="min-w-0 rounded-2xl border border-slate-200/90 bg-white p-4 shadow-2xs sm:p-5">
                        <div class="flex items-start gap-3.5">
                            @if(filled($pengurus->foto_kopsdm))
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($pengurus->foto_kopsdm) }}" alt="Foto {{ $pengurus->name_kopsdm }}" class="h-16 w-16 shrink-0 rounded-2xl border border-slate-200 object-cover">
                            @else
                                <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl border border-slate-200 bg-slate-100 text-2xl text-slate-400"><i class="fa-solid fa-user" aria-hidden="true"></i></span>
                            @endif
                            <div class="min-w-0 flex-1">
                                <h3 class="break-words text-sm font-black leading-snug text-slate-900 sm:text-base">{{ $pengurus->name_kopsdm }}</h3>
                                <span class="mt-1 inline-block rounded-md border border-rose-100 bg-rose-50 px-2.5 py-0.5 text-[11px] font-bold text-rose-700">{{ $pengurus->jab_kopsdm }}</span>
                                <p class="mt-1.5 break-words text-xs leading-snug text-slate-500">{{ $pengurus->koperasi?->name_koperasi ?? 'Koperasi tidak tersedia' }}</p>
                                <button type="button" onclick="selectPengurusForPhoto({{ $pengurus->id_kopsdm }})" class="mt-2.5 inline-flex min-h-8 items-center gap-1.5 text-xs font-bold text-rose-700 hover:text-rose-900 focus:outline-none focus:ring-2 focus:ring-rose-300">
                                    <i class="fa-solid fa-camera" aria-hidden="true"></i>
                                    {{ filled($pengurus->foto_kopsdm) ? 'Ganti foto' : 'Unggah foto' }}
                                </button>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-6 text-center text-sm text-slate-500 sm:col-span-2 2xl:col-span-3">{{ $group['empty'] }}</div>
                @endforelse
            </div>
        </section>
    @endforeach

    <section id="foto-pengurus" aria-labelledby="foto-pengurus-heading" class="scroll-mt-6">
        <div class="mb-3">
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-rose-700">Kelengkapan Profil</p>
            <h2 id="foto-pengurus-heading" class="text-lg font-black text-slate-900">Foto pengurus</h2>
            <p class="mt-1 text-sm text-slate-500">Pilih pengurus dan unggah foto JPG, PNG, atau WebP maksimal 5 MB.</p>
        </div>
        @if($pengurusFotoOptions->isNotEmpty())
            <form action="{{ route('admin.pengurus.foto.operator') }}" method="POST" enctype="multipart/form-data" class="grid gap-5 rounded-3xl border border-slate-200 bg-white p-5 shadow-xs md:grid-cols-2 sm:p-6">
                @csrf
                <div class="flex flex-col gap-4">
                    <div>
                        <label for="pengurus-foto-id" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600">Pilih pengurus</label>
                        <select id="pengurus-foto-id" name="id_kopsdm" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
                            <option value="">Pilih pengurus</option>
                            @foreach($pengurusFotoOptions as $pengurus)
                                <option value="{{ $pengurus->id_kopsdm }}" @selected(old('id_kopsdm') == $pengurus->id_kopsdm)>{{ $pengurus->name_kopsdm }} — {{ $pengurus->jab_kopsdm }}</option>
                            @endforeach
                        </select>
                        @error('id_kopsdm')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>
                    <div id="pengurus-foto-preview" class="hidden items-center gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-3.5">
                        <img id="pengurus-foto-preview-image" alt="Pratinjau foto yang dipilih" class="h-20 w-20 shrink-0 rounded-xl object-cover">
                        <p class="text-xs text-slate-500">Foto akan tersimpan setelah diunggah.</p>
                    </div>
                </div>
                <div class="flex flex-col justify-between gap-4">
                    <div>
                        <label for="pengurus-foto-file" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600">Pilih foto</label>
                        <input id="pengurus-foto-file" type="file" name="foto" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" required class="block w-full rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-4 text-xs text-slate-600 file:mr-3 file:rounded-xl file:border-0 file:bg-rose-50 file:px-3.5 file:py-2 file:font-bold file:text-rose-700">
                        <span id="pengurus-foto-name" class="mt-2 block break-all text-xs text-slate-500" aria-live="polite">Belum ada file dipilih</span>
                        @error('foto')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-rose-700 px-6 py-2.5 text-sm font-bold text-white shadow-xs transition hover:bg-rose-800 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:ring-offset-2">
                        <i class="fa-solid fa-upload" aria-hidden="true"></i>
                        Unggah foto
                    </button>
                </div>
            </form>
        @else
            <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-6 text-center text-sm text-slate-500">Belum ada data pengurus yang dapat dipilih.</div>
        @endif
    </section>
</div>
