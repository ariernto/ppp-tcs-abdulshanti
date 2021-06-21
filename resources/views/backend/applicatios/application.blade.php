@extends('layouts.app')
@section('content')

<section class="clear detail-section1" id="main">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
      <form method="post" action="{{ url('/application/change_status') }}">
      @csrf
        <div class="relative d-flex align-items-center mb-30">
           <input type="hidden" name="application_id" value="{{ $application->id }}">
          <span class="fontsize-12 colordef">Properties <i class="fas fa-angle-right ml-1 mr-1"></i>
          <a href="{{ url('applications') }}"><span class="fontsize-12 colordef">Property Application<i class="fas fa-angle-right ml-1 mr-1"></i>
          </span></a>
          <span class="fontsize-12 colorblue">Application Details</span>
          @if (\App\helper\PermissionHelper::permissionCheck('edit_applications'))
          <span class="chat-button" onclick="openNav()"><img src="{{ asset('public/images/opan-chat-icon.png')}}" class=""> Open Chat</span>
          @endif

        </div>
          @if(session()->has('success'))
			<div class="alert alert-success">
                <a href="#" class="close" id="close_alert" data-dismiss="alert" aria-label="close" style="padding:0px;height:32px;top:0px;">&times;</a>
                <p class="bold mb-0"> Message </p>
				{{ session()->get('success') }}
			</div>
        @endif
        @if(session()->has('error'))
			<div class="alert alert-danger">
                <a href="#" class="close" id="close_alert" data-dismiss="alert" aria-label="close" style="padding:0px;height:32px;top:0px;">&times;</a>
                <p class="bold mb-0"> Message </p>
				{{ session()->get('error') }}
			</div>
		@endif
        <div class="relative mb-30">
          <h6 class="h6 fontweight-700 mb-30"><a href="{{ url('/applications')}}" class="colordef"><i class="fas fa-arrow-left fontsize-14 mr-1"></i></a> Application Details
          </h6>
        </div>
        <div class="white-box mb-30">
            <div class="main-contant">
                <div class="relative">
                    <div class="d-flex mb-4">
                        <span class="detil-property">Property</span>
                        <span class="detil-value">{{ $application->hasProperty->headline }}
                        </span>
                    </div>
                    <div class="d-flex mb-4">
                        <span class="detil-property">Address
                        </span>
                        <span class="detil-value"> @php $address = json_decode($application->hasProperty->address); @endphp
                                {{ $address->street_number . ' ' . $address->street_name . ' ' . $address->suburb . ' ' . $address->state }}
                        </span>
                    </div>
                    <div class="d-flex mb-4">
                        <span class="detil-property">Applicant</span>
                        <span class="detil-value">{{ ($application->hasTenant)?$application->hasTenant->name . ' ' . $application->hasTenant->surname : ''  }} <span class="chips chips-green ml-1">Tenant</span></span>
                    </div>
                    <div class="d-flex mb-4">
                        <span class="detil-property">Applied On
                        </span>
                        <span class="detil-value">{{ date_format(date_create($application->date_applied), 'l, d F Y, h:i A') }}
                        </span>
                    </div>
                    <div class="d-flex mb-4">
                    	  @php
                            $i = 1;
                            $communication = explode(',', $application->communication_method);
                            $call = $email = $app = false;
                            foreach ($communication as $item){
                                if($item != ''){
                                    if ($item == 'call') $call = true;
									if ($item == 'email') $email = true;
									if ($item == 'app') $app = true;
                                }
                            }
                            @endphp
                        <span class="detil-property">Communication</span>
                        <span class="detil-value">
                                <div class="checkbox mt-0 mb-0 display-ib mr-30 disabled">
                                <label class="fontsize-12 colordef">
                                  <input type="checkbox"  value="email" {{ ($email)? 'checked': '' }} type="checkbox" name="for[]">
                                  <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                  Email
                                </label>
                            </div>
                             <div class="checkbox mt-0 mb-0 display-ib mr-30 disabled">
                                <label class="fontsize-12 colordef">
                                  <input value="call" type="checkbox" name="for[]" {{ ($call)? 'checked': '' }}>
                                  <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                  Phone
                                </label>
                            </div>

                             <div class="checkbox mt-0 mb-0 display-ib mr-30 disabled">
                                <label class="fontsize-12 colordef">
                                  <input id="App" value="app" {{ ($app)? 'checked': '' }} type="checkbox" name="for[]">
                                  <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                  App
                                </label>
                            </div>

                        </span>
                    </div>
                </div>

            </div>
            <div class="right-contant">
                <div class="form-group inp-rw" id="">
                    <div class="btn-group multi_sigle_select inp_select open">
                        <label class="label mb-1">Assigned Agent
                        </label>
                        <button data-toggle="dropdown" disabled class="btn btn-default dropdown-toggle mss_sl_btn" aria-expanded="true">{{ $application->assignedAgent->first_name . ' ' . $application->assignedAgent->last_name }}</button>
                    </div>
                </div>
                <div class="form-group inp-rw" id="">
                  <div class="btn-group multi_sigle_select inp_select open">
                      <label class="label mb-1">Application Status
                    </label>
                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle mss_sl_btn" aria-expanded="true">{{ ucwords(str_replace("_", " ", $application->approve_status)) }}</button>
                        @if (\App\helper\PermissionHelper::permissionCheck('edit_applications'))
                        <ul class="dropdown-menu mss_sl_btn_dm" x-placement="bottom-start">
                            <li class="radiobox-image">
                                <input type="radio" id="id_14" name="status" class="" value="pending_review" data-idrem="Pending review" @php if($application->approve_status=='pending_review'){ echo 'checked'; } @endphp>
                                <label for="id_14">Pending review</label>
                            </li>
                            {{-- <li class="radiobox-image">
                                <input type="radio" id="id_15" name="status" class="" value="reviewed" data-idrem="Reviewed" @php if($application->approve_status=='reviewed'){ echo 'checked'; } @endphp>
                                <label for="id_15">Reviewed </label>
                            </li> --}}
                             <li class="radiobox-image">
                                <input type="radio" id="idap_15" name="status" class="" value="approved" data-idrem="Approved" @php if($application->approve_status=='approved'){ echo 'checked'; } @endphp>
                                <label for="idap_15">Approved </label>
                            </li>
                             {{-- <li class="radiobox-image">
                                <input type="radio" id="iddc_15" name="status" class="" value="declined" data-idrem="Declined" @php if($application->approve_status=='declined'){ echo 'checked'; } @endphp>
                                <label for="iddc_15">Declined </label>
                            </li> --}}
                             <li class="radiobox-image">
                                <input type="radio" id="idcc_15" name="status" class="" value="cancelled" data-idrem="Cancelled" @php if($application->approve_status=='cancelled'){ echo 'checked'; } @endphp>
                                <label for="idcc_15">Cancelled </label>
                            </li>
                        </ul>
                        @endif
                  </div>
              </div>

            </div>
        </div>
        @if (\App\helper\PermissionHelper::permissionCheck('edit_applications'))
        <button type="submit" class="btn fontsize-12 mr-1">Save</button>
        <input type="hidden" name="saveandclose" id="saveandclosevalue" value="">
        <button type="submit" id="saveandclose" class="btn fontsize-12 mr-1">Save and Close</button>
        @endif

        <a href="{{ url('applications') }}"><button type="button" class="btn btn-black fontsize-12">Close</button></a>

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
      	if(!empty($application->hasTenant->profile_image)){
         $urlImgUrl = asset('public/uploads/users/'.$application->hasTenant->id.'/'.$application->hasTenant->profile_image);
        }
        else{
        $urlImgUrl = asset('public/images/user-icon.svg');
    }
      	@endphp
        <img src="{{ $urlImgUrl }}" style="height: 33px; width: 33px;border-radius: 50%;" alt="">
      </div>
      <span class="display-ib fontweight-500 fontsize-12 colordef">Chat with {{ ($application->hasTenant)?$application->hasTenant->name . ' ' . $application->hasTenant->surname : ''  }} </span>
    </div>
    <a href="javascript:void(0)" class="" onclick="closeNav()">&times;</a>
  </div>
  <div class="chat-box" id="chatBox">
  	    @if (count($application_message) > 0)
                    @foreach ($application_message as $chat)
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

   <input type="hidden" name="application" id="application" value="{{ $application->id }}">
	<input type="hidden" name="sender" id="sender" value="{{ auth()->user()->agent_id }}">
	<input type="hidden" name="reciever" id="reciever" value="{{ $application->hasTenant->id }}">
    <textarea name="message" id="message" class="msg-type" placeholder="Type your message here"></textarea>
    <div id="chatErr" class="text-danger"></div>
   <div id="chatSuccess" class="text-success"></div>
    <button type="button" id="send" class="send-button">
      <img src="{{ asset('public/images/send-black.svg') }}" alt="">
    </button>
  </div>


</div>
  <script>
      $(document).ready(function(){
        $('#saveandclose').click(function(){ $('#saveandclosevalue').val('close'); });
        // setTimeout(() => { $('#close_alert').trigger('click'); }, 5000);
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
    $('#send').click(function(){
    alert('sdf'); sendChat(); });
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
        url: "{{ url('/applicationChat') }}",
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
