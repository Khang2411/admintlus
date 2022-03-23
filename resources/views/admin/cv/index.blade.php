@extends('admin.dashboard.dashboard')
@section('css')
    {{-- <meta http-equiv="refresh" content="5"> --}}
    <link href="{{ asset('/css/testmix.css') }}" rel="stylesheet">
    <script src="{{ asset('js/libs/moment.min.js') }}"></script>
    <script href="{{ asset('js/libs/moment-locales.min.js') }}" rel="stylesheet"></script>
@endsection
@section('content')
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h1 class="h3 mb-2 text-gray-800">Danh sách hồ sơ nhập học 2022</h1>
                <a href="{{ url('admin/user/add') }}" class="text-secondary"><i class="fa fa-plus"
                        aria-hidden="true"></i>
                    Thêm hồ sơ</a>
            </div>
            <div class="card-body">
                <div class="analytic" style="padding-bottom:2%;">
                    <a href="{{ request()->fullurlwithquery(['status' => 'active']) }}" class="text-success"
                        data-v="status" data-style="actived">Tất cả<span class="text-muted">(2)</span></a>

                    <a href="{{ request()->fullurlwithquery(['status' => 'trash']) }}" class="text-danger"
                        data-v="recording" data-style="disable">Đã xóa<span class="text-muted">(0)</span></a>
                </div>
                <form action="{{ url('admin/user/action') }}" method="post">
                    @csrf
                    <div class="form-action form-inline" style="padding-bottom:2% ">
                        <select class="form-control mr-1" name="action">
                            <option value="">Chọn</option>


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
                                    <th>Tên</th>
                                    <th>Giới tính</th>
                                    <th>Điện thoại</th>
                                    <th>Tỉnh/Thành</th>
                                    <th>Nguyện vọng</th>
                                    <th>Ngày tạo</th>
                                    <th>Tác vụ</th>
                                </tr>
                            </thead>

                            <tbody>


                                @php
                                    $stt = 0;
                                @endphp
                                @foreach ($cvs as $cv)
                                    <th>
                                        <input type="checkbox" name="list_check[]" value="" id="checkAll">
                                    </th>
                                    <td>{{ $stt + 1 }}</td>
                                    <td>{{ $cv->surname . ' ' . $cv->name }}</td>
                                    <td>{{ $cv->gender == 1 ? 'Nam' : 'Nữ' }}</td>
                                    <td>{{ $cv->phone }}</td>
                                    <td>{{ $cv->region }}</td>
                                    <td>{{ $cv->aspiration }}</td>
                                    <td>{{ date('d/m/Y', strtotime($cv->updated_at)) }}
                                        <p class="moment_time"> {{ \Carbon\Carbon::parse($cv->updated_at)->diffForHumans() }}</p>
                                    </td>
                                    <td>
                                        <a href="{{ url("$cv->slug_pdf") }}" target="_blank"><button type="button"
                                                class="btn btn-primary">
                                                <i class="fas fa-file-pdf"></i></button></a>

                                        <button type="button" class="btn btn-warning btn-delete">
                                            <i class="fa fa-trash"></i></button>
                                    </td>
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                </form>
            </div>
        </div>

    </div>
    {{ $cvs->links() }}
@endsection
@section('js')
    <script src="{{ asset('js/libs/sweet_alert.min.js') }}"></script>
    <script src="{{ asset('js/user-list.js') }}"></script>
@endsection
