<?php

namespace App\Http\Controllers\admin\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminRegisterController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('guest:admin');

    }

     public function Register(){
        return view('admin.auth.register');
    }
    private function IsAdminKeyVaild($adminkey)
    {

        return $adminkey==="adminkey1";


    }
    private function VaildRequest(Request $request)
    {
         $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'phone' => ['required','regex:/^09[1-689][0-9]{7}$/' , 'unique:admins','unique:users'],
                "email" => ["required","string","email","unique:admins","unique:users"],
                "admin_Key" => ["required","string"],
                "password" => ['required', 'string', 'min:8', 'confirmed'],
                "password_confirmation" => ['required', 'string']




            ],[
                "phone.regex" => "this number is not available on the network . please check the entered number and try again"



            ]);

    }
    private function CreateAdmin(Request $request)
    {
         $date=$request->except(['admin_Key','_token','password_confirmation']);
           $date['password'] = hash::make($request->password);
           try
           {
           return  Admin::create($date);

           }
           catch(\Exception $e)
           {
            return null;
           }
    }



    public function Store(Request $request){
        //  dd($request->all());
        $this->VaildRequest($request);

        if($this->IsAdminKeyVaild($request->admin_Key))
        {

            $date=$this->CreateAdmin($request);
            if($date==null)
            {
                return redirect()->back()->with(['error' => 'Failed to create account. Please try again.']);

            }
            else
            {

                 return redirect()->route('admin.dashboard.login')->with([
            'flash' => 'success',
            'message' =>'Your account has been successfully created!',
        ]);

            }


        }
        else
        {

            return redirect()->back()->withErrors(['errorresponse' => 'The Admin key is Wrong!.']);

        }





    }
}
