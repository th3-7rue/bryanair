<?php

namespace App\Livewire;

use Livewire\Component;
use app\Models\User;
use App\Livewire\Booking;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class Payment extends Component
{
    public $goFlightId;
    public $returnFlightId;
    public $passengers;
    public $showPayment = false;
    public $paid = false;
    public $bookingId;
    public function mount()
    {
        if (!session('totalPrice')) {
            return redirect()->to('/');
        }
        $this->goFlightId = session('goFlightId');
        $this->returnFlightId = session('returnFlightId');
        $this->passengers = json_decode(session('passengers'), true);
    }
    public function render()
    {
        return view('livewire.payment');
    }
    public function confirm()
    {
        $this->bookingId = DB::table('bookings')->insertGetId([
            'goFlight' => $this->goFlightId,
            'backFlight' => $this->returnFlightId,
            'booking_date' => now(),
            'booking_status' => 'PENDING',
            'total_price' => session('totalPrice'),
        ]);


        DB::table('bookings_users')->insert([
            'booking' => $this->bookingId,
            'user' => auth()->user()->id,
        ]);


        // insert selected seats into database (search number in seats_aircraft and insert the id into seats_flight)
        // insert passengers into database
        if ($this->returnFlightId == null) {
            foreach ($this->passengers as $passenger) {
                DB::table('passengers')->insert([
                    'first_name' => $passenger['name'],
                    'last_name' => $passenger['surname'],
                    'age' => $passenger['age'],
                    'booking' => DB::table('bookings')->latest('id')->first()->id,
                    'goSeat' => DB::table('seats_aircraft')->where('number', $passenger['goSeat'])->where('aircraft', DB::table('flights')->where('id', $this->goFlightId)->first()->aircraft)->first()->id,
                    'backSeat' => null,
                ]);
            }
        } else {
            foreach ($this->passengers as $passenger) {
                DB::table('passengers')->insert([
                    'first_name' => $passenger['name'],
                    'last_name' => $passenger['surname'],
                    'age' => $passenger['age'],
                    'booking' => DB::table('bookings')->latest('id')->first()->id,
                    'goSeat' => DB::table('seats_aircraft')->where('number', $passenger['goSeat'])->where('aircraft', DB::table('flights')->where('id', $this->goFlightId)->first()->aircraft)->first()->id,
                    'backSeat' => DB::table('seats_aircraft')->where('number', $passenger['backSeat'])->where('aircraft', DB::table('flights')->where('id', $this->returnFlightId)->first()->aircraft)->first()->id,
                ]);
            }
        }
        // if no errors, showPayment = true

        $this->showPayment = true;
    }
    public function back()
    {
        return redirect()->to('/seats');
    }
    public function fakePay()
    {
        // update booking status
        DB::table('bookings')->where('id', $this->bookingId)->update(['booking_status' => 'CONFIRMED']);
        $this->paid = true;
        // clear session
        session()->forget('goFlightId');
        session()->forget('returnFlightId');
        session()->forget('passengers');
        session()->forget('totalPrice');
        session()->forget('selectedGoSeats');
        session()->forget('selectedBackSeats');
        session()->forget('departureDate');
        session()->forget('returnDate');
        session()->forget('departureAirport');
        session()->forget('arrivalAirport');
        session()->forget('selectedGoFlight');
        session()->forget('selectedReturnFlight');
        session()->forget('showBackSeats');
        session()->forget('showReturn');
        session()->forget('travelType');
        session()->forget('adults');
        session()->forget('children');
        session()->forget('infants');
        session()->forget('passengers');
    }
    /*     public function pay()
    {
        $user = auth()->user();
        $user->checkoutCharge(session('totalPrice') * 100, 'Biglietto aereo',1);
        session()->forget('totalPrice');
        return redirect()->to('/flights');
    } */
}
