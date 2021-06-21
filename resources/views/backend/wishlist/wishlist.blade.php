@extends('layouts.app')
@section('content')

<section class="clear table-section1">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="relative d-flex align-items-center mb-30">
          <span class="fontsize-12 colordef">Properties <i class="fas fa-angle-right ml-1 mr-1"></i></span><span class="fontsize-12 colorblue">Property Wishlists
        </span>
        </div>
        <div class="relative d-flex align-items-center justify-content-between">
          <h6 class="h6 fontweight-700">Property Wishlists <img src="images/Arrow-down.svg" class="arrow-down" alt=""></h6>
          <form action="" method="POST">
          	@csrf
	          <div class="d-flex">
	            <div class="form-group mr-3">
	              <input type="search" class="form-control search-input" name="q" id="q" value="{{ ($prop['q'] != '')? $prop['q']: '' }}" placeholder="Search wishlists">
                <img src="{{ asset('public/images/search-icon.svg') }}" class="search-icon" alt="">
                <img src="{{ asset('public/images/search-cancel-icon.svg') }}" class="crose-icon" id="reset" alt="">
	              <!-- <i class="fas fa-times-circle crose-icon" id="reset"></i> -->
	            </div>
	            <button type="submit" id="search" class="btn btn-black">Search</button>
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
                <a href="{{ url('/wishlist/id/'). '/' .$filterby }}"> ID <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                    $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                    if(Request::segment(2) && Request::segment(2) == "listing") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/wishlist/listing/'). '/' .$filterby }}"> Listing <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "property") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/wishlist/property/'). '/' .$filterby }}"> Property <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "propertytype") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/wishlist/propertytype/'). '/' .$filterby }}"> Property Type<span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "suburb") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/wishlist/suburb/'). '/' .$filterby }}"> Suburb <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "savedby") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/wishlist/savedby/'). '/' .$filterby }}"> Saved By <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                 <th>
                    @php
                    $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                    if(Request::segment(2) && Request::segment(2) == "client") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                @endphp
                <a href="{{ url('/wishlist/client/'). '/' .$filterby }}"> Client <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                <th>
                    @php
                        $filterby = 'asc'; $filterIcon = 'fa-arrow-up';
                        if(Request::segment(2) && Request::segment(2) == "addedon") { if(Request::segment(3) == "asc") { $filterby = 'desc'; $filterIcon = 'fa-arrow-down'; } }
                    @endphp
                    <a href="{{ url('/wishlist/addedon/'). '/' .$filterby }}"> Added On <span class="display-ib"> <i class="fas {{ $filterIcon }}"></i> </span> </a>
                </th>
                {{-- <th></th> --}}
              </tr>
            </thead>
            <tbody>

                @if (!empty($wishlist[0]))
            	 @foreach($wishlist as $row)
              <tr>
                <td><a class="linked" href="{{ url('/property') . '/' . $row->property_id }}">{{ $row->property_id }}</a></td>
                <td>{{ ($row->type)? $row->type: '' }} </td>
                <td><a href="{{ url('/property') . '/' . $row->property_id }}"><span class="overflow_elips width260">{{ ($row->headline)? $row->headline: '' }}</span></a></td>
                <td>
                    {{ ($row->property_type)? $row->property_type: '' }}

                </td>
                <td>@php if($row->address){
                            $address = json_decode($row->address);
                             echo $address->suburb;
                          }
                                  @endphp
                              </td>
                <td>{{ ($row->name)?$row->name . ' ' . $row->surname : ''  }}</td>
                 <td>
                     @if ($row->approvedCount)
                     <span>Tenant</span>
                     @else
                     <span>Prospect</span>
                     @endif
                 </td>
                <td>{{ date_format(date_create($row->created_at), 'd F Y') }}</td>
                {{-- <td>
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
                </td> --}}
              </tr>
             @endforeach
             @else
            <tr><td colspan="8" style="text-align: center;">No record found.</td></tr>
            @endif
              <!-- <tr>
                <td><a href="property-wishist-detail.html">40408820</a></td>
                <td>ResLease </td>
                <td><span class="overflow_elips width260">Address goes here on
                    on a single line to text..</span></td>
                <td>Paga Hill</td>
                <td>Chikelu Obasea</td>
                <td>24 Mar 2020</td>
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
                <td><a href="property-wishist-detail.html">40408820</a></td>
                <td>ResLease </td>
                <td><span class="overflow_elips width260">Address goes here on
                    on a single line to text..</span></td>
                <td>Paga Hill</td>
                <td>Chikelu Obasea</td>
                <td>24 Mar 2020</td>
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
                <td><a href="property-wishist-detail.html">40408820</a></td>
                <td>Commericial </td>
                <td><span class="overflow_elips width260">Address goes here on
                    on a single line to text..</span></td>
                <td>Ela Beach
                </td>
                <td>Chikelu Obasea</td>
                <td>24 Mar 2020</td>
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
                    <td><a href="property-wishist-detail.html">40408820</a></td>
                    <td>Commericial </td>
                    <td><span class="overflow_elips width260">Address goes here on
                        on a single line to text..</span></td>
                    <td>Town</td>
                    <td>Chikelu Obasea</td>
                    <td>24 Mar 2020</td>
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
                <td><a href="property-wishist-detail.html">40408820</a></td>
                <td>Commericial </td>
                <td><span class="overflow_elips width260">Address goes here on
                    on a single line to text..</span></td>
                <td>Lae</td>
                <td>Chikelu Obasea</td>
                <td>24 Mar 2020</td>
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
        // setTimeout(() => { $('#close_alert').trigger('click'); }, 5000);
    });
    $(document).ready(function(){
      $('.filter').change(function(){ $('#search').trigger('click'); });
      $('#reset').click(function(){ var url = "{{ url('/wishlist') }}"; window.location.replace(url); });
    });
  </script>
@endsection
