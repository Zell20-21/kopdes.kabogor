<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Kopang;
use App\Models\KopangType;
use App\Models\Koperasi;
use App\Models\Kopsdm;
use App\Models\LampiranInformasi;
use App\Models\User;
use App\Support\CsvSanitizer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display the Admin KMP Kabupaten Bogor dashboard.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        abort_unless(
            $user->isSuperAdmin() || $user->isOperatorDesa() || $user->isOperatorKecamatan(),
            403
        );

        $isOperator = $user->isOperatorDesa() || $user->isOperatorKecamatan();
        $activeTab = $request->get('tab', 'informasi');
        if ($user->isOperatorKecamatan() && $activeTab === 'lampiran') {
            $activeTab = 'informasi';
        }

        $baseQuery = $this->visibleKoperasiQuery($user);

        // Allow Superadmin to filter scope if selected via dropdown
        if ($user->isSuperAdmin() && $filterKec = $request->get('filter_kec')) {
            $baseQuery->where('id_kec', $filterKec);
        }

        // Aggregated statistics for Informasi Koperasi (GovTech KOP)
        $totalKoperasi = (clone $baseQuery)->count();
        $totalAnggota = (clone $baseQuery)->sum('jum_anggota');
        $simpananTotals = (clone $baseQuery)
            ->selectRaw(
                'COALESCE(SUM(jum_sim_pokok), 0) as total_simpanan_pokok, COALESCE(SUM(jum_sim_wajib), 0) as total_simpanan_wajib'
            )
            ->first();
        $totalSimpananPokok = (int) $simpananTotals->total_simpanan_pokok;
        $totalSimpananWajib = (int) $simpananTotals->total_simpanan_wajib;

        $opsSudah = (clone $baseQuery)->where('st_ops', 'SUDAH')->count();
        $opsBelum = (clone $baseQuery)->where('st_ops', 'BELUM')->count();
        $opsSudahPersen = $totalKoperasi > 0 ? round(($opsSudah / $totalKoperasi) * 100, 2) : 0;
        $opsBelumPersen = $totalKoperasi > 0 ? round(($opsBelum / $totalKoperasi) * 100, 2) : 0;

        $latihSudah = (clone $baseQuery)->where('st_latih', 'SUDAH')->count();
        $latihSebagian = (clone $baseQuery)->where('st_latih', 'SEBAGIAN')->count();
        $latihBelum = (clone $baseQuery)->where('st_latih', 'BELUM')->count();
        $latihSudahPersen = $totalKoperasi > 0 ? round(($latihSudah / $totalKoperasi) * 100, 2) : 0;
        $latihSebagianPersen = $totalKoperasi > 0 ? round(($latihSebagian / $totalKoperasi) * 100, 2) : 0;
        $latihBelumPersen = $totalKoperasi > 0 ? round(($latihBelum / $totalKoperasi) * 100, 2) : 0;

        $sertifikatSudah = (clone $baseQuery)->where('st_sertifikat', 'SUDAH')->count();
        $sertifikatBelum = (clone $baseQuery)->where('st_sertifikat', 'BELUM')->count();
        $sertifikatSudahPersen = $totalKoperasi > 0 ? round(($sertifikatSudah / $totalKoperasi) * 100, 2) : 0;
        $sertifikatBelumPersen = $totalKoperasi > 0 ? round(($sertifikatBelum / $totalKoperasi) * 100, 2) : 0;

        $koperasiTypes = KopangType::where('flag_del', 0)
            ->orderBy('name_kopangtype')
            ->get();
        $anggotaTypeCounts = Kopang::query()
            ->where('flag_del', 0)
            ->whereIn('id_koperasi', (clone $baseQuery)->select('id_koperasi'))
            ->selectRaw('id_kopangtype, COUNT(*) as jumlah')
            ->groupBy('id_kopangtype')
            ->pluck('jumlah', 'id_kopangtype');
        $klasifikasiAnggota = $koperasiTypes
            ->map(fn (KopangType $type): array => [
                'nama' => $type->name_kopangtype,
                'jumlah' => (int) ($anggotaTypeCounts[$type->id_kopangtype] ?? 0),
                'accent' => match (mb_strtolower($type->name_kopangtype)) {
                    'pengrajin umkm' => 'border-l-4 border-rose-500 pl-2',
                    'petani' => 'border-l-4 border-emerald-500 pl-2',
                    'lainnya' => 'border-l-4 border-amber-500 pl-2',
                    default => '',
                },
            ])
            ->all();

        // Database Koperasi query with search & filter
        $query = (clone $baseQuery)->with(['kecamatan', 'kelurahan']);

        if ($filterKec = ($request->get('id_kec') ?: $request->get('filter_kec'))) {
            $query->where('id_kec', $filterKec);
        }
        if ($filterKel = $request->get('id_kel')) {
            $query->where('id_kel', $filterKel);
        }
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name_koperasi', 'like', "%{$search}%")
                    ->orWhere('no_ahu', 'like', "%{$search}%")
                    ->orWhere('no_inkop', 'like', "%{$search}%")
                    ->orWhereHas('kecamatan', function ($sub) use ($search) {
                        $sub->where('name_kopkec', 'like', "%{$search}%");
                    })
                    ->orWhereHas('kelurahan', function ($sub) use ($search) {
                        $sub->where('name_kopkel', 'like', "%{$search}%");
                    });
            });
        }
        if ($statusOps = $request->get('status_ops')) {
            $query->where('st_ops', $statusOps);
        }

        $perPage = max(5, min(100, (int) $request->get('per_page', 25)));
        $koperasis = $query->orderBy('id_koperasi', 'asc')->paginate($perPage)->withQueryString();

        // GIS map points for all active cooperatives
        $gisKoperasis = (clone $baseQuery)
            ->with(['kecamatan:id_kopkec,name_kopkec', 'kelurahan:id_kopkel,name_kopkel'])
            ->select([
                'id_koperasi',
                'name_koperasi',
                'id_kec',
                'id_kel',
                'no_ahu',
                'no_inkop',
                'tgl_ahu',
                'st_ops',
                'st_latih',
                'st_sertifikat',
                'gps_lat',
                'gps_long',
                'cat_koperasi',
            ])
            ->get();

        $anggotaRecords = Kopang::with(['koperasi.kecamatan', 'type'])
            ->where('flag_del', 0)
            ->whereIn('id_koperasi', (clone $baseQuery)->select('id_koperasi'))
            ->orderByDesc('id_kopang')
            ->paginate(8, ['*'], 'member_page')
            ->withQueryString();

        // Database Pengurus statistics & query
        $pengurusBaseQuery = Kopsdm::where('flag_del', 0)
            ->whereIn('id_koperasi', (clone $baseQuery)->select('id_koperasi'));

        $totalPengurusCount = (clone $pengurusBaseQuery)->count();
        $totalPengawasKoperasi = (clone $pengurusBaseQuery)
            ->where('type_kopsdm', 'PENGAWAS')
            ->count();
        $totalPengurusKoperasi = (clone $pengurusBaseQuery)
            ->where('type_kopsdm', 'PENGURUS')
            ->count();
        $ketuaCount = (clone $pengurusBaseQuery)->where('jab_kopsdm', 'like', '%KETUA KOPERASI%')->count();
        $sekretarisCount = (clone $pengurusBaseQuery)->where('jab_kopsdm', 'like', '%SEKRETARIS%')->where('jab_kopsdm', 'not like', '%WAKIL%')->count();
        $bendaharaCount = (clone $pengurusBaseQuery)->where('jab_kopsdm', 'like', '%BENDAHARA%')->where('jab_kopsdm', 'not like', '%WAKIL%')->count();
        $pengawasLainnyaCount = max(0, $totalPengurusCount - ($ketuaCount + $sekretarisCount + $bendaharaCount));

        $statsPengurus = [
            'total' => $totalPengurusCount,
            'ketua' => $ketuaCount,
            'sekretaris' => $sekretarisCount,
            'bendahara' => $bendaharaCount,
            'pengawas_lainnya' => $pengawasLainnyaCount,
        ];

        $pengurusQuery = Kopsdm::with(['koperasi.kecamatan', 'koperasi.kelurahan'])
            ->where('flag_del', 0)
            ->whereIn('id_koperasi', (clone $baseQuery)->select('id_koperasi'));

        $filterKecPengurus = $request->get('filter_kec_pengurus');
        $filterKelPengurus = $request->get('filter_kel_pengurus');
        $perPagePengurus = max(5, min(100, (int) $request->get('per_page_pengurus', 25)));

        if ($filterKecPengurus) {
            $pengurusQuery->whereHas('koperasi', fn ($q) => $q->where('id_kec', $filterKecPengurus));
        }
        if ($filterKelPengurus) {
            $pengurusQuery->whereHas('koperasi', fn ($q) => $q->where('id_kel', $filterKelPengurus));
        }

        if ($searchPengurus = $request->get('search_pengurus')) {
            $pengurusQuery->where(function ($query) use ($searchPengurus) {
                $query->where('name_kopsdm', 'like', "%{$searchPengurus}%")
                    ->orWhere('jab_kopsdm', 'like', "%{$searchPengurus}%")
                    ->orWhere('type_kopsdm', 'like', "%{$searchPengurus}%")
                    ->orWhere('comt_kopsdm', 'like', "%{$searchPengurus}%")
                    ->orWhereHas('koperasi', function ($kq) use ($searchPengurus) {
                        $kq->where('name_koperasi', 'like', "%{$searchPengurus}%")
                            ->orWhereHas('kecamatan', fn ($sub) => $sub->where('name_kopkec', 'like', "%{$searchPengurus}%"))
                            ->orWhereHas('kelurahan', fn ($sub) => $sub->where('name_kopkel', 'like', "%{$searchPengurus}%"));
                    });
            });
        }
        $penguruses = $pengurusQuery
            ->orderBy('id_koperasi', 'asc')
            ->orderBy('order_kopsdm', 'asc')
            ->orderBy('id_kopsdm', 'asc')
            ->paginate($perPagePengurus)
            ->withQueryString();
        $pengurusFotoOptions = $user->isOperatorDesa()
            ? Kopsdm::where('flag_del', 0)
                ->whereIn('id_koperasi', (clone $baseQuery)->select('id_koperasi'))
                ->orderBy('id_koperasi')
                ->orderBy('order_kopsdm')
                ->orderBy('id_kopsdm')
                ->get()
            : collect();
        $jenisUsahaOptions = [
            ['id' => 1, 'name' => 'GERAI SEMBAKO', 'icon' => 'fa-store'],
            ['id' => 2, 'name' => 'GERAI APOTEK DESA', 'icon' => 'fa-prescription-bottle-medical'],
            ['id' => 3, 'name' => 'GERAI KANTOR KOPERASI', 'icon' => 'fa-building-columns'],
            ['id' => 4, 'name' => 'GERAI UNIT USAHA SIMPAN PINJAM', 'icon' => 'fa-hand-holding-dollar'],
            ['id' => 5, 'name' => 'GERAI KLINIK DESA', 'icon' => 'fa-kit-medical'],
            ['id' => 6, 'name' => 'GERAI COLD STORAGE/COLD CHAIN', 'icon' => 'fa-snowflake'],
            ['id' => 7, 'name' => 'GERAI LOGISTIK (DISTRIBUSI)', 'icon' => 'fa-truck-ramp-box'],
            ['id' => 8, 'name' => 'GERAI USAHA LAINNYA (KBLI 2020)', 'icon' => 'fa-boxes-stacked'],
            ['id' => 9, 'name' => 'GERAI KIOS PUPUK', 'icon' => 'fa-seedling'],
            ['id' => 10, 'name' => 'GERAI PANGKALAN LPG', 'icon' => 'fa-fire-flame-simple'],
            ['id' => 11, 'name' => 'GERAI AGEN POS INDONESIA', 'icon' => 'fa-envelope-open-text'],
            ['id' => 12, 'name' => 'GERAI AGEN LAKU PANDAI', 'icon' => 'fa-wallet'],
            ['id' => 13, 'name' => 'AKUN MICROSITE', 'icon' => 'fa-globe'],
        ];
        $operatorKoperasiProfiles = $user->isOperatorDesa()
            ? (clone $baseQuery)
                ->with(['kecamatan', 'kelurahan'])
                ->orderBy('name_koperasi')
                ->get()
                ->map(function (Koperasi $koperasi) use ($jenisUsahaOptions): array {
                    $selectedUsahaIds = collect($jenisUsahaOptions)
                        ->filter(fn (array $usaha): bool => strtoupper((string) $koperasi->getAttribute('id_koperasitype'.$usaha['id'])) === 'YES')
                        ->pluck('id')
                        ->all();

                    return [
                        'koperasi' => $koperasi,
                        'selected_usaha_ids' => $selectedUsahaIds,
                    ];
                })
            : collect();
        $totalJenisUsaha = $operatorKoperasiProfiles->sum(
            fn (array $profile): int => count($profile['selected_usaha_ids'])
        );
        $operatorPengurus = $user->isOperatorDesa()
            ? (clone $pengurusBaseQuery)
                ->where('type_kopsdm', 'PENGURUS')
                ->with('koperasi')
                ->orderBy('id_koperasi')
                ->orderBy('order_kopsdm')
                ->orderBy('id_kopsdm')
                ->get()
            : collect();
        $operatorPengawas = $user->isOperatorDesa()
            ? (clone $pengurusBaseQuery)
                ->where('type_kopsdm', 'PENGAWAS')
                ->with('koperasi')
                ->orderBy('id_koperasi')
                ->orderBy('order_kopsdm')
                ->orderBy('id_kopsdm')
                ->get()
            : collect();
        $locationPhotoSelect = Schema::hasColumn('app_md_koperasi', 'foto_lokasi')
            ? ['id_koperasi', 'name_koperasi', 'foto_lokasi']
            : ['id_koperasi', 'name_koperasi'];

        $locationPhotoKoperasis = $user->isOperatorDesa()
            ? (clone $baseQuery)
                ->select($locationPhotoSelect)
                ->orderBy('name_koperasi')
                ->get()
            : collect();

        $anggotaQuery = (clone $baseQuery)->with(['kecamatan', 'kelurahan']);

        $filterKecAnggota = $request->get('filter_kec_anggota');
        $filterKelAnggota = $request->get('filter_kel_anggota');
        $perPageAnggota = max(5, min(100, (int) $request->get('per_page_anggota', 25)));

        if ($filterKecAnggota) {
            $anggotaQuery->where('id_kec', $filterKecAnggota);
        }
        if ($filterKelAnggota) {
            $anggotaQuery->where('id_kel', $filterKelAnggota);
        }
        if ($searchAnggota = $request->get('search_anggota')) {
            $anggotaQuery->where(function ($q) use ($searchAnggota) {
                $q->where('name_koperasi', 'like', "%{$searchAnggota}%")
                    ->orWhereHas('kecamatan', fn ($sub) => $sub->where('name_kopkec', 'like', "%{$searchAnggota}%"))
                    ->orWhereHas('kelurahan', fn ($sub) => $sub->where('name_kopkel', 'like', "%{$searchAnggota}%"));
            });
        }

        $anggotaKoperasis = $anggotaQuery
            ->orderBy('id_koperasi', 'asc')
            ->paginate($perPageAnggota, ['*'], 'anggota_page')
            ->withQueryString();

        $kecamatansQuery = Kecamatan::query()
            ->where('flag_del', 0)
            ->with(['kelurahans' => function ($query) use ($user) {
                $query->where('flag_del', 0);

                if ($user->isOperatorDesa()) {
                    $query->where('id_kopkel', $user->id_branch);
                }

                $query->orderBy('name_kopkel', 'asc');
            }]);

        if ($user->isOperatorKecamatan()) {
            if ($user->id_company > 0) {
                $kecamatansQuery->where('id_kopkec', $user->id_company);
            } else {
                $kecamatansQuery->whereRaw('1 = 0');
            }
        } elseif ($user->isOperatorDesa()) {
            if ($user->id_branch > 0) {
                $kecamatansQuery->whereHas('kelurahans', fn ($query) => $query->where('id_kopkel', $user->id_branch));
            } else {
                $kecamatansQuery->whereRaw('1 = 0');
            }
        }

        $kecamatans = $kecamatansQuery
            ->orderBy('id_kopkec', 'asc')
            ->get();
        $kecamatansData = $kecamatans->map(fn (Kecamatan $kecamatan): array => [
            'id_kopkec' => $kecamatan->id_kopkec,
            'id' => $kecamatan->id,
            'name_kopkec' => $kecamatan->name_kopkec,
            'nama' => $kecamatan->nama,
            'latitude' => $kecamatan->latitude,
            'longitude' => $kecamatan->longitude,
            'jumlah' => $kecamatan->jumlah,
            'kop_desa' => $kecamatan->kop_desa,
            'kop_kel' => $kecamatan->kop_kel,
            'kelurahans' => $kecamatan->kelurahans->map(fn ($kelurahan): array => [
                'id_kopkel' => $kelurahan->id_kopkel,
                'name_kopkel' => $kelurahan->name_kopkel,
            ])->all(),
        ])->all();
        $assignedKecamatanId = $user->isOperatorDesa()
            ? ($kecamatans->first()?->id_kopkec ?? '')
            : $user->id_company;

        $allKoperasis = (clone $baseQuery)
            ->select(['id_koperasi', 'name_koperasi', 'id_kec', 'id_kel', 'gps_lat', 'gps_long'])
            ->orderBy('name_koperasi', 'asc')
            ->get();

        $lampirans = new LengthAwarePaginator([], 0, 10);
        try {
            if (Schema::hasTable('app_lampiran_informasi')) {
                $lampirans = LampiranInformasi::orderBy('urutan', 'asc')
                    ->orderBy('id', 'desc')
                    ->paginate(10, ['*'], 'lampiran_page')
                    ->withQueryString();
            }
        } catch (\Throwable $e) {
            $lampirans = new LengthAwarePaginator([], 0, 10);
        }

        $rekapSubtab = $request->get('subtab', 'info');

        // Fetch kelurahans and kecamatans with scoping for rekapitulasi
        $rekapKelurahansQuery = Kelurahan::query()
            ->where('flag_del', 0)
            ->with(['kecamatan:id_kopkec,name_kopkec', 'koperasi' => function ($q) {
                $q->where('flag_del', 0)->select(['id_koperasi', 'id_kel', 'id_kec', 'name_koperasi', 'st_ops', 'st_latih', 'st_sertifikat', 'jum_anggota', 'no_ahu', 'no_inkop']);
            }]);

        $rekapKecamatansQuery = Kecamatan::query()
            ->where('flag_del', 0)
            ->with(['kelurahans' => fn ($query) => $query->where('flag_del', 0), 'koperasis' => function ($q) {
                $q->where('flag_del', 0)->select(['id_koperasi', 'id_kel', 'id_kec', 'name_koperasi', 'st_ops', 'st_latih', 'st_sertifikat', 'jum_anggota']);
            }]);

        if ($user->isOperatorKecamatan()) {
            if ($user->id_company > 0) {
                $rekapKelurahansQuery->where('id_kopkec', $user->id_company);
                $rekapKecamatansQuery->where('id_kopkec', $user->id_company);
            } else {
                $rekapKelurahansQuery->whereRaw('1 = 0');
                $rekapKecamatansQuery->whereRaw('1 = 0');
            }
        } elseif ($user->isOperatorDesa()) {
            if ($user->id_branch > 0) {
                $rekapKelurahansQuery->where('id_kopkel', $user->id_branch);
                $rekapKecamatansQuery->whereHas('kelurahans', fn ($q) => $q->where('id_kopkel', $user->id_branch));
            } else {
                $rekapKelurahansQuery->whereRaw('1 = 0');
                $rekapKecamatansQuery->whereRaw('1 = 0');
            }
        }

        $allKelurahans = $rekapKelurahansQuery->orderBy('name_kopkel', 'asc')->get();
        $rekapDesaData = $allKelurahans->map(function ($kel) {
            $kop = $kel->koperasi;
            $hasKop = $kop !== null;

            return [
                'id_kopkel' => $kel->id_kopkel,
                'nama_desa' => $kel->name_kopkel,
                'id_kopkec' => $kel->id_kopkec,
                'nama_kecamatan' => $kel->kecamatan?->name_kopkec ?? '-',
                'koperasi_nama' => $kop?->name_koperasi ?? '-',
                'no_ahu' => $kop?->no_ahu ?? '-',
                'no_inkop' => $kop?->no_inkop ?? '-',
                'jum_koperasi' => $hasKop ? 1 : 0,
                'sudah_ops' => ($hasKop && strtoupper((string) $kop->st_ops) === 'SUDAH') ? 1 : 0,
                'belum_ops' => ($hasKop && strtoupper((string) $kop->st_ops) !== 'SUDAH') ? 1 : 0,
                'sudah_sertifikat' => ($hasKop && strtoupper((string) $kop->st_sertifikat) === 'SUDAH') ? 1 : 0,
                'jum_anggota' => (int) ($kop?->jum_anggota ?? 0),
            ];
        });

        $rekapKecamatanData = $rekapKecamatansQuery->orderBy('name_kopkec', 'asc')->get()->map(function ($kec) {
            $kops = $kec->koperasis;

            return [
                'id_kopkec' => $kec->id_kopkec,
                'nama_kecamatan' => $kec->name_kopkec,
                'jum_desa' => $kec->kelurahans->count(),
                'jum_koperasi' => $kops->count(),
                'sudah_ops' => $kops->where('st_ops', 'SUDAH')->count(),
                'belum_ops' => $kops->where('st_ops', '!=', 'SUDAH')->count(),
                'sudah_sertifikat' => $kops->where('st_sertifikat', 'SUDAH')->count(),
                'jum_anggota' => (int) $kops->sum('jum_anggota'),
            ];
        });

        // Compute highest and lowest stats for rekapitulasi card
        if (str_starts_with($rekapSubtab, 'rekap_ang_')) {
            if ($rekapSubtab === 'rekap_ang_kec') {
                $tertinggi = $rekapKecamatanData->sortByDesc('jum_anggota')->first();
                $terendah = $rekapKecamatanData->sortBy('jum_anggota')->first();
                $rekapTertinggiNama = 'KECAMATAN '.($tertinggi['nama_kecamatan'] ?? '-');
                $rekapTertinggiNilai = $tertinggi['jum_anggota'] ?? 0;
                $rekapTerendahNama = 'KECAMATAN '.($terendah['nama_kecamatan'] ?? '-');
                $rekapTerendahNilai = $terendah['jum_anggota'] ?? 0;
            } else {
                $tertinggi = $rekapDesaData->sortByDesc('jum_anggota')->first();
                $terendah = $rekapDesaData->sortBy('jum_anggota')->first();
                $rekapTertinggiNama = $tertinggi['nama_desa'] ?? '-';
                $rekapTertinggiNilai = $tertinggi['jum_anggota'] ?? 0;
                $rekapTerendahNama = $terendah['nama_desa'] ?? '-';
                $rekapTerendahNilai = $terendah['jum_anggota'] ?? 0;
            }
        } elseif ($rekapSubtab === 'rekap_kop_kec') {
            $tertinggi = $rekapKecamatanData->sortByDesc('jum_koperasi')->first();
            $terendah = $rekapKecamatanData->sortBy('jum_koperasi')->first();
            $rekapTertinggiNama = 'KECAMATAN '.($tertinggi['nama_kecamatan'] ?? '-');
            $rekapTertinggiNilai = $tertinggi['jum_koperasi'] ?? 0;
            $rekapTerendahNama = 'KECAMATAN '.($terendah['nama_kecamatan'] ?? '-');
            $rekapTerendahNilai = $terendah['jum_koperasi'] ?? 0;
        } else {
            $tertinggi = $rekapDesaData->sortByDesc('jum_koperasi')->first();
            $terendah = $rekapDesaData->sortBy('jum_koperasi')->first();
            $rekapTertinggiNama = $tertinggi['nama_desa'] ?? '-';
            $rekapTertinggiNilai = $tertinggi['jum_koperasi'] ?? 0;
            $rekapTerendahNama = $terendah['nama_desa'] ?? '-';
            $rekapTerendahNilai = $terendah['jum_koperasi'] ?? 0;
        }

        $viewData = compact(
            'user',
            'isOperator',
            'assignedKecamatanId',
            'activeTab',
            'rekapSubtab',
            'rekapDesaData',
            'rekapKecamatanData',
            'rekapTertinggiNama',
            'rekapTertinggiNilai',
            'rekapTerendahNama',
            'rekapTerendahNilai',
            'totalKoperasi',
            'totalAnggota',
            'totalSimpananPokok',
            'totalSimpananWajib',
            'opsSudah',
            'opsBelum',
            'opsSudahPersen',
            'opsBelumPersen',
            'latihSudah',
            'latihSebagian',
            'latihBelum',
            'latihSudahPersen',
            'latihSebagianPersen',
            'latihBelumPersen',
            'sertifikatSudah',
            'sertifikatBelum',
            'sertifikatSudahPersen',
            'sertifikatBelumPersen',
            'klasifikasiAnggota',
            'koperasis',
            'penguruses',
            'statsPengurus',
            'totalPengawasKoperasi',
            'totalPengurusKoperasi',
            'perPagePengurus',
            'allKoperasis',
            'anggotaKoperasis',
            'perPageAnggota',
            'kecamatans',
            'kecamatansData',
            'gisKoperasis',
            'anggotaRecords',
            'koperasiTypes',
            'pengurusFotoOptions',
            'jenisUsahaOptions',
            'operatorKoperasiProfiles',
            'totalJenisUsaha',
            'operatorPengurus',
            'operatorPengawas',
            'locationPhotoKoperasis',
            'perPage',
            'lampirans'
        );

        return $user->isOperatorDesa()
            ? view('admin.overview', $viewData)
            : view('admin.dashboard', $viewData);
    }

    /**
     * Store a cooperative member and update the cooperative's member total.
     */
    public function storeAnggota(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_koperasi' => ['required', 'integer', 'exists:app_md_koperasi,id_koperasi'],
            'id_kopangtype' => ['nullable', 'integer', Rule::exists('app_md_kopangtype', 'id_kopangtype')->where('flag_del', 0)],
            'name_kopang' => ['required', 'string', 'max:255'],
            'nik_kopang' => ['required', 'digits:16'],
            'id_kec' => ['nullable', 'integer'],
            'id_kel' => ['nullable', 'integer'],
            'kopang_telp' => ['nullable', 'string', 'max:255'],
            'kopang_usaha' => ['nullable', 'string', 'max:255'],
            'kopang_addr' => ['nullable', 'string', 'max:255'],
            'comt_kopang' => ['nullable', 'string', 'max:255'],
            'gps_lat' => ['nullable', 'string', 'max:50'],
            'gps_long' => ['nullable', 'string', 'max:50'],
        ]);

        $koperasi = $this->findVisibleKoperasi($request, (int) $validated['id_koperasi']);
        foreach (['id_kec' => 'id_kec', 'id_kel' => 'id_kel'] as $input => $attribute) {
            if (isset($validated[$input]) && (int) $validated[$input] !== (int) $koperasi->{$attribute}) {
                abort(404);
            }
        }

        DB::transaction(function () use ($request, $validated, $koperasi): void {
            $nextId = (int) DB::table('app_md_kopang')
                ->lockForUpdate()
                ->max('id_kopang') + 1;

            Kopang::create([
                'id_kopang' => $nextId,
                'name_kopang' => $validated['name_kopang'],
                'id_kec' => ($validated['id_kec'] ?? null) ?: $koperasi->id_kec,
                'id_kel' => ($validated['id_kel'] ?? null) ?: $koperasi->id_kel,
                'id_koperasi' => $koperasi->id_koperasi,
                'id_kopangtype' => ($validated['id_kopangtype'] ?? null) ?: 1,
                'comt_kopang' => ! empty($validated['comt_kopang']) ? $validated['comt_kopang'] : '-',
                'nik_kopang' => $validated['nik_kopang'] ?? null,
                'kopang_usaha' => $validated['kopang_usaha'] ?? '',
                'kopang_addr' => $validated['kopang_addr'] ?? '',
                'kopang_telp' => $validated['kopang_telp'] ?? '',
                'gps_lat' => ! empty($validated['gps_lat']) ? (string) $validated['gps_lat'] : (string) ($koperasi->gps_lat ?? '0'),
                'gps_long' => ! empty($validated['gps_long']) ? (string) $validated['gps_long'] : (string) ($koperasi->gps_long ?? '0'),
                'id_user' => $request->user()->id_user ?? 1,
                'tgl_data' => now(),
                'flag_del' => 0,
            ]);

            $koperasi->increment('jum_anggota');
        });

        $redirect = $request->filled('redirect_tab')
            ? redirect()->route('admin.dashboard', ['tab' => $request->get('redirect_tab')])
            : redirect()->route('admin.dashboard');

        return $redirect
            ->with('success', 'Data Anggota berhasil ditambahkan ke database.');
    }

    /**
     * Upload a photo only for a manager who does not have one yet.
     */
    public function uploadFotoPengurus(Request $request, Kopsdm $pengurus): RedirectResponse
    {
        abort_unless($pengurus->flag_del == 0, 404);
        $this->findVisibleKoperasi($request, (int) $pengurus->id_koperasi);
        abort_if(filled($pengurus->foto_kopsdm), 409, 'Pengurus ini sudah memiliki foto.');

        $request->validate([
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $this->saveFotoPengurus($request, $pengurus);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Foto pengurus berhasil diunggah.');
    }

    public function uploadFotoPengurusOperator(Request $request): RedirectResponse
    {
        abort_unless($request->user()->isOperatorDesa(), 404);

        $validated = $request->validate([
            'id_kopsdm' => ['required', 'integer'],
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $pengurus = Kopsdm::where('flag_del', 0)->findOrFail($validated['id_kopsdm']);
        $this->findVisibleKoperasi($request, (int) $pengurus->id_koperasi);

        $this->saveFotoPengurus($request, $pengurus);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Foto pengurus berhasil disimpan.');
    }

    public function uploadFotoLokasiOperator(Request $request, Koperasi $koperasi): RedirectResponse
    {
        abort_unless($request->user()->isOperatorDesa(), 404);

        $koperasi = $this->findVisibleKoperasi($request, (int) $koperasi->id_koperasi);
        $validated = $request->validate([
            'foto_lokasi' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $fotoLama = $koperasi->foto_lokasi;
        $koperasi->foto_lokasi = $validated['foto_lokasi']
            ->storePublicly("koperasi/lokasi/{$koperasi->id_koperasi}", 'public');
        $koperasi->save();

        if (filled($fotoLama)) {
            Storage::disk('public')->delete($fotoLama);
        }

        return redirect()->to(route('admin.dashboard').'#lokasi-koperasi')
            ->with('success', 'Foto lokasi koperasi berhasil disimpan.');
    }

    private function saveFotoPengurus(Request $request, Kopsdm $pengurus): void
    {
        $fotoLama = $pengurus->foto_kopsdm;
        $pengurus->foto_kopsdm = $request->file('foto')->storePublicly('pengurus', 'public');
        $pengurus->save();

        if (filled($fotoLama)) {
            Storage::disk('public')->delete($fotoLama);
        }
    }

    /**
     * Store a newly created Koperasi.
     */
    public function storeKoperasi(Request $request)
    {
        $user = $request->user();
        abort_unless($user->isSuperAdmin() || $user->isOperatorKecamatan(), 403);

        $validated = $request->validate([
            'name_koperasi' => 'required|string|max:255',
            'id_kec' => ['required', 'integer', Rule::exists('app_md_kopkec', 'id_kopkec')->where('flag_del', 0)],
            'id_kel' => ['required', 'integer', Rule::exists('app_md_kopkel', 'id_kopkel')
                ->where('id_kopkec', $request->input('id_kec'))
                ->where('flag_del', 0)],
            'no_inkop' => 'nullable|string|max:100',
            'no_ahu' => 'nullable|string|max:100',
            'tgl_ahu' => 'nullable|date',
            'st_ops' => ['required', 'string', 'in:SUDAH,BELUM'],
            'st_latih' => ['required', 'string', 'in:SUDAH,SEBAGIAN,BELUM'],
            'st_sertifikat' => ['required', 'string', 'in:SUDAH,BELUM'],
            'cat_koperasi' => ['nullable', 'string', 'max:255'],
        ]);

        $this->authorizeKoperasiLocation($user, (int) $validated['id_kec'], (int) $validated['id_kel']);

        $maxId = (int) Koperasi::max('id_koperasi');
        $validated['id_koperasi'] = $maxId + 1;
        $validated['kop_addr'] = 'Kabupaten Bogor, Jawa Barat';
        $validated['kop_telp'] = '08123456789';
        $validated['kop_mail'] = 'kmp.info@bogorkab.go.id';
        $validated['jum_pengurus'] = 5;
        $validated['jum_pengawas'] = 3;
        $validated['jum_anggota'] = 0;

        // Auto coordinate fallback from subdistrict
        $kec = Kecamatan::find($validated['id_kec']);
        $validated['gps_lat'] = $kec?->latitude ? (string) $kec->latitude : '-6.5950';
        $validated['gps_long'] = $kec?->longitude ? (string) $kec->longitude : '106.7900';

        Koperasi::create($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'koperasi'])
            ->with('success', 'Data Koperasi berhasil ditambahkan ke database.');
    }

    /**
     * Update an existing Koperasi.
     */
    public function updateKoperasi(Request $request, Koperasi $koperasi)
    {
        $user = $request->user();
        $this->findVisibleKoperasi($request, (int) $koperasi->id_koperasi);

        $rules = [
            'name_koperasi' => 'required|string|max:255',
            'id_kec' => ['required', 'integer', Rule::exists('app_md_kopkec', 'id_kopkec')->where('flag_del', 0)],
            'id_kel' => ['required', 'integer', Rule::exists('app_md_kopkel', 'id_kopkel')
                ->where('id_kopkec', $request->input('id_kec'))
                ->where('flag_del', 0)],
            'no_inkop' => 'nullable|string|max:100',
            'no_ahu' => 'nullable|string|max:100',
            'tgl_ahu' => 'nullable|date',
            'st_ops' => ['required', 'string', 'in:SUDAH,BELUM'],
            'st_latih' => ['required', 'string', 'in:SUDAH,SEBAGIAN,BELUM'],
            'st_sertifikat' => ['required', 'string', 'in:SUDAH,BELUM'],
            'cat_koperasi' => 'nullable|string',
            'jum_anggota' => 'nullable|integer|min:0',
            'jum_pengurus' => 'nullable|integer|min:0',
            'jum_pengawas' => 'nullable|integer|min:0',
            'kop_addr' => 'nullable|string|max:255',
            'kop_telp' => 'nullable|string|max:50',
            'kop_mail' => 'nullable|string|max:100',
            'gps_lat' => 'nullable|string|max:50',
            'gps_long' => 'nullable|string|max:50',
            // Finansial / Simpanan
            'jum_sim_pokok' => 'nullable|integer|min:0',
            'jum_sim_wajib' => 'nullable|integer|min:0',
            // Website & Media Sosial
            'kop_web' => 'nullable|string|max:255',
            'media_fb' => 'nullable|string|max:255',
            'media_ig' => 'nullable|string|max:255',
            'media_yt' => 'nullable|string|max:255',
            'media_x' => 'nullable|string|max:255',
            'media_tiktok' => 'nullable|string|max:255',
        ];

        for ($i = 1; $i <= 13; $i++) {
            $rules["id_koperasitype{$i}"] = 'nullable|string|max:50';
        }

        $validated = $request->validate($rules);
        $this->authorizeKoperasiLocation($user, (int) $validated['id_kec'], (int) $validated['id_kel']);

        if ($request->has('has_types_input')) {
            for ($i = 1; $i <= 13; $i++) {
                $key = "id_koperasitype{$i}";
                $validated[$key] = $request->boolean($key) ? 'Yes' : 'No';
            }
        }

        $koperasi->update($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'koperasi'])
            ->with('success', 'Data Koperasi berhasil diperbarui.');
    }

    /**
     * Delete an existing Koperasi (Soft delete).
     */
    public function destroyKoperasi(Request $request, Koperasi $koperasi)
    {
        $this->findVisibleKoperasi($request, (int) $koperasi->id_koperasi);

        $koperasi->update(['flag_del' => 1]);

        return redirect()->route('admin.dashboard', ['tab' => 'koperasi'])
            ->with('success', 'Data Koperasi berhasil dihapus.');
    }

    /**
     * Update Usaha for a Koperasi.
     */
    public function updateUsahaKoperasi(Request $request, Koperasi $koperasi)
    {
        $koperasi = $this->findVisibleKoperasi($request, (int) $koperasi->id_koperasi);
        $hasTypesInput = $request->has('has_types_input');
        $rules = [
            'cat_koperasi' => [$hasTypesInput ? 'nullable' : 'required', 'string', 'max:255'],
            'has_types_input' => ['sometimes', 'accepted'],
            'reset_types' => ['sometimes', 'accepted'],
        ];

        for ($index = 1; $index <= 13; $index++) {
            $rules["id_koperasitype{$index}"] = ['nullable', 'string', 'in:Yes'];
        }

        $validated = $request->validate($rules);
        $updates = [];

        if (array_key_exists('cat_koperasi', $validated)) {
            $updates['cat_koperasi'] = $validated['cat_koperasi'];
        }

        if ($hasTypesInput) {
            for ($index = 1; $index <= 13; $index++) {
                $key = "id_koperasitype{$index}";
                $updates[$key] = $request->boolean('reset_types') || ! $request->boolean($key)
                    ? 'No'
                    : 'Yes';
            }
        }

        $koperasi->update($updates);

        $redirect = $hasTypesInput && $request->user()->isOperatorDesa()
            ? redirect()->to(route('admin.dashboard').'#jenis-usaha')
            : redirect()->route('admin.dashboard', ['tab' => 'koperasi']);

        return $redirect->with('success', 'Data Usaha Koperasi berhasil diperbarui.');
    }

    /**
     * Upload Foto for a Koperasi.
     */
    public function uploadFotoKoperasi(Request $request, Koperasi $koperasi)
    {
        $this->findVisibleKoperasi($request, (int) $koperasi->id_koperasi);

        $request->validate([
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        if ($request->hasFile('foto')) {
            $request->file('foto')->store('koperasi_foto', 'public');
        }

        return redirect()->route('admin.dashboard', ['tab' => 'koperasi'])
            ->with('success', 'Foto Koperasi berhasil diunggah.');
    }

    /**
     * Export Koperasi table data to CSV/Excel.
     */
    public function exportKoperasi(Request $request)
    {
        $query = $this->visibleKoperasiQuery($request->user())
            ->with(['kecamatan', 'kelurahan']);

        if ($idKec = $request->get('id_kec')) {
            $query->where('id_kec', $idKec);
        }
        if ($idKel = $request->get('id_kel')) {
            $query->where('id_kel', $idKel);
        }
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name_koperasi', 'like', "%{$search}%")
                    ->orWhere('no_ahu', 'like', "%{$search}%")
                    ->orWhere('no_inkop', 'like', "%{$search}%");
            });
        }

        $items = $query->orderBy('id_koperasi', 'asc')->get();

        $filename = 'Database_Koperasi_Kabupaten_Bogor_'.date('Ymd_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($items) {
            $handle = fopen('php://output', 'w');
            // UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, ['No', 'NI-KOP', 'Nama Koperasi', 'Nomor AHU', 'Tanggal AHU', 'Kecamatan', 'Desa/Kelurahan', 'Status Operasional', 'Status Pelatihan', 'Status Sertifikat']);

            foreach ($items as $idx => $kop) {
                fputcsv($handle, array_map([CsvSanitizer::class, 'sanitize'], [
                    $idx + 1,
                    $kop->no_inkop ?? '-',
                    $kop->name_koperasi,
                    $kop->no_ahu ?? '-',
                    $kop->tgl_ahu ? date('d/m/Y', strtotime($kop->tgl_ahu)) : '-',
                    $kop->kecamatan?->name_kopkec ?? '-',
                    $kop->kelurahan?->name_kopkel ?? '-',
                    $kop->st_ops,
                    $kop->st_latih,
                    $kop->st_sertifikat,
                ]));
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Store a newly uploaded document attachment.
     */
    public function storeLampiran(Request $request): RedirectResponse
    {
        abort_unless($request->user()->isSuperAdmin(), 403);

        $request->validate([
            'judul' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'urutan' => 'nullable|integer',
            'file' => 'required|file|max:51200',
        ]);

        $dir = base_path('informasi');
        if (! file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $ext = strtolower($file->getClientOriginalExtension() ?: 'pdf');
        $cleanTitle = trim($request->judul);
        $displayName = str_ends_with(strtolower($cleanTitle), '.'.$ext) ? $cleanTitle : ($cleanTitle.'.'.$ext);
        $safeBase = Str::slug(pathinfo($cleanTitle, PATHINFO_FILENAME));
        $filename = time().'_'.($safeBase ?: 'dokumen').'.'.$ext;

        $file->move($dir, $filename);
        $savedPath = $dir.'/'.$filename;
        $sizeInMB = file_exists($savedPath) ? round(filesize($savedPath) / 1024 / 1024, 2).' MB' : '0 MB';

        LampiranInformasi::create([
            'judul' => $cleanTitle,
            'keterangan' => $request->keterangan,
            'file_name' => $displayName,
            'file_path' => $filename,
            'file_size' => $sizeInMB,
            'file_type' => $ext,
            'urutan' => (int) ($request->input('urutan') ?: 1),
            'is_active' => true,
        ]);

        return redirect()->route('admin.dashboard', ['tab' => 'lampiran'])->with('success', 'File lampiran berhasil diupload dan terhubung ke portal publik.');
    }

    /**
     * Update an existing document attachment.
     */
    public function updateLampiran(Request $request, LampiranInformasi $lampiran): RedirectResponse
    {
        abort_unless($request->user()->isSuperAdmin(), 403);

        $request->validate([
            'judul' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'urutan' => 'nullable|integer',
            'file' => 'nullable|file|max:51200',
        ]);

        $dir = base_path('informasi');
        if (! file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        $cleanTitle = trim($request->judul);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $ext = strtolower($file->getClientOriginalExtension() ?: 'pdf');
            $safeBase = Str::slug(pathinfo($cleanTitle, PATHINFO_FILENAME));
            $filename = time().'_'.($safeBase ?: 'dokumen').'.'.$ext;

            $file->move($dir, $filename);
            $savedPath = $dir.'/'.$filename;
            $sizeInMB = file_exists($savedPath) ? round(filesize($savedPath) / 1024 / 1024, 2).' MB' : '0 MB';

            // Delete old file if exists and not default
            if ($lampiran->file_path && $lampiran->file_path !== 'kdkp_maret_2026.pdf') {
                $oldPath = $dir.'/'.$lampiran->file_path;
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $lampiran->file_path = $filename;
            $lampiran->file_size = $sizeInMB;
            $lampiran->file_type = $ext;
        }

        $lampiran->judul = $cleanTitle;
        $lampiran->keterangan = $request->keterangan;
        $lampiran->file_name = str_ends_with(strtolower($cleanTitle), '.'.$lampiran->file_type) ? $cleanTitle : ($cleanTitle.'.'.$lampiran->file_type);
        if ($request->filled('urutan')) {
            $lampiran->urutan = (int) $request->urutan;
        }
        $lampiran->save();

        return redirect()->route('admin.dashboard', ['tab' => 'lampiran'])->with('success', 'Data lampiran berhasil diperbarui.');
    }

    /**
     * Delete an existing document attachment.
     */
    public function destroyLampiran(Request $request, LampiranInformasi $lampiran): RedirectResponse
    {
        abort_unless($request->user()->isSuperAdmin(), 403);

        $dir = base_path('informasi');
        if ($lampiran->file_path && $lampiran->file_path !== 'kdkp_maret_2026.pdf') {
            $path = $dir.'/'.$lampiran->file_path;
            if (file_exists($path)) {
                @unlink($path);
            }
        }

        $lampiran->delete();

        return redirect()->route('admin.dashboard', ['tab' => 'lampiran'])->with('success', 'Lampiran berhasil dihapus.');
    }

    /**
     * Store a newly created Pengurus / SDM.
     */
    public function storePengurus(Request $request)
    {
        $validated = $request->validate([
            'id_koperasi' => 'required|integer|exists:app_md_koperasi,id_koperasi',
            'name_kopsdm' => 'required|string|max:255',
            'jab_kopsdm' => 'required|string|max:255',
            'type_kopsdm' => 'required|string|in:PENGURUS,PENGAWAS',
            'order_kopsdm' => 'nullable|string|max:10',
            'comt_kopsdm' => 'nullable|string|max:255',
        ]);

        $this->findVisibleKoperasi($request, (int) $validated['id_koperasi']);

        $maxId = (int) Kopsdm::max('id_kopsdm');
        $validated['id_kopsdm'] = $maxId + 1;
        $validated['order_kopsdm'] = ! empty($validated['order_kopsdm']) ? $validated['order_kopsdm'] : '1';
        $validated['comt_kopsdm'] = ! empty($validated['comt_kopsdm']) ? $validated['comt_kopsdm'] : '-';
        $validated['id_user'] = $request->user()->id_user ?? 1;
        $validated['tgl_data'] = now();
        $validated['flag_del'] = 0;

        Kopsdm::create($validated);

        $redirect = $request->user()->isOperatorDesa()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('admin.dashboard', ['tab' => 'pengurus']);

        return $redirect
            ->with('success', 'Data Pengurus berhasil ditambahkan ke database.');
    }

    /**
     * Update an existing Pengurus / SDM.
     */
    public function updatePengurus(Request $request, Kopsdm $pengurus): RedirectResponse
    {
        abort_unless($pengurus->flag_del == 0, 404);
        $this->findVisibleKoperasi($request, (int) $pengurus->id_koperasi);

        $validated = $request->validate([
            'id_koperasi' => 'required|integer|exists:app_md_koperasi,id_koperasi',
            'name_kopsdm' => 'required|string|max:255',
            'jab_kopsdm' => 'required|string|max:255',
            'type_kopsdm' => 'required|string|in:PENGURUS,PENGAWAS',
            'order_kopsdm' => 'nullable|string|max:10',
            'comt_kopsdm' => 'nullable|string|max:255',
        ]);

        $this->findVisibleKoperasi($request, (int) $validated['id_koperasi']);

        $pengurus->update([
            'id_koperasi' => (int) $validated['id_koperasi'],
            'name_kopsdm' => $validated['name_kopsdm'],
            'jab_kopsdm' => $validated['jab_kopsdm'],
            'type_kopsdm' => $validated['type_kopsdm'],
            'order_kopsdm' => ! empty($validated['order_kopsdm']) ? $validated['order_kopsdm'] : '1',
            'comt_kopsdm' => ! empty($validated['comt_kopsdm']) ? $validated['comt_kopsdm'] : '-',
        ]);

        $redirect = $request->user()->isOperatorDesa()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('admin.dashboard', ['tab' => 'pengurus']);

        return $redirect
            ->with('success', 'Data Pengurus berhasil diperbarui.');
    }

    /**
     * Delete (soft delete) an existing Pengurus / SDM.
     */
    public function destroyPengurus(Request $request, Kopsdm $pengurus): RedirectResponse
    {
        abort_unless($pengurus->flag_del == 0, 404);

        $this->findVisibleKoperasi($request, (int) $pengurus->id_koperasi);

        $pengurus->update(['flag_del' => 1]);

        $redirect = $request->user()->isOperatorDesa()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('admin.dashboard', ['tab' => 'pengurus']);

        return $redirect
            ->with('success', 'Data Pengurus berhasil dihapus.');
    }

    /**
     * Export Pengurus table data to CSV/Excel.
     */
    public function exportPengurus(Request $request)
    {
        $query = Kopsdm::with(['koperasi.kecamatan', 'koperasi.kelurahan'])
            ->where('flag_del', 0);

        $visibleKoperasiIds = $this->visibleKoperasiQuery($request->user())->select('id_koperasi');
        $query->whereIn('id_koperasi', $visibleKoperasiIds);

        if ($idKec = $request->get('filter_kec_pengurus')) {
            $query->whereHas('koperasi', fn ($q) => $q->where('id_kec', $idKec));
        }
        if ($idKel = $request->get('filter_kel_pengurus')) {
            $query->whereHas('koperasi', fn ($q) => $q->where('id_kel', $idKel));
        }
        if ($search = $request->get('search_pengurus')) {
            $query->where(function ($q) use ($search) {
                $q->where('name_kopsdm', 'like', "%{$search}%")
                    ->orWhere('jab_kopsdm', 'like', "%{$search}%")
                    ->orWhere('type_kopsdm', 'like', "%{$search}%")
                    ->orWhere('comt_kopsdm', 'like', "%{$search}%")
                    ->orWhereHas('koperasi', function ($kq) use ($search) {
                        $kq->where('name_koperasi', 'like', "%{$search}%")
                            ->orWhereHas('kecamatan', fn ($sub) => $sub->where('name_kopkec', 'like', "%{$search}%"))
                            ->orWhereHas('kelurahan', fn ($sub) => $sub->where('name_kopkel', 'like', "%{$search}%"));
                    });
            });
        }

        $items = $query->orderBy('id_koperasi', 'asc')->orderBy('order_kopsdm', 'asc')->get();

        $filename = 'Database_Pengurus_Koperasi_Kabupaten_Bogor_'.date('Ymd_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($items) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, ['No', 'Unit Koperasi', 'Kecamatan', 'Nama Pengurus', 'Jabatan', 'Kategori', 'Urutan', 'Keterangan']);

            foreach ($items as $idx => $sdm) {
                fputcsv($handle, array_map([CsvSanitizer::class, 'sanitize'], [
                    $idx + 1,
                    $sdm->koperasi?->name_koperasi ?? '-',
                    $sdm->koperasi?->kecamatan?->name_kopkec ?? '-',
                    $sdm->name_kopsdm,
                    $sdm->jab_kopsdm,
                    $sdm->type_kopsdm,
                    $sdm->order_kopsdm,
                    $sdm->comt_kopsdm,
                ]));
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export Anggota table data to CSV/Excel.
     */
    public function exportAnggota(Request $request)
    {
        $baseQuery = $this->visibleKoperasiQuery($request->user());

        $query = (clone $baseQuery)->with(['kecamatan', 'kelurahan']);

        if ($idKec = $request->get('filter_kec_anggota')) {
            $query->where('id_kec', $idKec);
        }
        if ($idKel = $request->get('filter_kel_anggota')) {
            $query->where('id_kel', $idKel);
        }
        if ($search = $request->get('search_anggota')) {
            $query->where(function ($q) use ($search) {
                $q->where('name_koperasi', 'like', "%{$search}%")
                    ->orWhereHas('kecamatan', fn ($sub) => $sub->where('name_kopkec', 'like', "%{$search}%"))
                    ->orWhereHas('kelurahan', fn ($sub) => $sub->where('name_kopkel', 'like', "%{$search}%"));
            });
        }

        $items = $query->orderBy('id_koperasi', 'asc')->get();

        $filename = 'Database_Anggota_Koperasi_Kabupaten_Bogor_'.date('Ymd_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($items) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, ['No', 'Nama Koperasi', 'Kecamatan', 'Desa/Kelurahan', 'Jumlah Anggota Terdata']);

            foreach ($items as $idx => $kop) {
                fputcsv($handle, array_map([CsvSanitizer::class, 'sanitize'], [
                    $idx + 1,
                    $kop->name_koperasi,
                    $kop->kecamatan?->name_kopkec ?? '-',
                    $kop->kelurahan?->name_kopkel ?? '-',
                    $kop->jum_anggota,
                ]));
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function findVisibleKoperasi(Request $request, int $koperasiId): Koperasi
    {
        return $this->visibleKoperasiQuery($request->user())->findOrFail($koperasiId);
    }

    private function visibleKoperasiQuery(User $user): Builder
    {
        abort_unless(
            $user->isSuperAdmin() || $user->isOperatorDesa() || $user->isOperatorKecamatan(),
            403
        );

        $query = Koperasi::query()->where('flag_del', 0);

        if ($user->isOperatorDesa()) {
            return $user->id_branch > 0
                ? $query->where('id_kel', $user->id_branch)
                : $query->whereRaw('1 = 0');
        }

        if ($user->isOperatorKecamatan()) {
            return $user->id_company > 0
                ? $query->where('id_kec', $user->id_company)
                : $query->whereRaw('1 = 0');
        }

        return $query;
    }

    private function authorizeKoperasiLocation(User $user, int $districtId, int $villageId): void
    {
        if ($user->isSuperAdmin()) {
            return;
        }

        if ($user->isOperatorKecamatan()) {
            abort_unless($user->id_company > 0 && (int) $user->id_company === $districtId, 404);

            return;
        }

        abort_unless(
            $user->isOperatorDesa()
                && $user->id_branch > 0
                && (int) $user->id_branch === $villageId
                && Kelurahan::query()
                    ->where('id_kopkel', $villageId)
                    ->where('id_kopkec', $districtId)
                    ->where('flag_del', 0)
                    ->exists(),
            404
        );
    }
}
