@extends('layouts.app')

@section('content')
 <!-- Loader -->
    <div id="loader-wrapper">
      <div id="loader">
        <img src="{{ asset('public/images/loading.gif') }}" alt="" class="loader_img">
      </div>
    </div>
  <!-- /Loader -->
    <div class="login-signup-bg">
      <div class="white-box">
        
        <img src="{{ asset('public/images/checked-green.png') }}" alt="" class="checked-green">
        <h5 class="h5 text-center fontweight-700 mb-30">Check your email
        </h5>
        <p class="fontsize-14 fontweight-500">We've just send you a link to reset your password at <a href="JavaScript:Void(0);" class="colorblue ">{{ $_GET['email']}}</a></a></p>
        
          <div class="d-flex align-items-center justify-content-center mt-30">
            <a href="{{ route('login') }}" class="fontsize-12 colorblue"><i class="fas fa-arrow-left mr-1"></i>Back to Login</a>
          </div>

      </div>
    </div>

 @endsection