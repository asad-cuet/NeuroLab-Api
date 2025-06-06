@if (count($all_permissions) > 0)
    @php
        $checked_permissions = [];
        
    @endphp

    @foreach ($all_permissions as $row)
        @php
            $permission_base = substr($row->name, 0, strrpos($row->name, '-', -1));
        @endphp

        @if (in_array($permission_base, $checked_permissions))
        @else
            @php
                
                array_push($checked_permissions, $permission_base);
                
            @endphp
                <tr>
                    <th scope="row" class="text-capitalize">{{ str_replace('-', ' ', $permission_base) }}</th>
                    <td>
                        <div class="form-check form-switch form-switch-lg">
                            <input type="checkbox" value="1" class="form-check-input" role="switch" @if (in_array($permission_base . '-view', array_column($approved_permissions, 'name'))) checked="checked" @endif name="{{ $permission_base . '-view' }}" />
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-switch form-switch-lg">
                            <input type="checkbox" value="1" class="form-check-input" role="switch" @if (in_array($permission_base . '-create', array_column($approved_permissions, 'name'))) checked="checked" @endif name="{{ $permission_base . '-create' }}" />
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-switch form-switch-lg">
                            <input type="checkbox" value="1" class="form-check-input" role="switch" @if (in_array($permission_base . '-update', array_column($approved_permissions, 'name'))) checked="checked" @endif name="{{ $permission_base . '-update' }}" />
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-switch form-switch-lg">
                            <input type="checkbox" value="1" class="form-check-input" role="switch" @if (in_array($permission_base . '-delete', array_column($approved_permissions, 'name'))) checked="checked" @endif name="{{ $permission_base . '-delete' }}" />
                        </div>
                    </td>
                </tr>
        @endif
    @endforeach

@else
    <tr>
        <div class="easy_class">
        {{ __('default.no_permission_found..!') }}
        </div>
    </tr>
@endif