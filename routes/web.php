<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

Route::view('/register', 'Forms.register')->name('register');
Route::view('/login', 'Forms.login')->name('login');
Route::view('/properties', 'Catalogo.index')->name('properties');

//Rutas no activas aún
//Eenseña la vista individual de la casa
//Route::view('/properties/{id}', 'catalogo.show')->name('properties.show');

Route::middleware("guest")->group(function () {
    Route::view('/register', 'Forms.register')->name('register');
    Route::view('/login', 'Forms.login')->name('login');
});
Route::middleware("auth")->group(function () {

});
