@extends('layouts.app')
@section('content')
  <!-- <header class="page-header page-header-left-breadcrumb">
    <div class="right-wrapper">
      <ol class="breadcrumbs">
        <li>
        	<a href="{{ url('/home') }}"> <i class="fas fa-home"></i> </a>
        </li>
        <li><span>Maintenance</span></li>
      </ol>
    </div>
    <h2>Maintenance Listing</h2>
  </header>

  <section id="property-listing">
		<div class="row">
      <div class="col-12">
        <div class="d-flex justify-content-between mb-4">
          <div class="relative">
            <span class="color333 d-inline-block mr-2"><i class="far fa-check-circle"></i> Publish</span>
            <span class="color333 d-inline-block mr-2"><i class="far fa-times-circle"></i> Unpublish</span>
          </div>
          <div class="relative">
            <span class="color333 d-inline-block ml-2"><i class="far fa-question-circle"></i> Help</span>
            <span class="color333 d-inline-block ml-2"><i class="fas fa-info-circle"></i> Option</span>
          </div>
        </div>
			</div>
			<div class="col-12">
			<form action="" method="POST">
				@csrf
				<div class="row">
      	<div class="col-12 col-sm-12 col-md-6 col-lg-6">
        	<div class="d-flex">
            <input type="text" class="w-200 form-control" name="q" id="q" value="{{ ($prop['q'] != '')? $prop['q']: '' }}" placeholder="Search..." >
            <span class="">
              <button class="btn gray-btn" id="search" type="submit"><i class="fas fa-search"></i></button>
            </span>
            <span class="">
              <button class="btn gray-btn" id="reset" type="reset"><i class="fas fa-times"></i></button>
            </span>
          </div>
					<span class="fontsize-14 color-gray">Note: Sort the table by selecting the respective table headings</span>
				</div>
				<div class="col-12 col-sm-12 col-md-6 col-lg-6">
					<div class="d-flex justify-content-end">
						<select name="sortby" id="sortby" class="form-control mb-3 d-inline-block w-auto ml-2 filter">
							<option value="updated_at" {{ ($prop['sortby'] == '')? 'selected': '' }}> Sort table by </option>
							<option value="id" {{ ($prop['sortby'] == 'id')? 'selected': '' }}> ID </option>
							<option value="title" {{ ($prop['sortby'] == 'title')? 'selected': '' }}> Title </option>
							<option value="created_at" {{ ($prop['sortby'] == 'created_at')? 'selected': '' }}> Date Created </option>
							<option value="updated_at" {{ ($prop['sortby'] == 'updated_at')? 'selected': '' }}> Date Modified </option>
						</select>
						<select name="filterby" id="filterby" class="form-control mb-3 d-inline-block w-auto ml-2 filter">
							<option value="desc" {{ ($prop['filterby'] == '')?'selected':'' }}> Filter table by </option>
							<option value="asc" {{ ($prop['filterby'] == 'asc')?'selected':'' }}> Ascending </option>
							<option value="desc" {{ ($prop['filterby'] == 'desc')?'selected':'' }}> Descending </option>
						</select>
						<select name="pagination" id="pagination" class="form-control mb-3 d-inline-block w-auto ml-2 filter">
							<option value="5" {{ ($prop['pagination'] == '5')?'selected': '' }}>	5 </option>
							<option value="10" {{ ($prop['pagination'] == '10')?'selected': '' }}> 10 </option>
							<option value="15" {{ ($prop['pagination'] == '15')?'selected': '' }}> 15 </option>
							<option value="20" {{ ($prop['pagination'] == '20')?'selected': '' }}> 20 </option>
							<option value="25" {{ ($prop['pagination'] == '25')?'selected': '' }}> 25 </option>
							<option value="30" {{ ($prop['pagination'] == '30')?'selected': '' }}> 30 </option>
							<option value="50" {{ ($prop['pagination'] == '50')?'selected': '' }}> 50 </option>
							<option value="100" {{ ($prop['pagination'] == '100')?'selected': '' }}> 100 </option>
							<option value="200" {{ ($prop['pagination'] == '200')?'selected': '' }}> 200 </option>
							<option value="500" {{ ($prop['pagination'] == '500')?'selected': '' }}> 500 </option>
							<option value="1000" {{ ($prop['pagination'] == '1000')?'selected': '' }}> All </option>
						</select>
					</div>
				</div>
			</div>
			</form>
		</div>

			<div class="col-12 col-sm-12">
				<table class="table table-responsive-md mb-0" >
					<thead>
						<tr>
							<th>ID</th>
							<th>Title</th>
							<th>Issue </th>
							<th>Maintenance Type</th>
							<th>Property</th>
							<th>Assignee</th>
                            <th>Status</th>
                            <th>Date Lodged	</th>
                            <th>Rating</th>
						</tr>
					</thead>
					<tbody>
						@foreach($jobs as $job)
						<tr>
                            <td> <a href="{{ url('/maintanance') . '/' . $job->id }}">{{ $job->id }}</a></td>
                            <td>{{ $job->title }}</td>
                            @php $description = $job->description; @endphp
                            <td>{{ substr($description, 0, 25) }} @if (strlen($description) > 25)...@endif</td>
                            <td>{{ $job->mantinance_type }}</td>
                            <td>{{ $job->hasProperty->headline }}</td>
                            <td>{{ $job->assignedTo->first_name . ' ' . $job->assignedTo->last_name }}</td>
                            <td><span class="chips-leased">{{ $job->hasProperty->deal_type }}</span></td>
                            <td>{{ date_format(date_create($job->created_at), 'd F Y') }}</td>
                            <td>
                                <div class="star-reting">
                                    @php $rating = 0; if($job->hasRating) { $rating = $job->hasRating->rating; }
                                    @endphp
                                    @for($i = 1; $i <= 5; $i++)
                                    @if ($i <= $rating)
                                    <i class="fas fa-star color-yallow"></i>
                                    @else
                                    <i class="fas fa-star color-gray"></i>
                                    @endif
                                    @endfor
                                </div>
                            </td>
                        </tr>
						@endforeach
					</tbody>
        </table>
        <div class="dataTables_paginate paging_simple_numbers mt-4" id="datatable-tabletools_paginate">

          {{--  <ul class="pagination">
            <li class="paginate_button page-item previous disabled" id="datatable-tabletools_previous">
              <a href="#" aria-controls="datatable-tabletools" data-dt-idx="0" tabindex="0" class="page-link">Previous</a>
            </li>
            <li class="paginate_button page-item active">
              <a href="#" aria-controls="datatable-tabletools" data-dt-idx="1" tabindex="0" class="page-link">1</a>
            </li>
            <li class="paginate_button page-item ">
              <a href="#" aria-controls="datatable-tabletools" data-dt-idx="2" tabindex="0" class="page-link">2</a>
            </li>
            <li class="paginate_button page-item ">
              <a href="#" aria-controls="datatable-tabletools" data-dt-idx="3" tabindex="0" class="page-link">3</a>
            <li class="paginate_button page-item next" id="datatable-tabletools_next">
              <a href="#" aria-controls="datatable-tabletools" data-dt-idx="7" tabindex="0" class="page-link">Next</a>
            </li>
          </ul>  --}}
        </div>
			</div>
		</div>
  </section> -->

