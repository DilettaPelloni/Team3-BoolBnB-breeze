<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Models
use App\Models\Apartment;
use App\Models\Service;

//Helpers
use Illuminate\Support\Facades\Auth;

//Inertia
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function show($title_slug)
    {
        $apartment = Apartment::where('title_slug', $title_slug)->with('services')->first();

        if (Auth::check()) {
            $user_email = Auth::user()->email;
        } else {
            $user_email = '';
        }

        return Inertia::render('Guest/Show', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'apartment' => $apartment,
            'user_email' => $user_email
        ]);
    }

    public function search()
    {
        $apartments = Apartment::with('services')->get();
        $services = Service::all();

        return Inertia::render('Guest/Search', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'apartments' => null,
            'services' => $services,
        ]);
    }

    public function apartmentSearch(Request $request)
    {   
        //prendo i dati
        $data = $request->all();
        $address = $data['completeAddress'];
        $radius = $data['radius'];
        $lat = null;
        $lon = null;
        $error = null;

        if ($address) {
        
            $lat = $address['position']['lat'];
            $lon = $address['position']['lon'];

            $apartments = Apartment::selectRaw('*, ( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude) ) ) ) AS distance', [$lat, $lon, $lat])
                        ->having('distance', '<=', $radius)->get();
        }
        else {
            $apartments = null;
            $error = 'Non è stato dato un indirizzo';
        }

        $services = Service::all();
        
        return Inertia::render('Guest/Search', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'apartments' => $apartments,
            'services' => $services,
            'error' => $error,
        ]);
    }
    
}
