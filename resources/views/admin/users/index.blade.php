@extends('admin.layouts.master')

@section('title')
    Admin Dashboard
@endsection

@section('container')
@if($errors->any())
{{$errors}}
@endif
    <div class="trk-table">
        <div class="trk-table__wrapper">
            <div class=" trk-table__header d-flex flex-wrap align-items-center gap-3 justify-content-between">
                <div class="trk-table__title">
                    <h5>{{ $info->title }}</h5>
                    <p>{{ $info->description }}</p>
                </div>
                <div>
                    @can('user-create')
                        <a href="{{ route($info->first_button_route) }}" class="btn btn-primary">

                            <i class="flaticon2-add"></i>

                            {{ $info->first_button_title }}
                        </a>
                    @endcan
                </div>
            </div>
            <div class="trk-table__body">
                <div class="table__top">
                    <div class="table__top-dropdown">
                        <label>
                            <select class="selector" name="per_page" id="per_page" onchange="filterPerPage(this)">
                                <option value="5" @if ($per_page == 5) selected @endif>5</option>
                                <option value="10" @if ($per_page == 10) selected @endif>10</option>
                                <option value="15" @if ($per_page == 15) selected @endif>15</option>
                                <option value="20" @if ($per_page == 20) selected @endif>20</option>
                                <option value="25" @if ($per_page == 25) selected @endif>25</option>
                            </select> entries per page
                        </label>
                    </div>
                    <div class="table__top-search">
                        <div class="input-group">
                            <input type="text" id="search" class="form-control" placeholder="Search..."
                                value="{{ request()->search }}" onkeypress="searchOnEnter(event, this)" aria-label="Search">
                        </div>
                    </div>
                </div>
                <table class="table" id="">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th>{{ __('field.avatar') }}</th>
                            <th>{{ __('field.name') }}</th>
                            <th>{{ __('field.email') }}</th>
                            <th>{{ __('field.phone') }}</th>
                            <th>Login</th>
                            <th>Logout</th>
                            <th>{{ __('field.is_active') }}</th>
                            <th>{{ __('column.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $serial = 1;
                            @endphp

                            @foreach ($data as $row)
                            <tr>
                                <td>{{ $serial }}</td>
                                <td>
                                    <div class="trk-item d-flex gap-2">
                                        <div class="trk-thumb thumb-md">
                                            <img src="@if ($row->avatar != '') {{ asset($row->avatar) }} @else {{ asset(avatarUrl()) }} @endif"
                                                alt="avatar">
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->email }}</td>
                                <td>{{ $row->phone }}</td>
                                <td><a href="{{ route('admin.users.frontend.login', $row->id) }}" target="_blank" class="btn btn-exsm btn-tertiary">Login</a></td>
                                <td>
                                    <button onclick="openLogoutModal({{$row->id}})"
                                        class="btn btn-exsm btn-danger">
                                        Logout
                                    </button>
                                </td>
                                <td>
                                    <div class="form-check form-switch form-switch-lg">
                                        <input type="checkbox" name="is_active" value="{{ $row->id }}"
                                            onclick="toggleSwitchStatus(this,'users');" class="form-check-input"
                                            @if ($row->is_active == 1) checked @endif>
                                    </div>
                                </td>
                                <td>
                                    <ul class="trk-action__list">
                                        <li class="trk-action">
                                            <a href="{{ route('admin.users.show', $row->id) }}"
                                                class="trk-action__item trk-action__item--success">
                                                <i class="lni lni-eye"></i>
                                            </a>
                                        </li>
    
                                        @can('user-update')
                                            <li class="trk-action">
                                                <a href="{{ route('admin.users.edit', $row->id) }}"
                                                    class="trk-action__item trk-action__item--warning">
                                                    <i class="lni lni-pencil-alt"></i>
                                                </a>
                                            </li>
                                        @endcan

                                        @can('user-delete')
                                            <li class="trk-action">
                                                <a onclick="deleteCrudItem(`{{ route('admin.users.destroy', $row->id) }}`, `{{$info->title}}`)"
                                                    class="trk-action__item trk-action__item--danger">
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
                {{ $data->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
    @include('admin.components.modals.delete')
    @include('admin.users.components.logout')

@endsection

@section('js')
@parent

<script type="text/javascript">
    function openLogoutModal(userId) 
    {
        $('#logoutModal').modal('show');

        $.ajax({
            url: `/admin/users-api/${userId}/login-history`, 
            method: 'GET',
            success: function (data) {
                let tableBody = $('#loginHistoryTable');
                tableBody.html(''); 

                data.forEach(session => {
                    tableBody.append(`
                        <tr>
                            <td>${session.ip_address || 'N/A'}</td>
                            <td>${session.user_agent}</td>
                            <td>${new Date(session.last_activity * 1000).toLocaleString()}</td>
                            <td>
                                <button class="btn btn-danger" onclick="logoutSession('${session.id}')">Logout</button>
                            </td>
                        </tr>
                    `);
                });

                $('#logout_all_session_btn').attr('onclick', "logoutAllSessions("+userId+")");

                $('#logoutModal').modal('show');
            },
            error: function (xhr) {
                alert('Error fetching login history: ' + xhr.responseText);
            }
        });
    }


    function logoutSession(sessionId) {
        $.ajax({
            url: "{{route('admin.users-api.logout.session')}}",
            method: 'POST',
            data: {
                session_id: sessionId,
                _token: $('meta[name="csrf-token"]').attr('content'), 
            },
            success: function (data) {
                alert(data.message);
                $('#logoutModal').modal('hide');
            },
            error: function (xhr) {
                alert('Error logging out from session: ' + xhr.responseText);
            }
        });
    }


    function logoutAllSessions(userId) {
        $.ajax({
            url: "{{route('admin.users-api.logout.all.session')}}",
            method: 'POST',
            data: {
                user_id: userId,
                _token: $('meta[name="csrf-token"]').attr('content'), 
            },
            success: function (data) {
                alert(data.message);
                $('#logoutModal').modal('hide'); // Close modal
            },
            error: function (xhr) {
                alert('Error logging out from all sessions: ' + xhr.responseText);
            }
        });
    }

</script>
@endsection
