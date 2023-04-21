<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Inertia
use Inertia\Inertia;
use Inertia\Response;

//Models
use App\Models\Message;
use App\Models\Apartment;

//Request
use App\Http\Requests\StoreMessageRequest;

//Helpers
use Illuminate\Support\Facades\Redirect;

class MessagesController extends Controller
{
    public function store(StoreMessageRequest $request) {
        $data = $request->validated();
        $apartment = Apartment::where('id', $data['apartmentId'])->first();

        $newMessage = Message::create([
            'apartment_id'=>$data['apartmentId'],
            'content'=>$data['content'],
            'sender_email'=>$data['sender_email'],
            'sender_name'=>$data['sender_name'],
        ]);
    }

}
