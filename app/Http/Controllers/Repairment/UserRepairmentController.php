<?php

namespace App\Http\Controllers\Repairment;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersTraits\CheckingResults;
use App\Http\Requests\Repairment\User\CreateRepairmentRequest;
use App\Models\Repairment;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRepairmentController extends Controller
{
    use CheckingResults;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        if(Auth::check())
        {
            $user_repairments = Auth::user()->user_repairments;

            return response()->json($user_repairments);
        }
    }

    public function store(CreateRepairmentRequest $createRepairmentRequest)
    {
        if(Auth::check())
        {
            $validate = $createRepairmentRequest->validated();

            $type = $validate['type'];
            $property_id = $validate['property_id'];

            $location = $type . '-' . $property_id;

            $repairment = Repairment::create([
                ...$validate,
                'requested_by' => Auth::user()->id,
                'location' => $location,
            ]);

            $result = $this->checkingResults(
                $repairment,
                'The Repairment request made successfully',
                'Failed to make the repairment request'
            );

            return $result;
        }
    }

    public function destroy(string $id)
    {
        if(Auth::check())
        {
            $role = Role::where('user_id', Auth::user()->id)->get();
            //check if the role is for admin then delete
            //if the role is for user they can delete only when the repairment is not viewed.

            

            if( in_array('resident', $role) )
            {
                $delete = Repairment::where('id', $id)
                                    ->where('is_viewed', false)
                                    ->delete();

                $result = $this->checkingResults(
                    $delete,
                    'The repairment has been deleted',
                    'Failed to delete the repairment'
                );
    
                return $result;                    
            }
            else
            {
                $delete = Repairment::where('id', $id)->delete();

                $result = $this->checkingResults(
                    $delete,
                    'The repairment has been deleted',
                    'Failed to delete the repairment'
                );

                return $result;
            }
        }
    }
}
