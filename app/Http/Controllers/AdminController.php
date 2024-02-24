<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = User::where('role', 'admin')
            ->orWhere('role', 'both')
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

        // create a token
        $token = $validate->createToken('admintoken')->plainTextToken;

        $admin = User::create($validate);


        return response()->json(
            [
                $admin
            ], 201
        );
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
