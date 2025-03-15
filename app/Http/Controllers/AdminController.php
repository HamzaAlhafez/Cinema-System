<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


//contactus and cuontactshowform and showChangePassowrd and update personal information

class AdminController extends Controller
{

    public function index()
    {

        $admin=Auth::guard('admin')->user();
         return view('dashboard.Admins.edit',compact('admin'));

    }


    public function ContactUs(Request $request)
{
    $admin = Auth::guard('admin')->user();

    if ($request->has('Message')) {
        $message = $request->input('Message');


        $formattedMessage = "Message from: " . $admin->name . "\n" .
                            "Email: " . $admin->email . "\n" .
                            "Message content : " .  $message . "\n" . "------------------------------" . "\n";


        $filePath = public_path('ContactUsAdmin/message.txt');


        file_put_contents($filePath, $formattedMessage.PHP_EOL, FILE_APPEND);

        session()->flash('Contectus');
        return redirect()->back();
    }
}

    function ContactusShowform()
    {
        return view('dashboard.Admins.Contactus');

    }
    public function Viewproifle()
    {
         return view('dashboard.Admins.Viewproifle');
    }
     private function VaildRequest(Request $request,$id)
    {
         $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'phone' => ['required','regex:/^09[1-689][0-9]{7}$/',Rule::unique('admins')->ignore($id)],
                'email' => ["required","string","email",Rule::unique('admins')->ignore($id)],





            ]);

    }
    public function ShowChangePasswordForm()
    {
        return view('dashboard.Admins.changepassword');
    }
    public function ChangePassword(Request $request)
{
     $request->validate([
        'currentPassword' => ['required', 'string', 'min:8'],
        'newPassword' => ['required', 'string', 'min:8'],
        'confirmPassword' => ['required', 'string', 'same:newPassword'],
    ]);

    $admin = Auth::guard('admin')->user();
    try
    {



    if (!Hash::check($request->input('currentPassword'), $admin->password)) {
        session()->flash('CurrentpasswordFaild');
        return redirect()->back();

    }


    $admin->password = Hash::make($request->input('newPassword'));
    $admin->save();

    }
    catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);





               }
                session()->flash('Passwordchangedsuccessfully');
        return redirect()->back();






}



    public function update(Request $request,$id)
    {
           $this->VaildRequest($request,$id);

           try
           {
              $admin=Auth::guard('admin')->user();
        $admin->name=strip_tags($request->input('name'));
        $admin->email=strip_tags($request->input('email'));
        $admin->phone=strip_tags($request->input('phone'));
     $admin->save();

           }
               catch (\Exception $e) {
                         session()->flash('PhoneorEmailDeplicate');
                          return redirect()->back();
       }

session()->flash('edit');
return redirect()->route('Admins.index');

}


    public function destroy(string $id)
    {

    }



    public function create()
    {


    }


    public function store(Request $request)
    {
    }


    public function show(string $id)
    {}
    public function edit($id)
    {}

}
