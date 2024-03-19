<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Building;

use App\Http\Controllers\ControllersTraits\CheckingResults;
use App\Http\Controllers\ControllersTraits\GetValues;
use App\Http\Requests\ApartmentsRequests\CrateApartmentRequest;
use App\Http\Requests\ApartmentsRequests\UpdateApartmentRequest;

class ApartmentController extends Controller
{
    use CheckingResults,GetValues;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apartment = $this->getAllValues(Apartment::class);

        return response()->json($apartment);
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
    public function store(CrateApartmentRequest $request)
    {
        $apartment = $request->validated();

        if(is_null($apartment['electricity_unit'] ))
            $apartment['electricity_unit'] = 0;

        if(!is_null($apartment['building_id'] ))
            $building_exists = Building::where('id', $apartment['building_id'])->first();
        
            if(is_null($building_exists))
                return response()->json([ 
                'Result' => 'Fail',
                'Message' => 'The Building does not exist']
            ,404);

        $created = Apartment::create($apartment);

        $result = $this->checkingResults($created, 'The apartment has been created successfully', 'The apartment has been failed to create');

        return $result;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $name)
    {
        //
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
    public function update(UpdateApartmentRequest $request, string $building, int $floor, string $apartment_name)
    {
        $apartment = $request->validated();

        $apartment_id = Apartment::whereRelation(
                'building', 'name', $building
            )
            ->where(
                'floor', $floor
            )
            ->where(
                'name', $apartment_name
            )->first()->id;

        $update = Apartment::where('id', $apartment_id)->update($apartment);

        $result = $this->checkingResults($update,'Apartment updated successfully', 'Apartment update failed');

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $building, int $floor, string $apartment_name)
    {
        $apartment = Apartment::whereRelation(
            'building', 'name', $building
        )
        ->where(
            'floor', $floor
        )
        ->where(
            'name', $apartment_name
        )->first()->delete();

        $result = $this->checkingResults($apartment, 'Apartment deleted successfully','Apartment delete failed');

        return $result;
    }

    public function building_apartments(string $building)
    {
        $apartment = Apartment::whereRelation(
            'building', 'name', $building
        )->get();

        return response()->json($apartment);
    }

    public function building_floor_apartments(string $building, int $floor)
    {
        $apartment = Apartment::whereRelation(
            'building', 'name', $building
        )
        ->where(
            'floor', $floor
        )->get();

        return response()->json($apartment);
    }

    public function apartment(string $building, int $floor, $apartment_name)
    {
        $apartment = Apartment::whereRelation(
            'building', 'name', $building
        )
        ->where(
            'floor', $floor
        )
        ->where(
            'name', $apartment_name
        )->first();

        return response()->json($apartment);
    }
}
