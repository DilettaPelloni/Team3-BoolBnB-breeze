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
            'apartments' => $apartments,
            'services' => $services,
        ]);
    }
}
