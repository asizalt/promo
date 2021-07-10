<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



Route::get("/promo2mp3", [\App\Http\Controllers\AudioController::class,'promo2mp3']);
Route::get("/mp3", [\App\Http\Controllers\AudioController::class,'mp3']);


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
