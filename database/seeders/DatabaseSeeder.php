<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed default admin user
        User::updateOrCreate(
            ['email' => 'admin@bogorkab.go.id'],
            [
                'name' => 'Administrator KMP',
                'password' => Hash::make('password'),
            ]
        );

        $this->call([
            KecamatanSeeder::class,
            KoperasiSeeder::class,
        ]);
    }
}
