<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Movie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Categories=Categorie::all();
        return view('dashboard.categories.index',compact('Categories'));
        
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
            'Title' => ['required', 'min:1', 'max:255','unique:categories'],
            




        ]);

        try {
            $Categorie=new Categorie();
             
            $Categorie->title=strip_tags($request->input('Title'));
            $Categorie->admin_id=Auth::guard('admin')->user()->id;
            $Categorie->save();

       
            
} catch (\Exception $e) {
     return redirect()->back()->withErrors(['error' => $e->getMessage()]);

}
session()->flash('add');
return redirect()->route('categories.index');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            
            'Title' => ['required', 'min:1', 'max:255',Rule::unique('categories')->ignore($id)],
            




        ]);

        try {
            
              $Categorie =Categorie::findorfail($id);
              $Categorie->title=strip_tags($request->input('Title'));
              $Categorie->save();
        
} catch (\Exception $e) {
     return redirect()->back()->withErrors(['error' => $e->getMessage()]);

}
session()->flash('edit');
return redirect()->route('categories.index');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
        $to_delete =Categorie::findorfail($id);
            
          
        $MoivesCount = Movie::where('categorie_id', $to_delete->id)->count();
        
        
        if ($MoivesCount > 0) {
            session()->flash('Categoriehasmoive');
            return redirect()->route('categories.index');
        }
        
        $to_delete->delete();
        session()->flash('delete');
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }

    return redirect()->route('categories.index');
       
    }
}
