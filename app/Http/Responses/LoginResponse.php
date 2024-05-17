<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{

    public function toResponse($request)
    {

        // below is the existing response
        // replace this with your own code
        // the user can be located with Auth facade

        // if url contains payment, redirect to payment page
        if (strpos(url()->previous(), 'payment') !== false) {
            return redirect()->intended('/payment');
        } else {
            return redirect()->intended(config('fortify.home'));
        }
    }
}
