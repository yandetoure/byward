<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Shipment::create([
            'tracking_number' => 'BW-1001',
            'status' => 'Delivered',
            'origin' => 'Montreal, QC',
            'destination' => 'Toronto, ON',
            'current_location' => 'Toronto, ON',
            'expected_delivery_date' => \Carbon\Carbon::now()->subDays(1),
            'notes' => 'Package delivered successfully.',
        ]);

        \App\Models\Shipment::create([
            'tracking_number' => 'BW-1002',
            'status' => 'Out for Delivery',
            'origin' => 'Vancouver, BC',
            'destination' => 'Calgary, AB',
            'current_location' => 'Calgary, AB',
            'expected_delivery_date' => \Carbon\Carbon::today(),
            'notes' => 'Package is out for delivery.',
        ]);

        \App\Models\Shipment::create([
            'tracking_number' => 'BW-1003',
            'status' => 'In Transit',
            'origin' => 'Ottawa, ON',
            'destination' => 'Halifax, NS',
            'current_location' => 'Montreal, QC',
            'expected_delivery_date' => \Carbon\Carbon::now()->addDays(2),
            'notes' => 'In transit to destination.',
        ]);

        \App\Models\Shipment::create([
            'tracking_number' => 'BW-1004',
            'status' => 'Pending',
            'origin' => 'Winnipeg, MB',
            'destination' => 'Regina, SK',
            'current_location' => 'Winnipeg, MB',
            'expected_delivery_date' => \Carbon\Carbon::now()->addDays(5),
            'notes' => 'Shipment label created, pending pickup.',
        ]);
    }
}
