<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed admin user
        if (!User::where('email', 'admin@byward.com')->exists()) {
            User::create([
                'name' => 'Byward Admin',
                'email' => 'admin@byward.com',
                'password' => bcrypt('password'),
            ]);
        }

        $this->call([
            JobOfferSeeder::class,
        ]);
    }
}
