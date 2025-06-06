@extends('admin.layouts.master')

@section('title')
    Admin Dashboard
@endsection

@section('container')
        <div class="row">
            <div class="col-lg-12">
                <div class="trk-card">
                    <div class="trk-card__header">
                        <div class="trk-card__title">
                            <h5>{{$info->title}}</h5>
                            <p>{{ $info->description }}</p>
                        </div>
                        <div>
                            @can('admin-view')
                                <a href="{{ route($info->first_button_route) }}" class="btn btn-primary">
                                    <i class="flaticon2-add"></i>
                                    {{$info->first_button_title}}
                                </a>
                            @endcan
                        </div>
                    </div>
                    <div class="trk-card__body">

                    <div class="container">
                        <div class="trk-table  table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('button.permission') }}</th>
                                        <th scope="col">{{ __('button.view') }}</th>
                                        <th scope="col">{{ __('button.create') }}</th>
                                        <th scope="col">{{ __('button.update') }}</th>
                                        <th scope="col">{{ __('button.delete') }}</th>
                                    </tr>
                                </thead>

                                <tbody id="role_permission_list">

                                </tbody>

                            </table>
                            <div class="text-end mt-4">
                                <button class="btn btn-success"
                                    onclick="updatePermissions()">{{ __('button.update') }}</button>
                            </div>
                        </div>
                    </div>
                    
                    </div>
                    
                </div>
            </div>
        </div>









@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $('#multi_select').select2({
        placeholder: "Select Multiple"
    }); // nested
</script>
<script>
    function syncRoleChange(role) {
        $.ajax({
            url: "{{ url('admin/ajax/permissions-by-role') }}/" + role,
            type: "GET",
            data: {},
            success: function(response) {
                $('#role_permission_list').html(response);
            },
            error: function(errors) {
                console.log(errors);
            }
        });
        syncAdminOnRoleChange(role);
    
    }
    syncRoleChange({{$data->id}});


    function updatePermissions() {

        var selected = [];
        $('#role_permission_list input:checked').each(function() {
            selected.push($(this).attr('name'));
        });

        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        console.log(csrf_token);
        $.ajax({
            url: "{{ url('admin/ajax/update-permissions') }}/{{$data->id}}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrf_token
            },
            data: {
                'permissions': selected
            },
            success: function(response) {
                if (response) {
                    location.reload();
                }
            },
            error: function(errors) {
                console.log(errors);
            }
        });

        }

        function syncAdminOnRoleChange(role) {
            $('#role_id_admins').val(role);
            $.ajax({
                url: "{{ url('admin/ajax/admins-by-role') }}/" + role,
                type: "GET",
                data: {},
                success: function(response) {
                    $('#role_user_list').html(response);
                },
                error: function(errors) {
                    console.log(errors);
                }
            });

        }
</script>
@endsection
