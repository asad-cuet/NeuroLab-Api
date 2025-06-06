@extends('admin.layouts.master')

@section('title')
    {{ $page_title }}
@endsection
@section('container')
    <div class="trk-table">
        <div class="trk-table__wrapper">


            <div class=" trk-table__header d-flex justify-content-between">
                <div class="trk-table__title">
                    <h5>{{ $info->title }}</h5>
                    <p>{{ $info->description }}</p>
                </div>
                <div class="float-right">
                    @can('page-builder-create')
                        <a href="{{ route($info->first_button_route) }}" class="btn btn-primary">
                            <i class="flaticon2-add"></i>
                            {{ $info->first_button_title }}
                        </a>
                    @endcan




                </div>
            </div>



            <div class="trk-table__body">
                @if ($data->count() > 0)
                    <!--begin: Datatable-->
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th>Serial</th>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>View</th>
                                <th>Status</th>
                                <th>Is Edit Disable</th>
                                <th>Is Featured</th>
                                <th>Is Active</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                                $serial = 1;
                            @endphp

                            @foreach ($data as $row)
                                <tr>
                                    <td>{{ $serial }}
                                    </td>
                                    <td>{{ $row->title }}
                                    </td>
                                    <td>{{ $row->slug }}
                                    </td>
                                    <td>{{ $row->views }}
                                    </td>
                                    <td>{{ $row->status }}
                                    </td>
                                    <td>
                                        <div class="form-check form-switch form-switch-md">
                                            <input type="checkbox" name="is_edit_disable" value="{{ $row->id }}"
                                                onclick="toggleSwitchStatus(this,'page_builders');" class="form-check-input"
                                                @if ($row->is_edit_disable == 1) checked @endif>
                                        </div>



                                    </td>
                                    <td>
                                        <div class="form-check form-switch form-switch-md">
                                            <input type="checkbox" name="is_featured" value="{{ $row->id }}"
                                                onclick="toggleSwitchStatus(this,'page_builders');" class="form-check-input"
                                                @if ($row->is_featured == 1) checked @endif>
                                        </div>



                                    </td>
                                    <td>
                                        <div class="form-check form-switch form-switch-md">
                                            <input type="checkbox" name="is_active" value="{{ $row->id }}"
                                                onclick="toggleSwitchStatus(this,'page_builders');" class="form-check-input"
                                                @if ($row->is_active == 1) checked @endif>
                                        </div>



                                    </td>
                                    <td>
                                        <ul class="trk-action__list">
                                            <li class="trk-action">
                                                <a class="trk-action__item trk-action__item--success"
                                                    href="{{ route('admin.page-builders.show', $row->id) }}">
                                                    <i class="lni lni-eye"></i>
                                                </a>
                                            </li>
                                            @can('page-builder-update')
                                                <li class="trk-action">
                                                    <a class="trk-action__item trk-action__item--warning"
                                                        href="{{ route('admin.page-builders.edit', $row->id) }}">
                                                        <i class="lni lni-pencil-alt"></i>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('page-builder-delete')
                                                <li class="trk-action">
                                                    <a onclick="deleteCrudItem(`{{ route('admin.page-builders.destroy', $row->id) }}`)"
                                                        class="trk-action__item trk-action__item--danger" href="#">
                                                        <i class="lni lni-trash-can"></i>
                                                    </a>
                                                </li>
                                            @endcan
                                        </ul>

                                    </td>
                                </tr>
                                @php
                                    $serial++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>


                    <!--end: Datatable-->
                @else
                    <div class="alert alert-custom alert-notice alert-light-success fade show mb-5 text-center"
                        role="alert">
                        <div class="alert-icon">
                            <i class="flaticon-questions-circular-button"></i>
                        </div>
                        <div class="alert-text text-dark">
                            No Data Found..!
                            <a href="{{ route($info->first_button_route) }}" class="btn btn-success">
                                <i class="flaticon2-add"></i>
                                Add Now
                            </a>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
    @include('admin.components.modals.delete')
@endsection

@section('css')
@endsection
@section('js')
    @parent
    {{-- SCRIPT --}}
@endsection
