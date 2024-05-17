<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Database\Query\Builder;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;

class Landing extends Component
{
    public $showingPassengers = false;

    public $airportsSelected = false;
    public $searchTerm = '';
    public $searchTermA = '';
    #[Validate('required')]
    public $selectedAirportId = null;
    #[Validate('required')]
    public $selectedAirportIdA = null;

    public $airports;
    public $airportsA;
    public $departureAirport = null;
    public $arrivalAirport = null;
    #[Validate('required', 'date')]
    public $departureDate = null;
    #[Validate('required_if:travelType,two-ways', 'date', message: 'Scegli una data di ritorno')]
    #[Validate('exclude_if:travelType,one-way|after_or_equal:departureDate', message: 'La data di ritorno non può essere antecedente la data di partenza')]
    public $returnDate = null;
    #[Url]
    public $travelType = 'two-ways'; // Set default travel type
    public $adults = 1;

    public $children = 0;

    public $infants = 0;
    public $showDeparture = false;
    public $showArrival = false;
    public function toggleDeparture()
    {
        $this->showDeparture = !$this->showDeparture;
        $this->showArrival = false;
    }
    public function toggleArrival()
    {
        $this->showArrival = !$this->showArrival;
        $this->showDeparture = false;
    }
    public function hideAirports()
    {
        $this->showDeparture = false;
        $this->showArrival = false;
    }

