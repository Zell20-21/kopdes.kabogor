<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('app_md_kopangtype')) {
            Schema::create('app_md_kopangtype', function (Blueprint $table) {
                $table->integer('id_kopangtype')->primary();
                $table->string('name_kopangtype');
                $table->string('comt_kopangtype')->default('-');
                $table->integer('id_user')->default(1);
                $table->dateTime('tgl_data')->nullable();
                $table->tinyInteger('flag_del')->default(0);
            });
        }

        if (! Schema::hasTable('app_md_kopang')) {
            Schema::create('app_md_kopang', function (Blueprint $table) {
                $table->integer('id_kopang')->primary();
                $table->string('name_kopang');
                $table->integer('id_kec')->default(0);
                $table->integer('id_kel')->default(0);
                $table->integer('id_koperasi')->default(0)->index();
                $table->integer('id_kopangtype')->default(1);
                $table->string('comt_kopang')->default('-');
                $table->string('kopang_usaha')->default('');
                $table->string('kopang_addr')->default('');
                $table->string('kopang_telp')->default('');
                $table->string('gps_lat')->default('');
                $table->string('gps_long')->default('');
                $table->integer('id_user')->nullable();
                $table->dateTime('tgl_data')->nullable();
                $table->tinyInteger('flag_del')->default(0);
            });
        }

        foreach ([
            'Industri UMKM',
            'Pedagang UMKM',
            'Pengrajin UMKM',
            'Petani',
            'Buruh Lepas',
            'Pegawai/Karyawan',
            'Lainnya',
        ] as $index => $name) {
            DB::table('app_md_kopangtype')->insertOrIgnore([
                'id_kopangtype' => $index + 1,
                'name_kopangtype' => $name,
                'comt_kopangtype' => '-',
                'id_user' => 1,
                'tgl_data' => now(),
                'flag_del' => 0,
            ]);
        }

        if (! Schema::hasColumn('app_md_kopang', 'nik_kopang')) {
            Schema::table('app_md_kopang', function (Blueprint $table) {
                $table->text('nik_kopang')->nullable();
            });
        }

        if (! Schema::hasColumn('app_md_kopsdm', 'foto_kopsdm')) {
            Schema::table('app_md_kopsdm', function (Blueprint $table) {
                $table->string('foto_kopsdm')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Keep member and photo data intact when rolling back.
    }
};
