@extends('frontend.layouts.app')
@section('content')
@include('frontend.layouts.common',['title' => 'ISA Calculator'])
<div class="main-content bg-white mt-4" style="padding-left: 30px;">
    <div class="row">
        <div class="p-4 col-lg-8 col-12">
            <form>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Initial Deposit:</label>
                        <input type="number" required name="initial-deposit" id="initial-deposit" value="{{empty($_GET['initial-deposit']) ? '' : $_GET['initial-deposit']}}" class="form-control text-field">
                    </div>
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Contributions:</label>
                        <input type="number" required name="contributions" id="contributions" value="{{empty($_GET['contributions']) ? '' : $_GET['contributions']}}" class="form-control text-field">
                    </div>
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Interest Rate:</label>
                        <input type="number" required name="interest-rate" id="interest-rate" value="{{empty($_GET['interest-rate']) ? '' : $_GET['interest-rate']}}" class="form-control text-field">
                    </div>
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Investment Time (in years)</label>
                        <input type="number" required name="investment-time" id="investment-time" value="{{empty($_GET['investment-time']) ? '' : $_GET['investment-time']}}" class="form-control text-field">
                    </div>
                    <div class="col-md-12">
                        <label for="lang" class="form-label">Initial Deposit:</label>
                        <input type="number" required name="initial-deposit" id="initial-deposit" value="{{empty($_GET['initial-deposit']) ? '' : $_GET['initial-deposit']}}" class="form-control text-field">
                    </div>
                    <button type="button" class="btn btn-sm bg-primary col-3 text-white rounded-5 px-sm-3" onclick="calculateISA()">Calculate</button>
                </div>
            </form>
            <div class="mt-3">
                <p>Total ISA Amount: $<span id="isa-total-amount">0.00</span></p>
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
    function calculateISA() {
        var initialDeposit = parseFloat(document.getElementById('initial-deposit').value) || 0;
        var contributions = parseFloat(document.getElementById('contributions').value) || 0;
        var withdrawals = parseFloat(document.getElementById('withdrawals').value) || 0;
        var interestRate = parseFloat(document.getElementById('interest-rate').value) || 0;
        var investmentTime = parseFloat(document.getElementById('investment-time').value) || 0;

        
        
        for(var r, s = contributions, a=1; a <= investmentTime;){
            
            r = contributions;
            contributions = contributions/100*interestRate;
            contributions+=r;
            a++;
            
        }
        document.getElementById('isa-total-amount').textContent = contributions.toFixed(2);
    }
</script>


@endsection