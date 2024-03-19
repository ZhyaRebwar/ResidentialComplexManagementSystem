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
}
