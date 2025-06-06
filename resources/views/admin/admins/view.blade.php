@extends('admin.layouts.master')

@section('title')
    Admin Dashboard
@endsection

@section('container')
        <div class="row">
            <div class="col-lg-12">
                <div class="trk-card">
                    <div class="trk-card__header d-flex justify-content-between"">
                        <div class="trk-card__title">
                            <h5>{{$info->title}}</h5>
                        </div>
                        <div>
                            @can('admin-view')
                                <a href="{{ route($info->first_button_route) }}" class="btn btn-primary">
                                    <i class="flaticon2-add"></i>
                                    {{$info->first_button_title}}
                                </a>
                            @endcan
                        </div>
                    </div>
                    <div class="trk-card__body">
                        <div class="trk-card__body-text">
                            <ul class="crud-view">
                                <li class="crud-view__item d-flex align-items-center">
                                  <span class="crud-view__item-title">Avatar:</span>
                                  <span class="crud-view__item-content">
                                    <div class="admin__thumb-preview ms-0">
                                        @if ($data->avatar)
                                            <div id="imagePreview" class="admin__thumb-profilepreview"
                                                style="background-image: url({{ asset($data->avatar) }});">
                                            </div>
                                        @else
                                            <div id="imagePreview" class="admin__thumb-profilepreview"
                                                style="background-image: url('../../assets/images/testimonial/2.png');">
                                            </div>
                                        @endif
                                    </div>
                                  </span>
                                </li>
                                <li class="crud-view__item">
                                    <span class="crud-view__item-title">ID:</span>
                                    <span class="crud-view__item-content">{{$data->id}}</span>
                                </li>
                                <li class="crud-view__item">
                                  <span class="crud-view__item-title">Name:</span>
                                  <span class="crud-view__item-content">{{$data->name}}</span>
                                </li>
                                <li class="crud-view__item">
                                  <span class="crud-view__item-title">Email:</span>
                                  <span class="crud-view__item-content">{{$data->email}}</span>
                                </li>
                                <li class="crud-view__item">
                                  <span class="crud-view__item-title">Phone:</span>
                                  <span class="crud-view__item-content">{{$data->phone}}</span>
                                </li>
                                <li class="crud-view__item">
                                  <span class="crud-view__item-title">Created At:</span>
                                  <span class="crud-view__item-content">{{date('d-m-Y',strtotime($data->created_at))}}</span>
                                </li>
                              </ul>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
@endsection
