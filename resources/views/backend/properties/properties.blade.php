@extends('layouts.app')
@section('content')



<section class="clear table-section1">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="relative d-flex align-items-center mb-30">
          <span class="fontsize-12 colordef">Properties <i class="fas fa-angle-right ml-1 mr-1"></i></span><span class="fontsize-12 colorblue">Property Listings</span>
        </div>
        <div class="relative d-flex align-items-center justify-content-between">
          <h6 class="h6 fontweight-700">Property Listings <img src="images/Arrow-down.svg" class="arrow-down" alt=""></h6>
         <form action="" method="POST">
				@csrf
          <div class="d-flex">
            <div class="form-group mr-3">
              <input type="search" class="form-control search-input" name="q" id="q" value="{{ ($prop['q'] != '')? $prop['q']: '' }}" placeholder="Search properties">
              <img src="{{ asset('public/images/search-icon.svg') }}" class="search-icon" alt="">
              <img src="{{ asset('public/images/search-cancel-icon.svg') }}" class="crose-icon" id="reset" alt="">
              <!-- <i class="fas fa-times-circle crose-icon" id="reset"></i> -->
            </div>
            <button id="search" type="submit" class="btn btn-black">Search</button>
          </div>
      </form>
        </div>
        <div class="my-table">
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

          <table class="table">
            <thead>
              <tr>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "id") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/properties/id/'). '/' .$filterby }}"> ID <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "listing") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/properties/listing/'). '/' .$filterby }}"> Listing <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th style="color:#4A90E2;">
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "headline") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/properties/headline/'). '/' .$filterby }}"> Property <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "suburb") { if(Request::segment(3) == "asc") { $filterby = 'desc';  $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/properties/suburb/'). '/' .$filterby }}"> Suburb <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "property_type") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/properties/property_type/'). '/' .$filterby }}"> Type <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i></span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "price") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/properties/price/'). '/' .$filterby }}"> Price <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i></span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "assigned_to") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/properties/assigned_to/'). '/' .$filterby }}"> Assigned To <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i></span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "status") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/properties/status/'). '/' .$filterby }}"> Status <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                {{--  <th>Action</th>  --}}
              </tr>
            </thead>
            <tbody>
             @php if(!empty($proerties[0])){ @endphp
            	@foreach($proerties as $proerty)
						<tr>
							<td> <a href="{{ url('/property') . '/' . $proerty->item_id }}" class="linked"> {{ $proerty->item_id }} </a> </td>
                            <td>{{ ($proerty->type == '')? 'N/A' : $proerty->type }}</td>
                            <td><a href="{{ url('/property') . '/' . $proerty->item_id }}"><span class="overflow_elips width260">{{ $proerty->headline }}</span></a></td>
							@php $address = json_decode($proerty->address); @endphp
							<td> {{ $address->suburb }} </td>
							<td>{{ $proerty->property_type }}</td>
							<td><span class="overflow_elips width190">{{ $proerty->price_text }}</span></td>
							<td>@php if(!empty($proerty->assignedTo)){ echo $proerty->assignedTo->first_name . ' ' . $proerty->assignedTo->last_name; } @endphp</td>
							<td>@php if($proerty->status=='1'){ echo '<span class="chips chips-green">Available </span>'; }
							    elseif($proerty->status=='2') { echo '<span class="chips chips-gray">Under Offer</span>'; }
							    elseif($proerty->status=='3') { echo '<span class="chips chips-blue">Under Offer</span>'; }
							    elseif($proerty->status=='4') { echo '<span class="chips chips-gray">Withdrawn</span>'; }
							    elseif($proerty->status=='5'){ echo '<span class="chips chips-gray">Draft</span>'; }
							    elseif($proerty->status=='6'){ echo '<span class="chips chips-gray">Off Market</span>'; }
						        elseif($proerty->status=='7'){ echo '<span class="chips chips-gray"> Holiday Lease</span>'; } @endphp
						    </td>
						<!-- <td>
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
		                </td> -->

						@endforeach
             @php } else { @endphp
            <tr><td colspan="8" style="text-align: center;">No record found.</td></tr>
            @php }  @endphp
            </tbody>
          </table>

          <nav aria-label="Page navigation example">
            <ul class="pagination">
              @php
                  $url = url('/properties');
                  if (!is_numeric(Request::segment(2))) {
                  if (Request::segment(2)) { $url = $url . '/' . Request::segment(2); }
                  if (Request::segment(3)) { $url = $url . '/' . Request::segment(3); }
                  }
              @endphp
              <li class="page-item">
                <a class="page-link" href="{{ $url }}/{{ (($pagination - 1) != 0)?$pagination - 1:1 }}" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                  <span class="sr-only">Previous</span>
                </a>
              </li>
              @for ($i = 1; $i <= $totalPages; $i++)
                <li class="page-item"><a class="page-link {{ ($i == $pagination)?'active':'' }}" href="{{ $url }}/{{ $i }}">{{ $i }}</a></li>
              @endfor
              <li class="page-item">
                <a class="page-link" href="{{ $url }}/{{ (($pagination + 1) > $totalPages)?$totalPages:$pagination + 1 }}" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                  <span class="sr-only">Next</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>
        <div>

        </div>
      </div>
    </div>
  </div>
</section>
<script type="text/javascript">
$(document).ready(function(){
        $('#saveandclose').click(function(){ $('#saveandclosevalue').val('close'); });
        setTimeout(() => { $('#close_alert').trigger('click'); }, 5000);
    });
    $(document).ready(function(){
        $('.filter').change(function(){ $('#search').trigger('click'); });
        $('#reset').click(function(){ var url = "{{ url('/properties') }}"; window.location.replace(url); });
      });
</script>

@endsection
