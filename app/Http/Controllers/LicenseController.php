<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Services\LicenseService;
use App\Services\ProjectService;
use App\Models\User;
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

    /**
     * Update status against each license.
     * 
     * @header Authorization Bearer {ACCESS_TOKEN}
     * @group License management
     * 
     */

    public function updateStatus(Request $request)
    {
        $input_array = $request->all();
        $headers = $request->header();
        
        $validate = Validator::make($input_array,[
            'access_code' => 'required',
        ]);

        if($validate->fails())
        {
            return response()->json(['status' => false, 'errors' => $validate->getMessageBag()],400);
        }

        $user = User::where('client_id', $input_array['user'])->first();
        if(!$user) {
            return response()->json(['status'=>false,'message'=>'Invalid Client Id'], 400);
        }

        $project = Project::where('uuid', $input_array['project'])->first();
        if(!$project) {
            return response()->json(['status'=>false,'message'=>'Invalid Project Id'], 400);
        }

        $host = $headers['host'][0];

        $license = License::where('project_id', $project->id)->where('user_id', $user->id)
                            ->where('access_code', $input_array['access_code'])
                            ->where('host', $host)->where('is_used', 0)->first();
        
        if(!$license) {
            $checkLicense = License::where('project_id', $project->id)->where('user_id', $user->id)
                            ->where('access_code', $input_array['access_code'])
                            ->where('host', $host)->where('is_used', 1)->first();
            if($checkLicense) {
                return response()->json(['status' => false,'message'=>'Access Code Already Used.'], 403);     
            }
            return response()->json(['status'=>false,'message'=>'Invalid Access Code'], 400); 
        }

        $data = [
            'is_used' => 1,
            'request_payload' => json_encode($headers),
        ];

        $license->update($data);

        return response()->json(['status' => true, 'message' => 'Successfully Activated'],200);
    }
}
