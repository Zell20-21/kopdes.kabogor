<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Koperasi;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display the Admin KMP Kabupaten Bogor dashboard.
     */
    public function index(Request $request): View
    {
        $activeTab = $request->get('tab', 'informasi');

        // Aggregated statistics for Informasi Koperasi (GovTech KOP)
        $totalKoperasi = Koperasi::count();
        $totalAnggota = 0; // Data verifikasi tahap konsolidasi

        $opsSudah = Koperasi::where('status_operasional', 'SUDAH')->count();
        $opsBelum = Koperasi::where('status_operasional', 'BELUM')->count();
        $opsSudahPersen = $totalKoperasi > 0 ? round(($opsSudah / $totalKoperasi) * 100, 2) : 0;
        $opsBelumPersen = $totalKoperasi > 0 ? round(($opsBelum / $totalKoperasi) * 100, 2) : 0;

        $latihSudah = Koperasi::where('status_pelatihan', 'SUDAH')->count();
        $latihSebagian = 0;
        $latihBelum = Koperasi::where('status_pelatihan', 'BELUM')->count();
        $latihSudahPersen = $totalKoperasi > 0 ? round(($latihSudah / $totalKoperasi) * 100, 2) : 0;
        $latihSebagianPersen = 0.00;
        $latihBelumPersen = $totalKoperasi > 0 ? round(($latihBelum / $totalKoperasi) * 100, 2) : 0;

        $sertifikatSudah = Koperasi::where('status_sertifikat', 'SUDAH')->count();
        $sertifikatBelum = Koperasi::where('status_sertifikat', 'BELUM')->count();
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
        $query = Koperasi::query();
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('kecamatan', 'like', "%{$search}%")
                    ->orWhere('no_ahu', 'like', "%{$search}%");
            });
        }
        if ($statusOps = $request->get('status_ops')) {
            $query->where('status_operasional', $statusOps);
        }
        $koperasis = $query->orderBy('id', 'asc')->paginate(15)->withQueryString();

        $kecamatans = Kecamatan::orderBy('nomor_urut')->get();

        return view('admin.dashboard', compact(
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
            'kecamatans'
        ));
    }
}
