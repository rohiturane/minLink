<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
 
            return redirect()->intended('/admin/dashboard');
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
            'client_id' => Str::random(15)
        ]);

        $role = Role::where('name','user')->first();

        $user->syncRoles($role);

        return redirect('/login')->with(['message' => 'Your Account has been created successfully.']);
    }

    public function profile()
    {
        return view('admin.profile');
    }

    public function profileStore(Request $request)
    {
        $input_array = $request->all();
        //dd($input_array);

        $validate = Validator::make($input_array, [
            'name' => 'required',
            'new_password' => 'nullable|min:8|confirmed',
            'retype_password' => 'nullable|min:8'
        ]);

        if($validate->fails())
        {
            return back()->withErrors($validate)->withInput();
        }

        $user = User::find(auth()->user()->id);
        $user->name = $input_array['name'];
        
        if($input_array['new_password'] == $input_array['retype_password'])
        {
            $user->password = bcrypt($input_array['new_password']);
        }
        $user->save();

        session()->flash('status','success');
        session()->flash('message', 'Profile Data Updated Successfully');

        return redirect('/admin/dashboard');
    }
}
