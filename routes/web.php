<?php

use App\Http\Controllers\RotasController;
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

Route::prefix('/')->group(function () {
    Route::get('/', [RotasController::class, 'index'])->name('index');
    Route::get('/search', [RotasController::class, 'search'])->name('search');
    Route::get('/details/{id}', [RotasController::class, 'details'])->name('details');
});
