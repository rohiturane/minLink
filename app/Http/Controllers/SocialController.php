<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SocialController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('social_id', $user->id)->where('social_platform', 'google')->first();
            if($finduser){
                Auth::login($finduser);
                return redirect('/');
            }else{
                $checkUser = User::where('email', $user->email)->first();
                if($checkUser) {
                    $checkUser->social_id = $user->id;
                    $checkUser->social_platform = 'google';
                    $checkUser->save();
                    Auth::login($checkUser);
                } else {
                    
                    $newUser = User::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'social_id'=> $user->id,
                        'social_platform' => 'google',
                        'password' => Hash::make(Str::random(10))
                    ]);
                    $role = Role::where('name','user')->first();

                    $newUser->syncRoles($role);
                    Auth::login($newUser);
                }
                return redirect('/');
            }
        } catch (Exception $e) {
            session()->flash('status','danger');
            session()->flash('message',$e->getMessage());
            return back();
        }
    }
}
