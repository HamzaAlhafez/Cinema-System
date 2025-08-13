<?php

namespace App\Http\Controllers;
use App\Models\Ticket;
use Carbon\Carbon;
use App\Models\LoyaltyTransaction;
use App\Models\User;
use App\Models\Show;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;



use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function ticketsSold()
    {
        $currentYear = Carbon::now()->year;
        try 
        {
            $tickets = Ticket::selectRaw('MONTH(Booking_date) as month, COUNT(*) as total')
            ->whereRaw('YEAR(Booking_date) = ?', [$currentYear])
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');
    
       
        $months = [];
        $totals = [];
    
        foreach (range(1, 12) as $m) {
            $months[] = date("F", mktime(0, 0, 0, $m, 1)); 
            $totals[] = $tickets->get($m, 0); 
        }

        }
        catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }

    
        

    return view('dashboard.statistics.ticketsSold', compact('months', 'totals','currentYear'));




    }
    public function yearlyRevenue()
{
    $currentYear = Carbon::now()->year;
    try 
    {
        $revenues = Ticket::selectRaw('MONTH(Booking_date) as month, SUM(tickets_Price) as total')
    ->whereRaw('YEAR(Booking_date) = ?', [$currentYear])
    ->groupBy('month')
    ->orderBy('month')
    ->pluck('total', 'month');
    $months = [];
    $totals = [];
    $totalRevenue = 0;

    foreach (range(1, 12) as $m) {
        $months[] = date("F", mktime(0, 0, 0, $m, 1));
        $monthRevenue = $revenues[$m] ?? 0;
        $totals[] = $monthRevenue;
        $totalRevenue += $monthRevenue;
    }

    }
    catch (\Exception $e) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['error' => $e->getMessage()]);
    }

   
    
        
       

    
    

    return view('dashboard.statistics.yearlyRevenue', compact('months', 'totals', 'totalRevenue', 'currentYear'));
}
public function topUsersByPoints()
{
    try 
    {
        $usersData = LoyaltyTransaction::selectRaw('user_id, SUM(points) as total_points')
        ->groupBy('user_id')
        ->orderByDesc('total_points')
        ->take(10)
        ->get();
        $userNames = [];
    $pointsCount = [];

    foreach ($usersData as $data) {
        $user = User::find($data->user_id);
        $userNames[] = $user ? $user->name : 'Unknown';
        $pointsCount[] = $data->total_points;
    }

    }
    catch (\Exception $e) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['error' => $e->getMessage()]);
    }
    

    

   

    return view('dashboard.statistics.topUsersPoints', compact('userNames', 'pointsCount'));
}
public function topSellingMovies()
{
    try 
    {
        $moviesData = DB::table('tickets')
        ->join('shows', 'tickets.show_id', '=', 'shows.id')
        ->join('movies', 'shows.movie_id', '=', 'movies.id')
        ->select('movies.title', DB::raw('COUNT(tickets.id) as total_tickets'))
        ->groupBy('movies.id', 'movies.title')
        ->orderByDesc('total_tickets')
        ->take(10)
        ->get();
    
        $movieNames = $moviesData->pluck('title');
        $ticketsCount = $moviesData->pluck('total_tickets');

    }
    catch (\Exception $e) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['error' => $e->getMessage()]);
    }
   

    return view('dashboard.statistics.topSellingMovies', compact('movieNames', 'ticketsCount'));
}
public function topCategoriesByBookings()
{
    try 
    {
        $categoriesData = DB::table('tickets')
        ->join('shows', 'tickets.show_id', '=', 'shows.id')
        ->join('movies', 'shows.movie_id', '=', 'movies.id')
        ->join('categories', 'movies.categorie_id', '=', 'categories.id')
        ->select('categories.title', DB::raw('COUNT(tickets.id) as total_bookings'))
        ->groupBy('categories.title')
        ->orderByDesc('total_bookings')
        ->get();

    $categoryNames = $categoriesData->pluck('title')->toArray();
    $bookingsCount = $categoriesData->pluck('total_bookings')->toArray();

    }
    catch (\Exception $e) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['error' => $e->getMessage()]);
    }
   

    return view('dashboard.statistics.topCategoriesMoives', compact('categoryNames', 'bookingsCount'));
}


}
