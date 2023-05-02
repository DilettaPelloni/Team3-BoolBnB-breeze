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

        for ($i = 0; $i < 100; $i++) {
            //creo una nuova istanza di Apartment
            $apartment = new Apartment();

            if($i < 16) {
                $apartment->user_id = 1;
            }
            else {
                $apartment->user_id = 2;
            };
        

            //prendo un elemento a caso di ciascun array per formare il titolo
            $title = '';
            do {
                $adjective = $adjectives[rand(0, (count($adjectives) - 1))];
                $house = $houses[rand(0, (count($houses) - 1))];
                $with = $withs[rand(0, (count($withs) - 1))];
                $title = $adjective . ' ' . $house . ' ' . $with;
                $foundTitle = Apartment::where('title', $title)->first();
            } while ($foundTitle != null);
            $apartment->title = $title;
            $apartment->title_slug = Str::slug($title);

            //DESCRIZIONE

            //prendi il file description dalla cartella public e leggilo
            $file = fopen(public_path('txt\description.txt'), "r") or die("Unable to open file!");
            $array = array();

            while (!feof($file)) {
                $array[] = fgets($file);
            }
            fclose($file);

            //componi un nuovo array che ha come oggetti il testo compreso tra una e l'altra virgoletta
            $array2 = array();
            foreach ($array as $key => $value) {
                $array2[] = explode('""', $value);
            }

            //elimina le virgolette dagli array
            foreach ($array2 as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    $array2[$key][$key2] = str_replace('"', '', $value2);
                }
            }

            //descrizione: genera una descrizione prendendo un oggetto dell'array casuale
            $apartment->description = $array2[rand(0, (count($array2) - 1))][0];


            //---FINE DESCRIZIONE----

            //numero di stanze
            $apartment->rooms = $faker->numberBetween(1, 10);
            //numero di letti
            do {
                $apartment->beds = $faker->numberBetween(1, 10);
            } while ($apartment->beds > $apartment->rooms + 1);
            //numero di bagni
            do {
                $apartment->bathrooms = $faker->numberBetween(1, 4);
            } while ($apartment->bathrooms > ($apartment->rooms - $apartment->beds) + 2);
            //m2
            $apartment->size = ($apartment->rooms * 14) + rand(5, 100);

            //indirizzo latitudine e longitudine
            $handle = fopen(public_path('txt\cityclear.txt'), "r") or die("Unable to open file!");

            while (!feof($handle)) {
                $line = fgets($handle);
                $line = explode(",", $line);
                $line = str_replace("'", '', $line);
                $line[0] = trim($line[0]);
                $line[1] = trim($line[1]);
                $line[2] = trim($line[2]);

                $array[] = array(
                    "city" => $line[0],
                    "lat" => $line[1],
                    "long" => $line[2]
                );
            }

            fclose($handle);

            $random = rand(0, (count($array) - 1));
            $city = $array[$random]['city'];
            $lat = $array[$random]['lat'];
            $long = $array[$random]['long'];

            $street = $faker->streetName();
            $address = $street . ', ' . $city;

            $apartment->address = $address;
            $apartment->address_slug = Str::slug($address);
            $apartment->latitude = $lat;
            $apartment->longitude = $long;

            //immagine
            $cover_imgs = scandir(resource_path('seederImg'));
            $cover_imgs = array_diff($cover_imgs, ['.', '..']);
            $cover_img = $cover_imgs[array_rand($cover_imgs)];
            $apartment->cover_img = 'apartments/' . $cover_img;

            //visibile
            $apartment->visible = $faker->numberBetween(0, 1);

            //salvo
            $apartment->save();
        }
    }
}
