<?php

namespace App\Livewire;

use Livewire\Attributes\Session;
use Livewire\Component;
use App\Models\Passenger;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;



class Dashboard extends Component
{
    public $bookings;
    public $flights;
    public function mount()
    {
        $this->bookings = DB::table('bookings')->join('bookings_users', 'bookings.id', '=', 'bookings_users.booking')->where('bookings_users.user', auth()->id())->where('booking_status', 'CONFIRMED')->select('*')->get();
        // get name of departure and arrival of go and return flights of each booking
        foreach ($this->bookings as $booking) {
            $booking->goDeparture = DB::table('flights')->where('flights.id', $booking->goFlight)->join('airports', 'flights.departure_airport', '=', 'airports.id')->select('airports.location')->first()->location;
            $booking->goArrival = DB::table('flights')->where('flights.id', $booking->goFlight)->join('airports', 'flights.arrival_airport', '=', 'airports.id')->select('airports.location')->first()->location;
            $booking->backDeparture = DB::table('flights')->where('flights.id', $booking->backFlight)->join('airports', 'flights.departure_airport', '=', 'airports.id')->select('airports.location')->first()->location ?? null;
            $booking->backArrival = DB::table('flights')->where('flights.id', $booking->backFlight)->join('airports', 'flights.arrival_airport', '=', 'airports.id')->select('airports.location')->first()->location ?? null;
            $booking->goDepartureDatetime = DB::table('flights')->where('flights.id', $booking->goFlight)->select('departure_datetime')->first()->departure_datetime;
            $booking->goArrivalDatetime = DB::table('flights')->where('flights.id', $booking->goFlight)->select('arrival_datetime')->first()->arrival_datetime;
            $booking->backDepartureDatetime = DB::table('flights')->where('flights.id', $booking->backFlight)->select('departure_datetime')->first()->departure_datetime ?? null;
            $booking->backArrivalDatetime = DB::table('flights')->where('flights.id', $booking->backFlight)->select('arrival_datetime')->first()->arrival_datetime ?? null;
            $booking->price = DB::table('bookings')->where('id', $booking->id)->select('total_price')->first()->total_price;
            $booking->goAirline = DB::table('flights')->where('flights.id', $booking->goFlight)->join('airlines', 'flights.airline_id', '=', 'airlines.airline_id')->select('airlines.name')->first()->name;
            $booking->backAirline = DB::table('flights')->where('flights.id', $booking->backFlight)->join('airlines', 'flights.airline_id', '=', 'airlines.airline_id')->select('airlines.name')->first()->name ?? null;
        }
    }
}
