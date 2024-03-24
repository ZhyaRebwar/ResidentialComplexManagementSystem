<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\CreateMonthlyPaymentRequest;
use App\Models\MonthlyPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ControllersTraits\CheckingResults;

class UserMonthlyPaymentController extends Controller
{
    use CheckingResults;

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

    public function current_month(Request $request)
    {
        //check if the user is in this house or not...
        //I believe no need because we already have it in the front end...
        //it is also better to check(not done yet).

        $property = $request->property_type . '-' . $request->property_id;

        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();

        $payments = MonthlyPayment::join('property_fees', 'monthly_payments.property_fee_id', '=', 'property_fees.id')
                                    ->join('fees', 'property_fees.fee_id', '=', 'fees.id')
                                    ->whereBetween('fees.start_date', [$currentMonthStart, $currentMonthEnd])
                                    ->where('property', $property)
                                    ->select('fees.*', 'property_fees.*', 'monthly_payments.*')
                                    ->get();


        return response()->json($payments);
    }

    public function pay_month_fee(Request $request)
    {
        
        $property = $request->property_type . '-' . $request->property_id;

        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();

        if(Auth::check())
        {
            $user = Auth::user();

            $payments = MonthlyPayment::join('property_fees', 'monthly_payments.property_fee_id', '=', 'property_fees.id')
                                        ->join('fees', 'property_fees.fee_id', '=', 'fees.id')
                                        ->whereBetween('fees.start_date', [$currentMonthStart, $currentMonthEnd])
                                        ->where('property', $property)
                                        ->select('fees.*', 'property_fees.*', 'monthly_payments.*')
                                        ->update([
                                            'payment_date' => Carbon::now(),
                                            'paid_by' => $user->id,
                                            'is_paid' => true,
                                        ]);

            $result = $this->checkingResults(
                $payments,
                'The payment was successful',
                'Failed to make the payment'
            );

            return $result;
        }
    } 
}
