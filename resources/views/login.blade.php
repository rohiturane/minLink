<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Super Tools</title>
  <meta name="title" content="Super Tools" />
  <meta name="description" content="Login to Super Tools Platforms" />
  <link rel="apple-touch-icon" sizes="180x180" href="{{asset('/apple-touch-icon.png')}}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{asset('/favicon-32x32.png')}}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{asset('/favicon-16x16.png')}}">
  <link rel="manifest" href="{{asset('/site.webmanifest')}}">
  <meta name="author" content="DevRohit" />
  <link rel="canonical" href="http://127.0.0.1:8000" />
  <meta property="twitter:title" content="Super Tools Login" />
  <meta property="twitter:description" content="Login to Super Tools Platforms" />
  <meta property="twitter:card" content="summary_large_image" />
  <meta property="twitter:image" content="http://127.0.0.1:8000/Super Tools.png" />
  <meta property="og:title" content="Super Tools Login" />
  <meta property="og:description" content="Login to Super Tools Platforms" />
  <meta property="og:image" content="http://127.0.0.1:8000/Super Tools.png" />
  <link rel="stylesheet" href="{{ asset('/css/styles.min.css')}}" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="{{ url('/') }}" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="{{ asset('/Super Tools.png')}}" width="180" alt="">
                </a>
                <p class="text-center">Super Tools Login</p>
                @if(session()->has('message'))
                <div class="alert alert-success" role="alert">
                    {{ session()->get('message')}}
                </div>
                @endif
                <form method="post" action="{{ url('/auth/authenicate/user')}}">
                     @csrf 
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Username</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                  </div>
                    @if($errors->has('email'))
                        <div class="error">{{ $errors->first('email') }}</div>
                    @endif
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                      <input class="form-check-input primary" name="remember" type="checkbox" value="true" id="flexCheckChecked">
                      <label class="form-check-label text-dark" for="flexCheckChecked">
                        Remeber this Device
                      </label>
                    </div>
                    <!-- <a class="text-primary fw-bold" href="./index.html">Forgot Password ?</a> -->
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign In</button>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">Don't have an Account?</p>
                    <a class="text-primary fw-bold ms-2" href="{{ url('/register')}}">Create an account</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{asset('/libs/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{ asset('/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
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
</body>

</html>