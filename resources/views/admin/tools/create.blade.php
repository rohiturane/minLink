@extends('admin.layouts.app')
@section('admin_content')
<style>
    .ck-editor__editable {min-height: 400px;}
</style>
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">{{ empty($tool) ? 'Create Tool' : 'Edit Tool' }}</h5>
                @if(empty($tool))
                    <form method="post" action="{{ url('/admin/tool/store') }}" enctype="multipart/form-data">
                @else 
                    <form method="post" action="{{ url('/admin/tool/'.$tool->id.'/update') }}" enctype="multipart/form-data">
                @endif
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ empty($tool) ? '' : $tool->name }}" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                        @if(!empty($tool->image))<span>{{$tool->image}}</span>@endif
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Link</label>
                        <input type="text" class="form-control" name="link" value="{{ empty($tool) ? '' : $tool->link }}" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Section</label>
                        <select name="section" id="section" class="form-select">
                            <option value="1" {{ empty($tool) ? '' : ( $tool->section==1 ? 'selected' : '')}}>Youtube section</option>
                            <option value="2" {{ empty($tool) ? '' : ( $tool->section==2 ? 'selected' : '')}}>SEO Section</option>
                            <option value="3" {{ empty($tool) ? '' : ( $tool->section==3 ? 'selected' : '')}}>Image Section</option>
                            <option value="4" {{ empty($tool) ? '' : ( $tool->section==4 ? 'selected' : '')}}>Developer Section</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="1" {{ empty($tool) ? '' : ( $tool->status==1 ? 'selected' : '')}}>Active</option>
                            <option value="2" {{ empty($tool) ? '' : ( $tool->status==2 ? 'selected' : '')}}>InActive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ empty($tool) ? 'Save' : 'Update' }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection