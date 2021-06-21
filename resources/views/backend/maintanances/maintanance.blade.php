@extends('layouts.app')
@section('content')

<section class="clear detail-section1" id="main">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
      <form action="{{ url('/maintenance/change_status') }}" method="post">
        @csrf
        <input type="hidden" name="job_id" value="{{ $job->id }}">
        <div class="relative d-flex align-items-center mb-30">
          <span class="fontsize-12 colordef">Properties <i class="fas fa-angle-right ml-1 mr-1"></i>
            <a href="{{ url('/maintanances') }}">
                <span class="fontsize-12 colordef">Property Maintenance Properties<i class="fas fa-angle-right ml-1 mr-1"></i>
            </a>
          </span><span class="fontsize-12 colorblue">Request Details </span>
          @if (\App\helper\PermissionHelper::permissionCheck('edit_maintenance'))
          <span class="chat-button" onclick="openNav()"><img src="{{ asset('public/images/opan-chat-icon.png') }}" class=""> Open Chat</span>
          @endif
        </div>
          @if(session()->has('success'))
    <div class="alert alert-success">
    <a href="#" class="close" id="close_alert" data-dismiss="alert" aria-label="close" style="padding:0px;height:32px;top:0px;">&times;</a>
    <p class="bold mb-0"> Message </p>
        {{ session()->get('success') }}
    </div>
