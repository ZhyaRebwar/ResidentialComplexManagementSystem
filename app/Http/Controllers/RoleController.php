<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ControllersTraits\CheckingResults;
use App\Http\Controllers\ControllersTraits\GetValues;
use App\Http\Requests\RoleRequests\CreateRoleRequest;
use App\Http\Requests\RoleRequests\UpdateRoleRequest;
use App\Http\Requests\RoleRequests\DeleteRoleRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class RoleController extends Controller
{

    use CheckingResults,GetValues;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = Role::join('users', 'roles.user_id', '=', 'users.id')->get();

        $result = $this->getMultipleOrOneValue($role);

        return response()->json( $result );
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
    public function store(CreateRoleRequest $request)
    {
        $validate = $request->validated();

        $user_id = User::where('email', $validate['email'])
            ->first()
            ->id;

        $add_role = Role::create([
            'user_id' => $user_id,
            'role' => $validate['role']
        ]);

        $result = $this->checkingResults(
            $add_role,
            'Role added to the user successfully',
            'Role failed to be added to the user'
        );

        return response()->json( $result );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $email)
    {
        $user_roles = Role::join('users', 'roles.user_id', '=', 'users.id')
        ->where('email', $email)
        ->pluck('role');

        return response()->json( $user_roles);
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
    public function update(UpdateRoleRequest $request, string $email)
    {
        $validate = $request->validated();

        
        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteRoleRequest $request, string $email)
    {
        $validate = $request->validated();

        $user_id = User::where('email', $email)
            ->first()->id;
        
        $role = Role::where('user_id', $user_id)
            ->where('role', $validate)
            ->first()
            ->delete();
            
        $result = $this->checkingResults(
            $role,
            "The role has been deleted for this user",
            "The role has not been deleted for this user"
        );

        return response()->json($result);
    }
}
