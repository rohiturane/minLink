@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'Age Calculator'])
<div class="main-content bg-white mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-8 col-12">
            <form>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Date of Birth:</label>
                        <input type="date" required name="birth_date" id="birth_date" class="form-control text-field">
                    </div>
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Find Age on:</label>
                        <input type="date" required name="current_date" id="current_date" value="<?= date('Y-m-d') ?>" class="form-control text-field">
                    </div>
                    <button type="button" class="btn btn-sm bg-primary col-3 text-white rounded-5 px-sm-3" onclick="calculateAge()">Calculate</button>
                </div>
            </form>
            <div class="mt-3">
                <p>Your Age is: <p id="age-result"></p></p>
            </div>
            
            <div class="related_tools">
                {!! related_tools('5', 'ISA Calculator') !!}
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
<script>
    function calculateAge() {
        var birthdate = new Date(document.getElementById('birth_date').value);
        var currentDate = new Date(document.getElementById('current_date').value);

        var ageInMilliseconds = currentDate - birthdate;
        var ageInSeconds = ageInMilliseconds / 1000;
        var ageInMinutes = ageInSeconds / 60;
        var ageInHours = ageInMinutes / 60;
        var ageInDays = ageInHours / 24;
        var ageInYears = ageInDays / 365.25;

        var text = ageInYears+' years <br/>or '+Math.floor(ageInDays)+' days <br/>or '+Math.floor(ageInHours)+' hours <br/>or '+Math.floor(ageInMinutes)+' minutes <br/>or '+Math.floor(ageInSeconds)+' seconds';
        

        document.getElementById('age-result').innerHTML = text;
    }
</script>
@endsection