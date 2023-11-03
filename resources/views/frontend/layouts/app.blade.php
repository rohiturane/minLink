<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! empty($page_meta) ? '' : $page_meta !!}
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/app.css')}}">
    <script src="{{asset('js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
</head>

<body>
    <nav class="navbar align-items-center border-bottom fixed-top" style="background: white;">
        <div class="container-fluid">
            <div class="d-flex align-items-center ">
                <a href="/" class="navbar-brand m-0 textColor fw-bold brand">
                    <img src="{{ asset('/Super Tools.png')}}" alt="" style="width: 200px;" srcset="">
                </a>

                <div class="position-relative ms-4 d-none d-xl-inline-block">
                    <div class="dropdown">
                        <input class="searchInput bg-body-tertiary iconCursor ps-md-5 p-1 p-md-2" id="search" type="search" onkeyup="doOn(this);" placeholder="Search Tools" aria-label="Search">
                        
                        <span class="position-absolute searchImg iconCursor">
                            <i class="fa-solid fa-magnifying-glass"></i></span>

                            <ul id="def1" class="dropdown-menu list-group" style="display:none"></ul>
                    </div>
                </div>
                
            </div>
            <div class="d-flex align-items-center">
                <div class="d-none d-lg-block">
                    <ul class="d-flex m-0 list-unstyled ">
                        <!-- <li class="nav-item iconChange   me-4 pt-2">
                            <a href="#" class="nav-link text-center p-0">

                                <div class="smallFont textColor">About us</div>
                            </a>
                        </li> -->
                        <li class="nav-item iconChange  me-4 pt-2">
                            <a href="#" class="nav-link text-center p-0">

                                <div class="smallFont textColor">Blog</div>
                            </a>
                        </li>
                        <li class="nav-item iconChange  me-4 pt-2">
                            <a href="#" class="nav-link text-center p-0">

                                <div class="smallFont textColor">Privacy Policy</div>
                            </a>
                        </li>
                        <li class="nav-item iconChange  me-3 pt-2">
                            <a href="#" class="nav-link text-center p-0">

                                <div class="smallFont textColor">Terms of Service</div>
                            </a>
                        </li>
                        <li class="nav-item iconChange  me-3 pt-2">
                            <a href="#" class="nav-link text-center p-0">

                                <div class="smallFont textColor">Contact Us</div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div id="iconContainer" class="d-flex justify-content-center align-items-center rounded-5 bg-light d-xl-none">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                @if(Auth::check())
                <div class="dropdown">
                    <a class="btn btn-light text-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{Auth::user()->name}}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('form-logout').submit();" href="#">Logout</a></li>
                        <form id="form-logout" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                      </form>
                    </ul>
                </div>
                @else 
                    <a id="loginBtn" href="{{ url('/login')}}" class="btn btn-sm m-sm-2 m-1 bg-primary text-white rounded-5 px-sm-3 px-2">Login</a>
                @endif
            </div>
        </div>
    </nav>

    <div class="container-fluid" style="padding: 0;">

        @yield('content')
    </div>
    <!-- Remove the container if you want to extend the Footer to full width. -->
    <div class="container-fluid" style="background: black;">

        <footer class="text-center text-lg-start mt-xl-5 pt-4">
            <!-- Grid container -->
            <div class="container p-4">
                <!--Grid row-->
                <div class="row">
                    <!--Grid column-->
                    <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                        <h5 class="text-uppercase mb-4">YOUTUBE TOOLS</h5>

                        <ul class="list-unstyled mb-4">
                            <li>
                                <a href="{{ url('/youtube-trends')}}" class="text-white nav-link">Youtube Trends</a>
                            </li>
                            <li>
                                <a href="{{ url('/youtube-generate-tags')}}" class="text-white nav-link">Youtube Tag Generator</a>
                            </li>
                            <li>
                                <a href="{{ url('/youtube-generate-hashtag')}}" class="text-white nav-link">Youtube Hashtag Generator</a>
                            </li>
                            <li>
                                <a href="{{ url('/youtube-video-statistics')}}" class="text-white nav-link">Youtube Video Statistics</a>
                            </li>
                            <li>
                                <a href="{{ url('/youtube-channel-statistics')}}" class="text-white nav-link">Youtube Channel Statistics</a>
                            </li>
                        </ul>
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                        <h5 class="text-uppercase mb-4">BLOG SEO Tools</h5>

                        <ul class="list-unstyled">
                            <li>
                                <a href="{{ url('/terms-of-service-generator')}}" class="text-white nav-link">Terms of Service Generator</a>
                            </li>
                            <li>
                                <a href="{{ url('/privacy-policy-generator')}}" class="text-white nav-link">Privacy Policy Generator</a>
                            </li>
                            <li>
                                <a href="{{ url('/lorem-ipsum-generator')}}" class="text-white nav-link">Lorem Ipsum Generator</a>
                            </li>
                            <li>
                                <a href="{{ url('/keyword-suggestion')}}" class="text-white nav-link">Keyword Suggestion Tool</a>
                            </li>
                            <li>
                                <a href="{{ url('/domain-lookup')}}" class="text-white nav-link">Whois Domain Lookup</a>
                            </li>
                            <li>
                                <a href="{{ url('/robot-txt-generator')}}" class="text-white nav-link">Robot.txt Generator</a>
                            </li>
                        </ul>
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                        <h5 class="text-uppercase mb-4">Image Tools</h5>

                        <ul class="list-unstyled">
                            <li>
                                <a href="{{ url('/jpg-to-webp-generator')}}" class="text-white nav-link">JPG to Webp converter</a>
                            </li>
                            <li>
                                <a href="{{ url('/png-to-webp-generator')}}" class="text-white nav-link">PNG to Webp converter</a>
                            </li>
                            <li>
                                <a href="{{ url('/image-resizer')}}" class="text-white nav-link">Image Resizer</a>
                            </li>
                            <li>
                                <a href="{{ url('/image-compressor')}}" class="text-white nav-link">Image Compressor</a>
                            </li>
                        </ul>
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                        <h5 class="text-uppercase mb-4">Sign up to our newsletter</h5>

                        <div class="form-outline form-white mb-4">
                            <input type="email" id="email" class="form-control" placeholder="Email Address"/>
                            <button type="button" id="subscribe" class="btn btn-sm m-sm-2 m-1 bg-primary text-white rounded-5 px-sm-3 px-2">Subscribe</button>
                            <p id="subscribe_msg"></p>
                        </div>
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                        <h5 class="text-uppercase mb-4">Image Tools</h5>

                        <ul class="list-unstyled">
                            <li>
                                <a href="{{ url('/csv-to-json-converter')}}" class="text-white nav-link">CSV to JSON Converter</a>
                            </li>
                            <li>
                                <a href="{{ url('/json-to-csv-converter')}}" class="text-white nav-link">JSON to CSV Converter</a>
                            </li>
                            <li>
                                <a href="{{ url('/json-validator')}}" class="text-white nav-link">JSON Validation</a>
                            </li>
                            <li>
                                <a href="{{ url('/json-beautifier')}}" class="text-white nav-link">JSON Beautifier</a>
                            </li>
                            <li>
                                <a href="{{ url('/password-generator')}}" class="text-white nav-link">Password Generator</a>
                            </li>
                            <li>
                                <a href="{{ url('/sha-generator')}}" class="text-white nav-link">SHA Generator</a>
                            </li>
                            <li>
                                <a href="{{ url('/hash-generator')}}" class="text-white nav-link">HASH Generator</a>
                            </li>
                        </ul>
                    </div>
                    <!--Grid column-->
                </div>
                <!--Grid row-->
            </div>
            <!-- Grid container -->
            <hr />
            <!-- Copyright -->
            <div class="text-center p-3">
                © 2020 Copyright:
                <a class="text-white" href="https://devrohit.com/">Devrohit</a>
            </div>
            <!-- Copyright -->
        </footer>

    </div>
    <!-- End of .container -->
    <div class="float-sm">
        <div class="fl-fl float-fb">
            <i class="fa-brands fa-2xl fa-facebook-f" style="color: #f5f5f5;margin-top: 20px;margin-left: 10px;"></i>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}" target="_blank"> Facebook</a>
        </div>
        <div class="fl-fl float-tw">
            <i class="fa-brands fa-2xl fa-x-twitter" style="color: #f5f5f5;margin-top: 20px;margin-left: 10px;"></i>
            <a href="http://twitter.com/share?url={{url()->current()}}" target="_blank">Twitter</a>
        </div>
        <!-- <div class="fl-fl float-ig">
                <i class="fa-brands fa-2xl fa-instagram" style="color: #f5f5f5;margin-top: 20px;margin-left: 10px;"></i>
                <a href="" target="_blank">Instagram</a>
            </div> -->
        <div class="fl-fl float-ig">
            <i class="fa-brands fa-2xl fa-linkedin-in" style="color: #f5f5f5;margin-top: 20px;margin-left: 10px;"></i>
            <a href="https://www.linkedin.com/shareArticle?url={{url()->current()}}" target="_blank">LinkedIn</a>
        </div>
    </div>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div id="toast_message" class="toast-body">
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <a id="back-to-top" href="#" class="btn btn-secondary btn-md back-to-top" role="button"><i class="fas fa-chevron-up"></i></a>
    <script src="{{asset('js/custom.js')}}"></script>
    @php
        $setting = Cache::get('setting');
            
        if(empty($setting)) {
            $setting = Cache::rememberForever('setting', function () {
                return Setting::get();
            });
        }
        $api_key = find_object($setting, 'google_capatch_site_key');
    @endphp
    @if(!$api_key->isEmpty())
    <script src="https://www.google.com/recaptcha/api.js?render={{$api_key->first()->value}}"></script>
    @endif
    <script>
        $(function() {
            <?php if (session()->get('status') == 'error') { ?>
                generateToast("text-bg-danger", "{{ session()->get('message') }}");
            <?php } else if(session()->get('status') == 'success') { ?>
                generateToast("text-bg-primary", "{{ session()->get('message') }}");
            <?php } else if(session()->get('status')) {
                session()->forgot('status');
                session()->forgot('message');
              }
             ?>
            var temp = {};
            var tools = localStorage.getItem('tools') ?? 'NA';
            
            if(tools == 'NA')
            {
                // console.log('NA')
                var items = $(".tool-name");
                items.each(function (key, item) {
                    temp[item.textContent] = item.closest('a').href;
                });
                // console.log(temp)
                localStorage.setItem('tools', JSON.stringify(temp));
            }   
            
        });
        $(document).ready(function() {
            $(window).scroll(function() {
                if ($(this).scrollTop() > 100) {
                    $('#back-to-top').fadeIn();
                } else {
                    $('#back-to-top').fadeOut();
                }
            });
            // scroll body to 0px on click
            $('#back-to-top').click(function() {
                $('body,html').animate({
                    scrollTop: 0
                }, 400);
                return false;
            });
        });
        $('#subscribe').click(function(){
            $.ajax({
                url: '{{ url("/add-subscription")}}',
                method: 'post',
                data: {
                    email: $('#email').val(),
                    '_token': "{{ csrf_token() }}",
                },
                success: function(response) {
                    $('#subscribe_msg').text('');
                    $('#subscribe_msg').removeClass();
                    if(response.status) {
                        $('#subscribe_msg').addClass('text-success');
                        $('#subscribe_msg').text(response.message);
                    } else {
                        $('#subscribe_msg').addClass('text-danger');
                        $('#subscribe_msg').text(response.error.email[0]);
                    }
                    $('#email').val('');
                }
            })
        });
        
        function doOn(obj)
        {
            var text = $(obj).val().toLowerCase();
            var items = JSON.parse(localStorage.getItem('tools'));
            console.log(items)
            $("#def1 li").remove();
            if(text.length > 0 && Object.keys(items).length > 0)
            {
                // items.each(function (key, item) {
                for (const key in items) {
                    if(key.includes(text)) {
                        $("<li class='list-group-item'><a href='"+items[key]+"' class='text-decoration-none'>"+key+"</a></li>").appendTo("#def1");
                    }
                }
                document.getElementById("def1").style.display="block";
            }
            else {
                $("#def1 li").remove();
                document.getElementById("def1").style.display="none";
            }
        }
    </script>
</body>

</html>