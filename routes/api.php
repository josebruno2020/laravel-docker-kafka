<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FilhoteController;
use App\Http\Controllers\QueueController;
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

// Route::group(['prefix' => 'animals'], function () {

//     Route::get('', [AnimalController::class, 'index']);
//     Route::post('', [AnimalController::class, 'store']);
//     Route::get('{id}',[AnimalController::class, 'show']);
//     Route::post('edit/{id}',[AnimalController::class, 'update']);
//     Route::delete('{id}',[AnimalController::class, 'destroy']);

// });



// Route::prefix('filhotes/{id_animal}')->group(function () {
//     Route::post('', [FilhoteController::class, 'store']);
//     Route::delete('destroy/{id}', [FilhoteController::class, 'destroy']);
// });

Route::group(['prefix' => 'customers'], function() {
    Route::get('', [CustomerController::class, 'index']); 
});


Route::group(['prefix' => 'queue'], function() {
    Route::post('handle-event', [QueueController::class, 'handleEvent']);
});