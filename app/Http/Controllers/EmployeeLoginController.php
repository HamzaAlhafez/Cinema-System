<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class EmployeeLoginController extends Controller
{

    public function Login(){
        return view('employee.auth.login');
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
     if (Auth::guard('employee')->attempt($date)) {

         return redirect()->route('employee.home')->with([
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
    Auth::guard('employee')->Logout();

      return redirect()->route('Employee.login')->with([
            'flash' => 'success',
            'message' =>' you have logout in successfuly',
        ]);

}
    
}
