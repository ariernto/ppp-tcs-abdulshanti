@extends('layouts.app')

@section('content')
<!-- start: page -->
      <!--   <section class="body-sign">

            <div class="center-sign">
            	@if (session('status'))
                        <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                    @endif
                <a href="/" class="logo float-left">
                    <img src="{{ asset('public/img/logo.png') }}" height="74" alt="Porto Admin" />
                </a>


                <div class="panel card-sign">
                	 
                    <div class="card-title-sign mt-3 text-right">
                        <h2 class="title text-uppercase font-weight-bold m-0"><i class="fas fa-user mr-1"></i> {{ __('Reset Password') }}</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.email') }}">
                             @csrf
                            <div class="form-group mb-3">
                                <label>Email</label>
                                <div class="input-group">
                                    <input id="email" name="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus/>
                                    <span class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </span>
                                     @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-4 text-right ml-auto">
                                    <button type="submit" class="btn btn-primary mt-2">{{ __('Send Link') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <p class="text-center text-muted mt-3 mb-3">Copyright 2020 Pacific Palms Property. All Rights Reserved.</p>
            </div>
        </section> -->
<div id="loader-wrapper">
      <div id="loader">
        <img src="{{ asset('public/images/loading.gif') }}" alt="" class="loader_img">
      </div>
    </div>
  <!-- /Loader -->
    <div class="login-signup-bg">
      <div class="white-box">
        <div class="text-center">
          <img src="{{ asset('public/images/logo.png') }}" class="login-signup-logo" alt="pacific-palms-property">
        </div>
        @if (session('status'))
                        <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                    @endif
        <h5 class="h5 text-center fontweight-700 mb-4">Forgot Password</h5>
        <p class="fontsize-14 fontweight-500">Just let us know the email address you're using to login into the TCS and we'll send you a link to reset your password.</p>

    <form method="POST" action="{{ route('password.email') }}">
         @csrf
          <div class="form-group mb-30">
            <label class="label">Email</label>
            <input id="email" name="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus/>
            <!-- <span class="error">Enter Email</span> -->

             @error('email')
                <span class="error">
                   {{ $message }}
                </span>
                @enderror
          </div>
          
          <button type="submit" class="btn btn-large">{{ __('Send Link') }}</button>
          <div class="d-flex align-items-center justify-content-center mt-30">
            <a href="{{ route('login') }}" class="fontsize-12 colorblue"><i class="fas fa-arrow-left mr-1"></i>Back to Login</a>
          </div>
        </form>
      </div>
    </div>

@endsection
