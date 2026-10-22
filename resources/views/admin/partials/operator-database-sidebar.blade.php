<aside data-operator-database-sidebar aria-label="Navigasi database koperasi" class="min-w-0">
    <div class="rounded-2xl border border-slate-200 bg-white p-3 shadow-xs lg:sticky lg:top-6">
        @if(in_array(request()->query('page'), ['database-anggota', 'database-pengurus'], true))
            <a href="{{ route('admin.dashboard') }}" class="mb-2 flex min-h-11 items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-bold text-slate-700 transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-rose-300">
                <i class="fa-solid fa-arrow-left w-5 text-center text-slate-500" aria-hidden="true"></i>
                <span>Kembali ke dashboard</span>
            </a>
        @endif
        <p class="px-3 pb-2 pt-1 text-xs font-bold uppercase tracking-[0.14em] text-slate-500">Pengelolaan data</p>
        <nav class="grid gap-1.5 sm:grid-cols-2 lg:grid-cols-1" aria-label="Database koperasi">
            <a href="{{ route('admin.dashboard', ['page' => 'database-pengurus']) }}" @if(request()->query('page') === 'database-pengurus') aria-current="page" @endif class="flex min-h-11 items-center gap-3 rounded-xl border px-3 py-2.5 text-sm font-bold transition focus:outline-none focus:ring-2 focus:ring-rose-300 {{ request()->query('page') === 'database-pengurus' ? 'border-rose-200 bg-rose-50 text-rose-800' : 'border-transparent text-slate-700 hover:border-rose-100 hover:bg-rose-50 hover:text-rose-800' }}">
                <i class="fa-solid fa-people-group w-5 text-center text-rose-700" aria-hidden="true"></i>
                <span class="min-w-0 flex-1">Database Pengurus</span>
                <span class="rounded-full bg-white/80 px-2 py-0.5 text-xs font-bold text-slate-600">{{ number_format($totalPengurusKoperasi + $totalPengawasKoperasi) }}</span>
            </a>
            <a href="{{ route('admin.dashboard', ['page' => 'database-anggota']) }}" @if(request()->query('page') === 'database-anggota') aria-current="page" @endif class="flex min-h-11 items-center gap-3 rounded-xl border px-3 py-2.5 text-sm font-bold transition focus:outline-none focus:ring-2 focus:ring-rose-300 {{ request()->query('page') === 'database-anggota' ? 'border-rose-200 bg-rose-50 text-rose-800' : 'border-transparent text-slate-700 hover:border-rose-100 hover:bg-rose-50 hover:text-rose-800' }}">
                <i class="fa-solid fa-users w-5 text-center text-rose-700" aria-hidden="true"></i>
                <span class="min-w-0 flex-1">Database Anggota</span>
                <span class="rounded-full bg-white/80 px-2 py-0.5 text-xs font-bold text-slate-600">{{ number_format($totalAnggota) }}</span>
            </a>
        </nav>
    </div>
</aside>
