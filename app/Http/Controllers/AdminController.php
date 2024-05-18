<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ControllersTraits\CheckingResults;
use Illuminate\Http\Request;
use App\Http\Requests\CreateAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    use CheckingResults;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = User::join('roles', 'users.id', '=', 'roles.user_id')
        ->where('role', 'admin')
        ->select([
            'users.id as id',
            'name',
            'email',
            'phone_number',
            'age',
            'job_title',
            'users.created_at',
            'users.updated_at',
             ])
        ->get();

        return response()->json($admins);
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
    public function store(CreateAdminRequest $request)
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
        $admin = User::find($id);

        $admin['roles'] = $admin->roles()->pluck('role');

        return response()->json($admin);
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
    public function update(UpdateAdminRequest $request, string $id)
    {
        $updated = User::where("id", $id)->update($request->all());

        $result = $this->checkingResults(
            $updated,
            'The admin account has been updated successfully',
            'The update of admin account failed'
        );

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = User::find($id)->delete();

        $result = $this->checkingResults(
            $delete,
            'The admin account is deleted successfully',
            'Failed to delete the admin account'
        );

        return $result;
    }
}
