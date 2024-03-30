<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $role = Role::get();
        return view('admin.users.create',compact('role'));
    }

    public function store(Request $request)
    {
        $input_array = $request->all();

        $validate = Validator::make($input_array,[
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validate->fails())
        {
            return back()->withErrors($validate)->withInput();
        }

        $user = User::create([
            'name' => $input_array['name'],
            'email' => $input_array['email'],
            'password' => bcrypt($input_array['password'])
        ]);

        $role = Role::find($input_array['role']);

        $role->users()->attach($user);

        session()->flash('status','success');
        session()->flash('message', 'User Saved Successfully');

        return redirect('/admin/users');
    }

    public function edit($id)
    {
        $user = User::find($id);
        $role = Role::get();

        return view('admin.users.create', compact('role', 'user'));
    }

    public function update($id, Request $request)
    {
        $input_array = $request->all();

        $validate = Validator::make($input_array,[
            'name' => 'required',
            'email' => 'required',
        ]);

        if($validate->fails())
        {
            return back()->withErrors($validate)->withInput();
        }

        $user = User::find($id);
        $user->name = $input_array['name'];
        $user->email = $input_array['email'];
        $user->password = empty($input_array['password'])? : bcrypt($input_array['password']);
        $user->save();

        $role = Role::find($input_array['role']);

        //$role->users()->attach($user);
        $user->syncRoles($role->name);

        session()->flash('status','success');
        session()->flash('message', 'User Updated Successfully');

        return redirect('/admin/users');
    }

    public function delete($id)
    {
        $user = User::find($id);

        if(!$user)
        {
            session()->flash('status','success');
            session()->flash('message', 'Something went Wrong!! try again');

            return redirect('/admin/users');
        }

        $user->delete();

        session()->flash('status','success');
        session()->flash('message', 'User Deleted Successfully');

        return redirect('/admin/users');
    }
}
