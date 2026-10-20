<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\Koperasi;
use Illuminate\Database\Seeder;
use PDO;

class KoperasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Don't truncate if table already populated
        if (Koperasi::count() > 0) {
            return;
        }

        // Try querying from local MySQL kdkmp_dbkoperasi
        try {
            $pdo = new PDO('mysql:host=127.0.0.1;dbname=kdkmp_dbkoperasi;charset=utf8mb4', 'root', '', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);

            $stmt = $pdo->query('SELECT * FROM app_md_koperasi ORDER BY id_koperasi ASC');
            $rows = $stmt->fetchAll();

            if (! empty($rows)) {
                $batch = [];
                foreach ($rows as $row) {
                    $batch[] = [
                        'id_koperasi' => (int) $row['id_koperasi'],
                        'name_koperasi' => $row['name_koperasi'],
                        'id_kec' => (int) $row['id_kec'],
                        'id_kel' => (int) $row['id_kel'],
                        'kop_addr' => $row['kop_addr'] ?? '',
                        'kop_telp' => $row['kop_telp'] ?? '',
                        'kop_mail' => $row['kop_mail'] ?? '',
                        'st_ops' => $row['st_ops'] ?? 'SUDAH',
                        'st_latih' => $row['st_latih'] ?? 'BELUM',
                        'st_sertifikat' => $row['st_sertifikat'] ?? 'SUDAH',
                        'cat_koperasi' => $row['cat_koperasi'] ?? 'KOPERASI DESA',
                        'no_ahu' => $row['no_ahu'] ?? '',
                        'no_inkop' => $row['no_inkop'] ?? '',
                        'jum_pengurus' => (int) ($row['jum_pengurus'] ?? 5),
                        'jum_pengawas' => (int) ($row['jum_pengawas'] ?? 3),
                        'jum_anggota' => (int) ($row['jum_anggota'] ?? 0),
                    ];

                    if (count($batch) >= 100) {
                        Koperasi::insert($batch);
                        $batch = [];
                    }
                }

                if (! empty($batch)) {
                    Koperasi::insert($batch);
                }

                return;
            }
        } catch (\Throwable $e) {
            // Fallback generation based on all 435 registered villages and 40 sub-districts
            $kecamatans = Kecamatan::with('kelurahans')->orderBy('id_kopkec', 'asc')->get();
            $koperasiId = 1;
            $batch = [];

            // Exact data overrides for preview accuracy based on official Diskop records
            $exactOverrides = [
                1 => ['nikop' => '3201140020005', 'ahu' => 'AHU-0011857.AH.01.29.TAHUN 2025', 'tgl' => '2025-06-03'],
                2 => ['nikop' => '3201140030003', 'ahu' => 'AHU-0000305.AH.01.29.TAHUN 2025', 'tgl' => '2025-05-22'],
                3 => ['nikop' => '3201140040004', 'ahu' => 'AHU-0017591.AH.01.29.TAHUN 2025', 'tgl' => '2025-06-03'],
                4 => ['nikop' => '3201140050007', 'ahu' => 'AHU-0016983.AH.01.29.TAHUN 2025', 'tgl' => '2025-06-03'],
                5 => ['nikop' => '3201140060004', 'ahu' => 'AHU-0016419.AH.01.29.TAHUN 2025', 'tgl' => '2025-06-02'],
                6 => ['nikop' => '3201140070006', 'ahu' => 'AHU-0004902.AH.01.29.TAHUN 2025', 'tgl' => '2025-05-22'],
                7 => ['nikop' => '3201140080009', 'ahu' => 'AHU-0004848.AH.01.29.TAHUN 2025', 'tgl' => '2025-05-22'],
                8 => ['nikop' => '3201140090009', 'ahu' => 'AHU-0009980.AH.01.29.TAHUN 2025', 'tgl' => '2025-05-28'],
                9 => ['nikop' => '3201140100005', 'ahu' => 'AHU-0015933.AH.01.29.TAHUN 2025', 'tgl' => '2025-06-02'],
                10 => ['nikop' => '3201230020010', 'ahu' => 'AHU-0012301.AH.01.29.TAHUN 2025', 'tgl' => '2025-05-30'],
                11 => ['nikop' => '3201230090008', 'ahu' => 'AHU-0007548.AH.01.29.TAHUN 2025', 'tgl' => '2025-05-26'],
                12 => ['nikop' => '3201230030011', 'ahu' => 'AHU-0011928.AH.01.29.TAHUN 2025', 'tgl' => '2025-05-30'],
                13 => ['nikop' => '3201230050013', 'ahu' => 'AHU-0016531.AH.01.29.TAHUN 2025', 'tgl' => '2025-06-02'],
                14 => ['nikop' => '3201230040014', 'ahu' => 'AHU-0013876.AH.01.29.TAHUN 2025', 'tgl' => '2025-05-30'],
                15 => ['nikop' => '3201230060006', 'ahu' => 'AHU-0016304.AH.01.29.TAHUN 2025', 'tgl' => '2025-06-02'],
                16 => ['nikop' => '3201230080017', 'ahu' => 'AHU-0012319.AH.01.29.TAHUN 2025', 'tgl' => '2025-05-30'],
                17 => ['nikop' => '3201230070004', 'ahu' => 'AHU-0012429.AH.01.29.TAHUN 2025', 'tgl' => '2025-05-30'],
                18 => ['nikop' => '3201230010033', 'ahu' => 'AHU-0011809.AH.01.29.TAHUN 2025', 'tgl' => '2025-05-26'],
                19 => ['nikop' => '3201090020049', 'ahu' => 'AHU-0003239.AH.01.29.TAHUN 2025', 'tgl' => '2025-05-16'],
                20 => ['nikop' => '3201090050017', 'ahu' => 'AHU-0003881.AH.01.29.TAHUN 2025', 'tgl' => '2025-05-20'],
                21 => ['nikop' => '3201090040018', 'ahu' => 'AHU-0004456.AH.01.29.TAHUN 2025', 'tgl' => '2025-05-21'],
                22 => ['nikop' => '3201090060002', 'ahu' => 'AHU-0008865.AH.01.29.TAHUN 2025', 'tgl' => '2025-05-27'],
                23 => ['nikop' => '3201090090044', 'ahu' => 'AHU-0008852.AH.01.29.TAHUN 2025', 'tgl' => '2025-05-27'],
                24 => ['nikop' => '3201090070048', 'ahu' => 'AHU-0005918.AH.01.29.TAHUN 2025', 'tgl' => '2025-05-26'],
                25 => ['nikop' => '3201090080028', 'ahu' => 'AHU-0006068.AH.01.29.TAHUN 2025', 'tgl' => '2025-05-26'],
            ];

            // Sub-district approximate centers for GIS spread
            $kecGeo = [
                1 => [-6.5516, 106.8797], 2 => [-6.4958, 106.7972], 3 => [-6.6975, 106.8378],
                4 => [-6.5383, 107.1325], 5 => [-6.5542, 106.7028], 6 => [-6.6575, 106.8525],
                7 => [-6.4828, 106.8486], 8 => [-6.5861, 106.6667], 9 => [-6.7411, 106.8153],
                10 => [-6.5417, 106.5389], 11 => [-6.6853, 106.7867], 12 => [-6.3986, 106.9625],
                13 => [-6.6028, 106.7622], 14 => [-6.6958, 106.9328], 15 => [-6.4528, 106.7083],
                16 => [-6.4883, 106.8789], 17 => [-6.5806, 106.7361], 18 => [-6.4183, 106.9056],
                19 => [-6.3889, 106.6944], 20 => [-6.4889, 106.4583], 21 => [-6.4714, 107.0544],
                22 => [-6.5056, 106.7486], 23 => [-6.4528, 106.9583], 24 => [-6.5778, 106.6278],
                25 => [-6.5986, 106.5986], 26 => [-6.6431, 106.9083], 27 => [-6.6389, 106.5333],
                28 => [-6.6639, 106.6778], 29 => [-6.4222, 106.7333], 30 => [-6.3639, 106.5667],
                31 => [-6.5264, 106.7111], 32 => [-6.4889, 106.6472], 33 => [-6.5861, 106.4972],
                34 => [-6.5750, 107.0278], 35 => [-6.5722, 106.8389], 36 => [-6.4639, 106.7667],
                37 => [-6.6472, 106.7639], 38 => [-6.6083, 107.1583], 39 => [-6.3778, 106.4861],
                40 => [-6.6194, 106.7111],
            ];

            foreach ($kecamatans as $kec) {
                $center = $kecGeo[$kec->id_kopkec] ?? [-6.5950, 106.7900];
                $desaList = $kec->kelurahans()->orderBy('id_kopkel', 'asc')->get();
                $idx = 0;

                foreach ($desaList as $desa) {
                    $isKel = str_starts_with(strtoupper($desa->name_kopkel), 'KEL.');
                    $cleanDesa = trim(str_replace(['KEL.', 'KEL '], '', strtoupper($desa->name_kopkel)));
                    $cat = $isKel ? 'KOPERASI KELURAHAN' : 'KOPERASI DESA';
                    $prefix = $isKel ? 'KOPERASI KELURAHAN MERAH PUTIH ' : 'KOPERASI DESA MERAH PUTIH ';
                    $fullName = $prefix.$cleanDesa.' KECAMATAN '.strtoupper($kec->name_kopkec);

                    // Coordinate jitter around subdistrict center
                    $angle = ($idx * 37) * (M_PI / 180);
                    $dist = 0.008 + (($idx % 5) * 0.004);
                    $lat = $center[0] + (sin($angle) * $dist);
                    $long = $center[1] + (cos($angle) * $dist);

                    $override = $exactOverrides[$koperasiId] ?? null;
                    $nikop = $override['nikop'] ?? ('3201'.str_pad($kec->id_kopkec, 2, '0', STR_PAD_LEFT).str_pad($desa->id_kopkel, 3, '0', STR_PAD_LEFT).str_pad($koperasiId, 4, '0', STR_PAD_LEFT));
                    $ahu = $override['ahu'] ?? ('AHU-00'.str_pad(3000 + ($koperasiId * 37), 5, '0', STR_PAD_LEFT).'.AH.01.29.TAHUN 2025');
                    $tgl = $override['tgl'] ?? date('Y-m-d', strtotime('2025-05-15 +'.($koperasiId % 20).' days'));

                    $batch[] = [
                        'id_koperasi' => $koperasiId,
                        'name_koperasi' => $fullName,
                        'id_kec' => $kec->id_kopkec,
                        'id_kel' => $desa->id_kopkel,
                        'kop_addr' => 'Kabupaten Bogor, Jawa Barat',
                        'kop_telp' => '08'.rand(1111111111, 9999999999),
                        'kop_mail' => 'kmp.'.strtolower(str_replace(' ', '', $cleanDesa)).'@bogorkab.go.id',
                        'st_ops' => 'SUDAH',
                        'st_latih' => ($koperasiId <= 2) ? 'SUDAH' : 'BELUM',
                        'st_sertifikat' => 'SUDAH',
                        'cat_koperasi' => $cat,
                        'no_ahu' => $ahu,
                        'no_inkop' => $nikop,
                        'tgl_ahu' => $tgl,
                        'gps_lat' => number_format($lat, 6, '.', ''),
                        'gps_long' => number_format($long, 6, '.', ''),
                        'jum_pengurus' => 5,
                        'jum_pengawas' => 3,
                        'jum_anggota' => 0,
                    ];

                    $koperasiId++;
                    $idx++;
                }
            }

            foreach (array_chunk($batch, 100) as $chunk) {
                Koperasi::insert($chunk);
            }
        }
    }
}
