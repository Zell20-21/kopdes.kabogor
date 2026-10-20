<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('app_md_kopkec')) {
            Schema::create('app_md_kopkec', function (Blueprint $table) {
                $table->integer('id_kopkec')->primary();
                $table->integer('id_kab')->default(158);
                $table->integer('id_kopwil')->default(1);
                $table->string('code_kopkec', 10)->default('');
                $table->string('name_kopkec', 255);
                $table->integer('jum_desa')->default(0);
                $table->integer('jum_koperasi')->default(0);
                $table->tinyInteger('flag_del')->default(0);
            });
        }

        if (! Schema::hasTable('app_md_kopkel')) {
            Schema::create('app_md_kopkel', function (Blueprint $table) {
                $table->integer('id_kopkel')->primary();
                $table->integer('id_kopkec')->default(0);
                $table->string('code_kopkec', 10)->default('');
                $table->string('code_kopkel', 10)->default('');
                $table->string('name_kopkel', 255);
                $table->integer('jum_koperasi')->default(0);
                $table->tinyInteger('flag_del')->default(0);
            });
        }

        if (! Schema::hasTable('app_md_koperasi')) {
            Schema::create('app_md_koperasi', function (Blueprint $table) {
                $table->integer('id_koperasi')->primary();
                $table->string('name_koperasi', 255);
                $table->integer('id_kec')->default(0);
                $table->integer('id_kel')->default(0);
                $table->string('kop_addr', 255)->default('');
                $table->string('kop_web', 255)->nullable();
                $table->string('kop_mail', 255)->default('');
                $table->string('kop_telp', 255)->default('');
                $table->string('st_ops', 255)->default('SUDAH');
                $table->string('st_latih', 255)->default('BELUM');
                $table->string('st_sertifikat', 255)->default('SUDAH');
                $table->string('gps_lat', 255)->default('-6.5950');
                $table->string('gps_long', 255)->default('106.7900');
                $table->string('cat_koperasi', 255)->default('KOPERASI DESA');
                $table->integer('thn_berdiri')->default(2025);
                $table->string('no_sertifikat', 255)->default('-');
                $table->string('nama_npak', 255)->default('');
                $table->bigInteger('jum_sim_pokok')->default(0);
                $table->bigInteger('jum_sim_wajib')->default(0);
                $table->integer('jum_pengurus')->default(5);
                $table->integer('jum_pengawas')->default(3);
                $table->integer('jum_anggota')->default(0);
                $table->string('no_inkop', 255)->nullable();
                $table->string('no_ahu', 255)->nullable();
                $table->dateTime('tgl_ahu')->nullable();
                $table->integer('id_user')->default(1);
                $table->tinyInteger('flag_del')->default(0);
            });
        }

        if (! Schema::hasTable('app_md_user')) {
            Schema::create('app_md_user', function (Blueprint $table) {
                $table->integer('id_user')->primary();
                $table->string('name_user', 255);
                $table->string('gelar_dpn', 50)->default('-');
                $table->string('gelar_blk', 50)->default('-');
                $table->string('login_user', 255)->unique();
                $table->string('pswd', 255);
                $table->integer('level_user')->default(1);
                $table->integer('id_company')->default(0);
                $table->integer('id_branch')->default(0);
                $table->string('nip_user', 50)->default('-');
                $table->integer('id_golongan')->default(0);
                $table->string('telp_user', 255)->default('-');
                $table->string('email_user', 255)->default('-');
                $table->string('email', 255)->nullable();
                $table->string('password', 255)->nullable();
                $table->integer('id_jabatan')->default(0);
                $table->integer('id_instansi')->default(0);
                $table->integer('id_bidang')->default(0);
                $table->integer('id_bidangsub')->default(0);
                $table->string('comt_user', 255)->default('-');
                $table->tinyInteger('flag_del')->default(0);
                $table->tinyInteger('islogin')->default(0);
                $table->tinyInteger('dispmode')->default(1);
                $table->string('filter1', 255)->nullable();
                $table->string('filter2', 255)->nullable();
                $table->string('filter3', 255)->nullable();
            });
        }

        if (! Schema::hasTable('app_md_kopsdm')) {
            Schema::create('app_md_kopsdm', function (Blueprint $table) {
                $table->integer('id_kopsdm')->primary();
                $table->integer('id_koperasi')->default(0);
                $table->string('name_kopsdm', 255);
                $table->string('jab_kopsdm', 255);
                $table->string('type_kopsdm', 255)->default('PENGURUS');
                $table->string('order_kopsdm', 255)->default('1');
                $table->string('comt_kopsdm', 255)->default('-');
                $table->integer('id_user')->default(1);
                $table->dateTime('tgl_data')->nullable();
                $table->tinyInteger('flag_del')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Keep intact to prevent data loss
    }
};
