<?php

namespace App\Http\Controllers\Protest;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersTraits\CheckingResults;
use App\Http\Requests\Protest\User\CreateProtestRequest;
use Illuminate\Http\Request;
use App\Models\Protest;
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
        //get all the specific user protests   
        if(Auth::check())
        {
            $user_protests = Auth::user()->protest;

            return response()->json($user_protests);
        }
    }

    public function store(CreateProtestRequest $createProtestRequest)
    {

        if(Auth::check())
        {
            $validate = $createProtestRequest->validated();

            // in the request it must have a location containing type

            $protest = Protest::create([
                ...$validate,
                'made_by' => Auth::user()->id,
                'location' => $validate['type'] . '-' . $validate['property_id']
            ]);

            $result = $this->checkingResults(
                $protest,
                'The Protest made successfully',
                'Failed to make the protest'
            );

            return $result;
        }
    }
}
