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

        $user_name = '';
        $user_email = '';

        if (Auth::check()) {
            $user_email = Auth::user()->email;
            if(Auth::user()->firstname != null) {
                $user_name = Auth::user()->firstname;
            }
        }

        return Inertia::render('Guest/Show', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'apartment' => $apartment,
            'user_email' => $user_email,
            'user_name' => $user_name,
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
        $rooms = $data['filters']['rooms'];
        $beds = $data['filters']['beds'];
        $requestedServices = $data['filters']['services'];
        $lat = null;
        $lon = null;

        if ($address) {
        
            $lat = $address['position']['lat'];
            $lon = $address['position']['lon'];

            $apartments = Apartment::selectRaw('*, ( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude) ) ) ) AS distance', [$lat, $lon, $lat])
            ->having('distance', '<=', $radius)
            ->having('visible', '=', '1')
            ->having('rooms', '>=', $rooms)
            ->having('beds', '>=', $beds)
            ->with('services')
            ->get();

            $filteredApartments = $apartments;
            if (count($requestedServices) > 0) {
                $filteredApartments = [];

                foreach ($apartments as $apartment) {
                    if ($this->filterApartment($apartment, $requestedServices)) {
                        array_push($filteredApartments, $apartment);
                    }
                }
            }

            if(count($filteredApartments) == 0) {
                $filteredApartments = null;
            }
        }
        else {
            $filteredApartments = null;
        }

        $services = Service::all();
        
        return Inertia::render('Guest/Search', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'apartments' => $filteredApartments,
            'services' => $services,
            'centerAddress' => $address,
        ]);
    }

    private function filterApartment($apartment, $requestedServices) {

        $apartmentServicesIds = [];
        foreach ($apartment['services'] as $service) {
            array_push($apartmentServicesIds, $service['id']);
        }

        foreach ($requestedServices as $requestedService) {
            if(!(in_array($requestedService, $apartmentServicesIds))) {
                return false;
            };
        }
        return true;
    }
    
}