<section class="clear table-section1">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="relative d-flex align-items-center mb-30">
          <span class="fontsize-12 colordef">Properties <i class="fas fa-angle-right ml-1 mr-1"></i></span><span class="fontsize-12 colorblue">Property Maintenance Requests
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

        <div class="relative d-flex align-items-center justify-content-between">
          <h6 class="h6 fontweight-700">Property Maintenance Requests <img src="{{ asset('public/images/Arrow-down.svg') }}" class="arrow-down" alt=""></h6>
         <form action="" method="POST">
          @csrf
          <div class="d-flex">
            <div class="form-group mr-3">
              <input type="search" class="form-control search-input" name="q" id="q" value="{{ ($prop['q'] != '')? $prop['q']: '' }}" placeholder="Search requests">
              <img src="{{ asset('public/images/search-icon.svg') }}" class="search-icon" alt="">
              <img src="{{ asset('public/images/search-cancel-icon.svg') }}" class="crose-icon" id="reset" alt="">
            </div>
            <button type="submit" id='search' class="btn btn-black">Search</button>
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
                <a href="{{ url('/maintanances/id/'). '/' .$filterby }}"> ID <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i>  </span> </a>
                </th>
                <th>
                    @php
                    $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                    if(Request::segment(2) && Request::segment(2) == "loggedon") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/maintanances/loggedon/'). '/' .$filterby }}"> Lodged On <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i>  </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "issue") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/maintanances/issue/'). '/' .$filterby }}"> Issue <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i>  </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "mantinance_type") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/maintanances/mantinance_type/'). '/' .$filterby }}"> Type <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i>  </span> </a>

                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "property") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/maintanances/property/'). '/' .$filterby }}"> Property <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "assignee") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/maintanances/assignee/'). '/' .$filterby }}"> Assignee <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "status") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/maintanances/status/'). '/' .$filterby }}"> Status <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "rectifyingTime") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/maintanances/rectifyingTime/'). '/' .$filterby }}"> Rectifying Time <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
              </tr>
            </thead>
            <tbody>
                @if (!empty($jobs[0]))
           @foreach($jobs as $job)
              <tr>
                <td><a class="linked" href="{{ url('/maintanance') . '/' . $job->id }}">{{ $job->id }}</a></td>
                <td>{{ date_format(date_create($job->created_at), 'd F Y') }}</td>
                <td><span class="overflow_elips width260"><span class="colorgray"> <b>Subject:</b> </span> {{ $job->title }}
                </span></td>
                <td>{{ $job->mantinance_type }}</td>
                <td><a href="{{ url('/property') . '/' . $job->property_id }}"><span class="overflow_elips width260">{{ $job->hasProperty->headline }}</span></a></td>
                <td>{{ $job->assignedTo->first_name . ' ' . $job->assignedTo->last_name }}</td>
                <td class="blue-new"> <span class="chips chips-@php if($job->status=='cancelled') echo 'cancel'; elseif($job->status=='closed') echo 'close'; elseif($job->status=='in progress') echo 'booked'; elseif($job->status=='new') echo 'open'; else echo 'green';  @endphp"> {{ $job->status }} </span> </td>
                <td>{{ $job->hours }} hours</td>
              </tr>
            @endforeach
            @else
            <tr><td colspan="8" style="text-align: center;">No record found.</td></tr>
            @endif
             <!--  <tr>
                <td><a href="maintenance-requests-detail.html">40408820</a></td>
                <td>24 Mar 2020</td>
                <td><span class="overflow_elips width260"><span class="colorgray">Subject here:</span> Enquiry goes here on a single line to text..
                </span></td>
                <td>Plumbing</td>
                <td><span class="overflow_elips width260">Property Address goe
                    here on a single line to text..</span></td>
                <td>Olishia Farmer </td>
                <td><span class="chips chips-green">Open</span></td>
                <td>48 hours</td>
                <td>
                  <div class="dropdown dropleft">
                    <span class="" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="JavaScript:Void(0);">Action</a>
                      <a class="dropdown-item" href="JavaScript:Void(0);">Another action</a>
                      <a class="dropdown-item" href="JavaScript:Void(0);">Something else here</a>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td><a href="maintenance-requests-detail.html">40408820</a></td>
                <td>24 Mar 2020</td>
                <td><span class="overflow_elips width260"><span class="colorgray">Subject here:</span> Enquiry goes here on a single line to text..
                </span></td>
                <td>Plumbing</td>
                <td><span class="overflow_elips width260">Property Address goe
                    here on a single line to text..</span></td>
                <td>Olishia Farmer </td>
                <td><span class="chips chips-green">Open</span></td>
                <td>48 hours</td>
                <td>
                  <div class="dropdown dropleft">
                    <span class="" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="JavaScript:Void(0);">Action</a>
                      <a class="dropdown-item" href="JavaScript:Void(0);">Another action</a>
                      <a class="dropdown-item" href="JavaScript:Void(0);">Something else here</a>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td><a href="maintenance-requests-detail.html">40408820</a></td>
                <td>24 Mar 2020</td>
                <td><span class="overflow_elips width260"><span class="colorgray">Subject here:</span> Enquiry goes here on a single line to text..
                </span></td>
                <td>Plumbing</td>
                <td><span class="overflow_elips width260">Property Address goe
                    here on a single line to text..</span></td>
                <td>Olishia Farmer </td>
                <td><span class="chips chips-green">Open</span></td>
                <td>48 hours</td>
                <td>
                  <div class="dropdown dropleft">
                    <span class="" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="JavaScript:Void(0);">Action</a>
                      <a class="dropdown-item" href="JavaScript:Void(0);">Another action</a>
                      <a class="dropdown-item" href="JavaScript:Void(0);">Something else here</a>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
              <tr>
                <td><a href="maintenance-requests-detail.html">40408820</a></td>
                <td>24 Mar 2020</td>
                <td><span class="overflow_elips width260"><span class="colorgray">Subject here:</span> Enquiry goes here on a single line to text..
                </span></td>
                <td>Plumbing</td>
                <td><span class="overflow_elips width260">Property Address goe
                    here on a single line to text..</span></td>
                <td>Olishia Farmer </td>
                <td><span class="chips chips-green">Open</span></td>
                <td>48 hours</td>
                <td>
                  <div class="dropdown dropleft">
                    <span class="" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="JavaScript:Void(0);">Action</a>
                      <a class="dropdown-item" href="JavaScript:Void(0);">Another action</a>
                      <a class="dropdown-item" href="JavaScript:Void(0);">Something else here</a>
                    </div>
                  </div>
                </td>
                </tr>
                <tr>
                    <td><a href="maintenance-requests-detail.html">40408820</a></td>
                    <td>24 Mar 2020</td>
                    <td><span class="overflow_elips width260"><span class="colorgray">Subject here:</span> Enquiry goes here on a single line to text..
                    </span></td>
                    <td>Plumbing</td>
                    <td><span class="overflow_elips width260">Property Address goe
                        here on a single line to text..</span></td>
                    <td>Olishia Farmer </td>
                    <td><span class="chips chips-green">Open</span></td>
                    <td>48 hours</td>
                    <td>
                      <div class="dropdown dropleft">
                        <span class="" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-ellipsis-v"></i>
                        </span>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="JavaScript:Void(0);">Action</a>
                          <a class="dropdown-item" href="JavaScript:Void(0);">Another action</a>
                          <a class="dropdown-item" href="JavaScript:Void(0);">Something else here</a>
                        </div>
                      </div>
                    </td>
                  </tr> -->
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
        $('#reset').click(function(){ var url = "{{ url('/maintanances') }}"; window.location.replace(url); });
    });
  </script>
@endsection
