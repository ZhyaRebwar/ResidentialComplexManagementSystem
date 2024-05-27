<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Building;
use App\Models\House;
use App\Models\Protest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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


        //  2 array par, awsal ->har mangek chand danay haya 
        // 2 array protest, maintainance bo har mangek(for five months before)

        // Define the date range
        $startDate = now()->endOfMonth()->subYears(2);
        $endDate = now()->endOfMonth();

        // Retrieve protests grouped by year and month
        $protestCounts = DB::table('protests')
        ->select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as protest_count')
        )
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc')
        ->get();


        // Format the data for easy use in your view or response
        $formattedCounts = [];
        foreach ($protestCounts as $count) {
            $formattedCounts[] = [
                'year' => $count->year,
                'month' => $count->month,
                'protest_count' => $count->protest_count
            ];
        }


     
        return response()->json([
            'house_number' => $no_houses,
            'apartment_number' => $no_apartments,
            'building_number' => $no_buildings,
            'user_number' => $no_user,
            'residents_number' => $no_residents,
            'admin_number' => $no_admin,
            'two_years_protests' => $formattedCounts
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
