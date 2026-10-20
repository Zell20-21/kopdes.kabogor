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
        Schema::create('koperasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kecamatan')->nullable();
            $table->text('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('status_operasional')->default('SUDAH');
            $table->string('status_pelatihan')->default('BELUM');
            $table->string('status_sertifikat')->default('SUDAH');
            $table->string('nama_notaris')->nullable();
            $table->string('no_ahu')->nullable();
            $table->string('no_inkop')->nullable();
            $table->unsignedInteger('jum_pengurus')->default(5);
            $table->unsignedInteger('jum_pengawas')->default(3);
            $table->unsignedInteger('jum_anggota')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koperasis');
    }
};
