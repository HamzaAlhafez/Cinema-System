<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\TicketFood;
use App\Models\FoodCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;


use Illuminate\Http\Request;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $foods=Food::with('FoodCategory')->get();
        return view('dashboard.foods.index',compact('foods'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    private function VaildRequest(Request $request,$id=null)
    {
           $request->validate([
            'name' => ['required', 'min:1', 'max:255',Rule::unique('foods')->ignore($id)],
            'Categories_id' => ['required', Rule::exists(FoodCategory::class, 'id')],
            'description' => ['nullable','string' , 'min:1', 'max:255'],
             'price' => ['required', 'numeric'],
             'stock' => ['required', 'numeric'],
           

    ]);
}
public function SaveImage($name,$image,$folder)
    {

        $file_extension=$image -> getClientOriginalExtension() ;
        $file_name=$name . '.' .$file_extension;
        $path=$folder;

        $image -> move($path,$file_name);
        return $file_name;

    }

    
    public function store(Request $request)
    {
        $filename = $this->SaveImage($request->name, $request->image, 'imagesfoods/food');
        $this->VaildRequest($request);
        try {
            $Food = new Food();
        $Food->name = strip_tags($request->input('name'));
        $Food->description = $request->filled('description') 
    ? strip_tags($request->input('description'))
    : null;
        $Food->price =strip_tags($request->input('price'));
        $Food->image =$filename;
        $Food->stock =strip_tags($request->input('stock'));
        $Food->food_category_id=strip_tags($request->input('Categories_id'));
        $Food->admin_id=Auth::guard('admin')->user()->id;
        $Food->save();
        
        
       
             }
             catch (\Exception $e) {
              return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
        
            session()->flash('add');
            return redirect()->route('foods.index');
       
    }

    /**
     * Display the specified resource.
     */
    public function show(Food $food)
    {
        //
    }

   
    public function edit(Food $food)
    {
        
    }

   
    public function update(Request $request,$id)
    {
        $this->VaildRequest($request,$id);
        try 
        {
            $Food=Food::findorfail($id);
            $Food->name = strip_tags($request->input('name'));
            $Food->description = $request->filled('description') 
        ? strip_tags($request->input('description'))
        : null;
            $Food->price =strip_tags($request->input('price'));
            $Food->stock =strip_tags($request->input('stock'));
            $Food->food_category_id=strip_tags($request->input('Categories_id'));
             if($request->image!=null)
             {
                $destiantion='imagesfoods/food/'.$Food->image;
                if(file::exists($destiantion))
                {
                    file::delete($destiantion);

                }
                $filename = $this->SaveImage($request->name, $request->image, 'imagesfoods/food');
                $Food->image = $filename;

            }
            $Food->save();
 
                



             


           
          

        }
        catch(\Exception $e)
        {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }
        
        session()->flash('edit');
        return redirect()->route('foods.index');
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $to_delete =Food::findorfail($id);
            $FoodCategorycount=TicketFood::where('food_id', $to_delete->id)->count();
            
            
            if ($FoodCategorycount > 0 && $to_delete->stock > 0 ) {
                session()->flash('FoodHasTiket');
                return redirect()->route('foods.index');
            }

            $destiantion='imagesfoods/food/'.$to_delete->image;
            if(file::exists($destiantion))
            {
                file::delete($destiantion);

            }
            $to_delete->delete();
            session()->flash('delete');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
        return redirect()->route('foods.index');
    }

   


                
              
            
            
           
        
    
        
        
    
}
