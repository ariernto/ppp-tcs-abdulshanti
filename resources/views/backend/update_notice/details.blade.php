@extends('layouts.app')
@section('content')
<section class="clear detail-section1">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="relative d-flex align-items-center mb-30">
            <span class="fontsize-12 colordef">Content <i class="fas fa-angle-right ml-1 mr-1"></i>
            <span class="fontsize-12 colordef">
                <a href="{{ url('/update-notice/') }}">
                    Updates and Notices
                </a>
            <i class="fas fa-angle-right ml-1 mr-1"></i>
            </span><span class="fontsize-12 colorblue">Updates and Notices Detail </span>
          </div>
          <div class="relative ">
            <h6 class="h6 fontweight-700 mb-30">
                <a href="{{ url('/update-notice/') }}">
                    <i class="fas fa-arrow-left fontsize-14 mr-1"></i>
                </a>
                Updates and Notices Detail </h6>
          </div>
          <div class="white-box d-block mb-30">
              <div class="main-contant w-100">
                  <div class="relative w-50">
                      <div class="d-flex mb-4">
                          <span class="detil-property">ID</span>
                          <span class="detil-value">{{ $updateNotice->id }} </span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Title </span>
                          <span class="detil-value">{{ $updateNotice->title }}</span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Category </span>
                          <span class="detil-value">{{ $updateNotice->type }} </span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Date Created </span>
                          <span class="detil-value">{{ Carbon\Carbon::parse($updateNotice->publish_date)->format('d F Y') }} </span>
                      </div>
                      <div class="mb-4">
                          <span class="detil-value d-block mb-4">Description </span>
                          <p class="detil-value mb-0">{{ $updateNotice->description }}</p>
                      </div>
                  </div>
                  <div class="relative w-50 pl-30  border-l">
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
