@extends('frontend.layouts.app')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" type="text/css" />
        <!-- Google fonts-->
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css" />
<!-- Youtube Events -->
<header class="masthead">
    <div class="container position-relative">
        <div class="row justify-content-center">
            <div class="col-xl-6">
                <div class="text-center text-white">
                    <!-- Page heading-->
                    <h1 class="mb-5">Min-Link: Link Shortener Service</h1>
                    
                    <form class="form-subscribe" id="contactForm" data-sb-form-api-token="API_TOKEN">
                        <!-- Email address input-->
                        <div class="row">
                            <div class="col">
                                <input class="form-control form-control-lg" id="link" type="text" placeholder="Enter your link" required />
                            </div>
                            <div class="col-auto"><button class="btn btn-primary btn-lg" id="submitButton" type="button">Shorten it!</button></div>
                        </div>
                        <div class="m-3">
                            <span>Min-Link is the World's Shortest Link Shortener service to track, brand, and share short URLs. </span>
                        </div>
                        
                    </form>
                </div>
            </div>
            <div class="table-responsive p-2 m-3 rounded" id="short_div" style="display: none; background: white;">
                <table class="table table-bordered"  id="table">
                    <tr>
                        <td>Title</td>
                        <td>Destination URL</td>
                        <td>Short Link</td>
                        <td>Action</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</header>
<!-- Icons Grid-->
<section class="features-icons bg-light text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                    <div class="features-icons-icon d-flex"><i class="bi bi-link-45deg m-auto text-primary"></i></div>
                    <h3>Shorten URL</h3>
                    <p class="lead mb-0">This theme will look great on any device, no matter the size!</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                    <div class="features-icons-icon d-flex"><i class="bi bi-bar-chart m-auto text-primary"></i></div>
                    <h3>Smart Report</h3>
                    <p class="lead mb-0">You will get smart reports of shorten link. It is fast and secure, our service has HTTPS protocol and data encryption</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="features-icons-item mx-auto mb-0 mb-lg-3">
                    <div class="features-icons-icon d-flex"><i class="bi-terminal m-auto text-primary"></i></div>
                    <h3>Easy to Use</h3>
                    <p class="lead mb-0">Easy and fast, enter the long link to get your shortened link</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Image Showcases-->
<section class="showcase">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-6 order-lg-2 text-white img-fluid showcase-img" style="background-image: url('images/1.jpg')"></div>
            <div class="col-lg-6 order-lg-1 my-auto showcase-text">
                <h2>Quick and easy URL shortening tool!</h2>
                <p class="lead mb-0">Long URLs from Instagram, Facebook, YouTube, Twitter, LinkedIn, WhatsApp, TikTok, blogs, and websites may be shortened with Min-Link. To shorten a URL, simply copy it and click the button. Share the shortened URL via email, chat, and the website by copying it from the following page. Check the URL's click-through rate once it has been shortened.</p>
            </div>
        </div>
        <div class="row g-0">
            <div class="col-lg-6 text-white img-fluid showcase-img" style="background-image: url('images/2.jpg')"></div>
            <div class="col-lg-6 my-auto showcase-text">
                <h2>Shorten, Distribute, and Monitor</h2>
                <p class="lead mb-0">You may use your shortened URLs in blogs, forums, papers, publications, ads, instant messaging, and other places. With our click counter, you can keep an eye on the number of hits coming from your URL and track data for your company and projects.</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action-->
<section class="call-to-action text-white text-center" id="signup">
    <div class="container position-relative">
        <div class="row justify-content-center">
            <div class="col-xl-6">
                <h2 class="mb-4">Sign up to Our Newsletter!</h2>
                <!-- Signup form-->
                <!-- * * * * * * * * * * * * * * *-->
                <!-- * * SB Forms Contact Form * *-->
                <!-- * * * * * * * * * * * * * * *-->
                <!-- This form is pre-integrated with SB Forms.-->
                <!-- To make this form functional, sign up at-->
                <!-- https://startbootstrap.com/solution/contact-forms-->
                <!-- to get an API token!-->
                <form class="form-subscribe" id="contactFormFooter" data-sb-form-api-token="API_TOKEN">
                    <!-- Email address input-->
                    <div class="row">
                        <div class="col">
                            <input class="form-control form-control-lg" id="email" type="email" placeholder="Email Address" data-sb-validations="required,email" />
                        </div>
                        <div class="col-auto"><button class="btn btn-primary btn-lg disabled" id="subscribe" type="button">Subscribe</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Footer-->
<script>
    $('#submitButton').click(function(){
        let guest = JSON.parse(localStorage.getItem('guest') ?? '{}');
        var oDateOne = new Date(guest.date);
        var oDateTwo = new Date();
        // console.log(oDateTwo)
        if(guest.count > 0 || oDateOne <= oDateTwo)
        {
            $.ajax({
                method: 'post',
                url: '/api/generate/short-link',
                data: {
                    'link' : $('#link').val(),
                    'guest': guest
                },
                success: function(response){
                    if(response.status) {
                        localStorage.setItem('guest', JSON.stringify(response.guest));
                        var link = response.link;
                        var short = "'"+window.location.hostname+'/'+link.code+"'";
                        var row = '<tr><td>'+link.title+'</td><td>'+link.url+'</td><td>'+window.location.hostname+'/'+link.code+'</td><td><button type="button" onclick="copyToClipboard('+short+')" class="btn btn-sm"><i class="bi bi-clipboard m-auto text-primary"></i></button></td></tr>';
                        $('#short_div').css('display', 'block');
                        $('#table').append(row);
                    }
                }
            });
        } else {
            generateToast("text-bg-danger", "Daily Limit exceeds. Please create an account or login");
        }
    });
</script>
@endsection