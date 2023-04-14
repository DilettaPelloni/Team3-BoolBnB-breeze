<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

//Model
use App\Models\Apartment;
use App\Models\User;

//Utility
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        //array per generare i titoli
        $adjectives = [
            'Splendente',
            'Incantevole',
            'Enorme',
            'Strabiliante',
            'Affascinante',
            'Accogliente',
            'Spettacolare'
        ];

        $houses = [
            'villa',
            'appartamento',
            'chalet',
            'casa sull\'albero',
            'casa',
            'stanza',
            'cantina',
            'sottoscala',
        ];

        $withs = [
            'con piscina',
            'con ampio parcheggio',
            'per famiglie',
            'per coppie',
            'con giardino',
            'con idromassaggio',
            'in campagna',
            'nel bosco',
            'con vista sul mare',
            'vicino al centro storico',
            'nel verde',
        ];

        //array per generare le foto
        // $cover_imgs = ;

        for ($i = 0; $i < 10; $i++) {
            //creo una nuova istanza di Apartment
            $apartment = new Apartment();

            $apartment->user_id = 1;

            //prendo un elemento a caso di ciascun array per formare il titolo
            $title = '';
            do {
                $adjective = $adjectives[rand(0, (count($adjectives)-1))];
                $house = $houses[rand(0, (count($houses)-1))];
                $with = $withs[rand(0, (count($withs)-1))];
                $title = $adjective.' '.$house.' '.$with;
                $foundTitle = Apartment::where('title', $title)->first();
            } while ($foundTitle != null);
            $apartment->title = $title;
            $apartment->title_slug = Str::slug($title);

            //descrizione: genera da 2 a 4 paragrafi
            $apartment->description = $faker->paragraphs(rand(2, 4), true);

            //numero di stanze, letti e bagni e m2
            $apartment->rooms = $faker->numberBetween(1, 10);
            $apartment->beds = $faker->numberBetween(1, 10);
            $apartment->bathrooms = $faker->numberBetween(1, 4);
            $apartment->size = $faker->numberBetween(12, 300);

            //indirizzo
            $address = $faker->address();
            $apartment->address = $address;
            $apartment->address_slug = Str::slug($address);

            //immagine
            $apartment->cover_img = 'https://pixabay.com/get/g2dd46f4f314d945d4f60efbd81c11adf5b9bec8ec56fdd3884b489d5488a189c18327417fbf028fc36fdf7d32219e23a2cfb51944a13f442e11b831b3ac6d5f8_1280.jpg';

            //visibile
            $apartment->visible = $faker->numberBetween(0, 1);

            //salvo
            $apartment->save();
        }
    }
}
