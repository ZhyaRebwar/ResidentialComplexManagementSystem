<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\CreateFeeRequest;
use App\Models\Fee;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ControllersTraits\CheckingResults;
use App\Http\Controllers\ControllersTraits\GetValues;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeeController extends Controller
{
    use CheckingResults, GetValues, CheckingResults;

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

    public function update(Request $request, string $id)
    {
        $request->only(['amount']);

        $update = Fee::where('id', $id)->update([ 'amount' => $request->amount ]);

        $result = $this->checkingResults(
            $update,
            'The fee has been updated',
            'Failed to update the fee'
        );

        return $result;
    }

    public function destroy(string $id)
    {
        if(Auth::check())
        {
            $delete = Fee::where('id', $id)->delete();

            $result = $this->checkingResults(
                $delete,
                'The Fee deleted successfully',
                'Failed to delete the fee'
            );

            return $result;
        }
    }
}
