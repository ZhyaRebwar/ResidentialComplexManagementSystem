<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building;
use App\Models\Facility;
use App\Http\Requests\CreateBuildingRequest;
use App\Http\Requests\UpdateBuildingRequest;

use App\Http\Controllers\ControllersTraits\CheckingResults;
use App\Http\Controllers\ControllersTraits\GetValues;

class BuildingController extends Controller
{
    use CheckingResults, GetValues;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $buildings = Building::all();
        $buildings = $this->getAllValues( Building::class );
        return response()->json($buildings);
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
    public function store(CreateBuildingRequest $request)
    {
        $building = $request->validated();

        $building_id = Facility::where('facility_type', 'building')->first()->id;

        // static building id
        $building['facility_id'] = $building_id;

        $created = Building::create( $building );

        // check if updated or not!
        $result = $this->checkingResults($created, 'Building created successfully', 'Failed to create building');

        return $result;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $name)
    {
        $building = $this->getValue(Building::class,'name', $name);

        return response()->json($building);
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
    public function update(UpdateBuildingRequest $request, string $name)
    {
        $building = $request->validated();

        if($request->facility_id)
            unset($request['facility_id']);

        $updated = Building::where('name', $name)->update($building);

        // check if updated or not!
        $result = $this->checkingResults($updated);

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $name)
    {
        $destroy = Building::where('name', $name)->delete();

        return response()->json($destroy == 1 ? 'Deleted':'Failed');
    }
}
