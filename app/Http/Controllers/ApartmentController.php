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
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

//Model
use App\Models\Service;
use App\Models\Message;
use App\Models\View;

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
        $address_slug = Str::slug($data['address'], '-');
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
            'address' => $data['address'],
            'address_slug' => $address_slug,
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'cover_img' => $imgPath,
            'visible' => $data['visible'],
        ]);

        if (array_key_exists('activeServices', $data)) {
            foreach ($data['activeServices'] as $serviceId) {
                $newApartment->services()->sync($data['activeServices']);
            }
        }

        return Redirect::route('gestione-appartamenti.show', $newApartment->id);
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
        //prendo l'id dello user
        $user_id = Auth::user()->id;
        //prendo l'appartamento
        $apartment = Apartment::where('id', $apartment_id)->with('services')->first();

        //se l'utente loggato è diverso dall'utente che ha creato l'appartamento, viene reindirizzato alla dashboard
        if($user_id != $apartment->user_id) {
            return Redirect::route('dashboard');
        }

        $services = Service::all();
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
    public function update(Request $request, $apartment_id)
    {

        $apartment = Apartment::where('id', $apartment_id)->first();

        $request->validate([
            'title' => [
                'required',
                'max:255',
                'string',
                Rule::unique('apartments')->ignore($apartment)
            ],
            'description' => 'nullable|max:3000',
            'rooms' => 'required|numeric|max:10|min:1',
            'beds' => 'required|numeric|max:10|min:1',
            'bathrooms' => 'required|numeric|max:4|min:1',
            'size' => 'required|numeric|max:300|min:12',
            'address' => 'required|string|max:255',
            "latitude" => "required|numeric|between:-90,90",
            "longitude" => "required|numeric|between:-180,180",
            'cover_img' => 'nullable|max:2048|image',
            'visible' => 'boolean|required',
            'activeServices' => 'nullable|array|exists:services,id'
        ]);

        $data = $request->all();

        //se una nuova immagine è stata passata sostituisco quella vecchia
        if ($data['cover_img'] != null) {
            $imgPath = Storage::put('apartments', $data['cover_img']);
            $data['cover_img'] = $imgPath;

            if ($apartment->cover_img) {
                Storage::delete($apartment->cover_img);
                $apartment->cover_img = $imgPath;
            }
        }

        //faccio lo slug del titolo
        $title_slug = Str::slug($data['title'], '-');
        //faccio lo slug dell'indirizzo
        $address_slug = Str::slug($data['address'], '-');

        //aggiorno l'appartamento
        $apartment->title = $data['title'];
        $apartment->title_slug = $title_slug;
        $apartment->description = $data['description'];
        $apartment->rooms = $data['rooms'];
        $apartment->beds = $data['beds'];
        $apartment->bathrooms = $data['bathrooms'];
        $apartment->size = $data['size'];
        $apartment->address = $data['address'];
        $apartment->address_slug = $address_slug;
        $apartment->latitude = $data['latitude'];
        $apartment->longitude = $data['longitude'];
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
    public function destroy($apartment_id)
    {
        $apartment = Apartment::where('id', $apartment_id)->first();

        Storage::delete($apartment->cover_img);
        $apartment->delete();
        return Redirect::route('gestione-appartamenti.index');
    }


    // GESTIONE PAGINA MESSAGGI
    public function messages()
    {
        $user_id = Auth::user()->id;
        //prendo i messaggi degli appartamenti dell'utente
        $messages = Message::join('apartments', 'messages.apartment_id', '=', 'apartments.id')
                            ->join('users', 'apartments.user_id', '=', 'users.id')
                            ->where('user_id',$user_id)
                            ->get();

        return Inertia::render('Management/Messages', [
            'messages' => $messages,
        ]);
    }

        // GESTIONE DASHBOARD
        public function dashboard()
        {
            $user_firstname = Auth::user()->firstname;
            $user_id = Auth::user()->id;
            $views = View::join('apartments', 'views.apartment_id', '=', 'apartments.id')
                        ->join('users', 'apartments.user_id', '=', 'users.id')
                        ->where('user_id',$user_id)
                        ->get();

            return Inertia::render('Dashboard', [
                'views' => $views,
                'user_firstname' => $user_firstname,
            ]);
        }
}
