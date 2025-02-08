<?php

use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\DevisController;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;


Route::get('/devis-apercu', [DevisController::class, 'apercu'])->name('devis_apercu');

Route::get('/generate-quote', [DevisController::class, 'store'])->name('generate_quote');

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fr', 'es'])) {
        Session::put('locale', $locale);
        App::setLocale($locale);
    }
    return redirect()->back();
})->name('changeLang');



Route::post('/devis', [DevisController::class, 'store'])->name('devis.store');

Route::get('/DEVIS', [QuoteController::class, 'index']);
Route::get('/send-quote', [QuoteController::class, 'sendQuote'])->name('quote.send');

Route::post('/envoyer-devis', [DevisController::class, 'envoyerDevis'])->name('envoyer_devis');



Route::get('/', function () {
    return view('devis');
});

