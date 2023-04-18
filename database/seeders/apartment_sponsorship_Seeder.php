<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

//Model
use App\Models\Apartment;
use App\Models\Sponsorship;

//Helpers & utility
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;
use DateInterval;
use DateTime;

class apartment_sponsorship_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 10; $i++) {

            do {
                //salvo un'id casuale fra gli appartamenti
                $apartment_id = Apartment::inRandomOrder()->first()->id;
                //salvo un'id casuale fra le sponsorizzazioni
                $sponsorship_id = Sponsorship::inRandomOrder()->first()->id;
                //cerco se esiste già la combinazione
                $foundCombo = DB::table('apartment_sponsorship')
                                ->where('apartment_id', $apartment_id)
                                ->where('sponsorship_id', $sponsorship_id)
                                ->first();
                //se esiste già la combinazione ripete
            } while ($foundCombo != null);

            //genero una data di partenza casuale fra oggi e tre gg fa
            $startDate = $faker->dateTimeBetween('-3 days', 'now');

            //ottengo la durata della sponsorship scelta casualmente nel passaggio precedente
            $duration = Sponsorship::where('id', $sponsorship_id)->value('duration');
            //dalla durata estraggo il numero di ore
            $hours = substr($duration, 0, strpos($duration, ':'));
            //creo una copia di startDate e la chiamo endDate
            $endDate = clone $startDate;
            //modifico endDate spostandola avanti di un numero di ore pari alla durata della sponsorship
            $endDate->add(new DateInterval('PT' . $hours . 'H'));

            //salvo la combinazione a DB
            DB::table('apartment_sponsorship')->insert([
                'apartment_id' => $apartment_id,
                'sponsorship_id' => $sponsorship_id,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);
        };
    }
}
