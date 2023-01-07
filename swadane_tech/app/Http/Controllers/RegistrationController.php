<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    //
    public function form()
    {
        return view('register');
    }
    public function form_data(Request $request)
    {
        $validated=$request->validate([
            'first_name' =>'required',
            'last_name' =>'required',
            'email' =>'required|unique:users',
            'phone' =>'required|unique:users'
        ]);
        $pswd=request('pswd');
        $cpswd=request('cpswd');
        if($pswd != $cpswd)
        {
            return redirect()->route('form')->with('danger','Password and confirm password not match');
        }

        $input=array(
            'first_name' =>request('first_name'),
            'last_name' =>request('last_name'),
            'email' =>request('email'),
            'phone' =>request('phone'),
            'password' =>bcrypt(request('pswd'))
        );
        $insert=User::create($input);
        return redirect()->route('login')->with('success','Please login and verify your email');
    }
}
