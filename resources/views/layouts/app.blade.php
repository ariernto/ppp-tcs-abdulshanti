<!DOCTYPE html>
<html class="has-tab-navigation @if (session('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d')){{'dark'}} @endif">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="{{ asset('public/css/bootstrap.css') }}" />
  <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="{{ asset('public/css/mani_layout.css') }}">
  <link rel="stylesheet" href="{{ asset('public/css/mani_style.css') }}" />
  <link rel="stylesheet" href="{{ asset('public/css/mani_responsive.css') }}" />
   <link rel="stylesheet" href="{{ asset('public/css/slick.css') }}" />

  <link rel="stylesheet" href="{{ asset('public/css/animation.css') }}" /> <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">


   <script src="{{ asset('public/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/js/popper.min.js') }}"></script>
    <script src="{{ asset('public/js/bootstrap.js') }}"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <script src="{{ asset('public/js/slick.js') }}"></script>
    <script src="{{ asset('public/js/mani_custom.js') }}"></script>
     <script src="{{ asset('public/js/jquery.buttonLoader.js') }}"></script>
    <script src="{{ asset('public/js/wow.min.js') }}"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>
  <link rel="stylesheet" href="{{ asset('public/css/animation.css') }}" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <link rel="shortcut icon" type="image/png"  href="{{ asset('public/images/favicon.png') }}" />

</head>
<body>
   @if(auth()->user())
          <!-- start header section-->
