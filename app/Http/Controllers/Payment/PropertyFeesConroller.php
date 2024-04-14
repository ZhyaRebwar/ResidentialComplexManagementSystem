<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersTraits\CheckingResults;
use App\Http\Requests\Property\CreatePropertyFeeRequest;
use App\Models\PropertyFees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ControllersTraits\GetValues;

class PropertyFeesConroller extends Controller
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
            $properties_fees = PropertyFees::all();

            return response()->json($properties_fees);
        }
    }

    public function store(CreatePropertyFeeRequest $createPropertyFeeRequest)
    {
        $validate = $createPropertyFeeRequest->validated();

        if(Auth::check())
        {
            $model = 'App\\Models\\';
            if($validate['property'] == 'houses')
                $model .= 'House';
            else    
                $model .= 'Apartment';
            
            // $property_check = $model::find( $validate['property_id'] );
            $property_check = $this->getValueId($model, $validate['property_id']);
            
            if( !empty($property_check) )
            {
                $property = $validate['property'] . '-' . $validate['property_id'];

                $property_fees = PropertyFees::where('fee_id', $validate['fee_id'])
                                        ->where('property', $property)
                                        ->get()
                                        ->first();
                
                if( !$property_fees )
                {
                    $property_fees_create = PropertyFees::create([ 
                        'fee_id' => $validate['fee_id'],
                        'property' => $property,
                        'start_date' => $validate['start_date'],
                        'end_date' => $validate['end_date']
                    ]);

                    $result = $this->checkingResults(
                        $property_fees_create,
                        'The fee assigned to the property',
                        'The fee could not be assigned to the fee'
                    );

                    return $result;
                } else
                {
                    return response()->json(['result' => 'Failed', 'Message' => 'The fee is already assigned to the property']);
                }

            } else 
            {
                return response()->json([
                    'result' => 'Failed',
                    'message' => 'The property does not exist',
                    
                ]);
            }
        } else
        {
            return response()->json(['result' => 'Could not assign property to the fee', !empty($property_check) ]);
        }

        
    }

    public function update(Request $request, string $id)
    {
        $request->only(['property','property_id', 'start_date', 'end_date']);

        $validate = $request->validate([]);

        $update = PropertyFees::where('id', $id)->update($validate);

        $result = $this->checkingResults(
            $update,
            'The property fee updated successfully',
            'Failed to update the property fee'
        );

        return $result;
    }

    //get all fees of all types of a specific house.
    public function house_payments(Request $request)
    {
        if(Auth::check())
        {
            $user = Auth::user();

            //the url params
            $house_fees = $request;
            $property = $house_fees['property'] . '-' . $house_fees['house_id'];

            $property_fee = PropertyFees::where('property_fees.property', $property)
                    ->join('fees', 'fees.id', 'property_fees.fee_id')
                    ->get();

            return response()->json($property_fee);
        }
    }

    public function property_fees(Request $request)
    {
        if(Auth::check())
        {
            $property_fees = PropertyFees::where('property', $request->property . '-' . $request->property_id)
                                            ->get();

            return response()->json($property_fees);
        }
    }

    public function destroy(string $id)
    {
        if(Auth::check())
        {
            $delete = PropertyFees::where('id', $id)->delete();

            $result = $this->checkingResults(
                $delete,
                'The Property fee deleted successfully',
                'Failed to delete the property fee'
            );

            return $result;
        }
    }
}
