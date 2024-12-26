<?php

use App\Http\Controllers\FilmsController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('/')->group(function (){
    Route::get('/',                         [FilmsController::class, 'index'])->name('films.index');

    Route::prefix('/films')->group(function (){
        Route::get('/',                     [FilmsController::class, 'showAll'])->name('films.showAll');
        Route::get('/{id}',                 [FilmsController::class, 'show'])->name('films.show');

        Route::post('/store',               [FilmsController::class, 'store'])->name('films.store');
        Route::put('/update',               [FilmsController::class, 'update'])->name('films.update');
        Route::put('/public/{id}',          [FilmsController::class, 'public'])->name('films.publicFilms');
        Route::put('/un-public/{id}',       [FilmsController::class, 'unPublic'])->name('films.unPublicFilms');

        Route::delete('/destroy',           [FilmsController::class, 'destroy'])->name('films.destroy');
    });
});
