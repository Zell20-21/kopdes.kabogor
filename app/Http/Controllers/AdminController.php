<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Koperasi;
use App\Models\Kopsdm;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display the Admin KMP Kabupaten Bogor dashboard.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $isOperator = $user->isOperatorDesa() || $user->isOperatorKecamatan();
        $activeTab = $request->get('tab', 'informasi');

        // Scoping based on user role
        $baseQuery = Koperasi::query()->where('flag_del', 0);
        if ($user->isOperatorDesa()) {
            if ($user->id_branch > 0) {
                $baseQuery->where('id_kel', $user->id_branch);
            } else {
                $baseQuery->whereRaw('1 = 0');
            }
        } elseif ($user->isOperatorKecamatan()) {
            if ($user->id_company > 0) {
                $baseQuery->where('id_kec', $user->id_company);
            } else {
                $baseQuery->whereRaw('1 = 0');
            }
        } elseif (! $user->isSuperAdmin()) {
            $baseQuery->whereRaw('1 = 0');
        }

        // Allow Superadmin to filter scope if selected via dropdown
        if ($user->isSuperAdmin() && $filterKec = $request->get('filter_kec')) {
            $baseQuery->where('id_kec', $filterKec);
        }

        // Aggregated statistics for Informasi Koperasi (GovTech KOP)
        $totalKoperasi = (clone $baseQuery)->count();
        $totalAnggota = (clone $baseQuery)->sum('jum_anggota');

        $opsSudah = (clone $baseQuery)->where('st_ops', 'SUDAH')->count();
        $opsBelum = (clone $baseQuery)->where('st_ops', 'BELUM')->count();
        $opsSudahPersen = $totalKoperasi > 0 ? round(($opsSudah / $totalKoperasi) * 100, 2) : 0;
        $opsBelumPersen = $totalKoperasi > 0 ? round(($opsBelum / $totalKoperasi) * 100, 2) : 0;

        $latihSudah = (clone $baseQuery)->where('st_latih', 'SUDAH')->count();
        $latihSebagian = 0;
        $latihBelum = (clone $baseQuery)->where('st_latih', 'BELUM')->count();
        $latihSudahPersen = $totalKoperasi > 0 ? round(($latihSudah / $totalKoperasi) * 100, 2) : 0;
        $latihSebagianPersen = 0.00;
        $latihBelumPersen = $totalKoperasi > 0 ? round(($latihBelum / $totalKoperasi) * 100, 2) : 0;

        $sertifikatSudah = (clone $baseQuery)->where('st_sertifikat', 'SUDAH')->count();
        $sertifikatBelum = (clone $baseQuery)->where('st_sertifikat', 'BELUM')->count();
        $sertifikatSudahPersen = $totalKoperasi > 0 ? round(($sertifikatSudah / $totalKoperasi) * 100, 2) : 0;
        $sertifikatBelumPersen = $totalKoperasi > 0 ? round(($sertifikatBelum / $totalKoperasi) * 100, 2) : 0;

        // Klasifikasi Anggota UMKM
        $klasifikasiAnggota = [
            ['nama' => 'Industri UMKM', 'jumlah' => 0, 'accent' => ''],
            ['nama' => 'Pedagang UMKM', 'jumlah' => 0, 'accent' => ''],
            ['nama' => 'Pengrajin UMKM', 'jumlah' => 0, 'accent' => 'border-l-4 border-rose-500 pl-2'],
            ['nama' => 'Petani', 'jumlah' => 0, 'accent' => 'border-l-4 border-emerald-500 pl-2'],
            ['nama' => 'Lainnya', 'jumlah' => 0, 'accent' => 'border-l-4 border-amber-500 pl-2'],
        ];

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

        // Database Pengurus query
        $pengurusQuery = Kopsdm::with('koperasi')
            ->where('flag_del', 0)
            ->whereIn('id_koperasi', (clone $baseQuery)->select('id_koperasi'));
        if ($searchPengurus = $request->get('search_pengurus')) {
            $pengurusQuery->where(function ($query) use ($searchPengurus) {
                $query->where('name_kopsdm', 'like', "%{$searchPengurus}%")
                    ->orWhere('jab_kopsdm', 'like', "%{$searchPengurus}%");
            });
        }
        $penguruses = $pengurusQuery->orderBy('id_kopsdm', 'asc')->paginate(20)->withQueryString();

        $anggotaKoperasis = (clone $baseQuery)
            ->with(['kecamatan', 'kelurahan'])
            ->orderBy('id_koperasi', 'asc')
            ->paginate(15, ['*'], 'anggota_page')
            ->withQueryString();

        $kecamatansQuery = Kecamatan::with(['kelurahans' => function ($query) use ($user) {
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
            'kelurahans' => $kecamatan->kelurahans->map(fn ($kelurahan): array => [
                'id_kopkel' => $kelurahan->id_kopkel,
                'name_kopkel' => $kelurahan->name_kopkel,
            ])->all(),
        ])->all();
        $assignedKecamatanId = $user->isOperatorDesa()
            ? ($kecamatans->first()?->id_kopkec ?? '')
            : $user->id_company;

        return view('admin.dashboard', compact(
            'user',
            'isOperator',
            'assignedKecamatanId',
            'activeTab',
            'totalKoperasi',
            'totalAnggota',
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
            'anggotaKoperasis',
            'kecamatans',
            'kecamatansData',
            'gisKoperasis',
            'perPage'
        ));
    }

    /**
     * Store a newly created Koperasi.
     */
    public function storeKoperasi(Request $request)
    {
        $validated = $request->validate([
            'name_koperasi' => 'required|string|max:255',
            'id_kec' => 'required|integer',
            'id_kel' => 'required|integer',
            'no_inkop' => 'nullable|string|max:100',
            'no_ahu' => 'nullable|string|max:100',
            'tgl_ahu' => 'nullable|date',
            'st_ops' => 'required|string',
            'st_latih' => 'required|string',
            'st_sertifikat' => 'required|string',
            'cat_koperasi' => 'nullable|string',
        ]);

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
     * Export Koperasi table data to CSV/Excel.
     */
    public function exportKoperasi(Request $request)
    {
        $query = Koperasi::with(['kecamatan', 'kelurahan'])->where('flag_del', 0);

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
                fputcsv($handle, [
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
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
