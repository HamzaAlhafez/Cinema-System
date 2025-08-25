<?php

namespace App\Http\Controllers;

use App\Models\Trailer;
use App\Models\Movie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class TrailerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trailers=Trailer::with('movie')->get();
        return view('dashboard.Trailers.index',compact('trailers'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $request->validate([
            'trailer_url' => ['required', 'min:1', 'max:255','url','unique:trailers','regex:/^(https?\:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/'],
            'movie_id' => ['required', Rule::exists(Movie::class, 'id')],
            




        ]);

        try {
            $Trailer=new Trailer();
             
            $Trailer->trailer_url=strip_tags($request->input('trailer_url'));
            $Trailer->movie_id=strip_tags($request->input('movie_id'));
            $Trailer->admin_id=Auth::guard('admin')->user()->id;
            $Trailer->save();

       
            
} catch (\Exception $e) {
     return redirect()->back()->withErrors(['error' => $e->getMessage()]);

}
   session()->flash('add');
   return redirect()->route('Trailers.index');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Trailer $trailer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trailer $trailer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,string $id)
    {
        $request->validate([
            'trailer_url' => ['required', 'min:1', 'max:255','url',Rule::unique('trailers')->ignore($id),'regex:/^(https?\:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/'],
            'movie_id' => ['required', Rule::exists(Movie::class, 'id')],
            




        ]);
        try {
            $Trailer=Trailer::findorfail($id);
             
            $Trailer->trailer_url=strip_tags($request->input('trailer_url'));
            $Trailer->movie_id=strip_tags($request->input('movie_id'));
            $Trailer->admin_id=Auth::guard('admin')->user()->id;
            $Trailer->save();

       
            
} catch (\Exception $e) {
     return redirect()->back()->withErrors(['error' => $e->getMessage()]);

}
   session()->flash('edit');
   return redirect()->route('Trailers.index');

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $to_delete =Trailer::findorfail($id);
                
              
            
            
            $to_delete->delete();
            session()->flash('delete');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
        return redirect()->route('Trailers.index');
    
       
        
    }
}
