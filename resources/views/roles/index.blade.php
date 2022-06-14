@extends(config('vgplay.roles.layout'))

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover" id="datatable">
                    <thead>
                        <tr>
                            <th>Tên</th>
                            <th>Tên hiển thị</th>
                            <th>Ngày tạo</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($roles) > 0)
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $role->name ?? '' }}</td>
                                    <td>{{ $role->display_name ?? '' }}</td>
                                    <td>{{ is_null($role->created_at) ? '' : $role->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        @if (auth(config('vgplay.roles.guard'))->user()->can(config('vgplay.roles.roles.permissions.update')))
                                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                                Sửa
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('#datatable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "autoWidth": false,
            "responsive": true,
            "language": {
                "processing": "Đang xử lý...",
                "infoFiltered": "(được lọc từ _MAX_ mục)",
                "emptyTable": "Không có dữ liệu",
                "info": "Hiển thị _START_ tới _END_ của _TOTAL_ bản ghi",
                "infoEmpty": "Hiển thị 0 tới 0 của 0 bản ghi",
                "lengthMenu": "Hiển thị _MENU_ bản ghi",
                "loadingRecords": "Đang tải...",
                "paginate": {
                    "first": "Đầu tiên",
                    "last": "Cuối cùng",
                    "next": "Sau",
                    "previous": "Trước"
                },
                "search": "Tìm kiếm:",
                "zeroRecords": "Không tìm thấy kết quả"
            }
        });
    </script>
@endpush
