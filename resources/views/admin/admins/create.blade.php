@extends('admin.layouts.master')

@section('title')
    Admin Dashboard
@endsection

@section('container')
    <div class="row">
        <div class="col-lg-12">
            <div class="trk-card">
                <div class="trk-card__wrapper">
                    <div class="trk-card__header text-center">
                        <div>
                            <h5>{{ $info->title }}</h5>
                        </div>
                        <div>
                            <a href="{{ route($info->first_button_route) }}" class="btn btn-primary">

                                <i class="flaticon2-add"></i>

                                {{ $info->first_button_title }}
                            </a>
                        </div>
                    </div>
                    <div class="trk-card__body">
                        <form action="{{ route($info->form_route) }}" method="post" class="form"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="name">{{ __('field.name') }}
                                            <span>&#x002A;</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name') }}"
                                            placeholder="Enter Name" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email">{{ __('field.email') }}
                                            <span>&#x002A;</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') }}"
                                            placeholder="Enter Email" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="phone">{{ __('field.phone') }}
                                            <span>&#x002A;</span></label>
                                        <input type="phone" class="form-control @error('phone') is-invalid @enderror"
                                            id="phone" name="phone" value="{{ old('phone') }}"
                                            placeholder="Enter Phone number" required>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="password">{{ __('field.password') }}
                                            <span>&#x002A;</span></label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="password" name="password" value="{{ old('password') }}"
                                            placeholder="Enter Password">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="confirm_password">{{ __('field.confirm_password') }}
                                            <span>&#x002A;</span></label>
                                        <input type="password"
                                            class="form-control @error('confirm_password') is-invalid @enderror"
                                            id="confirm_password" name="confirm_password"
                                            value="{{ old('confirm_password') }}" placeholder="Enter Confirm Password">
                                        @error('confirm_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="avatar">{{ __('field.avatar') }}</label>
                                        <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                                            id="avatar" name="avatar">
                                        @error('avatar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="is_active">Is Active</label>
                                        <div class="form-check form-switch form-switch-lg">
                                            <input type="checkbox" role="switch" name="is_active" value="1"
                                                class="form-check-input">
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-lg-10">
                                    <button type="submit" class="btn btn-primary mt-4">{{ __('button.create') }}</button>
                                    <button type="reset" class="btn btn-danger mt-4">{{ __('button.reset') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
