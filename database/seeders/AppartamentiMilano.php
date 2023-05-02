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
        $array = [];

        while (!feof($handle)) {
            $line = fgets($handle);
            $line = explode(":", $line);

            $array[] = array(
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
        dd($array[0]);
        fclose($handle);

        foreach ($array as $apartment) {
            $newApartment = Apartment::create([
                'user_id'=> 1,
                'title'=> $apartment['title'],
                'title_slug'=> Str::slug($apartment['title']),
                'description'=> $apartment['description'],
                'rooms'=> $apartment['rooms'],
                'beds'=> $apartment['beds'],
                'bathrooms'=> $apartment['bathrooms'],
                'size'=> $apartment['size'],
                'address'=> $apartment['address'],
                'address_slug'=> Str::slug($apartment['address']),
                'latitude'=> $apartment['latitude'],
                'latitude'=> $apartment['latitude'],
                'cover_img'=> $apartment['cover_img'],
                'visible'=> $apartment['visible']
            ]);
        }
    }
}
