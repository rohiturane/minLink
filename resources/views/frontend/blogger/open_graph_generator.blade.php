@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'Open Graph Generator'])
<div class="main-content bg-white mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-8 col-12">
            <form>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Site Title</label>
                        <input type="text" name="title" class="form-control" value="{{empty($_GET['title']) ? '' : $_GET['title']}}">
                    </div>
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Site Name</label>
                        <input type="text" name="site_name" class="form-control" value="{{empty($_GET['site_name']) ? '' : $_GET['site_name']}}">
                    </div>
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Site URL</label>
                        <input type="text" name="site_url" class="form-control" value="{{empty($_GET['site_url']) ? '' : $_GET['site_url']}}">
                    </div>
                    <div class="col-md-6">
                        <label for="lang" class="form-label">Set Type</label>
                        <select name="type" id="type" class="form-select">
                            <option value="article">Article</option>
                            <option value="book">Book</option>
                            <option value="books.author">Book Author</option>
                            <option value="books.genre">Book Genre</option>
                            <option value="business.business">Business</option>
                            <option value="fitness.course">Fitness Course</option>
                            <option value="music.album">Music Album</option>
                            <option value="music.musician">Music Musician</option>
                            <option value="music.playlist">Music Playlist</option>
                            <option value="music.radio_station">Music Radio Station</option>
                            <option value="music.song">Music song</option>
                            <option value="object">Object (Generic Object)</option>
                            <option value="place">Place</option>
                            <option value="product">Product</option>
                            <option value="product.group">Product Group</option>
                            <option value="product.item">Product Item</option>
                            <option value="profile">Profile</option>
                            <option value="quick_election.election">Election</option>
                            <option value="restaurant">Restaurant</option>
                            <option value="restaurant.menu">Restaurant Menu</option>
                            <option value="restaurant.menu_item">Restaurant Menu Item</option>
                            <option value="restaurant.menu_section">Restaurant Menu Section</option>
                            <option value="video.episode">Video Episode</option>
                            <option value="video.movie">Video Movie</option>
                            <option value="video.tv_show">Video TV Show</option>
                            <option value="video.other">Video Other</option>
                            <option value="website">Website</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Number Of images</label>
                        <input type="text" class="form-control" name="images[]">
                    </div>
                    <div class="col-md-12">
                        <label for="">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-sm bg-primary col-3 text-white rounded-5 px-sm-3">Generate</button>
                </div>
            </form>

            @if(!empty($data))
            <div class="mt-3">
                <div class="mt-3 mb-3">
                    <textarea class="form-control" rows="5" id="meta_tags">{{$data}}</textarea>
                </div>
                <button type="button" class="btn btn-sm bg-success text-white rounded-5 px-sm-3" onclick="copyToClipboard('meta_tags')">Copy to Clipboard</button>
                <button type="button" class="btn btn-sm bg-danger text-white rounded-5 px-sm-3" onclick="resetForm()">Reset</button>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
