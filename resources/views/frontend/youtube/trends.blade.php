@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'Youtube Trends'])
<div class="main-content bg-white mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-8 col-12">
          <form>
              <div class="row g-3">
                  <div class="col-md-12">
                    <label for="country" class="form-label">Country</label>
                    <select class="form-select text-field" name="country" id="country" required="">
                      @foreach($countries as $key => $country)
                          <option value="{{$key}}" @if(!empty($_GET['country']) && $key == $_GET['country']) selected @endif>{{$country}}</option>
                      @endforeach
                    </select>
                    <div class="invalid-feedback">
                      Please select a valid country.
                    </div>
                  </div>
                  <div class="col-md-12">
                    <label for="lang" class="form-label">Language</label>
                    <select class="form-select text-field" name="lang" id="lang" required="">
                      @foreach($languages as $key => $language)
                          <option value="{{$key}}" @if(!empty($_GET['lang']) && $key == $_GET['lang']) selected @endif>{{$language}}</option>
                      @endforeach
                    </select>
                    <div class="invalid-feedback">
                      Please select a valid language.
                    </div>
                  </div>
                  <div class="col-md-12">
                    <label for="lang" class="form-label">Number of Result</label>
                    <input type="number" class="form-control text-field" required value="{{empty($_GET['result']) ? '1': $_GET['result']}}" min="1" max="100" name="result">
                  </div>
                  
                  <button type="submit" class="btn btn-sm bg-primary col-3 text-white rounded-5 px-sm-3">Search</button>
              </div>
          </form>

          @if(!empty($dataArray))
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead class="table-primary">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Thumbnail</th>
                  <th scope="col">Video</th>
                  <th scope="col">Video Tags</th>
                </tr>
              </thead>
              <tbody>
                @foreach($dataArray as $key => $data)
                  <tr>
                      <td scope="row">{{++$key}}</td>
                      <td><img src="{{$data['thumbnail']}}" class="img-fluid img-thumbnail"></td>
                      <td><a href="{{$data['link']}}">{{$data['title']}}</a></td>
                      <td>
                        @if(!empty($data['tags'][0]))
                          @foreach($data['tags'][0] as $tag)
                            <span class="badge rounded-pill text-bg-secondary">{{$tag}}</span>
                          @endforeach
                        @endif
                      </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @endif
          <div class="related_tools">
              {!! related_tools('1','Youtube Trends') !!}
          </div>
        </div>
        <div class="col-lg-3 col-12">
          {!! show_ads('youtube_vertical') !!}
        </div>
    </div>
</div>
<div class="row px-5 py-4">
    <div class="page-information">
      {!! empty($page_info['html_content']) ? '' : $page_info['html_content'] !!}
    </div>
</div>
@endsection