<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateResidentRequest;
use App\Http\Requests\UpdateResidentRequest;
use App\Models\User;

class ResidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $residents = User::where('role', 'user')
            ->orWhere('role', 'both')
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
    public function store(CreateResidentRequest $request)
    {
        // in request we have the data we send through a form.
        $validate = $request->validated();

        // $resident = $this->user()->create($validate);

        $resident = User::create($validate);

        return response()->json(["status" => ($resident) ? "Success" : "Fail"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $email)
    {
        
        $resident = User::where('email', $email)
            ->where('role', 'user')
            ->orWhere('role', 'both')
            ->get();

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
    public function update(UpdateResidentRequest $request, string $email)
    {
        $resident_id = User::where('role', 'user')
        ->orWhere('role', 'both')
        ->firstWhere('email', $email)
        ->id;

        $updated = User::where('id', $resident_id)->update( $request->all() );

        return response()->json([ $updated ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $email)
    {
        $resident = User::where('email', $email)
            ->where('role', 'user')
            ->orWhere('role','both')
            ->delete();

        return response()->json( [ 'User deleted successfully.' ] );
    }
}
