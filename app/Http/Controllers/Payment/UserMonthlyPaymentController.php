<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\CreateMonthlyPaymentRequest;
use Illuminate\Support\Facades\Auth;

class UserMonthlyPaymentController extends Controller
{
    public function __construct ()
    {
        $this->middleware('auth:sanctum');
    }

    public function store (CreateMonthlyPaymentRequest $createMonthlyPaymentRequest)
    {
        $validate = $createMonthlyPaymentRequest->validated();

        if(Auth::check())
        {
            //check if this month is payed or not(only allowed for current month).

            //pay for which fee(house, electricity, water...)

            //pay for this month only

            //
        }   
    }
}
