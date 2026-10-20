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
        $activeTab = $request->get('tab', 'informasi');

        // Scoping based on user role
        $baseQuery = Koperasi::query();
        if ($user && $user->isOperatorDesa() && $user->id_branch > 0) {
            $baseQuery->where('id_kel', $user->id_branch);
        } elseif ($user && $user->isOperatorKecamatan() && $user->id_company > 0) {
            $baseQuery->where('id_kec', $user->id_company);
        }

        // Allow Superadmin to filter scope if selected via dropdown
        if ($filterKec = $request->get('filter_kec')) {
            $baseQuery->where('id_kec', $filterKec);
        }

        // Aggregated statistics for Informasi Koperasi (GovTech KOP)
        $totalKoperasi = (clone $baseQuery)->count();
        $totalAnggota = 0; // Data verifikasi tahap konsolidasi (sesuai referensi UI)

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
        $koperasis = $query->orderBy('id_koperasi', 'asc')->paginate(15)->withQueryString();

        // Database Pengurus query
        $pengurusQuery = Kopsdm::with('koperasi');
        if ($user && $user->isOperatorDesa() && $user->id_branch > 0) {
            $kopId = Koperasi::where('id_kel', $user->id_branch)->value('id_koperasi');
            $pengurusQuery->where('id_koperasi', $kopId ?: 0);
        } elseif ($user && $user->isOperatorKecamatan() && $user->id_company > 0) {
            $kopIds = Koperasi::where('id_kec', $user->id_company)->pluck('id_koperasi');
            $pengurusQuery->whereIn('id_koperasi', $kopIds);
        }
        if ($searchPengurus = $request->get('search_pengurus')) {
            $pengurusQuery->where('name_kopsdm', 'like', "%{$searchPengurus}%")
                ->orWhere('jab_kopsdm', 'like', "%{$searchPengurus}%");
        }
        $penguruses = $pengurusQuery->orderBy('id_kopsdm', 'asc')->paginate(20)->withQueryString();

        $kecamatans = Kecamatan::orderBy('id_kopkec')->get();

        return view('admin.dashboard', compact(
            'user',
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
            'kecamatans'
        ));
    }
}
