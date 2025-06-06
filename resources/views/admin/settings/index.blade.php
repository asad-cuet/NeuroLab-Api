@extends('admin.layouts.master')

@section('title')
Admin Dashboard
@endsection

@section('container')
    <div class="website-content">
        <div class="row g-5">
            <div class="col-md-12">
                <div class="trk-card">
                    <div class="trk-card__header">
                        <h5>
                            Setting
                        </h5>
                    </div>
                    <div class="trk-card__body">
                        <div class="row g-4">
                                        <!--begin::Aside-->
                                        @include('admin.settings.sidebar')
                                        <!--begin::Content-->
                                        @include('admin.settings.main-body')
                                        <!--end::Content-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script>
    (function() {
        "use strict";
        const imgInp = document.getElementById('favImgInp');
        if (imgInp) {
            imgInp.onchange = evt => {
                const [file] = imgInp.files
                if (file) {
                    document.getElementById('favImagePreview').style.backgroundImage = 'url(' + URL
                        .createObjectURL(file) + ')';
                }
            };
        }
    })();
</script>
{!!renderCKEditorScript('meta_description')!!}
{!!renderCKEditorScript('about_us')!!}
{!!renderCKEditorScript('privacy_policy')!!}
{!!renderCKEditorScript('copyright_policy')!!}
@endsection