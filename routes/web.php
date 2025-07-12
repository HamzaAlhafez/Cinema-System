<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\user\profilecontroller;
use App\Http\Controllers\UserShowController;
use App\Http\Controllers\ticketsController;
use App\Http\Controllers\PromoCodeController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ChatbotController;




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



Route::post('/botman', [ChatbotController::class, 'handle']);

// إطار الدردشة (iframe)
Route::get('/botman/chat', [ChatbotController::class, 'iframe']);
///
Route::get('/chat-page', function () {
    return view('botman.chat'); 
})->name('chat'); 

Route::get('/', function () {
    return view('welcome');
})->name('home');



Auth::routes(['verfiy'=> true]);// class auth


Route::resource('showsmoive', UserShowController::class);
Route::post('showsmoive/search', [UserShowController::class, 'Search'])->name('showsmoive.Search');
Route::get('/shows/filter-by-category', [UserShowController::class, 'filterByCategory'])->name('shows.filterByCategory');





Route::middleware(['auth'])->group(function () {
  
    
    Route::get('user/profile', function () {
        return view('user.profile');
    })->name('user.profile');
    
    Route::post('user/password', [UserProfileController::class,'ChangePassword'])
        ->name('user.ChangePassword');
    
    Route::patch('/user/update', [UserProfileController::class, 'update'])
        ->name('user.update');
    
    Route::get('/user/edit', [UserProfileController::class, 'edit'])
        ->name('user.edit');
    
    Route::resource('tickets', ticketsController::class);
    
    Route::get('promocodes/Show', [PromoCodeController::class, 'ShowPromoCodes'])
        ->name('promocodes.Show');
    
    Route::get('promocodes/Show/Mypromocodes', [PromoCodeController::class, 'ShowMypromocodes'])
        ->name('promocodes.Show.Mypromocodes');
    
    Route::post('promocodes/redeem', [PromoCodeController::class, 'redeem'])
        ->name('promocodes.redeem');
});








    

