@extends('layouts.app')
@section('content')

<section class="clear table-section1">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="relative d-flex align-items-center mb-30">
            <span class="fontsize-12 colordef">Content <i class="fas fa-angle-right ml-1 mr-1"></i></span><span class="fontsize-12 colorblue">Updates and Notices </span>
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
            <h6 class="h6 fontweight-700">Updates and Notices </h6>
            <form action="" method="GET">
            <div class="d-flex search-btn-block">
                @if (\App\helper\PermissionHelper::permissionCheck('add_update_notice'))
                <button type="button" class="btn" data-target=".maddupdatesnotices" data-toggle="modal" style="margin: 0 1rem 1rem 0;">Add Updates and Notices</button>
                @endif

              <div class="d-flex">
                <div class="form-group mr-3">
                  <input type="search" name="q" value="{{ (isset($_GET['q']))?$_GET['q']:'' }}" class="form-control search-input">
                  <img src="images/search-icon.svg" class="search-icon" alt="">
                  <i class="fas fa-times-circle crose-icon"></i>
                </div>
                <button type="submit" class="btn btn-black">Search</button>
              </div>
            </div>
        </form>
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
                    <a href="{{ url('/update-notice/id/'). '/' .$filterby }}"> ID <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i>  </span> </a>
                  </th>
                  <th>
                    @php
                    $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                    if(Request::segment(2) && Request::segment(2) == "title") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/update-notice/title/'). '/' .$filterby }}"> Title <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i>  </span> </a>
                    </th>
                  <th>
                    @php
                    $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                    if(Request::segment(2) && Request::segment(2) == "description") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/update-notice/description/'). '/' .$filterby }}"> Description <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i>  </span> </a>
                    </th>
                  <th>
                    @php
                    $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                    if(Request::segment(2) && Request::segment(2) == "type") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/update-notice/type/'). '/' .$filterby }}"> Category <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i>  </span> </a>
                    </th>
                  <th>
                    @php
                    $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                    if(Request::segment(2) && Request::segment(2) == "publish_date") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/update-notice/publish_date/'). '/' .$filterby }}"> Date Created <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i>  </span> </a>
                    </th>
                    @if (
                        \App\helper\PermissionHelper::permissionCheck('edit_update_notice') ||
                        \App\helper\PermissionHelper::permissionCheck('delete_update_notice')
                    )
                    <th></th>
                    @endif

                </tr>
              </thead>
              <tbody>
                @if (count($updateNotices) > 0)
                @foreach ($updateNotices as $updateNotice)
                <tr id="row_{{ $updateNotice->id }}">
                  <td> <a href="{{ url('/update-notice') . '/' . $updateNotice->id }}"> {{ $updateNotice->id }} </a> </td>
                  <td>{{ $updateNotice->title }}</td>
                  <td>{{ substr($updateNotice->description, 0, 50) }}...</td>
                  <td>{{ $updateNotice->type }}</td>
                  <td>{{ Carbon\Carbon::parse($updateNotice->publish_date)->format('d F Y') }}</td>
                  @if (
                      \App\helper\PermissionHelper::permissionCheck('edit_update_notice') ||
                      \App\helper\PermissionHelper::permissionCheck('delete_update_notice')
                  )
                  <td>
                    <div class="dropdown">
                      <span class="" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-ellipsis-h"></i> </span>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item edit pointer" data-id="{{ $updateNotice->id }}">Edit</a>
                        <a class="dropdown-item delete pointer" data-id="{{ $updateNotice->id }}">Delete</a>
                      </div>
                    </div>
                  </td>
                  @endif
                </tr>
                @endforeach

                @else
                <tr><td colspan="6" style="text-align: center;">No record found.</td></tr>
                @endif

              </tbody>
            </table>
            {{ $updateNotices->links() }}
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="modal fade maddupdatesnotices" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
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
                              <h6 class="h6 colordef fontweight-700 mb-30">Add Updates and Notices</h6>
                              <ul class="nav nav-pills flex-column " id="myTab" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true" class="vertical-tab active"><span class="dot"></span> 1.  Updates and Notices Details
                                </a>
                                </li>
                              </ul>
                              <div class="tab-alert">
                                <img src="{{ url('/public/images/info-icon.svg') }}" class="d-inlin-block" alt=""> <span class="fontsize-12">All the fields are required unless marked as <i>(optional)</i>
                                </span>
                              </div>
                            </div>
                              <div class="tab-content right-tab-option" id="main_form">
                                  <a href="JavaScript:Void(0);" class="color888 fontsize-12 a_hover_888 cancel-btn" data-dismiss="modal" aria-label="Close" #closeCompanyModal>Cancel <img src="{{ url('public/images/crose-icon1.svg') }}" class="crose-icon" alt=""></a>
                                <div class="tab-pane fade show active" role="tabpanel" id="step1">
                                    <span class="fontsize-14">Step 1 of 1</span>
                                    <h5 class="fontsize-20 colorblue fontweight-500 mb-30">Updates and Notices Details</h5>
                                    <form class="" action="{{ url('/update-notice/store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label id="title_label" class="label">Title</label>
                                            <input id="title" name="title" type="text" class="form-control width260" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label id="description_label" class="label">Description</label>
                                            <textarea id="description" name="description" type="text" class="form-control width320" placeholder=""></textarea>
                                        </div>
                                        <div class="form-group">
                                            <div class="btn-group multi_sigle_select inp_select open">
                                              <label id="category_label" class="label mb-1 d-block">Category</label>
                                              <input id="category" name="category" type="text" class="form-control width260" placeholder="">
                                            </div>
                                        </div>
                                        {{--  <div class="form-group mb-30">
                                          <label id="booking_date_label" class="label">Date Created</label>
                                          <span class="after-datepicker-icon"></span>
                                          <input id="booking_date" name="booking_date" type="text" class="form-control date-picker width160" placeholder="">
                                      </div>  --}}
                                        <button id="create_update" type="submit" class="btn next-step">Add Updates and Notices</button>
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

  <button type="button" id="medithelp" style="display: none" data-target=".meditupdatesnotices" data-toggle="modal"></button>
  <div class="modal fade meditupdatesnotices" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
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
                              <h6 class="h6 colordef fontweight-700 mb-30">Edit Updates and Notices</h6>
                              <ul class="nav nav-pills flex-column " id="myTab" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true" class="vertical-tab active"><span class="dot"></span> 1.  Updates and Notices Details
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
                                    <h5 class="fontsize-20 colorblue fontweight-500 mb-30">Updates and Notices Details</h5>
                                    <form class="" action="{{ url('/update-notice/update') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id" id="edit_id">
                                        <div class="form-group">
                                            <label id="edit_title_label" class="label">Title</label>
                                            <input id="edit_title" name="edit_title" type="text" class="form-control width260" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label id="edit_description_label" class="label">Description</label>
                                            <textarea id="edit_description" name="edit_description" type="text" class="form-control width320" placeholder=""></textarea>
                                        </div>
                                        <div class="form-group">
                                            <div class="btn-group multi_sigle_select inp_select open">
                                              <label id="edit_category_label" class="label mb-1 d-block">Category</label>
                                              <input id="edit_category" name="edit_category" type="text" class="form-control width260" placeholder="">
                                            </div>
                                        </div>
                                        {{--  <div class="form-group mb-30">
                                          <label class="label">Date Created</label>
                                          <span class="after-datepicker-icon"></span>
                                          <input type="text" class="form-control date-picker width160" placeholder="" id="datepicker1">
                                      </div>  --}}
                                        <button id="editUpdate" type="submit" class="btn next-step">Save</button>
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
      <script>
        new WOW().init();
      </script>
      <script type="text/javascript">
        $(window).on ('load', function (){ $('#loader').delay(100).fadeOut('slow'); $('#loader-wrapper').delay(500).fadeOut('slow'); });
        $('#booking_date').datepicker({ uiLibrary: 'bootstrap4' });
        $(document).ready(function () {
            $('.nav-pills > li a[title]').tooltip();
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) { var target = $(e.target); if (target.parent().hasClass('disabled')) { return false; } });
            $(".next-step").click(function (e) { var active = $('.wizard .nav-pills li.active'); nextTab(active); });
            $(".back-btn").click(function (e) { var active = $('.wizard .nav-pills li.active'); prevTab(active); });
            $('#create_update').click(function() {
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
                if ($('#category').val() == '') {
                    $('#category').css('border-color', 'red');
                    $('#category_label').css('color', 'red');
                } else {
                    $('#category').css('border-color', '#ECECEC');
                    $('#category_label').css('color', '#444444');
                }
                if(
                    $('#title').val() == '' ||
                    $('#description').val() == '' ||
                    $('#category').val() == ''
                ) { return false; }
            });

            $('#editUpdate').click(function() {
                if ($('#edit_title').val() == '') {
                    $('#edit_title').css('border-color', 'red');
                    $('#edit_title_label').css('color', 'red');
                } else {
                    $('#edit_title').css('border-color', '#ECECEC');
                    $('#edit_title_label').css('color', '#444444');
                }
                if ($('#edit_description').val() == '') {
                    $('#edit_description').css('border-color', 'red');
                    $('#edit_description_label').css('color', 'red');
                } else {
                    $('#edit_description').css('border-color', '#ECECEC');
                    $('#edit_description_label').css('color', '#444444');
                }
                if ($('#edit_category').val() == '') {
                    $('#edit_category').css('border-color', 'red');
                    $('#edit_category_label').css('color', 'red');
                } else {
                    $('#edit_category').css('border-color', '#ECECEC');
                    $('#edit_category_label').css('color', '#444444');
                }
                if(
                    $('#edit_title').val() == '' ||
                    $('#edit_description').val() == '' ||
                    $('#edit_category').val() == ''
                ) { return false; }
            });

            $('.edit').click(function(){
                var id = $(this).data('id');
                var url = "{{ url('update-notice/edit') }}";
                $.ajax({
                  url: url,
                  type: 'post',
                  dataType: 'text',
                  headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                  data: { id: id },
                  cache: false,
                  success: function(res){
                      var response = JSON.parse(res);
                    $('#edit_title').val(response.data.title);
                    $('#edit_description').val(response.data.description);
                    $('#edit_category').val(response.data.type);
                    $('#edit_id').val(response.data.id);

                      $('#medithelp').trigger('click');
                    }
                });
              });

            $('.delete').click(function(){
                var delete_id = $(this).data('id');
                var url = "{{ url('update-notice/delete') }}";
                swal({
                    title: "WARNING!",
                    text: "You are about to delete this update or notice",
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
        });
        function nextTab(elem) { $(elem).next().find('a[data-toggle="tab"]').click(); }
        function prevTab(elem) { $(elem).prev().find('a[data-toggle="tab"]').click(); }
        $('.nav-pills').on('click', 'li', function() { $('.nav-pills li.active').removeClass('active'); $(this).addClass('active'); });
      </script>

@endsection
