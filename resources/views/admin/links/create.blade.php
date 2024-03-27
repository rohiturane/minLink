@extends('admin.layouts.app')
@section('admin_content')
<link rel="stylesheet" href="{{asset('/css/select2.min.css')}}">
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">{{ empty($link) ? 'Create Link': 'Update Link'}}</h5>
                @if(empty($link))
                <form action="{{url('/link/store')}}" method="post" enctype="multipart/form-data">
                @else
                <form action="{{url('/link/'.$link->uuid.'/update')}}" method="post" enctype="multipart/form-data">
                @endif
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" value="{{ empty($link) ? '' : $link->title }}" name="title" aria-describedby="emailHelp">
                        @if($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title');}}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="url" class="form-label">Destination Link</label>
                        <input type="text" class="form-control" id="url" value="{{ empty($link) ? '' : $link->url }}" name="url" aria-describedby="emailHelp">
                        @if($errors->has('url'))
                            <span class="text-danger">{{ $errors->first('url');}}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Domain</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Select a Domain</option>
                            @foreach($domains as $domain)
                                <option value="{{$domain->id}}" @php if(!empty($link)) { if($link->domain_id == $domain->id){ echo 'selected'; } } @endphp>{{ $domain->domain }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" value="" name="password" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="expire_at" class="form-label">Expire At</label>
                        <input type="date" class="form-control" id="expire_at" value="{{ empty($link) ? '' : $link->expire_at }}" name="expire_at" aria-describedby="emailHelp">
                        @if($errors->has('expire_at'))
                            <span class="text-danger">{{ $errors->first('expire_at');}}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Tags</label>
                        @php
                            $tagArr = [];
                            if(!empty($link))
                            {
                                $tagArr = explode(',', $link->tags);
                            }
                        @endphp
                        <select name="tags[]" id="tags" class="form-control"  multiple="multiple">
                            <option value="">Select a Tag</option>
                            @foreach($tags as $tag)
                                <option value="{{$tag}}" @php if(in_array($tag, $tagArr)){ echo 'selected'; } @endphp>{{$tag}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" cols="30" rows="10">{{ empty($link) ? '' : $link->description }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary"> {{ empty($link) ? 'Save' : 'Update'}}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('custom-scripts')
<script src="{{ asset('/js/select2.min.js')}}"></script>
<script src="{{ asset('/js/ckeditor.js')}}"></script>
<script>
    $("#category").select2({
        tags: true,
        tokenSeparators: [',', ' ']
    })
    $("#tags").select2({
        tags: true,
        tokenSeparators: [',', ' ']
    })
    ClassicEditor.create(document.getElementById('editor'))
    .then( editor => {
        editor.ui.view.editable.element.style.height = '400px';
    }  )
    .catch( error => {
            console.error( error );
    } );
</script>
@endpush