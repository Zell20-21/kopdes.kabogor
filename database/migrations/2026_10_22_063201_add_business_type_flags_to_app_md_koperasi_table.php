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
        if (! Schema::hasTable('app_md_koperasi')) {
            return;
        }

        $missingColumns = [];
        for ($index = 1; $index <= 13; $index++) {
            $column = "id_koperasitype{$index}";
            if (! Schema::hasColumn('app_md_koperasi', $column)) {
                $missingColumns[] = $column;
            }
        }

        if ($missingColumns === []) {
            return;
        }

        Schema::table('app_md_koperasi', function (Blueprint $table) use ($missingColumns) {
            foreach ($missingColumns as $column) {
                $table->string($column, 50)->default('No');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Preserve business type values when rolling back.
    }
};
