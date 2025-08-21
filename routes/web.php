<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\user\profilecontroller;
use App\Http\Controllers\UserShowController;
use App\Http\Controllers\ticketsController;
use App\Http\Controllers\PromoCodeController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\TicketFoodController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\RatingController;
use Illuminate\Support\Facades\EnsureUserHasRatedTickets;







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


Route::get('/botman/chat', [ChatbotController::class, 'iframe'])->name('botman.iframe');;

Route::get('/chat-page', function () {
    return view('botman.chat'); 
})->name('chat')->middleware('forceRating'); 



Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('forceRating');



Auth::routes(['verfiy'=> true]);// class auth


Route::resource('showsmoive', UserShowController::class)->middleware('forceRating');
Route::post('showsmoive/search', [UserShowController::class, 'Search'])->name('showsmoive.Search')->middleware('forceRating');
Route::get('/shows/filter-by-category', [UserShowController::class, 'filterByCategory'])->name('shows.filterByCategory')->middleware('forceRating');
Route::get('ticket-foods', [TicketFoodController::class, 'index'])->name('ticket-foods.index')->middleware('forceRating');
//

Route::middleware(['auth'])->group(function () {
    Route::get('/rating', [RatingController::class, 'create'])->name('rating.create');
    Route::post('/rating', [RatingController::class, 'store'])->name('rating.store');

    
   
  

   
    Route::middleware(['forceRating'])->group(function () {
      
       

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

        Route::resource('ticket-foods', TicketFoodController::class)->except(['index']);
        Route::get('/my/ratings', [RatingController::class, 'myRatings'])->name('my.ratings');
        Route::get('/rating/edit/{id}', [RatingController::class, 'edit'])->name('rating.edit');
        Route::put('/ratings/{id}', [RatingController::class, 'update'])->name('rating.update');
    });
});


















    

