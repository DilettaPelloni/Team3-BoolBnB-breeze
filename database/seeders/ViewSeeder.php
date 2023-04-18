<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

//Model
use App\Models\View;
use App\Models\Apartment;

//Utility
use Faker\Generator as Faker;

class ViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 20; $i++) {
            $view = new View();
            //prendo un'id casuale fra gli appartamenti e lo assegno
            $apartmentId = Apartment::inRandomOrder()->first()->id;
            $view->apartment_id = $apartmentId;
            //genero un ip casuale
            $view->user_ip = $faker->ipv4();

            $view->save();
        };
    }
}
