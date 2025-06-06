{{-- Extends layout --}}
@extends('admin._layouts._default')
@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>
@endsection

{{-- Content --}}
@section('content')

    <div class="row">
        <div class="col-md-12">

            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">File Manager Of {{ $file_manager->name }}</h3>
                    <div class="card-toolbar">
                        <div class="example-tools justify-content-center">
                            <a href="{{route('admin.file-managers.index')}}"
                                class="btn btn-light-warning">
                                <i class="flaticon2-list"></i>
                                All File Managers
                            </a>
                        </div>
                    </div>
                </div>
                <form action="{{route('admin.file-upload', $file_manager->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" for="name">File</label>
                            <div class="col-md-6">
                                <input type="file" class="form-control" name="file" />
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-10">
                                <button type="submit" class="btn btn-success mr-2">Upload</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>



            </div>
        </div>
    </div>

@endsection

@section('styles')

    @parent

@endsection

@section('scripts')

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
            file.previewElement.querySelector("[data-dz-thumbnail]").src = "admin/file-managers/store" + response.file;
        });
    }
};
</script>

@endsection
