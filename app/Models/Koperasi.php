<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Koperasi extends Model
{
    protected $table = 'app_md_koperasi';

    protected $primaryKey = 'id_koperasi';

    public $timestamps = false;

    protected $guarded = [];

    protected $appends = [
        'id',
        'nama_koperasi',
        'kecamatan_nama',
        'desa_nama',
        'alamat',
        'status_operasional',
        'status_pelatihan',
        'status_sertifikat',
        'jenis_koperasi',
        'jumlah_anggota',
    ];

    public function getIdAttribute(): int
    {
        return (int) $this->id_koperasi;
    }

    public function getNamaKoperasiAttribute(): string
    {
        return (string) $this->name_koperasi;
    }

    public function getKecamatanNamaAttribute(): string
    {
        return (string) ($this->kecamatan?->name_kopkec ?? '');
    }

    public function getDesaNamaAttribute(): string
    {
        return (string) ($this->kelurahan?->name_kopkel ?? '');
    }

    public function getAlamatAttribute(): string
    {
        return (string) $this->kop_addr;
    }

    public function getStatusOperasionalAttribute(): string
    {
        return (string) $this->st_ops;
    }

    public function getStatusPelatihanAttribute(): string
    {
        return (string) $this->st_latih;
    }

    public function getStatusSertifikatAttribute(): string
    {
        return (string) $this->st_sertifikat;
    }

    public function getJenisKoperasiAttribute(): string
    {
        return (string) $this->cat_koperasi;
    }

    public function getJumlahAnggotaAttribute(): int
    {
        return (int) $this->jum_anggota;
    }

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'id_kec', 'id_kopkec');
    }

    public function kelurahan(): BelongsTo
    {
        return $this->belongsTo(Kelurahan::class, 'id_kel', 'id_kopkel');
    }

    public function sdms(): HasMany
    {
        return $this->hasMany(Kopsdm::class, 'id_koperasi', 'id_koperasi');
    }
}
