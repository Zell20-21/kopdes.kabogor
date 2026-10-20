<?php

namespace Database\Seeders;

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
            // fallback for test environments without MySQL
            for ($i = 1; $i <= 435; $i++) {
                $ops = ($i === 1) ? 'BELUM' : 'SUDAH';
                $latih = ($i <= 2) ? 'SUDAH' : 'BELUM';
                $sertifikat = ($i === 1) ? 'BELUM' : 'SUDAH';

                Koperasi::create([
                    'id_koperasi' => $i,
                    'name_koperasi' => "KOPERASI MERAH PUTIH UNIT {$i}",
                    'id_kec' => ($i % 40) + 1,
                    'id_kel' => $i,
                    'kop_addr' => 'Kabupaten Bogor, Jawa Barat',
                    'kop_telp' => '081234567890',
                    'kop_mail' => 'kdkmp@bogorkab.go.id',
                    'st_ops' => $ops,
                    'st_latih' => $latih,
                    'st_sertifikat' => $sertifikat,
                    'cat_koperasi' => ($i % 20 === 0) ? 'KOPERASI KELURAHAN' : 'KOPERASI DESA',
                    'no_ahu' => "AHU-{$i}.AH.01.29.TAHUN 2025",
                    'no_inkop' => "32010000{$i}",
                    'jum_pengurus' => 5,
                    'jum_pengawas' => 3,
                    'jum_anggota' => 0,
                ]);
            }
        }
    }
}
