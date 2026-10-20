<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kopsdm extends Model
{
    protected $table = 'app_md_kopsdm';

    protected $primaryKey = 'id_kopsdm';

    public $timestamps = false;

    protected $guarded = [];

    public function koperasi(): BelongsTo
    {
        return $this->belongsTo(Koperasi::class, 'id_koperasi', 'id_koperasi');
    }
}
