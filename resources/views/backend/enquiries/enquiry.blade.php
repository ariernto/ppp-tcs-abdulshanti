@extends('layouts.app')
@section('content')

  <section class="clear detail-section1" id="main">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
      <form method="post" action="{{ url('/enquiryUpdate') }}">  @csrf
        <div class="relative d-flex align-items-center mb-30">
          <input type="hidden" name="enqId" value="{{ $enquiry->id }}">
          <span class="fontsize-12 colordef">Properties <i class="fas fa-angle-right ml-1 mr-1"></i>
          <a href="{{ url('/enquiries') }}"><span class="fontsize-12 colordef">Property Enquiry<i class="fas fa-angle-right ml-1 mr-1"></i>
          </span></a>
          <span class="fontsize-12 colorblue">Enquiry Details        </span>
          @if (\App\helper\PermissionHelper::permissionCheck('edit_enquiries'))
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
        <div class="relative mb-30">
          <h6 class="h6 fontweight-700 mb-30"><a href="{{ url('/enquiries') }}" class="colordef"><i class="fas fa-arrow-left fontsize-14 mr-1"></i></a> Enquiry Details</h6>
        </div>
        <div class="white-box mb-30">
            <div class="alert-type-box"><img src="{{ asset('public/images/info-icon.svg') }}">To respond to this enquiry and any of its threads, use the chat window located to the right.</div>
            <div class="main-contant">
                <div class="relative">
                    <div class="d-flex mb-3">
                        <span class="display-ib colordef fontsize-12 fontweight-500 mr-4">Subject</span>
                        <span class="display-ib colordef fontsize-12 ">{{ $enquiry->subjects }}</span>
                    </div>
                    <div class="gray-box-italic mb-30">
                        <span>{{ $enquiry->message }}</span>
                    </div>
                    <div class="d-flex mb-4">
                        <span class="detil-property">Lodged By</span>
                        <span class="detil-value">{{ ($enquiry->hasTenant)?$enquiry->hasTenant->name . ' ' . $enquiry->hasTenant->surname : ''  }} <span class="chips chips-gray ml-1">Prospect</span></span>
                     </div>
                     <div class="d-flex mb-4">
                      <span class="detil-property">Lodged On</span>
                      <span class="detil-value">{{ date('l, d F Y h:i A',strtotime($enquiry->created_at))}}</span>
                   </div>
                   <div class="devider mb-4"></div>
                   @php if($enquiry->hasProperty){ @endphp
                   <div class="d-flex mb-4">
                        <span class="detil-property">Property</span>
                        <span class="detil-value colorblue" style="color:#4A90E2;">
                            <a target="_blank" href="{{ url('/property') }}/{{ $enquiry->hasProperty->item_id }}">
                                {{ ($enquiry->hasProperty)?$enquiry->hasProperty->headline: '' }}
                            </a>

                        </span>
                    </div>
                    <div class="d-flex mb-4">
                        <span class="detil-property">Address
                        </span>
                        <span class="detil-value">   @php
                      if ($enquiry->hasProperty){
                        $address = json_decode($enquiry->hasProperty->address);
                        $outadd = $address->street_number . ' ' . $address->street_name . ' ' . $address->suburb . ' ' . $address->state;
                      } else { $outadd = ''; }
                                            @endphp

                                            {{ $outadd }}
                        </span>
                    </div>
                    <div class="d-flex mb-4">
                        <span class="detil-property">Price
                        </span>
                        <span class="detil-value">{{ ($enquiry->hasProperty)?$enquiry->hasProperty->price_text:'' }}</span>
                    </div>
                  @php } @endphp
                </div>

            </div>
            <div class="right-contant">
                <div class="form-group inp-rw" id="">
                    <div class="btn-group multi_sigle_select inp_select open">
                        <label class="label mb-1">Assigned Agent
                        </label>
                        <button data-toggle="dropdown" disabled class="btn btn-default dropdown-toggle mss_sl_btn" aria-expanded="true">{{ ($enquiry->assignedAgent)?$enquiry->assignedAgent->first_name . ' ' . $enquiry->assignedAgent->last_name: '' }}</button>
                        <!-- <ul class="dropdown-menu mss_sl_btn_dm" x-placement="bottom-start">
                            <li class="radiobox-image">
                                <input type="radio" id="id_20" name="Assigned" class="" value="Choose" data-idrem="Availability">
                                <label for="id_20">Markus Teller
                                </label>
                            </li>
                            <li class="radiobox-image">
                                <input type="radio" id="id_15" name="Assigned" class="" value="Option" data-idrem="Option">
                                <label for="id_15">Option </label>
                            </li>
                        </ul>  -->
                    </div>
                </div>
                <div class="form-group inp-rw" id="">
                  <div class="btn-group multi_sigle_select inp_select open">
                      <label class="label mb-1">Enquiry Status </label>
                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle mss_sl_btn" aria-expanded="true">{{ ($enquiry->status=='active')?'open':'close' }}</button>
                    @if (\App\helper\PermissionHelper::permissionCheck('edit_enquiries'))
                    <ul class="dropdown-menu mss_sl_btn_dm" x-placement="bottom-start">
                        <li class="radiobox-image">
                            <input type="radio" id="id_14" name="status" class="" value="active" data-idrem="Open" @php if($enquiry->status=='active'){ echo 'checked'; } @endphp>
                            <label for="id_14">Open</label>
                        </li>
                        <li class="radiobox-image">
                            <input type="radio" id="id_15" name="status" class="" value="cancel" data-idrem="Close" @php if($enquiry->status=='cancel'){ echo 'checked'; } @endphp>
                            <label for="id_15">Close </label>
                        </li>
                    </ul>
                    @endif
                  </div>
              </div>
            </div>
        </div>
        @if (\App\helper\PermissionHelper::permissionCheck('edit_enquiries'))
        <button type="submit" class="btn fontsize-12 mr-1">Save</button>
        <input type="hidden" name="saveandclose" id="saveandclosevalue" value="">
        <button type="submit" id="saveandclose" class="btn fontsize-12 mr-1">Save and Close</button>
        @endif
        <a href="{{ url('/enquiries') }}"><button type="button" class="btn btn-black fontsize-12">Close</button></a>
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
        if(!empty($enquiry->hasTenant->profile_image)){
         $urlImgUrl = asset('public/uploads/users/'.$enquiry->hasTenant->id.'/'.$enquiry->hasTenant->profile_image);
        }
        else{
        $urlImgUrl = asset('public/images/user-icon.svg');
    }
        @endphp
        <img src="{{ $urlImgUrl }}" style="height: 33px; width: 33px;border-radius: 50%;" alt="">
      </div>
      <span class="display-ib fontweight-500 fontsize-12 colordef">Chat with {{ ($enquiry->hasTenant)?$enquiry->hasTenant->name . ' ' . $enquiry->hasTenant->surname : ''  }} </span>
    </div>
    <a href="javascript:void(0)" class="" onclick="closeNav()">&times;</a>
  </div>
  <div class="chat-box" id="chatBox">
        @if (count($enquiry_message) > 0)
                    @foreach ($enquiry_message as $chat)
                    @if ($chat->sender_id == auth()->user()->agent_id)

                      <div class="send-msg">
                        <span class="out-chat">{{ $chat->message }}</span>
                        <span class="chat-date-time">{{ date_format(date_create($chat->created_at), 'd M Y,, h:i: A') }}</span>

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
   <input type="hidden" name="application" id="application" value="{{ $enquiry->id }}">
  <input type="hidden" name="sender" id="sender" value="{{ auth()->user()->agent_id }}">
  <input type="hidden" name="reciever" id="reciever" value="{{ $enquiry->hasTenant->id }}">
  <textarea  name="message" id="message" class="msg-type" placeholder="Type your message here"></textarea>
    <div id="chatErr" class="text-danger"></div>
   <div id="chatSuccess" class="text-success"></div>
    <button type="button" id="send" class="send-button">
      <img src="{{ asset('public/images/send-black.svg') }}" alt="">
    </button>
  </div>
</div>



  <script type="text/javascript">
    $(document).ready(function(){
        $('#saveandclose').click(function(){ $('#saveandclosevalue').val('close'); });

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
      $('#cancel').click(function(){ window.location.replace("{{ url('/enquiries') }}"); });
      $('#save').click(function(){
        var enqStatus = $('#enqStatus').val();
        var enqId = "{{ $enquiry->id }}";
        $.ajax({
            url: "{{ url('/enquiryUpdate') }}",
            type: 'post',
            dataType: 'text',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { enqStatus: enqStatus, enqId: enqId },
            cache: false,
            success: function(res){
                var response = JSON.parse(res);
                if(response.status == '1'){
                    $('#success').text('Status updated successfully.').css('display', '');
                    $('#error').text('').css('display', 'none');
                } else {
                    $('#error').text('There is an error updating status.').css('display', '');
                    $('#success').text('').css('display', 'none');
                }
                setTimeout(function(){
                    $('#error').text('').css('display', 'none');
                    $('#success').text('').css('display', 'none');
                }, 5000);
            }
        });
      });
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
          url: "{{ url('/enquiryChat') }}",
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
