<?php

namespace App\Http\Controllers;

use Braintree\Gateway;

use Illuminate\Http\Request;

//carbon
use Carbon\Carbon;



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
        $apartment_id = $data['apartment_id'];
        $sponsorship_id = $data['sponsorship_id'];
        $duration = $data['duration'];
        $nonce = $data['nonce'];
        $amount = $data['amount'];
        $result = $gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);


        //gestisco la data di inizio e fine sponsorizzazione

        $duration = substr($duration, 0, 2);
        $start_date = Carbon::now();
        $end_date = Carbon::now()->addHours($duration);




        if ($result->success) {

            $apartment = Apartment::find($apartment_id);

        //$apartment->sponsorships()->attach($sponsorship_id, ['start_date' => $start_date, 'end_date' => $end_date]);
        //crisi qui: si genera un duplicato in database 

        //soluzione: updateExistingPivot invece di attach aaaaaaaaa
        $apartment->sponsorships()->updateExistingPivot($sponsorship_id, ['end_date' => $end_date]);


            return response()->json(['success' => true, 'message' => 'Transaction completed']);
        } else {
            return response()->json(['success' => false, 'error' => $result->message]);
        }
    }
}
