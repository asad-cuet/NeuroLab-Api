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
                        <a href="{{ route($info->second_button_route) }}" class="btn btn-warning">
                            <i class="flaticon2-add"></i>
                            {{ $info->second_button_title }}
                        </a>
                    </div>
                </div>
                <div class="trk-card__body">

                    <div class="tork-tab">
                      <div class="tork-tab__header">
                        <ul class="nav tork-tab__nav" id="pills-tab" role="tablist">
                          <li class="nav-item tork-tab__item" role="presentation">
                            <a class="nav-link @if(request()->tab!='') @if(request()->tab=='view') active @else @endif @else active @endif" id="pills-view-post-tab" data-bs-toggle="pill"
                              href="#pills-view-post" role="tab" aria-selected="true">
                              View Post
                            </a>
                          </li>
                          @can('blog-update')
                          <li class="nav-item tork-tab__item" role="presentation">
                            <a class="nav-link @if(request()->tab=='edit') active @endif" id="pills-edit-post-tab" data-bs-toggle="pill" href="#pills-edit-post"
                              role="tab" aria-selected="false">
                              Edit Post
                            </a>
                          </li>
                          @endcan
                          <li class="nav-item tork-tab__item" role="presentation">
                            <a class="nav-link @if(request()->tab=='comments') active @endif" id="pills-comments-tab" data-bs-toggle="pill" href="#pills-comments"
                              role="tab" aria-selected="false">
                              Comments
                            </a>
                          </li>
                        </ul>
                      </div>
                      <div class="tork-tab__body">
                        <div class="tab-content" id="pills-tabContent-2">
                          <div class="tab-pane fade @if(request()->tab!='') @if(request()->tab=='view') show active @else @endif @else show active @endif" id="pills-view-post" role="tabpanel"
                            aria-labelledby="pills-view-post-tab">

                            <div class="row g-4">

                              <div class="col-12">
                                <div class="trk-card trk-card--sm border2 rounded-3">
                                  <div class="trk-card__body">
                                    <div class="row g-4">
                                      <div class="col-lg-8">
                                        <ul class="view-list">
                                          <li class="view-list__item">
                                            <h6 class="mb-1 fw-medium fs-6 title-color">Title</h6>
                                            <p class="mb-0 text-muted">{{$data->title}}</p>
                                          </li>
                                          <li class="view-list__item">
                                            <h6 class="mb-1 fw-medium fs-6 title-color">Slug</h6>
                                            <p class="mb-0 text-muted">{{$data->slug}}</p>
                                          </li>
                                          <li class="view-list__item">
                                            <h6 class="mb-1 fw-medium fs-6 title-color">Category</h6>
                                            <p class="mb-0 text-muted">{{$data->blogCategory?->title}}</p>
                                          </li>
                                          <li class="view-list__item">
                                            <h6 class="mb-1 fw-medium fs-6 title-color">Status</h6>
                                            <p class="mb-0 text-muted">{{$data->status}}</p>
                                          </li>
                                        </ul>
                                      </div>
                                      <div class="col-lg-4">
                                        <div class="view-list-image text-lg-end">
                                          <img src="@if($data->getMedia('banners')->isNotEmpty()) {{ asset($data->getFirstMediaUrl('banners')) }} @else {{ asset(avatarUrl()) }} @endif" alt="image">
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div> 
                              </div>

                              <div class="col-12">
                                <div class="trk-card trk-card--sm border2 rounded-3">
                                  <div class="trk-card__body">
                                    <div class="accordion trk-accordion">


                                      <div class="trk-accordion__section mb-0">
                                            <div
                                            class="trk-accordion__item p-0 border-bottom-0 d-flex flex-wrap align-items-center justify-content-between"
                                            id="elementHeadingFour">
                                            <button
                                                class="trk-accordion__header-toggle justify-content-between w-100 trk-accordion__item-content collapsed"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseCourseElementFour" aria-expanded="true"
                                                aria-controls="collapseCourseElementFour">
                                                <h6> Short Description</h6>
                                                <span class="arrow mt-2">
                                                <i class="lni lni-chevron-up"></i>
                                                </span>
                                            </button>
                                            </div>
                                            <div id="collapseCourseElementFour"
                                            class="trk-accordion__body p-0 bg-white collapse "
                                            aria-labelledby="elementHeadingFour" data-bs-parent="#courseElementAccordion">
                                            <div class="trk-accordion__item-content">
                                                    {!!$data->short_description!!}
                                            </div>
                                            </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="col-12">
                                <div class="trk-card trk-card--sm border2 rounded-3">
                                  <div class="trk-card__body">
                                    <div class="accordion trk-accordion">


                                        <div class="trk-accordion__section mb-0">
                                            <div
                                            class="trk-accordion__item p-0 border-bottom-0 d-flex flex-wrap align-items-center justify-content-between"
                                            id="elementHeadingFive">
                                            <button
                                                class="trk-accordion__header-toggle justify-content-between w-100 trk-accordion__item-content collapsed"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseCourseElementFive" aria-expanded="true"
                                                aria-controls="collapseCourseElementFive">
                                                <h6>Description</h6>
                                                <span class="arrow mt-2">
                                                <i class="lni lni-chevron-up"></i>
                                                </span>
                                            </button>
                                            </div>
                                            <div id="collapseCourseElementFive"
                                            class="trk-accordion__body p-0 bg-white collapse "
                                            aria-labelledby="elementHeadingFive" data-bs-parent="#courseElementAccordion">
                                            <div class="trk-accordion__item-content">
                                                    {!!$data->description!!}
                                            </div>
                                            </div>
                                      </div>


                                    </div>
                                  </div>
                                </div>
                              </div>

                            </div>

                          </div>


                          @can('blog-update')
                            <div class="tab-pane fade @if(request()->tab=='edit') show active @endif" id="pills-edit-post" role="tabpanel"
                                aria-labelledby="pills-edit-post-tab">
                                @include('admin.blogs.includes.edit_form',['data'=>$data,'info'=>$info])
                            </div>
                          @endcan

                          @can('blog-comment-update')
                          <div class="tab-pane fade @if(request()->tab=='comments') show active @endif" id="pills-comments" role="tabpanel"
                            aria-labelledby="pills-comments-tab">
                            @include('admin.blogs.includes.comments',['data'=>$data,'info'=>$info])
                          </div>
                          @endcan
                        </div>
                      </div>
                    </div>

                  </div>
            </div>
        </div>
    </div>
    @include('admin.components.modals.delete')
@endsection

@section('js')
    @parent


    {!! renderCKEditorScript('short_description') !!}

    {!! renderCKEditorScript('description') !!}

    {!! renderCKEditorScript('meta_description') !!}


    {{-- SCRIPT --}}'
@endsection