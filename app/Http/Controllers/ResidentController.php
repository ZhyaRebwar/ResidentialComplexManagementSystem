<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateResidentRequest;
use App\Http\Requests\UpdateResidentRequest;
use App\Models\User;
use App\Models\Role;

use App\Http\Controllers\ControllersTraits\CheckingResults;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\user\UserUpdateProfileRequest;
use App\Models\Apartment;
use App\Models\House;
use Illuminate\Support\Facades\DB;

class ResidentController extends Controller
{
    use CheckingResults;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $residents = User::join('roles', 'users.id', '=', 'roles.user_id')
        ->where('role', 'resident')
        ->get();

        return response()->json($residents);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateResidentRequest $request)
    {
        $validate = $request->validated();

        $role = $validate['role'];

        unset($validate['role'] );

        DB::beginTransaction();

        $resident = User::create($validate);

        $resident_id = $resident->id;

        $add_role = Role::create(
            ['role' => $role,
             'user_id' => $resident_id,
             ]
        );

        DB::commit();


        $result = $this->checkingResults(
        $add_role, 
        'The user has been created successfully',
        'The user has been failed to create'
        );

        return $result;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $resident = User::find($id);

        return response()->json($resident);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateResidentRequest $request, string $id)
    {
        $updated = User::where("id", $id)->update($request->all());

        $result = $this->checkingResults(
            $updated,
            'The resident account has been updated successfully',
            'The update of resident account failed'
        );

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $resident = User::find($id)->delete();

        $result = $this->checkingResults(
            $resident,
            'The user deleted successfully',
            'Failed to delete the user'
        );

        return response()->json( $result);
    }


    // for the users only
    public function user()
    {

        if(Auth::check())
        {   
            //get the user id.
            $user = Auth::user();

            //get all the user contents
            return response()->json([
                'user' => $user,
                'status' => 'success',
                'message' => 'successfully retrieved user info' 
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => 'failed',
                'message' => "couldn't retrieve user contents, please try again" 
            ], 401);
        }
    }

    public function editProfileUser(UserUpdateProfileRequest $request)
    {
        $request->only(['phone_number', 'job_title', 'password']);

        $values_validate = $request->validated();


        // if( $values_validate['password'] )
        // {
        //     unset( $values_validate['password'] );
        // }
        // else
        // {
        $values_validate['password'] = bcrypt($request->password);
        // }

        if(Auth::check())
        {   
            $user_id = Auth::user()->id;

            $result = User::where('id', $user_id)
                ->update($values_validate);

            if($result)
            {
                return response()->json([
                    'status' => 'success',
                    'message' => "The user content has been updated"                 
                ], 200);
            }
            else
            {
                return response()->json([
                    'status' => 'failed',
                    'message' => "The user content couldn't be updated"                 
                ], 400);
            }
        }
        else
        {
            return response()->json([
                'status' => 'failed',
                'message' => "authorization error, please try again" 
            ], 401);
        }
    }

    public function userResidentialProperty()
    {
        if(Auth::check())
        {   
            $user = Auth::user();

            $houses_id = $user->house_residency_residents->map(function ($houses) {
                return $houses['house_id'];
            });

            $houses = House::leftJoin('users', 'houses.owner_id', '=', 'users.id')
                ->whereIn('houses.id', $houses_id)
                ->select([
                    'electricity_unit', 
                    'houses.name as house_name', 
                    'users.name as owner',
                ])
                ->get();

            $apartments_id = $user->apartment_residency_residents->map(function ($apartment) {
                return $apartment['apartment_id'];
            });
    
            $apartments = Apartment::leftJoin('users', 'apartments.owner_id', '=', 'users.id')
                ->leftJoin('buildings', 'apartments.building_id', '=', 'buildings.id')
                ->whereIn('apartments.id', $apartments_id)
                ->select([
                    'electricity_unit', 
                    'apartments.name as house_name', 
                    'users.name as owner',
                    'buildings.name as building_name',
                    'floor',
                ])
                ->get();                

            return response()->json([
                'residential_properties' => 
                ['houses' => $houses,
                'apartments' => $apartments],
                'status' => 'success',
                'message' => 'successfully retrieved residential properties of the user' 
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => 'failed',
                'message' => "couldn't retrieve residential properties of the user contents, please try again" 
            ], 401);
        }
    }
}
