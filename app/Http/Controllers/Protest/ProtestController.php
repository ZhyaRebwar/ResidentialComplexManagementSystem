<?php

namespace App\Http\Controllers\Protest;

use App\Http\Controllers\Controller;
use App\Models\Protest;
use Illuminate\Http\Request;

class ProtestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $protest = Protest::join('users', 'protests.made_by', '=', 'users.id')
        ->select([
            'protests.id as id',
            'title',
            'description',
            'compliant',
            'status',
            'users.name as made by',
            'location',
            'protests.created_at',
            'protests.updated_at',
             ])
        ->get();

        return response()->json($protest);
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
