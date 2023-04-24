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
            [
                "name" => 'Cassaforte',
                "icon" => 'vault',
            ],
            [
                "name" => 'Accessori Cucina',
                "icon" => 'utensils',
            ],
            [
                "name" => 'Biciclette',
                "icon" => 'bicycle',
            ],
            [
                "name" => 'Animali domestici',
                "icon" => 'dog',
            ],
            [
                "name" => 'Vista panoramica',
                "icon" => 'mountain',
            ],
            [
                "name" => 'Riscaldamento', 
                "icon" => 'temperature-quarter',
            ],
            [
                "name" => 'Possibilità di escursioni',
                "icon" => 'person-hiking',
            ],
            [
                "name" => 'Biancheria da letto',
                "icon" => 'bed',
            ],
            [
                "name" => 'Tavolo da gioco',
                "icon" => 'table-tennis-paddle-ball',
            ],
            [
                "name" => 'Accesso alla spiaggia',
                "icon" => 'umbrella-beach',
            ],
            [
                "name" => 'Area fumatori',
                "icon" => 'smoking',
            ],
            [
                "name" => 'Self check-in',
                "icon" => 'key',
            ],
            [
                "name" => 'Telecamere di sicurezza',
                "icon" => 'eye', 
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
