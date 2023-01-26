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


Route::middleware([
    'auth:sanctum',
    \App\Http\Middleware\ValidatedUserEmail::class
])->group(function () {

    Route::get('/myorders',[App\Http\Controllers\OrderController::class, 'list']);
    Route::get('/mygifts',[App\Http\Controllers\GiftController::class, 'list']);


    Route::post('add-cart', [App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.store');
    Route::post('update-cart', [App\Http\Controllers\CartController::class, 'updateCart'])->name('cart.update');
    Route::post('remove-cart', [App\Http\Controllers\CartController::class, 'removeCart'])->name('cart.remove');
    Route::post('clear-cart', [App\Http\Controllers\CartController::class, 'clearAllCart'])->name('cart.clear');

});


Route::get('/brand_list',[App\Http\Controllers\BrandController::class, 'list']);

Route::get('/item_list',[App\Http\Controllers\ItemController::class, 'list']);