<header class="relative header home_header">
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid relative">
      <a class="navbar-brand" href="JavaScript:Void(0);">
        <img src="{{ asset('public/images/logo.png') }}" class="logo">
      </a>
      <button class="navbar-toggler togglerBtn" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
         <ul class="navbar-nav">
            @if (\App\helper\PermissionHelper::permissionCheck('view_dashboard'))
            <li class="nav-item">
              <a class="nav-link" href="{{ url('dashboard') }}">Dashboard</a>
            </li>
            @endif

            <li class="nav-item
                @if (
                    Request::segment(1) == 'properties' ||
                    Request::segment(1) == 'inspections' ||
                    Request::segment(1) == 'applications' ||
                    Request::segment(1) == 'enquiries' ||
                    Request::segment(1) == 'wishlist' ||
                    Request::segment(1) == 'maintanances'
                ) active @endif
            ">
              <a class="nav-link" href="JavaScript:Void(0);">Properties</a>
              <div class="menu">
                @if (\App\helper\PermissionHelper::permissionCheck('view_properties'))
                <a href="{{ url('/properties') }}" class="a_menu">Property Listing</a>
                @endif
                @if (\App\helper\PermissionHelper::permissionCheck('view_inspection'))
                <a href="{{ url('/inspections') }}" class="a_menu">Property Inspections</a>
                @endif
                @if (\App\helper\PermissionHelper::permissionCheck('view_applications'))
                <a href="{{ url('/applications') }}" class="a_menu">Property Applications</a>
                @endif
                @if (\App\helper\PermissionHelper::permissionCheck('view_enquiries'))
                <a href="{{ url('/enquiries') }}" class="a_menu">Property Enquiries</a>
                @endif
                @if (\App\helper\PermissionHelper::permissionCheck('view_wishlists'))
                <a href="{{ url('/wishlist') }}" class="a_menu">Property Wishists</a>
                @endif
                @if (\App\helper\PermissionHelper::permissionCheck('view_maintenance'))
                <a href="{{ url('/maintanances') }}" class="a_menu">Maintenance Requests</a>
                @endif
              </div>
            </li>

            @if (\App\helper\PermissionHelper::permissionCheck('view_client'))
            <li class="nav-item
                @if (Request::segment(1) == 'tenants' || Request::segment(1) == 'new-tenant' || Request::segment(1) == 'prospects' )
                    active
                @endif
            ">
              <a class="nav-link" href="JavaScript:Void(0);">Clients</a>
              <div class="menu">
                <a href="{{ url('/tenants') }}" class="a_menu">Tenants</a>
                @if (\App\helper\PermissionHelper::permissionCheck('add_client'))
                <a href="{{ url('/new-tenant') }}" class="a_menu">New Tenant</a>
                @endif
                <a href="{{ url('/prospects') }}" class="a_menu">Prospects</a>
              </div>
            </li>
            @endif
            @if (\App\helper\PermissionHelper::permissionCheck('view_role_user'))
            <li class="nav-item @if(Request::segment(1) == 'users' || Request::segment(1) == 'workers') active @endif">
              <a class="nav-link" href="JavaScript:Void(0);" >Users </a>
              <div class="menu">
                <a href="{{ url('/users') }}" class="a_menu">Users</a>
                <a href="{{ url('/workers') }}" class="a_menu">Workers</a>
              </div>
            </li>
            @endif
            @if (
                \App\helper\PermissionHelper::permissionCheck('view_guide_article') ||
                \App\helper\PermissionHelper::permissionCheck('view_update_notice') ||
                \App\helper\PermissionHelper::permissionCheck('view_article')
            )
            <li class="nav-item">
              <a class="nav-link" href="JavaScript:Void(0);">Content</a>
              <div class="menu">
                @if (\App\helper\PermissionHelper::permissionCheck('view_guide_article'))
                <a href="{{ url('/help') }}" class="a_menu">Help Guides</a>
                @endif
                @if (\App\helper\PermissionHelper::permissionCheck('view_article'))
                <a href="{{ url('/news') }}" class="a_menu">News</a>
                @endif
                @if (\App\helper\PermissionHelper::permissionCheck('view_update_notice'))
                <a href="{{ url('/update-notice') }}" class="a_menu">Update and Notice</a>
                @endif
              </div>
            </li>
            @endif

            @if (\App\helper\PermissionHelper::permissionCheck('view_events'))
            <li class="nav-item">
              <a class="nav-link" href="JavaScript:Void(0);">Events</a>
            </li>
            @endif
            @if (\App\helper\PermissionHelper::permissionCheck('view_document'))
            <li class="nav-item">
              <a class="nav-link" href="JavaScript:Void(0);">Documents</a>
            </li>
            @endif
            <!--<li class="nav-item">
              <a class="nav-link" href="JavaScript:Void(0);">Messages</a>
            </li>-->

          </ul>
      </div>
      <div class="">
        <ul class="mb-0 pl-0 right-nav ">
            <li class="nav-item">
              <a class="nav-link" href="JavaScript:Void(0);" >
                <img src="{{ asset('public/images/user-icon.svg') }}" alt="">
              </a>
              <div class="menu">
                <a href="{{ route('logout') }}" class="a_menu">Logout</a>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="JavaScript:Void(0);" >
                <img src="{{ asset('public/images/bell-icon.svg') }}" alt="">
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="JavaScript:Void(0);" >
                <img src="{{ asset('public/images/Question.svg') }}" alt="">
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="JavaScript:Void(0);" >
                <img src="{{ asset('public/images/settings.svg') }}" alt="">
              </a>
            </li>
          </ul>
      </div>
    </div>
  </nav>
</header>
<!-- header end -->

     @endif

    @yield('content')

    <script>
      new WOW().init();
    </script>
    <script type="text/javascript">
      $(window).on ('load', function (){
        $('#loader').delay(100).fadeOut('slow');
        $('#loader-wrapper').delay(500).fadeOut('slow');
      });

    $(document).on('click','.viewpass',function(){
        var id   =  $(this).attr('data-id');
        var type =  $(this).attr('data-type');
        if(type=='text'){
           $(this).html('<i class="far fa-eye-slash"></i>');
          $(this).attr('data-type','password');


        }else{
          $(this).html('<i class="far fa-eye"></i>');
          $(this).attr('data-type','text');

        }
        $("#"+id).attr('type',type);
      });
    </script>
</body>
</html>
