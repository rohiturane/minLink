<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use OverflowException;

class DomainController extends Controller
{
    public function index()
    {
        if(auth()->user()->hasRole('admin'))
        {
            $domains = Domain::get();
        } else {
            $domains = Domain::where('created_by', auth()->id())->get();
        }

        return view('admin.domains.index', compact('domains'));
    }

    public function create()
    {
        return view('admin.domains.create');
    }

    public function store(Request $request)
    {
        if(!auth()->user()->hasFeature('domains'))
        {
            session()->flash('status','success');
            session()->flash('message', "You can't create Domains.");

            return redirect('/admin/dashboard');
        }
        
        try {
            auth()->user()->consume('domains', 1);
        } catch (OverflowException $e) {
            session()->flash('status','success');
            session()->flash('message', 'Domain limit exceeds. Please go to contact us page');

            return redirect('/');
        }
        catch(\Exception $e) {
            session()->flash('status','success');
            session()->flash('message', 'Something went wrong!!');
            Log::info('Error occurs in creating domains '.print_r($e->getMessage(), true));
            return redirect('/admin/dashboard');
        }

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

        return redirect('/admin/domains');
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

        return redirect('/admin/domains');
    }

    public function delete($uuid)
    {
        $domain = Domain::where('uuid', $uuid)->first();

        if(!$domain) {
            session()->flash('status','success');
            session()->flash('message', 'Something went Wrong!! try again');

            return redirect('/admin/domains');
        }
        //Link::where('domain_id', $domain->id)->update(['domain_id' => null]);
        $domain->delete();
        
        session()->flash('status','success');
        session()->flash('message', 'Domain Deleted Successfully');

        return redirect('/admin/domains');
    }
}
