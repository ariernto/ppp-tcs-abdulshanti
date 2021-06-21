@extends('layouts.app')

@section('content')
<!-- start: page -->
       <!--  <section class="body-sign">

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
                        <form method="POST" action="{{ route('password.update') }}">
                             @csrf

                        <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group mb-3">
                               
                                <div class="input-group">
                                    <input id="email" name="email" type="hidden" class="form-control form-control-lg @error('email') is-invalid @enderror"  value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus/>
                                    
                                    
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label>Password</label>
                                <div class="input-group">
                                    <input id="password" name="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" required autocomplete="new-password" autofocus/>
                                   <span class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                    </span>
                                     @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                               <div class="form-group mb-3">
                                <label>Confirm Password</label>
                                <div class="input-group">
                                    <input id="password-confirm" name="password_confirmation" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" required autocomplete="new-password"/>
                                   <span class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                    </span>
                                    
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-4 text-right ml-auto">
                                    <button type="submit" class="btn btn-primary mt-2">{{ __('Update password') }}</button>
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
        <div class="text-center mb-30">
          <img src="{{ asset('public/images/logo.png') }}" class="login-signup-logo" alt="pacific-palms-property">
             @if (session('status'))
                <div class="alert alert-success" role="alert">{{ session('status') }}</div>
            @endif
          <h5 class="h5 text-center fontweight-700 mb-30">Reset Password</h5>
          <p class="fontsize-14 fontweight-500 mb-2">Let's set up your new password for</p>
          <span class="fontsize-20 colorblue fontweight-500">{{ $email ?? old('email') }}</span>
        </div>        
     <form method="POST" action="{{ route('password.update') }}">
          @csrf
          <input type="hidden" name="token" value="{{ $token }}">
          <input id="email" name="email" type="hidden"   value="{{ $email ?? old('email') }}"/>
          <div class="form-group">
            <label class="label">New Password</label>
              <div class="input-group">
                <input id="password" name="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" required autocomplete="new-password" autofocus/>
                <!-- <span class="error">Enter Password</span> -->
                @error('password')
                <span class="error">
                    {{ $message }}
                </span>
                @enderror
                <div class="input-group-append">
                  <span class="input-group-text viewpass" data-type='text' data-id='password'>
                    <i class="far fa-eye"></i>
                    <!-- <i class="far fa-eye-slash"></i> -->
                  </span>
                </div>
              </div>
          </div>
          <div class="form-group mb-30">
            <label class="label">Confirm New Password</label>
              <div class="input-group">
                <input id="password-confirm" name="password_confirmation" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" required autocomplete="new-password"/>
                <!-- <span class="error">Enter Password</span> -->
                <div class="input-group-append">
                  <span class="input-group-text viewpass" data-type='text' data-id='password-confirm'>
                    <i class="far fa-eye"></i>
                    <!-- <i class="far fa-eye-slash"></i> -->
                  </span>
                </div>
              </div>
          </div>
          <button type="submit" class="btn btn-large">{{ __('Update password') }}</button>
          <!-- <button type="submit" class="btn btn-large">Confirm Password</button> -->
        </form>
      </div>
    </div>
@endsection