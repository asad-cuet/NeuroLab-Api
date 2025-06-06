@extends('admin.layouts.guest')

@section('content')
<div class="auth-page auth-page--signin">
    <div class="auth-page__card">
      <div class="auth-page__card-header">
        <div class="auth-page__logo">
          <img src="{{asset('assets/images/logo/logo-icon.png')}}" alt="Logo" class="auth-page__logo-image">
        </div>
        <h2 class="auth-page__title">{{ __('Confirm Password') }}</h2>
        <p class="auth-page__subtitle">{{ __('Please confirm your password before continuing.') }}</p>
      </div>
      <form method="POST" action="{{ route('admin.password.update') }}" class="auth-page__form">
        @csrf        
        <div class="row mb-3">
            <label class="form-label" for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Confirm Password') }}
                </button>

                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </div>
        </div>
      </form>
    </div>
</div>



@endsection
