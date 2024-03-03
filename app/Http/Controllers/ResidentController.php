<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateResidentRequest;
use App\Http\Requests\UpdateResidentRequest;
use App\Models\User;
use App\Models\Role;

use App\Http\Controllers\ControllersTraits\CheckingResults;

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

        // $resident = $this->user()->create($validate);

        $role = $validate['role'];

        unset($validate['role'] );

        $resident = User::create($validate);

        $resident_id = $resident->id;

        $add_role = Role::create(
            ['role' => $role,
             'user_id' => $resident_id,
             ]
        );

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
    public function show(string $email)
    {
        
        $resident = User::where('email', $email)
            ->where('role', 'user')
            ->orWhere('role', 'both')
            ->get();

        return json_encode([ $resident ]);
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
    public function update(UpdateResidentRequest $request, string $email)
    {
        $resident_id = User::where('role', 'user')
        ->orWhere('role', 'both')
        ->firstWhere('email', $email)
        ->id;

        $updated = User::where('id', $resident_id)->update( $request->all() );

        return response()->json([ $updated ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $email)
    {
        $resident = User::where('email', $email)
            ->where('role', 'user')
            ->orWhere('role','both')
            ->delete();

        return response()->json( [ 'User deleted successfully.' ] );
    }
}
