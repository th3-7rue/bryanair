<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    protected $fillable = [
        'IATA',
        'name',
        'location',
        'time',
        'DST',
    ];

    // Optional: Define relationships with other models if needed
    public function departureFlights()
    {
        return $this->hasMany(Flight::class, 'departure_airport'); // Assuming foreign key
    }

    public function arrivalFlights()
    {
        return $this->hasMany(Flight::class, 'arrival_airport'); // Assuming foreign key
    }
}
