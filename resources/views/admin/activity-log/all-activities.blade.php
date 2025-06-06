@extends('admin.layouts.master')


@section('container')
    <div class="trk-card mb-3 {{ @$class }}">
        {{-- Header --}}

        <div class="trk-card__header">
            <div>
                <h5>All Activities</h5>
                <p>{{ count($activities) }}
                    activities out of
                    {{ $total_activities }}</p>
            </div>
        </div>


        {{-- Body --}}
        
        <div class="trk-card__body">

            <div class="row g-4 justify-content-center">
                <div class="col-12 text-center">
                    @if(count($admins))
                        <form action="{{route(Route::currentRouteName())}}" method="GET" class="mx-auto">
                            <div class="row justify-content-center">
                                <div class="col-md-8 col-lg-6">
                                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                                        <div class="form-group">
                                            <select class="form-select" data-live-search="true" name="admin_id" aria-label="Default select example">
                                                <option value="">Choose Admin</option>
                                                @foreach ($admins as $admin)
                                                    <option value="{{ $admin->id }}" @if(request()->admin_id==$admin->id) selected @endif>
                                                        {{ $admin->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-danger">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>


                <div class="col-12">
                    @if(count($mapped_activities))
                        <div class="table__top">
                            <div class="table__top-dropdown">
                                <label>
                                    <select class="selector" name="per_page" id="per_page" onchange="filterPerPage(this)">
                                        <option value="5" @if($per_page==5) selected @endif>5</option>
                                        <option value="10" @if($per_page==10) selected @endif>10</option>
                                        <option value="15" @if($per_page==15) selected @endif>15</option>
                                        <option value="20" @if($per_page==20) selected @endif>20</option>
                                        <option value="25" @if($per_page==25) selected @endif>25</option>
                                    </select> entries per page
                                </label>
                            </div>
                            <div class="table__top-search">
                                <div class="input-group">
                                    <input type="text" id="search" class="form-control" placeholder="Search..." value="{{request()->search}}" onkeypress="searchOnEnter(event, this)" aria-label="Search">
                                </div>
                            </div>
                        </div>
                        <div class="timeline">
                            @php
                                foreach ($mapped_activities as $activity) {
                                    echo "
                                    <div class=\"timeline__item\">
                                        <div class=\"timeline__icon {$activity['icon_class']}\"></div>
                                        <div class=\"timeline__content\">
                                            <p class=\"timeline__time\">{$activity['updated_at']}</p>
                                            <p class=\"timeline__text\">{$activity['details']}</p>
                                        </div>
                                    </div>";
                                }
                            @endphp
                        </div>
                        {{$activities->appends(request()->input())->links()}}
                    @else
                        <div class="alert alert-custom alert-notice alert-light-success fade show mb-5 text-center"
                            role="alert">
                            <div class="alert-icon">
                                <i class="flaticon-questions-circular-button"></i>
                            </div>
                            <div class="alert-text text-dark">
                                No Activity Found
                            </div>
                        </div>
                    @endif
                </div>
            </div>


        </div>
    </div>
@endsection
