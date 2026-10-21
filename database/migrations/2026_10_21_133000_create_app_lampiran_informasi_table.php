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
        if (! Schema::hasTable('app_lampiran_informasi')) {
            Schema::create('app_lampiran_informasi', function (Blueprint $table) {
                $table->id();
                $table->string('judul');
                $table->string('keterangan')->nullable();
                $table->string('file_name');
                $table->string('file_path');
                $table->string('file_size')->nullable();
                $table->string('file_type', 20)->default('pdf');
                $table->integer('urutan')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });

            // Seed initial existing document if available
            $pdfPath = base_path('informasi/kdkp_maret_2026.pdf');
            $size = file_exists($pdfPath) ? round(filesize($pdfPath) / 1024 / 1024, 2).' MB' : '5.47 MB';

            DB::table('app_lampiran_informasi')->insert([
                'judul' => 'DATA PROGRES PEMBANGUNAN KDKMP',
                'keterangan' => 'LAPJUSIK DIM 0621 • 24 MARET 2026',
                'file_name' => 'kdkp_maret_2026.pdf',
                'file_path' => 'kdkp_maret_2026.pdf',
                'file_size' => $size,
                'file_type' => 'pdf',
                'urutan' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_lampiran_informasi');
    }
};
