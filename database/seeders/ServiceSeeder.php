<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

//Models
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            [
                "name" => 'Wi-Fi',
                "icon" => 'wifi'
            ],
            [
                "name" => 'Lavatrice',
                "icon" => 'soap'
            ],
            [
                "name" => 'Cucina',
                "icon" => 'kitchen-set',
            ],
            [
                "name" => 'Aria Condizionata',
                "icon" => 'fan'
            ],
            [
                "name" => 'TV',
                "icon" => 'tv'
            ],
            [
                "name" => 'Piscina',
                "icon" => 'person-swimming'
            ],
            [
                "name" => 'Parcheggio',
                "icon" => 'square-parking',
            ],
            [
                "name" => 'Asciugacapelli',
                "icon" => 'wind'
            ],
            [
                "name" => 'Ferro da Stiro',
                "icon" => 'shirt'
            ],
            [
                "name" => 'Ricarica veicoli elettrici',
                "icon" => 'car-battery'
            ],
            [
                "name" => 'Frigorifero',
                "icon" => 'snowflake'
            ],
            [
                "name" => 'Bollitore',
                "icon" => 'mug-hot'
            ],
            [
                "name" => 'Idromassaggio',
                "icon" => 'bath'
            ],
        ];

        foreach ($services as $service) {
            $newService = Service::create([
                'name'=> $service['name'],
                'icon'=> $service['icon'],
            ]);
        }
    }
}
