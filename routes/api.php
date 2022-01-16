<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\PlaceController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */


Route::group(["middleware" => ["guest"]], static function () {
    Route::post("/country/all", [CountryController::class,"index",]);   
    Route::post("/country/add", [CountryController::class,"store",]);  
    
    
    Route::post("/city/all", [CityController::class,"index",]);   
    Route::post("/city/add", [CityController::class,"store",]); 
    
    
    /* Route::post("/locations/all", [LocationsController::class,"index",]);   
    Route::post("/locations/add", [LocationsController::class,"store",]);  */
    Route::post("/locations/all", [PlaceController::class,"index",]);   
    Route::post("/locations/add", [PlaceController::class,"store",]);  
    Route::post("/locations/saveFile", [PlaceController::class,"storeFile",]);  
});



