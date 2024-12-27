<?php

use App\Http\Controllers\Api\FilmsController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('/v1')->group(function (){
    Route::prefix('films')->group(function (){
        Route::get('/',                     [FilmsController::class, 'showAll']);
        Route::get('/{id}',                 [FilmsController::class, 'show']);

        Route::post('/store',               [FilmsController::class, 'store']);
        Route::post('/update/{id}',          [FilmsController::class, 'update']);

        Route::put('/public/{id}',          [FilmsController::class, 'public']);
        Route::put('/un-public/{id}',       [FilmsController::class, 'unPublic']);

        Route::delete('/destroy/{id}',      [FilmsController::class, 'destroy']);
    });
});
