<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'goFlight',
        'backFlight',
        'booking_date',
        'booking_status',
        'total_price',
    ];

    // Optional: Define relationships with other models if needed
    public function flight()
    {
        return $this->belongsTo(Flight::class, 'flight_id'); // Assuming foreign key
    }
}
