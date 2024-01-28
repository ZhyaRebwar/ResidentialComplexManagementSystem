<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// when registered send request to user to create account!
Route::apiResource('residents', ResidentController::class)
    ->only(['store', 'show', 'index', 'destroy', 'update']);


// managing admins
Route::apiResource('admins', AdminController::class)
    ->only(['store']);
