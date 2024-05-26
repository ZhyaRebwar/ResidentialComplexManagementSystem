<?php

namespace App\Http\Controllers\Protest;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersTraits\CheckingResults;
use App\Models\Protest;
use Illuminate\Http\Request;

class ProtestController extends Controller
{
    use CheckingResults;
    
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
        $request->only(['status']);

        $update = Protest::where('id', $id)->update(['status' => $request->status]);

        $result = $this->checkingResults(
            $update,
            'The status has been updated',
            'Failed to update the status'
        );

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Protest::find($id);

         // Check if the record exists
         if (!$delete) {
            // Return a response indicating the record was not found
            return response()->json(['message' => 'Resource not found'], 404);
        }

        $delete->delete();


        $result = $this->checkingResults(
            $delete,
            'The delete of protest was successful',
            'The delete of protest failed'
        );

        return $result;
    }
}
