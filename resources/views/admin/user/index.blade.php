@extends('admin.dashboard.dashboard')
@section('css')
    {{-- <meta http-equiv="refresh" content="5"> --}}
    {{-- <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('/css/testmix.css') }}" rel="stylesheet">

@endsection
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                <strong>{{ session('status') }}</strong>
            </div>
        @endif
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h1 class="h3 mb-2 text-gray-800">Danh sách thành viên</h1>
                <a href="{{ url('admin/user/add') }}" class="text-secondary"><i class="fa fa-plus"
                        aria-hidden="true"></i>
                    Thêm thành viên</a>
            </div>
            <div class="card-body">
                <div class="analytic" style="padding-bottom:2%;">
                    <a href="{{ request()->fullurlwithquery(['status' => 'active']) }}" class="text-success"
                        data-v="status" data-style="actived">Đã kích hoạt<span class="text-muted">(2)</span></a>
                    <a href="{{ request()->fullurlwithquery(['status' => 'trash']) }}" class="text-danger"
                        data-v="recording" data-style="disable">Vô hiệu hóa<span class="text-muted">(0)</span></a>
                </div>
                <form action="{{ url('admin/user/action') }}" method="post">
                    @csrf
                    <div class="form-action form-inline" style="padding-bottom:2% ">
                        <select class="form-control mr-1" name="action">
                            <option value="">Chọn</option>
                            @foreach ($list_action as $key => $values)
                                <option value="{{ $key }}">{{ $values }}</option>
                            @endforeach

                        </select>
                        <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" name="checkall" id="checkAll">
                                    </th>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>CCCD</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Quyền</th>
                                    <th>Ngày tạo</th>
                                    {{-- <th>Ghi chú</th> --}}
                                    <th>Tác vụ</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $stt = 1;
                                @endphp
                                @foreach ($users as $user)
                                    <tr id="tr{{ $user->id }}"">
                                        <th>
                                            <input class=" check" type="checkbox"name="list_check[]" value="{{ $user->id }}">
                                        </th>
                                        <th scope="row">
                                            {{-- {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }} --}}
                                            {{ $stt++ }}
                                        </th>
                                        <td class="name">{{ $user->name }}</td>
                                        <td class="name">{{ $user->cccd }}</td>
                                        <td class="email">{{ $user->email }}</td>
                                        <td class="phone">{{ $user->phone }}</td>
                                        <td class="role">{{ $user->role_id==1?"Administrator":"Subscriber" }}</td>
                                        <td class="updated_at">{{ $user->updated_at }}</td>
                                        <td>
                                            @if (Auth::id() != $user->id)
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#editModal" data-bs-id={{ $user->id }}">
                                                    <i class="fa fa-edit"></i></button>
                                            @endif
                                            @if (Auth::id() != $user->id)
                                                <button type="button" class="btn btn-warning btn-delete">
                                                    <i class="fa fa-trash"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>

    </div>
    {{ $users->links() }}
    {{-- Modal edit user --}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cập nhật</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" id="txtid" />
                        <div class="form-group">
                            <label for="txtname" class="col-form-label">Tên thành viên:</label>
                            <input type="text" class="form-control" id="txtname" name="txtname">
                        </div>
                        <div class="form-group">
                            <label for="txtemail" class="col-form-label">Email:</label>
                            <input type="email" class="form-control" id="txtemail" name="txtemail" disabled>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">SDT:</label>
                            <input type="text" class="form-control" id="txtphone">
                        </div>
                        <div class="form-group">
                            <label for="txtsalary" class="col-form-label">Lương:</label>
                            <input type="text" class="form-control" id="txtsalary" name="txtsalary">
                        </div>
                        <div class="form-group">
                            <label for="selectrole">Cấp quyền</label>
                            <select class="form-control" id="selectrole" name="selectrole">
                                <option selected value="">Chọn...</option>
                                <option value="1">Admitrator</option>
                                <option value="2">Subscriber</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Ghi chú:</label>
                            <textarea class="form-control" id="txtnote" style="height: 145px;"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" id="btn_sendmodal_edit">Cập nhật</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!-- Core plugin JavaScript-->
    {{-- <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script> --}}
    <script src="{{ asset('js/libs/sweet_alert.min.js') }}"></script>
    <script src="{{ asset('js/user-list.js') }}"></script>
@endsection