@endif
        <div class="relative mb-30">
          <h6 class="h6 fontweight-700 mb-30"><a href="{{ url('/maintanances') }}" class="colordef"><i class="fas fa-arrow-left fontsize-14 mr-1"></i></a> Request Details</h6>
        </div>
        <div class="white-box mb-30">
            <div class="alert-type-box"><img src="{{ asset('public/images/info-icon.svg') }}">A suitable maintenance worker should be assigned to every job for rectification.</div>
            <div class="main-contant">
                <div class="relative">
                    <div class="d-flex mb-3">
                        <span class="display-ib colordef fontsize-12 fontweight-500 mr-4">Issue</span>
                        <span class="display-ib colordef fontsize-12 "> <b>{{ $job->title }}</b>  </span>
                        <span class="chips chips-black ml-auto" style="text-transform: uppercase">{{ $job->mantinance_type }}</span>
                    </div>
                    <div class="gray-box-italic mb-30">
                        <span>{{ $job->description }}</span>
                    </div>
                    <div class="d-flex mb-4">
                        <span class="detil-property">Requested By
                        </span>
                        <span class="detil-value">{{ ($job->hasTenant)?$job->hasTenant->name . ' ' . $job->hasTenant->surname : ''  }}<span class="chips chips-green ml-1">Tenant</span></span>
                     </div>
                     <div class="d-flex mb-4">
                      <span class="detil-property">Requested On
                    </span>
                      <span class="detil-value">{{ date_format(date_create($job->created_at), 'l, d F Y, h:i A') }}</span>
                   </div>
                   <div class="devider mb-4"></div>
                   <div class="d-flex mb-4">
                        <span class="detil-property">Property</span>
                        <span class="detil-value colorblue" style="color:#4A90E2;">
                            <a target="_blank" href="{{ url('/') }}/property/{{ $job->hasProperty->item_id }}"> {{ $job->hasProperty->headline }} </a>
                        </span>
                    </div>
                    <div class="d-flex mb-4">
                        <span class="detil-property">Address
                        </span>
                        <span class="detil-value">@php
                          if ($job->hasProperty){
                            $address = json_decode($job->hasProperty->address);
                            $outadd = $address->street_number . ' ' . $address->street_name . ' ' . $address->suburb . ' ' . $address->state;
                          } else { $outadd = ''; }
                                  @endphp
                               {{ $outadd }}
                        </span>
                    </div>
                    <div class="d-flex mb-4">
                        <span class="detil-property">Rectifying Time</span>
                        <span class="detil-value">{{ $job->hours }} hours </span>
                    </div>
                    @if ($job->status=='resolved')
                    <div class="devider mb-4"></div>
                    <div class="d-flex mb-4">
                        <span class="detil-property">Tenant Rating</span>
                        <span class="detil-value">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <!-- <fieldset class="rating">
                                <input type="radio" id="star5" name="rating" value="5" />
                                <label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                {{--  seperator  --}}
                                <input type="radio" id="star4half" name="rating" value="4 and a half" />
                                <label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                {{--  seperator  --}}
                                <input type="radio" id="star4" name="rating" value="4" />
                                <label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                {{--  seperator  --}}
                                <input type="radio" id="star3half" name="rating" value="3 and a half" />
                                <label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                {{--  seperator  --}}
                                <input type="radio" id="star3" name="rating" value="3" />
                                <label class = "full" for="star3" title="Meh - 3 stars"></label>
                                {{--  seperator  --}}
                                <input type="radio" id="star2half" name="rating" value="2 and a half" />
                                <label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                {{--  seperator  --}}
                                <input type="radio" id="star2" name="rating" value="2" />
                                <label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                {{--  seperator  --}}
                                <input type="radio" id="star1half" name="rating" value="1 and a half" />
                                <label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                {{--  seperator  --}}
                                <input type="radio" id="star1" name="rating" value="1" />
                                <label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                {{--  seperator  --}}
                                <input type="radio" id="starhalf" name="rating" value="half" />
                                <label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                            </fieldset> -->
                        </span>
                    </div>
                    <div class="d-flex mb-4">
                        <span class="detil-property">Tenant Feedback</span>
                        <span class="detil-value">
                            @php if(!empty($job->hasRating->review)){ @endphp
                            <div class="gray-box-value">
                                {{ ($job->hasRating)?$job->hasRating->review:'' }}
                            </div>
                            @php } @endphp
                        </span>
                    </div>
                    @endif
                    <div class="d-flex w-100">
                        @php $images = json_decode($job->filepath); @endphp
                        <div class="upload-img-box display-ib">
                            @if (count($images) > 0)
                            <img src="{{ asset('public/uploads/job/') }}/{{ $job->uid }}/{{ $images[0] }}" onerror="this.onerror=null;this.src='{{ asset('public/images/slider-default.png') }}';" class="upload-img-new" alt="">
                            @else
                            <img src="{{ asset('public/images/slider-default.png') }}" class="upload-img-new" alt="">
                            @endif
                        </div>
                        @if (count($images) > 0)
                        <div class="display-ib pl-3">
                            <a href="JavaScript:Void(0);" class="view-gallay-btn mb-3" data-target=".gallaryMaintanance" data-toggle="modal">
                              <img src="{{ asset('public/images/photo-upload-dummy.svg') }}" class="mr-1" alt="">View Images
                            </a>
                            <span class="fontsize-12 colordef">{{ count($images) - 1 }} more photos attached</span>
                        </div>
                         @endif
                    </div>
                </div>

            </div>
            <div class="right-contant">
                <div class="form-group inp-rw" id="">
                    <div class="btn-group multi_sigle_select inp_select open">
                        <label class="label mb-1">Assigned Worker</label>
                        <button data-toggle="dropdown" class="btn btn-default dropdown-toggle mss_sl_btn" aria-expanded="true">{{ ( $job->assignedWorker)?$job->assignedWorker->name:'Assign Worker' }}</button>
                        @if (\App\helper\PermissionHelper::permissionCheck('edit_maintenance'))
                        <ul class="dropdown-menu mss_sl_btn_dm" x-placement="bottom-start">
                            @foreach ($workers as $worker)
                            <li class="radiobox-image">
                                <input type="radio" id="id_{{ $worker->id }}" name="assignedWorker" class="" value="{{ $worker->id }}" {{ ($job->assignedWorker)?($worker->id == $job->assign_id)?'checked':'':'' }} data-idrem="Availability">
                                <label for="id_{{ $worker->id }}">{{ $worker->name }}</label>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
                <div class="form-group inp-rw" id="">
                  <div class="btn-group multi_sigle_select inp_select open">
                      <label class="label mb-1">Job Card Status </label>
                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle mss_sl_btn" aria-expanded="true">{{$job->status}}</button>
                    @if (\App\helper\PermissionHelper::permissionCheck('edit_maintenance'))
                    <ul class="dropdown-menu mss_sl_btn_dm" x-placement="bottom-start">
                        <li class="radiobox-image">
                          <input type="radio" id="id_13" name="status" class="" value="new" data-idrem="New" @php if($job->status=='new'){ echo 'checked'; } @endphp>
                          <label for="id_13">New</label>
                      </li>
                       <li class="radiobox-image">
                          <input type="radio" id="idin_13" name="status" class="" value="in progress" data-idrem="In progress" @php if($job->status=='in progress'){ echo 'checked'; } @endphp>
                          <label for="idin_13">In progress</label>
                      </li>
                      <li class="radiobox-image">
                          <input type="radio" id="idca_13" name="status" class="" value="cancelled" data-idrem="In progress" @php if($job->status=='cancelled'){ echo 'checked'; } @endphp>
                          <label for="idca_13">Cancelled</label>
                      </li>
                       <li class="radiobox-image">
                          <input type="radio" id="idca_1131" name="status" class="" value="resolved" data-idrem="Closed" @php if($job->status=='closed' || $job->status=='resolved'){ echo 'checked'; } @endphp>
                          <label for="idca_1131">Closed</label>
                      </li>
                    </ul>
                    @endif
                  </div>
              </div>

            </div>
        </div>
        @if (\App\helper\PermissionHelper::permissionCheck('edit_maintenance'))
        <button type="submit" class="btn fontsize-12 mr-1">Save</button>
        <input type="hidden" name="saveandclose" id="saveandclosevalue" value="">
        <button type="submit" id="saveandclose" class="btn fontsize-12 mr-1">Save and Close</button>
        @endif

        <a href="{{ url('/maintanances') }}"><button type="button" class="btn btn-black fontsize-12">close</button></a>
      </form>
      </div>
    </div>
  </div>
