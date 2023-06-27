<?php

use App\Http\Controllers\Client\ContestController;
use App\Http\Controllers\Client\CriteriaController;
use App\Http\Controllers\Client\JudgeController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('client')->middleware(['auth:web'])->group( function () {
    Route::resource('contests', ContestController::class);
    Route::resource('judges', JudgeController::class);
    Route::resource('criteria', CriteriaController::class);
});