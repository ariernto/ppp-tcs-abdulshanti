@extends('layouts.app')
@section('content')
<section class="clear table-section1">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="relative d-flex align-items-center mb-30">
          <span class="fontsize-12 colordef">Clients <i class="fas fa-angle-right ml-1 mr-1"></i></span><span class="fontsize-12 colorblue">Prospects</span>
        </div>
        {{-- <div class="relative d-flex align-items-center justify-content-between">
          <h6 class="h6 fontweight-700">Tenants <img src="{{ asset('public/images/Arrow-down.svg') }}" class="arrow-down" alt=""></h6>
          <div class="d-flex search-btn-block">
            <div class="d-flex">
              <div class="form-group mr-3">
                <input type="search" class="form-control search-input" placeholder="Search tenants">
                <img src="{{ asset('public/images/search-icon.svg') }}" class="search-icon" alt="">
                <img src="{{ asset('public/images/search-cancel-icon.svg') }}" class="crose-icon" id="reset" alt="">
                 <!-- <i class="fas fa-times-circle crose-icon" id="reset"></i> -->
              </div>
              <button type="button" class="btn btn-black">Search</button>
            </div>
          </div>
        </div> --}}
        <div class="relative d-flex align-items-center justify-content-between">
            <h6 class="h6 fontweight-700">Prospects <img src="{{ asset('public/images/Arrow-down.svg') }}" class="arrow-down" alt=""></h6>
            <form action="" method="POST">
                @csrf
                <div class="d-flex search-btn-block">
                    <div class="d-flex">
                        <div class="form-group mr-3">
                            <input type="search" name="search" class="form-control search-input" placeholder="Search tenants">
                            <img src="{{ asset('public/images/search-icon.svg') }}" class="search-icon" alt="">
                            <i class="fas fa-times-circle crose-icon" id="reset"></i>
                        </div>
                        {{--  <button type="button" class="btn btn-black">Search</button>  --}}
                        <button type="submit" class="btn btn-black">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="my-table">
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
          <table class="table">
            <thead>
              <tr>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "id") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/prospects/id/'). '/' .$filterby }}"> ID <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i></span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "prospect") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/prospects/prospect/'). '/' .$filterby }}"> Name <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "email") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/prospects/email/'). '/' .$filterby }}"> Email <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th> @php
                    $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                    if(Request::segment(2) && Request::segment(2) == "listing") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                @endphp
                <a href="{{ url('/prospects/listing/'). '/' .$filterby }}"> Listing <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a> </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "property") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/prospects/property/'). '/' .$filterby }}"> Property <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>

                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "type") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/prospects/type/'). '/' .$filterby }}"> Type <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "leasedon") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/prospects/leasedon/'). '/' .$filterby }}"> Leased On <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                    $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                    if(Request::segment(2) && Request::segment(2) == "leaseddue") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                @endphp
                <a href="{{ url('/prospects/leaseddue/'). '/' .$filterby }}"> Leased Due <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
              </tr>
            </thead>
            <tbody>
             @php if(!empty($prospects[0])){ @endphp
            	@foreach($prospects as $prospect)
				<tr>
                    <td> <a class="linked" href="{{ url('/prospects') . '/' . $prospect->id }}"> {{ $prospect->id }} </a> </td>
                    <td> {{ $prospect->name }} {{ $prospect->surname }} </td>
                    <td> {{ $prospect->email }} </td>
                    <td> {{ $prospect->deal_type }} </td>
                    <td> {{ $prospect->headline }} </td>
                    <td> {{ $prospect->type }} </td>
                    <td> {{ Carbon\Carbon::parse($prospect->date_leased)->format('d F Y') }} </td>
                    <td> {{ Carbon\Carbon::parse($prospect->lease_due)->format('d F Y') }} </td>
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
<script type="text/javascript">
$(document).ready(function(){
        $('#saveandclose').click(function(){ $('#saveandclosevalue').val('close'); });
    });
    $(document).ready(function(){
        $('.filter').change(function(){ $('#search').trigger('click'); });
        $('#reset').click(function(){ var url = "{{ url('/properties') }}"; window.location.replace(url); });
      });



</script>>

@endsection
