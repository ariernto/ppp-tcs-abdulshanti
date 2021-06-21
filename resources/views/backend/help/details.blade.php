@extends('layouts.app')
@section('content')


<section class="clear detail-section1">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="relative d-flex align-items-center mb-30">
            <span class="fontsize-12 colordef">Content <i class="fas fa-angle-right ml-1 mr-1"></i>
            <span class="fontsize-12 colordef">
                <a href="{{ url('help') }}">
                    Help
                </a>
                <i class="fas fa-angle-right ml-1 mr-1"></i>
            </span><span class="fontsize-12 colorblue">Help Detail </span>
          </div>
          <div class="relative ">
            <h6 class="h6 fontweight-700 mb-30">
                <a href="{{ url('help') }}">
                    <i class="fas fa-arrow-left fontsize-14 mr-1"></i>
                </a>
                Help Detail </h6>
          </div>
          <div class="white-box d-block mb-30">
              <div class="main-contant w-100">
                  <div class="relative w-50">
                      <div class="d-flex mb-4">
                          <span class="detil-property">ID</span>
                          <span class="detil-value"> {{ $help->id }} </span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Title </span>
                          <span class="detil-value">{{ $help->quetion }}</span>
                      </div>
                      <div class="d-flex mb-4">
                          <span class="detil-property">Date Created
                        </span>
                          <span class="detil-value">
                            {{ Carbon\Carbon::parse($help->created_at)->format('d F Y') }}
                        </span>
                      </div>
                      <div class="mb-4">
                          <span class="detil-value d-block">Description </span>
                          <p class="detil-value mb-0">
                            {{ $help->answer }}
                          </p>
                      </div>
                      <div class="d-flex mb-4">
                          <div class="upload-img-box display-ib">
                              <img src="{{ url('/public/uploads/help/') . '/' . $help->image }}" onerror="this.onerror=null;this.src='{{ url('/public/images/photo-upload-dummy.svg') }}';" class="mr-3" alt="" width="190" height="130">
                          </div>
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
