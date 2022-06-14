@extends(config('vgplay.roles.layout'))
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('roles.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="name">Tên</label>
                        <input readonly type="text" class="form-control mb-3" id="name" value="{{ $role->name }}">
                        @error('name')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Tên hiển thị</label>
                        <input required type="text" class="form-control mb-3" id="display_name" name="display_name"
                            value="{{ old('display_name', $role->display_name) }}">
                        @error('display_name')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    @if (!$role->isAdminRole())
                        <div class="form-group">
                            <label for="features">Chức năng có thể truy cập</label>
                            @foreach ($permissions as $permission)
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input"
                                        id="permission-{{ $permission->id }}" name="permissions[]"
                                        value="{{ $permission->id }}" @if (in_array($permission->id, $role->permissions->pluck('id')->toArray())) checked @endif>
                                    <label class="custom-control-label"
                                        for="permission-{{ $permission->id }}">{{ $permission->display_name }}</label>
                                </div>
                            @endforeach
                            @error('permissions')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    @endif
                    <div class="form-group ">
                        <button class="btn btn-success">Lưu lại</button>
                        <a data-action="{{ route('roles.destroy', $role->id) }}"
                            class="btn btn-danger btn-delete float-right">
                            <i class="fas fa-trash"></i>
                            Xoá</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <form method="POST" id="form-delete">
        @csrf
        @method('DELETE')
    </form>
@endsection
@push('scripts')
    <script>
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            let action = $(this).data('action');
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xoá?',
                text: "Sau khi xoá sẽ không thể phục hồi lại!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xoá!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-delete').attr('action', action);
                    $('#form-delete').submit();
                }
            })
        });
    </script>
@endpush
