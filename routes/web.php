<?php

use App\Http\Controllers\ContactController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('/contact', 'contact');
Route::post('/contact', [ContactController::class, 'send'])
    ->middleware('throttle:5,1')
    ->name('contact.send');

Route::view('/our-management', 'management');
Route::view('/development', 'development');               // FMB Developments Ltd (real estate)
Route::view('/garments/services', 'garments-services');

Route::view('/collection/men-knit', 'collection-men-knit');
Route::view('/collection/women-knit', 'collection-women-knit');
Route::view('/collection/kid-knit', 'collection-kid-knit');
Route::view('/collection/home-tex', 'collection-home-tex');

// Language switch: English / বাংলা
Route::get('/lang/{locale}', function (string $locale) {
    abort_unless(in_array($locale, SetLocale::SUPPORTED, true), 404);
    session(['locale' => $locale]);

    return back();
})->name('lang.switch');
