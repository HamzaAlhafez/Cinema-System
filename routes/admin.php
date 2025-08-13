<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\admin\AdminHomeController;
use App\Http\Controllers\admin\auth\AdminLoginController;
use App\Http\Controllers\admin\auth\AdminRegisterController;
use App\Http\Controllers\moviescontroller;
use App\Http\Controllers\HallController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PromoCodeController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\FoodCategoryController;
use App\Http\Controllers\TicketFoodController;
use App\Http\Controllers\TrailerController;
use App\Http\Controllers\StatisticsController;



/*
|--------------------------------------------------------------------------
| admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('admin/dashboard/home', function () {
    return view('dashboard.index');
})->name('admin.dashboard.home')->middleware('auth:admin');

Route::get('admin/dashboard/login', [AdminLoginController::class, 'Login'])->name('admin.dashboard.login');
Route::post('admin/dashboard/check', [AdminLoginController::class, 'CheckLogin'])->name('admin.dashboard.check');
Route::get('admin/dashboard/register', [AdminRegisterController::class, 'Register'])->name('admin.dashboard.register');
Route::post('admin/dashboard/store', [AdminRegisterController::class, 'Store'])->name('admin.dashboard.store');
Route::post('admin/dashboard/Logout', [AdminLoginController::class, 'Logout'])->name('admin.dashboard.Logout');


Route::middleware(['auth:admin'])->group(function ()   {


    Route::resource('movies', moviescontroller::class);
    Route::post('movies/search', [moviescontroller::class, 'Search'])->name('movies.Search');
Route::resource('halls', HallController::class);




Route::resource('shows', ShowController::class)->except(['show']);

Route::get('shows/getAvailableHalls', [ShowController::class, 'getAvailableHalls'])->name('shows.getAvailableHalls');

Route::post('shows/search', [ShowController::class, 'Search'])->name('shows.Search');
Route::resource('employees', EmployeeController::class);
Route::post('employees/search', [EmployeeController::class, 'Search'])->name('employees.search');
Route::resource('Admins', AdminController::class);
Route::get('admin/dashboard/ChangePassword', [AdminController::class, 'ShowChangePasswordForm'])->name('admin.dashboard.ChangePassword');
Route::post('Admins/password', [AdminController::class, 'ChangePassword'])->name('Admins.password');
Route::post('Admins/Contactus', [AdminController::class, 'ContactUs'])->name('Admins.Contactus');
Route::get('admin/dashboard/Contactus', [AdminController::class, 'ContactusShowform'])->name('admin.dashboard.Contactus');

Route::get('admin/dashboard/ViewProfile', [AdminController::class, 'Viewproifle'])->name('admin.dashboard.ViewProfile');
Route::resource('promocodes', PromoCodeController::class);
Route::resource('categories',CategorieController::class);
Route::resource('food-categories', FoodCategoryController::class);
Route::resource('foods', FoodController::class);
Route::resource('Trailers', TrailerController::class);
Route::get('/statistics/tickets', [StatisticsController::class, 'ticketsSold'])
->name('statistics.tickets');
Route::get('/statistics/yearly-revenue', [StatisticsController::class, 'yearlyRevenue'])
    ->name('statistics.yearlyRevenue');
    
    Route::get('/statistics/top-users-points', [StatisticsController::class, 'topUsersByPoints'])
    ->name('statistics.topUsersPoints');
    Route::get('/statistics/top-selling-movies', [StatisticsController::class, 'topSellingMovies'])->name('statistics.topSellingMovies');
    Route::get('/statistics/top-categories', [StatisticsController::class, 'topCategoriesByBookings'])->name('statistics.topCategoriesMoives');

});







