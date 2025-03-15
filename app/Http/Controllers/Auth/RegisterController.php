<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('guest');
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required','regex:/^09[1-689][0-9]{7}$/' , 'unique:users'],

        ],[
            "phone.regex" => "this number is not available on the network . please check the entered number and try again"



        ]);
    }


    protected function create(array $data)
    {


    try {
        return User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    } catch (Exception $e) {

        return null;
    }





    }
    public function register(Request $request)
{
    $this->validator($request->all())->validate();

    $user = $this->create($request->all());

    if ($user==null) {

        return redirect()->back()->with(['error' => 'Failed to create account. Please try again.']);
    }
    else
    {



          return redirect('login')->with([
            'flash' => 'success',
            'message' =>'Your account has been successfully created!',
        ]);

    }


}



}


