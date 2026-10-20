<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kelurahan extends Model
{
    protected $table = 'app_md_kopkel';

    protected $primaryKey = 'id_kopkel';

    public $timestamps = false;

    protected $guarded = [];

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'id_kopkec', 'id_kopkec');
    }

    public function koperasi(): HasOne
    {
        return $this->hasOne(Koperasi::class, 'id_kel', 'id_kopkel');
    }
}
