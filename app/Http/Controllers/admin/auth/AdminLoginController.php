<?php

namespace App\Http\Controllers\admin\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('Logout');

    }



    public function Login(){
        return view('admin.auth.login');
    }

     protected function validator(array $data)
    {
        return Validator::make($data,[
        "login" => ["required", "string"],
        "password" => ["required", "string"],
    ],[
        "login.required" => "the phone / email  is required"

    ]);


    }
    private function GetDate(Request $request)
    {
        $date = [
        'password' => $request->password,
    ];


    if (filter_var($request->login, FILTER_VALIDATE_EMAIL)) {
        $date['email'] = $request->login;
    } else {
        $date['phone'] = $request->login;
    }
    return $date;


    }






   public function CheckLogin(Request $request)
{
    $this->validator($request->all())->validate();
     $date=$this->GetDate($request);
     if (Auth::guard('admin')->attempt($date)) {

         return redirect()->route('admin.dashboard.home')->with([
            'flash' => 'success',
            'message' =>' you have logged in successfuly',
        ]);

    } else {
        return redirect()->back()
            ->withInput(['login' => $request->login])
            ->withErrors(['errorresponse' => 'These credentials do not match our records.']);
    }
}





public function Logout(){
    Auth::guard('admin')->Logout();

      return redirect()->route('admin.dashboard.login')->with([
            'flash' => 'success',
            'message' =>' you have logout in successfuly',
        ]);

}

}
