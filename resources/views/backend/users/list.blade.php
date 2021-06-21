@extends('layouts.app')
@section('content')
<section class="clear table-section1">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="relative d-flex align-items-center mb-30">
          <span class="fontsize-12 colordef">Users <i class="fas fa-angle-right ml-1 mr-1"></i></span><span class="fontsize-12 colorblue">User and Role Management </span>
        </div>
        <span id="messageBox">
          @if(session()->has('success'))
          <div class="alert alert-success" style="text-transform: lowercase;">
			  <a href="#" class="close" id="close_alert" data-dismiss="alert" aria-label="close">&times;</a>
			  <p class="bold mb-0" style="text-transform: capitalize;"> Message </p>
              {{ session()->get('success') }}
          </div>
          @endif
          @if(session()->has('norecord'))
              <div class="alert alert-warning">
                <a href="#" class="close" id="close_alert" data-dismiss="alert" aria-label="close">&times;</a>
                <p class="bold mb-0"> Message </p>
                {{ session()->get('norecord') }}
                @php session()->forget('norecord'); @endphp
              </div>
              @endif
              @if(session()->has('error'))
              <div class="alert alert-danger">
                <a href="#" class="close" id="close_alert" data-dismiss="alert" aria-label="close">&times;</a>
                <p class="bold mb-0"> Message </p>
                {{ session()->get('error') }}
                @php session()->forget('error'); @endphp
              </div>
              @endif
        </span>
        <div class="relative d-flex align-items-center justify-content-between">
          <h6 class="h6 fontweight-700">User and Role Management </h6>
          <div class="d-flex search-btn-block">
            @if (\App\helper\PermissionHelper::permissionCheck('add_role_user'))
            <button type="button" class="btn" data-target=".madduser" data-toggle="modal" style="margin: 0 1rem 1rem 0;">Add User</button>
            @endif

                  <form action="">
                    <div class="d-flex">
                        <div class="form-group mr-3" >
                        <input type="search" name="q" value="{{ (isset($_GET['q']))?$_GET['q']:'' }}" class="form-control search-input">
                        <img src="{{ url('/public/images/search-icon.svg') }}" class="search-icon" alt="">
                        <i class="fas fa-times-circle crose-icon"></i>
                        </div>
                        <button type="submit" class="btn btn-black">Search</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="my-table">
          <table class="table vertical-middle">
            <thead>
              <tr>
                <th>
                    @php
                    $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                    if(Request::segment(2) && Request::segment(2) == "id") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/users/id/'). '/' .$filterby }}" > ID <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i>  </span> </a>
                </th>
                <th>
                    @php
                    $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                    if(Request::segment(2) && Request::segment(2) == "name") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/users/name/'). '/' .$filterby }}"> Name <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i>  </span> </a>
                </th>
                <th>
                    @php
                    $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                    if(Request::segment(2) && Request::segment(2) == "email") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/users/email/'). '/' .$filterby }}"> Email <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i>  </span> </a>
                </th>
                <th>
                    @php
                    $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                    if(Request::segment(2) && Request::segment(2) == "position") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/users/position/'). '/' .$filterby }}"> Position <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i>  </span> </a>
                </th>
                <th>
                    @php
                    $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                    if(Request::segment(2) && Request::segment(2) == "role") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/users/role/'). '/' .$filterby }}"> Role <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i>  </span> </a>
                </th>
                <th>
                    @php
                    $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                    if(Request::segment(2) && Request::segment(2) == "status") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/users/status/'). '/' .$filterby }}"> Status<span class="display-ib pl-5px"> <i class="fas {{ $filterIcon }}"></i>  </span> </a>
                </th>
                <th>
                    @php
                    $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                    if(Request::segment(2) && Request::segment(2) == "created_at") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/users/created_at/'). '/' .$filterby }}"> Date Created<span class="display-ib pl-5px"> <i class="fas {{ $filterIcon }}"></i>  </span> </a>
                </th>
                @if (\App\helper\PermissionHelper::permissionCheck('edit_role_user') || \App\helper\PermissionHelper::permissionCheck('delete_role_user'))
                <th></th>
                @endif
              </tr>
            </thead>
            <tbody>
                @if (count($users) > 0)
                @foreach($users as $user)
                <tr id="row_{{ $user->id }}">
                  <td> <a href="{{ url('/user') }}/{{ $user->id }}" class="linked"> {{ $user->id }} </a> </td>
                  <td>
                    <a href="#">
                        @if ($user->profile_image != '')
                        <img src="{{ url('/public/uploads/users/') . '/' . $user->id . '/' . $user->profile_image }}" onerror="this.onerror=null;this.src='{{ url('/public/images/name-img1.png') }}';" class="mr-3 border-radius50" alt="" width="40" height="40">
                        @else
                        <span class="user-default-icon {{ strtolower(substr($user->name,0, 1)) }}">{{ substr($user->name,0, 1) }}</span>
                        @endif
                      {{ $user->name }} {{ $user->surname }}
                    </a>
                  </td>
                  <td> {{ $user->email }} </td>
                  <td>{{ $user->position }} </td>
                  <td>{{ $user->role }}</td>
                  <td id="status_{{ $user->id }}">{{ $user->status }}</td>
                  <td>{{ Carbon\Carbon::parse($user->created_at)->format('d F Y') }}</td>
                  @if (\App\helper\PermissionHelper::permissionCheck('edit_role_user') || \App\helper\PermissionHelper::permissionCheck('delete_role_user'))
                  <td>
                    <div class="dropdown">
                      <span class="" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-ellipsis-h"></i> </span>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          @if (\App\helper\PermissionHelper::permissionCheck('edit_role_user'))
                          <a class="dropdown-item" href="{{ url('/user') . '/' . $user->id . '/edit' }}">Edit</a>
                          @endif
                          @if (\App\helper\PermissionHelper::permissionCheck('delete_role_user'))
                          <a class="dropdown-item delete pointer" data-id="{{ $user->id }}" >Delete</a>
                          @endif
                          @if (\App\helper\PermissionHelper::permissionCheck('edit_role_user'))
                          <a id="deactivate_{{ $user->id }}" class="dropdown-item deactivate {{ ($user->status == 'inactive')?'no-display':'' }}" data-id="{{ $user->id }}"  href="JavaScript:Void(0);">Deactivate</a>
                          <a id="activate_{{ $user->id }}" class="dropdown-item activate {{ ($user->status == 'inactive')?'':'no-display' }}" data-id="{{ $user->id }}"  href="JavaScript:Void(0);">Activate</a>
                          @endif
                      </div>
                    </div>
                  </td>
                  @endif
                </tr>
                @endforeach

                @else
                <tr><td colspan="8" style="text-align: center;">No record found.</td></tr>
                @endif
            </tbody>
          </table>
          {{ $users->links() }}
        </div>
      </div>
    </div>
  </div>
