<?php

use App\Http\Controllers\Repairment\UserRepairmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\Protest\ProtestController;
use App\Http\Controllers\Protest\UserProtestController;
use App\Http\Controllers\RoleController;

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

Route::get('/', function () {
    return json_encode(['came back to where you started.']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// when registered send request to user to create account!
Route::middleware('auth:sanctum')
    ->apiResource('residents', ResidentController::class)
    ->only(['store', 'index', 'destroy', 'update']);

Route::middleware('auth:sanctum')
    ->controller(ResidentController::class)
    ->prefix('residents')
    ->group( function () {
        Route::get('/self', 'user');
        Route::put('/self/update', 'editProfileUser');
        Route::get('/self/residential-property', 'userResidentialProperty');
    });

Route::controller(UserProtestController::class)
    ->prefix('protests/user')
    ->group( function () {
        Route::get('', 'index');
        Route::post('', 'store');
    });

Route::controller(UserRepairmentController::class)
    ->prefix('repairments/user')
    ->group( function () {
        Route::get('', 'index');
        Route::post('', 'store');
    });

// managing admins
Route::apiResource('admins', AdminController::class)
    ->only(['store', 'show', 'index', 'destroy', 'update']);
    // ->middleware('auth:sanctum')


// login & register admins
Route::controller(LoginController::class)
    ->group(
        function (){
            // login admin account
            Route::post('/login', 'login');

            //we don't need to signup because only admins can create other admins

            Route::get('/logoff', 'logoff')->middleware('auth:sanctum');
        });

// managing buildings 
Route::apiResource('buildings', BuildingController::class)
    ->only(['index', 'update', 'destroy', 'show', 'store']);

Route::apiResource('houses', HouseController::class)
    ->only(['index', 'update', 'store', 'show', 'destroy']);

Route::apiResource('apartments', ApartmentController::class)
    ->only(['index', 'store']);

//to update an apartment
Route::put('/apartments/{building}/{floor}/{apartment}', [ApartmentController::class, 'update'] );

//to delete an apartment
Route::delete('/apartments/{building}/{floor}/{apartment}', [ApartmentController::class, 'destroy'] );

// to get all apartments from a building
Route::get('/apartments/{building}', [ApartmentController::class,'building_apartments'] );

//to get all apartments from a building floor
Route::get('/apartments/{building}/{floor}', [ApartmentController::class,'building_floor_apartments'] );

//to get specific apartment from building floor
Route::get('/apartments/{building}/{floor}/{apartment}', [ApartmentController::class,'apartment'] );

//resource of roles
Route::apiResource('roles', RoleController::class)
        ->only(['index', 'update', 'show', 'store'])
        ->middleware('auth:sanctum');

//to delete a users role
Route::delete('/roles/{email}', [RoleController::class,'destroy'] );
