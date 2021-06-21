@extends('layouts.app')

@section('content')

<!-- <section class="body-sign">
            <div class="center-sign">
                <a href="/" class="logo float-left">
                    <img src="{{ asset('public/img/logo.png') }}" height="74" alt="Porto Admin" />
                </a>

                <div class="panel card-sign">
                    <div class="card-title-sign mt-3 text-right">
                        <h2 class="title text-uppercase font-weight-bold m-0"><i class="fas fa-user mr-1"></i> Sign In</h2>
                    </div>
                    <div class="card-body">
                         <form method="POST" action="{{ route('login') }}">
                        @csrf
                            <div class="form-group mb-3">
                                <label>Email</label>
                                <div class="input-group">
                                    <input name="email" id="email" type="email" type="text" class="form-control form-control-lg @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus/>
                                    <span class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </span>
                                  @if(Session::has('error'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ Session::get('error') }}</strong>
                                    </span>
                                 @endif
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <div class="clearfix">
                                    <label class="float-left">Password</label>
                                    @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" />
                                    <span class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                    </span>
                                      @if(Session::has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ Session::get('password') }}</strong>
                                    </span>
                                 @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4 text-right ml-auto">
                                    <button type="submit" class="btn btn-primary mt-2">Sign In</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <p class="text-center text-muted mt-3 mb-3">Copyright 2020 Pacific Palms Property. All Rights Reserved.</p>
            </div>
        </section> -->
        <!-- end: page -->

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
        <h5 class="h5 text-center fontweight-700 mb-4">Login</h5>
         <form method="POST" action="{{ route('login') }}">
                        @csrf
          <!-- <div class="form-group inp-rw" id="">
            <label class="inp">
                <input type="text" placeholder="&nbsp;" class="form-control">
                <span class="error">Helper text</span>
                <span class="label">First Name</span>
            </label>
          </div> -->
          <div class="form-group">
            <label class="label">Email</label>
            <input type="email" name="email" id="email" class="form-control form-control-lg  @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus/>
            <!-- <span class="error">Enter Email</span> -->
            @if(Session::has('error'))
            <span class="error">
                {{ Session::get('error') }}
            </span>
          @endif
          </div>
          <div class="form-group">
            <label class="label">Password</label>
              <div class="input-group">
                <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" />
                <!-- <span class="error">Enter Password</span> -->
                 @if(Session::has('password'))
                    <span class="error">
                    {{ Session::get('password') }}
                    </span>
                 @endif
                <div class="input-group-append">
                  <span class="input-group-text viewpass" data-id='password' data-type='text'>
                    <i class="far fa-eye"></i>
                    <!-- <i class="far fa-eye-slash"></i> -->
                  </span>
                </div>
              </div>
          </div>
          <div class="d-flex align-items-center justify-content-end mb-30">

             @if (Route::has('password.request'))
              
                    <a  href="{{ route('password.request') }}" class="colordef fontsize-12 a_hover_black"><i class="fas fa-unlock-alt mr-1"></i>{{ __('Forgot Password?') }}</a>
                @endif
            
          </div>
          <button type="submit" class="btn btn-large">Login</button>
        </form>
      </div>
    </div>


@endsection
