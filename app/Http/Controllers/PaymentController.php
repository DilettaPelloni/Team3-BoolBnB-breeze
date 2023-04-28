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
}
