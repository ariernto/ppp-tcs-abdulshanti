@extends('layouts.app')
@section('content')

<section class="clear detail-section1" id="main">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
       <form action="{{ url('/inspection/change_status') }}" method="post">
        @csrf
        <input type="hidden" name="inspection_id" value="{{ $inspection->id }}">
        <div class="relative d-flex align-items-center mb-30">
          <span class="fontsize-12 colordef">Properties <i class="fas fa-angle-right ml-1 mr-1"></i>
          <a href="{{ url('/inspections') }}"><span class="fontsize-12 colordef">Property Inspections<i class="fas fa-angle-right ml-1 mr-1"></i>
          </span></a>
          <span class="fontsize-12 colorblue">Inspection Details</span>
          @if (\App\helper\PermissionHelper::permissionCheck('delete_inspection'))
          <span data-id = "{{ $inspection->id }}" class="delete delete-button"> <i class="far fa-trash-alt"></i></span>
          @endif
          @if (\App\helper\PermissionHelper::permissionCheck('edit_inspection'))
          <span class="chat-button" onclick="openNav()"><img src="{{ asset('public/images/opan-chat-icon.png') }}" class=""> Open Chat</span>
          @endif
        </div>
        @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" id="close_alert" data-dismiss="alert" aria-label="close" style="padding:0px;height:32px;top:0px;">&times;</a>
            <p class="bold mb-0"> Message </p>
            {{ session()->get('success') }}
        </div>
        @endif
        <div class="relative mb-30">
            <h6 class="h6 fontweight-700 mb-30"><a href="{{ url('/inspections') }}" class="colordef"><i class="fas fa-arrow-left fontsize-14 mr-1"></i></a> Inspection Details</h6>

        </div>
        <div class="white-box mb-30">
            <div class="main-contant">
                <div class="relative">
                    <div class="d-flex mb-4">
                        <span class="detil-property">Property</span>
                        <span class="detil-value">{{ $inspection->hasProperty->headline }}
                        </span>
                    </div>
                    <div class="d-flex mb-4">
                        <span class="detil-property">Address
                        </span>
                        <span class="detil-value">
                            @php
                            if(!empty($inspection->hasProperty)){
                                $address = json_decode($inspection->hasProperty->address);
                                $outadd = $address->street_number . ' ' . $address->street_name . ' ' . $address->suburb . ' ' . $address->state;
                            } else { $outadd = ''; }
                            @endphp
                            {{ $outadd }}
                        </span>
                    </div>
                    <div class="d-flex mb-4">
                        <span class="detil-property">Tentative Date(s)</span>
                        <span class="detil-value">
                            @php $dates = explode(',', $inspection->inspect_dates); @endphp
                            @foreach ($dates as $item)
                            <input type="text" placeholder="" value="{{ date_format(date_create($item), 'd F Y h:i a') }}" disabled>
                            @endforeach
                        </span>
                    </div>
                    <div class="d-flex mb-4">
                        <span class="detil-property">Lodged By</span>
                        <span class="detil-value">{{ ($inspection->hasTenant)?$inspection->hasTenant->name . ' ' . $inspection->hasTenant->surname : ''  }}<span class="chips chips-gray ml-1">Prospect</span></span>
                     </div>
                     <div class="d-flex mb-4">
                      <span class="detil-property">Lodged On</span>
                      <span class="detil-value">{{ date_format(date_create($inspection->created_at), 'l, F dS Y, h:iA') }}</span>
                   </div>
                    <div class="d-flex mb-4">
                        <span class="detil-property">Communication</span>
                         @php
                            $i = 1;
                            $communication = explode(',', $inspection->communication_method);
                            $call = $email = $app = false;
                            foreach ($communication as $item){
                                if($item != ''){
                                    if ($item == 'call') { $call = true; }
                                    if ($item == 'email') { $email = true; }
                                    if ($item == 'app') { $app = true;}
                                }
                            }
                            @endphp
                        <span class="detil-value">
                           <div class="checkbox mt-0 mb-0 display-ib mr-30">
                                <label class="fontsize-12 colordef disabled">
                                  <input type="checkbox"  value="email" {{ ($email)? 'checked': '' }} type="checkbox" name="for[]">
                                  <span class="cr"><i class="cr-icon fa fa-check"></i></span> Email
                                </label>
                            </div>
                             <div class="checkbox mt-0 mb-0 display-ib mr-30">
                                <label class="fontsize-12 colordef disabled">
                                  <input value="call" type="checkbox" name="for[]" {{ ($call)? 'checked': '' }}>
                                  <span class="cr"><i class="cr-icon fa fa-check"></i></span> Phone
                                </label>
                            </div>
                             <div class="checkbox mt-0 mb-0 display-ib mr-30">
                                <label class="fontsize-12 colordef disabled">
                                  <input id="App" value="app" {{ ($app)? 'checked': '' }} type="checkbox" name="for[]">
                                  <span class="cr"><i class="cr-icon fa fa-check"></i></span> App
                                </label>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
            <div class="right-contant">
                <div class="form-group inp-rw" id="">
                    <div class="btn-group multi_sigle_select inp_select open">
                        <label class="label mb-1">Assigned Agent</label>
                        <button data-toggle="dropdown" disabled class="btn btn-default dropdown-toggle mss_sl_btn" aria-expanded="true">{{ ($inspection->assignedAgent)?$inspection->assignedAgent->first_name . ' ' . $inspection->assignedAgent->last_name:'' }}</button>
                    </div>
                </div>
                <div class="form-group inp-rw" id="">
                  <div class="btn-group multi_sigle_select inp_select open">
                      <label class="label mb-1">Inspection Status </label>
                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle mss_sl_btn" aria-expanded="true">{{ $inspection->booked_status }}</button>
                      @if (\App\helper\PermissionHelper::permissionCheck('edit_inspection'))
                      <ul class="dropdown-menu mss_sl_btn_dm" x-placement="bottom-start">
                          <li class="radiobox-image">
                            <input type="radio" id="id_13" name="status" class="" value="booked" data-idrem="Booked"
                            @php if($inspection->booked_status=='booked'){ echo 'checked'; }@endphp
                            >
                            <label for="id_13">Booked</label>
                        </li>
                          <li class="radiobox-image">
                              <input type="radio" id="id_14" name="status" class="" value="open" data-idrem="Opan" @php if($inspection->booked_status=='open'){ echo 'checked'; }@endphp>
                              <label for="id_14">Open</label>
                          </li>
                          <li class="radiobox-image">
                              <input type="radio" id="id_15" name="status" class="" value="cancelled" data-idrem="Cancelled"  @php if($inspection->booked_status=='cancelled'){ echo 'checked'; }@endphp>
                              <label for="id_15">Cancelled </label>
                          </li>
                            <li class="radiobox-image">
                              <input type="radio" id="id_151" name="status" class="" value="closed" data-idrem="Closed"  @php if($inspection->booked_status=='closed'){ echo 'checked'; }@endphp>
                              <label for="id_151">Closed</label>
                          </li>
                      </ul>
                      @endif

                  </div>
              </div>
              <div class="form-group inp-rw" id="">
                <label class="label mb-1">Booked Date</label>
                <span class="after-datepicker-icon"></span>
                <input type="text" class="date-picker" style="cursor: pointer" {{ (\App\helper\PermissionHelper::permissionCheck('edit_inspection'))?'':'disabled' }} name="booked_date" placeholder="Choose" value="@php if(!empty($inspection->booked_date) && $inspection->booked_date!='0000-00-00 00:00:00'){ echo date('Y-m-d',strtotime($inspection->booked_date)); }else{ echo date('Y-m-d',strtotime($dates[0])); } @endphp" id="datepicker5" readonly>
              </div>
              <div class="form-group inp-rw" id="">
                @if (\App\helper\PermissionHelper::permissionCheck('edit_inspection'))
                <input id="timepicker1" type="text" class="time-picker"  style="cursor: pointer" name="booked_time" placeholder="Choose" value="@php if(!empty($inspection->booked_date) && $inspection->booked_date!='0000-00-00 00:00:00'){ echo date('H:i:s',strtotime($inspection->booked_date)); }else{ echo date('H:i:s',strtotime($dates[0])); } @endphp" id="booked_time">
                @else
                <input id="" type="text" class="time-picker"  style="cursor: pointer" name="booked_time" placeholder="Choose" value="@php if(!empty($inspection->booked_date) && $inspection->booked_date!='0000-00-00 00:00:00'){ echo date('H:i:s',strtotime($inspection->booked_date)); }else{ echo date('H:i:s',strtotime($dates[0])); } @endphp">
                @endif
             </div>
              <!-- <div class="form-group inp-rw" id="">
                <label class="label mb-1">Booked Time</label>
                <span class="after-datepicker-icon"></span>
                <input type="text" class="date-picker" style="cursor: pointer" name="booked_time" placeholder="Choose" value="@php if(!empty($inspection->booked_date) && $inspection->booked_date!='0000-00-00 00:00:00'){ echo date('H:i:s',strtotime($inspection->booked_date)); }else{ echo date('H:i:s',strtotime($dates[0])); } @endphp" id="booked_time">
              </div> -->
              {{--  <div class="devider"></div>  --}}
            </div>
        </div>
        @if (\App\helper\PermissionHelper::permissionCheck('edit_inspection'))
        <button type="submit" class="btn fontsize-12 mr-1">Save</button>
        <input type="hidden" name="saveandclose" id="saveandclosevalue" value="">
        <button type="submit" id="saveandclose" class="btn fontsize-12 mr-1">Save and Close</button>
        @endif

        <a href="{{ url('/inspections') }}"><button type="button" class="btn btn-black fontsize-12" id="close">Close</button></a>
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
                if(!empty($inspection->hasTenant->profile_image)){
                    $urlImgUrl = asset('public/uploads/users/'.$inspection->hasTenant->id.'/'.$inspection->hasTenant->profile_image);
                } else {
                    $urlImgUrl = asset('public/images/user-icon.svg');
                }
                @endphp
                <img src="{{ $urlImgUrl }}" style="height: 33px; width: 33px;border-radius: 50%;" alt="">
            </div>
        <span class="display-ib fontweight-500 fontsize-12 colordef">Chat with {{ ($inspection->hasTenant)?$inspection->hasTenant->name . ' ' . $inspection->hasTenant->surname : ''  }} </span>
        </div>
        <a href="javascript:void(0)" class="" onclick="closeNav()">&times;</a>
    </div>
    <div class="chat-box" id="chatBox">
        @if (count($inspection_message) > 0)

                    @foreach ($inspection_message as $chat)
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


   <input type="hidden" name="application" id="application" value="{{ $inspection->id }}">
  <input type="hidden" name="sender" id="sender" value="{{ auth()->user()->agent_id }}">
  <input type="hidden" name="reciever" id="reciever" value="{{ $inspection->hasTenant->id }}">
  <textarea  name="message" id="message" class="msg-type" placeholder="Type your message here"></textarea>
    <div id="chatErr" class="text-danger"></div>
   <div id="chatSuccess" class="text-success"></div>
    <button type="button" id="send" class="send-button">
      <img src="{{ asset('public/images/send-black.svg') }}" alt="">
    </button>
  </div>

    </div>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script>
    $(document).ready(function(){
        $('.delete').click(function() {
            var delete_id = $(this).data('id');
            var url = "{{ url('inspection/delete') }}";
            swal({
                title: "WARNING!",
                text: "You are about to delete this inspection",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: url,
                        type: 'post',
                        dataType: 'text',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        data: { delete_id: delete_id },
                        cache: false,
                        success: function(res){
                            window.location = "{{ url('/inspection/delete_message') }}";
                        }
                    });
                }
            });
        });
    });

    $(document).ready(function(){
        $('#saveandclose').click(function(){ $('#saveandclosevalue').val('close'); });
        // setTimeout(() => { $('#close_alert').trigger('click'); }, 5000);
    });
    new WOW().init();
    $('#datepicker5').datepicker({
        uiLibrary: 'bootstrap4',
        format:'yyyy-mm-dd'
    });
    $('#timepicker1').timepicker({
        minuteStep: 1,
        template: 'modal',
        appendWidgetTo: 'body',
        showSeconds: true,
        showMeridian: false,
        defaultTime: false
    });
    $(window).on ('load', function (){
        $('#loader').delay(100).fadeOut('slow');
        $('#loader-wrapper').delay(500).fadeOut('slow');
    });
    function openNav() {
        document.getElementById("mySidenav").style.right = "0px";
        document.getElementById("main").style.marginRight = "350px";
        $('.chat-button').css('display','none');
        $('.delete-button').css('right','0px');
    }
    function closeNav() {
        document.getElementById("mySidenav").style.right = "-350px";
        document.getElementById("main").style.marginRight= "0";
        $('.chat-button').css('display','flex');
        $('.delete-button').css('right','115px');
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
            url: "{{ url('/inspectionChat') }}",
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
      el.style.cssText = 'height:' + el.scrollHeight + 'px';
    },0);
  }
    </script>
@endsection
