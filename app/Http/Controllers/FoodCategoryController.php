<?php

namespace App\Http\Controllers;

use App\Models\FoodCategory;
use Illuminate\Support\Facades\Auth;
use App\Models\Food;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class FoodCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $FoodCategorys=FoodCategory::all();
        return view('dashboard.FoodCategorys.index',compact('FoodCategorys'));
        
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
            'name' => ['required', 'min:1', 'max:255','unique:food_categories'],
            




        ]);

        try {
            $FoodCategory=new FoodCategory();
             
            $FoodCategory->name=strip_tags($request->input('name'));
            $FoodCategory->admin_id=Auth::guard('admin')->user()->id;
            $FoodCategory->save();

       
            
} catch (\Exception $e) {
     return redirect()->back()->withErrors(['error' => $e->getMessage()]);

}
   session()->flash('add');
   return redirect()->route('food-categories.index');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(FoodCategory $foodCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FoodCategory $foodCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,string $id)
    {
        $request->validate([
            
            'name' => ['required', 'min:1', 'max:255',Rule::unique('food_categories')->ignore($id)],
        ]);
        try {
            
            $FoodCategory=FoodCategory::findorfail($id);
            $FoodCategory->name=strip_tags($request->input('name'));
            $FoodCategory->save();
      
} catch (\Exception $e) {
   return redirect()->back()->withErrors(['error' => $e->getMessage()]);

}
session()->flash('edit');
return redirect()->route('food-categories.index');
            




        
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $to_delete =FoodCategory::findorfail($id);
                
              
            $FoodCategorycount=Food::where('food_category_id', $to_delete->id)->count();
            
            
            if ($FoodCategorycount > 0) {
                session()->flash('CategoriehasItem');
                return redirect()->route('food-categories.index');
            }
            
            $to_delete->delete();
            session()->flash('delete');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    
        return redirect()->route('food-categories.index');
        
    }
}
