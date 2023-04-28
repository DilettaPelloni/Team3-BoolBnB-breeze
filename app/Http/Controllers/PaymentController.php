<?php

namespace App\Http\Controllers;

use Braintree\Gateway;

use Illuminate\Http\Request;

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
}
