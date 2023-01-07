<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function email_varification(Request $request)
    {
        if($request->isMethod('post'))
        {
            return 1;
        }
        return view('email_verify');
    }
    public function login()
    {
        return view('login');
    }
    public function login_data(Request $request)
    {

        $credential=[
            'email'=>request('email'),
            'password'=>request('pswd')
        ];

        if(auth()->attempt($credential))
        {
            $otp=rand(1000,9999);
            $user=User::where('email',$credential['email'])->first();
            $user->email_otp=$otp;
            $user->save();

            return redirect()->route('email_varification')->with('success','Verify your email using otp');
        }
        else
        {
            return redirect()->route('login')->with('danger','Login is invalid');
        }
    }
}
