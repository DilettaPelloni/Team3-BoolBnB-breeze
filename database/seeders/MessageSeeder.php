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
        $texts = [
            'Buongiorno, ho visto l\'annuncio del vostro appartamento e sarei interessato/a a prenotarlo. Potete darmi maggiori informazioni sulla disponibilità?',
            'Ciao, sto cercando un appartamento per le mie prossime vacanze e il vostro sembra perfetto! Potete dirmi quali sono le modalità di prenotazione?',
            'Salve, mi chiamo Giovanni e sto cercando un appartamento per il weekend. Il vostro sembra molto bello, posso prenotarlo per sabato e domenica?',
            'Buonasera, sono interessata al vostro appartamento e volevo sapere se è ancora disponibile per il mese di giugno.',
            'Salve, ho visto le foto del vostro appartamento e mi sembra molto accogliente. Potete dirmi di più sui servizi inclusi nella prenotazione?',
            'Ciao, sarei interessato/a a prenotare il vostro appartamento per il prossimo weekend. Quali sono i costi?',
            'Buongiorno, mi chiamo Chiara e sto cercando un appartamento per un soggiorno di una settimana. Potete dirmi se il vostro è ancora disponibile?',
            'Salve, sono interessato/a alla prenotazione del vostro appartamento. Potete dirmi quali sono le modalità di pagamento?',
            'Ciao, il vostro appartamento sembra perfetto per le mie esigenze. Potete dirmi se è disponibile per il prossimo weekend?',
            'Buongiorno, mi piacerebbe prenotare il vostro appartamento per un soggiorno di tre giorni. Quali sono i costi?',
            'Salve, sto cercando un appartamento per le vacanze estive e il vostro sembra molto interessante. Potete dirmi se ci sono ancora disponibilità per il mese di agosto?',
            'Ciao, ho visto le foto del vostro appartamento e mi sembra molto bello. Potete dirmi di più sulla posizione?',
            'Buongiorno, sono interessato/a alla prenotazione del vostro appartamento per il prossimo fine settimana. Potete dirmi se è ancora disponibile?',
            'Salve, il vostro appartamento sembra molto accogliente. Potete dirmi quali sono i servizi inclusi?',
            'Ciao, ho visto l\'annuncio del vostro appartamento e mi sembra perfetto per le mie esigenze. Potete dirmi quali sono i costi per un soggiorno di una settimana?',
            'Buongiorno, mi chiamo Luca e sto cercando un appartamento per il prossimo mese. Il vostro sembra molto interessante, potete dirmi di più sulla disponibilità?',
            'Salve, sono interessato/a alla prenotazione del vostro appartamento per un weekend romantico. Potete dirmi se è ancora disponibile?',
            'Ciao, il vostro appartamento sembra molto bello. Potete dirmi se ci sono sconti per le prenotazioni a lungo termine?',
            'Salve, sono molto interessato/a alla prenotazione del vostro appartamento. Potete dirmi se c\'è una tariffa per il parcheggio?',
            'Ciao, ho visto le foto del vostro appartamento e mi sembra perfetto per il mio soggiorno. Potete dirmi di più sulla vicinanza ai mezzi pubblici?',
            'Buongiorno, sono interessato/a alla prenotazione del vostro appartamento per il prossimo fine settimana. Potete dirmi se c\'è una cauzione da pagare?',
            'Salve, sto cercando un appartamento per le mie prossime vacanze e il vostro sembra molto bello. Potete dirmi di più sulla vicinanza alla spiaggia?',
            'Ciao, ho visto le foto del vostro appartamento e mi sembra molto accogliente. Potete dirmi di più sui servizi per la colazione?',
            'Buongiorno, sono interessato/a alla prenotazione del vostro appartamento per il prossimo mese. Potete dirmi se c\'è una tariffa per le pulizie finali?',
            'Salve, il vostro appartamento sembra molto bello. Potete dirmi di più sui servizi di connessione internet?',
            'Ciao, sono alla ricerca di un appartamento per un soggiorno di lavoro. Potete dirmi di più sulla vicinanza alle principali attrazioni turistiche?',
            'Buongiorno, ho visto l\'annuncio del vostro appartamento e mi sembra perfetto per il mio soggiorno. Potete dirmi se c\'è un deposito bagagli?',
            'Salve, sto cercando un appartamento per un weekend di relax. Il vostro sembra perfetto, potete dirmi di più sulla vicinanza ai ristoranti?',
            'Ciao, sono interessato/a alla prenotazione del vostro appartamento per il prossimo weekend. Potete dirmi di più sui servizi di pulizia?',
            'Buongiorno, il vostro appartamento sembra molto bello. Potete dirmi se ci sono sconti per le prenotazioni last minute?',
            'Salve, sto cercando un appartamento per un soggiorno romantico. Il vostro sembra perfetto, potete dirmi di più sui servizi di SPA?',
            'Ciao, ho visto le foto del vostro appartamento e mi sembra molto accogliente. Potete dirmi di più sui servizi di cucina?',
            'Buongiorno, sono interessato/a alla prenotazione del vostro appartamento per il prossimo fine settimana. Potete dirmi se ci sono sconti per le famiglie con bambini?',
            'Salve, sto cercando un appartamento per le mie prossime vacanze. Potete dirmi di più sulla vicinanza ai supermercati?',
            'Ciao, ho visto le foto del vostro appartamento e mi sembra molto bello. Potete dirmi di più sui servizi di lavanderia?',
            'Buongiorno, sono interessato/a alla prenotazione del vostro appartamento per il prossimo mese.',
            'Ciao! Sono interessato a prenotare l\'appartamento che hai pubblicizzato. Potresti dirmi di più sul prezzo e sulla posizione?',
            'Buongiorno, ho visto l\'annuncio del tuo appartamento e sono molto interessato! Potresti dirmi di più sulla disponibilità?',
            'Sono molto interessato a prenotare il tuo appartamento per le mie vacanze. Potresti dirmi se è ancora disponibile?',
            'Salve, sarei interessato a prenotare l\'appartamento per il mese di agosto. Potresti dirmi il prezzo e la disponibilità?',
            'Ciao! Volevo chiederti se l\'appartamento è ancora disponibile per il periodo che mi interessa. Potresti fornirmi ulteriori dettagli?',
            'Buongiorno, sono interessato a prenotare l\'appartamento per il mio prossimo viaggio. Potresti dirmi di più sui servizi offerti?',
        ];

        for ($i = 0; $i < 20; $i++) {
            $message = new Message();
            //prendo un'id casuale fra gli appartamenti e lo assegno
            $apartmentId = Apartment::inRandomOrder()
                ->where('user_id', 1)
                ->first()->id;
            $message->apartment_id = $apartmentId;
            //prendo un elemento casuale da uno tei messaggi in texts[]
            $message->content = $texts[rand(0, count($texts)-1)];
            //genero una mail casuale
            $message->sender_email = $faker->freeEmail();
            //genero un nume casuale
            $message->sender_name = $faker->name();
            //salvo
            $message->save();
        }
    }
}
