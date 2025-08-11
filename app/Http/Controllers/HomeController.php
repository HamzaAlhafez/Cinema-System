<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Show;
use App\Models\Promocode;
use App\Models\Food;
use Illuminate\Support\Facades\Auth;
use App\Models\FoodCategory;
use App\Models\Categorie;
use App\Models\Ticket;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
{
    try {
        $today = Carbon::today()->toDateString();
        
       
        $shows = $this->getUpcomingShows();
        $comingSoon = $this->getComingSoonMovies();
        $promocodes = $this->getActivePromocodes($today);
        $recommendedShows = $this->getRecommendedShows();
        
        return view('home', compact(
            'shows', 
            'comingSoon', 
            'promocodes',
            'recommendedShows'
        ));
        
    } catch (\Exception $e) {
        
        
      
        return view('home', [
            'shows' => collect(),
            'comingSoon' => collect(),
            'promocodes' => collect(),
            'recommendedShows' => collect()
            
        ]);
    }
}


private function getUpcomingShows()
{
    return Show::with(['movie', 'hall'])
        ->where(function ($query) {
            $query->whereDate('date', '>', now()->toDateString())
                ->orWhere(function ($query) {
                    $query->whereDate('date', '=', now()->toDateString())
                        ->whereTime('end_time', '>', now()->toTimeString());
                });
        })
        ->get();
}


private function getComingSoonMovies()
{
    return Movie::whereDoesntHave('shows')
        ->with('Categorie') 
        ->take(4)
        ->get();
}


private function getActivePromocodes($today)
{
    return Promocode::where('is_active', true)
        ->where('expiry_date', '>=', $today)
        ->get();
}


private function getRecommendedShows()
{
    if (!Auth::check()) {
        return collect();
    }

    $userId = Auth::id();
    $topCategories = $this->getUserTopCategories($userId);

    if ($topCategories->isEmpty()) {
        return collect();
    }

    $topCategoryId = $topCategories->first()['category']->id;
    
    return Show::with(['movie', 'hall'])
        ->whereHas('movie', function ($query) use ($topCategoryId) {
            $query->where('categorie_id', $topCategoryId);
        })
        ->where(function ($query) {
            $query->whereDate('date', '>', now()->toDateString())
                ->orWhere(function ($query) {
                    $query->whereDate('date', '=', now()->toDateString())
                        ->whereTime('end_time', '>', now()->toTimeString());
                });
        })
        ->orderBy('date', 'asc')
        ->orderBy('start_time', 'asc')
        ->get();
}


private function getUserTopCategories($userId)
{
    return Ticket::where('user_id', $userId)
        ->with(['show.movie.categorie'])
        ->get()
        ->filter(function($ticket) {
            return $ticket->show && $ticket->show->movie && $ticket->show->movie->categorie;
        })
        ->groupBy('show.movie.categorie_id')
        ->map(function ($tickets) {
            return [
                'count' => $tickets->count(),
                'category' => $tickets->first()->show->movie->categorie
            ];
        })
        ->sortByDesc('count')
        ->filter(function ($item) {
            return $item['count'] >= 3;
        });
}
}

    

