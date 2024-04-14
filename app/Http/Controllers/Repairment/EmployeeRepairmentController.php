<?php

namespace App\Http\Controllers\Repairment;

use App\Http\Controllers\Controller;
use App\Models\Repairment;
use Illuminate\Http\Request;
use App\Http\Controllers\ControllersTraits\CheckingResults;

class EmployeeRepairmentController extends Controller
{
    use checkingResults;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $repairment = Repairment::all();

        return response()->json($repairment);
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->only(['status']);

        $update = Repairment::where('id', $id)->update(['status' => $request->status]);

        $result = $this->checkingResult(
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
        $delete = Repairment::where('id', $id)->delete();

        $result = $this->checkingResults(
            $delete,
            'The repairment deleted successfully',
            'Failed to delete the repairment'
        );

        return $result;
    }
}
