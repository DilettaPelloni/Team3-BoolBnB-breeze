<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Controllers
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\PaymentController;

//Model
use App\Models\Apartment;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//HOME PAGE
Route::get('/', [PageController::class, 'home'])->name('welcome');

//PAGINA SEARCH
Route::get('/ricerca', [PageController::class, 'search'])->name('search');
Route::post('/ricerca', [PageController::class, 'apartmentSearch'])->name('apartmentSearch');

//PAGINA APPARTAMENTO
Route::get('/scopri/{title_slug}', [PageController::class, 'show'])->name('guest_show');

//IMMAGAZZINARE MESSAGGI
Route::post('/messages', [MessagesController::class, 'store'])->name('messages.store');


//PAGINE SOLO PER UTENTI LOGGATI
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource("gestione-appartamenti", ApartmentController::class);
    Route::get('/dashboard', [ApartmentController::class, 'dashboard'])->name('dashboard');
    Route::get('/messaggi', [ApartmentController::class, 'messages'])->name('messages.index');
    Route::get('/sponsorizzazioni', [ApartmentController::class, 'sponsorship'])->name('sponsorship');
});

//PER CREARE UNA NUOVA SPONSORIZZAZIONE
Route::post('avtiveSponsoship/create', [PaymentController::class, 'createActiveSponsoship'])->name('createActiveSponsoship');





//VECCHIA ROUTE DASHBOARD
// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/prova', function () {
    return Inertia::render('prova');
})->middleware(['auth', 'verified'])->name('prova');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__ . '/auth.php';