    public function updateTravelType($value)
    {
        if ($value == 'one-way') {
            $this->returnDate = null;
        }
        $this->travelType = $value;
        $this->render();
    }
    public function mount()
    {
        if (session('travelType')) {
            $this->travelType = session('travelType');
        }
        if (session('departureAirport')) {
            $this->selectedAirportId = session('departureAirport');
            $this->departureAirport = session('departureAirport');
            // select location and IATA
            $query = DB::table('airports')->select('IATA', 'location')->where('id', $this->selectedAirportId)->get();
            // truncate location on first comma
            $this->searchTerm = explode(',', $query[0]->location)[0] . ' - ' . $query[0]->IATA;
        }
        if (session('arrivalAirport')) {
            $this->selectedAirportIdA = session('arrivalAirport');
            $this->arrivalAirport = session('arrivalAirport');
            $query = DB::table('airports')->select('IATA', 'location')->where('id', $this->selectedAirportIdA)->get();
            // truncate location on first comma
            $this->searchTermA = explode(',', $query[0]->location)[0] . ' - ' . $query[0]->IATA;
        }
        if (session('departureDate')) {
            $this->departureDate = session('departureDate');
        }
        if (session('returnDate')) {
            $this->returnDate = session('returnDate');
        }
        if (session('adults')) {
            $this->adults = session('adults');
        }
        if (session('children')) {
            $this->children = session('children');
        }
        if (session('infants')) {
            $this->infants = session('infants');
        }
    }
    public function render()
    {
        // if session data is available, set the values
        if (empty($this->searchTerm)) {
            $this->resetDeparture();
        }
        if (empty($this->searchTermA)) {
            $this->resetArrival();
        }
        if (!empty($this->arrivalAirport)) {
            $this->airports = DB::table('airports')
                ->select('airports.id', 'IATA', 'name', 'location')
                // Check for airports present in flights table as departure airports
                ->join('flights', function ($join) {
                    $join->on('airports.id', '=', 'flights.departure_airport');
                })
                ->whereNotNull('flights.departure_airport')  // Ensure non-null departure airport
                ->where('flights.departure_airport', '<>', $this->selectedAirportIdA) // Ensure departure airport is not the same as the arrival airport
                ->where('flights.arrival_airport', '=', $this->selectedAirportIdA) // Ensure arrival airport is the same as the selected arrival airport
                ->where('flights.departure_datetime', '>=', now()) // Ensure departure date is in the future
                ->where(function (Builder $query) {
                    $query->where('IATA', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('name', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('location', 'like', '%' . $this->searchTerm . '%');
                })
                ->limit(10)
                ->distinct()
                ->get();
        } else {
            $this->airports = DB::table('airports')
                ->select('airports.id', 'IATA', 'name', 'location')
                ->where('airports.id', '<>', $this->selectedAirportIdA)
                ->join('flights', function ($join) {
                    $join->on('airports.id', '=', 'flights.departure_airport');
                })
                ->whereNotNull('flights.departure_airport')
                ->where('flights.departure_datetime', '>=', now()) // Ensure departure date is in the future

                ->where(function (Builder $query) {
                    $query->where('IATA', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('name', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('location', 'like', '%' . $this->searchTerm . '%');
                })
                ->limit(10)
                ->distinct()
                ->get();
        }
        if (!empty($this->departureAirport)) {
            $this->airportsA = DB::table('airports')
                ->select('airports.id', 'IATA', 'name', 'location')
                ->join('flights', function ($join) {
                    $join->on('airports.id', '=', 'flights.arrival_airport');
                })
                ->whereNotNull('flights.arrival_airport')
                ->where('flights.arrival_airport', '<>', $this->selectedAirportId)
                ->where('flights.departure_airport', '=', $this->selectedAirportId)
                ->where('flights.departure_datetime', '>=', now()) // Ensure departure date is in the future

                ->where(function (Builder $query) {
                    $query->where('IATA', 'like', '%' . $this->searchTermA . '%')
                        ->orWhere('name', 'like', '%' . $this->searchTermA . '%')
                        ->orWhere('location', 'like', '%' . $this->searchTermA . '%');
                })
                ->limit(10)
                ->distinct()
                ->get();
        } else {
            $this->airportsA = DB::table('airports')
                ->select('airports.id', 'IATA', 'name', 'location')
                ->join('flights', function ($join) {
                    $join->on('airports.id', '=', 'flights.arrival_airport');
                })
                ->where('airports.id', '<>', $this->selectedAirportId)
                ->where('flights.departure_datetime', '>=', now()) // Ensure departure date is in the future

                ->whereNotNull('flights.arrival_airport')
                ->where(function (Builder $query) {
                    $query->where('IATA', 'like', '%' . $this->searchTermA . '%')
                        ->orWhere('name', 'like', '%' . $this->searchTermA . '%')
                        ->orWhere('location', 'like', '%' . $this->searchTermA . '%');
                })
                ->limit(10)
                ->distinct()
                ->get();
        }

        return view('livewire.landing');
    }

    public function selectAirport($airportId)
    {
        $this->selectedAirportId = $airportId;
        $location = explode(',', $this->airports->where('id', $airportId)->first()->location)[0];
        $this->searchTerm = $this->airports->where('id', $airportId)->first()
            ->IATA . ' - ' . $location; // add location

        // Add any additional logic here, such as:
        // - Filtering the $airportsA list based on the selected departure airport (if applicable)
        // - Performing other actions related to the selection
        // stop the search
        $this->departureAirport = $this->selectedAirportId;

        $this->airports = '';
        // update session data
        session(['departureAirport' => $this->departureAirport]);
        $this->airportsSelected();
    }
    /* if both departure and arrival airports are selecte dispatch an event */


    public function selectAirportA($airportId)
    {
        $this->selectedAirportIdA = $airportId;

        // truncate location on first comma
        $location = explode(',', $this->airportsA->where('id', $airportId)->first()->location)[0];
        $this->searchTermA = $this->airportsA->where('id', $airportId)->first()->IATA
            . ' - ' . $location; // add location


        $this->arrivalAirport = $this->selectedAirportIdA;
        $this->airportsA = '';
        // update session data
        session(['arrivalAirport' => $this->arrivalAirport]);
        $this->airportsSelected();
    }
    public function airportsSelected()
    {
        if ($this->selectedAirportId && $this->selectedAirportIdA) {
            $this->airportsSelected = true;
        } else {
            $this->airportsSelected = false;
        }
    }
    public function swap()
    {
        $temp = $this->selectedAirportId;
        $this->selectedAirportId = $this->selectedAirportIdA;
        $this->selectedAirportIdA = $temp;

        $temp = $this->searchTerm;
        $this->searchTerm = $this->searchTermA;
        $this->searchTermA = $temp;

        $temp = $this->departureAirport;
        $this->departureAirport = $this->arrivalAirport;
        $this->arrivalAirport = $temp;

        session(['departureAirport' => $this->departureAirport]);
        session(['arrivalAirport' => $this->arrivalAirport]);
    }
    public function resetDeparture()
    {
        $this->searchTerm = '';
        $this->selectedAirportId = null;
        $this->airports = '';
        $this->departureAirport = null;
        session(['departureAirport' => $this->departureAirport]);
    }
    public function resetArrival()
    {
        $this->searchTermA = '';
        $this->selectedAirportIdA = null;
        $this->airportsA = '';
        $this->arrivalAirport = null;
        session(['arrivalAirport' => $this->arrivalAirport]);
    }
    public function closePassengers()
    {
        $this->showingPassengers = false;
    }
    public function showPassengers()
    {
        $this->showingPassengers = true;
    }


    public function incrementAdults()
    {
        $this->adults++;
    }

    public function decrementAdults()
    {
        if ($this->adults > 0) {
            $this->adults--;
        }
    }
    public function incrementChildren()
    {

        $this->children++;
    }
    public function decrementChildren()
    {
        if ($this->children > 0) {
            $this->children--;
        }
    }
    public function incrementInfants()
    {
        if ($this->infants < $this->adults) {
            $this->infants++;
        }
    }
    public function decrementInfants()
    {
        if ($this->infants > 0) {
            $this->infants--;
        }
    }
    public function search()
    {
        //dd($this->travelType, $this->departureAirport, $this->arrivalAirport, $this->departureDate, $this->returnDate, $this->adults, $this->children, $this->infants);
        $this->validate();
        session(['travelType' => $this->travelType,]);
        session(['departureAirport' => $this->departureAirport,]);
        session(['arrivalAirport' => $this->arrivalAirport,]);
        session(['departureDate' => $this->departureDate,]);
        session(['returnDate' => $this->returnDate,]);
        session(['adults' => $this->adults,]);
        session(['children' => $this->children,]);
        session(['infants' => $this->infants,]);

        $this->redirect('/flights', navigate: true);
    }
}
