<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Flights;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');
Route::get('/flights', function () {
    return view('flights');
});
Route::get('/seats', function () {
    return view('seats');
});
Route::get('/payment', function () {
    return view('payment');
})->middleware('auth', 'verified');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
