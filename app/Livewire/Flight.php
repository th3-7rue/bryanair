<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    protected $fillable = [
        'departure_airport',
        'arrival_airport',
        'departure_datetime',
        'arrival_datetime',
        'aircraft',
        'airline_id',
        'base_price',
        // Add other relevant fields
    ];

    // Optional: Define relationships with other models if needed
    public function departureAirport()
    {
        return $this->belongsTo(Airport::class, 'departure_airport'); // Assuming foreign key
    }

    public function arrivalAirport()
    {
        return $this->belongsTo(Airport::class, 'arrival_airport'); // Assuming foreign key
    }



    // Optional: Define methods to search or filter flights

}
