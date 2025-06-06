@extends('admin.layouts.master')

@section('title')
    Admin Dashboard
@endsection

@section('css')
    <style>
        .select2 {
            display: none;
        }
    </style>
@endsection

@section('container')
    <div class="trk-table tables">
        <div class="row">
            <div class="col-lg-12">
                <div class="trk-table__wrapper">
                    <div class="trk-table__header d-flex flex-wrap align-items-center gap-3 justify-content-between">
                        <div class="trk-table__title">
                            <h5>{{ $page_title }}</h5>
                            <p>{{ $info->description }}</p>
                        </div>
                        <div>
                            <a href="{{ route($info->first_button_route) }}" class="btn btn-primary">

                                <i class="flaticon2-add"></i>

                                {{ $info->first_button_title }}
                            </a>
                        </div>
                    </div>
                    <div class="trk-table__body tables_body table-responsive">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="form-control nav-link active" id="nav-role-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-role" type="button" role="tab" aria-controls="nav-role"
                                    aria-selected="true"><i class="lni lni-bolt"></i>
                                    {{ __('button.roles') }}</button>
                                <button class="form-control nav-link" id="nav-permissions-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-permissions" type="button" role="tab"
                                    aria-controls="nav-permissions" aria-selected="false"><i class="lni lni-protection"></i>
                                    {{ __('button.permissions_by_role') }}</button>
                                <button class="form-control nav-link" id="nav-admins-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-admins" type="button" role="tab" aria-controls="nav-admins"
                                    aria-selected="false"><i class="lni lni-user"></i>
                                    {{ __('button.admins_by_role') }}</button>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-role" role="tabpanel"
                                aria-labelledby="nav-role-tab">
                                <div class="role">
                                    <div class="container">
                                        <div class="trk-table table-responsive">
                                            <table class="table" id="myTable">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Serial</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Guard Name</th>
                                                        <th scope="col">Is Active</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data as $key => $row)
                                                        <tr>
                                                            <td scope="row">{{ $key + 1 }}</td>
                                                            <td>{{ $row->name }}</td>
                                                            <td>{{ $row->guard_name }}</td>
                                                            <td>
                                                                @if ($row->is_active)
                                                                    <span class="badge bg-primary">Active</span>
                                                                @else
                                                                    <span class="badge bg-danger">Inactive</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <ul class="trk-action__list">


                                                                    @can('user-update')
                                                                        <li class="trk-action">
                                                                            <a href="{{ route('admin.roles.edit', $row->id) }}"
                                                                                class="trk-action__item trk-action__item--warning">
                                                                                <i class="lni lni-pencil-alt"></i>
                                                                            </a>
                                                                        </li>
                                                                    @endcan

                                                                    @can('user-delete')
                                                                        <li class="trk-action">
                                                                            <a onclick="deleteCrudItem(`{{ route('admin.roles.destroy', $row->id) }}`)"
                                                                                class="trk-action__item trk-action__item--danger">
                                                                                <i class="lni lni-trash-can"></i>
                                                                            </a>
                                                                        </li>
                                                                    @endcan

                                                                    <li class="trk-action">
                                                                        <a href="{{ route('admin.roles.show', $row->id) }}"
                                                                            class="trk-action__item trk-action__item--success">
                                                                            <i class="lni lni-protection"></i>
                                                                        </a>

                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-permissions" role="tabpanel"
                                aria-labelledby="nav-permissions-tab">
                                <div class="role permissions">
                                    <div class="container">
                                        <div class="tables_top-area">
                                            <span>Role</span>
                                            <select class="form-select search-select" data-live-search="true" name="role"
                                                aria-label="Default select example" id="role_id_permissions"
                                                onchange="syncRoleChange(this.value)">
                                                @foreach ($data as $item)
                                                    @if ($item->is_active)
                                                        <option value="{{ $item->id }}">{{ $item->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
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

                            <div class="tab-pane fade" id="nav-admins" role="tabpanel" aria-labelledby="nav-admins-tab">
                                <div class="row justify-content-center">
                                    <div class="col-lg-6">
                                        <div class="row g-4 justify-content-center mb-5">
                                            <div class="col-8">
                                                <div class="form-group d-flex align-items-center">
                                                    <span class="m-3">Role</span>
                                                    <select class="form-select search-select" data-live-search="true"
                                                        name="role" aria-label="Default select example"
                                                        id="role_id_admins" onchange="syncRoleChange(this.value)">
                                                        @foreach ($data as $item)
                                                            @if ($item->is_active)
                                                                <option value="{{ $item->id }}">{{ $item->name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-10">
                                                <div class="form-group">
                                                    <select class="multi-select form-select" multiple autocomplete="off"
                                                        name="admin_ids[]" id="admin_ids" placeholder="Select Admins..">
                                                        @foreach (App\Models\Admin::where('is_active', 1)->get() as $admin)
                                                            <option value="{{ $admin->id }}">{{ $admin->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group text-end">
                                                    <button class="btn btn-success"
                                                        onclick="AddUserRole()">{{ __('default.select') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="role_user_list">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal-->
            <div class="modal fade" id="adminDeleteModal">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-content">

                            <div class="modal-body">
                                <div class="delete-icon text-center mb-10 mt-5">
                                    <div class="bg-gray-200 rounded-circle demo-square demo-square-lg m-auto">

                                        <i class="flaticon2-trash icon-5x text-danger"></i>

                                    </div>


                                </div>

                                <div class="modal-text text-center mb-10">

                                    <h4 class="text-dark font-weight-bolder d-block mb-5">
                                        {{ __('message.you_are_about_to_delete_an_item!') }}
                                    </h4>
                                    <div class="text-muted font-weight-bold font-size-lg">
                                        {{ __('message.this_will_delete_you_item_permanently.') }}
                                        <br>
                                        {{ __('message.are_you_sure?') }}
                                    </div>

                                </div>



                                <div class="modal-bottom text-right">
                                    <button type="button"
                                        class="btn btn-light-success font-weight-bold btn-sm mr-3 font-size-lg"
                                        data-dismiss="modal">{{ __('button.cancel') }}</button>
                                    <button type="submit"
                                        class="btn btn-danger font-weight-bold btn-sm mr-10 font-size-lg"
                                        id="adminDeleteBtn"
                                        onclick="DeleteUserRole(this.value)">{{ __('button.delete') }}</button>
                                </div>


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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $('#multi_select').select2({
            placeholder: "Select Multiple"
        }); // nested
    </script>
    <script type="text/javascript">
        function Delete(route) {

            var form = document.getElementById('deleteForm');
            var attribute = document.createAttribute("action");
            attribute.value = route;
            form.setAttributeNode(attribute);

            $('#deleteModal').modal('show');
        }

        function updatePermissions() {

            var selected = [];
            $('#role_permission_list input:checked').each(function() {
                selected.push($(this).attr('name'));
            });

            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            console.log(csrf_token);
            $.ajax({
                url: "{{ url('admin/ajax/update-permissions') }}/" + $('#role_id_permissions').val(),
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrf_token
                },
                data: {
                    'permissions': selected
                },
                success: function(response) {
                    if (response) {
                        SwalFlash(true, 'Success', 'Permissions Updated Successfully.');
                    }else{
                        SwalFlash(true, 'Error', 'Something went wrong. Try again.');
                    }
                },
                error: function(errors) {
                    console.log(errors);
                }
            });

        }

        $(document).ready(function() {
            var role_id = $('#role_id_permissions').val();
            syncRoleChange(role_id);
        });



        function syncRoleChange(role) {
            $('#role_id_permissions').val(role);
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

        function AddUserRole() {
            var role_id = $('#role_id_permissions').val();
            var admin_ids = $('#admin_ids').val();
            $.ajax({
                url: "{{ url('admin/ajax/add-user-role') }}",
                type: "GET",
                data: {
                    "admin_ids": admin_ids,
                    "role_id": role_id
                },
                success: function(response) {
                    $('#role_user_list').html(response);
                },
                error: function(errors) {
                    console.log(errors);
                }
            });

        }

        function AdminDeleteModal(admin_id) {

            var btn = document.getElementById('adminDeleteBtn');
            var attribute = document.createAttribute("value");
            attribute.value = admin_id;
            btn.setAttributeNode(attribute);

            $('#adminDeleteModal').modal('show');
        }

        function DeleteUserRole(admin_id) {
            if (admin_id > 0) {
                var role_id = $('#role_id_permissions').val();
                $.ajax({
                    url: "{{ url('admin/ajax/delete-user-role') }}",
                    type: "GET",
                    data: {
                        "admin_id": admin_id,
                        "role_id": role_id
                    },
                    success: function(response) {
                        $('#role_user_list').html(response);
                    },
                    error: function(errors) {
                        console.log(errors);
                    }
                });
            }
            $('#adminDeleteModal').modal('hide');

        }
    </script>
    @parent
@endsection
