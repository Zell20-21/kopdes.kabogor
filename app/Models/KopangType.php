<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KopangType extends Model
{
    protected $table = 'app_md_kopangtype';

    protected $primaryKey = 'id_kopangtype';

    public $timestamps = false;

    protected $fillable = [
        'id_kopangtype',
        'name_kopangtype',
        'comt_kopangtype',
        'id_user',
        'tgl_data',
        'flag_del',
    ];
}
