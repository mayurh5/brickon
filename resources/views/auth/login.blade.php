@extends('layouts.fullLayoutMaster')
{{-- title --}}

@section('title','Login')

{{-- page scripts --}}

@section('page-styles')
  <link rel="stylesheet" type="text/css" href="{{asset('css/pages/authentication.css')}}">
@endsection

@section('content')
<!-- login page start -->
<section id="auth-login" class="row flexbox-container">
  <div class="col-xl-4 col-11">
    <div class="card bg-authentication mb-0">
      <div class="row m-0">
        <!-- left section-login -->
        <div class="col-12 px-0">
          <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
            <div class="text-center mt-4">
              <img class="logo" style="width: 50%;" src="{{asset('images/logo/final-logo.png')}}">
            </div>
            <div class="card-body">

              {{-- form  --}}
              <form method="POST" action="{{ route('login') }}" id="login-form">
                @csrf
                <div class="form-group mb-50">
                  <label class="text-bold-600" for="user_name">User Name</label>
                  <input id="user_name" type="text" name="user_name" class="form-control @error('user_name') is-invalid @enderror" value="{{ old('user_name') }}"  autocomplete="user_name" autofocus placeholder="User Name" required>
                  @error('user_name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label class="text-bold-600" for="password">Password</label>
                  <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" autocomplete="current-password" placeholder="Password" required>
                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group d-flex flex-md-row flex-column justify-content-between align-items-center">

                  <div class="float-right"><a href="#" class="card-link"><small>Forgot Password?</small></a></div>

                </div>

                <button id="loginFrmBtn" class="btn btn-primary glow w-100 position-relative">Login
                  <i id="icon-arrow" class="bx bx-right-arrow-alt"></i>
                </button>
              </form>

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
<!-- login page ends -->
@endsection

{{-- page scripts --}}
@section('page-scripts')
  @include('scripts.login_js')
@endsection
