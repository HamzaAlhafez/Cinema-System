<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MangerController extends Controller
{
    
    public function index()
    {
         $mangers = Manger::with('Admin')->get();
        return view('dashboard.mangers.index',compact('mangers'));
        
    }
     public function Search(Request $request)
    {
          $request->validate([
             'textSearch' => ['required'],

            
            
            
           
        ]);
       $textSearch=$request->textSearch;
       try 
       {
        $mangers=Manger::where('name', $textSearch )->get();

       }
       catch (\Exception $e) {
     return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    
}
       
      
       if($mangers->count() > 0)
       {
        return view('dashboard.mangers.index',compact('mangers'));

       }
       else 
       {
         session()->flash('SearchFaild');
        
        return redirect()->route('mangers.index');

       }


    }

    
    public function create()
    {
        
    }
    private function VaildRequest(Request $request)
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'phone' => ['required', 'regex:/^09[1-689][0-9]{7}$/', 'unique:mangers'],
        'email' => ['required', 'string', 'email', 'unique:mangers'],
        'password' => ['required', 'string', 'min:8'],
        'password-confirm' => ['required', 'string', 'same:password'],
    ]);
}

   
    public function store(Request $request)
    {
        $this->VaildRequest($request);
      
try {
      $manger=new Manger();
        $manger->name = strip_tags($request->input('name'));
$manger->email = strip_tags($request->input('email'));
$manger->phone = strip_tags($request->input('phone'));
$manger->password =hash::make(strip_tags($request->input('password'))); 
$manger->admin_id=Auth::guard('admin')->user()->id;
    $manger->save();
} catch (\Exception $e) {
     return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    
}
session()->flash('add');
return redirect()->route('mangers.index');

        

        


    }

    
    public function show(string $id)
    {
        
    }

   
    public function edit(string $id)
    {
       
    }

   
    public function update(Request $request, string $id)
    {
        
    }

    
    public function destroy(string $id)
    {
         try {
             $to_delete=Manger::findorfail($id);
        $to_delete -> delete();

        }
        catch (\Exception $e) {
     return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    
}

        

       session()->flash('delete');
return redirect()->route('mangers.index');

        
    }
}
