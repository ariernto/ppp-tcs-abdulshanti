@extends('layouts.app')
@section('content')
<section class="clear detail-section1">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="relative d-flex align-items-center mb-30"> </span>
            <span class="fontsize-12 colordef">Users <i class="fas fa-angle-right ml-1 mr-1"></i>
            <span class="fontsize-12 colordef"> <a href="{{ url('/workers') }}"> Workers <i class="fas fa-angle-right ml-1 mr-1"></i> </a> </span>
            <span class="fontsize-12 colorblue">Worker Detail </span>
          </div>
          <div class="relative ">
            <h6 class="h6 fontweight-700 mb-30"><a href="{{ url('/workers') }}"> <i class="fas fa-arrow-left fontsize-14 mr-1"></i> </a> Worker Detail </h6>
          </div>
          <div class="white-box d-block mb-30">
              <div class="main-contant w-100">
                  <div class="relative w-50">
                      <div class="d-flex mb-4">
                          <span class="detil-property">ID</span>
                          <span class="detil-value"> {{ $workers->id }} </span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Name </span>
                          <span class="detil-value">{{ $workers->name }}</span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Designation</span>
                          <span class="detil-value">{{ $workers->designation }}</span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Jobs Completed</span>
                          <span class="detil-value">{{ count($workers->completedjobs) }} / {{ count($workers->activejobs) }}
                        </span>
                      </div>
                      <div class="d-flex mb-4">
                          <div class="upload-img-box display-ib">
                              <img src="{{ url('/public/uploads/users/') . '/' . $workers->id . '/' . $workers->profile }}" onerror="this.onerror=null;this.src='{{ url('/public/images/photo-upload-dummy.svg') }}';" class="upload-img-new" alt="">
                          </div>
                      </div>
                  </div>
                  <div class="relative w-50 pl-30  border-l">
                    <div class="d-flex align-items-center justify-content-between w-100 right-block-worker">
                        <p class="fontsize-14 colorblue fontweight-500">Recent Jobs </p>
                        {{--  <div class="relative d-flex table-section1" style="padding: 15px 15px;">
                          <div class="form-group mr-3 ml-3">
                              <input type="search" class="form-control search-input">
                              <img src="images/search-icon.svg" class="search-icon" alt="">
                              <i class="fas fa-times-circle crose-icon"></i>
                            </div>
                        </div>  --}}
                    </div>
                    <div class="d-block mt-4 w-100 scroll-height">
                        @foreach ($workers->activejobs as $item)
                        <div class="d-flex align-items-center justify-content-between mb-4 ">
                            <span class="fontsize-12">#{{ $item->id }}: {{ $item->title }}</span>
                            <span class="fontsize-12">{{ $item->mantinance_type }}</span>
                            <span class="fontsize-12"><span class="detil-value">
                              <span class="chips chips-green">{{ $item->status }}</span></span></span>
                            <span class="fontsize-12">{{ Carbon\Carbon::parse($item->created_at)->format('d F Y') }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
             </div>
            </div>
          </div>
      </div>
    </div>
  </section>
      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.js"></script>
      <script src="js/slick.js"></script>
      <script src="js/mani_custom.js"></script>
      <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
      <script src="js/wow.min.js"></script>
      <script>
        new WOW().init();
      </script>
      <script type="text/javascript">
        $(window).on ('load', function (){
          $('#loader').delay(100).fadeOut('slow');
          $('#loader-wrapper').delay(500).fadeOut('slow');
        });
        $('#datepicker7').datepicker({
              uiLibrary: 'bootstrap4'
        });
      </script>
@endsection