</section>

<div class="modal fade madduser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-xl width1150" role="document">
    <div class="modal-content">
      <div class="modal-body modal-mb-body p-0">
        <div class="popup-tenant border-radius8">
          <div class="container-fluid">
            <form class="" action="{{ url('/users/create') }}" enctype="multipart/form-data" method="POST">
              @csrf
              <div class="row">
                <div class="col-12">
                  <div class="white-box">
                    <div class="d-flex wizard">
                      <div class="p-3 left-tabs-option">
                        <h6 class="h6 colordef fontweight-700 mb-30">Add User</h6>
                        <ul class="nav nav-pills flex-column " id="myTab" role="tablist">
                          <li role="presentation" class="active">
                            <a href="#step1" id="stepone" data-toggle="tab" style="pointer-events: none" aria-controls="step1" role="tab" aria-expanded="true" class="vertical-tab active"><span class="dot"></span> 1. Personal Details </a>
                          </li>
                          <li role="presentation" class="">
                            <a href="#step2" data-toggle="tab" style="pointer-events: none" aria-controls="step2" role="tab" aria-expanded="false" class="vertical-tab"><span class="dot"></span> 2. Role</a>
                          </li>
                        </ul>
                        <div class="tab-alert">
                          <img src="{{ url('/public') }}/images/info-icon.svg" class="d-inlin-block" alt=""> <span class="fontsize-12">All the fields are required unless marked as <i>(optional)</i>
                          </span>
                        </div>
                      </div>
                      <div class="tab-content right-tab-option" id="main_form">
                        <a href="JavaScript:Void(0);" class="color888 fontsize-12 a_hover_888 cancel-btn" data-dismiss="modal" aria-label="Close" #closeCompanyModal>Cancel <img src="{{ url('/public/images/crose-icon1.svg') }}" class="crose-icon" alt=""></a>
                        <div class="tab-pane fade show active" role="tabpanel" id="step1">
                          <span class="fontsize-14">Step 1 of 2</span>
                          <h5 class="fontsize-20 colorblue fontweight-500 mb-30">Personal Details</h5>
                          <div class="form-group">
                            <label id="first_name_label" class="label">First Name</label>
                            <input type="text" name="first_name" id="first_name" class="form-control width260" placeholder="">
                          </div>
                          <div class="form-group">
                            <label id="last_name_label" class="label">Last Name</label>
                            <input type="text" name="last_name" id="last_name" class="form-control width260" placeholder="">
                          </div>
                          <div class="form-group">
                            <label id="email_label" class="label">Email</label>
                            <input type="text" name="email" id="email" class="form-control width260" placeholder="">
                            <span style="color: red; font-size: 12px" id="email_err"></span>
                          </div>
                          <div class="form-group">
                             <label id="position_label" class="label">Position</label>
                             <input type="text" name="position" id="position" class="form-control width260" placeholder="">
                          </div>
                          <div class="form-group">
                            <label id="profile_label" class="label d-block">Photo</label>
                            <label class="all_type_upload_file">
                              <img id="imagerr" src="{{ url('/public/images/add-user-img.png') }}" class="border-radius8" width="120" height="120">
                              <input name="profile" id="profile" type="file" style="display: none">
                            </label>
                          </div>
                          <div class="form-group mb-30">
                            <label id="password_label" class="label">Password</label>
                            <input type="password" name="password" id="password" class="form-control width260" placeholder="">
                            {{-- <div class="d-flex mt-2">
                              <span class="fontsize-10 colordef">Password Strength</span>
                              <img src="{{ url('/public/images/strength.png') }}" alt="" class="ml-5">
                            </div> --}}
                          </div>
                          <div class="form-group mb-30">
                            <label id="confirm_password_label" class="label">Confirm Password</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control width260" placeholder="">
                          </div>
                          <button type="button" id="nextStep" class="btn next-step">Next Step <img src="{{ url('/public/images/white-arrow.svg') }}" alt=""></button>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="step2">
                          <span class="fontsize-14">Step 2 of 2</span>
                          <h5 class="fontsize-20 colorblue fontweight-500 mb-30">Role</h5>
                          <div class="row mb-5 pb-4">
                            @foreach ($permissions as $permission)
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                              <div class="checkbox display-ib mb-2">
																<label class="fontsize-12 colordef">
																	<input type="checkbox" name="permission[]" value="{{ $permission->id }}">
																	<span class="cr"><i class="cr-icon fa fa-check"></i></span>
																	{{ $permission->permission_name }}
																</label>
                              </div>
                            </div>
                            @endforeach
                          </div>
                          <button type="button" class="back-btn"><img src="{{ url('/public/images/back-arrow.svg') }}"></button>
                          <button type="submit" id="finish" class="btn next-step">Finish and Add User</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/slick.js"></script>
	<script src="js/mani_custom.js"></script>
	<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
	<script src="js/wow.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script> new WOW().init(); </script>
	<script type="text/javascript">
	  $(window).on ('load', function (){ $('#loader').delay(100).fadeOut('slow'); $('#loader-wrapper').delay(500).fadeOut('slow'); });
      $(document).ready(function(){ $('#saveandclose').click(function(){ $('#saveandclosevalue').val('close'); });
      // setTimeout(() => { $('#close_alert').trigger('click'); }, 5000);
        });
	  $(document).ready(function () {
	    $('.nav-pills > li a[title]').tooltip();
	    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) { var target = $(e.target); if (target.parent().hasClass('disabled')) { return false; } });
	    $(".next-step").click(function (e) { var active = $('.wizard .nav-pills li.active'); nextTab(active); });
	    $(".back-btn").click(function (e) { var active = $('.wizard .nav-pills li.active'); prevTab(active); });
        $('#nextStep').click(function() {
	      // first_name
	      if ($('#first_name').val() == '') {
	        $('#first_name').css('border-color', 'red');
	        $('#first_name_label').css('color', 'red');
	      } else {
	        $('#first_name').css('border-color', '#ECECEC');
	        $('#first_name_label').css('color', '#444444');
	      }
	      // last_name
	      if ($('#last_name').val() == '') {
	        $('#last_name').css('border-color', 'red');
	        $('#last_name_label').css('color', 'red');
	      } else {
	        $('#last_name').css('border-color', '#ECECEC');
	        $('#last_name_label').css('color', '#444444');
	      }
	      // email
	      if ($('#email').val() == '') {
	        $('#email').css('border-color', 'red');
	        $('#email_label').css('color', 'red');
	      } else {
	        $('#email').css('border-color', '#ECECEC');
	        $('#email_label').css('color', '#444444');
	      }
	      // position
	      if ($('#position').val() == '') {
	        $('#position').css('border-color', 'red');
	        $('#position_label').css('color', 'red');
	      } else {
	        $('#position').css('border-color', '#ECECEC');
	        $('#position_label').css('color', '#444444');
	      }
	      // profile
	      if ($('#profile').val() == '') {
	        $('#imagerr').css('border', '1px solid red');
	        $('#profile_label').css('color', 'red');
	      } else {
	        $('#imagerr').css('border', 'none');
	        $('#profile_label').css('color', '#444444');
	      }
	      // password
	      if ($('#password').val() == '') {
	        $('#password').css('border-color', 'red');
	        $('#password_label').css('color', 'red');
	      } else {
	        $('#password').css('border-color', '#ECECEC');
	        $('#password_label').css('color', '#444444');
	      }
	      // confirm_password
	      if ($('#confirm_password').val() == '') {
	        $('#confirm_password').css('border-color', 'red');
	        $('#confirm_password_label').css('color', 'red');
	      } else {
	        if ($('#password').val() != $('#confirm_password').val()) {
	          $('#confirm_password').css('border-color', 'red');
	          $('#confirm_password_label').css('color', 'red');
	        } else {
	          $('#confirm_password').css('border-color', '#ECECEC');
	          $('#confirm_password_label').css('color', '#444444');
	        }
	      }
	      if (
	        $('#first_name').val() == '' ||
	        $('#last_name').val() == '' ||
	        $('#email').val() == '' ||
	        $('#position').val() == '' ||
	        $('#password').val() == '' ||
	        $('#confirm_password').val() == '' ||
	        $('#profile').val() == '' ||
	        $('#password').val() != $('#confirm_password').val()
	      ) { setTimeout(() => { $('#stepone').trigger('click'); }, 200); }
	    });
	    $('#finish').click(function() {
	      var isChecked = $("input[type=checkbox]").is(":checked");
	      if (
	        $('#first_name').val() == '' ||
	        $('#last_name').val() == '' ||
	        $('#email').val() == '' ||
	        $('#position').val() == '' ||
	        $('#password').val() == '' ||
	        $('#confirm_password').val() == '' ||
	        $('#profile').val() == '' ||
	        $('#password').val() != $('#confirm_password').val()
	      ) {
              // first_name
	      if ($('#first_name').val() == '') {
	        $('#first_name').css('border-color', 'red');
	        $('#first_name_label').css('color', 'red');
	      } else {
	        $('#first_name').css('border-color', '#ECECEC');
	        $('#first_name_label').css('color', '#444444');
	      }
	      // last_name
	      if ($('#last_name').val() == '') {
	        $('#last_name').css('border-color', 'red');
	        $('#last_name_label').css('color', 'red');
	      } else {
	        $('#last_name').css('border-color', '#ECECEC');
	        $('#last_name_label').css('color', '#444444');
	      }
	      // email
	      if ($('#email').val() == '') {
	        $('#email').css('border-color', 'red');
	        $('#email_label').css('color', 'red');
	      } else {
	        $('#email').css('border-color', '#ECECEC');
	        $('#email_label').css('color', '#444444');
	      }
	      // position
	      if ($('#position').val() == '') {
	        $('#position').css('border-color', 'red');
	        $('#position_label').css('color', 'red');
	      } else {
	        $('#position').css('border-color', '#ECECEC');
	        $('#position_label').css('color', '#444444');
	      }
	      // profile
	      if ($('#profile').val() == '') {
	        $('#imagerr').css('border', '1px solid red');
	        $('#profile_label').css('color', 'red');
	      } else {
	        $('#imagerr').css('border', 'none');
	        $('#profile_label').css('color', '#444444');
	      }
	      // password
	      if ($('#password').val() == '') {
	        $('#password').css('border-color', 'red');
	        $('#password_label').css('color', 'red');
	      } else {
	        $('#password').css('border-color', '#ECECEC');
	        $('#password_label').css('color', '#444444');
	      }
	      // confirm_password
	      if ($('#confirm_password').val() == '') {
	        $('#confirm_password').css('border-color', 'red');
	        $('#confirm_password_label').css('color', 'red');
	      } else {
	        if ($('#password').val() != $('#confirm_password').val()) {
	          $('#confirm_password').css('border-color', 'red');
	          $('#confirm_password_label').css('color', 'red');
	        } else {
	          $('#confirm_password').css('border-color', '#ECECEC');
	          $('#confirm_password_label').css('color', '#444444');
	        }
	      }
            $('#stepone').trigger('click');
            return false;
          } else {
            if(!isChecked) {
                return false;
            } else {

            }
          }
        });

	    function readURL(input) {
	      if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function(e) { $('#imagerr').attr('src', e.target.result); }
	        reader.readAsDataURL(input.files[0]);
	      }
	    }
	    $("#profile").change(function() { readURL(this); });
	  });
	  function nextTab(elem) { $(elem).next().find('a[data-toggle="tab"]').click(); }
	  function prevTab(elem) { $(elem).prev().find('a[data-toggle="tab"]').click(); }
	  $('.nav-pills').on('click', 'li', function() { $('.nav-pills li.active').removeClass('active'); $(this).addClass('active'); });
	  $(document).ready(function() {
	    $('.delete').click(function() {
	      var delete_id = $(this).data('id');
	      var url = "{{ url('users/delete') }}";
	      swal({
	        title: "WARNING!",
	        text: "You are about to delete this user",
	        icon: "warning",
	        buttons: true,
	        dangerMode: true,
	      }).then((willDelete) => {
	          if (willDelete) {
	            $.ajax({
	              url: url,
	              type: 'post',
	              dataType: 'text',
	              headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
	              data: { delete_id: delete_id },
	              cache: false,
	              success: function(res){
	                var response = JSON.parse(res);
	                var msg = response.msg;
	                var htmlMsgbox = `<div class="alert alert-success">
	                  <a href="#" class="close" id="close_alert" data-dismiss="alert" aria-label="close">&times;</a>
	                  <p class="bold mb-0"> Message </p>
	                  ${msg}
	                </div>`;
	                $('#messageBox').html(htmlMsgbox);
	                $('#row_' + delete_id).remove();
	                // setTimeout(() => { $('#close_alert').trigger('click'); }, 5000);
	              }
	            });
	          }
	        });
	      });
	      $('.deactivate').click(function() {
	        var id = $(this).data('id');
	        var url = "{{ url('users/deactivate') }}";
	        swal({
	          title: "WARNING!",
	          text: "You are about to deactivate this user",
	          icon: "warning",
	          buttons: true,
	          dangerMode: true,
	        }).then((willDeactivate) => {
	          if (willDeactivate) {
	            $.ajax({
	              url: url,
	              type: 'post',
	              dataType: 'text',
	              headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
	              data: { id: id },
	              cache: false,
	              success: function(res){
	                var response = JSON.parse(res);
	                var msg = response.msg;
	                if (response.status == 1) {
	                  $('#status_' + id).text('inactive');
	                  $('#deactivate_' + id).addClass('no-display');
	                  $('#activate_' + id).removeClass('no-display');
	                  var htmlMsgbox = `<div class="alert alert-success">
	                    <a href="#" class="close" id="close_alert" data-dismiss="alert" aria-label="close">&times;</a>
	                    <p class="bold mb-0"> Message </p>
	                    ${msg}
	                  </div>`;
	                  $('#messageBox').html(htmlMsgbox);
	                  // setTimeout(() => { $('#close_alert').trigger('click'); }, 5000);
	                } else {
	                  var htmlMsgbox = `<div class="alert alert-deleted">
	                    <a href="#" class="close" id="close_alert" data-dismiss="alert" aria-label="close">&times;</a>
	                    <p class="bold mb-0"> Message </p>
	                    ${msg}
	                  </div>`;
	                  $('#messageBox').html(htmlMsgbox);
	                  // setTimeout(() => { $('#close_alert').trigger('click'); }, 5000);
	                }
	              }
	            });
	          }
	        });
	      });
	      $('.activate').click(function() {
	        var id = $(this).data('id');
	        var url = "{{ url('users/activate') }}";
	        swal({
	            title: "WARNING!",
	            text: "You are about to activate this user",
	            icon: "warning",
	            buttons: true,
	            dangerMode: true,
	        }).then((willactivate) => {
	          if (willactivate) {
	            $.ajax({
	              url: url,
	              type: 'post',
	              dataType: 'text',
	              headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
	              data: { id: id },
	              cache: false,
	              success: function(res){
	                var response = JSON.parse(res);
	                var msg = response.msg;
	                if (response.status == 1) {
	                  $('#status_' + id).text('active');
	                  $('#deactivate_' + id).removeClass('no-display');
	                  $('#activate_' + id).addClass('no-display');
	                  var htmlMsgbox = `<div class="alert alert-success">
	                    <a href="#" class="close" id="close_alert" data-dismiss="alert" aria-label="close">&times;</a>
	                    <p class="bold mb-0"> Message </p>
	                    ${msg}
	                  </div>`;
	                  $('#messageBox').html(htmlMsgbox);
	                  // setTimeout(() => { $('#close_alert').trigger('click'); }, 5000);
	                } else {
	                  var htmlMsgbox = `<div class="alert alert-deleted">
	                    <a href="#" class="close" id="close_alert" data-dismiss="alert" aria-label="close">&times;</a>
	                    <p class="bold mb-0"> Message </p>
	                    ${msg}
	                  </div>`;
	                  $('#messageBox').html(htmlMsgbox);
	                  // setTimeout(() => { $('#close_alert').trigger('click'); }, 5000);
	                }
	              }
	            });
	          }
	        });
          });

        // email_label
        $('#email').change(function() {
            var url = "{{ url('users/check_user') }}";
            $.ajax({
                url: url,
	            type: 'post',
	            dataType: 'text',
	            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
	            data: { email: $('#email').val() },
                cache: false,
                success: function(res){
                    var response = JSON.parse(res);
                    if (response.status == '0') {
                        $('#email_err').text(response.msg);
                    } else {
                        $('#email_err').text('');
                    }
                }
            });
        });

	    });
	</script>
@endsection
