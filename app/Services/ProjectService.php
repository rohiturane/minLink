<?php
namespace App\Services;

use App\Models\Project;
use Illuminate\Support\Str;

class ProjectService 
{
    public function index()
    {
        if(auth()->user()->role == 'user')
        {
            $projects = Project::where('user_id', auth()->user()->id)->get();
        } else {
            $projects = Project::get();
        }
        return $projects;
    }

    public function store($params)
    {
        $data = [
            'uuid' => Str::orderedUuid(), 
            'name' => $params['name'],
            'user_id' => auth()->user()->id
        ];
        $project = Project::create($data);

        return $project;
    }

    public function get($uuid)
    {
        $project = Project::with('license','license.user')->where('uuid', $uuid)->first();

        return $project;
    }

    public function update($uuid, $params)
    {
        $project = Project::where('uuid', $uuid)->first();

        $data = [
            'name' => $params['name']
        ];

        $project->update($data);

        return $project;
    }

    public function destory($uuid)
    {
        $project = Project::where('uuid', $uuid)->first();

        if($project) 
        {
            $project->delete();
            return true;
        } 
        return false;
    }

    public function dropdownList()
    {
        return Project::pluck('name','id');
    }
}