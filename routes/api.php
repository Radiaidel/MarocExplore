<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItineraireController;

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

Route::post('/register',[AuthController::class,'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::get('/itineraires', [ItineraireController::class, 'index']);
Route::get('/itineraires/{id}', [ItineraireController::class, 'show']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/itineraires', [ItineraireController::class, 'store']);
    Route::put('/itineraires/{id}', [ItineraireController::class, 'update']);
    Route::delete('/itineraires/{id}', [ItineraireController::class, 'destroy']);
    Route::post('/itineraires/{itinerary}/wishlist', [ItineraireController::class, 'addToWishlist']);
});
