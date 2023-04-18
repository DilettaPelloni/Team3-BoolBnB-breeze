<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

//Model
use App\Models\Sponsorship;

class SponsorshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sponsoships = [
            [
                "duration" => '24:00:00',
                "name" => 'Entry level',
                "price" => 2.99
            ],
            [
                "duration" => '72:00:00',
                "name" => 'Medium level',
                "price" => 5.99
            ],
            [
                "duration" => '144:00:00',
                "name" => 'Pro level',
                "price" => 9.99
            ],
            
        ];

        foreach ($sponsoships as $sponsoship) {
            $newSponsorship = Sponsorship::create([
                'duration'=> $sponsoship['duration'],
                'name'=> $sponsoship['name'],
                'price'=> $sponsoship['price'],
            ]);
        }
    }
}
