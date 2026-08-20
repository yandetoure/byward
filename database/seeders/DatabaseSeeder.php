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

        // Seed some default jobs
        if (\App\Models\JobOffer::count() === 0) {
            \App\Models\JobOffer::create([
                'title_en' => 'Driver / Operator',
                'title_fr' => 'Chauffeur / Opérateur',
                'description_en' => 'Join our modern fleet. Ensure safe and timely transport of goods.',
                'description_fr' => 'Rejoignez notre flotte moderne. Assurez un transport sûr et rapide.',
                'is_active' => true,
            ]);

            \App\Models\JobOffer::create([
                'title_en' => 'Warehouse Associate',
                'title_fr' => 'Associé d\'Entrepôt',
                'description_en' => 'Manage inventory, fulfill orders, and keep our supply chain moving.',
                'description_fr' => 'Gérez les stocks, préparez les commandes et assurez la fluidité logistique.',
                'is_active' => true,
            ]);

            \App\Models\JobOffer::create([
                'title_en' => 'Logistics Coordinator',
                'title_fr' => 'Coordonnateur Logistique',
                'description_en' => 'Plan transport operations and optimize delivery efficiency.',
                'description_fr' => 'Planifiez les opérations de transport et optimisez l\'efficacité des livraisons.',
                'is_active' => true,
            ]);
        }
    }
}