</section>

<div id="mySidenav" class="sidenav">
  <div class="d-flex align-items-center justify-content-between">
    <div class="relative">
      <div class="chat-img display-ib">
        @php
        if(!empty($job->hasTenant->profile_image)){
         $urlImgUrl = asset('public/uploads/users/'.$job->hasTenant->id.'/'.$job->hasTenant->profile_image);
        }
        else{
        $urlImgUrl = asset('public/images/user-icon.svg');
    }
        @endphp
        <img src="{{ $urlImgUrl }}" style="height: 33px; width: 33px;border-radius: 50%;" alt="">
      </div>
      <span class="display-ib fontweight-500 fontsize-12 colordef">Chat with {{ ($job->hasTenant)?$job->hasTenant->name . ' ' . $job->hasTenant->surname : ''  }} </span>
    </div>
    <a href="javascript:void(0)" class="" onclick="closeNav()">&times;</a>
  </div>
  <div class="chat-box" id="chatBox">
        @if (count($jobMessage) > 0)
                    @foreach ($jobMessage as $chat)
                    @if ($chat->sender_id == auth()->user()->agent_id)

                      <div class="send-msg">
                        <span class="out-chat">{{ $chat->message }}</span>
                        <span class="chat-date-time">{{ date_format(date_create($chat->created_at), 'd M Y, h:i: A') }}</span>

                    </div>
                    @else

                      <div class="received-msg">
                        <span class="in-chat">{{ $chat->message }}</span>
                        <span class="chat-date-time">{{ date_format(date_create($chat->created_at), 'd M Y, h:i: A') }}</span>

                    </div>
                    @endif
                    @endforeach
                    @else
                    <div> <p>No chat available yet</p> </div>
                    @endif


  </div>
  <div class="msg-input">
    <div class="message-send-box">
    <img src="{{ asset('public/images/emoji.svg') }}" class="emoji">

   <input type="hidden" name="application" id="application" value="{{ $job->id }}">
  <input type="hidden" name="sender" id="sender" value="{{ auth()->user()->agent_id }}">
  <input type="hidden" name="reciever" id="reciever" value="{{ $job->hasTenant->id }}">
  <textarea  name="message" id="message" class="msg-type" placeholder="Type your message here"></textarea>
    <div id="chatErr" class="text-danger"></div>
   <div id="chatSuccess" class="text-success"></div>
    <button type="button" id="send" class="send-button">
      <img src="{{ asset('public/images/send-black.svg') }}" alt="">
    </button>
  </div>
