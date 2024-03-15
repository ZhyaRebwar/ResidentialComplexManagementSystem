<?php

namespace App\Http\Controllers\Repairment;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersTraits\CheckingResults;
use App\Http\Requests\Repairment\User\CreateRepairmentRequest;
use App\Models\Repairment;
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

            $repairment = Repairment::create([
                ...$validate,
                'requested_by' => Auth::user()->id,
                'location' => $validate['type'] . '-' . $validate['property_id'],
            ]);

            $result = $this->checkingResults(
                $repairment,
                'The Repairment request made successfully',
                'Failed to make the repairment request'
            );

            return $result;
        }
    }
}
