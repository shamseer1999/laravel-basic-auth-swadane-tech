<?php

namespace App\Http\Controllers;

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
        print_r(request()->all());
    }
}
