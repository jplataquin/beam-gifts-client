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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/myorders',[App\Http\Controllers\OrderController::class, 'list']);

    Route::get('/mygifts',[App\Http\Controllers\GiftController::class, 'list']);

});


Route::get('/brand_list',[App\Http\Controllers\BrandController::class, 'list']);

Route::get('/item_list',[App\Http\Controllers\BrandController::class, 'list']);