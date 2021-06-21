@extends('layouts.app')
@section('content')
<section class="clear detail-section1">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="relative d-flex align-items-center mb-30">
            <span class="fontsize-12 colordef">Users <i class="fas fa-angle-right ml-1 mr-1"></i>
            <span class="fontsize-12 colordef">
              <a href="{{ url('/users') }}"> User and Role Management <i class="fas fa-angle-right ml-1 mr-1"></i> </a>
            </span><span class="fontsize-12 colorblue">User Edit </span>
          </div>
          <div class="relative ">
            <h6 class="h6 fontweight-700 mb-30"> <a href="{{ url('/users') }}"> <i class="fas fa-arrow-left fontsize-14 mr-1"></i> </a> User Edit </h6>
          </div>
          <div class="white-box d-block mb-30">
            <div class="main-contant w-100">
							<form class="w-100" action="" enctype="multipart/form-data" method="POST">
								@csrf
								<div class="row">
									<div class="col-12">
										<div class="">
											<div class="d-flex wizard">
												<div class="p-3 left-tabs-option">
													<h6 class="h6 colordef fontweight-700 mb-30">Edit User</h6>
													<ul class="nav nav-pills flex-column " id="myTab" role="tablist">
														<li role="presentation" class="active">
															<a href="#step1" id="stepone" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true" class="vertical-tab active"><span class="dot"></span> 1. Personal Details </a>
														</li>
														<li role="presentation" class="">
															<a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" aria-expanded="false" class="vertical-tab"><span class="dot"></span> 2. Role</a>
														</li>
													</ul>
													<div class="tab-alert">
														<img src="{{ url('/public') }}/images/info-icon.svg" class="d-inlin-block" alt=""> <span class="fontsize-12">All the fields are required unless marked as <i>(optional)</i>
														</span>
													</div>
												</div>
												<div class="tab-content right-tab-option" id="main_form">
													<a href="{{ url('/users') }}" class="color888 fontsize-12 a_hover_888 cancel-btn">Cancel <img src="{{ url('/public/images/crose-icon1.svg') }}" class="crose-icon" alt=""></a>
													<div class="tab-pane fade show active" role="tabpanel" id="step1">
														<span class="fontsize-14">Step 1 of 2</span>
														<h5 class="fontsize-20 colorblue fontweight-500 mb-30">Personal Details</h5>
														<div class="form-group">
															<label id="first_name_label" class="label">First Name</label>
															<input type="text" name="first_name" id="first_name" value="{{ $users->name }}" class="form-control width260" placeholder="">
														</div>
														<div class="form-group">
															<label id="last_name_label" class="label">Last Name</label>
															<input type="text" name="last_name" id="last_name" value="{{ $users->surname }}" class="form-control width260" placeholder="">
														</div>
														<div class="form-group">
															<label id="email_label" class="label">Email</label>
															<input type="text" name="email" id="email" value="{{ $users->email }}" class="form-control width260" placeholder="">
														</div>
														<div class="form-group">
															 <label id="position_label" class="label">Position</label>
															 <input type="text" name="position" id="position" value="{{ $users->position }}" class="form-control width260" placeholder="">
														</div>
														<div class="form-group">
															<label id="profile_label" class="label d-block">Photo</label>
															<label class="all_type_upload_file">
																<img id="imagerr" src="{{ url('/public/uploads/users/') . '/' . $users->id . '/' . $users->profile_image }}" onerror="this.onerror=null;this.src='{{ url('/public/images/add-user-img.png') }}';" class="border-radius8" width="120" height="120">
																<input name="profile" id="profile" type="file" style="display: none">
															</label>
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
																		<input type="checkbox" name="permission[]" {{ (in_array($permission->id, $hasPermission))?'checked':'' }} value="{{ $permission->id }}">
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
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script> new WOW().init(); </script>
      <script type="text/javascript">
        $(window).on ('load', function (){
          $('#loader').delay(100).fadeOut('slow');
          $('#loader-wrapper').delay(500).fadeOut('slow');
        });
        $('.nav-pills > li a[title]').tooltip();
	    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) { var target = $(e.target); if (target.parent().hasClass('disabled')) { return false; } });
	    $(".next-step").click(function (e) { var active = $('.wizard .nav-pills li.active'); nextTab(active); });
	    $(".back-btn").click(function (e) { var active = $('.wizard .nav-pills li.active'); prevTab(active); });
        $('#datepicker7').datepicker({ uiLibrary: 'bootstrap4' });
        $(document).ready(function(){
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
                if (
                  $('#first_name').val() == '' ||
                  $('#last_name').val() == '' ||
                  $('#email').val() == '' ||
                  $('#position').val() == ''
                ) { setTimeout(() => { $('#stepone').trigger('click'); }, 200); }
              });
              $('#finish').click(function() {
                var isChecked = $("input[type=checkbox]").is(":checked");
                if (
                  $('#first_name').val() == '' ||
                  $('#last_name').val() == '' ||
                  $('#email').val() == '' ||
                  $('#position').val() == ''
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
                  $('#stepone').trigger('click');
                  return false;
                } else {
                  if(!isChecked) {
                      return false;
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
      </script>
@endsection
