<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Hall;
use App\Models\Show;
use Carbon\Carbon;

// index and search and show

class UserShowController extends Controller
{


    public function index()
    {
        
        $shows = Show::with(['movie', 'hall'])
        ->where(function ($query) {
            $query->whereDate('date', '>', now()->toDateString())
                ->orWhere(function ($query) {
                    $query->whereDate('date', '=', now()->toDateString())
                        ->whereTime('end_time', '>', now()->toTimeString());
                });
        })
        ->get();

    return view('Shows.showmoive', compact('shows'));
       
    }
    public function Search(Request $request)
{
    $request->validate([
        'textSearch' => ['required'],
    ]);

    $textSearch = $request->textSearch;

    try {
        $movies = Movie::where('title', 'like', '%'.$textSearch.'%')->pluck('id');

        $shows = Show::whereIn('movie_id', $movies)
            ->with('movie', 'hall')
            ->where(function ($query) {
                $query->whereDate('date', '>', now()->toDateString())
                    ->orWhere(function ($query) {
                        $query->whereDate('date', '=', now()->toDateString())
                            ->whereTime('end_time', '>', now()->toTimeString());
                    });
            })
            ->get();

    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }

    if ($shows->count() > 0) {
        return view('Shows.showmoive', compact('shows'));
    } else {
        return redirect()->route('showsmoive.index')
            ->with(['flash' => 'error', 'message' => 'No upcoming shows found for this movie']);
    }
}
public function todayShows()
{
    $today =  Carbon::today('Asia/Damascus');

   
    $shows = Show::whereDate('date', $today)
        ->with(['movie', 'hall'])
        ->orderBy('start_time')
        ->get();

    return view('employee.Dashboard.Reservations.todayShows', compact('shows', 'today'));
}



    
    public function filterByCategory(Request $request)
{
    $request->validate([
        'category_id' => 'required|integer',
    ], [
        'category_id.required' => 'You must select a category.',
    ]);

    $categoryId = $request->input('category_id');

    try {
        $shows = Show::with(['movie', 'hall'])
            ->whereHas('movie', function ($query) use ($categoryId) {
                $query->where('categorie_id', $categoryId);
            })
            ->where(function ($query) {
                $query->whereDate('date', '>', now()->toDateString())
                    ->orWhere(function ($query) {
                        $query->whereDate('date', '=', now()->toDateString())
                            ->whereTime('end_time', '>', now()->toTimeString());
                    });
            })
            ->get();

        return view('Shows.showmoive', compact('shows'));
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
}
   


    public function create()
    {

    }


    public function store(Request $request)
    {

    }


    public function show($id)
{

     $shows = Show::with(['movie', 'hall','movie.trailer'])->findOrFail($id);


    return view('Shows.showDetails', compact('shows'));
}


    public function edit(string $id)
    {

    }


    public function update(Request $request, string $id)
    {

    }


    public function destroy(string $id)
    {


    }
}
