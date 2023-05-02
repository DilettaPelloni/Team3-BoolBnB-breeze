<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

//Helpers
use Illuminate\Support\Facades\DB;

//Models
use App\Models\Apartment;
use App\Models\Service;

class apartments_service_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 500; $i++) {

            do {
                //salvo un'id casuale fra gli appartamenti
                $apartment_id = Apartment::where('id', '<', 60)
                    ->inRandomOrder()
                    ->first()
                    ->id;
                //salvo un'id casuale fra i servizi
                $service_id = Service::inRandomOrder()->first()->id;
                //cerco se esiste già la combinazione
                $foundCombo = DB::table('apartment_service')
                                ->where('apartment_id', $apartment_id)
                                ->where('service_id', $service_id)
                                ->first();
                //se esiste già la combinazione ripete
            } while ($foundCombo != null);

            //salvo la combinazione a DB
            DB::table('apartment_service')->insert([
                'apartment_id' => $apartment_id,
                'service_id' => $service_id
            ]);
        };
        for ($i = 0; $i < 500; $i++) {

            do {
                //salvo un'id casuale fra gli appartamenti
                $apartment_id = Apartment::where('id', '>=', 60)
                    ->inRandomOrder()
                    ->first()
                    ->id;
                //salvo un'id casuale fra i servizi
                $service_id = Service::inRandomOrder()->first()->id;
                //cerco se esiste già la combinazione
                $foundCombo = DB::table('apartment_service')
                                ->where('apartment_id', $apartment_id)
                                ->where('service_id', $service_id)
                                ->first();
                //se esiste già la combinazione ripete
            } while ($foundCombo != null);

            //salvo la combinazione a DB
            DB::table('apartment_service')->insert([
                'apartment_id' => $apartment_id,
                'service_id' => $service_id
            ]);
        };
    }
}
