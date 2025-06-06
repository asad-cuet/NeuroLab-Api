@extends('admin.layouts.master')

@section('title')
    Admin Dashboard
@endsection

@section('container')
    <div class="row justify-content-center">
        <div class="col-lg-8">
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
                        <form action="{{ route($info->form_route) }}" method="post" class="form">
                            @csrf
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="name">{{ __('field.name') }}</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" placeholder="{{ __('field.name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="is_active">{{ __('field.is_active') }}</label>
                                        <div class="form-check form-switch form-switch-lg">
                                            <input type="checkbox" role="switch" name="is_active" id="is_active"
                                                value="1" class="form-check-input">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-10">
                                    <button type="submit" class="btn btn-primary mt-4">{{ __('button.submit') }}</button>
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
