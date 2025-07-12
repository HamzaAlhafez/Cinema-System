<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserProfileController extends Controller
{
    public function index()
    {

        $user=Auth::guard('user')->user();
         return view('user.profile',compact('user'));

    }



    public function edit()
{
    $user = auth()->user();
    return view('user.edit', compact('user'));
}

    
    public function update(Request $request)
    {


        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:15', 
        ]);

        $user = auth()->user(); 
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone; 
        $user->save(); 

        return redirect()->route('user.profile')->with('success', 'تم تحديث البيانات بنجاح!');
    }





    public function ChangePassword(Request $request)
{
   
    $request->validate([
        'currentPassword' => ['required', 'string', 'min:8'],
        'newPassword' => ['required', 'string', 'min:8'],
        'confirmPassword' => ['required', 'string', 'same:newPassword'],
    ]);

  
    $user = auth()->user(); 

    try {
       
        if (!Hash::check($request->input('currentPassword'), $user->password)) {
          
            session()->flash('CurrentpasswordFaild', 'The current password is incorrect.');
            return redirect()->back();
        }

       
        $user->password = Hash::make($request->input('newPassword'));
        $user->save();

      
        session()->flash('Passwordchangedsuccessfully', 'Your password has been successfully updated.');
        return redirect()->back();

    } catch (\Exception $e) {
       
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
}

}
