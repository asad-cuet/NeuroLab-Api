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
                        @can('blog-comment-update')
                            <a href="{{ route($info->first_button_route, $id) }}" class="btn btn-primary">
                                <i class="flaticon2-add"></i>
                                {{ $info->first_button_title }}
                            </a>
                        @endcan
                        <a href="{{ route('admin.blogs.show',$data->blog_id).'?tab=comments' }}" class="btn btn-warning">
                            <i class="flaticon2-add"></i>
                            Blog
                        </a>
                    </div>
                </div>
                <div class="trk-card__body">
                    <div class="trk-card__body-text">
                        <ul class="crud-view mt-4">
                            <li class="crud-view__item">
                                <span class="crud-view__item-title">Image:</span>
                                <span class="crud-view__item-content">
                                    <div class="trk-avatar d-flex flex-wrap align-items-center">
                                        <div class="trk-avatar__item me-3">

                                            <img style="height:100px;"
                                                @if ($data->image) src="{{ asset($data->image) }}"
                                                @else                
                                                    src="{{ asset(avatarUrl()) }}" 
                                                @endif
                                                alt="#" data-bs-original-title="" title="">
                                        </div>
                                    </div>
                                </span>
                            </li>
                            <li class="crud-view__item">
                                <span class="crud-view__item-title">Name:</span>
                                <span class="crud-view__item-content">{{ $data->name }}</span>
                            </li>
                            <li class="crud-view__item">
                                <span class="crud-view__item-title">Phone:</span>
                                <span class="crud-view__item-content">{{ $data->phone }}</span>
                            </li>
                            <li class="crud-view__item">
                                <span class="crud-view__item-title">Email:</span>
                                <span class="crud-view__item-content">{{ $data->email }}</span>
                            </li>
                            <li class="crud-view__item">
                                <span class="crud-view__item-title">User:</span>
                                <span class="crud-view__item-content">

                                    {{ $data->user?->name }}

                                </span>
                            </li>
                            <li class="crud-view__item">
                                <span class="crud-view__item-title">Status:</span>
                                <span class="crud-view__item-content">
                                    {{ $data->status }} </span>
                            </li>
                            <li class="crud-view__item">
                                <span class="crud-view__item-title">Parent Comment Description:</span>
                                <span class="crud-view__item-content">

                                    {{ $data->blogComment?->description }}

                                </span>
                            </li>
                            <li class="crud-view__item">
                                <span class="crud-view__item-title">Description:</span>
                                <span class="crud-view__item-content">{!! $data->description !!}</span>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
