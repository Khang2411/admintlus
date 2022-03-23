<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>PDF Hồ Sơ Sinh Viên Đăng Ký Nhập Học</title>
    <style>
        .infor {
            float: left;
            width: 50%;
        }

        .address-infor {
            float: left;
            width: 50%;
        }

        .aspirations-infor {
            float: left;
            width: 50%;
        }

        h5 {
            color: #056839 !important;
            font-weight: bold !important;
        }

        h4 {
            color: #003399 !important;
            font-weight: bold !important;
        }

        span {
            margin-right: 0.5rem;
        }

    </style>
</head>

<body>
    <div class="per-infor">
        <h4>THÔNG TIN THÍ SINH</h4>
        <div class="infor">
            <span>Họ tên:</span>
            <span>{{ $inforAll[0]['surname'] }} {{ $inforAll[0]['name'] }}</span>
        </div>

        <div class="infor">
            <span>Ngày sinh:</span>
            <span>{{ $inforAll[0]['birthday'] }}</span>
        </div>
        <div style="clear: both;margin-top:0.5rem;"></div>
        <div class="infor">
            <span>Giới tính:</span>
            <span>{{ $inforAll[0]['gender'] == '1' ? 'Nam' : 'Nữ' }} </span>
        </div>
        <div class="infor">
            <span>CCCD/CMND:</span>
            <span>{{ $inforAll[0]['cccd'] }}</span>
        </div>
        <div style="clear: both;margin-top:0.5rem;"></div>
        <div class="infor">
            <span>SĐT:</span>
            <span>{{ $inforAll[0]['phone'] }}</span>
        </div>
        <div style="clear: both;margin-top:0.5rem;"></div>
        <h5>Địa chỉ thường trú</h5>
        <div class="address-infor">
            <span>Tỉnh/Thành:</span>
            <span>{{ $region->name }}</span>
        </div>
        <div class="address-infor">
            <span>Quận/Huyện:</span>
            <span>{{ $district->name }}</span>
        </div>
        <div style="clear: both;margin-top:0.5rem;"></div>
        <div class="address-infor">
            <span>Phường/Xã:</span>
            <span>{{ $ward->name }}</span>
        </div>
        <div class="address-infor">
            <span>Số nhà:</span>
            <span>{{ $inforAll[0]['apartment_number'] }}</span>
        </div>
        <h5>Địa chỉ tạm trú (nếu có)</h5>
        <div class="address-infor">
            <span>Tỉnh/Thành:</span>
            <span>{{ $tem_region == null ? '' : $tem_region->name }}</span>
        </div>
        <div class="address-infor">
            <span>Quận/Huyện:</span>
            <span>{{ $tem_district == null ? '' : $tem_district->name }}</span>
        </div>
        <div style="clear: both;margin-top:0.5rem;"></div>
        <div class="address-infor">
            <span>Phường/Xã:</span>
            <span>{{ $tem_ward == null ? '' : $tem_ward->name }}</span>
        </div>
        <div class="address-infor">
            <span>Số nhà:</span>
            <span>{{ $inforAll[0]['tem_apartment_number'] }}</span>
        </div>
        <div style="clear: both;margin-top:0.5rem;"></div>
        <h5>Tên trường học lớp 12</h5>
        <div class="school-infor">
            <span>Tên trường:</span>
            <span>{{ $inforAll[0]['school_name'][0] }}</span>
        </div>

        <h4>THÔNG TIN ĐĂNG KÝ</h4>
        <div class="aspirations-infor">
            <span>Nguyện vọng:</span>
            <span>{{ $aspiration->name }}</span>
        </div>
        <div class="aspirations-infor">
            <span>Tổ hợp:</span>
            <span>{{ $combinationSubjects->name }}</span>
        </div>
        <div style="clear: both;margin-top:0.5rem;"></div>
        <h4>THÔNG TIN KHẢO SÁT</h4>
        <div class="image-infor">
            <p style="color:#003399">Ảnh CCCD/CMND</p>
            <br>
            <div>
                <img src="{{ url("/storage/app/public/{$urlImg['imgFrontCCCD']}") }}" alt="cccd" width="540"
                    height="298">
                <img src="{{ url("/storage/app/public/{$urlImg['imgBackCCCD']}") }}" alt="cccd" width="540"
                    height="298">
            </div>
        </div>
        <div class="image-infor">
            <p style="color:#003399">Ảnh Giấy Tốt Nghiệp Tạm Thời</p>
            <br>
            <div style="text-align:center">
                <img src="{{ url("/storage/app/public/{$urlImg['graduate']}") }}" alt="cccd" width="540"
                    height="298">
            </div>
        </div>
        <div class="image-infor">
            <p style="color:#003399">Ảnh 3x4</p>
            <br>
            <div style="text-align:center">
                <img src="{{ url("/storage/app/public/{$urlImg['3x4']}") }}" alt="cccd" width="540" height="298">
            </div>
        </div>
    </div>
    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

</body>

</html>
