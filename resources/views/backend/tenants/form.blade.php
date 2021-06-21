@extends('layouts.app')
@section('content')
  <section class="new-tenant">
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <form action="" id="newTanentForm" method="post">
              <div class="white-box">
                <div class="d-flex wizard">
                    <div class="p-3 left-tabs-option">
                      {{--  <a href="JavaScript:Void(0);" class="d-block mb-30"><img src="{{ asset('public/images/logo.png') }}" alt="" class="vertical-tab-logo"></a>  --}}
                      <h6 class="h6 colordef fontweight-700 mb-30">{{ (Request::segment(2) == 'edit')?'Edit':'New' }} Tenant</h6>
                      <ul class="nav nav-pills flex-column " id="myTab" role="tablist">
                        <li role="presentation" class="active"> <a href="#step1" id="steps1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true" class="vertical-tab active"> <span class="dot"></span> 1. Personal Details </a> </li>
                        <li role="presentation" class=""> <a href="#step2" id="steps2" data-toggle="tab" aria-controls="step2" role="tab" aria-expanded="false" class="vertical-tab"> <span class="dot"></span> 2. Employment Detail </a> </li>
                        <li role="presentation" class=""> <a href="#step3" id="steps3" data-toggle="tab" aria-controls="step3" role="tab" aria-expanded="false" class="vertical-tab"> <span class="dot"></span> 3. Lease Details </a> </li>
                      </ul>
                      <div class="tab-alert"> <img src="images/info-icon.svg" class="d-inlin-block" alt=""> <span class="fontsize-12"> All the fields are required unless marked as <i>(option)</i> </span> </div>
                    </div>
                        @csrf
                        <div class="tab-content right-tab-option" id="main_form">
                            <a href="{{ url()->previous() }}" class="color888 fontsize-12 a_hover_888 cancel-btn">Cancel <img src="{{ asset('public/images/crose-icon1.svg') }}" class="crose-icon" alt=""></a>
                            <div class="tab-pane fade show active" role="tabpanel" id="step1">
                                <span class="fontsize-14">Step 1 of 3</span>
                                <h5 class="fontsize-20 colorblue fontweight-500 mb-30">Personal Details</h5>
                                    <div class="form-group">
                                        <label id="first_name_err" class="label">First Name</label>
                                        <input type="text" id="first_name" name="first_name" class="form-control width260" value="{{ (isset($application) && $application->hasTenant != null)?$application->hasTenant->name:Request::old('first_name') }}" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label id="last_name_err" class="label">Last Name</label>
                                        <input type="text" id="last_name" name="last_name" class="form-control width260" value="{{ (isset($application) && $application->hasTenant != null)?$application->hasTenant->surname:Request::old('last_name') }}" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label class="label" id="address_err">Address</label>
                                        <textarea type="text" id="address" name="address" class="form-control width320" placeholder="">{{ (isset($application) && $application->hasTenant != null)?$application->hasTenant->address:Request::old('address')}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="label" id="email_err">Email</label>
                                        <input type="text" id="email" name="email" class="form-control width260" value="{{ (isset($application) && $application->hasTenant != null)?$application->hasTenant->email:Request::old('email') }}" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label id="mobile_err" class="label">Mobile Number</label>
                                        <input type="text" id="mobile" name="mobile" class="form-control width260" value="{{ (isset($application) && $application->hasTenant != null)?$application->hasTenant->mobile:Request::old('mobile') }}" placeholder="">
                                    </div>
                                    <div class="form-group mb-30">
                                        <label class="label" id="phone_err">Phone Number </label>
                                        <input type="text" id="phone" name="phone" class="form-control width260" value="{{ (isset($application) && $application->hasTenant != null)?$application->hasTenant->phone:Request::old('phone') }}" placeholder="">
                                    </div>
                                    <button type="button" id="stepOne" class="btn next-step">Next Step <img src="{{ asset('public/images/white-arrow.svg') }}" alt=""></button>
                                </div>
                                <div class="tab-pane" role="tabpanel" id="step2">
                                    <span class="fontsize-14">Step 2 of 3</span>
                                    <h5 class="fontsize-20 colorblue fontweight-500 mb-30">Employment Details</h5>
                                    <div class="form-group inp-rw" id="">
                                        <div class="btn-group multi_sigle_select inp_select open">
                                            <label class="label mb-1 d-block" id="profession_err">Profession </label>
                                            <input type="text" id="profession" name="profession" value="{{ (isset($application) && $application->hasEmployeement != null)?$application->hasEmployeement->profession:Request::old('profession') }}" class="form-control width260" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="label" id="employeer_err">Employer</label>
                                        <input type="text" id="employeer" name="employeer" value="{{ (isset($application) && $application->hasEmployeement != null)?$application->hasEmployeement->employeer:Request::old('employeer') }}" class="form-control width260" placeholder="">
                                    </div>
                                    <div class="form-group inp-rw" id="">
                                        <div class="btn-group multi_sigle_select inp_select open">
                                            <label id="position_err" class="label mb-1 d-block">Position</label>
                                            <input type="text" id="position" name="position" value="{{ (isset($application) && $application->hasEmployeement != null)?$application->hasEmployeement->position:Request::old('position') }}" class="form-control width260" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="label" id="employedon_err">Employed On</label>
                                        <span class="after-datepicker-icon" ></span>
                                        <input type="text" id="employedon" name="employedon" autocomplete="employedon2" value="{{ (isset($application) && $application->hasEmployeement != null)?$application->hasEmployeement->employed_on:Request::old('employedon') }}" class="form-control date-picker width160" placeholder="" id="datepicker1">
                                    </div>
                                    <div class="form-group ">
                                        <label class="label" id="employmentDue_err">Employment Due</label>
                                        <span class="after-datepicker-icon"></span>
                                        <input type="text" id="employmentDue" name="employmentDue" autocomplete="employmentDue2" value="{{ (isset($application) && $application->hasEmployeement != null)?$application->hasEmployeement->employment_due:Request::old('employmentDue') }}" class="form-control date-picker width160" placeholder="" id="datepicker2">
                                    </div>
                                    <div class="form-group mb-30">
                                        <label class="label" id="employerAddress_err">Employer Address</label>
                                        <textarea type="text" id="employerAddress" name="employerAddress" class="form-control width320" placeholder="">{{ (isset($application) && $application->hasEmployeement != null)?$application->hasEmployeement->employer_address:Request::old('employerAddress') }}</textarea>
                                    </div>
                                    <button type="button" id="backTo1" class="back-btn"> <img src="{{ asset('public/images/back-arrow.svg') }}"> </button>
                                    <button type="button" id="stepTwo" class="btn next-step">Next Step <img src="{{ asset('public/images/white-arrow.svg') }}" alt=""></button>
                                </div>
                                <div class="tab-pane" role="tabpanel" id="step3">
                                    <span class="fontsize-14">Step 3 of 3</span>
                                    <h5 class="fontsize-20 colorblue fontweight-500 mb-30">Lease Details</h5>
                                    <div class="form-group inp-rw" id="">
                                        <div class="btn-group multi_sigle_select inp_select open">
                                            <label id="property_err" class="label mb-1 d-block">Properties </label>
                                            @if (Request::old('property'))
                                            @foreach ($properties as $property)
                                            @if (Request::old('property') == $property->item_id)
                                            <button id="property" data-toggle="dropdown" class="btn btn-default dropdown-toggle mss_sl_btn " aria-expanded="true">{{ $property->headline }} </button>
                                            @endif
                                            @endforeach
                                            @else
                                            <button id="property" data-toggle="dropdown" class="btn btn-default dropdown-toggle mss_sl_btn " aria-expanded="true">{{ (isset($property))?$property->headline:'Choose property' }} </button>
                                            @endif
                                            <ul class="dropdown-menu mss_sl_btn_dm overflow-fit" x-placement="bottom-start">
                                                <li class="radiobox-image">
                                                    <input type="radio" id="id_0" name="property" class="prop" value="" data-idrem="">
                                                    <label for="id_0">  Choose property</label>
                                                </li>
                                                @foreach ($properties as $property)
                                                <li class="radiobox-image">
                                                    <input type="radio" id="id_{{ $property->id }}" name="property" class="prop" value="{{ $property->item_id }}" {{ (isset($application) && $property->item_id == $application->property_id)?'checked':(Request::old('property') == $property->item_id)?'checked':'' }} data-idrem="{{ $property->headline }}">
                                                    <label for="id_{{ $property->id }}">{{ $property->headline }}</label>
                                                </li>
                                                @endforeach
                                            </ul>
                                            <span id="property_err">@error('property'){{ $message }}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="form-group inp-rw" id="">
                                        <div class="btn-group multi_sigle_select inp_select open">
                                            <label id="agentBtn_err" class="label mb-1 d-block">Agent </label>
                                            <button data-toggle="dropdown" id="agentBtn" class="btn btn-default dropdown-toggle mss_sl_btn " aria-expanded="true">{{ (isset($application))?$application->assignedAgent->first_name . ' ' . $application->assignedAgent->last_name :'Choose agent' }}</button>
                                            <ul id="agentList" class="dropdown-menu mss_sl_btn_dm overflow-fit" x-placement="bottom-start">
                                                @if (isset($application))
                                                <li class="radiobox-image">
                                                    <input type="radio" id="ida_0" name="agent" class="agent" value="{{ $application->assignedAgent->agent_id }}" checked data-idrem="">
                                                    <label for="ida_0">{{ $application->assignedAgent->first_name }} {{ $application->assignedAgent->last_name }}</label>
                                                </li>
                                                @else
                                                <li class="radiobox-image">
                                                    <input type="radio" id="ida_0" name="agent" class="agent" value="" data-idrem="">
                                                    <label for="ida_0">Choose agent</label>
                                                </li>
                                                @endif
                                            </ul>
                                            <span id="agent_err">@error('agent'){{ $message }}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="label" id="appliedOn_err">Applied On</label>
                                        <span class="after-datepicker-icon"></span>
                                        <input type="text" id="appliedOn" autocomplete="appliedOn2" name="appliedOn" value="{{ (isset($application))?Carbon\Carbon::parse($application->date_applied)->format('Y-m-d'):Request::old('appliedOn') }}" class="form-control date-picker width160" placeholder="" id="datepicker">
                                    </div>
                                    <div class="form-group ">
                                        <label class="label" id="leasedOn_err">Leased On</label>
                                        <span class="after-datepicker-icon"></span>
                                        <input type="text" id="leasedOn" autocomplete="leasedOn2" name="leasedOn" value="{{ (isset($application))?Carbon\Carbon::parse($application->date_leased)->format('Y-m-d'):Request::old('leasedOn') }}" class="form-control date-picker width160" placeholder="" id="datepicker4">
                                    </div>
                                    <div class="form-group ">
                                        <label class="label" id="leasedDue_err">Leased Due </label>
                                        <span class="after-datepicker-icon"></span>
                                        <input type="text" id="leasedDue" autocomplete="leasedDue2" name="leasedDue" value="{{ (isset($application))?Carbon\Carbon::parse($application->lease_due)->format('Y-m-d'):Request::old('leasedDue') }}" class="form-control date-picker width160" placeholder="" id="datepicker3">
                                    </div>
                                    <div class="form-group mb-30">
                                        <label class="label d-block" id="deposit_err">Security Deposit</label>
                                        <input type="text" id="deposit" onkeypress="return isNumber(event)" name="deposit" value="{{ (isset($application))?$application->security_diposit:Request::old('deposit') }}" class="form-control d-inline-block width160" placeholder="">
                                        <span class="fontsize-12 colordef d-inline-block ml-2">PGK</span>
                                    </div>
                                    <button type="button" id="backTo2" class="back-btn"><img src="{{ asset('public/images/back-arrow.svg') }}"></button>

                                    @if (\App\helper\PermissionHelper::permissionCheck('edit_client') || \App\helper\PermissionHelper::permissionCheck('add_client'))
                                    <button type="button" id="finish" class="btn next-step">Finish and Save Tenant <img src="{{ asset('public/images/white-arrow.svg') }}" alt=""></button>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </section>
  <script>
    $('#employedon').datepicker({ uiLibrary: 'bootstrap4', format:'yyyy-mm-dd', maxDate: new Date() });
    $('#employmentDue').datepicker({ uiLibrary: 'bootstrap4', format:'yyyy-mm-dd' });
    $('#appliedOn').datepicker({ uiLibrary: 'bootstrap4', format:'yyyy-mm-dd', maxDate: new Date() });
    $('#leasedOn').datepicker({ uiLibrary: 'bootstrap4', format:'yyyy-mm-dd', maxDate: new Date() });
    $('#leasedDue').datepicker({ uiLibrary: 'bootstrap4', format:'yyyy-mm-dd' });
    $(document).ready(function(){
        $('#backTo1').click(function(){ $('#steps1').trigger('click'); });
        $('#backTo2').click(function(){ $('#steps2').trigger('click'); });
        $('#stepOne').click(function(){
            if($('#first_name').val() == "") { $('#first_name').css("border-color", 'red'); $('#first_name_err').css("color", 'red');
            } else { $('#first_name').css("border-color","#ECECEC"); $('#first_name_err').css("color","#444444"); }
            if($('#last_name').val() == "") { $('#last_name').css("border-color", 'red'); $('#last_name_err').css("color", 'red');
            } else { $('#last_name').css("border-color","#ECECEC"); $('#last_name_err').css("color","#444444"); }
            if($('#address').val() == "") { $('#address').css("border-color", 'red'); $('#address_err').css("border-color", 'red');
            } else { $('#address').css("border-color","#ECECEC"); $('#address_err').css("color","#444444"); }
            if($('#email').val() == "") { $('#email').css("border-color", 'red'); $('#email_err').css("color", 'red');
            } else { $('#email').css("border-color","#ECECEC"); $('#email_err').css("color","#444444"); }
            if($('#mobile').val() == "") { $('#mobile').css("border-color", 'red'); $('#mobile_err').css("color", 'red');
            } else { $('#mobile').css("border-color","#ECECEC"); $('#mobile_err').css("color","#444444"); }
            // if($('#phone').val() == "") { $('#phone').css("border-color", 'red'); } else { $('#phone').css("border-color","#ECECEC"); }
            if ($('#first_name').val() != "" && $('#last_name').val() != "" && $('#address').val() != "" && $('#email').val() != "" && $('#mobile').val() != "") { $('#steps2').trigger('click'); }
        });
        $('#stepTwo').click(function() {
            if($('#profession').val() == "") { $('#profession').css("border-color", 'red'); $('#profession_err').css("color", 'red');
            } else { $('#profession').css("border-color","#ECECEC"); $('#profession_err').css("color","#444444"); }
            if($('#employeer').val() == "") { $('#employeer').css("border-color", 'red'); $('#employeer_err').css("color", 'red');
            } else { $('#employeer').css("border-color","#ECECEC"); $('#employeer_err').css("color","#444444"); }
            if($('#position').val() == "") { $('#position').css("border-color", 'red'); $('#position_err').css("color", 'red');
            } else { $('#position').css("border-color","#ECECEC"); $('#position_err').css("color","#444444"); }
            if($('#employedon').val() == "") { $('#employedon').css("border-color", 'red'); $('#employedon_err').css("color", 'red');
            } else { $('#employedon').css("border-color","#ECECEC"); $('#employedon-err').css("color","#444444"); }
            if($('#employmentDue').val() == "") { $('#employmentDue').css("border-color", 'red'); $('#employmentDue_err').css("color", 'red');
            } else { $('#employmentDue').css("border-color","#ECECEC"); $('#employmentDue_err').css("color","#444444"); }
            if($('#employerAddress').val() == "") { $('#employerAddress').css("border-color", 'red'); $('#employerAddress_err').css("color", 'red');
            } else { $('#employerAddress').css("border-color","#ECECEC"); $('#employerAddress_err').css("color","#444444"); }
            if($('#profession').val() != "" && $('#employeer').val() != "" && $('#position').val() != "" && $('#employedon').val() != "" && $('#employmentDue').val() != "" && $('#employerAddress').val() != "") {
                if($('#first_name').val() == "" || $('#last_name').val() == "" || $('#address').val() == "" || $('#email').val() == "" || $('#mobile').val() == "") {
                    if($('#first_name').val() == "") { $('#first_name').css("border-color", 'red'); $('#first_name_err').css("color", 'red');
                    } else { $('#first_name').css("border-color","#ECECEC"); $('#first_name_err').css("color","#444444"); }
                    if($('#last_name').val() == "") { $('#last_name').css("border-color", 'red'); $('#last_name_err').css("color", 'red');
                    } else { $('#last_name').css("border-color","#ECECEC"); $('#last_name_err').css("color","#444444"); }
                    if($('#address').val() == "") { $('#address').css("border-color", 'red'); $('#address_err').css("border-color", 'red');
                    } else { $('#address').css("border-color","#ECECEC"); $('#address_err').css("color","#444444"); }
                    if($('#email').val() == "") { $('#email').css("border-color", 'red'); $('#email_err').css("color", 'red');
                    } else { $('#email').css("border-color","#ECECEC"); $('#email_err').css("color","#444444"); }
                    if($('#mobile').val() == "") { $('#mobile').css("border-color", 'red'); $('#mobile_err').css("color", 'red');
                    } else { $('#mobile').css("border-color","#ECECEC"); $('#mobile_err').css("color","#444444"); }
                    $('#steps1').trigger('click');
                } else {
                    $('#steps3').trigger('click');
                }
            }
        });
        $('.prop').click(function(){
            var property_id = $(this).val();
            var url = "{{ url('get-agent') }}";
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'text',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: { property_id: property_id },
                cache: false,
                success: function(res){
                    var response = JSON.parse(res);
                    var agents = response.data;
                    var agent = `<li class="radiobox-image">
                        <input type="radio" id="ida_0" name="agent" class="agent" value="" data-idrem="">
                        <label for="ida_0">Choose agent</label>
                    </li>`;
                    for(var i = 0; i < agents.length; i++) {
                        var element = agents[i];
                        agent = agent + `<li class="radiobox-image">
                            <input type="radio" id="ida_${element.id}" name="agent" class="agent" value="${element.agent_id}" data-idrem="${element.first_name} ${element.last_name}">
                            <label for="ida_${element.id}">${element.first_name} ${element.last_name}</label>
                        </li>`;
                    }
                    $('#agentList').html(agent);
                }
            });
        });
        @if (Request::old('property'))
            var property_id = "{{ Request::old('property') }}";
            var url = "{{ url('get-agent') }}";
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'text',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: { property_id: property_id },
                cache: false,
                success: function(res){
                    var response = JSON.parse(res);
                    var agents = response.data;
                    var ChoseAgent = "Choose Agent";
                    var agent = `<li class="radiobox-image">
                        <input type="radio" id="ida_0" name="agent" class="agent" value="" data-idrem="">
                        <label for="ida_0">Choose agent</label>
                    </li>`;
                    for(var i = 0; i < agents.length; i++) {
                        var element = agents[i];
                        if(element.agent_id == "{{ Request::old('agent') }}") {
                            agent = agent + `<li class="radiobox-image">
                                <input type="radio" id="ida_${element.id}" name="agent" class="agent" checked value="${element.agent_id}" data-idrem="${element.first_name} ${element.last_name}">
                                <label for="ida_${element.id}">${element.first_name} ${element.last_name}</label>
                            </li>`;
                            ChoseAgent = element.first_name + " " + element.last_name;
                        } else {
                            agent = agent + `<li class="radiobox-image">
                                <input type="radio" id="ida_${element.id}" name="agent" class="agent" value="${element.agent_id}" data-idrem="${element.first_name} ${element.last_name}">
                                <label for="ida_${element.id}">${element.first_name} ${element.last_name}</label>
                            </li>`;
                        }
                    }
                    $('#agentBtn').text(ChoseAgent);
                    $('#agentList').html(agent);
                }
            });
        @endif
        $('#finish').click(function(){
            let property = false;
            let agent = false;
            $(".prop").each(function() { if (this.checked && this.value != '') { property = true; } });
            $('.agent').each(function() { if (this.checked && this.value != '') { agent = true; } });
            if (agent) { $('#agentBtn').attr('style', "border-color: #ECECEC !important"); $('#agentBtn_err').css("color","#444444");
            } else { $('#agentBtn').attr('style', "border-color: red !important"); $('#agentBtn_err').css("color","red"); }
            if (property) { $('#property').attr('style', "border-color: #ECECEC !important"); $('#property_err').css("color","#444444");
            } else { $('#property').attr('style', "border-color: red !important"); $('#property_err').css("color","red"); }
            if($('#appliedOn').val() == "") { $('#appliedOn').css("border-color", 'red'); $('#appliedOn_err').css("color", 'red');
            } else { $('#appliedOn').css("border-color","#ECECEC"); $('#appliedOn_err').css("color","#444444"); }
            if($('#leasedOn').val() == "") { $('#leasedOn').css("border-color" , 'red'); $('#leasedOn_err').css("color", 'red');
            } else { $('#leasedOn').css("border-color","#ECECEC"); $('#leasedOn_err').css("color","#444444"); }
            if($('#leasedDue').val() == "") { $('#leasedDue').css("border-color", 'red'); $('#leasedDue_err').css("color",  'red');
            } else { $('#leasedDue').css("border-color","#ECECEC"); $('#leasedDue_err').css("color","#444444"); }
            if($('#deposit').val() == "") { $('#deposit').css("border-color", 'red'); $('#deposit_err').css("color", 'red');
            } else { $('#deposit').css("border-color","#ECECEC"); $('#deposit_err').css("color","#444444"); }
            if(property && agent && $('#appliedOn').val() != "" && $('#leasedOn').val() != "" && $('#leasedDue').val() != "" && $('#deposit').val() != "") {
                if($('#first_name').val() == "" || $('#last_name').val() == "" || $('#address').val() == "" || $('#email').val() == "" || $('#mobile').val() == "") {
                    if($('#first_name').val() == "") { $('#first_name').css("border-color", 'red'); $('#first_name_err').css("color", 'red');
                    } else { $('#first_name').css("border-color","#ECECEC"); $('#first_name_err').css("color","#444444"); }
                    if($('#last_name').val() == "") { $('#last_name').css("border-color", 'red'); $('#last_name_err').css("color", 'red');
                    } else { $('#last_name').css("border-color","#ECECEC"); $('#last_name_err').css("color","#444444"); }
                    if($('#address').val() == "") { $('#address').css("border-color", 'red'); $('#address_err').css("border-color", 'red');
                    } else { $('#address').css("border-color","#ECECEC"); $('#address_err').css("color","#444444"); }
                    if($('#email').val() == "") { $('#email').css("border-color", 'red'); $('#email_err').css("color", 'red');
                    } else { $('#email').css("border-color","#ECECEC"); $('#email_err').css("color","#444444"); }
                    if($('#mobile').val() == "") { $('#mobile').css("border-color", 'red'); $('#mobile_err').css("color", 'red');
                    } else { $('#mobile').css("border-color","#ECECEC"); $('#mobile_err').css("color","#444444"); }
                    $('#steps1').trigger('click');
                }
                if($('#profession').val() == "" || $('#employeer').val() == "" || $('#position').val() == "" || $('#employedon').val() == "" || $('#employmentDue').val() == "" || $('#employerAddress').val() == "") {
                    if($('#profession').val() == "") { $('#profession').css("border-color", 'red'); $('#profession_err').css("color", 'red');
                    } else { $('#profession').css("border-color","#ECECEC"); $('#profession_err').css("color","#444444"); }
                    if($('#employeer').val() == "") { $('#employeer').css("border-color", 'red'); $('#employeer_err').css("color", 'red');
                    } else { $('#employeer').css("border-color","#ECECEC"); $('#employeer_err').css("color","#444444"); }
                    if($('#position').val() == "") { $('#position').css("border-color", 'red'); $('#position_err').css("color", 'red');
                    } else { $('#position').css("border-color","#ECECEC"); $('#position_err').css("color","#444444"); }
                    if($('#employedon').val() == "") { $('#employedon').css("border-color", 'red'); $('#employedon_err').css("color", 'red');
                    } else { $('#employedon').css("border-color","#ECECEC"); $('#employedon-err').css("color","#444444"); }
                    if($('#employmentDue').val() == "") { $('#employmentDue').css("border-color", 'red'); $('#employmentDue_err').css("color", 'red');
                    } else { $('#employmentDue').css("border-color","#ECECEC"); $('#employmentDue_err').css("color","#444444"); }
                    if($('#employerAddress').val() == "") { $('#employerAddress').css("border-color", 'red'); $('#employerAddress_err').css("color", 'red');
                    } else { $('#employerAddress').css("border-color","#ECECEC"); $('#employerAddress_err').css("color","#444444"); }
                    $('#steps2').trigger('click');
                }
                if(
                    $('#first_name').val() != "" &&
                    $('#last_name').val() != "" &&
                    $('#address').val() != "" &&
                    $('#email').val() != "" &&
                    $('#mobile').val() != "" &&
                    $('#profession').val() != "" &&
                    $('#employeer').val() != "" &&
                    $('#position').val() != "" &&
                    $('#employedon').val() != "" &&
                    $('#employmentDue').val() != "" &&
                    $('#employerAddress').val() != "" &&
                    $('#appliedOn').val() != "" &&
                    $('#leasedOn').val() != "" &&
                    $('#leasedDue').val() != "" &&
                    $('#deposit').val() != ""
                ) { $('#newTanentForm').submit(); }
            }
        });
    });
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) { return false; } return true;
    }
  </script>
  @endsection
