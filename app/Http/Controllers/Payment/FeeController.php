<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\CreateFeeRequest;
use App\Models\Fee;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ControllersTraits\CheckingResults;
use App\Http\Controllers\ControllersTraits\GetValues;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FeeController extends Controller
{
    use CheckingResults, GetValues;

    public function __construct() 
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        if(Auth::check())
        {
            $fees = $this->getAllValues(Fee::class);

            return response()->json($fees);
        }
    }

    public function store (CreateFeeRequest $createFeeRequest)
    {
        $validate = $createFeeRequest->validated();

        if(Auth::check())
        {            
            $start_date = Carbon::now();

            DB::beginTransaction();

            $fee = Fee::create([
                ...$validate,
                'start_date' => $start_date,
            ]);

            DB::commit();

            $result = $this->checkingResults(
                $fee,
                'The fee added successfully',
                'Failed to make the fee'
            );

            return $result;
        }
    }
}
