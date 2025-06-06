@extends('admin.layouts.master')

@section('title')
    {{ $page_title }}
@endsection

@section('container')
    <div class="row">
        <div class="col-lg-12">
            <div class="trk-card">
                <div class="trk-card__header d-flex justify-content-between">
                    <div class="trk-card__title">
                        <h5>{{ $info->title }}</h5>
                    </div>
                    <div class="float-right">
                        @can('page-builder-update')
                            <a href="{{ route($info->first_button_route, $id) }}" class="btn btn-primary">
                                <i class="flaticon2-add"></i>
                                {{ $info->first_button_title }}
                            </a>
                        @endcan
                        <a href="{{ route($info->second_button_route) }}" class="btn btn-warning">
                            <i class="flaticon2-add"></i>
                            {{ $info->second_button_title }}
                        </a>
                    </div>
                </div>
                <div class="trk-card__body">
                    <div class="trk-card__body-text">
                        <ul class="crud-view mt-4">
                            <li class="crud-view__item">
                                <span class="crud-view__item-title">Title:</span>
                                <span class="crud-view__item-content">{{ $data->title }}</span>
                            </li>
                            <li class="crud-view__item">
                                <span class="crud-view__item-title">Slug:</span>
                                <span class="crud-view__item-content">{{ $data->slug }}</span>
                            </li>
                            <li class="crud-view__item">
                                <span class="crud-view__item-title">Meta Title:</span>
                                <span class="crud-view__item-content">{{ $data->meta_title }}</span>
                            </li>
                            <li class="crud-view__item">
                                <span class="crud-view__item-title">Meta Tag:</span>
                                <span class="crud-view__item-content">{{ $data->meta_tags }}</span>
                            </li>
                            <li class="crud-view__item">
                                <span class="crud-view__item-title">View:</span>
                                <span class="crud-view__item-content">{{ $data->views }}</span>
                            </li>
                            <li class="crud-view__item">
                                <span class="crud-view__item-title">Status:</span>
                                <span class="crud-view__item-content">
                                    {{ $data->status }} </span>
                            </li>
                            <li class="crud-view__item">
                                <span class="crud-view__item-title">Is Edit Disable:</span>
                                <span class="crud-view__item-content">{{ $data->is_edit_disable }}</span>
                            </li>

                            <li class="crud-view__item">
                                <span class="crud-view__item-title">Is Featured:</span>
                                <span class="crud-view__item-content">{{ $data->is_featured }}</span>
                            </li>

                            <li class="crud-view__item">
                                <span class="crud-view__item-title">Description:</span>
                                <span class="crud-view__item-content">{!! $data->description !!}</span>
                            </li>
                            <li class="crud-view__item">
                                <span class="crud-view__item-title">Meta Description:</span>
                                <span class="crud-view__item-content">{!! $data->meta_description !!}</span>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
