@extends('admin.layouts.app')
@section('admin_content')
<style>
    .ck-editor__editable {min-height: 400px;}
</style>
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">{{ empty($ad) ? 'Create Advertise' : 'Edit Advertise' }}</h5>
                @if(empty($ad))
                    <form method="post" action="{{ url('/admin/advertise/store') }}" enctype="multipart/form-data">
                @else 
                    <form method="post" action="{{ url('/admin/advertise/'.$ad->id.'/update') }}" enctype="multipart/form-data">
                @endif
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Ad Slug</label>
                        <input type="text" class="form-control" name="ads_slug" value="{{ empty($ad) ? '' : $ad->ads_slug }}" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                        @if(!empty($ad->image))<span>{{$ad->image}}</span>@endif
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="2" {{ empty($ad) ? '' : ($ad->status == 2 ? 'selected': '')}}>Draft</option>
                            <option value="1" {{ empty($ad) ? '' : ($ad->status == 1 ? 'selected': '')}}>Active</option>
                            <option value="0" {{ empty($ad) ? '' : ($ad->status == 0 ? 'selected': '')}}>InActive</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">External HTML</label>
                        <textarea name="external_html" id="external_html" class="form-control" rows="6">{{ empty($ad) ? '' : $ad->external_html }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ empty($ad) ? 'Save' : 'Update' }}</button>
                </form>
            </div>
            <p class="text-center"><b>Ads Slugs:</b> youtube_horizontal, youtube_horizontal_end, youtube_vertical, seo_horizontal, seo_horizontal_end, seo_vertical, image_horizontal, image_horizontal_end, image_vertical, developer_horizontal, developer_horizontal_end, developer_vertical.</p>
        </div>
    </div>
</div>
@endsection