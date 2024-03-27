<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class DomainController extends Controller
{
    public function index()
    {
        $domains = Domain::get();

        return view('admin.domains.index', compact('domains'));
    }

    public function create()
    {
        return view('admin.domains.create');
    }

    public function store(Request $request)
    {
        $input_array = $request->all();

        $validate = Validator::make($input_array, [
            'domain' => 'required',
            'redirect' => 'required'
        ]);

        if($validate->fails())
        {
            return back()->withErrors($validate)->withInput(); 
        }

        $domain = Domain::create([
            'uuid' => Str::orderedUuid(),
            'domain' => $input_array['domain'],
            'redirect' => $input_array['redirect'],
            'status' => $input_array['status']
        ]);

        session()->flash('status','success');
        session()->flash('message', 'Domain Saved Successfully');

        return redirect('/domains');
    }

    public function edit($uuid)
    {
        $domain = Domain::where('uuid', $uuid)->first();

        return view('admin.domains.create', compact('domain'));
    }

    public function update($uuid, Request $request)
    {
        $input_array = $request->all();

        $validate = Validator::make($input_array, [
            'domain' => 'required',
            'redirect' => 'required'
        ]);

        if($validate->fails())
        {
            return back()->withErrors($validate)->withInput(); 
        }

        $domain = Domain::where('uuid', $uuid)->first();

        $domain->update([
            'domain' => $input_array['domain'],
            'redirect' => $input_array['redirect'],
            'status' => $input_array['status']
        ]);

        session()->flash('status','success');
        session()->flash('message', 'Domain Updated Successfully');

        return redirect('/domains');
    }

    public function delete($uuid)
    {
        $domain = Domain::where('uuid', $uuid)->first();

        if(!$domain) {
            session()->flash('status','success');
            session()->flash('message', 'Something went Wrong!! try again');

            return redirect('/domains');
        }
        //Link::where('domain_id', $domain->id)->update(['domain_id' => null]);
        $domain->delete();
        
        session()->flash('status','success');
        session()->flash('message', 'Domain Deleted Successfully');

        return redirect('/domains');
    }
}
