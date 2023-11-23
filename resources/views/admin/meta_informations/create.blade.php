@extends('admin.layouts.app')
@section('admin_content')
<style>
    .ck-editor__editable {min-height: 400px;}
</style>
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">{{ empty($page) ? 'Create Page Information' : 'Edit Page Information' }}</h5>
                @if(empty($page))
                    <form method="post" action="{{ url('/admin/page_information/store') }}">
                @else 
                    <form method="post" action="{{ url('/admin/page_information/'.$page->id.'/update') }}">
                @endif
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Page Slug</label>
                        <input type="text" class="form-control" name="page_slug" value="{{ empty($page) ? '' : $page->page_slug }}" id="exampleInputEmail1" aria-describedby="emailHelp">
                        @if($errors->has('page_slug'))
                            <span class="text-danger ">{{ $errors->first('page_slug');}}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">HTML Content</label>
                        <textarea id="editor" name="html_content" rows="8">{{ empty($page) ? '' : $page->html_content }}</textarea>
                        @if($errors->has('html_content'))
                            <span class="text-danger ">{{ $errors->first('html_content');}}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Meta Title</label>
                        <input type="text" class="form-control" name="meta_title" value="{{ empty($page) ? '' : $page->meta_title }}" id="exampleInputEmail1" aria-describedby="emailHelp">
                        @if($errors->has('meta_title'))
                            <span class="text-danger ">{{ $errors->first('meta_title');}}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" class="form-control" rows="6">{{ empty($page) ? '' : $page->meta_description }}</textarea>
                        @if($errors->has('meta_description'))
                            <span class="text-danger">{{ $errors->first('meta_description');}}</span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">{{ empty($page) ? 'Save' : 'Update' }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('/js/ckeditor.js')}}"></script>
<script>
        ClassicEditor.create(document.getElementById('editor'))
            .then( editor => {
                editor.ui.view.editable.element.style.height = '400px';
            }  )
            .catch( error => {
                    console.error( error );
            } );
</script>
@endsection