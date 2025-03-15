<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\user\profilecontroller;
use App\Http\Controllers\UserShowController;



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
})->name('home');



Auth::routes(['verfiy'=> true]);// class auth
Route::resource('showsmoive', UserShowController::class);
Route::post('showsmoive/search', [UserShowController::class, 'Search'])->name('showsmoive.Search');









