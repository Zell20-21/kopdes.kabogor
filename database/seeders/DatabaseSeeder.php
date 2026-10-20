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
            ['id_user' => 1],
            [
                'name_user' => 'Administrator KMP',
                'login_user' => 'admin',
                'pswd' => '7a4e024dfcaf88657eb31364d311cc8b',
                'level_user' => 1,
                'email_user' => 'admin@bogorkab.go.id',
                'email' => 'admin@bogorkab.go.id',
                'password' => Hash::make('password'),
            ]
        );

        $this->call([
            KecamatanSeeder::class,
            KoperasiSeeder::class,
        ]);
    }
}
