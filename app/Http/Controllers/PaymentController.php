<?php

namespace App\Http\Controllers;

use Braintree\Gateway;

use Illuminate\Http\Request;

//carbon
use Carbon\Carbon;

//Helpers
use DateTime;
use DateInterval;
use DateTimeZone;

use Illuminate\Support\Facades\DB; //per gestire il db

use App\Models\Apartment;
use App\Models\Sponsorship;

class PaymentController extends Controller
{
    public function getToken()
    {

        $gateway = new Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'nzfddrsy7sckzpfb',
            'publicKey' => '656kfm2x8r8jxt2s',
            'privateKey' => '5f58c8c92be2fd470822b31a48fae548'
        ]);

        $clientToken = $gateway->clientToken()->generate();

        return response()->json(['token' => $clientToken]);
    }

    public function createTransaction(Request $request)
    {
        $gateway = new Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'nzfddrsy7sckzpfb',
            'publicKey' => '656kfm2x8r8jxt2s',
            'privateKey' => '5f58c8c92be2fd470822b31a48fae548'
        ]);

        $data = $request->all();

        $nonce = $data['nonce'];
        $amount = $data['amount'];

        $result = $gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        if ($result->success) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'error' => $result->message]);
        }
    }

    public function createActiveSponsoship (Request $request) {
        $data = $request->all();

        $apartmentId = $data['selectedApartment'];
        $sponsorshipId = $data['selectedSponsor']['id'];

        $start_date = new DateTime('now', new DateTimeZone('Europe/Vatican'));

        //calcolo la data di fine
        $duration = $data['selectedSponsor']['duration'];
        $hours = substr($duration, 0, strpos($duration, ':'));

        $endDate = clone $start_date;
        $endDate->add(new DateInterval('PT' . $hours . 'H'));

        $newActiveSponsorship = DB::table('apartment_sponsorship')->insert([
            'apartment_id' => $apartmentId,
            'sponsorship_id' => $sponsorshipId,
            'start_date' => $start_date,
            'end_date' => $endDate,
        ]);
    }
}
