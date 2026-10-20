<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
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

        $fasilitas = [
            [
                'nama' => 'Kantor Koperasi',
                'icon' => 'fa-solid fa-building-columns',
                'bg' => 'bg-blue-50 text-blue-700 border-blue-200',
            ],
            [
                'nama' => 'Gerai Sembako',
                'icon' => 'fa-solid fa-store',
                'bg' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            ],
            [
                'nama' => 'Klinik & Apotek',
                'icon' => 'fa-solid fa-kit-medical',
                'bg' => 'bg-rose-50 text-rose-700 border-rose-200',
            ],
            [
                'nama' => 'Simpan Pinjam',
                'icon' => 'fa-solid fa-hand-holding-dollar',
                'bg' => 'bg-violet-50 text-violet-700 border-violet-200',
            ],
            [
                'nama' => 'Cold Storage',
                'icon' => 'fa-solid fa-snowflake',
                'bg' => 'bg-cyan-50 text-cyan-700 border-cyan-200',
            ],
            [
                'nama' => 'Logistik & LPG',
                'icon' => 'fa-solid fa-truck-ramp-box',
                'bg' => 'bg-amber-50 text-amber-700 border-amber-200',
            ],
        ];

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
            'fasilitas',
            'jenisUsaha',
            'sdmKoperasi',
            'totalSdm',
            'informasiFiles'
        ));
    }

    /**
     * Get detail of a specific kecamatan.
     */
    public function show(Kecamatan $kecamatan): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $kecamatan,
        ]);
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
