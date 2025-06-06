@extends('admin.layouts.master')

@section('title')
    Admin Menus
@endsection

@section('container')
    <div class="row">
        <div class="col-md-12">

            <div class="trk-card">

                <!--end::Header-->
                <div class="trk-card__body">
                    @csrf
                    <div class="col-md-8 mx-auto my-20">

                        <div class="mb-5 d-flex flex-wrap gap-4 justify-content-between" id="nestable-expand-collapse">
                            <button type="button" class="btn btn-success" data-action="expand-all">Expand All</button>
                            <button type="button" class="btn btn-primary" data-action="collapse-all">Collapse
                                All</button>
                        </div>

                        <h3 class="card-title text-center mb-4">
                            <span>{{ __('default.orientate_your_menus') }}</span>
                        </h3>


                        <div class="dd" id="nestable">
                            @if (isset($info->admin_menus[0]))
                                {{ AdminSidebar::renderDragDropMenus($info->admin_menus, $info->admin_menus[0]) }}
                            @endif
                        </div>

                        <div class="mb-5 d-flex justify-content-center mt-5" id="nestable-expand-collapse">
                            <a href="{{ route('admin.sync.admin.menu') }}" class="btn btn-primary">Sync Menus</a>
                        </div>




                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.components.modals.delete')
@endsection

@section('js')
    <script src="{{ asset('assets/js/nestable.js') }}"></script>
    <script>
        nestableWithData('#nestable', 'updateNestableOutput', '#nestable-expand-collapse');

        function updateNestableOutput(output) {
            //For showing output chnages
            // var outputSelector = document.querySelector('#nestable-output');
            // if (window.JSON) {
            //   outputSelector.value = JSON.stringify(output.result);
            // } else {
            //   console.error('JSON browser support required for this demo.');
            // }
            // Run an API Request to Server
            var _token = $('meta[name="csrf-token"]').attr('content');
            const menuList = {
                nested_menus_array: output.result,
                _token: _token
            };
            const url = "{{ route('admin.save-nested-admin-menus') }}";
            adminMenuUpdateApiCalling(menuList, url)
        }

        function adminMenuUpdateApiCalling(data, url) {
            // console.log('updateNestableOutput API Calling');
            // Make sure to set proper headers for the request
            const headers = new Headers();
            headers.append('Content-Type', 'application/json');
            fetch(url, {
                    method: 'POST',
                    headers: headers,
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    SwalFlash(true, 'Success', 'Admin Menu Updated Successfully');
                })
                .catch(error => {
                    // Handle errors
                    console.error('Error during POST request:', error);
                });
        }
    </script>
@endsection
