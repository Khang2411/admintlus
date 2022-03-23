@extends('admin.dashboard.dashboard')
@section('content')
    <div class="container-fluid contact-form">
        <div class="contact-image">
            <img src="https://image.ibb.co/kUagtU/rocket_contact.png" alt="rocket_contact" />
        </div>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                <strong>{{ session('status') }}</strong>
            </div>
        @endif
        <form action="{{ url('admin/user/store') }}" method="post">
            @csrf
            <h3>Thêm thành viên</h3>
            <div class="row" style="align-items:center;">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Tên thành viên</label>
                        <input type="text" name="txtname" class="form-control" placeholder="Tên thành viên *" value="" />
                        @error('txtname')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">CCCD</label>
                        <input type="text" name="txtcccd" class="form-control" placeholder="CCCD*" value="" />
                        @error('txtname')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="txtemail" class="form-control" placeholder="Email *" value="" />
                        @error('txtemail')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">SĐT</label>
                        <input type="text" name="txtphone" class="form-control" placeholder="SĐT*" value="" />
                        @error('txtphone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Mật khẩu</label>
                        <input type="password" name="txtpass" class="form-control" placeholder="Mật khẩu*" />
                        @error('txtpass')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Xác nhận mật khẩu</label>
                        <input type="password" name="txtpass_confirmation" class="form-control"
                            placeholder="Xác nhận mật khẩu*" />
                        @error('txtpass_confirmation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="selectrole">Cấp quyền</label>
                        <select class="form-control" id="selectrole" name="selectrole">
                            <option selected value="">Chọn...</option>
                            <option value="1">Admitrator</option>
                            <option value="2">Subscriber</option>
                        </select>
                        @error('selectrole')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <textarea name="txtnote" class="form-control" placeholder="Ghi chú ... (không bắt buộc)"
                            style="width: 100%; height: 150px;"></textarea>
                    </div>
                    <div class="form-group" align="center">
                        <input type="submit" name="btnSubmit" class="btnContact" value="Thêm" />
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('css')
    <link href="{{ asset('css/testmix.css') }}" rel="stylesheet">
@endsection
