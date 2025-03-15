<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hall;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class HallController extends Controller
{

    public function index()
    {
        $halls=Hall::all();
        return view('dashboard.halls.index',compact('halls'));

    }


    public function store(Request $request)
    {
        $request->validate([
            'hall_name' => ['required', 'min:1', 'max:255','unique:halls'],
            'Capacity' => ['required'],




        ]);

        try {
             $hall = new Hall();
       $hall->hall_name=strip_tags($request->input('hall_name'));

        $hall->Capacity=strip_tags($request->input('Capacity'));
        $hall->admin_id=Auth::guard('admin')->user()->id;
     $hall->save();
} catch (\Exception $e) {
     return redirect()->back()->withErrors(['error' => $e->getMessage()]);

}
session()->flash('add');
return redirect()->route('halls.index');






    }





    public function update(Request $request,$id)
    {
        $request->validate([
            'hall_name' => ['required', 'min:1', 'max:255',Rule::unique('halls')->ignore($id)],
            'Capacity' => ['required'],




        ]);

        try {
              $hall =Hall::findorfail($id);
        $hall->hall_name=strip_tags($request->input('hall_name'));
        $hall->Capacity=strip_tags($request->input('Capacity'));
     $hall->save();
} catch (\Exception $e) {
     return redirect()->back()->withErrors(['error' => $e->getMessage()]);

}
session()->flash('edit');
return redirect()->route('halls.index');


    }


    public function destroy(string $id)
    {


}
}
