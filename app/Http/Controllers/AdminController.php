<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\User;
use App\Models\Role;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $residents = User::join('roles', 'users.id', '=', 'roles.user_id')
        ->where('role', 'admin')
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
    public function store(CreateAdminRequest $request)
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
        $admin = User::where('email', $email)
        ->where(function ($query) {
            $query->where('role', 'admin')
                ->orWhere('role', 'both');
        })
        ->get();

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
    public function update(UpdateAdminRequest $request, string $email)
    {
        $admin_id = User::where('email', $email)
        ->where(function ($query) {
            $query->where('role', 'admin')
                ->orWhere('role', 'both');
        })
        ->first()
        ->id;

        $updated = User::where("id", $admin_id)->update( $request->all() );

        return response()->json($admin_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $email)
    {
        $admin = User::where('email', $email)
        ->where(function ($query) {
            $query->where('role', 'admin')
                ->orWhere('role', 'both');
        })
        ->delete();

        return response()->json($admin);
    }
}
