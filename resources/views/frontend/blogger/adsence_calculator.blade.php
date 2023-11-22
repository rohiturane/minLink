@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'Adsence Calculator'])
<div class="main-content bg-white mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-8 col-12">
            <form>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Page impressions</label>
                        <input type="text" required name="impressions" value="{{empty($_GET['impressions']) ? '' : $_GET['impressions']}}" class="form-control text-field">
                    </div>
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Click Through Rate (CTR)</label>
                        <input type="text" required name="ctr" value="{{empty($_GET['ctr']) ? '' : $_GET['ctr']}}" class="form-control text-field">
                    </div>
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Cost Per Click</label>
                        <input type="text" required name="cpc" value="{{empty($_GET['cpc']) ? '' : $_GET['cpc']}}" class="form-control text-field">
                    </div>
                    <button type="submit" class="btn btn-sm bg-primary col-3 text-white rounded-5 px-sm-3">Calculate</button>
                </div>
            </form>

            @if(!empty($data))
            <div class="mt-3">
                <div class="mt-3 mb-3">
                    <table class="table table-striped table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>Time Periods</th>
                                <th>Earnings</th>
                                <th>Clicks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Daily</td>
                                <td>{{$data['daily_earnings']}}</td>
                                <td>{{$data['daily_clicks']}}</td>
                            </tr>
                            <tr>
                                <td>Monthly</td>
                                <td>{{$data['mothly_earnings']}}</td>
                                <td>{{$data['mothly_clicks']}}</td>
                            </tr>
                            <tr>
                                <td>Yearly</td>
                                <td>{{$data['yearly_earnings']}}</td>
                                <td>{{$data['yearly_clicks']}}</td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            <div class="related_tools">
                {!! related_tools('2', 'Adsence Calculator') !!}
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
