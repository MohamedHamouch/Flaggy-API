<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('home');
});
Route::get('/home', function () {
    return view('home');
});


Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
});
Route::middleware(['auth'])->group(function () {
    Route::resource('countries', CountryController::class);
});

Route::get('/check', function () {
    dd([
        'is_authenticated' => Auth::check(),
        'user' => Auth::user(),
        'guard' => Auth::getDefaultDriver()
    ]);
})->middleware('auth');