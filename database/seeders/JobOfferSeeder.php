<?php

namespace Database\Seeders;

use App\Models\JobOffer;
use Illuminate\Database\Seeder;

class JobOfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobs = [
            [
                'title_en' => 'Driver / Operator',
                'title_fr' => 'Chauffeur / Opérateur',
                'description_en' => 'Join our modern fleet. Ensure safe and timely transport of goods with flexible schedules.',
                'description_fr' => 'Rejoignez notre flotte moderne. Assurez le transport sécurisé et ponctuel de nos marchandises.',
                'is_active' => true,
            ],
            [
                'title_en' => 'Warehouse Associate',
                'title_fr' => 'Préparateur de commandes',
                'description_en' => 'The heart of our operations. Manage inventory, fulfill orders, and keep our supply chain moving.',
                'description_fr' => 'Au cœur de nos opérations. Gérez l\'inventaire et préparez les commandes efficacement.',
                'is_active' => true,
            ],
            [
                'title_en' => 'Logistics Coordinator',
                'title_fr' => 'Coordonnateur Logistique',
                'description_en' => 'The brains behind our routes. Plan transport operations and optimize delivery efficiency.',
                'description_fr' => 'Le cerveau derrière nos routes. Planifiez les opérations et optimisez les livraisons.',
                'is_active' => true,
            ],
            [
                'title_en' => 'Administration & Support',
                'title_fr' => 'Administration & Support',
                'description_en' => 'The backbone of our team. Provide exceptional administrative support.',
                'description_fr' => 'Le pilier de l\'équipe. Assurez un support administratif exceptionnel au quotidien.',
                'is_active' => true,
            ],
        ];

        foreach ($jobs as $job) {
            JobOffer::updateOrCreate(
                ['title_en' => $job['title_en']],
                $job
            );
        }
    }
}
