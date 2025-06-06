@extends('admin.layouts.master')

@section('title')
    Admin Dashboard
@endsection

@section('container')
    <div class="row justify-content-center">
        <div class="col-12">
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
                        <form action="{{ route($info->form_route, $id) }}" method="post" class="form">
                            @csrf
                            @method('PUT')
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="name">{{ __('field.title') }}</label>
                                        <input type="text" class="form-control @error(' title') is-invalid @enderror"
                                            id="name" name="name" value="{{ $row->name }}">
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="is_active">{{ __('field.is_active') }}</label>
                                    <div class="form-check form-switch form-switch-lg">
                                        <input type="checkbox" role="switch" name="is_active" value="1"
                                            class="form-check-input"
                                            @if ($row->is_active) checked="checked" @endif>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary ">{{ __('button.update') }}</button>
                                    <button type="reset" class="btn btn-danger ">{{ __('button.reset') }}</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
