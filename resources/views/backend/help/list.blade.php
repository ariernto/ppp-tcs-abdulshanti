@extends('layouts.app')
@section('content')


<section class="clear table-section1">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="relative d-flex align-items-center mb-30">
            <span class="fontsize-12 colordef">Content <i class="fas fa-angle-right ml-1 mr-1"></i></span><span class="fontsize-12 colorblue">Help </span>
          </div>
          <span id="messageBox">
            @if(session()->has('success'))
            <div class="alert alert-success">
                <a href="#" class="close" id="close_alert" data-dismiss="alert" aria-label="close">&times;</a>
                <p class="bold mb-0"> Message </p>
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
            <h6 class="h6 fontweight-700">Help </h6>
            <div class="d-flex search-btn-block">
                @if (\App\helper\PermissionHelper::permissionCheck('add_guide_article'))
                <button type="button" class="btn" data-target=".maddhelp" data-toggle="modal" style="margin: 0 1rem 1rem 0;">Add Help</button>
                @endif

            <form action="">
              <div class="d-flex">
                <div class="form-group mr-3">
                  <input type="search" name="q" value="{{ (isset($_GET['q']))?$_GET['q']:'' }}" class="form-control search-input">
                  <img src="images/search-icon.svg" class="search-icon" alt="">
                  <i class="fas fa-times-circle crose-icon"></i>
                </div>
                <button type="submit" class="btn btn-black">Search</button>
              </div>
            </form>
            </div>
          </div>
          <div class="my-table">
            <table class="table">
              <thead>
                <tr>
                  <th>
                    @php
                    $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                    if(Request::segment(2) && Request::segment(2) == "id") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/help/id/'). '/' .$filterby }}"> ID <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i>  </span> </a>
                    </th>
                  <th>
                    @php
                    $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                    if(Request::segment(2) && Request::segment(2) == "quetion") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/help/quetion/'). '/' .$filterby }}"> Title <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i>  </span> </a>
                    </th>
                  <th>
                    @php
                    $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                    if(Request::segment(2) && Request::segment(2) == "answer") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/help/answer/'). '/' .$filterby }}"> Description <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i>  </span> </a>
                    </th>
                  <th>
                    @php
                    $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                    if(Request::segment(2) && Request::segment(2) == "created_at") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/help/created_at/'). '/' .$filterby }}"> Date Created <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i>  </span> </a>
                    </th>
                    @if (
                        \App\helper\PermissionHelper::permissionCheck('edit_guide_article') ||
                        \App\helper\PermissionHelper::permissionCheck('delete_guide_article')
                    )
                    <th></th>
                    @endif
                </tr>
              </thead>
              <tbody>
                  @if (count($helps) > 0)
                  @foreach ($helps as $help)
                  <tr id="row_{{ $help->id }}">
                    <td> <a href="{{ url('help') . '/' . $help->id }}"> {{ $help->id }} </a> </td>
                    <td>
                        <img src="{{ url('/public/uploads/help/') . '/' . $help->image }}" onerror="this.onerror=null;this.src='{{ url('/public/images/titlle-img1.png') }}';" class="mr-3 border-radius50" alt="" width="40" height="40">
                        {{ $help->quetion }}
                    </td>
                    <td> {{ substr($help->answer, 0, 50) }}... </td>
                    <td>{{ Carbon\Carbon::parse($help->created_at)->format('d F Y') }}</td>

                    @if (
                        \App\helper\PermissionHelper::permissionCheck('edit_guide_article') ||
                        \App\helper\PermissionHelper::permissionCheck('delete_guide_article')
                    )
                    <td>
                      <div class="dropdown">
                        <span class="" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-ellipsis-h"></i>
                        </span>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @if (\App\helper\PermissionHelper::permissionCheck('edit_guide_article'))
                            <a class="dropdown-item edit pointer" data-id="{{ $help->id }}">Edit</a>
                            @endif
                            @if (\App\helper\PermissionHelper::permissionCheck('delete_guide_article'))
                          <a class="dropdown-item delete pointer" data-id="{{ $help->id }}">Delete</a>
                          @endif
                        </div>
                      </div>
                    </td>
                    @endif
                  </tr>
                  @endforeach
                  @else
                  <tr><td colspan="5" style="text-align: center;">No record found.</td></tr>
                  @endif

              </tbody>
            </table>
            {{ $helps->links() }}
          </div>
        </div>
      </div>
    </div>
  </section>





  <div class="modal fade maddhelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl width1150" role="document">
      <div class="modal-content">
        <div class="modal-body modal-mb-body">

          <div class="new-tenant popup-tenant border-radius8">
            <div class="container-fluid">
                <form action="{{ url('help/store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                <div class="row">
                  <div class="col-12">
                      <div class="white-box">
                        <div class="d-flex wizard">
                            <div class="p-3 left-tabs-option">
                              <h6 class="h6 colordef fontweight-700 mb-30">Add Help</h6>
                              <ul class="nav nav-pills flex-column " id="myTab" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true" class="vertical-tab active"><span class="dot"></span> Help Details
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
                                    {{--  <span class="fontsize-14">Step 1 of 1</span>  --}}
                                    <h5 class="fontsize-20 colorblue fontweight-500 mb-30">Help Details</h5>
                                    <form class="">
                                        <div class="form-group">
                                            <label id="title_label" class="label">Title</label>
                                            <input name="title" id="title" type="text" class="form-control width260" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label id="description_label" class="label">Description</label>
                                            <textarea name="description" id="description" type="text" class="form-control width320" placeholder=""></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label id="image_label" class="label d-block">Image</label>
                                            <label class="all_type_upload_file">
                                              <img src="{{ url('public/images/add-user-img.png') }}" id="image_profile" class="border-radius8" width="120" height="120">
                                              <input style="display: none" type="file" name="image" id="image">
                                            </label>
                                        </div>
                                        {{--  <div class="form-group mb-30">
                                          <label class="label">Date Created</label>
                                          <span class="after-datepicker-icon"></span>
                                          <input type="text" class="form-control date-picker width160" placeholder="" id="datepicker1">
                                      </div>  --}}
                                        <button type="submit" id="add_help" class="btn next-step">Add Help</button>
                                    </form>
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


  <button type="button" id="medithelp" style="display: none" data-target=".medithelp" data-toggle="modal"></button>
  <div class="modal fade medithelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl width1150" role="document">
      <div class="modal-content">
        <div class="modal-body modal-mb-body">

          <div class="new-tenant popup-tenant border-radius8">
            <div class="container-fluid">
                <div class="row">
                  <div class="col-12">
                      <div class="white-box">
                        <div class="d-flex wizard">
                            <div class="p-3 left-tabs-option">
                              <h6 class="h6 colordef fontweight-700 mb-30">Edit Help</h6>
                              <ul class="nav nav-pills flex-column " id="myTab" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true" class="vertical-tab active"><span class="dot"></span> Help Details
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
                                    {{--  <span class="fontsize-14">Step 1 of 1</span>  --}}
                                    <h5 class="fontsize-20 colorblue fontweight-500 mb-30">Help Details</h5>
                                    <form class="" action="{{ url('help/update') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label id="edit_title_label" class="label">Title</label>
                                            <input id="edit_title" name="edit_title" type="text" class="form-control width260" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label id="edit_desctiption_label" class="label">Description</label>
                                            <textarea name="edit_desctiption" id="edit_desctiption" type="text" class="form-control width320" placeholder=""></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label id="edit_image_label" class="label d-block">Image</label>
                                            <label class="all_type_upload_file">
                                              <img id="edit_image_err" src="{{ url('public/images/user-default-img.png') }}" class="border-radius8" width="120" height="120">
                                              <input id="edit_image" name="edit_image" type="file" style="display: none">
                                            </label>
                                        </div>
                                        {{--  <div class="form-group mb-30">
                                          <label class="label">Date Created</label>
                                          <span class="after-datepicker-icon"></span>
                                          <input type="text" class="form-control date-picker width160" placeholder="" id="datepicker1">
                                      </div>  --}}
                                      <input type="hidden" name="id" id="edit_id">
                                        <button type="submit" id='edit_help' class="btn next-step">Edit Help</button>
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
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
      <script> new WOW().init(); </script>
      <script>
        $(window).on ('load', function (){ $('#loader').delay(100).fadeOut('slow'); $('#loader-wrapper').delay(500).fadeOut('slow'); });
        $('#datepicker1').datepicker({ uiLibrary: 'bootstrap4' });
        $(document).ready(function () {
            $('#saveandclose').click(function(){ $('#saveandclosevalue').val('close'); });
            $('.nav-pills > li a[title]').tooltip();
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) { var target = $(e.target); if (target.parent().hasClass('disabled')) { return false; } });
            $(".next-step").click(function (e) { var active = $('.wizard .nav-pills li.active'); nextTab(active); });
            $(".back-btn").click(function (e) { var active = $('.wizard .nav-pills li.active'); prevTab(active); });
            $('#add_help').click(function() {
                if ($('#title').val() == '') {
                    $('#title').css('border-color', 'red');
                    $('#title_label').css('color', 'red');
                } else {
                    $('#title').css('border-color', '#ECECEC');
                    $('#title_label').css('color', '#444444');
                }
                if ($('#description').val() == '') {
                    $('#description').css('border-color', 'red');
                    $('#description_label').css('color', 'red');
                } else {
                    $('#description').css('border-color', '#ECECEC');
                    $('#description_label').css('color', '#444444');
                }
                if ($('#image').val() == '') {
                    $('#image_profile').css('border', '1px solid red');
                    $('#image_label').css('color', 'red');
                  } else {
                    $('#image_profile').css('border', 'none');
                    $('#image_label').css('color', '#444444');
                  }
                if (
                    $('#title').val() == '' ||
                    $('#description').val() == '' ||
                    $('#image').val() == ''
                ) { return false; }
            });
            $('#edit_help').click(function() {
                if ($('#edit_title').val() == '') {
                    $('#edit_title').css('border-color', 'red');
                    $('#edit_title_label').css('color', 'red');
                } else {
                    $('#edit_title').css('border-color', '#ECECEC');
                    $('#edit_title_label').css('color', '#444444');
                }
                if ($('#edit_desctiption').val() == '') {
                    $('#edit_desctiption').css('border-color', 'red');
                    $('#edit_desctiption_label').css('color', 'red');
                } else {
                    $('#edit_desctiption').css('border-color', '#ECECEC');
                    $('#edit_desctiption_label').css('color', '#444444');
                }
                if ( $('#edit_title').val() == '' || $('#edit_desctiption').val() == '' ) { return false; }
            });
            $('.edit').click(function(){
              var id = $(this).data('id');
              var url = "{{ url('help/edit') }}";
              $.ajax({
                url: url,
                type: 'post',
                dataType: 'text',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: { id: id },
                cache: false,
                success: function(res){
                    var response = JSON.parse(res);
                    $('#edit_id').val(response.data.id);
                    $('#edit_title').val(response.data.quetion);
                    $('#edit_desctiption').val(response.data.answer);
                    $('#edit_image_err').attr('src', "{{ url('public/uploads/help') }}/" + response.data.image);
                    $('#medithelp').trigger('click');
                  }
              });
            });
            $('.delete').click(function(){
                var delete_id = $(this).data('id');
                var url = "{{ url('help/delete') }}";
                swal({
                    title: "WARNING!",
                    text: "You are about to delete this Help",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                  }).then((willDelete) => {
                      if(willDelete) {
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
                              }
                        });
                      }
                  });
            });
            function readURL(input, preview) {
                if (input.files && input.files[0]) {
                  var reader = new FileReader();
                  reader.onload = function(e) { $(preview).attr('src', e.target.result); }
                  reader.readAsDataURL(input.files[0]);
                }
              }
              $("#image").change(function() { readURL(this, '#image_profile'); });
              $("#edit_image").change(function() { readURL(this, '#edit_image_err'); });
        });
        function nextTab(elem) { $(elem).next().find('a[data-toggle="tab"]').click(); }
        function prevTab(elem) { $(elem).prev().find('a[data-toggle="tab"]').click(); }
        $('.nav-pills').on('click', 'li', function() { $('.nav-pills li.active').removeClass('active'); $(this).addClass('active'); });
      </script>

@endsection
