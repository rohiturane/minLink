@extends('admin.layouts.app')
@section('admin_content')
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">{{ empty($project) ? 'Create Project' : 'Edit Project' }}</h5>
                @if(empty($project))
                    <form method="post" action="{{ url('/project/store') }}">
                @else 
                    <form method="post" action="{{ url('/project/'.$project->uuid.'/update') }}">
                @endif
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ empty($project) ? '' : $project->name }}" id="exampleInputEmail1" aria-describedby="emailHelp">
                        @if($errors->has('name'))
                            <span class="text-danger ">{{ $errors->first('name');}}</span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">{{ empty($project) ? 'Save' : 'Update' }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection