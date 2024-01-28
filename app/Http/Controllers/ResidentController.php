<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateResidentRequest;
use App\Http\Requests\UpdateResidentRequest;
use App\Models\Resident;

class ResidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $residents = Resident::all();

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
        // in request we have the data we send through a form.
        $validate = $request->validated();

        // $request->user()->create($validate); how work later

        $resident = Resident::create($validate);

        return json_encode([ $resident]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $name)
    {
        
        $resident = Resident::firstWhere('name', $name);

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
    public function update(UpdateResidentRequest $request, string $name)
    {

        $resident_id = Resident::firstWhere('name', $name)->id;

        $updated = Resident::where('id', $resident_id)->update( $request->all() );

        return response()->json([ $updated ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $name)
    {
        $resident = Resident::where('name', $name)->delete();

        return response()->json( [ 'User deleted successfully.' ] );
    }
}
