<?php

namespace App\Http\Controllers;

use App\Mail\otpVerify;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

            $details=array(
                'title'=>'This is the OTP varification email',
                'body' =>'Please verify your email using this otp '.$otp.' and explore'
            );
            Mail::to(auth()->user()->email)->send(new otpVerify($details));

            return redirect()->route('email_varification')->with('success','Verify your email using otp');
        }
        else
        {
            return redirect()->route('login')->with('danger','Login is invalid');
        }
    }
}
