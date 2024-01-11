@extends('admin.layouts.app')
@section('admin_content')
<style>
    .ck-editor__editable {min-height: 400px;}
</style>
<link rel="stylesheet" href="{{asset('/css/select2.min.css')}}">
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">{{ empty($post) ? 'Create Post': 'Update Post'}}</h5>
                @if(empty($post))
                <form action="{{url('/post/store')}}" method="post" enctype="multipart/form-data">
                @else
                <form action="{{url('/post/'.$post->id.'/update')}}" method="post" enctype="multipart/form-data">
                @endif
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" value="{{ empty($post) ? '' : $post->title }}" name="title" aria-describedby="emailHelp">
                        @if($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title');}}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" value="{{ empty($post) ? '' : $post->slug }}" name="slug" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Category</label>
                        @php
                            $categoryArr = [];
                            if(!empty($post))
                            {
                                $categoryArr = explode(',', $post->category);
                            }
                            //dd($categoryArr);
                        @endphp
                        <select name="category[]" id="category" class="form-control"  multiple="multiple">
                            <option value="">Select a Category</option>
                            @foreach($categories as $category)
                                <option value="{{$category}}" @php if(in_array($category, $categoryArr)){ echo 'selected'; } @endphp>{{$category}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Tags</label>
                        @php
                            $tagArr = [];
                            if(!empty($post))
                            {
                                $tagArr = explode(',', $post->tags);
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
                        <label for="exampleInputEmail1" class="form-label">HTML Content</label>
                        <textarea id="editor" name="html" rows="8">{{ empty($post) ? '' : $post->html }}</textarea>
                        @if($errors->has('html'))
                            <span class="text-danger">{{ $errors->first('html');}}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Featured Image</label>
                        <input type="file" name="featured_image" id="featured_image" class="form-control">
                        @if(!empty($post->featured_image))<span>{{$post->featured_image}}</span>@endif
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Meta Title</label>
                        <input type="text" class="form-control" name="meta_title" value="{{ empty($post) ? '' : $post->meta_title }}" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" class="form-control" rows="6">{{ empty($post) ? '' : $post->meta_description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="0" @php if(!empty($post)) { if($post->status == 0){ echo 'selected'; } } @endphp>Draft</option>
                            <option value="1" @php if(!empty($post)) { if($post->status == 1){ echo 'selected'; } } @endphp>Published</option>
                            <option value="2" @php if(!empty($post)) { if($post->status == 2){ echo 'selected'; } } @endphp>Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary"> {{ empty($post) ? 'Save' : 'Update'}}</button>
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