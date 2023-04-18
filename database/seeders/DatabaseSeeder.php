<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ApartmentSeeder::class,
            ServiceSeeder::class,
            SponsorshipSeeder::class,
            MessageSeeder::class,
            ViewSeeder::class,
            apartment_sponsorship_Seeder::class,
            apartments_service_Seeder::class,
        ]);
    }
}
