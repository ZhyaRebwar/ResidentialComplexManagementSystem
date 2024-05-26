<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\House;
use App\Models\Facility;

use App\Http\Controllers\ControllersTraits\CheckingResults;
use App\Http\Controllers\ControllersTraits\GetValues;
use App\Http\Requests\HousesRequests\CreateHouseRequest;
use App\Http\Requests\HousesRequests\UpdateHouseRequest;

class HouseController extends Controller
{
    use CheckingResults,GetValues;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $houses = House::leftJoin('users', 'houses.owner_id', '=', 'users.id')
        ->select([
            'houses.id as id',
            'houses.name as name',
            'users.name as owner_name',
            'houses.created_at',
            'houses.updated_at',
        ])
        ->get();

        return response()->json($houses);
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
    public function store(CreateHouseRequest $request)
    {
        $house = $request->validated();

        if(is_null($house['electricity_unit'] ))
            $house['electricity_unit'] = 0;

        $house_facility = Facility::where('facility_type', 'house')->first()->id;

        $house['facility_id'] = $house_facility;

        $created = House::create( $house );

        $result = $this->checkingResults($created, 'The house has been created successfully', 'The house has been failed to create');

        return $result;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $name)
    {
        $house = $this->getValue(House::class, 'name', $name);

        return response()->json($house);
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
    public function update(UpdateHouseRequest $request, string $name)
    {
        $house = $request->validated();
        
        $house_id = $this->getValue(House::class, 'name', $name)->id;

        $update = House::where('id', $house_id)->update($house);

        $result = $this->checkingResults($update,'House updated successfully','House update failed');

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $name)
    {
        // deleting from the object we got
        $house = $this->getValue(House::class, 'name', $name)->delete();

        $result = $this->checkingResults($house, 'House deleted successfully', 'Failed to delete House');

        return $result;
    }
}
