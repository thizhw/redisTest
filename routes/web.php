<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RedisController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/redis', [RedisController::class, 'index']);

Route::post('/setRedis', [RedisController::class, 'setData']);
Route::get('/getRedis', [RedisController::class, 'getData']);

Route::get('/rediss', function() {
    return view('redis');
});

Route::post('/setData', [RedisController::class, 'store'])->name('setData');

Route::get('/redis', [RedisController::class, 'getData']);
