<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function authenicate(Request $request)
    {
        $input_array = $request->all();

        $validate = Validator::make($input_array, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validate->fails())
        {
            return back()->withErrors($validate);
        }

        $remember = false;

        if(!empty($input_array['remember'])) {
            $remember = $input_array['remember'];
        }
        
        if (Auth::attempt(['email' => $input_array['email'], 'password' => $input_array['password']], $remember)) 
        {
            $request->session()->regenerate();
 
            if(auth()->user()->role == 1)
            {
                return redirect()->intended('admin/dashboard');
            }
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }

    public function register()
    {
        return view('register');
    }

    public function registerUser(Request $request)
    {
        $input_array = $request->all();

        $validate = Validator::make($input_array, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validate->fails())
        {
            return back()->withErrors($validate);
        }

        $user = User::create([
            'name' => $input_array['name'],
            'email' => $input_array['email'],
            'password' => bcrypt($input_array['password']),
            'role' => 2
        ]);

        return redirect('/login')->with(['message' => 'Your Account has been created successfully.']);
    }
}
