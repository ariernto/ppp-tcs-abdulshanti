@extends('layouts.app')
@section('content')
  <!-- <header class="page-header page-header-left-breadcrumb">
    <div class="right-wrapper">
      <ol class="breadcrumbs">
        <li>
        	<a href="{{ url('/home') }}"> <i class="fas fa-home"></i> </a>
        </li>
        <li><span>Enquiries</span></li>
      </ol>
    </div>
    <h2>Enquiry Listing</h2>
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
                    <div class="row">
                        @csrf


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
                                    <option value="subjects" {{ ($prop['sortby'] == 'subjects')? 'selected': '' }}> Enquiry </option>
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
							<th> Enquiry 11 </th>
							<th>Tenant </th>
							<th>Property</th>
							<th>Assigned Agent</th>
							<th>Status</th>
							<th>Date Lodged</th>
						</tr>
					</thead>
					<tbody>
                        @if (!empty($enquiries))
                        @foreach($enquiries as $enquiry)
                        <tr>
                            <td> <a href="{{ url('/enquiry') . '/' .$enquiry->id }}">{{ $enquiry->id }}</a> </td>
                            <td> {{ $enquiry->subjects }} </td>
                            <td> {{ ($enquiry->hasTenant)?$enquiry->hasTenant->name . ' ' . $enquiry->hasTenant->surname : ''  }} </td>
                            <td> {{ ($enquiry->hasProperty)?$enquiry->hasProperty->headline: '' }} </td>
                            <td> {{ ($enquiry->assignedAgent)?$enquiry->assignedAgent->first_name . ' ' . $enquiry->assignedAgent->last_name: '' }} </td>
                            <td>
                                @if($enquiry->status == 'active')
                                <span class="chips-open">Open</span>
                                @else
                                <span class="chips-close">Close</span>
                                @endif
                            </td>
                            <td> {{ date_format(date_create($enquiry->updated_at), 'd F Y') }} </td>
                        </tr>
                        @endforeach
                        @else
                        <tr><td colspan="8" style="text-align: center;">No record found.</td></tr>
                        @endif
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
          <span class="fontsize-12 colordef">Properties <i class="fas fa-angle-right ml-1 mr-1"></i></span><span class="fontsize-12 colorblue">Property Enquiries
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
          <h6 class="h6 fontweight-700">Property Enquiries <img src="images/Arrow-down.svg" class="arrow-down" alt=""></h6>
         <form action="" method="POST">
            @csrf
          <div class="d-flex">
            <div class="form-group mr-3">
              <input type="search" class="form-control search-input" name="q" id="q" value="{{ ($prop['q'] != '')? $prop['q']: '' }}" placeholder="Search enquiries">
              <img src="{{ asset('public/images/search-icon.svg') }}" class="search-icon" alt="">
              <img src="{{ asset('public/images/search-cancel-icon.svg') }}" class="crose-icon" id="reset" alt="">
              <!-- <i class="fas fa-times-circle crose-icon" id="reset"></i> -->
            </div>
            <button type="submit" id="search" class="btn btn-black">Search</button>
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
                    <a href="{{ url('/enquiries/id/'). '/' .$filterby }}"> ID <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "lodged") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/enquiries/lodged/'). '/' .$filterby }}"> Enquiry Date <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "enquiry") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/enquiries/enquiry/'). '/' .$filterby }}"> Enquiry <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "lodgedby") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/enquiries/lodgedby/'). '/' .$filterby }}"> Lodged By <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "type") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/enquiries/type/'). '/' .$filterby }}"> Type <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "agent") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/enquiries/agent/'). '/' .$filterby }}"> Assigned Agent <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "status") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/enquiries/status/'). '/' .$filterby }}"> Status <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>

                </th>
              </tr>
            </thead>
            <tbody>

              @if (!empty($enquiries[0]))
             @foreach($enquiries as $enquiry)
              <tr>
                <td><a class="linked" href="{{ url('/enquiry') . '/' .$enquiry->id }}">{{ $enquiry->id }}</a></td>
                <td>{{ date_format(date_create($enquiry->updated_at), 'd F Y') }}
                </td>
                <td><span class="overflow_elips width520"><span class="colorgray">Subject here:</span> {{ $enquiry->subjects }}
                </span></td>
                <td> {{ ($enquiry->hasTenant)?$enquiry->hasTenant->name . ' ' . $enquiry->hasTenant->surname : ''  }}
                </td>
                <td class="capitalize">{{ $enquiry->type }}</td>
                <td>{{ ($enquiry->assignedAgent)?$enquiry->assignedAgent->first_name . ' ' . $enquiry->assignedAgent->last_name: '' }}
                </td>
                <td>@if($enquiry->status == 'active')
                    <span class="chips chips-open">Open</span>
                    @else
                    <span class="chips chips-close">Close</span>
                    @endif
                </td>
              </tr>
            @endforeach
            @else
            <tr><td colspan="8" style="text-align: center;">No record found.</td></tr>
            @endif
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
        // setTimeout(() => { $('#close_alert').trigger('click'); }, 5000);
    });
    $(document).ready(function(){
        $('.filter').change(function(){ $('#search').trigger('click'); });
        $('#reset').click(function(){ var url = "{{ url('/enquiries') }}"; window.location.replace(url); });
    });
  </script>
@endsection
