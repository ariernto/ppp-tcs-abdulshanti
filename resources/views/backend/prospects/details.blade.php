@extends('layouts.app')
@section('content')

<section class="clear detail-section1">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="relative d-flex align-items-center mb-30">
            <span class="fontsize-12 colordef">Clients <i class="fas fa-angle-right ml-1 mr-1"></i>
            <span class="fontsize-12 colordef">Prospects <i class="fas fa-angle-right ml-1 mr-1"></i>
            </span><span class="fontsize-12 colorblue">Prospect Details </span>
          </div>
          <div class="relative ">
            <h6 class="h6 fontweight-700 mb-30"><i class="fas fa-arrow-left fontsize-14 mr-1"></i></i> {{ $application->hasTenant->name }} {{ $application->hasTenant->surname }} </h6>
          </div>
          <div class="white-box d-block mb-30">
              <div class="main-contant w-100">
                  <div class="relative w-50">
                      <p class="fontsize-14 colorblue fontweight-500">Prospect Details   </p>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Name</span>
                          <span class="detil-value">{{ $application->hasTenant->name }} {{ $application->hasTenant->surname }} </span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Location </span>
                          <span class="detil-value">
                            @php $address = json_decode($application->hasProperty->address); @endphp
                            {{ $address->state }} ({{ $address->country }})
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
                      <div class="d-flex mb-4">
                          <span class="detil-property">Joined On</span>
                          <span class="detil-value">{{ Carbon\Carbon::parse($application->hasTenant->created_at)->format('d F Y') }} </span>
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
                                <input type="text" class="date-picker" placeholder="Choose" value="" id="datepicker7">
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
            {{--  <button type="button" class="btn fontsize-12 mr-1">Save</button>  --}}
            <a href="{{ url('/prospects') }}"><button type="button" class="btn btn-black fontsize-12"> Close </button></a>
          </div>
      </div>
    </div>
  </section>
@endsection
