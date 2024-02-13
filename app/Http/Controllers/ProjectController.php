<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProjectService;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    protected $service;

    public function __construct(ProjectService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $projects = $this->service->index();

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $input_array = $request->all();

        $validate = Validator::make($input_array,[
            'name' => 'required',
        ]);

        if($validate->fails())
        {
            return back()->withErrors($validate)->withInput();
        }

        $project = $this->service->store($input_array);

        session()->flash('status','success');
        session()->flash('message', 'Project saved Successfully');

        return redirect('/projects');
    }

    public function edit($uuid)
    {
        $project = $this->service->get($uuid);

        return view('admin.projects.create', compact('project'));
    }

    public function update($uuid, Request $request)
    {
        $input_array = $request->all();

        $validate = Validator::make($input_array,[
            'name' => 'required',
        ]);

        if($validate->fails())
        {
            return back()->withErrors($validate)->withInput();
        }

        $project = $this->service->update($uuid, $input_array);

        session()->flash('status','success');
        session()->flash('message', 'Project updated Successfully');

        return redirect('/projects');
    }

    public function destory($uuid)
    {
        $project = $this->service->destory($uuid);

        session()->flash('status','success');
        session()->flash('message', 'Project deleted Successfully');

        return redirect('/projects');
    }
}
