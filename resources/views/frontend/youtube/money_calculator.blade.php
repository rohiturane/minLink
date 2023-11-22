@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'Youtube Money Calculator'])
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<div class="main-content bg-white mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-8 col-12">
    
            <form>
                <div class="row g-3">
                    <div class="col-md-12">
                    <label for="lang" class="form-label">Daily Views</label>
                    <input type="text" required name="daily_views" value="{{ empty($_GET['daily_views']) ? '100' : $_GET['daily_views']}}" class="form-control text-field">
                    </div>
                    <div class="col-md-12">
                        <p>
                        <label for="amount">Price range:</label>
                        <input type="text" id="amount" name="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                        </p>
                        
                        <div id="slider-range"></div>
                    </div>
                    <button type="submit" class="btn btn-sm bg-primary col-3 text-white rounded-5 px-sm-3">Calculate</button>
                </div>
            </form>

            @if(!empty($data))
            
                <div class="mt-4">
                    <table class="table table-striped table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>Estimated Daily Earnings</th>
                                <th>Estimated Monthly Earnings</th>
                                <th>Estimated Yearly Earnings</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ '$'.$data['cpm_min'].' - '. '$'.$data['cpm_max']}}</td>
                                <td>{{ '$'.$data['cpm_min_monthly'].' - '. '$'.$data['cpm_max_monthly']}}</td>
                                <td>{{ '$'.$data['cpm_min_yearly'].' - '. '$'.$data['cpm_max_yearly']}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
            <div class="related_tools">
                {!! related_tools('1', 'Youtube Money Calculator') !!}
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
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    
    //-----JS for Price Range slider-----

$( function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 10.00,
      step: 0.5, 
      values: [ 1.00, 4.20 ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      }
    });
    $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
      " - $" + $( "#slider-range" ).slider( "values", 1 ) );
  } );
</script>
@endsection
