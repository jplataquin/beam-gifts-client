<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CartSetup;

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


Route::middleware([CartSetup::class])->group(function () {

    Route::get('/', function () {

        return view('welcome');
    });

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/brands',[App\Http\Controllers\BrandController::class, 'index']);
    Route::get('/brand/{name}',[App\Http\Controllers\BrandController::class, 'display']);

    Route::get('/gifts',[App\Http\Controllers\ItemController::class, 'index']);
    Route::get('/gift/{brandname}/{itemname}',[App\Http\Controllers\ItemController::class, 'display']);
    
});



Auth::routes();



Route::get('/testemail',[App\Http\Controllers\ClientController::class,'sendValidateEmail']);

Route::middleware(['auth'])->group(function () {

    //TODO place in auth middleware
    Route::get('cart', [App\Http\Controllers\CartController::class, 'cartList'])->name('cart.list');

    Route::get('payment/creditcard/{uid}', [App\Http\Controllers\PaymongoController::class, 'creditcard']);
    Route::post('payment/creditcard', [App\Http\Controllers\PaymongoController::class, '_creditcard']);

    Route::get('myorders/', [App\Http\Controllers\OrderController::class, 'index']);
    Route::get('myorders/{uid}', [App\Http\Controllers\OrderController::class, 'display']);

    Route::get('mygifts/', [App\Http\Controllers\GiftController::class, 'index']);

    
    Route::get('/email',[App\Http\Controllers\ClientController::class, 'email']);
    Route::get('profile', [App\Http\Controllers\ClientController::class, 'profile']);

    
});

Route::get('/validate/email/{token}',[App\Http\Controllers\ClientController::class,'validateEmail']);

Route::get('/gift/{item_uid}',[App\Http\Controllers\GiftController::class, 'qr']);


Route::get('/tic',[App\Http\Controllers\GiftController::class, 'tictactoe']);

Route::get('adarna.js', function(){

    $response = Response::make(File::get(base_path('node_modules/adarna/dist/adarna.js')), 200);
    $response->header("Content-Type", 'text/javascript');

    return $response;
});

Route::get('easyqrcode.js', function(){

    $response = Response::make(File::get(base_path('node_modules/easyqrcodejs/dist/easy.qrcode.min.js')), 200);
    $response->header("Content-Type", 'text/javascript');

    return $response;
});


Route::get('bootstrap.js', function(){

    
    $response = Response::make(File::get(base_path('node_modules/bootstrap/dist/js/bootstrap.bundle.js')), 200);
    $response->header("Content-Type", 'text/javascript');

    return $response;

});


Route::get('xupdate',function(){
 
    $process = new Process(['/usr/bin/git pull']);
    $process->setWorkingDirectory('/');
    $process->run();

    // executes after the command finishes
    if (!$process->isSuccessful()) {
        throw new ProcessFailedException($process);
        return false;
    }

    echo $process->getOutput();

    echo "OK --";
});