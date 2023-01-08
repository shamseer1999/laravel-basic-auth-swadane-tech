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
            $user_id=decrypt(request('user_id'));
            $otp=request('otp');

            $check=User::where(['id'=>$user_id,'email_otp'=>$otp])->first();
            $time=time();
            $valid_time=round(($time-$check['otp_timeout'])/60);
            
            
            if($valid_time<10.0)
            {
                $check->email_verified_at=date("Y-m-d H:i:s");
                $check->save();
                return redirect()->route("dashbord");
            }else{
                return redirect()->route('login')->with("danger","Your otp has expierd");
            }
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
            if(auth()->user()->email_verified_at !="")
            {
                return redirect()->route("dashbord");
            }else{
                $otp=rand(1000,9999);
            $user=User::where('email',$credential['email'])->first();
            $user->email_otp=$otp;
            $user->otp_timeout=time();
            $user->save();

            $details=array(
                'title'=>'This is the OTP varification email',
                'body' =>'Please verify your email using this otp '.$otp.' and explore'
            );
            Mail::to(auth()->user()->email)->send(new otpVerify($details));

            return redirect()->route('email_varification')->with('success','Verify your email using otp.Please find out it from your email');
            }
            
        }
        else
        {
            return redirect()->route('login')->with('danger','Login is invalid');
        }
    }
}
