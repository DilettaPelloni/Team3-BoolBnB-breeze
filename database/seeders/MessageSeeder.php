<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

//Model
use App\Models\Message;
use App\Models\Apartment;

//Utility
use Faker\Generator as Faker;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 20; $i++) {
            $message = new Message();
            //prendo un'id casuale fra gli appartamenti e lo assegno
            $apartmentId = Apartment::inRandomOrder()->first()->id;
            $message->apartment_id = $apartmentId;
            //genero un testo casuale con un numero di paragrafi che può andare da 2 a 6
            $message->content = $faker->paragraphs(rand(2,6), true);
            //genero una mail casuale
            $message->sender_email = $faker->freeEmail();
            //genero un nume casuale
            $message->sender_name = $faker->name();
            //salvo
            $message->save();
        }
    }
}
