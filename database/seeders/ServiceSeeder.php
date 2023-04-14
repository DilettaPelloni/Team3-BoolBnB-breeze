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
                "icon" => 'icona-wifi'
            ],
            [
                "name" => 'Lavatrice',
                "icon" => 'icona-lavatrice'
            ],
            [
                "name" => 'Cucina',
                "icon" => 'icona-cucina'
            ],
            [
                "name" => 'Aria Condizionata',
                "icon" => 'icona-AriaCondizionata'
            ],
            [
                "name" => 'TV',
                "icon" => 'icona-TV'
            ],
            [
                "name" => 'Piscina',
                "icon" => 'icona-piscina'
            ],
            [
                "name" => 'Parcheggio',
                "icon" => 'icona-Parcheggio'
            ],
            [
                "name" => 'Asciugacapelli',
                "icon" => 'icona-Asciugacapelli'
            ],
            [
                "name" => 'Ferro da Stiro',
                "icon" => 'icona-ferroDaStiro'
            ],
            [
                "name" => 'Ricarica veicoli elettrici',
                "icon" => 'icona-ricaricaVeicoli'
            ],
            [
                "name" => 'Frigorifero',
                "icon" => 'icona-Frigorifero'
            ],
            [
                "name" => 'Bollitore',
                "icon" => 'icona-Bollitore'
            ],
            [
                "name" => 'Idromassaggio',
                "icon" => 'icona-idromassaggio'
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
