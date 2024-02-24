<?php

namespace App\Http\Controllers\ControllersTraits;

trait CheckingResults 
{
    public function checkingResults($value, $successMessage = 'success', $failMessage = 'fail')
    {
        if($value)
        {
            return response()->json(['Result' => 'OK', 'Message' => $successMessage], 200);
        }else
        {
            return response()->json(['Result' => 'Fail', 'Message' => $failMessage], 400);
        }
    }
}