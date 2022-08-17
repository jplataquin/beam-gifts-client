<?php

use Illuminate\Support\Facades\Route;
use  Symfony\Component\Process\Process;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/brand/{name}',[App\Http\Controllers\ClientController::class, 'brand']);
Route::get('/item/{brandname}/{itemname}',[App\Http\Controllers\ClientController::class, 'item']);


Route::get('cart', [App\Http\Controllers\CartController::class, 'cartList'])->name('cart.list');
Route::post('add-cart', [App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.store');
Route::post('update-cart', [App\Http\Controllers\CartController::class, 'updateCart'])->name('cart.update');
Route::post('remove-cart', [App\Http\Controllers\CartController::class, 'removeCart'])->name('cart.remove');
Route::post('clear-cart', [App\Http\Controllers\CartController::class, 'clearAllCart'])->name('cart.clear');


Route::get('payment/creditcard', [App\Http\Controllers\PaymongoController::class, 'creditcard']);
Route::post('payment/creditcard', [App\Http\Controllers\PaymongoController::class, '_creditcard']);


Route::get('adarna.js', function(){

    $response = Response::make(File::get(base_path('node_modules/adarna/dist/adarna.js')), 200);
    $response->header("Content-Type", 'text/javascript');

    return $response;
});


Route::get('xupdate',function(){
 
    $process = new Process(['git pull']);

    $process->run();

    echo "OK --";
});