<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Koperasi extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'kecamatan',
        'alamat',
        'telepon',
        'email',
        'status_operasional',
        'status_pelatihan',
        'status_sertifikat',
        'nama_notaris',
        'no_ahu',
        'no_inkop',
        'jum_pengurus',
        'jum_pengawas',
        'jum_anggota',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'jum_pengurus' => 'integer',
        'jum_pengawas' => 'integer',
        'jum_anggota' => 'integer',
    ];
}