</div>


	<!-- end: page -->




  <script type="text/javascript">
    $(document).ready(function(){
        $('#saveandclose').click(function(){ $('#saveandclosevalue').val('close'); });
        // setTimeout(() => { $('#close_alert').trigger('click'); }, 5000);
    });
    new WOW().init();
            $(function () {
                $('#datetimepicker1').datetimepicker();
            });

      $(window).on ('load', function (){
        $('#loader').delay(100).fadeOut('slow');
        $('#loader-wrapper').delay(500).fadeOut('slow');
      });

      function openNav() {
        document.getElementById("mySidenav").style.right = "0px";
        document.getElementById("main").style.marginRight = "350px";
        $('.chat-button').css('display','none');
      }

      function closeNav() {
        document.getElementById("mySidenav").style.right = "-350px";
        document.getElementById("main").style.marginRight= "0";
        $('.chat-button').css('display','flex');
      }

    $(document).ready(function(){
      $('#send').click(function(){ sendChat(); });
      $('#message').keyup(function(event){ if(event.keyCode == 13){ sendChat(); } });
    });
    function sendChat() {
      var token = $('input[name="_token"]').val();
      var application = $('#application').val();
      var sender = $('#sender').val();
      var reciever = $('#reciever').val();
      var message = $('#message').val();
      if(message == ''){
          $('#chatErr').text('empty message');
          setTimeout(function(){ $('#chatSuccess').text(''); $('#chatErr').text(''); }, 5000);
          return false;
      }
      $.ajax({
          url: "{{ url('/maintananceChat') }}",
          type: 'post',
          dataType: 'text',
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          data: {
              application: application,
              sender: sender,
              reciever: reciever,
              message: message
          },
          cache: false,
          success: function(res){
              var response = JSON.parse(res);
              if(response.status == '1'){
                  $('#chatBox').append(`<div class="send-msg"><span class="out-chat"> ${ message } </span> </div>`);
                  $('#chatSuccess').text('Sent');
              } else { $('#chatErr').text('Error sending chat.'); }
              $('#message').val('');
        }
      });
      setTimeout(function(){ $('#chatSuccess').text(''); $('#chatErr').text(''); }, 5000);
    }


  // textarea auto height
  var textarea = document.querySelector('textarea');
  textarea.addEventListener('keydown', autosize);
  function autosize(){
    var el = this;
    setTimeout(function(){
      el.style.cssText = 'height:auto; padding:0';
      // for box-sizing other than "content-box" use:
      // el.style.cssText = '-moz-box-sizing:content-box';
      el.style.cssText = 'height:' + el.scrollHeight + 'px';
    },0);
  }
    </script>
@endsection

<div class="modal fade gallaryMaintanance" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
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
                    @foreach($images as $image)
                    <div class="carousel-item {{ ($i == 1)?'active':'' }}">
                        <img class="d-block w-100" src="{{ asset('public/uploads/job/') }}/{{ $job->uid }}/{{ $image }}" onerror="this.onerror=null;this.src='{{ asset('public/images/slider-default.png') }}';" alt="slide{{ $i++ }}">
                    </div>
                    @endforeach
                      {{-- <div class="carousel-item">
                        <img class="d-block w-100" src="{{ asset('public/images/slider-default.png') }}" alt="Second slide">
                      </div>
                      <div class="carousel-item">
                        <img class="d-block w-100" src="{{ asset('public/images/slider-default.png') }}" alt="Third slide">
                      </div> --}}
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
