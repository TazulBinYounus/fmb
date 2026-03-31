<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/our-management', function () {
    return view('management');
});

Route::get('/development', function () {
    return view('development');
});

Route::get('/collection/men-knit', function () {
    return view('collection-men-knit');
});
Route::get('/collection/women-knit', function () {
    return view('collection-women-knit');
});
Route::get('/collection/kid-knit', function () {
    return view('collection-kid-knit');
});
Route::get('/collection/home-tex', function () {
    return view('collection-home-tex');
});
