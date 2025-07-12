<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
    
     public function logout(Request $request)
    {
        $this->guard()->logout();
         return redirect()->route('home')->with([
            'flash' => 'success',
            'message' =>' you have logout in successfuly',
        ]);

        




    }
    protected function validator(array $data)
    {
        return Validator::make($data,[
        "userlogin" => ["required", "string"],
        "password" => ["required", "string"],
    ],[
        "userlogin.required" => "the phone / email  is required"

    ]);


    }
    public function GetDate(Request $request)
    {
        $date = [
        'password' => $request->password,
    ];


    if (filter_var($request->userlogin, FILTER_VALIDATE_EMAIL)) {
        $date['email'] = $request->userlogin;
    } else {
        $date['phone'] = $request->userlogin;
    }
    return $date;


    }
     public function login(Request $request)
    {
        $this->validator($request->all())->validate();

        $date=$this->GetDate($request);
        if (Auth::attempt($date)) {
        return redirect()->route('home')->with(['flash' => 'success', 'message' => 'Signed in!']);
    } else {
        return redirect()->back()
            ->withInput(['userlogin' => $request->userlogin])
            ->withErrors(['errorresponse' => 'These credentials do not match our records.']);
    }
}














}


