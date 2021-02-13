<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function vallogin(Request $request)
    {
        request()->validate(
            [
                'username' => 'required',
                'password' => 'required'
            ]
        );

        $kredensil = $request->only('username', 'password');


        if( Auth::attempt($kredensil) ) {
            // $user = Auth::user();
               return redirect('/kasir');   
        }

        return redirect()->intended('/login');
    }
}
