@extends(config('vgplay.roles.layout'))

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tên</label>
                        <input required type="text" class="form-control mb-3" id="name" name="name"
                            value="{{ old('name') }}">
                        @error('name')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="display_name">Tên hiển thị</label>
                        <input required type="text" class="form-control mb-3" id="display_name" name="display_name"
                            value="{{ old('display_name') }}">
                        @error('display_name')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="features">Chức năng có thể truy cập</label>
                        @foreach ($permissions as $permission)
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="permission-{{ $permission->id }}"
                                    name="permissions[]" value="{{ $permission->id }}">
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
                    <div class="form-group">
                        <button class="btn btn-success">Lưu lại</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
