@extends('layouts.app')
@section('content')

<section class="clear table-section1">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="relative d-flex align-items-center mb-30">
          <span class="fontsize-12 colordef">Properties <i class="fas fa-angle-right ml-1 mr-1"></i></span><span class="fontsize-12 colorblue">Property Inspections
          </span>
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
            <h6 class="h6 fontweight-700">Property Inspections <img src="images/Arrow-down.svg" class="arrow-down" alt=""></h6>
            <form action="" method="POST">
            @csrf
              <div class="d-flex">
                <div class="form-group mr-3">
                  <input type="search" class="form-control search-input" name="q" id="q" value="{{ ($prop['q'] != '')? $prop['q']: '' }}" placeholder="Search inspections" >
                  <img src="{{ asset('public/images/search-icon.svg') }}" class="search-icon" alt="">
                  <img src="{{ asset('public/images/search-cancel-icon.svg') }}" class="crose-icon" id="reset" alt="">
                  <!-- <i class="fas fa-times-circle crose-icon" id="reset"></i> -->
                </div>
                <button id="search" type="submit" class="btn btn-black">Search</button>
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
                    <a href="{{ url('/inspections/id/'). '/' .$filterby }}"> ID <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "headline") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/inspections/headline/'). '/' .$filterby }}"> Property <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "agent") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/inspections/agent/'). '/' .$filterby }}"> Assigned Agent <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                    $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                    if(Request::segment(2) && Request::segment(2) == "bookedfor") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/inspections/bookedfor/'). '/' .$filterby }}"> Booked For <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>

                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "lodged_by") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/inspections/lodged_by/'). '/' .$filterby }}"> Lodged By <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "lodged") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/inspections/lodged/'). '/' .$filterby }}"> Lodged On <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "status") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/inspections/status/'). '/' .$filterby }}"> Status <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                @if (\App\helper\PermissionHelper::permissionCheck('edit_inspection') || \App\helper\PermissionHelper::permissionCheck('delete_inspection'))
                <th></th>
                @endif
              </tr>
            </thead>
            <tbody>
              @php if(!empty($inspections[0])){ @endphp
              @foreach($inspections as $inspection)
              <tr id="row{{ $inspection->id }}">
                <td><a class="linked" href="{{ url('/inspection') . '/' .$inspection->id }}">{{ $inspection->property_id }}</a></td>
                <td><a class="" href="{{ url('/property') . '/' . $inspection->property_id }}"><span class="overflow_elips width260">{{ ($inspection->headline)?$inspection->headline:'' }}</span></a></td>
                <td>{{ ($inspection->first_name)?$inspection->first_name . ' ' . $inspection->last_name: '' }}</td>
                <td> @php $i =1; $dates = explode(',', $inspection->booked_date); @endphp
                @foreach ($dates as $item)
                  @if ($item != '')
                    @if ($i != 1) , @endif
                    @if ($i%3 == 0) <br> @endif
                    {{ date_format(date_create($item), 'd F Y') }}
                    @php $i++; @endphp
                  @endif
                @endforeach
              </td>
                <td><span class="overflow_elips width125">{{ ($inspection->name)?$inspection->name . ' ' . $inspection->surname : ''  }}</span>
                  <span class="td-img">
                    @php  $commethod = explode(',',$inspection->communication_method); @endphp
                    <img src="{{ asset('public/images/envlob-icon.svg') }}" class="<?php if(!in_array('email', $commethod)) echo 'disable'; ?>" alt="">
                    <img src="{{ asset('public/images/call-icon.svg') }}" class="<?php if(!in_array('call', $commethod)) echo 'disable'; ?>" alt="">
                    <img src="{{ asset('public/images/phone-icon.svg') }}"   class="<?php if(!in_array('app', $commethod)) echo 'disable'; ?>" alt="">
                  </span>
                </td>
                <td>{{ date_format(date_create($inspection->created_at), 'd F Y') }}</td>
                <td>
                    <span class="chips chips-@php if($inspection->booked_status=='cancelled') echo 'cancel'; elseif($inspection->booked_status=='closed') echo 'close'; else echo $inspection->booked_status;  @endphp">
                        {{ $inspection->booked_status }}
                    </span>
                </td>
                @if (\App\helper\PermissionHelper::permissionCheck('edit_inspection') || \App\helper\PermissionHelper::permissionCheck('delete_inspection'))
                <td>
                  <div class="dropdown dropleft">
                    <span class="" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @if (\App\helper\PermissionHelper::permissionCheck('edit_inspection'))
                        <a href="{{ url('/inspection') . '/' .$inspection->id }}" class="dropdown-item">Edit</a>
                        @endif
                        @if (\App\helper\PermissionHelper::permissionCheck('delete_inspection'))
                        <a data-id = "{{ $inspection->id }}" class="dropdown-item delete" href="JavaScript:Void(0);">Delete</a>
                        @endif

                    </div>
                  </div>
                </td>
                @endif
              </tr>

             @endforeach
            @php } else { @endphp
            <tr><td colspan="8" style="text-align: center;">No record found.</td></tr>

            @php }  @endphp

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script>
  $(document).ready(function(){
        $('#saveandclose').click(function(){ $('#saveandclosevalue').val('close'); });
    });
    $(document).ready(function(){
        $('.filter').change(function(){ $('#search').trigger('click'); });
        $('#reset').click(function(){ var url = "{{ url('/inspections') }}"; window.location.replace(url); });
        $('.delete').click(function() {
            var delete_id = $(this).data('id');
            var url = "{{ url('inspection/delete') }}";
            swal({
                title: "WARNING!",
                text: "You are about to delete this inspection",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
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
                            var htmlMsgbox = `<div class="alert alert-danger">
                                <a href="#" class="close" id="close_alert" data-dismiss="alert" aria-label="close">&times;</a>
                                <p class="bold mb-0"> Message </p>
                                ${msg}
                            </div>`;
                            $('#messageBox').html(htmlMsgbox);
                            $('#row' + delete_id).remove();
                            $('#saveandclose').click(function(){ $('#saveandclosevalue').val('close'); });
                        }
                    });
                }
            });
        });
      });
  </script>
@endsection
