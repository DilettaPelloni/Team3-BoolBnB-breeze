<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;

//Inertia
use Inertia\Inertia;
use Inertia\Response;

//Helpers
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

//Model
use App\Models\Service;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;

        $apartments = Apartment::where('user_id', $user_id)->get();
        return Inertia::render('Management/Index', [
            'apartments' => $apartments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::all();
        return Inertia::render('Management/Create', [
            'services' => $services,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreApartmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApartmentRequest $request)
    {
        $data = $request->validated();

        //faccio lo slug del titolo
        $title_slug = Str::slug($data['title'], '-');
        //compongo l'indirizzo completo e lo slugifico
        $address = $data['cap'] . ' ' . $data['city'] . ' ' . $data['street'] . ' n. ' . $data['civic_number'];
        $address_slug = Str::slug($address, '-');
        //salvo l'immagine
        $imgPath = Storage::put('apartments', $data['cover_img']);
        //prendo l'id dello user
        $user_id = Auth::user()->id;

        $newApartment = Apartment::create([
            'user_id' => $user_id,
            'title' => $data['title'],
            'title_slug' => $title_slug,
            'description' => $data['description'],
            'rooms' => $data['rooms'],
            'beds' => $data['beds'],
            'bathrooms' => $data['bathrooms'],
            'size' => $data['size'],
            'address' => $address,
            'address_slug' => $address_slug,
            'cover_img' => $imgPath,
            'visible' => $data['visible'],
        ]);

        if (array_key_exists('activeServices', $data)) {
            foreach ($data['activeServices'] as $serviceId) {
                $newApartment->services()->sync($data['activeServices']);
            }
        }

        return Redirect::route('gestione-appartamenti.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function show($apartment_id)
    {
        $apartment = Apartment::where('id', $apartment_id)->with('services')->first();

        return Inertia::render('Management/Show', [
            'apartment' => $apartment,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function edit($apartment_id)
    {
        $services = Service::all();
        $apartment = Apartment::where('id', $apartment_id)->with('services')->first();
        return Inertia::render('Management/Edit', [
            'services' => $services,
            'apartment' => $apartment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateApartmentRequest  $request
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApartmentRequest $request, $apartment_id)
    {
        $data = $request->validated();

        $apartment = Apartment::where('id', $apartment_id)->first();

        //se una nuova immagine è stata passata sostituisco quella vecchia
        if($data['cover_img'] != null) {
            $imgPath = Storage::put('apartments', $data['cover_img']);
            $data['cover_img'] = $imgPath;

            if($apartment->cover_img) {
                Storage::delete($apartment->cover_img);
                $apartment->cover_img = $imgPath;
            }
        }

        //faccio lo slug del titolo
        $title_slug = Str::slug($data['title'], '-');
        //faccio lo slug dell'indirizzo
        $address_slug = Str::slug($data['address'], '-');
        //prendo l'id dello user
        $user_id = Auth::user()->id;

        //aggiorno l'appartamento
        $apartment->user_id = $user_id;
        $apartment->title = $data['title'];
        $apartment->title_slug = $title_slug;
        $apartment->description = $data['description'];
        $apartment->rooms = $data['rooms'];
        $apartment->beds = $data['beds'];
        $apartment->bathrooms = $data['bathrooms'];
        $apartment->size = $data['size'];
        $apartment->address = $data['address'];
        $apartment->address_slug = $address_slug;
        $apartment->visible = $data['visible'];
        $apartment->save();

        if (array_key_exists('activeServices', $data)) {
            foreach ($data['activeServices'] as $serviceId) {
                $apartment->services()->sync($data['activeServices']);
            }
        }

        return Redirect::route('gestione-appartamenti.show', $apartment->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        //
    }
}
