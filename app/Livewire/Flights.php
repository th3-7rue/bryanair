<?php

namespace App\Livewire;

use Livewire\Attributes\Session;
use Livewire\Component;
use App\Models\Passenger;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;


class Flights extends Component
{

    // retrieve data from session
    public $travelType;
    public $departureAirport;
    public $arrivalAirport;
    public $departureDate;
    public $returnDate;
    public $adults;
    public $children;
    public $infants;

    public $goFlights;
    public $goDepartureAirportName;
    public $goArrivalAirportName;
    public $returnFlights;
    public $returnDepartureAirportName;
    public $returnArrivalAirportName;
    public $departureIATA;
    public $arrivalIATA;
    public $selectedGoFlight;
    public $selectedReturnFlight;
    public $goFlightId;
    public $returnFlightId;
    public $totalPrice;
    public $adultsNames = [];
    public $childrenNames = [];
    public $infantsNames = [];
    public function mount()
    {
        if (!session('travelType')) {
            return redirect()->route('welcome');
        }
        $this->travelType = session('travelType');
        $this->departureAirport = session('departureAirport');
        $this->arrivalAirport = session('arrivalAirport');
        $this->departureDate = session('departureDate');
        $this->returnDate = session('returnDate');
        $this->adults = session('adults');
        $this->children = session('children');
        $this->infants = session('infants');
        $this->goFlightId = session('goFlightId');
        $this->returnFlightId = session('returnFlightId');
        $this->selectedGoFlight = session('selectedGoFlight');
        $this->selectedReturnFlight = session('selectedReturnFlight');
        $this->updateFlights();
    }
    public function updateFlights()
    {
        $this->getGoFlights();
        if ($this->travelType == 'two-ways') {
            $this->getReturnFlights();
        }
        //$this->render();
    }
    public function render()
    {

        return view('livewire.flights');
    }
    public function selectGoFlight($flightId)
    {
        $this->goFlightId = $flightId;
        session(['goFlightId' => $flightId]);

        $this->selectedGoFlight = Flight::select('flights.*', 'airlines.name as airline_name')
            ->join('airlines', 'flights.airline_id', '=', 'airlines.airline_id')
            ->where('flights.id', $flightId)
            ->first();
        session(['selectedGoFlight' => $this->selectedGoFlight]);
        $this->redirect(request()->header('Referer'), navigate: true);
    }
    public function selectReturnFlight($flightId)
    {
        $this->returnFlightId = $flightId;
        session(['returnFlightId' => $flightId]);

        $this->selectedReturnFlight = Flight::select('flights.*', 'airlines.name as airline_name')
            ->join('airlines', 'flights.airline_id', '=', 'airlines.airline_id')
            ->where('flights.id', $flightId)
            ->first();
        session(['selectedReturnFlight' => $this->selectedReturnFlight]);
        $this->redirect(request()->header('Referer'), navigate: true);
    }
    public function deselectGoFlight()
    {
        $this->goFlightId = null;
        session(['goFlightId' => null]);
        $this->selectedGoFlight = null;
        session(['selectedGoFlight' => null]);
        //$this->updateFlights();
        $this->redirect(request()->header('Referer'), navigate: true);
    }
    public function deselectReturnFlight()
    {
        $this->returnFlightId = null;
        session(['returnFlightId' => null]);
        $this->selectedReturnFlight = null;
        session(['selectedReturnFlight' => null]);
        //$this->updateFlights();
        $this->redirect(request()->header('Referer'), navigate: true);
    }
    public function showSearch()
    {
        $this->redirect('welcome', navigate: true);
    }
    public function getGoFlights()
    {
        // get flights from the database
        $this->goFlights = Flight::select('flights.*', 'airlines.name as airline_name')
            ->join('airlines', 'flights.airline_id', '=', 'airlines.airline_id')
            ->where('departure_airport', $this->departureAirport)
            ->where('arrival_airport', $this->arrivalAirport)
            // where departure date is the same day as the selected departure date
            ->whereDate('departure_datetime', $this->departureDate)
            ->get();
        $this->departureIATA = Airport::where('id', $this->departureAirport)->first()->IATA;
        $this->goDepartureAirportName = Airport::where('id', $this->departureAirport)->first()->location;
        // truncate after first comma
        $this->goDepartureAirportName = explode(',', $this->goDepartureAirportName)[0];
        $this->arrivalIATA = Airport::where('id', $this->arrivalAirport)->first()->IATA;
        $this->goArrivalAirportName = Airport::where('id', $this->arrivalAirport)->first()->location;
        // truncate after first comma
        $this->goArrivalAirportName = explode(',', $this->goArrivalAirportName)[0];
    }
    public function getReturnFlights()
    {
        // get flights from the database
        $this->returnFlights = Flight::select('flights.*', 'airlines.name as airline_name')
            ->join('airlines', 'flights.airline_id', '=', 'airlines.airline_id')
            ->where('departure_airport', $this->arrivalAirport)
            ->where('arrival_airport', $this->departureAirport)
            // where departure date is the same day as the selected departure date
            ->whereDate('departure_datetime', $this->returnDate)
            ->get();
        $this->returnDepartureAirportName = Airport::where('id', $this->arrivalAirport)->first()->location;
        // truncate after first comma
        $this->returnDepartureAirportName = explode(',', $this->returnDepartureAirportName)[0];
        $this->returnArrivalAirportName = Airport::where('id', $this->departureAirport)->first()->location;
        // truncate after first comma
        $this->returnArrivalAirportName = explode(',', $this->returnArrivalAirportName)[0];
    }
    public function goDateBefore()
    {
        $this->departureDate = date('Y-m-d', strtotime($this->departureDate . ' -1 day'));
        session(['departureDate' => $this->departureDate]);
        $this->updateFlights();
        $this->redirect(request()->header('Referer'), navigate: true);
    }
    public function goDateAfter()
    {
        $this->departureDate = date('Y-m-d', strtotime($this->departureDate . ' +1 day'));
        session(['departureDate' => $this->departureDate]);
        $this->updateFlights();
        $this->redirect(request()->header('Referer'), navigate: true);
    }
    public function returnDateBefore()
    {
        $this->returnDate = date('Y-m-d', strtotime($this->returnDate . ' -1 day'));
        session(['returnDate' => $this->returnDate]);
        $this->updateFlights();
        $this->redirect(request()->header('Referer'), navigate: true);
    }
    public function returnDateAfter()
    {
        $this->returnDate = date('Y-m-d', strtotime($this->returnDate . ' +1 day'));
        session(['returnDate' => $this->returnDate]);
        $this->updateFlights();
        $this->redirect(request()->header('Referer'), navigate: true);
    }
    public function calcPrice()
    {
        $goPrice = $this->selectedGoFlight->base_price;
        $returnPrice = $this->selectedReturnFlight->base_price ?? 0;
        $this->totalPrice = ($goPrice + $returnPrice) * $this->adults + ($goPrice + $returnPrice) * $this->children * 0.8 + ($goPrice + $returnPrice) * $this->infants * 0.5;
        session(['totalPrice' => $this->totalPrice]);
        return $this->totalPrice;
    }
    public function goToSeats()
    {
        if (
            // custom messages
            $this->validate([
                'selectedGoFlight' => 'required',
                'selectedReturnFlight' => 'required_if:travelType,two-ways',
                'adultsNames.*.name' => 'required|string|min:2',

                'adultsNames.*.surname' => 'required|string|min:2',
                'childrenNames.*.name' => 'required|string|min:2',
                'childrenNames.*.surname' => 'required|string|min:2',
                'infantsNames.*.name' => 'required|string|min:2',
                'infantsNames.*.surname' => 'required|string|min:2',
            ])
        ) {
            // create the passengers
            $passengers = [];
            foreach ($this->adultsNames as $adult) {
                $passenger = new Passenger($adult['name'], $adult['surname'], 1);
                array_push($passengers, $passenger);
            }
            foreach ($this->childrenNames as $child) {
                $passenger = new Passenger($child['name'], $child['surname'], 2);
                array_push($passengers, $passenger);
            }
            foreach ($this->infantsNames as $infant) {
                $passenger = new Passenger($infant['name'], $infant['surname'], 3);
                array_push($passengers, $passenger);
            }

            session(['passengers' => json_encode($passengers, true)]);
            $this->redirect('/seats', navigate: true);
        }
    }
}
