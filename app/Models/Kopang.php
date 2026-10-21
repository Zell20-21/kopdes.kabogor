<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kopang extends Model
{
    protected $table = 'app_md_kopang';

    protected $primaryKey = 'id_kopang';

    public $timestamps = false;

    protected $fillable = [
        'id_kopang',
        'name_kopang',
        'nik_kopang',
        'id_kec',
        'id_kel',
        'id_koperasi',
        'id_kopangtype',
        'comt_kopang',
        'kopang_usaha',
        'kopang_addr',
        'kopang_telp',
        'gps_lat',
        'gps_long',
        'id_user',
        'tgl_data',
        'flag_del',
    ];

    protected function casts(): array
    {
        return [
            'nik_kopang' => 'encrypted',
        ];
    }

    public function koperasi(): BelongsTo
    {
        return $this->belongsTo(Koperasi::class, 'id_koperasi', 'id_koperasi');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(KopangType::class, 'id_kopangtype', 'id_kopangtype');
    }
}
