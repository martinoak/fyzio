<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('prices')->insert([
            [
                'service_name' => 'Individuální fyzioterapie',
                'duration' => '30 min',
                'price' => 600,
                'description' => null,
                'icon' => 'fa-solid fa-person-walking',
                'order' => 1
            ],
            [
                'service_name' => 'Individuální fyzioterapie',
                'duration' => '60 min',
                'price' => 1200,
                'description' => null,
                'icon' => 'fa-solid fa-person-walking',
                'order' => 2
            ],
            [
                'service_name' => 'Přístrojová lymfodrenáž',
                'duration' => '30 min',
                'price' => 150,
                'description' => null,
                'icon' => 'fa-solid fa-spa',
                'order' => 3
            ],
            [
                'service_name' => 'Přístrojová lymfodrenáž',
                'duration' => '60 min',
                'price' => 300,
                'description' => null,
                'icon' => 'fa-solid fa-spa',
                'order' => 4
            ],
            [
                'service_name' => 'Manuální lymfodrenáž',
                'duration' => '60 min',
                'price' => 1200,
                'description' => null,
                'icon' => 'fa-solid fa-spa',
                'order' => 5
            ],
            [
                'service_name' => 'Vojtova reflexní terapie',
                'duration' => '60 min',
                'price' => 1200,
                'description' => null,
                'icon' => 'fa-solid fa-person-dots-from-line',
                'order' => 6
            ],
            [
                'service_name' => 'Elektroterapie',
                'duration' => null,
                'price' => 100,
                'description' => null,
                'icon' => 'fa-solid fa-bolt',
                'order' => 7
            ],
            [
                'service_name' => 'Tejpování',
                'duration' => 'Nalepení',
                'price' => 100,
                'description' => null,
                'icon' => 'fa-solid fa-tape',
                'order' => 8
            ],
            [
                'service_name' => 'Tejpování',
                'duration' => 'Použitý materiál à 1cm',
                'price' => 1.50,
                'description' => null,
                'icon' => 'fa-solid fa-tape',
                'order' => 9
            ],
            [
                'service_name' => 'Potvrzení pro pojišťovnu',
                'duration' => null,
                'price' => 100,
                'description' => null,
                'icon' => 'fa-solid fa-check-to-slot',
                'order' => 10
            ],
            [
                'service_name' => 'Dárkové poukazy',
                'duration' => null,
                'price' => 500,
                'description' => 'od 500 Kč',
                'icon' => 'fa-solid fa-hand-holding-heart',
                'order' => 11
            ],
        ]);
    }
}

