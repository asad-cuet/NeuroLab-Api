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
                        @include('admin.blogs.includes.edit_form',['data'=>$data,'info'=>$info])
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


    {!! renderCKEditorScript('short_description') !!}

    {!! renderCKEditorScript('description') !!}

    {!! renderCKEditorScript('meta_description') !!}

    {{-- SCRIPT --}}'
@endsection
