<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Koperasi;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DashboardController extends Controller
{
    /**
     * Display the KMP Kabupaten Bogor dashboard.
     */
    public function index(): View
    {
        $kecamatans = Kecamatan::orderBy('id_kopkec')->get();

        $totalDesa = $kecamatans->sum('kop_desa');
        $totalKelurahan = $kecamatans->sum('kop_kel');
        $totalKoperasi = $kecamatans->sum('jumlah');

        // Master Fasilitas & Gerai KDKMP (Dilengkapi ID Tipe dan Jumlah Riil di Database)
        $fasilitasOptions = [
            [
                'id' => 3,
                'type_ids' => [3],
                'nama' => 'Kantor Koperasi',
                'icon' => 'fa-solid fa-building-columns',
                'bg' => 'bg-blue-50 text-blue-700 border-blue-200 hover:bg-blue-100',
                'badge' => 'bg-blue-600',
                'count' => 25,
                'featured' => true,
            ],
            [
                'id' => 1,
                'type_ids' => [1],
                'nama' => 'Gerai Sembako',
                'icon' => 'fa-solid fa-store',
                'bg' => 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100',
                'badge' => 'bg-emerald-600',
                'count' => 18,
                'featured' => true,
            ],
            [
                'id' => 5,
                'type_ids' => [5, 2], // Gerai Klinik Desa & Gerai Apotek Desa
                'nama' => 'Klinik & Apotek',
                'icon' => 'fa-solid fa-kit-medical',
                'bg' => 'bg-rose-50 text-rose-700 border-rose-200 hover:bg-rose-100',
                'badge' => 'bg-rose-600',
                'count' => 4,
                'featured' => true,
            ],
            [
                'id' => 4,
                'type_ids' => [4],
                'nama' => 'Simpan Pinjam',
                'icon' => 'fa-solid fa-hand-holding-dollar',
                'bg' => 'bg-violet-50 text-violet-700 border-violet-200 hover:bg-violet-100',
                'badge' => 'bg-violet-600',
                'count' => 3,
                'featured' => true,
            ],
            [
                'id' => 6,
                'type_ids' => [6],
                'nama' => 'Cold Storage',
                'icon' => 'fa-solid fa-snowflake',
                'bg' => 'bg-cyan-50 text-cyan-700 border-cyan-200 hover:bg-cyan-100',
                'badge' => 'bg-cyan-600',
                'count' => 1,
                'featured' => true,
            ],
            [
                'id' => 7,
                'type_ids' => [7, 10], // Logistik Distribusi & Pangkalan LPG
                'nama' => 'Logistik & LPG',
                'icon' => 'fa-solid fa-truck-ramp-box',
                'bg' => 'bg-amber-50 text-amber-700 border-amber-200 hover:bg-amber-100',
                'badge' => 'bg-amber-600',
                'count' => 7,
                'featured' => true,
            ],
            // Opsi Tambahan untuk "Tampilkan Semua Opsi Gerai"
            [
                'id' => 2,
                'type_ids' => [2],
                'nama' => 'Gerai Apotek Desa',
                'icon' => 'fa-solid fa-prescription-bottle-medical',
                'bg' => 'bg-pink-50 text-pink-700 border-pink-200 hover:bg-pink-100',
                'badge' => 'bg-pink-600',
                'count' => 3,
                'featured' => false,
            ],
            [
                'id' => 9,
                'type_ids' => [9],
                'nama' => 'Kios Pupuk Desa',
                'icon' => 'fa-solid fa-seedling',
                'bg' => 'bg-lime-50 text-lime-800 border-lime-200 hover:bg-lime-100',
                'badge' => 'bg-lime-600',
                'count' => 3,
                'featured' => false,
            ],
            [
                'id' => 10,
                'type_ids' => [10],
                'nama' => 'Pangkalan Gas LPG',
                'icon' => 'fa-solid fa-fire-flame-curved',
                'bg' => 'bg-orange-50 text-orange-700 border-orange-200 hover:bg-orange-100',
                'badge' => 'bg-orange-600',
                'count' => 5,
                'featured' => false,
            ],
            [
                'id' => 12,
                'type_ids' => [12],
                'nama' => 'Agen Laku Pandai',
                'icon' => 'fa-solid fa-money-bill-transfer',
                'bg' => 'bg-teal-50 text-teal-700 border-teal-200 hover:bg-teal-100',
                'badge' => 'bg-teal-600',
                'count' => 2,
                'featured' => false,
            ],
            [
                'id' => 8,
                'type_ids' => [8],
                'nama' => 'Usaha Lainnya (KBLI)',
                'icon' => 'fa-solid fa-boxes-stacked',
                'bg' => 'bg-slate-100 text-slate-700 border-slate-300 hover:bg-slate-200',
                'badge' => 'bg-slate-600',
                'count' => 1,
                'featured' => false,
            ],
            [
                'id' => 13,
                'type_ids' => [13],
                'nama' => 'Akun Microsite Resmi',
                'icon' => 'fa-solid fa-globe',
                'bg' => 'bg-sky-50 text-sky-700 border-sky-200 hover:bg-sky-100',
                'badge' => 'bg-sky-600',
                'count' => 253,
                'featured' => false,
            ],
            [
                'id' => 11,
                'type_ids' => [11],
                'nama' => 'Agen Pos Indonesia',
                'icon' => 'fa-solid fa-envelope-open-text',
                'bg' => 'bg-yellow-50 text-yellow-800 border-yellow-200 hover:bg-yellow-100',
                'badge' => 'bg-yellow-600',
                'count' => 0,
                'featured' => false,
            ],
        ];

        // Slide Timeline Kegiatan & Pembangunan KDKMP Kabupaten Bogor
        $timelineSlides = [
            [
                'fase' => 'FASE 1',
                'tanggal' => 'Inisiasi Program',
                'judul' => 'Sosialisasi & Konsensus Wilayah',
                'lokasi' => 'KMP Desa Gunung Putri, Kec. Gunung Putri',
                'deskripsi' => 'Konsolidasi pembentukan struktur kelembagaan 435 Koperasi Desa & Kelurahan Merah Putih di seluruh Kabupaten Bogor.',
                'foto' => asset('asset/kop_137.jpg'),
            ],
            [
                'fase' => 'FASE 2',
                'tanggal' => 'Sertifikasi Legalitas',
                'judul' => 'Pengesahan Akta & SK Kemenkumham',
                'lokasi' => 'KMP Desa Pamegarsari, Kec. Parung',
                'deskripsi' => 'Standardisasi legalitas AHU notaris serta penetapan badan hukum koperasi resmi sesuai amanat UU 25/1992.',
                'foto' => asset('asset/kop_18.jpg'),
            ],
            [
                'fase' => 'FASE 3',
                'tanggal' => 'Infrastruktur Fisik',
                'judul' => 'Aktivasi Gedung & Gerai Sembako',
                'lokasi' => 'KMP Desa Warujaya, Kec. Parung',
                'deskripsi' => 'Penyediaan kantor sekretariat koperasi, etalase sembako kebutuhan pokok, dan ruang layanan simpan pinjam.',
                'foto' => asset('asset/kop_19.jpg'),
            ],
            [
                'fase' => 'FASE 4',
                'tanggal' => 'Pemberdayaan SDM',
                'judul' => 'Pelatihan & Literasi Digital Pengurus',
                'lokasi' => 'KMP Kelurahan Puspanegara, Kec. Citeureup',
                'deskripsi' => 'Penguatan kapasitas bagi 23.428 pengurus, pengawas, dan relawan kader posko koperasi desa terpadu.',
                'foto' => asset('asset/kop_256.jpg'),
            ],
            [
                'fase' => 'FASE 5',
                'tanggal' => 'Ekspansi Layanan',
                'judul' => 'Gerai Klinik Desa & Fasilitas Logistik',
                'lokasi' => 'KMP Kelurahan Karang Asem Barat, Kec. Citeureup',
                'deskripsi' => 'Pengembangan unit gerai klinik kesehatan warga, pangkalan LPG subsidi, dan cold chain penyimpanan hasil tani.',
                'foto' => asset('asset/kop_257.jpg'),
            ],
            [
                'fase' => 'FASE 6',
                'tanggal' => '19 Juli 2025',
                'judul' => 'Menuju Kick-Off Peluncuran Nasional',
                'lokasi' => 'KMP Kelurahan Atang Senjaya, Kec. Kemang',
                'deskripsi' => 'Kesiapan operasional penuh 435 Koperasi Merah Putih menyongsong puncak peringatan Hari Koperasi Nasional 2025.',
                'foto' => asset('asset/kop_32.jpg'),
            ],
        ];

        // Data Geospasial Koperasi beserta Gerai Aktif untuk Filter Peta
        $koperasiList = Koperasi::select([
            'id_koperasi', 'name_koperasi', 'id_kec', 'id_kel', 'gps_lat', 'gps_long', 'kop_addr', 'kop_telp',
            'id_koperasitype1', 'id_koperasitype2', 'id_koperasitype3', 'id_koperasitype4', 'id_koperasitype5',
            'id_koperasitype6', 'id_koperasitype7', 'id_koperasitype8', 'id_koperasitype9', 'id_koperasitype10',
            'id_koperasitype11', 'id_koperasitype12', 'id_koperasitype13',
        ])->with(['kecamatan:id_kopkec,name_kopkec', 'kelurahan:id_kopkel,name_kopkel'])->get();

        $koperasiMapPoints = [];
        foreach ($koperasiList as $k) {
            $activeTypes = [];
            for ($i = 1; $i <= 13; $i++) {
                if ($k->{'id_koperasitype'.$i} === 'Yes') {
                    $activeTypes[] = $i;
                }
            }
            $koperasiMapPoints[] = [
                'id' => (int) $k->id_koperasi,
                'nama' => (string) $k->name_koperasi,
                'kecamatan' => (string) ($k->kecamatan?->name_kopkec ?? ''),
                'id_kec' => (int) $k->id_kec,
                'desa' => (string) ($k->kelurahan?->name_kopkel ?? ''),
                'lat' => (float) $k->gps_lat,
                'lng' => (float) $k->gps_long,
                'alamat' => (string) ($k->kop_addr ?? ''),
                'telp' => (string) ($k->kop_telp ?? ''),
                'types' => $activeTypes,
            ];
        }

        $jenisUsaha = [
            ['nama' => 'Kios Mini Cafe', 'jumlah' => 224, 'persentase' => 51.49, 'color' => 'bg-emerald-500'],
            ['nama' => 'Gerai Kantor Koperasi', 'jumlah' => 154, 'persentase' => 35.40, 'color' => 'bg-rose-500'],
            ['nama' => 'Gerai Sembako', 'jumlah' => 72, 'persentase' => 16.55, 'color' => 'bg-blue-500'],
            ['nama' => 'Pangkalan LPG', 'jumlah' => 5, 'persentase' => 1.15, 'color' => 'bg-cyan-500'],
            ['nama' => 'Gerai Apotek Desa', 'jumlah' => 0, 'persentase' => 0.00, 'color' => 'bg-slate-300'],
            ['nama' => 'Kios Pupuk & Simpan Pinjam', 'jumlah' => 8, 'persentase' => 1.84, 'color' => 'bg-amber-500'],
            ['nama' => 'Logistik & Cold Chain', 'jumlah' => 2, 'persentase' => 0.46, 'color' => 'bg-indigo-500'],
        ];

        $sdmKoperasi = [
            ['no' => 1, 'kategori' => 'Pengurus Domisili', 'jumlah' => 2610, 'persen' => '11.14%'],
            ['no' => 2, 'kategori' => 'Pengawas Koperasi', 'jumlah' => 1305, 'persen' => '5.57%'],
            ['no' => 3, 'kategori' => 'Anggota Koperasi', 'jumlah' => 19513, 'persen' => '83.29%'],
        ];
        $totalSdm = 23428;

        // Dokumen Progres & Laporan dari folder informasi
        $informasiDir = base_path('informasi');
        $informasiFiles = [];
        if (is_dir($informasiDir)) {
            $files = glob($informasiDir.'/*.*');
            foreach ($files as $file) {
                $filename = basename($file);
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                $informasiFiles[] = [
                    'filename' => $filename,
                    'title' => 'DATA PROGRES PEMBANGUNAN KDKMP',
                    'subtitle' => 'LAPJUSIK DIM 0621 &bull; 24 MARET 2026',
                    'size' => round(filesize($file) / 1024 / 1024, 2).' MB',
                    'ext' => $ext,
                    'url' => route('informasi.file', $filename),
                ];
            }
        }

        return view('dashboard', compact(
            'kecamatans',
            'totalDesa',
            'totalKelurahan',
            'totalKoperasi',
            'fasilitasOptions',
            'timelineSlides',
            'koperasiMapPoints',
            'jenisUsaha',
            'sdmKoperasi',
            'totalSdm',
            'informasiFiles'
        ));
    }

    /**
     * Get detail of a specific kecamatan with its cooperatives list and map points.
     */
    public function show(Kecamatan $kecamatan): View|JsonResponse
    {
        $koperasis = Koperasi::where('id_kec', $kecamatan->id_kopkec)
            ->with(['kelurahan'])
            ->orderBy('id_koperasi')
            ->get();

        $koperasiPoints = $koperasis->map(function ($k) {
            return [
                'id' => (int) $k->id_koperasi,
                'nama' => (string) $k->name_koperasi,
                'desa' => (string) ($k->kelurahan?->name_kopkel ?? ''),
                'lat' => (float) $k->gps_lat,
                'lng' => (float) $k->gps_long,
                'alamat' => (string) ($k->kop_addr ?? ''),
                'telp' => (string) ($k->kop_telp ?? ''),
                'status' => (string) ($k->st_ops ?? 'SUDAH'),
            ];
        });

        if (request()->wantsJson() || request()->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'nama' => $kecamatan->name_kopkec,
                    'jumlah' => $koperasis->count(),
                    'koperasis' => $koperasiPoints,
                ],
            ]);
        }

        return view('kecamatan.show', compact('kecamatan', 'koperasis', 'koperasiPoints'));
    }

    /**
     * Get profile detail of a specific koperasi with pengurus, stats, and photos.
     */
    public function showKoperasi(Koperasi $koperasi): View
    {
        $koperasi->load(['kecamatan', 'kelurahan', 'sdms']);

        // Find pengurus (Ketua, Sekretaris, Bendahara)
        $ketua = $koperasi->sdms->first(fn ($s) => stripos($s->jab_kopsdm, 'KETUA') !== false && stripos($s->jab_kopsdm, 'WAKIL') === false && stripos($s->jab_kopsdm, 'PENGAWAS') === false);
        $sekretaris = $koperasi->sdms->first(fn ($s) => stripos($s->jab_kopsdm, 'SEKRETARIS') !== false && stripos($s->jab_kopsdm, 'WAKIL') === false);
        $bendahara = $koperasi->sdms->first(fn ($s) => stripos($s->jab_kopsdm, 'BENDAHARA') !== false && stripos($s->jab_kopsdm, 'WAKIL') === false);

        // Helper to find photo from root asset or public/asset with fallback
        $getPhoto = function (string $prefix, int $id, string $fallback): string {
            $extensions = ['jpg', 'jpeg', 'png', 'webp', 'JPG', 'JPEG', 'PNG'];
            foreach ($extensions as $ext) {
                $file = "asset/{$prefix}_{$id}.{$ext}";
                if (file_exists(base_path($file)) || file_exists(public_path($file))) {
                    return asset($file);
                }
            }

            return asset("asset/{$fallback}");
        };

        $fotoKetua = $getPhoto('kakop', $koperasi->id_koperasi, 'kakop_0.png');
        $fotoSekretaris = $getPhoto('sekkop', $koperasi->id_koperasi, 'sekkop_0.png');
        $fotoBendahara = $getPhoto('benkop', $koperasi->id_koperasi, 'benkop_0.png');
        $fotoGedung = $getPhoto('kop', $koperasi->id_koperasi, 'kop_0.png');

        // Additional gallery photos if available
        $additionalGallery = [];
        foreach (['dtkop1', 'dtkop2', 'dtkop3'] as $dt) {
            foreach (['jpg', 'jpeg', 'png', 'webp', 'JPG', 'JPEG', 'PNG'] as $ext) {
                $file = "asset/{$dt}_{$koperasi->id_koperasi}.{$ext}";
                if (file_exists(base_path($file)) || file_exists(public_path($file))) {
                    $additionalGallery[] = asset($file);
                    break;
                }
            }
        }

        // 13 Jenis Usaha mapping
        $jenisUsahaList = [
            ['nama' => 'GERAI SEMBAKO', 'status' => strtolower((string) $koperasi->id_koperasitype1) === 'yes'],
            ['nama' => 'GERAI APOTEK DESA', 'status' => strtolower((string) $koperasi->id_koperasitype2) === 'yes'],
            ['nama' => 'GERAI KANTOR KOPERASI', 'status' => strtolower((string) $koperasi->id_koperasitype3) === 'yes'],
            ['nama' => 'GERAI UNIT USAHA SIMPAN PINJAM', 'status' => strtolower((string) $koperasi->id_koperasitype4) === 'yes'],
            ['nama' => 'GERAI KLINIK DESA', 'status' => strtolower((string) $koperasi->id_koperasitype5) === 'yes'],
            ['nama' => 'GERAI COLD STORAGE/COLD CHAIN', 'status' => strtolower((string) $koperasi->id_koperasitype6) === 'yes'],
            ['nama' => 'GERAI LOGISTIK (DISTRIBUSI)', 'status' => strtolower((string) $koperasi->id_koperasitype7) === 'yes'],
            ['nama' => 'GERAI USAHA LAINNYA (KBLI 2020)', 'status' => strtolower((string) $koperasi->id_koperasitype8) === 'yes'],
            ['nama' => 'GERAI KIOS PUPUK', 'status' => strtolower((string) $koperasi->id_koperasitype9) === 'yes'],
            ['nama' => 'GERAI PANGKALAN LPG', 'status' => strtolower((string) $koperasi->id_koperasitype10) === 'yes'],
            ['nama' => 'GERAI AGEN POS INDONESIA', 'status' => strtolower((string) $koperasi->id_koperasitype11) === 'yes'],
            ['nama' => 'GERAI AGEN LAKU PANDAI', 'status' => strtolower((string) $koperasi->id_koperasitype12) === 'yes'],
            ['nama' => 'AKUN MICROSITE', 'status' => strtolower((string) $koperasi->id_koperasitype13) === 'yes'],
        ];

        return view('koperasi.show', compact(
            'koperasi',
            'ketua',
            'sekretaris',
            'bendahara',
            'fotoKetua',
            'fotoSekretaris',
            'fotoBendahara',
            'fotoGedung',
            'additionalGallery',
            'jenisUsahaList'
        ));
    }

    /**
     * Export rekapitulasi data as CSV/Excel compatible file.
     */
    public function export(): StreamedResponse
    {
        $kecamatans = Kecamatan::orderBy('id_kopkec')->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="Rekapitulasi_KMP_Kabupaten_Bogor_2025.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($kecamatans) {
            $handle = fopen('php://output', 'w');

            // BOM for UTF-8 Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header Row
            fputcsv($handle, ['No', 'Kecamatan', 'Kop. Desa', 'Kop. Kelurahan', 'Total Koperasi', 'Status', 'Daftar Desa/Kelurahan']);

            foreach ($kecamatans as $item) {
                fputcsv($handle, [
                    $item->nomor_urut,
                    $item->nama,
                    $item->kop_desa,
                    $item->kop_kel,
                    $item->jumlah,
                    $item->status,
                    is_array($item->daftar_desa) ? implode(', ', $item->daftar_desa) : '',
                ]);
            }

            // Summary row
            fputcsv($handle, [
                '',
                'TOTAL KESELURUHAN (KABUPATEN BOGOR)',
                $kecamatans->sum('kop_desa'),
                $kecamatans->sum('kop_kel'),
                $kecamatans->sum('jumlah'),
                '100% Aktif',
                '',
            ]);

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
