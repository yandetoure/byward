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

        // Seed default jobs
        if (\App\Models\JobOffer::count() === 0) {
            \App\Models\JobOffer::create([
                'title_en' => 'Driver / Operator',
                'title_fr' => 'Chauffeur / Opérateur',
                'description_en' => 'Join our modern fleet. Ensure safe and timely transport of goods with flexible schedules.',
                'description_fr' => 'Rejoignez notre flotte moderne. Assurez le transport sécurisé et ponctuel de nos marchandises.',
                'is_active' => true,
            ]);

            \App\Models\JobOffer::create([
                'title_en' => 'Warehouse Associate',
                'title_fr' => 'Préparateur de commandes',
                'description_en' => 'The heart of our operations. Manage inventory, fulfill orders, and keep our supply chain moving.',
                'description_fr' => 'Au cœur de nos opérations. Gérez l\'inventaire et préparez les commandes efficacement.',
                'is_active' => true,
            ]);

            \App\Models\JobOffer::create([
                'title_en' => 'Logistics Coordinator',
                'title_fr' => 'Coordonnateur Logistique',
                'description_en' => 'The brains behind our routes. Plan transport operations and optimize delivery efficiency.',
                'description_fr' => 'Le cerveau derrière nos routes. Planifiez les opérations et optimisez les livraisons.',
                'is_active' => true,
            ]);

            \App\Models\JobOffer::create([
                'title_en' => 'Administration & Support',
                'title_fr' => 'Administration & Support',
                'description_en' => 'The backbone of our team. Provide exceptional administrative support.',
                'description_fr' => 'Le pilier de l\'équipe. Assurez un support administratif exceptionnel au quotidien.',
                'is_active' => true,
            ]);
        }
    }
}
