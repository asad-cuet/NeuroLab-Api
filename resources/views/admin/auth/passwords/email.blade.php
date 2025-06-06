@extends('admin.layouts.guest')

@section('content')
        <!-- ===============>> account start here <<================= -->
        <div class="auth-page auth-page--signin">
            <div class="auth-page__card">
              <div class="auth-page__card-header">
                <div class="auth-page__logo">
                  <img src="{{asset('assets/images/logo/logo-icon.png')}}" alt="Logo" class="auth-page__logo-image">
                </div>
                <h2 class="auth-page__title">Forget Password</h2>
                <p class="auth-page__subtitle">No worries, we’ll send you reset instructions.</p>
              </div>
              <form method="POST" action="{{ route('admin.password.email') }}"class="auth-page__form">
                @csrf        
                <div class="form-group">
                  <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email Address" required>
                  @error('email')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                  @enderror                </div>
        
                <button type="submit" class="btn btn--primary">{{ __('Send Password Reset Link') }}</button>
        
                {{-- <p class="auth-page__signup-text">
                  Don't have account yet? <a href="signup.html" class="auth-page__link auth-page__link--signup">Create an
                    Account</a>
                </p> --}}
              </form>
              <div class="account__switch text-center mt-4">
                <p>Password Remembered? <a href="{{route('admin.login')}}">Login with Password</a></p>
            </div>
            </div>
          </div>
        <!-- ===============>> account end here <<================= -->
@endsection