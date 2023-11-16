@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'Robot txt Generator'])
<div class="main-content bg-white mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-8 col-12">
            <form>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Default All Robots are</label>
                        <select name="all_robots" class="form-select">
                            <option value=" ">Allow</option>
                            <option value="/">Disallow</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Crawl-Delay</label>
                        <select name="delay" id="delay" class="form-select">
                            <option value="">No Delay</option>
                            <option value="5">5 Seconds</option>
                            <option value="10">10 Seconds</option>
                            <option value="20">20 Seconds</option>
                            <option value="60">60 Seconds</option>
                            <option value="120">120 Seconds</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Search Robots</label>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="">Google</label>
                            </div>
                            <div class="col-md-6">
                                <select name="google" id="google" class="form-select">
                                    <option value="">Same as Default</option>
                                    <option value="">Allow</option>
                                    <option value="/">Disallow</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="">Google Image</label>
                            </div>
                            <div class="col-md-6">
                                <select name="google_image" id="google_image" class="form-select">
                                    <option value="">Same as Default</option>
                                    <option value="">Allow</option>
                                    <option value="/">Disallow</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="">Google Mobile</label>
                            </div>
                            <div class="col-md-6">
                                <select name="google_mobile" id="google_mobile" class="form-select">
                                    <option value="">Same as Default</option>
                                    <option value="">Allow</option>
                                    <option value="/">Disallow</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="">MSN Search</label>
                            </div>
                            <div class="col-md-6">
                                <select name="msn_search" id="msn_search" class="form-select">
                                    <option value="">Same as Default</option>
                                    <option value="">Allow</option>
                                    <option value="/">Disallow</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="">Yahoo</label>
                            </div>
                            <div class="col-md-6">
                                <select name="yahoo" id="yahoo" class="form-select">
                                    <option value="">Same as Default</option>
                                    <option value="">Allow</option>
                                    <option value="/">Disallow</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="">Yahoo MM</label>
                            </div>
                            <div class="col-md-6">
                                <select name="yahoo_mm" id="yahoo_mm" class="form-select">
                                    <option value="">Same as Default</option>
                                    <option value="">Allow</option>
                                    <option value="/">Disallow</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="">Yahoo Blogs</label>
                            </div>
                            <div class="col-md-6">
                                <select name="yahoo_blogs" id="yahoo_blogs" class="form-select">
                                    <option value="">Same as Default</option>
                                    <option value="">Allow</option>
                                    <option value="/">Disallow</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="">Ask/Teoma</label>
                            </div>
                            <div class="col-md-6">
                                <select name="ask_teoma" id="ask_teoma" class="form-select">
                                    <option value="">Same as Default</option>
                                    <option value="">Allow</option>
                                    <option value="/">Disallow</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="">GigaBlast</label>
                            </div>
                            <div class="col-md-6">
                                <select name="gigablast" id="gigablast" class="form-select">
                                    <option value="">Same as Default</option>
                                    <option value="">Allow</option>
                                    <option value="/">Disallow</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="">DMOZ Checker</label>
                            </div>
                            <div class="col-md-6">
                                <select name="dmoz_checker" id="dmoz_checker" class="form-select">
                                    <option value="">Same as Default</option>
                                    <option value="">Allow</option>
                                    <option value="/">Disallow</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="">Nutch</label>
                            </div>
                            <div class="col-md-6">
                                <select name="nutch" id="nutch" class="form-select">
                                    <option value="">Same as Default</option>
                                    <option value="">Allow</option>
                                    <option value="/">Disallow</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="">Alexa/Wayback</label>
                            </div>
                            <div class="col-md-6">
                                <select name="alexa" id="alexa" class="form-select">
                                    <option value="">Same as Default</option>
                                    <option value="">Allow</option>
                                    <option value="/">Disallow</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="">Baidu</label>
                            </div>
                            <div class="col-md-6">
                                <select name="baidu" id="baidu" class="form-select">
                                    <option value="">Same as Default</option>
                                    <option value="">Allow</option>
                                    <option value="/">Disallow</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="">Naver</label>
                            </div>
                            <div class="col-md-6">
                                <select name="naver" id="naver" class="form-select">
                                    <option value="">Same as Default</option>
                                    <option value="">Allow</option>
                                    <option value="/">Disallow</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="">MSN PicSearch</label>
                            </div>
                            <div class="col-md-6">
                                <select name="msb_picpearch" id="msb_picpearch" class="form-select">
                                    <option value="">Same as Default</option>
                                    <option value="">Allow</option>
                                    <option value="/">Disallow</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="">Disallow Folders</label>
                        <textarea class="form-control" rows="4"></textarea>
                        <span class=""><b>Note:</b> Enter the folder name sepearte line</span>
                    </div>

                    <button type="submit" class="btn btn-sm bg-primary col-3 text-white rounded-5 px-sm-3">Generate</button>
                </div>
            </form>

            @if(!empty($data))
            <div class="mt-3">
                <div class="mt-3 mb-3">
                    <textarea class="form-control" rows="5" id="robot_txt">{{$data}}</textarea>
                </div>
                <button type="button" class="btn btn-sm bg-success text-white rounded-5 px-sm-3" onclick="copyToClipboard('robot_txt')">Copy to Clipboard</button>
                <button type="button" class="btn btn-sm bg-danger text-white rounded-5 px-sm-3" onclick="resetForm()">Reset</button>
            </div>
            @endif
            <div class="related_tools">
                {!! related_tools('2') !!}
            </div>
        </div>
        <div class="col-lg-3 col-12">
          {!! show_ads('seo_vertical') !!}
        </div>
    </div>
</div>
<div class="row px-5 py-4">
    <div class="page-information">
      {!! empty($page_info['html_content']) ? '' : $page_info['html_content'] !!}
    </div>
</div>
@endsection
