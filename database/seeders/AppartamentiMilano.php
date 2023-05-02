<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

//Models
use App\Models\Apartment;

//Helpers
use Illuminate\Support\Str;

class AppartamentiMilano extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $handle = fopen(public_path('txt\Milan.txt'), "r") or die("Unable to open file!");

        while (!feof($handle)) {
            $line = fgets($handle);
            $line = explode(":", $line);

            $apartments[] = array(
                "title" => $line[0],
                "rooms" => $line[1],
                "beds" => $line[2],
                "bathrooms" => $line[3],
                "size"=> $line[4],
                "address"=> $line[5],
                "lat"=> $line[6],
                "lon"=> $line[7],
                "img"=> $line[8],
                "visible"=> $line[9],
            );
        }

        fclose($handle);

        $file = fopen(public_path('txt\description.txt'), "r") or die("Unable to open file!");
        $descriptions = array();

        while (!feof($file)) {
            $descriptions[] = fgets($file);
        }
        fclose($file);

        //componi un nuovo array che ha come oggetti il testo compreso tra una e l'altra virgoletta
        $cleanDescriptions = array();
        foreach ($descriptions as $key => $value) {
            $cleanDescriptions[] = explode('""', $value);
        }
        //elimina le virgolette dagli array
        foreach ($cleanDescriptions as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $cleanDescriptions[$key][$key2] = str_replace('"', '', $value2);
            }
        }

        foreach ($apartments as $apartment) {
            $newApartment = Apartment::create([
                'user_id'=> 1,
                'title'=> $apartment['title'],
                'title_slug'=> Str::slug($apartment['title']),
                'description'=> $cleanDescriptions[rand(0, (count($cleanDescriptions) - 1))][0],
                'rooms'=> $apartment['rooms'],
                'beds'=> $apartment['beds'],
                'bathrooms'=> $apartment['bathrooms'],
                'size'=> $apartment['size'],
                'address'=> $apartment['address'],
                'address_slug'=> Str::slug($apartment['address']),
                'latitude'=> $apartment['lat'],
                'longitude'=> $apartment['lon'],
                'cover_img'=> $apartment['img'],
                'visible'=> $apartment['visible']
            ]);
        }
    }
}
