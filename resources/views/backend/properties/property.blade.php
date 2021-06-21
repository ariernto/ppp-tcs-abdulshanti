@extends('layouts.app')
@section('content')

<section class="clear detail-section1">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="relative d-flex align-items-center mb-30">
          <span class="fontsize-12 colordef">Properties <i class="fas fa-angle-right ml-1 mr-1"></i>
         <a href="{{ url('/properties') }}"><span class="fontsize-12 colordef">Property Listings <i class="fas fa-angle-right ml-1 mr-1"></i>
          </span></a>
          <span class="fontsize-12 colorblue">Property Details</span>
        </div>
        <div class="relative ">
          <h6 class="h6 fontweight-700 mb-30"><a href="{{ url('/properties')}}" class="colordef"><i class="fas fa-arrow-left fontsize-14 mr-1"></i></a> {{ $proertyDetails->headline }}</h6>
        </div>
        <div class="nav nav-tabs mb-30" role="tablist">
          <button class="fontsize-12 active" data-toggle="tab" href="#tabs-1" role="tab">About Property</button>
          <button class="fontsize-12  " data-toggle="tab" href="#tabs-2" role="tab" {{ ($application)?'':'disabled' }}>Tenant and Lease</button>
        </div>
        <div class="tab-content">
          <div class="tab-pane active" id="tabs-1" role="tabpanel">
            <div class="white-box">
              <div class="main-contant">
                  <div class="relative w-50">
                      <div class="d-flex mb-4">
                          <span class="detil-property">ID</span>
                          <span class="detil-value">{{ $proertyDetails->item_id }}</span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Property</span>
                          <span class="detil-value">{{ $proertyDetails->headline }}</span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Listing</span>
                          <span class="detil-value">{{ $proertyDetails->type }}</span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Type</span>
                          <span class="detil-value">{{ $proertyDetails->property_type }}</span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Price</span>
                          <span class="detil-value">{{ $proertyDetails->price_text }}</span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Assigned To</span>
                          <span class="detil-value">{{ $proertyDetails->assignedToAgent->first_name . ' ' . $proertyDetails->assignedToAgent->last_name }}</span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Status</span>
                          <span class="detil-value">
                              @php

                             // echo '<pre>'; print_r($proertyDetails); die;
                               if($proertyDetails->status=='1'){
                                   echo '<span class="chips chips-green" style="width:100px;">Available </span>';
                                  }
                                elseif($proertyDetails->status=='2')
                                  {
                                    echo '<span class="chips chips-gray" style="width:100px;">Under Offer</span>';
                                  }
                                elseif($proertyDetails->status=='3')
                                  {
                                    echo '<span class="chips chips-blue" style="width:100px;">Under Offer</span>';
                                   }
                                elseif($proertyDetails->status=='4')
                                  {
                                  echo '<span class="chips chips-gray" style="width:100px;">Withdrawn</span>';
                                  }
                                elseif($proertyDetails->status=='5'){
                                  echo '<span class="chips chips-gray" style="width:100px;">Draft</span>';
                                 }
                                elseif($proertyDetails->status=='6'){
                                 echo '<span class="chips chips-gray" style="width:100px;">Off Market</span>';
                                }
                                  elseif($proertyDetails->status=='7'){ echo '<span class="chips chips-gray" style="width:100px;"> Holiday Lease</span>'; } @endphp
                          </span>
                      </div>
                  </div>
                  <div class="relative w-50 pl-30  border-l">
                    <div class="d-flex w-100">
                       @php $photo = (array)json_decode($proertyDetails->photos); if(!empty($photo)){
                            $url = $photo[1]->versions->thumb->url;
                            $totalimg =count($photo);
                             }
                            else{
                            $url =asset('public/images/photo-upload-dummy.svg');
                            $totalimg =0;

                             }  @endphp

                        <div class="upload-img-box display-ib">
                            <img src="{{ $url }}" class="upload-img-new" alt="">
                            <!-- <input type="file"> -->
                        </div>
                        <div class="display-ib pl-3">
                            <a href="JavaScript:Void(0);" class="view-gallay-btn mb-3" data-target=".mgallarywork" data-toggle="modal">
                              <img src="{{ asset('public/images/photo-upload-dummy.svg') }}" class="mr-1" alt="">View Gallery
                            </a>
                            <span class="fontsize-12 colordef">{{ $totalimg }} more photos attached</span>
                        </div>
                      </div>
                      <div class="d-block mt-4 w-100">
                        <p class="fontsize-12 fontweight-500 colordef mb-3">Description</p>
                        <p class="fontsize-12 mb-4">{{ $proertyDetails->description }}</p>

                        <p class="fontsize-12 fontweight-500 colordef mb-3">Features</p>
                        <div class="d-block">
                          @php $features = json_decode($proertyDetails->features);  @endphp
                             @if(!empty($features))
                             @foreach($features as $fe)
                           <p class="categary">
                             <img src="{{ asset('public/images/tick.png') }}" class="correct-arrow" alt="">{{ $fe->name }}</p>
                             @endforeach
                            @endif

                        </div>
                      </div>
                  </div>
              </div>

             <!--  <div class="right-contant">
                  <div class="form-group inp-rw" id="">
                      <div class="btn-group multi_sigle_select inp_select open">
                          <label class="label mb-1">Availability</label>
                          <button data-toggle="dropdown" class="btn btn-default dropdown-toggle mss_sl_btn" aria-expanded="true">Published</button>
                          <ul class="dropdown-menu mss_sl_btn_dm" x-placement="bottom-start">
                              <li class="radiobox-image">
                                  <input type="radio" id="id_14" name="Availability" class="" value="Published" data-idrem="Availability">
                                  <label for="id_14">Published</label>
                              </li>
                              <li class="radiobox-image">
                                  <input type="radio" id="id_15" name="Availability" class="" value="Option" data-idrem="Option">
                                  <label for="id_15">Option </label>
                              </li>
                          </ul>
                      </div>
                  </div>
                  <div class="form-group inp-rw" id="">
                    <div class="btn-group multi_sigle_select inp_select open">
                        <label class="label mb-1">Access</label>
                        <button data-toggle="dropdown" class="btn btn-default dropdown-toggle mss_sl_btn" aria-expanded="true">Registered</button>
                        <ul class="dropdown-menu mss_sl_btn_dm" x-placement="bottom-start">
                            <li class="radiobox-image">
                                <input type="radio" id="id_14" name="Access" class="" value="Registered" data-idrem="Registered">
                                <label for="id_14">Registered</label>
                            </li>
                            <li class="radiobox-image">
                                <input type="radio" id="id_15" name="Access" class="" value="Option" data-idrem="Option">
                                <label for="id_15">Option </label>
                            </li>
                        </ul>
                    </div>
                </div>
              </div> -->
            </div>
            <div class="w-100 mt-30">
              <div class="mb-4">
                <a href="{{ url('/properties') }}"><button type="button" class="btn btn-black fontsize-12">Close</button></a>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="tabs-2" role="tabpanel">
            <div class="white-box">
              <div class="main-contant">
                  <div class="relative w-50">
                      <div class="d-flex mb-4">
                          <span class="detil-property">Tenant Name </span>
                          <span class="detil-value"> {{ ($application && $application->hasTenant)?$application->hasTenant->name . ' ' . $application->hasTenant->surname:'' }} </span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Email </span>
                          <span class="detil-value"> {{ ($application && $application->hasTenant)?$application->hasTenant->email:'' }} </span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Phone </span>
                          <span class="detil-value"> {{ ($application && $application->hasTenant)?$application->hasTenant->mobile:'' }} </span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Address </span>
                          <span class="detil-value"> {{ ($application && $application->hasTenant)?$application->hasTenant->address:'' }} </span>
                      </div>

                  </div>
                  <div class="relative w-50 pl-30  border-l">
                    <div class="w-100">
                      <div class="d-flex mb-4">
                          <span class="detil-property"> Property </span>
                          <span class="detil-value">{{ $proertyDetails->headline }}</span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property"> Type </span>
                          <span class="detil-value"> {{ $proertyDetails->type }} </span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property"> Leased On </span>
                          <span class="detil-value"> {{ ($application)?Carbon\Carbon::parse($application->date_leased)->format('d F Y'):'' }} </span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property"> Lease Due </span>
                          <span class="detil-value"> {{ ($application)?Carbon\Carbon::parse($application->lease_due)->format('d F Y'):'' }} </span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property"> Date Applied </span>
                          <span class="detil-value"> {{ ($application)?Carbon\Carbon::parse($application->date_applied)->format('d F Y'):'' }} </span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property"> Security Deposit </span>
                          <span class="detil-value"> {{ ($application)?$application->security_diposit:'' }} </span>
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
</section>

<div class="modal fade mgallarywork" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Images</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"><img src="{{ asset('public/images/crose-icon1.svg') }}" alt=""></span>
            </button>
        </div>

        <div class="modal-body">
          <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @php $i = 1; @endphp
                        @foreach ($images as $image)
                        <div class="carousel-item {{ ($i == 1)?'active':'' }}">
                            <img class="d-block w-100" src="{{ $image->versions->large->url }}" alt="First slide">
                        </div>
                        @php $i++; @endphp
                        @endforeach
                      {{--  <div class="carousel-item">
                        <img class="d-block w-100" src="{{ asset('public/images/slider-default.png') }}" alt="Second slide">
                      </div>
                      <div class="carousel-item">
                        <img class="d-block w-100" src="{{ asset('public/images/slider-default.png') }}" alt="Third slide">
                      </div>  --}}
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
@endsection
