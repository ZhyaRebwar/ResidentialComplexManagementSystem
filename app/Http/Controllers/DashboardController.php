<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Building;
use App\Models\House;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $no_houses = House::count();
        $no_apartments = Apartment::count();
        $no_buildings = Building::count();

        $no_user = User::count();
        // $no_residents = User::roles->exists(['residents'])->count();

        $no_residents = User::join('roles', 'users.id', '=', 'roles.user_id')
                            ->where('roles.role', 'resident')
                            ->count();
                            

        $no_admin = User::join('roles', 'users.id', '=', 'roles.user_id')
                            ->where('roles.role', 'admin')
                            ->count();
                            
     
        return response()->json([
            'house_number' => $no_houses,
            'apartment_number' => $no_apartments,
            'building_number' => $no_buildings,
            'user_number' => $no_user,
            'residents_number' => $no_residents,
            'admin_number' => $no_admin
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
