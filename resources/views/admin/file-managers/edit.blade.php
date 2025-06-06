{{-- Extends layout --}}
@extends('admin._layouts._default')

{{-- Content --}}
@section('content')

    <div class="row">
        <div class="col-md-12">

            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">File Manager</h3>
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
                <form class="form" action="{{route('admin.file-managers.update',$file_manager->id)}}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" for="name">File Manager</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" value="{{ $file_manager->name }}" name="file_manager" />
                            </div>
                            <div class="col-md-4"></div>
                        </div> 
                        <div class="form-group row">
                            <label class=" col-md-2 col-form-label text-left" for="Is Active">Is Active</label>
                            <div class="col-md-6">
                                <span class="switch switch-outline switch-icon switch-success">
                                    <label>

                                        <input type="checkbox" value="1" name="is_active"  {{$file_manager->is_active==1? 'checked':''}} >
                                        <span></span>
                                    </label>
                                </span>

                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-10">
                                <button type="submit" class="btn btn-success mr-2">Update</button>
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



@endsection
