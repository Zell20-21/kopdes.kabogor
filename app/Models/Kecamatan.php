<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'nomor_urut',
        'nama',
        'kop_desa',
        'kop_kel',
        'jumlah',
        'latitude',
        'longitude',
        'status',
        'daftar_desa',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'nomor_urut' => 'integer',
        'kop_desa' => 'integer',
        'kop_kel' => 'integer',
        'jumlah' => 'integer',
        'latitude' => 'float',
        'longitude' => 'float',
        'daftar_desa' => 'array',
    ];
}
