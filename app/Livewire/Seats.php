<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\DB;

class Seats extends Component
{
    public $goAircraft;
    public $backAircraft;
    public $bookingId;
    public $selectedPassenger = 0;
    public $passengers = [];
    public $goSeats;
    public $backSeats;
    public $goFlightId;
    public $returnFlightId;
    public $originIata;
    public $destinationIata;
    #[Url]
    public $selectedGoSeats = [];
    #[Url]
    public $selectedBackSeats = [];
    public $occupiedGoSeats = [];
    public $occupiedBackSeats = [];
    public $corridoio = [
        4,
        10,
        16,
        22,
        28,
        34,
        40, 46, 52, 58, 64, 70, 76, 82, 88, 94, 100, 106, 112, 118, 124, 130, 136, 142, 148, 154, 160, 166, 172, 178, 184, 190, 196, 202, 208, 214, 220, 226, 232, 238, 244, 250, 256, 262, 268, 274, 280, 286, 292, 298, 304, 310, 316, 322, 328, 334, 340, 346
    ];
    public $goSeatsAssigned = false;
    public $backSeatsAssigned = false;
    public $showBackSeats = false;
    public function mount()
    {
        // if session is empty, redirect to the homepage
        if (!session('goFlightId')) {
            return redirect()->to('/flights');
        }
        if (!session('passengers')) {
            return redirect()->to('/flights');
        }
        $this->goAircraft = DB::table('flights')->where('flights.id', session('goFlightId'))->join('aircrafts', 'flights.aircraft', '=', 'aircrafts.id')->select('aircrafts.name')->first()->name;
        if (session('returnFlightId')) {
            $this->backAircraft = DB::table('flights')->where('flights.id', session('returnFlightId'))->join('aircrafts', 'flights.aircraft', '=', 'aircrafts.id')->select('aircrafts.name')->first()->name;
        }
        // get the passengers from the session
        $this->passengers = json_decode(session('passengers'), true);
        // $this->selectedGoSeats = json_decode(session('selectedGoSeats'), true) ?? [];
        //   $this->selectedBackSeats = json_decode(session('selectedBackSeats'), true) ?? [];
        //  $this->selectedPassenger = session('selectedPassenger') ?? 0;
        // get the flight id
        $this->goFlightId = session('goFlightId');
        $this->returnFlightId = session('returnFlightId');
        // get the seats from database
        // get the origin and destination IATA codes
        $this->originIata = Airport::where('id', Flight::where('id', $this->goFlightId)->first()->departure_airport)->first()->IATA;
        $this->destinationIata = Airport::where('id', Flight::where('id', $this->goFlightId)->first()->arrival_airport)->first()->IATA;
        // $this->showBackSeats = session('showBackSeats') ?? false;

        $this->getOccupiedGoSeats();
    }
    public function render()
    {
        $this->goSeats = $this->getGoSeats();
        if ($this->showBackSeats) {
            $this->backSeats = $this->getBackSeats();
        }
        if (count($this->selectedGoSeats) == count($this->passengers)) {
            $this->goSeatsAssigned = true;
        }
        if (count($this->selectedBackSeats) == count($this->passengers)) {
            $this->backSeatsAssigned = true;
        }

        return view('livewire.seats');
    }
    public function getGoSeats()
    {
        // get the seats from the database
        $seats = DB::table('flights')->where('flights.id', $this->goFlightId)->join('seats_aircraft', 'flights.aircraft', '=', 'seats_aircraft.aircraft')->select('seats_aircraft.*')->distinct()->get();
        return $seats;
    }
    public function getBackSeats()
    {
        // get the seats from the database
        $seats = DB::table('flights')->where('flights.id', $this->returnFlightId)->join('seats_aircraft', 'flights.aircraft', '=', 'seats_aircraft.aircraft')->select('seats_aircraft.*')->distinct()->get();
        return $seats;
    }
    public function getOccupiedGoSeats()
    {
        // get the occupied seats from the database
        $this->occupiedGoSeats = DB::table('passengers')->join('seats_aircraft', 'passengers.goSeat', '=', 'seats_aircraft.id')->join('bookings', 'passengers.booking', '=', 'bookings.id')->where('bookings.goFlight', $this->goFlightId)->select('seats_aircraft.number')->distinct()->get()->pluck('number')->toArray();
    }
    public function getOccupiedBackSeats()
    {
        // get the occupied seats from the database
        $this->occupiedBackSeats = DB::table('passengers')->join('seats_aircraft', 'passengers.backSeat', '=', 'seats_aircraft.id')->join('bookings', 'passengers.booking', '=', 'bookings.id')->where('bookings.backFlight', $this->returnFlightId)->select('seats_aircraft.number')->distinct()->get()->pluck('number')->toArray();
    }
    public function selectGoSeat($seatId, $seatNumber)
    {
        // if the seat is already selected by the same passenger, deselect it
        if (isset($this->selectedGoSeats[$this->selectedPassenger]))
            $this->deselectGoSeat();
        $this->passengers[$this->selectedPassenger]['goSeat'] = $seatNumber;
        session(['passengers' => json_encode($this->passengers)]);
        $this->selectedGoSeats[$this->selectedPassenger] = $seatNumber;
        // Avanzamento automatico al prossimo passeggero
        if ($this->selectedPassenger < count($this->passengers) - 1)
            $this->selectedPassenger++;
        // if all passengers have selected a seat, goSeatsAssigned is true
        if (count($this->selectedGoSeats) == count($this->passengers)) {
            $this->goSeatsAssigned = true;
            //return redirect(request()->header('Referer'));
        }
        $this->render();
    }
    public function selectBackSeat($seatId, $seatNumber)
    {
        // if the seat is already selected by the same passenger, deselect it
        // check if null
        if (isset($this->selectedBackSeats[$this->selectedPassenger]))
            $this->deselectBackSeat();
        $this->passengers[$this->selectedPassenger]['backSeat'] = $seatNumber;
        $this->passengers[$this->selectedPassenger]['backSeatId'] = $seatId;
        // session(['passengers' => json_encode($this->passengers)]);
        $this->selectedBackSeats[$this->selectedPassenger] = $seatNumber;
        // session(['selectedBackSeats' => json_encode($this->selectedBackSeats)]);
        // Avanzamento automatico al prossimo passeggero
        if ($this->selectedPassenger < count($this->passengers) - 1)
            $this->selectedPassenger++;
        // if all passengers have selected a seat, backSeatsAssigned is true
        if (count($this->selectedBackSeats) == count($this->passengers)) {
            $this->backSeatsAssigned = true;
            //return redirect(request()->header('Referer'));
        }

        $this->render();
    }
    public function deselectGoSeat()
    {
        unset($this->passengers[$this->selectedPassenger]['goSeat']);
        unset($this->selectedGoSeats[$this->selectedPassenger]);

        //  session(['selectedGoSeats' => json_encode($this->selectedGoSeats)]);
        session(['passengers' => json_encode($this->passengers)]);
        //return redirect(request()->header('Referer'));
    }
    public function deselectBackSeat()
    {
        unset($this->passengers[$this->selectedPassenger]['backSeat']);
        unset($this->selectedBackSeats[$this->selectedPassenger]);
        //  session(['selectedBackSeats' => json_encode($this->selectedBackSeats)]);
        session(['passengers' => json_encode($this->passengers)]);
    }
    public function goToNextStep()
    {
        if (session('travelType') == 'two-ways' && !$this->showBackSeats) {
            $this->showBackSeats = true;
            $this->getOccupiedBackSeats();
            $this->selectedPassenger = 0;
            //dump($this->showBackSeats);
            // session(['showBackSeats' => $this->showBackSeats]);
            //return redirect(request()->header('Referer'));
        } else {
            $this->goToPayment();
        }
    }
    public function selectPassenger($passenger)
    {
        $this->selectedPassenger = $passenger;
        // session(['selectedPassenger' => $this->selectedPassenger]);
    }
    public function goToPayment()
    {

        // save the passengers in the session
        session(['passengers' => json_encode($this->passengers)]);
        return redirect()->to('/payment');
    }
    public function goBack()
    {
        if ($this->showBackSeats) {
            $this->showBackSeats = false;
            // session(['showBackSeats' => $this->showBackSeats]);
            //return redirect(request()->header('Referer'));
        } else {
            $this->redirect('/flights', navigate: true);
        }
    }
}
