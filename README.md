# Dashboard KMP Kabupaten Bogor (Koperasi Merah Putih)

Dashboard Koperasi Desa / Kelurahan Merah Putih (KDKMP) Kabupaten Bogor - Pemerintah Daerah Kabupaten Bogor.

## 📌 Deskripsi

Aplikasi web berbasis **Laravel 12 & Leaflet.js** untuk memvisualisasikan capaian agregat, diversifikasi usaha, demografi sumber daya manusia, serta pemetaan geospasial sebaran Koperasi Merah Putih di 40 Kecamatan se-Kabupaten Bogor (416 Desa dan 19 Kelurahan).

## 🚀 Fitur Utama

- **Capaian Agregat Kabupaten Bogor**:
  - 435 Koperasi Terbentuk (Target 100% Tercapai)
  - 100% Keaktifan dengan kepemilikan gedung & anggota tetap
  - 6 Fasilitas Utama: Kantor Koperasi, Gerai Sembako, Klinik & Apotek, Simpan Pinjam, Cold Storage, Logistik & LPG
- **Informasi Statistik**:
  - Potensi satuan administratif (416 Desa + 19 Kelurahan)
  - Diversifikasi 7 unit usaha
  - Demografi 23,428 personil SDM Koperasi
- **Pemetaan Geospasial Wilayah (Leaflet.js)**:
  - Khusus mencakup wilayah administratif Kabupaten Bogor (dengan batasan koordinat & poligon batas wilayah)
  - 40 Pin marker interaktif di setiap kecamatan dengan indikator jumlah koperasi
  - Popup interaktif dengan rincian desa & kelurahan
  - Multi-layer: Peta POS, Citra Satelit, dan Topografi
  - Filter interaktif per kecamatan
- **Rekapitulasi Sebaran Per Kecamatan**:
  - Tabel 2 kolom paralel (40 Kecamatan lengkap)
  - Live search filter nama kecamatan
  - Total Keseluruhan 435 Koperasi
- **Ekspor Data**:
  - Export data sebaran format CSV / Excel kompatibel

## 🛠️ Instalasi & Menjalankan Lokal

1. Clone repositori:
   ```bash
   git clone https://github.com/Zell20-21/kopdes.kabogor.git
   cd kopdes.kabogor
   ```

2. Instal dependensi PHP:
   ```bash
   composer install
   ```

3. Instal dependensi Node & build asset:
   ```bash
   npm install
   npm run build
   ```

4. Konfigurasi Environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Migrasi & Seeding Data:
   ```bash
   php artisan migrate:fresh --seed
   ```

6. Jalankan server:
   ```bash
   php artisan serve
   ```
   Buka di peramban: `http://127.0.0.1:8000`
