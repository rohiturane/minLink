<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LicenseService;
use App\Services\ProjectService;
use Illuminate\Support\Facades\Validator;

class LicenseController extends Controller
{
    protected $service, $project;

    public function __construct(LicenseService $service, ProjectService $project)
    {
        $this->service = $service;
        $this->project = $project;
    }

    public function index()
    {
        $licenses = $this->service->index();

        return view('admin.licenses.index', compact('licenses'));
    }

    public function create()
    {
        $projects = $this->project->dropdownList();
        return view('admin.licenses.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $input_array = $request->all();

        $validate = Validator::make($input_array, [
            'project_id' => 'required',
            'host' => 'required',
        ]);

        if($validate->fails())
        {
            return back()->withErrors($validate)->withInput();
        }

        $license = $this->service->store($input_array);

        session()->flash('status','success');
        session()->flash('message', 'License saved Successfully');

        return redirect('/licenses');
    }

    public function edit($uuid)
    {
        $projects = $this->project->dropdownList();
        $license = $this->service->get($uuid);
        return view('admin.licenses.create', compact('projects', 'license'));
    }

    public function update($uuid, Request $request)
    {
        $input_array = $request->all();

        $validate = Validator::make($input_array, [
            'project_id' => 'required',
            'host' => 'required',
        ]);

        if($validate->fails())
        {
            return back()->withErrors($validate)->withInput();
        }

        $license = $this->service->update($uuid, $input_array);

        session()->flash('status','success');
        session()->flash('message', 'License updated Successfully');

        return redirect('/licenses');
    }

    public function destory($uuid)
    {
        $license = $this->service->destory($uuid);

        session()->flash('status','success');
        session()->flash('message', 'License deleted Successfully');

        return redirect('/licenses');
    }
}
