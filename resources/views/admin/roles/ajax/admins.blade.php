@if (count($admins) > 0)
<div class="admin">
@foreach ($admins as $admin)
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-6 col-6">
            <div class="alert alert-primary alert-dismissible fade show mb-3 admin-item" role="alert">
                <span> {{ $admin->email }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" onclick="AdminDeleteModal({{$admin->id}})"></button>
            </div>
        </div>
    </div>
    @endforeach
</div>

@else
<div class="admin">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-6 col-6">
            <div class="alert alert-primary alert-dismissible fade show mb-3 admin-item" role="alert">
                <span>No Admins</span>
            </div>
        </div>
    </div>
</div>
@endif