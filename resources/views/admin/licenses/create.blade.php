@extends('admin.layouts.app')
@section('admin_content')
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">{{ empty($license) ? 'Create License' : 'Edit License' }}</h5>
                @if(empty($license))
                    <form method="post" action="{{ url('/license/store') }}">
                @else 
                    <form method="post" action="{{ url('/license/'.$license->uuid.'/update') }}">
                @endif
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Project</label>
                        <select name="project_id" id="project_id" class="form-select">
                            <option value="">Select a Project</option>
                            @foreach($projects as $key => $project)
                                <option value="{{$key}}">{{$project}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Host</label>
                        <input type="text" class="form-control" name="host" value="{{ empty($license) ? '' : $license->host }}" id="exampleInputEmail1" aria-describedby="emailHelp">
                        @if($errors->has('host'))
                            <span class="text-danger ">{{ $errors->first('host');}}</span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">{{ empty($license) ? 'Save' : 'Update' }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection