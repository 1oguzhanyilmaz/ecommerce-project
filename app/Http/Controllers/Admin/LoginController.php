<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function login(){
        if (\request()->isMethod('POST')){
            $this->validate(\request(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $credentials = [
                'email' => \request()->get('email'),
                'password' => \request()->get('password'),
                'is_manager' => 1,
            ];
            if (auth()->guard('admin')->attempt($credentials, \request()->has('remember'))){
                return redirect()->route('admin.dashboard');
            }else{
                return back()->withErrors('Login Failed');
            }
        }

        return view('admin.login');
    }

    public function logout(Request $request){
        auth()->guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

}
