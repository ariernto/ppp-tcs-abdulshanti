@extends('layouts.app')
@section('content')
<section class="clear detail-section1">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="relative d-flex align-items-center mb-30">
            <span class="fontsize-12 colordef">Users <i class="fas fa-angle-right ml-1 mr-1"></i>
            <span class="fontsize-12 colordef">
                <a href="{{ url('/users') }}">
                    User and Role Management <i class="fas fa-angle-right ml-1 mr-1"></i>
                </a>
            </span><span class="fontsize-12 colorblue">User Detail </span>
          </div>
          <div class="relative d-flex">
            <h6 class="h6 fontweight-700 mb-30">
                <a href="{{ url('/users') }}">
                    <i class="fas fa-arrow-left fontsize-14 mr-1"></i>
                </a>
                User Detail </h6>
                <a href="JavaScript:Void(0);" class="ml-auto">
                <button class="btn fontsize-12 mr-0 edit-tenant-button"> <b> Edit </b> </button>
            </a>
          </div>
          <div class="white-box d-block mb-30">
              <div class="main-contant w-100">
                  <div class="relative w-50">
                      <p class="fontsize-14 colorblue fontweight-500">User Detail   </p>
                      <div class="d-flex mb-4">
                          <span class="detil-property">ID</span>
                          <span class="detil-value">{{ $user->id }} </span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">First Name </span>
                          <span class="detil-value">{{ $user->name }}</span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Last Name
                        </span>
                          <span class="detil-value">{{ $user->surname }}
                        </span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Email
                        </span>
                          <span class="detil-value">{{ $user->email }}
                        </span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Position
                        </span>
                          <span class="detil-value">{{ $user->position }}
                        </span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Date Created</span>
                          <span class="detil-value">{{ Carbon\Carbon::parse($user->created_at)->format('d F Y') }} </span>
                      </div>
                      <div class="d-flex mb-4">
                          @if ($user->profile_image != '')
                          <img src="{{ url('/public/uploads/users/') . '/' . $user->id . '/' . $user->profile_image }}" onerror="this.onerror=null;this.src='{{ url('/public/images/name-img1.png') }}';" class="border-radius8" alt="" width="120" height="120">
                          @else
                          <span class="user-default-icon-broad {{ strtolower(substr($user->name,0, 1)) }}">{{ substr($user->name,0, 1) }}</span>
                          @endif
                      </div>
                  </div>
                  <div class="relative w-50 pl-30  border-l">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <p class="fontsize-14 colorblue fontweight-500">Role
                        </p>
                    </div>
                    <div class="d-block mt-4 w-100 scroll-height">
                        @foreach ($user->hasPermission as $permission)
                        <div class="d-flex align-items-center justify-content-between mb-4 ">
                            <span class="fontsize-12">{{ $permission->permission_name }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
             </div>
            </div>

          </div>
      </div>
    </div>
  </section>
      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.js"></script>
      <script src="js/slick.js"></script>
      <script src="js/mani_custom.js"></script>
      <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
      <script src="js/wow.min.js"></script>
      <script>
        new WOW().init();
      </script>
      <script type="text/javascript">
        $(window).on ('load', function (){
          $('#loader').delay(100).fadeOut('slow');
          $('#loader-wrapper').delay(500).fadeOut('slow');
        });
        $('#datepicker7').datepicker({
              uiLibrary: 'bootstrap4'
        });
      </script>
@endsection
