<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kecamatan extends Model
{
    protected $table = 'app_md_kopkec';

    protected $primaryKey = 'id_kopkec';

    public $timestamps = false;

    protected $guarded = [];

    protected $appends = [
        'nomor_urut',
        'nama',
        'kop_desa',
        'kop_kel',
        'jumlah',
        'status',
        'daftar_desa',
        'latitude',
        'longitude',
    ];

    public function getNomorUrutAttribute(): int
    {
        return (int) $this->id_kopkec;
    }

    public function getNamaAttribute(): string
    {
        return (string) $this->name_kopkec;
    }

    public function getJumlahAttribute(): int
    {
        return (int) ($this->jum_koperasi ?: $this->koperasis()->count());
    }

    public function getKopDesaAttribute(): int
    {
        return (int) $this->koperasis()->where('cat_koperasi', 'KOPERASI DESA')->count();
    }

    public function getKopKelAttribute(): int
    {
        return (int) $this->koperasis()->where('cat_koperasi', 'KOPERASI KELURAHAN')->count();
    }

    public function getStatusAttribute(): string
    {
        return '100% Terbentuk';
    }

    public function getDaftarDesaAttribute(): array
    {
        return $this->kelurahans()->pluck('name_kopkel')->toArray();
    }

    public function getLatitudeAttribute(): float
    {
        $lat = $this->koperasis()->where('gps_lat', '!=', '')->where('gps_lat', '!=', '0')->value('gps_lat');

        return $lat ? (float) $lat : -6.5950;
    }

    public function getLongitudeAttribute(): float
    {
        $long = $this->koperasis()->where('gps_long', '!=', '')->where('gps_long', '!=', '0')->value('gps_long');

        return $long ? (float) $long : 106.7900;
    }

    public function kelurahans(): HasMany
    {
        return $this->hasMany(Kelurahan::class, 'id_kopkec', 'id_kopkec');
    }

    public function koperasis(): HasMany
    {
        return $this->hasMany(Koperasi::class, 'id_kec', 'id_kopkec');
    }
}
