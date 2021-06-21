@extends('layouts.app')
@section('content')

<section class="clear table-section1">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="relative d-flex align-items-center mb-30">
            <span class="fontsize-12 colordef">Users <i class="fas fa-angle-right ml-1 mr-1"></i></span><span class="fontsize-12 colorblue">Workers </span>
          </div>
          <span id="messageBox">
            @if(session()->has('success'))
            <div class="alert alert-success">
                <a href="#" class="close" id="close_alert" data-dismiss="alert" aria-label="close">&times;</a>
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
          <form action="" method="GET">
          <div class="relative d-flex align-items-center justify-content-between">
            <h6 class="h6 fontweight-700">Workers </h6>
            <div class="d-flex search-btn-block">

                @if (\App\helper\PermissionHelper::permissionCheck('add_role_user'))
                <button type="button" class="btn" data-target=".maddworker" data-toggle="modal" style="margin: 0 1rem 1rem 0;">Add Worker</button>
                @endif

              <div class="d-flex">
                <div class="form-group mr-3">
                  <input type="search" name="q" value="{{ (isset($_GET['q']))?$_GET['q']:'' }}" class="form-control search-input">
                  <img src="{{ url('public/images/search-icon.svg') }}" class="search-icon" alt="">
                  <i class="fas fa-times-circle crose-icon"></i>
                </div>
                <button type="submit" class="btn btn-black">Search</button>
              </div>
            </div>
        </div>
    </form>

          <div class="my-table">
                <!-- <div class="alert alert-warning">
                    <a href="#" class="close" id="close_alert" data-dismiss="alert" aria-label="close">&times;</a>
                    <p class="bold mb-0"> Message </p>
                      No record found.
                </div> -->
            <table class="table vertical-middle">
              <thead>
                <tr>
                    <th>
                        @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "id") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                        @endphp
                        <a href="{{ url('/workers/id/'). '/' .$filterby }}"> ID <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i>  </span> </a>
                    </th>
                    <th>
                        @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "name") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                        @endphp
                        <a href="{{ url('/workers/name/'). '/' .$filterby }}"> Name <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i>  </span> </a>
                    </th>
                    <th>
                        @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "designation") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                        @endphp
                        <a href="{{ url('/workers/designation/'). '/' .$filterby }}"> Designation <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i>  </span> </a>
                    </th>
                    <th>Recent Job</th>
                    <th class="text-center"> Jobs Completed </th>
                    <th>
                        @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "created_at") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                        @endphp
                        <a href="{{ url('/workers/created_at/'). '/' .$filterby }}"> Date Created <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i>  </span> </a>
                    </th>
                    @if (\App\helper\PermissionHelper::permissionCheck('edit_role_user') || \App\helper\PermissionHelper::permissionCheck('delete_role_user'))
                    <th></th>
                    @endif

                </tr>
              </thead>
              <tbody>
                  @if (count($workers) > 0)

                  @foreach ($workers as $worker)
                  <tr id="workerRow_{{ $worker->id }}" class="">
                      <td> <a href="{{ url('worker') . '/' . $worker->id }}" class="linked"> {{ $worker->id }} </a> </td>
                      <td>
                          @if ($worker->profile != '')
                          <img src="{{ url('/public/uploads/users/') . '/' . $worker->id . '/' . $worker->profile }}" onerror="this.onerror=null;this.src='{{ url('/public/images/name-img1.png') }}';" class="mr-3 border-radius50" alt="" width="40" height="40"> {{ $worker->name }}
                          @else
                          <span class="user-default-icon {{ strtolower(substr($worker->name,0, 1)) }}">{{ substr($worker->name,0, 1) }}</span>
                          @endif
                      </td>
                      <td>{{ $worker->designation }} </td>
                      <td >
                          @if ($worker->lastJob) #{{ $worker->lastJob->id }}: {{ $worker->lastJob->title }} @else No job assigned yet @endif
                      </td>
                      <td class="text-center"> {{ count($worker->completedjobs) }} / {{ count($worker->activejobs) }} </td>
                      <td>{{ Carbon\Carbon::parse($worker->created_at)->format('d F Y') }}</td>
                      <td>
                          <div class="dropdown">
                          <span class="" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="fas fa-ellipsis-h"></i>
                          </span>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                              @if (\App\helper\PermissionHelper::permissionCheck('edit_role_user'))
                              <a class="dropdown-item getWorker" data-target=".meditworker" data-worker_id = "{{ $worker->id }}" data-toggle="modal" href="JavaScript:Void(0);">Edit</a>
                              @endif
                              @if (\App\helper\PermissionHelper::permissionCheck('delete_role_user'))
                              <a class="dropdown-item delete" data-id="{{ $worker->id }}" href="JavaScript:Void(0);">Delete</a>
                              @endif
                              @if (\App\helper\PermissionHelper::permissionCheck('edit_role_user'))
                              <a id="deactivate_{{ $worker->id }}" class="dropdown-item deactivate {{ ($worker->status == 'inactive')?'no-display':'' }}" data-id="{{ $worker->id }}"  href="JavaScript:Void(0);">Deactivate</a>
                              <a id="activate_{{ $worker->id }}" class="dropdown-item activate {{ ($worker->status == 'inactive')?'':'no-display' }}" data-id="{{ $worker->id }}"  href="JavaScript:Void(0);">Activate</a>
                              @endif
                          </div>
                          </div>
                      </td>
                  </tr>
                  @endforeach
                  @else
                  <tr><td colspan="7" style="text-align: center;">No record found.</td></tr>

                  @endif
              </tbody>
            </table>
            {{ $workers->links() }}
          </div>
        </div>
      </div>
    </div>
  </section>



  <div class="modal fade maddworker" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl width1150" role="document">
      <div class="modal-content">
        <div class="modal-body modal-mb-body p-0">

          <div class="popup-tenant border-radius8">
            <div class="container-fluid">
                <div class="row">
                  <div class="col-12">
                      <div class="white-box">
                        <div class="d-flex wizard">
                            <div class="p-3 left-tabs-option">
                              {{--  <a href="JavaScript:Void(0);" class="d-block mb-30"><img src="{{ url('public/images/logo.png') }}" alt="" class="vertical-tab-logo"></a>  --}}
                              <h6 class="h6 colordef fontweight-700 mb-30">Add Worker</h6>
                              <ul class="nav nav-pills flex-column " id="myTab" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#step1" style="pointer-events: none" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true" class="vertical-tab active"><span class="dot"></span> 1.  Worker Details
                                </a>
                                </li>
                              </ul>
                              <div class="tab-alert">
                                <img src="{{ url('public/images/info-icon.svg') }}" class="d-inlin-block" alt=""> <span class="fontsize-12">All the fields are required unless marked as <i>(optional)</i>
                                </span>
                              </div>
                            </div>
                              <div class="tab-content right-tab-option" id="main_form">
                                  <a href="JavaScript:Void(0);" class="color888 fontsize-12 a_hover_888 cancel-btn" data-dismiss="modal" aria-label="Close" #closeCompanyModal>Cancel <img src="{{ url('public/images/crose-icon1.svg') }}" class="crose-icon" alt=""></a>
                                <div class="tab-pane fade show active" role="tabpanel" id="step1">
                                    <span class="fontsize-14">Step 1 of 1</span>
                                    <h5 class="fontsize-20 colorblue fontweight-500 mb-30">Worker Details</h5>
                                    <form class="" method="POST" enctype="multipart/form-data" action="{{ url('worker/create') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label id="name_label" class="label">Name</label>
                                            <input type="text" id="name" name="name" class="form-control width260" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label id="designation_label" class="label">Designation</label>
                                            <input type="text" id="designation" name="designation" class="form-control width260" placeholder="">
                                        </div>
                                        <div class="form-group mb-5">
                                            <label id="profile_label" class="label d-block">Image</label>
                                            <label class="all_type_upload_file">
                                              <img src="{{ url('public/images/add-user-img.png') }}" id="profile_image" class="border-radius8" width="120" height="120">
                                              <input type="file" style="display: none" id="profile" name="profile">
                                            </label>
                                        </div>
                                        <button type="submit" id="create_worker" class="btn next-step">Add Worker</button>
                                    </form>
                                </div>
                              </div>
                        </div>
                      </div>
                  </div>
                </div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>



  <div class="modal fade meditworker" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl width1150" role="document">
      <div class="modal-content">
        <div class="modal-body modal-mb-body p-0">

          <div class="popup-tenant border-radius8">
            <div class="container-fluid">
                <div class="row">
                  <div class="col-12">
                      <div class="white-box">
                        <div class="d-flex wizard">
                            <div class="p-3 left-tabs-option">
                              <h6 class="h6 colordef fontweight-700 mb-30">Edit Worker</h6>
                              <ul class="nav nav-pills flex-column " id="myTab" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true" class="vertical-tab active"><span class="dot"></span> 1.  Worker Details
                                </a>
                                </li>
                              </ul>
                              <div class="tab-alert">
                                <img src="{{ url('public/images/info-icon.svg') }}" class="d-inlin-block" alt=""> <span class="fontsize-12">All the fields are required unless marked as <i>(optional)</i>
                                </span>
                              </div>
                            </div>
                              <div class="tab-content right-tab-option" id="main_form">
                                  <a href="JavaScript:Void(0);" class="color888 fontsize-12 a_hover_888 cancel-btn" data-dismiss="modal" aria-label="Close" #closeCompanyModal>Cancel <img src="{{ url('public/images/crose-icon1.svg') }}" class="crose-icon" alt=""></a>
                                <div class="tab-pane fade show active" role="tabpanel" id="step1">
                                    <span class="fontsize-14">Step 1 of 1</span>
                                    <h5 class="fontsize-20 colorblue fontweight-500 mb-30">Worker Details</h5>
                                    <form class="" method="POST" enctype="multipart/form-data" action="{{ url('worker/update') }}">
                                        @csrf
                                        <input type="hidden" name="id" id="edit_id">
                                        <div class="form-group">
                                            <label id="edit_name_label" class="label">Name</label>
                                            <input type="text" id="edit_name" name="name" class="form-control width260" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label id="edit_designation_label" class="label">Designation</label>
                                            <input type="text" id="edit_designation" name="designation" class="form-control width260" placeholder="">
                                        </div>
                                        <div class="form-group mb-5">
                                            <label class="label d-block">Image</label>
                                            <label class="all_type_upload_file">
                                              <img src="{{ url('public/images/user-default-img.png') }}" id="edit_profile_image" class="border-radius8" width="120" height="120">
                                              <input type="file"  style="display: none" id="edit_profile" name="profile">
                                            </label>
                                        </div>
                                        <button type="submit" id="edit_worker" class="btn next-step">Save</button>
                                    </form>
                                </div>
                              </div>
                        </div>
                      </div>
                  </div>
                </div>
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
      <script> new WOW().init(); </script>
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
      <script type="text/javascript">
        $(window).on ('load', function (){
          $('#loader').delay(100).fadeOut('slow');
          $('#loader-wrapper').delay(500).fadeOut('slow');
        });
        $('#datepicker1').datepicker({ uiLibrary: 'bootstrap4' });
        $(document).ready(function(){ $('#saveandclose').click(function(){ $('#saveandclosevalue').val('close'); });
        // setTimeout(() => { $('#close_alert').trigger('click'); }, 5000);
        });
        $(document).ready(function () {
            $('.nav-pills > li a[title]').tooltip();
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) { var target = $(e.target); if (target.parent().hasClass('disabled')) { return false; } });
            $(".next-step").click(function (e) { var active = $('.wizard .nav-pills li.active'); nextTab(active); });
            $(".back-btn").click(function (e) { var active = $('.wizard .nav-pills li.active'); prevTab(active); });
            function readURL(input, preview) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) { $(preview).attr('src', e.target.result); }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#profile").change(function() { readURL(this, '#profile_image'); });
            $("#edit_profile").change(function() { readURL(this, '#edit_profile_image'); });
            $('#create_worker').click(function() {
                if ($('#name').val() == '') {
                    $('#name').css('border-color', 'red');
                    $('#name_label').css('color', 'red');
                } else {
                    $('#name').css('border-color', '#ECECEC');
                    $('#name_label').css('color', '#444444');
                }
                if ($('#designation').val() == '') {
                    $('#designation').css('border-color', 'red');
                    $('#designation_label').css('color', 'red');
                } else {
                    $('#designation').css('border-color', '#ECECEC');
                    $('#designation_label').css('color', '#444444');
                }
                if ($('#profile').val() == '') {
                    $('#profile_image').css('border', '1px solid red');
                    $('#profile_label').css('color', 'red');
                } else {
                    $('#profile_image').css('border', 'none');
                    $('#profile_label').css('color', '#444444');
                }
                if ($('#name').val() == '' || $('#designation').val() == '' || $('#profile').val() == '') { return false; }
            });
            $('#edit_worker').click(function () {
                if ($('#edit_name').val() == '') {
                    $('#edit_name').css('border-color', 'red');
                    $('#edit_name_label').css('color', 'red');
                } else {
                    $('#edit_name').css('border-color', '#ECECEC');
                    $('#edit_name_label').css('color', '#444444');
                }
                if ($('#edit_designation').val() == '') {
                    $('#edit_designation').css('border-color', 'red');
                    $('#edit_designation_label').css('color', 'red');
                } else {
                    $('#edit_designation').css('border-color', '#ECECEC');
                    $('#edit_designation_label').css('color', '#444444');
                }
                if ($('#edit_name').val() == '' || $('#edit_designation').val() == '') { return false; }
            });

            $('.delete').click(function() {
                var delete_id = $(this).data('id');
                var url = "{{ url('workers/delete') }}";
                swal({
                  title: "WARNING!",
                  text: "You are about to delete this worker",
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
                          $('#workerRow_' + delete_id).remove();
                          // setTimeout(() => { $('#close_alert').trigger('click'); }, 5000);
                        }
                      });
                    }
                  });
                });

            $('.deactivate').click(function() {
                var id = $(this).data('id');
                var url = "{{ url('workers/deactivate') }}";
                swal({
                  title: "WARNING!",
                  text: "You are about to deactivate this workers",
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
                var url = "{{ url('workers/activate') }}";
                swal({
                    title: "WARNING!",
                    text: "You are about to activate this workers",
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
            $('.getWorker').click(function(){
                var id = $(this).data('worker_id');
                var url = "{{ url('worker/get') }}/" + id ;
                $.ajax({
                    url: url,
                    type: 'get',
                    dataType: 'text',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: {},
                    cache: false,
                    success: function(res){
                        var response = JSON.parse(res);
                        var inputs = response.data;
                        $('#edit_id').val(inputs.id);
                        $('#edit_name').val(inputs.name);
                        $('#edit_designation').val(inputs.designation);
                        var profileImage = "{{ url('/public/uploads/users/')}}/" + inputs.id + '/' + inputs.profile;
                        $('#edit_profile_image').attr('src', profileImage);
                    }
                });
            });
        });
        function nextTab(elem) { $(elem).next().find('a[data-toggle="tab"]').click(); }
        function prevTab(elem) { $(elem).prev().find('a[data-toggle="tab"]').click(); }
        $('.nav-pills').on('click', 'li', function() { $('.nav-pills li.active').removeClass('active'); $(this).addClass('active'); });
      </script>

@endsection
