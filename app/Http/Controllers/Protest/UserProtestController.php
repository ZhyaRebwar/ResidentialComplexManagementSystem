<?php

namespace App\Http\Controllers\Protest;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersTraits\CheckingResults;
use App\Http\Requests\Protest\User\CreateProtestRequest;
use Illuminate\Http\Request;
use App\Models\Protest;
use App\Models\Repairment;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class UserProtestController extends Controller
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
            $user_protests = Auth::user()->protests;

            return response()->json($user_protests);
        }
    }

    public function store(CreateProtestRequest $createProtestRequest)
    {

        if(Auth::check())
        {
            $validate = $createProtestRequest->validated();

            $type = $validate['type'];
            $property_id = $validate['property_id'];

            $location = $type . '-' . $property_id;

            $protest = Protest::create([
                ...$validate,
                'made_by' => Auth::user()->id,
                'location' => $location,
            ]);

            $result = $this->checkingResults(
                $protest,
                'The Protest made successfully',
                'Failed to make the protest'
            );

            return $result;
        }
    }

    public function update(Request $request, string $id)
    {
        // $request->only([])

        $validate = $request->validate([]);

        if(Auth::check())
        {
            $role = Role::where('user_id', Auth::user()->id)->get();
            //check if the role is for admin then delete
            //if the role is for user they can delete only when the protest is not viewed.

            

            if( in_array('resident', $role) )
            {
                $delete = Protest::where('id', $id)
                                    ->where('is_viewed', false)
                                    ->update($validate);

                $result = $this->checkingResults(
                    $delete,
                    'The protest has been updated successfully',
                    'Failed to update the protest'
                );
    
                return $result;                    
            }
            else
            {
                $delete = Protest::where('id', $id)->update($validate);

                $result = $this->checkingResults(
                    $delete,
                    'The protest has been updated successfully',
                    'Failed to update the protest'
                );

                return $result;
            }
        }   
    }

    public function destroy(string $id)
    {
        if(Auth::check())
        {
            $role = Role::where('user_id', Auth::user()->id)->get();
            //check if the role is for admin then delete
            //if the role is for user they can delete only when the protest is not viewed.

            if( in_array('resident', $role) )
            {
                $delete = Protest::where('id', $id)
                                    ->where('is_viewed', false)
                                    ->delete();

                $result = $this->checkingResults(
                    $delete,
                    'The protest has been deleted',
                    'Failed to delete the protest'
                );
    
                return $result;                    
            }
            else
            {
                $delete = Protest::where('id', $id)->delete();

                $result = $this->checkingResults(
                    $delete,
                    'The protest has been deleted',
                    'Failed to delete the protest'
                );
    
                return $result;
            }
  
        }
    }
}
