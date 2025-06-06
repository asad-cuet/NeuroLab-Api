{{-- Extends layout --}}
@extends('admin._layouts._default')


@section('styles')
    <!-- Share JS -->
    <script src="{{ asset('js/share.js') }}"></script>

    <style>
        #social-links ul {
            padding-left: 0;
        }

        #social-links ul li {
            display: inline-block;
        }

        #social-links ul li a {
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 1px;
            font-size: 25px;
        }

        #social-links .fa-facebook {
            color: #0d6efd;
        }

        #social-links .fa-twitter {
            color: deepskyblue;
        }

        #social-links .fa-linkedin {
            color: #0e76a8;
        }

        #social-links .fa-whatsapp {
            color: #25D366
        }

        #social-links .fa-reddit {
            color: #FF4500;
            ;
        }

        #social-links .fa-telegram {
            color: #0088cc;
        }
    </style>
@endsection

{{-- Content --}}
@section('content')



    <div class="row">

        <div class="col-md-12">

            <div class="row">
                <h3 class="card-title align-items-start col-md-4">
                    <span class="card-label font-weight-bolder text-dark">File Manager</span>
                    {{-- <span class="text-muted mt-3 font-weight-bold font-size-sm">description </span> --}}
                </h3>
                <div class="form-group  col-md-4">
                    <div class="input-group">
                        @if (null !== request()->perPage)
                            <input type="hidden" name="perPage" value="{{ request()->perPage }}">
                        @endif

                        <input type="text" name="search" value="{{ isset(request()->search) ? request()->search : '' }}"
                            class="form-control" placeholder="Search for...">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit">Search!</button>
                        </div>

                    </div>
                </div>

                <div class="card-toolbar col-md-4">
                    <div class="float-right">
                        <a href="{{ route('admin.file-managers.create') }}" class="btn btn-success">

                            <i class="flaticon2-add"></i>

                            Add File
                        </a>

                        <div class="dropdown dropdown-inline">
                            <a href="#" class="btn btn-light-danger font-weight-bold dropdown-toggle"
                                data-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-file-export"></i> Export</a>
                            <div class="dropdown-menu dropdown-menu-md dropdown-menu-right py-5" style="">
                                <ul class="navi navi-hover">

                                    <li class="navi-item">
                                        <a class="navi-link" onclick="Export('xlsx')">
                                            <span class="navi-icon">
                                                <i class="fas fa-file-excel text-warning"></i>
                                            </span>
                                            <span class="navi-text">Xlsx</span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a class="navi-link" onclick="Export('csv')">
                                            <span class="navi-icon">
                                                <i class="fas fa-file-csv text-success"></i>
                                            </span>
                                            <span class="navi-text">Csv</span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a class="navi-link" onclick="Export('pdf')">
                                            <span class="navi-icon">
                                                <i class="fas fa-file-pdf text-danger"></i>
                                            </span>
                                            <span class="navi-text">Pdf</span>
                                        </a>
                                    </li>


                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>



            <div class="card card-custom gutter-b">



                <div class="card-body">

                    @if (count($file_managers) > 0)
                        <!--begin: Datatable-->
                        <table class="table table-separate table-head-custom table-checkable" id="kt_datatable">
                            <thead>
                                <tr class="bg-gray-100 text-left px-2">
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Share</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>


                            <tbody>

                                @php $serial=1; @endphp

                                @foreach ($file_managers as $item)
                                    <tr>
                                        <td>{{ $serial++ }}</td>
                                        <td><a
                                                href="{{ route('admin.file-managers.show', $item->id) }}">{{ $item->name }}</a>
                                        </td>
                                        <td>
                                            {{-- this is just an example url to show demo. You need to update the below url, 
                                        which route is of a specific post/content and accessable without login --}}

                                            {{-- also must need to add above class & script --}}

                                            {{-- telegram, reddit, twitter also available --}}

                                            {!! Share::page(url('/share-uploads/' . $item->id))->facebook()->linkedin()->whatsapp() !!}
                                        </td>
                                        <td>

                                            <a href="{{ route('admin.file-managers.edit', $item->id) }}"
                                                class="trk-action__item trk-action__item--warning">
                                                <i class="flaticon2-pen"></i>
                                            </a>

                                            <a onclick="deleteCrudItem('{{ route('admin.file-managers.destroy', $item->id) }}')"
                                                class="trk-action__item trk-action__item--danger">
                                                <i class="flaticon2-trash"></i>
                                            </a>

                                        </td>


                                    </tr>
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
                                <a class="btn btn-success btn-sm ml-10" href="{{ route('admin.file-managers.create') }}">
                                    Add Now
                                </a>
                            </div>


                        </div>
                    @endif




                </div>


                <!--end::Body-->


            </div>

        </div>
    </div>
    <!-- Modal-->
    <div class="modal fade" id="deleteModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <form id="deleteForm" class="form" method="POST">
                    @method('DELETE')
                    @csrf


                    <div class="modal-content">

                        <div class="modal-body">
                            <div class="delete-icon text-center mb-10 mt-5">
                                <div class="bg-gray-200 rounded-circle demo-square demo-square-lg m-auto">

                                    <i class="flaticon2-trash icon-5x text-danger"></i>

                                </div>


                            </div>

                            <div class="modal-text text-center mb-10">

                                <h4 class="text-dark font-weight-bolder d-block mb-5"> You are about to delete an item!</h4>
                                <div class="text-muted font-weight-bold font-size-lg">
                                    This will delete you item permanently.
                                    <br>
                                    Are you sure?
                                </div>

                            </div>



                            <div class="modal-bottom text-right">
                                <button type="button"
                                    class="btn btn-light-success font-weight-bold btn-sm mr-3 font-size-lg"
                                    data-dismiss="modal">Cancel</button>
                                <button type="submit"
                                    class="btn btn-danger font-weight-bold btn-sm mr-10 font-size-lg">Delete</button>
                            </div>


                        </div>


                </form>
            </div>

        </div>
    </div>
    </div>

@endsection

@section('styles')
    @parent
@endsection
@section('scripts')
    <script type="text/javascript">
        function deleteCrudItem(route) {

            var form = document.getElementById('deleteForm');
            var attribute = document.createAttribute("action");
            attribute.value = route;
            form.setAttributeNode(attribute);

            $('#deleteModal').modal('show');
        }

        function Export(format) {
            var url = window.location.pathname + '?export=' + format;
            window.location.replace(url);

        }

        // $(document).ready(function() {
        //     $('#myTable').DataTable();
        // });
    </script>

    @parent
@endsection
