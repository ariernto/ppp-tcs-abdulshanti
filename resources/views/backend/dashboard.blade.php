@extends('layouts.app')
@section('content')

<section class="clear dashboard-sec1">
    <div class="container">
      <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
              <div class="d-flex align-items-center justify-content-between heading-block">
                  <h3 class="ds1-rb-i-h3">Dashboard</h3>
                  <button class="btn mbtn-border"> Jan 2019 - Dec 2019</button>
              </div>
          </div>
        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
              <div class="ds1-left-block">
                  <div class="squre-box">
                      <h6 class="ds1-rb-i-h6">Prospect Registration Overview</h6>
                      <div class="d-flex align-items-center justify-content-between overview-heading">
                          <span class="ds1-rb-i-span">Overview</span>
                          <div class="">
                              <span class="ds1-rb-i-span active mr-3">Monthly</span>
                              <span class="ds1-rb-i-span mr-3">Quarterly</span>
                              <span class="ds1-rb-i-span mr-3">Yearly</span>
                          </div>
                      </div>
                      <div id="chartContainer1" class="chartContainer1" style="height: 300px; width: 100%;"></div>
                  </div>
              </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
          <div class="ds1-right-block">
              <div class="ds1-rb-inner squre-box">
                  <div class="mb-2">
                      <h3 class="ds1-rb-i-h3">{{ $data->property->totalProperty }} <small class="ds1-rb-i-small">Properties</small></h3>
                  </div>
                  <div class="row mb-1">
                      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                          <div class="">
                              <h3 class="ds1-rb-i-h3">{{ $data->property->available }}</h3>
                              <small class="ds1-rb-i-small">Available</small>
                          </div>
                      </div>
                      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4" style="border-left: 1px solid #EEEEEE;border-right: 1px solid #EEEEEE;">
                          <div class="">
                              <h3 class="ds1-rb-i-h3">{{ $data->property->underOffer }}</h3>
                              <small class="ds1-rb-i-small">Under Offer</small>
                          </div>
                      </div>
                      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                          <div class="">
                              <h3 class="ds1-rb-i-h3">{{ $data->property->withdrawn }}</h3>
                              <small class="ds1-rb-i-small">Withdrawn</small>
                          </div>
                      </div>

                      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                        <div class="">
                            <h3 class="ds1-rb-i-h3">{{ $data->property->draft }}</h3>
                            <small class="ds1-rb-i-small">Draft</small>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                        <div class="">
                            <h3 class="ds1-rb-i-h3">{{ $data->property->offMarket }}</h3>
                            <small class="ds1-rb-i-small">Off Market</small>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                        <div class="">
                            <h3 class="ds1-rb-i-h3">{{ $data->property->holidayLease }}</h3>
                            <small class="ds1-rb-i-small">Holiday Lease</small>
                        </div>
                    </div>


                  </div>
                  <div class="">
                      <a href="{{ url('properties') }}" class="ds1-rb-i-a">See all properties</a>
                  </div>
              </div>
          </div>
          <div class="ds1-right-block">
              <div class="ds1-rb-inner squre-box">
                  <div class="mb-2 d-flex align-items-center justify-content-between">
                      <h3 class="ds1-rb-i-h3">{{ $data->clients->tenants }} <small class="ds1-rb-i-small">Tenants</small></h3>
                      <h3 class="ds1-rb-i-h3">{{ $data->clients->prospects }} <small class="ds1-rb-i-small">Prospects</small></h3>
                  </div>
                  <div class="mb-2 d-flex align-items-center justify-content-between">
                      <a href="{{ url('tenants') }}" class="ds1-rb-i-a">See all tenants</a>
                      <a href="{{ url('prospects') }}" class="ds1-rb-i-a">See all prospects</a>
                  </div>
                  <div class="mb-2 d-flex align-items-center justify-content-between">
                      <h3 class="ds1-rb-i-h3">{{ $data->clients->totalClient }} <small class="ds1-rb-i-small">Total Registered Clients</small></h3>
                  </div>
              </div>
          </div>
        </div>
      </div>
      <div class="row">
          <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
              <div class="ds1-right-block">
                  <div class="ds1-rb-inner squre-box">
                      <div class="mb-2">
                          <h3 class="ds1-rb-i-h3"> {{ $data->application->totalApplication }} <small class="ds1-rb-i-small">Application lodged</small></h3>
                      </div>
                      <div class="row mb-1">
                          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                              <div class="">
                                  <h3 class="ds1-rb-i-h3">{{ $data->application->pendingApplication }}</h3>
                                  <small class="ds1-rb-i-small">Pending</small>
                              </div>
                          </div>
                          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="">
                                <h3 class="ds1-rb-i-h3">{{ $data->application->reviewedApplication }}</h3>
                                <small class="ds1-rb-i-small">Reviewed</small>
                            </div>
                        </div>
                          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4" style="border-left: 1px solid #EEEEEE;border-right: 1px solid #EEEEEE;">
                              <div class="">
                                  <h3 class="ds1-rb-i-h3">{{ $data->application->cancelledApplication }}</h3>
                                  <small class="ds1-rb-i-small">Cancelled</small>
                              </div>
                          </div>
                          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                              <div class="">
                                  <h3 class="ds1-rb-i-h3">{{ $data->application->approvedApplication }}</h3>
                                  <small class="ds1-rb-i-small">Approved</small>
                              </div>
                          </div>
                      </div>
                      <div class="">
                          <a href="{{ url('applications') }}" class="ds1-rb-i-a">See all applications</a>
                      </div>
                  </div>
              </div>
              <div class="ds1-right-block">
                  <div class="ds1-rb-inner squre-box">
                      <div class="mb-2">
                          <h3 class="ds1-rb-i-h3">{{ $data->inspection->totalInspection }} <small class="ds1-rb-i-small"> Inspections lodged</small></h3>
                      </div>
                      <div class="row mb-1">
                          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                              <div class="">
                                  <h3 class="ds1-rb-i-h3">{{ $data->inspection->closedInspection }}</h3>
                                  <small class="ds1-rb-i-small">Closed</small>
                              </div>
                          </div>
                          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4" style="border-left: 1px solid #EEEEEE;border-right: 1px solid #EEEEEE;">
                              <div class="">
                                  <h3 class="ds1-rb-i-h3">{{ $data->inspection->openInspection }}</h3>
                                  <small class="ds1-rb-i-small">Opened</small>
                              </div>
                          </div>
                          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                              <div class="">
                                  <h3 class="ds1-rb-i-h3">{{ $data->inspection->cancelledInspection }}</h3>
                                  <small class="ds1-rb-i-small">Cancelled</small>
                              </div>
                          </div>
                          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="">
                                <h3 class="ds1-rb-i-h3">{{ $data->inspection->bookedInspection }}</h3>
                                <small class="ds1-rb-i-small">Booked</small>
                            </div>
                        </div>
                      </div>
                      <div class="">
                          <a href="{{ url('inspections') }}" class="ds1-rb-i-a">See all inspections</a>
                      </div>
                  </div>
              </div>
              <div class="ds1-right-block">
                  <div class="ds1-rb-inner squre-box">
                      <div class="mb-2">
                          <h3 class="ds1-rb-i-h3">{{ $data->job->totalJob }} <small class="ds1-rb-i-small"> Maintenance requests lodged</small></h3>
                      </div>
                      <div class="row mb-1">
                          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                              <div class="">
                                  <h3 class="ds1-rb-i-h3">{{ $data->job->newJob }}</h3>
                                  <small class="ds1-rb-i-small">New Job</small>
                              </div>
                          </div>
                          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4" style="border-left: 1px solid #EEEEEE;border-right: 1px solid #EEEEEE;">
                              <div class="">
                                  <h3 class="ds1-rb-i-h3">{{ $data->job->cancelledJob }}</h3>
                                  <small class="ds1-rb-i-small">Cancelled</small>
                              </div>
                          </div>
                          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                              <div class="">
                                  <h3 class="ds1-rb-i-h3">{{ $data->job->inProgressJob }}</h3>
                                  <small class="ds1-rb-i-small">In Progress</small>
                              </div>
                          </div>
                          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="">
                                <h3 class="ds1-rb-i-h3">{{ $data->job->resolvedJob }}</h3>
                                <small class="ds1-rb-i-small">Resolved</small>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="">
                                <h3 class="ds1-rb-i-h3">{{ $data->job->closedJob }}</h3>
                                <small class="ds1-rb-i-small">Closed</small>
                            </div>
                        </div>
                      </div>
                      <div class="">
                          <a href="{{ url('maintanances') }}" class="ds1-rb-i-a">See all maintenances</a>
                      </div>
                  </div>
              </div>
              <div class="ds1-right-block">
                  <div class="ds1-rb-inner squre-box">
                      <div class="mb-2">
                          <h3 class="ds1-rb-i-h3">{{ $data->enquiry->totalEnquiry }} <small class="ds1-rb-i-small"> Enquiries lodged</small></h3>
                      </div>
                      <div class="row mb-1">
                          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                              <div class="">
                                  <h3 class="ds1-rb-i-h3">{{ $data->enquiry->activeEnquiry }}</h3>
                                  <small class="ds1-rb-i-small">Active</small>
                              </div>
                          </div>
                          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4" style="border-left: 1px solid #EEEEEE;border-right: 1px solid #EEEEEE;">
                              <div class="">
                                  <h3 class="ds1-rb-i-h3">{{ $data->enquiry->archiveEnquiry }}</h3>
                                  <small class="ds1-rb-i-small">Archive</small>
                              </div>
                          </div>
                          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                              <div class="">
                                  <h3 class="ds1-rb-i-h3">{{ $data->enquiry->muteEnquiry }}</h3>
                                  <small class="ds1-rb-i-small">Mute</small>
                              </div>
                          </div>
                          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="">
                                <h3 class="ds1-rb-i-h3">{{ $data->enquiry->cancelEnquiry }}</h3>
                                <small class="ds1-rb-i-small">Cancel</small>
                            </div>
                        </div>
                      </div>
                      <div class="">
                          <a href="{{ url('enquiries') }}" class="ds1-rb-i-a">See all Enquiry</a>
                      </div>
                  </div>
              </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
              <div class="ds1-left-block">
                  <div class="squre-box">
                      <h6 class="ds1-rb-i-h6">Lodgements Overview</h6>
                      <div class="d-flex align-items-center justify-content-between overview-heading">
                          <span class="ds1-rb-i-span">Overview</span>
                          <div class="">
                              <span class="ds1-rb-i-span active mr-3">Monthly</span>
                              <span class="ds1-rb-i-span mr-3">Quarterly</span>
                              <span class="ds1-rb-i-span mr-3">Yearly</span>
                          </div>
                      </div>
                      <div id="chartContainer2" class="chartContainer2" style="height: 300px; width: 100%;"></div>
                  </div>
              </div>
              <div class="ds1-left-block">
                  <div class="squre-box">
                      <h6 class="ds1-rb-i-h6">Events Overview</h6>
                      <div class="d-flex align-items-center justify-content-between overview-heading">
                          <span class="ds1-rb-i-span">Overview</span>
                          <div class="">
                              <span class="ds1-rb-i-span active mr-3">Monthly</span>
                              <span class="ds1-rb-i-span mr-3">Quarterly</span>
                              <span class="ds1-rb-i-span mr-3">Yearly</span>
                          </div>
                      </div>
                      <div id="chartContainer3" class="chartContainer3" style="height: 300px; width: 100%;"></div>
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
    </script>
    <script>
        $('#datepicker1').datepicker({ uiLibrary: 'bootstrap4' });
        $(document).ready(function () {
            $('.nav-pills > li a[title]').tooltip();
            //Wizard
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                var target = $(e.target);
                if (target.parent().hasClass('disabled')) { return false; }
            });
            $(".next-step").click(function (e) {
                var active = $('.wizard .nav-pills li.active');
                nextTab(active);
            });
            $(".back-btn").click(function (e) {
                var active = $('.wizard .nav-pills li.active');
                prevTab(active);
            });
        });
        function nextTab(elem) { $(elem).next().find('a[data-toggle="tab"]').click(); }
        function prevTab(elem) { $(elem).prev().find('a[data-toggle="tab"]').click(); }
        $('.nav-pills').on('click', 'li', function() { $('.nav-pills li.active').removeClass('active'); $(this).addClass('active'); });
    </script>
    <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var chart = new CanvasJS.Chart("chartContainer1", {
                axisY: {
                    includeZero: false,
                    interval: 10,
                    title: "Temperature (C)"
                },
                axisX: {
                    interval: 1,
                    intervalType: "month",
                    valueFormatString: "MMM"
                },
                data: [{
                    type: "rangeColumn",
                    color: "#369EAD",
                    dataPoints: [
                        { x: new Date(2012,00,01), y: [0, 10] },  // y: [Low ,High]
                        { x: new Date(2012,01,01), y: [0, 16] },
                        { x: new Date(2012,02,01), y: [0, 19] },
                        { x: new Date(2012,03,01), y: [0, 22] },
                        { x: new Date(2012,04,01), y: [0, 29] },
                        { x: new Date(2012,05,01), y: [0, 34] },
                        { x: new Date(2012,06,01), y: [0, 30] },
                        { x: new Date(2012,07,01), y: [0, 25] },
                        { x: new Date(2012,08,01), y: [0, 20] },
                        { x: new Date(2012,09,01), y: [0, 15] },
                        { x: new Date(2012,10,01), y: [0, 9] },
                        { x: new Date(2012,11,01), y: [0, 5] }
                    ]
                }]
            });
            chart.render();
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            var chart2 = new CanvasJS.Chart("chartContainer2", {
                theme: "light2",
                data: [{
                    type: "pie",
                    showInLegend: true,
                    toolTipContent: "{y} - #percent %",
                    yValueFormatString: "#,##0,,.## Million",
                    legendText: "{indexLabel}",
                    dataPoints: [
                        {  y: 4181563, indexLabel: "PlayStation 3" },
                        {  y: 2175498, indexLabel: "Wii" },
                        {  y: 3125844, indexLabel: "Xbox 360" },
                        {  y: 1176121, indexLabel: "Nintendo DS"},
                        {  y: 1727161, indexLabel: "PSP" },
                        {  y: 4303364, indexLabel: "Nintendo 3DS"},
                        {  y: 1717786, indexLabel: "PS Vita"}
                    ]
                }]
            });
            chart2.render();
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            var chart3 = new CanvasJS.Chart("chartContainer3", {
                axisY:{
                    title:"Coal (bn tonnes)",
                    valueFormatString: "#0.#,.",
                },
                data: [{
                    type: "stackedColumn",
                    legendText: "Anthracite & Bituminous",
                    showInLegend: "true",
                    dataPoints: [
                        {  y: 111338 , label: "USA"},
                        {  y: 49088, label: "Russia" },
                        {  y: 62200, label: "China" },
                        {  y: 90085, label: "India" },
                        {  y: 38600, label: "Australia"},
                        {  y: 48750, label: "SA"}
                    ]
                },  {
                    type: "stackedColumn",
                    legendText: "SubBituminous & Lignite",
                    showInLegend: "true",
                    indexLabel: "#total bn",
                    yValueFormatString: "#0.#,.",
                    indexLabelPlacement: "outside",
                    dataPoints: [
                        {  y: 135305 , label: "USA"},
                        {  y: 107922, label: "Russia" },
                        {  y: 52300, label: "China" },
                        {  y: 3360, label: "India" },
                        {  y: 39900, label: "Australia"},
                        {  y: 0, label: "SA"}
                    ]
                }]
            });
            chart3.render();
        });
    </script>
@endsection
