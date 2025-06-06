@extends('admin.layouts.master')

@section('title')
    Admin Dashboard
@endsection

@section('container')
    <div class="website-content">
        <div class="row g-5">
            <div class="col-md-12">
                <div class="trk-card">
                    <div class="trk-card__header">
                        <div>
                            <h5>
                                {{ __('default.account_setting') }}
                            </h5>
                            <p>
                                Update account information
                            </p>
                        </div>
                    </div>
                    <div class="trk-card__body">
                        <div class="row g-4 justify-content-center">
                            <div class="col-sm-10 col-md-8 col-lg-8">
                                <form class="form" action="{{ route('admin.profile.update') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-4">

                                        <div class="admin__thumb">
                                            <div class="admin__thumb-upload">
                                                <div class="admin__thumb-edit">
                                                    <input type='file' id="imgInp" accept=".png, .jpg, .jpeg"
                                                        name="avatar" id="user_avatar" />
                                                    <label class="form-label" for="imgInp"></label>
                                                </div>
                                                <div class="admin__thumb-preview">
                                                    @if (Auth::user()->avatar)
                                                        <div id="imagePreview" class="admin__thumb-profilepreview"
                                                            style="background-image: url({{ asset(Auth::user()->avatar) }});">
                                                        </div>
                                                    @else
                                                        <div id="imagePreview" class="admin__thumb-profilepreview"
                                                            style="background-image: url('../../assets/images/testimonial/2.png');">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="name">{{ __('field.name') }}
                                                    <span>&#x002A;</span></label>
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                                    value="{{ Auth::user()->name }}" name="name" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="role">{{ __('field.role') }}</label>

                                                <select class="multi-select form-select" multiple autocomplete="off">
                                                @foreach(Auth::user()->getRoleNames() as $item)
                                                    <option value="{{ $item }}" selected>{{ $item }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="email11">{{ __('field.email_address') }}
                                                    <span>&#x002A;</span></label>
                                                <input type="text"
                                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                                    name="email" value="{{ Auth::user()->email }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="phone">{{ __('field.phone') }}
                                                    <span>&#x002A;</span></label>
                                                <input type="text"
                                                    class="form-control @error('phone') is-invalid @enderror" id="phone"
                                                    name="phone" value="{{ Auth::user()->phone }}" required>
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="new_password">{{ __('field.new_password') }}</label>
                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    id="password" name="password">
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="password">{{ __('field.confirm_password') }}</label>
                                                <input type="password"
                                                    class="form-control @error('confirm_password') is-invalid @enderror"
                                                    id="confirm_password" name="confirm_password">
                                                @error('confirm_password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- @if ($errors->any())
                                    {{dd($errors)}}
                                @endif --}}
                                    <div class="text-end">
                                        <button type="reset"
                                            class="btn btn-danger mt-4">{{ __('button.reset') }}</button>
                                        <button class="btn btn-primary mt-4">{{ __('button.submit') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    {{-- SCRIPT --}}
@endsection
