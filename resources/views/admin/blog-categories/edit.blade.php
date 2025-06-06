{{-- Extends layout --}}
@extends('admin.layouts.master')

@section('title')
    {{ $info->title }}
@endsection

{{-- Content --}}
@section('container')
    <div class="row">
        <div class="col-lg-12">
            <div class="trk-card">
                <div class="trk-card__wrapper">
                    {{-- Card Header Start --}}
                    <div class=" trk-table__header d-flex justify-content-between">
                        <div class="trk-table__title">
                            <h5>{{ $info->title }}</h5>
                        </div>
                        <div class="float-right">
                            <a href="{{ route($info->first_button_route) }}" class="btn btn-primary">

                                <i class="flaticon2-add"></i>

                                {{ $info->first_button_title }}
                            </a>
                            <a href="{{ route($info->second_button_route) }}" class="btn btn-warning">

                                <i class="flaticon2-add"></i>

                                {{ $info->second_button_title }}
                            </a>
                        </div>
                    </div>
                    {{-- Card Header End --}}

                    {{-- Card Body Start --}}
                    <div class="trk-card__body">
                        <form class="form" action="{{ route($info->form_route, $id) }}" method="post"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row g-4">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label class="form-label" for="banner">Banner</label>
                                        <div class="admin__thumb-upload">
                                            <div class=" admin__thumb-edit">
                                                <input type='file' class="@error('banner') is-invalid @enderror"
                                                    id="banner" name="banner"
                                                    onchange="imagePreview(this,'image_preview_banner');"
                                                    accept=".png, .jpg, .jpeg" />
                                                <label for="banner"></label>
                                            </div>

                                            <div class="admin__thumb-preview">
                                                <div id="image_preview_banner" class="admin__thumb-profilepreview"
                                                    style="
                            background-image: url({{ $data->banner != '' ? asset($data->banner) : asset(avatarUrl()) }});">
                                                </div>
                                            </div>

                                            @error('banner')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>




                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="title">Title <span>&#x002A;</span> </label>
                                        <input type="text" value="{{ $data->title }}"
                                            class="form-control @error('title') is-invalid @enderror" id="title"
                                            name="title" placeholder="Enter Title" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="slug">Slug <span>&#x002A;</span> </label>
                                        <input type="text" value="{{ $data->slug }}"
                                            class="form-control @error('slug') is-invalid @enderror" id="slug"
                                            name="slug" placeholder="Enter Slug" required>
                                        @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label class="form-label" for="parent_id">Blog Category </label>
                                        <select class="form-select search-select @error('parent_id') is-invalid @enderror"
                                            data-live-search="true" id="parent_id" name="parent_id">
                                            <option value="">--Choose--</option>
                                            @foreach (activeModelData('App\Models\BlogCategory') as $row)
                                                <option value="{{ $row->id }}"
                                                    @if ($data->parent_id == $row->id) selected @endif>{{ $row->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('parent_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>


                            </div>
                            <div class="row">
                                <div class="col-lg-10">
                                    <button type="submit" class="btn btn-primary mt-4">{{ __('button.update') }}</button>
                                    <button type="reset" class="btn btn-danger mt-4">{{ __('button.reset') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{-- Card Body End --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    @parent
@endsection

@section('js')
    @parent


    {{-- SCRIPT --}}'
@endsection
