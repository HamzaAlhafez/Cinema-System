<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Hall;
use App\Models\Show;

// index and search and show

class UserShowController extends Controller
{


    public function index()
    {
       $shows = Show::with(['movie', 'hall'])->get();
    return view('user.showmoive', compact('shows'));
    }



     public function Search(Request $request)
    {
        $request->validate([
    'textSearch' => ['required'],
]);

$textSearch = $request->textSearch;

try {

    $movies = Movie::where('title', $textSearch )->pluck('id')->first();


    $shows = Show::where('movie_id',$movies)->with('movie', 'hall')->get();
} catch (\Exception $e) {
    return redirect()->back()->withErrors(['error' => $e->getMessage()]);
}

if ($shows->count() > 0) {
    return view('user.showmoive', compact('shows'));
} else {
     session()->flash('SearchFaild');
    return redirect()->route('showsmoive.index')->with(['flash' => 'error', 'message' => 'Search Faild Please try again']);
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

     $shows = Show::with(['movie', 'hall'])->findOrFail($id);


    return view('user.showDetails', compact('shows'));
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
