@extends('layouts.app')
@section('content')
<section class="clear detail-section1">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="relative d-flex align-items-center mb-30">
            <span class="fontsize-12 colordef">Clients <i class="fas fa-angle-right ml-1 mr-1"></i>
            <span class="fontsize-12 colordef">Tenants <i class="fas fa-angle-right ml-1 mr-1"></i>
            </span><span class="fontsize-12 colorblue">Tenant Details</span>
          </div>
          <div class="relative ">
                <h6 class="h6 fontweight-700 mb-30">
                <a href="{{ url('/tenants') }}" class="colordef">
                    <i class="fas fa-arrow-left fontsize-14 mr-1"></i></i>
                </a>
                {{ $application->hasTenant->name }} {{ $application->hasTenant->surname }} </h6>
          </div>
          <div class="nav nav-tabs mb-30" role="tablist">
            <button class="fontsize-12 active" data-toggle="tab" href="#tabs-3" role="tab">Tenant Details </button>
            <button class="fontsize-12  " data-toggle="tab" href="#tabs-4" role="tab">Lease Details </button>
            @if (\App\helper\PermissionHelper::permissionCheck('edit_client'))
            <a href="{{ url('tenants/edit/') . '/' . Request::segment(2) }}" class="ml-auto">
                <button class="btn fontsize-12 mr-0 edit-tenant-button"> Edit </button>
            </a>
            @endif

          </div>
          <div class="tab-content">
            <div class="tab-pane active" id="tabs-3" role="tabpanel">
              <div class="white-box d-block mb-30">
                <div class="main-contant w-100">
                    <div class="relative w-50">
                        <p class="fontsize-14 colorblue fontweight-500">Personal Details </p>
                        <div class="d-flex mb-4">
                            <span class="detil-property">Name</span>
                            <span class="detil-value">{{ $application->hasTenant->name }} {{ $application->hasTenant->surname }} </span>
                        </div>
                        <div class="d-flex mb-4">
                            <span class="detil-property">Address                        </span>
                            <span class="detil-value">
                                {{ $application->hasTenant->address }}
                            </span>
                        </div>
                        <div class="d-flex mb-4">
                            <span class="detil-property">Email
                          </span>
                            <span class="detil-value">{{ $application->hasTenant->email }}
                          </span>
                        </div>
                        <div class="d-flex mb-4">
                            <span class="detil-property">Mobile
                          </span>
                            <span class="detil-value">{{ $application->hasTenant->mobile }}
                          </span>
                        </div>
                        <div class="d-flex mb-4">
                            <span class="detil-property">Phone
                          </span>
                            <span class="detil-value">{{ $application->hasTenant->phone }}
                          </span>
                        </div>
                      <div class="devider mb-4 mt-3"></div>

                      <p class="fontsize-14 colorblue fontweight-500">Employment Details</p>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Profession</span>
                          <span class="detil-value">
                              {{ (isset($application->hasEmployeement->profession))?$application->hasEmployeement->profession:'NA' }}
                            </span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Employer</span>
                          <span class="detil-value">
                              {{ (isset($application->hasEmployeement->employer))?$application->hasEmployeement->employer:'NA' }}
                            </span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Position</span>
                          <span class="detil-value">
                              {{ (isset($application->hasEmployeement->position))?$application->hasEmployeement->position:'NA' }}
                            </span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Employed On</span>
                          <span class="detil-value">
                              {{ (isset($application->hasEmployeement->employed_on))?$application->hasEmployeement->employed_on:'NA' }}
                            </span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Employment Due</span>
                            <span class="detil-value">
                              {{ (isset($application->hasEmployeement->employment_due))?$application->hasEmployeement->employment_due:'NA' }}
                            </span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Employer Address</span>
                          <span class="detil-value">
                              {{ (isset($application->hasEmployeement->employer_address))?$application->hasEmployeement->employer_address:'NA' }}
                            </span>
                      </div>
                    </div>

                    {{-- <div class="relative w-50 pl-30  border-l">
                      <div class="d-flex align-items-center justify-content-between w-100">
                          <p class="fontsize-14 colorblue fontweight-500">Checked Properties
                          </p>
                          <div class="relative d-flex">
                              <div class="form-group inp-rw" style="width:130px;" id="">
                                  <div class="btn-group multi_sigle_select inp_select open">
                                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle mss_sl_btn" aria-expanded="true">Daily</button>
                                      <ul class="dropdown-menu mss_sl_btn_dm" x-placement="bottom-start">
                                          <li class="radiobox-image">
                                              <input type="radio" id="id_22" name="Daily" class="" value="Daily" data-idrem="Daily">
                                              <label for="id_22">Daily</label>
                                          </li>
                                          <li class="radiobox-image">
                                              <input type="radio" id="id_23" name="Daily" class="" value="Daily" data-idrem="Daily">
                                              <label for="id_23">Weekly </label>
                                          </li>
                                      </ul>
                                  </div>
                              </div>
                              <div class="form-group inp-rw ml-2" style="width:130px;" id="">
                                  <span class="after-datepicker-icon"></span>
                                  <input type="text" class="date-picker" placeholder="Choose" value="" id="datepicker10">
                              </div>
                          </div>
                      </div>
                      <div class="d-block mt-4 w-100 scroll-height">
                          <div class="d-flex align-items-center justify-content-between mb-4 ">
                              <span class="fontsize-12">Winward East Unit 07/02 kermat street, Ela Beach.</span>
                              <span class="fontsize-12">4 Mar 2020</span>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mb-4 ">
                              <span class="fontsize-12">Winward East Unit 07/02 kermat street, Ela Beach.</span>
                              <span class="fontsize-12">4 Mar 2020</span>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mb-4 ">
                              <span class="fontsize-12">Winward East Unit 07/02 kermat street, Ela Beach.</span>
                              <span class="fontsize-12">4 Mar 2020</span>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mb-4 ">
                              <span class="fontsize-12">Winward East Unit 07/02 kermat street, Ela Beach.</span>
                              <span class="fontsize-12">4 Mar 2020</span>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mb-4 ">
                              <span class="fontsize-12">Winward East Unit 07/02 kermat street, Ela Beach.</span>
                              <span class="fontsize-12">4 Mar 2020</span>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mb-4 ">
                              <span class="fontsize-12">Winward East Unit 07/02 kermat street, Ela Beach.</span>
                              <span class="fontsize-12">4 Mar 2020</span>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mb-4 ">
                              <span class="fontsize-12">Winward East Unit 07/02 kermat street, Ela Beach.</span>
                              <span class="fontsize-12">4 Mar 2020</span>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mb-4 ">
                              <span class="fontsize-12">Winward East Unit 07/02 kermat street, Ela Beach.</span>
                              <span class="fontsize-12">4 Mar 2020</span>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mb-4 ">
                              <span class="fontsize-12">Winward East Unit 07/02 kermat street, Ela Beach.</span>
                              <span class="fontsize-12">4 Mar 2020</span>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mb-4 ">
                              <span class="fontsize-12">Winward East Unit 07/02 kermat street, Ela Beach.</span>
                              <span class="fontsize-12">4 Mar 2020</span>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mb-4 ">
                              <span class="fontsize-12">Winward East Unit 07/02 kermat street, Ela Beach.</span>
                              <span class="fontsize-12">4 Mar 2020</span>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mb-4 ">
                              <span class="fontsize-12">Winward East Unit 07/02 kermat street, Ela Beach.</span>
                              <span class="fontsize-12">4 Mar 2020</span>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mb-4 ">
                              <span class="fontsize-12">Winward East Unit 07/02 kermat street, Ela Beach.</span>
                              <span class="fontsize-12">4 Mar 2020</span>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mb-4 ">
                              <span class="fontsize-12">Winward East Unit 07/02 kermat street, Ela Beach.</span>
                              <span class="fontsize-12">4 Mar 2020</span>
                          </div>
                      </div>
                  </div> --}}
               </div>
              </div>
            </div>
            <div class="tab-pane" id="tabs-4" role="tabpanel">
              <div class="white-box mb-30">
                <div class="main-contant">
                    <div class="relative w-100">
                        <div class="d-flex mb-4">
                            <span class="detil-property mt-2">Property
                            </span>
                            <span class="detil-value">
                              <div class="form-group inp-rw mb-0" id="">
                                  <div class="btn-group multi_sigle_select inp_select open">
                                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle mss_sl_btn" aria-expanded="true">{{ $application->hasProperty->headline }}</button>
                                      {{--  <ul class="dropdown-menu mss_sl_btn_dm" x-placement="bottom-start">
                                          <li class="radiobox-image">
                                              <input type="radio" id="id_18" name="Access" class="" value="Public" data-idrem="Public">
                                              <label for="id_18">Public</label>
                                          </li>
                                          <li class="radiobox-image">
                                              <input type="radio" id="id_19" name="Access" class="" value="Option" data-idrem="Option">
                                              <label for="id_19">Option </label>
                                          </li>
                                      </ul>  --}}
                                  </div>
                              </div>
                            </span>
                        </div>
                        <div class="d-flex mb-4">
                            <span class="detil-property">Address
                            </span>
                            <span class="detil-value">
                                @php $address = json_decode($application->hasProperty->address); @endphp
                                {{ $address->street_number }} {{ $address->street_name }},
                                {{ $address->suburb }} {{ $address->region }},
                                {{ $address->state }} {{ $address->postcode }} {{ $address->country }}
                            </span>
                        </div>
                        <div class="d-flex mb-4">
                            <span class="detil-property">Applied On
                            </span>
                            <span class="detil-value">
                                {{ Carbon\Carbon::parse($application->date_applied)->format('d F Y') }}
                            </span>
                        </div>
                        <div class="d-flex mb-4">
                          <span class="detil-property">Leased On
                          </span>
                          <span class="detil-value">
                            {{ Carbon\Carbon::parse($application->date_leased)->format('d F Y') }}
                          </span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Leased Due
                          </span>
                          <span class="detil-value">
                            {{ Carbon\Carbon::parse($application->lease_due)->format('d F Y') }}
                          </span>
                      </div>
                        <div class="d-flex mb-4">
                            <span class="detil-property">Security Deposit
                            </span>
                            <span class="detil-value">
                                {{ $application->security_diposit }}
                            </span>
                        </div>

                    </div>

                </div>
                <div class="right-contant">
                  <div class="form-group inp-rw" id="">
                      <div class="btn-group multi_sigle_select inp_select open">
                          <label class="label mb-1">Availability</label>
                          <button data-toggle="dropdown" class="btn btn-default dropdown-toggle mss_sl_btn" aria-expanded="true">Published</button>
                          @if (\App\helper\PermissionHelper::permissionCheck('edit_client'))
                          <ul class="dropdown-menu mss_sl_btn_dm" x-placement="bottom-start">
                              <li class="radiobox-image">
                                  <input type="radio" id="id_18" name="Availability" class="" value="Published" data-idrem="Availability">
                                  <label for="id_18">Published</label>
                              </li>
                              <li class="radiobox-image">
                                  <input type="radio" id="id_19" name="Availability" class="" value="Option" data-idrem="Option">
                                  <label for="id_19">Option </label>
                              </li>
                          </ul>
                          @endif
                      </div>
                  </div>
                  <div class="form-group inp-rw" id="">
                      <div class="btn-group multi_sigle_select inp_select open">
                          <label class="label mb-1">Listing</label>
                          <button data-toggle="dropdown" class="btn btn-default dropdown-toggle mss_sl_btn" aria-expanded="true">Residential</button>
                          @if (\App\helper\PermissionHelper::permissionCheck('edit_client'))
                          <ul class="dropdown-menu mss_sl_btn_dm" x-placement="bottom-start">
                              <li class="radiobox-image">
                                  <input type="radio" id="id_25" name="Access" class="" value="Residential
                                  " data-idrem="Residential">
                                  <label for="id_25">Residential </label>
                              </li>
                          </ul>
                          @endif
                      </div>
                  </div>
                  <div class="form-group inp-rw" id="">
                      <div class="btn-group multi_sigle_select inp_select open">
                          <label class="label mb-1">Access</label>
                          <button data-toggle="dropdown" class="btn btn-default dropdown-toggle mss_sl_btn" aria-expanded="true">Residential</button>
                          @if (\App\helper\PermissionHelper::permissionCheck('edit_client'))

                          <ul class="dropdown-menu mss_sl_btn_dm" x-placement="bottom-start">
                              <li class="radiobox-image">
                                  <input type="radio" id="id_26" name="Access" class="" value="Residential
                                  " data-idrem="Residential">
                                  <label for="id_26">Residential </label>
                              </li>
                          </ul>
                          @endif
                      </div>
                  </div>
              </div>
              </div>
            </div>
            <a href="{{ url('/tenants') }}">
                <button type="button" class="btn btn-black fontsize-12">Close</button>
            </a>
            {{--  <button type="button" class="btn fontsize-12 mr-1">Save</button>  --}}
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection
