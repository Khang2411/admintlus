<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    //
    function list()
    {
        $list_action = ['delete' => 'Xóa tạm thời'];
        if (request()->status == 'trash') {
            $users = User::onlyTrashed()->get();
            $list_action = ['restore' => 'Khôi phục', 'force_delete' => 'Xóa vĩnh viễn'];
        } else {
            $users = User::paginate(15);
        }
        return view('admin.user.index', compact('users', 'list_action'));
    }

    function add()
    {
        return view('admin.user.add');
    }
    function store()
    {

        request()->validate(
            [
                'txtname' => 'required',
                'txtcccd' => "required",
                'txtemail' => 'required|email|unique:users,email',
                'txtphone' => 'required|regex:/^[0-9\-\(\)\/\+\s]*$/|max:10',
                'txtpass' => 'required|confirmed',
                'txtpass_confirmation' => 'required',
                'selectrole' => 'required',
                'txtnote' => 'max:255'
            ],
            [
                'txtname.required' => "Chưa nhập tên",
                'txtcccd.required' => "Chưa nhập CCCD",
                'txtemail.required' => 'Chưa nhập Email',
                'txtemail.email' => 'Không phải là Email',
                'txtemail.unique' => 'Email đã tồn tại',
                'txtphone.required' => 'Chưa nhập SĐT',
                'txtphone.regex' => 'Không phải SĐT',
                'txtphone.max' => 'SĐT phải là 10 số',
                'txtpass.required' => 'Chưa nhập mật khẩu',
                'txtpass.confirmed' => 'Xác nhận mật khẩu không chính xác',
                'txtpass_confirmation.required' => 'Chưa nhập xác nhận mật khẩu',
                'selectrole.required' => 'Chưa cấp quyền',
                'txtnote.max' => 'Quá 255 ký tự'
            ]
        );
        // return $user = request()->all();
        // $user['txtpass'] = Hash::make(request()->input('txtpass'));
        // User::create($user);
        User::create(
            [
                "cccd" => request()->txtcccd,
                'name' => request()->txtname,
                'email' => request()->txtemail,
                'password' => Hash::make(request()->txtpass),
                'phone' => request()->txtphone,
                'role_id' => request()->selectrole,
                'note' => request()->txtnote,
                "current_team_id" => 2
            ]
        );

        return redirect('admin/user/list')->with(['status' => "Thêm thành công"]);
    }
}
