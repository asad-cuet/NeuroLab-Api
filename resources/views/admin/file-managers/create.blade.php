{{-- Extends layout --}}
@extends('admin.layouts.master')

@section('title')
    Admin Dashboard
@endsection


@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <style>
        .img-thumbnail {
            width: 100%;
            height: 150px !important;
            object-fit: cover;
        }

        .thumbnail {
            position: relative;
        }

        .thumbnail img {
            transition: transform .8s;
            transform-origin: 0, 0;
        }

        .thumbnail:hover img {
            transform: scale(1.2, 1.2);
            overflow: hidden;
        }


        .myImg {
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .myImg:hover {
            opacity: 0.7;
        }

        /* The Modal (background) */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            /* z-index: 1; Sit on top */
            padding-top: 100px;
            /* Location of the box */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.9);
            /* Black w/ opacity */
        }

        /* Modal Content (image) */
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        /* Caption of Modal Image */
        .caption_img_info {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
            height: 150px;
        }

        /* Add Animation */
        .modal-content,
        .caption_img_info {
            -webkit-animation-name: zoom;
            -webkit-animation-duration: 0.6s;
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @-webkit-keyframes zoom {
            from {
                -webkit-transform: scale(0)
            }

            to {
                -webkit-transform: scale(1)
            }
        }

        @keyframes zoom {
            from {
                transform: scale(0)
            }

            to {
                transform: scale(1)
            }
        }

        /* The Close Button */
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        .card_img_01 {
            ;
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px) {
            .modal-content {
                width: 100%;
            }
        }
    </style>
@endsection

@section('container')
    <!-- ========== section start ========== -->
    <section class="page-container">
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="row g-5">
                    <div class="col-lg-12">
                        <div class="trk-card">
                            <div class="trk-card__wrapper">
                                <div class="trk-card__header d-flex align-items-center justify-content-between">
                                    <h5>File Manager</h5>
                                    <button class="btn btn-primary"><i class="fa-solid fa-file-signature"></i> All File
                                        Manager</button>
                                </div>
                                <div class="trk-card__body">
                                    <div class="gallery">
                                        <div class="gallery__wrapper">
                                            <div class="gallery__top mb-5">
                                                <form method="post" class="gallery__top-from form-horizontal"
                                                    action="{{ route('admin.file-managers.store') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-xl-4 col-sm-12">
                                                            <div class="form-group row">
                                                                <label class="control-label col-sm-3 align-self-center mb-0"
                                                                    for="image_uploads">File
                                                                    :</label>
                                                                <div class="col-sm-9">
                                                                    <div class="form-group">
                                                                        <input class="form-control" type="file"
                                                                            title="multiple images select"
                                                                            id="image_uploads" name="files[]"
                                                                            accept=".jpg, .jpeg, .png" multiple>
                                                                    </div>


                                                                    <div class="form-group">
                                                                        <input class="btn btn-primary  mt-4" type="submit"
                                                                            value="Upload">
                                                                        <input class="btn btn-secondary mt-4" type="reset"
                                                                            value="Reset">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                            <div class="gallery__middle">
                                                <div class="row g-4">
                                                    @foreach ($file_managers as $item)
                                                        @foreach ($item->getMedia('files') as $key => $image)
                                                            <div class="col-xl-3 col-lg-4 col-md-6">
                                                                <div class="trk-card">
                                                                    <div class="trk-card__thumb trk-card__thumb--overlay">
                                                                        <img src="{{ $image->getUrl() }}"
                                                                            style="height: 300px!important; width:100%"
                                                                            alt="#" loading="lazy">
                                                                        <div class="trk-card__thumb-overlay">
                                                                            <div class="trk-card__thumb-badge">
                                                                                <span
                                                                                    class="badge badge-success top-0">Featured
                                                                                </span>
                                                                            </div>
                                                                            <div class="trk-card__thumb-content">
                                                                                <h6>Card title</h6>
                                                                                <p>This is a wider card </p>
                                                                                <span>hello there</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="trk-card__body">
                                                                        <ul>
                                                                            <li><svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="16" height="16"
                                                                                    viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor" stroke-width="2"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round" icon-name="link"
                                                                                    data-lucide="link"
                                                                                    class="lucide lucide-link w-4 h-4 mr-2">
                                                                                    <path
                                                                                        d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71">
                                                                                    </path>
                                                                                    <path
                                                                                        d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71">
                                                                                    </path>
                                                                                </svg> Price: $90</li>
                                                                            <li><svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="16" height="16"
                                                                                    viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor" stroke-width="2"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    icon-name="layers" data-lucide="layers"
                                                                                    class="lucide lucide-layers w-4 h-4 mr-2">
                                                                                    <polygon
                                                                                        points="12 2 2 7 12 12 22 7 12 2">
                                                                                    </polygon>
                                                                                    <polyline points="2 17 12 22 22 17">
                                                                                    </polyline>
                                                                                    <polyline points="2 12 12 17 22 12">
                                                                                    </polyline>
                                                                                </svg> Remaining Stock: 211</li>
                                                                            <li><i class="lni lni-pencil-alt"></i>
                                                                                Status: Inactive
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="trk-card__footer">
                                                                        <div
                                                                            class="trk-card__footer-action d-flex align-items-center justify-content-between">
                                                                            <a href="javascript:void()"
                                                                                class="trk-card__footer-view"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#viewModal_{{ $image->id }}"><i
                                                                                    class="lni lni-eye"></i>
                                                                                Preview</a>
                                                                            <div class="trk-card__footer-group">
                                                                                <a href="javascript:void()"
                                                                                    class="trk-card__footer-edit"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editModal_{{ $image->id }}"
                                                                                    onclick="deleteCrudItem(`{{ route('admin.file-managers.destroy', $image->id) }}`)"><i
                                                                                        class="lni lni-pencil-alt"></i>
                                                                                    Edit</a>
                                                                                <a href="javascript:void()"
                                                                                    class="trk-card__footer-delete"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#deleteModal_{{ $image->id }}"><i
                                                                                        class="lni lni-trash-can"></i>
                                                                                    Delete</a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="gallery-modal">
                                                                            <div class="gallery-modal__view modal fade"
                                                                                id="viewModal_{{ $image->id }}"
                                                                                tabindex="-1"
                                                                                aria-labelledby="exampleModalLabel1"
                                                                                aria-hidden="true">
                                                                                <div class="modal-dialog modal-lg">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h1 class="modal-title fs-5"
                                                                                                id="exampleModalLabel">
                                                                                                View message
                                                                                            </h1>
                                                                                            <button type="button"
                                                                                                class="btn-close"
                                                                                                data-bs-dismiss="modal"
                                                                                                aria-label="Close"></button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <div
                                                                                                class="row align-items-center">

                                                                                                <div class="col-md-6">
                                                                                                    <div
                                                                                                        class="modal-body__thumb">
                                                                                                        <img src="{{ $image->getUrl() }}"
                                                                                                            alt="{{ $image->getUrl() }}">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-md-6">
                                                                                                    <div
                                                                                                        class="modal-body__content">
                                                                                                        <h6>wonderful
                                                                                                            viwe
                                                                                                        </h6>
                                                                                                        <p>
                                                                                                            Lorem
                                                                                                            ipsum
                                                                                                            dolor
                                                                                                            sit
                                                                                                            amet
                                                                                                            consectetur
                                                                                                            adipisicing
                                                                                                            elit.
                                                                                                            Dolor,
                                                                                                            molestias!
                                                                                                        </p>
                                                                                                        <div
                                                                                                            class="modal-body__content-form middle">
                                                                                                            <form
                                                                                                                class="form">
                                                                                                                <div
                                                                                                                    class="form-group">
                                                                                                                    <button
                                                                                                                        class="btn btn-primary mt-4"
                                                                                                                        data-bs-dismiss="modal">Close</button>
                                                                                                                    <button
                                                                                                                        class="btn btn-warning mt-4"
                                                                                                                        data-bs-dismiss="modal"
                                                                                                                        data-bs-dismiss="modal">Reset</button>
                                                                                                                </div>
                                                                                                            </form>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <script></script>
                                                                            <div class="gallery-modal__edit modal fade"
                                                                                id="editModal_{{ $image->id }}"
                                                                                tabindex="-1"
                                                                                aria-labelledby="exampleModalLabel2"
                                                                                aria-hidden="true">
                                                                                <div class="modal-dialog modal-lg">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h1 class="modal-title fs-5"
                                                                                                id="exampleModalLabel">
                                                                                                Edit message
                                                                                            </h1>
                                                                                            <button type="button"
                                                                                                class="btn-close"
                                                                                                data-bs-dismiss="modal"
                                                                                                aria-label="Close"></button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <div
                                                                                                class="row align-items-center">

                                                                                                <div class="col-md-6">
                                                                                                    <div
                                                                                                        class="modal-body__thumb">
                                                                                                        <img src="{{ $image->getUrl() }}"
                                                                                                            alt="{{ $image->getUrl() }}">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-md-6">
                                                                                                    <div
                                                                                                        class="modal-body__content">
                                                                                                        <h6>wonderful
                                                                                                            viwe
                                                                                                        </h6>
                                                                                                        <p>
                                                                                                            Lorem
                                                                                                            ipsum
                                                                                                            dolor
                                                                                                            sit
                                                                                                            amet
                                                                                                            consectetur
                                                                                                            adipisicing
                                                                                                            elit.
                                                                                                            Dolor,
                                                                                                            molestias!
                                                                                                        </p>
                                                                                                        <div
                                                                                                            class="modal-body__content-form middle">
                                                                                                            <form
                                                                                                                method="post"
                                                                                                                class="form"
                                                                                                                action="/"
                                                                                                                enctype="multipart/form-data">
                                                                                                                <div
                                                                                                                    class="form-group">
                                                                                                                    <label
                                                                                                                        for="image_uploads">File</label>
                                                                                                                    <input
                                                                                                                        class="form-control"
                                                                                                                        type="file"
                                                                                                                        title="multiple images select"
                                                                                                                        id="image_uploads"
                                                                                                                        name="image_uploads"
                                                                                                                        accept=".jpg, .jpeg, .png"
                                                                                                                        multiple>
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="form-group">
                                                                                                                    <button
                                                                                                                        class="btn btn-primary mt-4 ">Edit</button>
                                                                                                                    <button
                                                                                                                        class="btn btn-warning mt-4"
                                                                                                                        data-bs-dismiss="modal">Reset</button>
                                                                                                                </div>
                                                                                                            </form>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="gallery-modal__delete modal fade"
                                                                                id="deleteModal_{{ $image->id }}"
                                                                                tabindex="-1"
                                                                                aria-labelledby="exampleModalLabe3"
                                                                                aria-hidden="true">
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h1 class="modal-title fs-5"
                                                                                                id="exampleModalLabel">
                                                                                                Delete
                                                                                                message</h1>
                                                                                            <button type="button"
                                                                                                class="btn-close"
                                                                                                data-bs-dismiss="modal"
                                                                                                aria-label="Close"></button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <div
                                                                                                class="row align-items-center">

                                                                                                <div class="col-md-6">
                                                                                                    <div
                                                                                                        class="modal-body__thumb">
                                                                                                        <img src="{{ $image->getUrl() }}"
                                                                                                            alt="{{ $image->getUrl() }}">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-md-6">
                                                                                                    <div
                                                                                                        class="modal-body__content">
                                                                                                        <h6>Are you
                                                                                                            Sure?
                                                                                                        </h6>
                                                                                                        <p>
                                                                                                            Lorem
                                                                                                            ipsum
                                                                                                            dolor
                                                                                                            sit
                                                                                                            amet
                                                                                                            consectetur
                                                                                                        </p>
                                                                                                        <button
                                                                                                            class="btn btn-primary"
                                                                                                            data-bs-dismiss="modal">Cancel</button>
                                                                                                        <button
                                                                                                            type="button"
                                                                                                            class="btn btn-danger">Delete</button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- end container -->
    </section>
    <!-- ========== section end ========== -->
@endsection


@section('js')
    @parent


    <script type="text/javascript">
        new KTImageInput("1");
    </script>

    <script>
        Dropzone.options.myDropzone = {
            previewTemplate: '<div class="dz-preview dz-file-preview"><div class="dz-image"><img data-dz-thumbnail /></div><div class="dz-details"><div class="dz-size"><span data-dz-size></span></div><div class="dz-filename"><span data-dz-name></span></div></div><div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div><div class="dz-success-mark"><span>✔</span></div><div class="dz-error-mark"><span>✘</span></div><div class="dz-error-message"><span data-dz-errormessage></span></div></div>',
            init: function() {
                this.on("success", function(file, response) {
                    console.log(response.file);
                    file.previewElement.querySelector("[data-dz-thumbnail]").src =
                        "admin/file-managers/store" + response.file;
                });
            }
        };
    </script>

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
    </script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
@endsection
