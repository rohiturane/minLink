<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Panel</title>
  <link rel="shortcut icon" type="image/png" href="{{asset('/images/logos/favicon.png')}}" />
  <link rel="stylesheet" href="{{asset('/css/styles.min.css')}}" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="{{ url('/admin/dashboard')}}" class="text-nowrap logo-img">
            <img src="{{ asset('/Super Tools.png')}}" width="180" alt="" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Home</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ url('/admin/dashboard')}}" aria-expanded="false">
                <span>
                  <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>
            
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ url('/admin/posts')}}" aria-expanded="false">
                <span>
                  <i class="ti ti-article"></i>
                </span>
                <span class="hide-menu">Post</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ url('/admin/setting')}}" aria-expanded="false">
                <span>
                  <i class="ti ti-settings"></i>
                </span>
                <span class="hide-menu">Settings</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{url('/admin/page_informations')}}" aria-expanded="false">
                <span>
                  <i class="ti ti-brand-pagekit"></i>
                </span>
                <span class="hide-menu">Page Information</span>
              </a>
            </li>
            <div class="fixed-bottom">
            <li class="" style="padding: 0px 24px;">
              <a class="btn btn-danger m-1" style="width: 220px;" href="{{url('/admin/optimize-app')}}">Optimize Application</a>
            </li>
            <li  style="padding: 0px 24px;">
              <a class="btn btn-primary m-1" style="width: 220px;" href="{{url('/admin/generate/sitemap')}}">Generate Sitemap</a>
            </li>
          </ul>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
            <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                <i class="ti ti-bell-ringing"></i>
                <div class="notification bg-primary rounded-circle"></div>
                </a>
            </li>
            </ul>
            <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
              <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                  <li class="nav-item dropdown">
                  <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      <img src="{{ asset('/images/profile/user-1.jpg')}}" alt="" width="35" height="35" class="rounded-circle">
                  </a>
                  <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                      <div class="message-body">
                      <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                          <i class="ti ti-user fs-6"></i>
                          <p class="mb-0 fs-3">My Profile</p>
                      </a>
                      <!-- <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                          <i class="ti ti-mail fs-6"></i>
                          <p class="mb-0 fs-3">My Account</p>
                      </a>
                      <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                          <i class="ti ti-list-check fs-6"></i>
                          <p class="mb-0 fs-3">My Task</p>
                      </a> -->
                      <a href="#" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                      <form id="frm-logout" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                      </form>
                      </div>
                  </div>
                  </li>
              </ul>
            </div>
        </nav>
      </header>
      @yield('admin_content')
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
  <script src="{{ asset('/libs/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{ asset('/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('/js/sidebarmenu.js')}}"></script>
  <script src="{{ asset('/js/app.min.js')}}"></script>
  <script src="{{ asset('/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
  <script src="{{ asset('/libs/simplebar/dist/simplebar.js')}}"></script>
  <script src="{{ asset('/js/dashboard.js')}}"></script>
  <script src="{{ asset('/js/custom.js')}}"></script>
  <script>
    $(function() {
            <?php if (session()->get('status') == 'error') { ?>
                generateToast("text-bg-danger", "{{ session()->get('message') }}");
            <?php } if(session()->get('status') == 'success') { ?>
                generateToast("text-bg-primary", "{{ session()->get('message') }}");
            <?php } else if(session()->get('status')) {
                session()->forgot('status');
                session()->forgot('message');
              }
             ?>
    });
  </script>
</body>

</html>