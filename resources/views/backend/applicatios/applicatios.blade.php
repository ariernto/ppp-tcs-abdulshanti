@extends('layouts.app')
@section('content')


<section class="clear table-section1">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="relative d-flex align-items-center mb-30">
          <span class="fontsize-12 colordef">Properties <i class="fas fa-angle-right ml-1 mr-1"></i></span><span class="fontsize-12 colorblue">Property Applications
        </span>
        </div>

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
                <a href="#" class="close" id="close_alert" data-dismiss="alert" aria-label="close" style="padding:0px;height:32px;top:0px;">&times;</a>
                <p class="bold mb-0"> Message </p>
				{{ session()->get('error') }}
			</div>
		@endif
        <div class="relative d-flex align-items-center justify-content-between">
          <h6 class="h6 fontweight-700">Property Applications <img src="images/Arrow-down.svg" class="arrow-down" alt=""></h6>

           <form action="" method="POST">
           	<div class="d-flex">

         	@csrf
            <div class="form-group mr-3">
              <input type="search" class="form-control search-input"  name="q" id="q" value="{{ ($prop['q'] != '')? $prop['q']: '' }}" placeholder="Search applications">
              <img src="{{ asset('public/images/search-icon.svg') }}" class="search-icon" alt="">
              <img src="{{ asset('public/images/search-cancel-icon.svg') }}" class="crose-icon" id="reset" alt="">
              <!-- <i class="fas fa-times-circle crose-icon"  id="reset" ></i> -->
            </div>
            <button type="submit"  id="search" class="btn btn-black">Search</button>

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
                    <a href="{{ url('/applications/id/'). '/' .$filterby }}"> ID <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "headline") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/applications/headline/'). '/' .$filterby }}"> Property <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "agent") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/applications/agent/'). '/' .$filterby }}"> Assigned Agent <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "lodged") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/applications/lodged/'). '/' .$filterby }}"> Lodged On <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "lodged_by") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/applications/lodged_by/'). '/' .$filterby }}"> Lodged By <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "status") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/applications/status/'). '/' .$filterby }}"> Status <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
              </tr>
            </thead>
            <tbody>
          @php if(!empty($applicatios[0])){  @endphp
         @foreach($applicatios as $application)
              <tr>
                <td><a class="linked" href="{{ url('/application') . '/' . $application->id }}">{{ $application->property_id }}</a></td>

                <td><a href="{{ url('/property') . '/' . $application->property_id }}"><span class="overflow_elips width260">{{ ($application->headline)? $application->headline: '' }}</span></a></td>
                <td>{{ ($application->first_name)?$application->first_name . ' ' . $application->last_name  : ''  }} </td>
                <td>{{ date_format(date_create($application->date_applied), 'd F Y') }} </td>
                <td><span class="overflow_elips width125">{{ ($application->name)?$application->name . ' ' . $application->surname : ''  }}</span>
                  <span class="td-img">
                  	@php  $commethod = explode(',',$application->communication_method); @endphp

                    <img src="{{ asset('public/images/envlob-icon.svg') }}" class="<?php if(!in_array('email', $commethod)) echo 'disable'; ?>" alt="">

                    <img src="{{ asset('public/images/call-icon.svg') }}" class="<?php if(!in_array('call', $commethod)) echo 'disable'; ?>" alt="">

                    <img src="{{ asset('public/images/phone-icon.svg') }}"   class="<?php if(!in_array('app', $commethod)) echo 'disable'; ?>" alt="">
                  </span>
                </td>
                <td><span class="chips chips-@php if($application->approve_status=='cancelled') echo 'cancel'; elseif($application->approve_status=='declined') echo 'close'; elseif($application->approve_status=='approved') echo 'booked'; else echo 'green';  @endphp" style="min-width: 103px; ">{{ ucwords(str_replace("_", " ", $application->approve_status)) }}</span></td>
              </tr>
            @endforeach
            @php
           } else{ @endphp
           <tr><td colspan="7" style="text-align: center;">No record found.</td></tr>
       @php } @endphp
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

  <script>
  $(document).ready(function(){
        $('#saveandclose').click(function(){ $('#saveandclosevalue').val('close'); });
    });
    $(document).ready(function(){
      $('.filter').change(function(){ $('#search').trigger('click'); });
      $('#reset').click(function(){ var url = "{{ url('/applications') }}"; window.location.replace(url); });
    });
  </script>
@endsection
