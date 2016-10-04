<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\User;

class UserController extends Controller
{
    public function getDanhSach()
    {
        $users = User::all();
    	return view('admin.user.danhsach', ['users' => $users]);
    }

    public function getThem()
    {
    	return view('admin.user.them');
    }

    public function postThem(Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required|unique:users,name|min:3|max:100',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:3|max:32',
                'repassword' => 'required|same:password'
            ],
            [
                'name.required' => 'Bạn chưa nhập tên thành viên',
                'name.unique' => 'Tên thành viên đã tồn tại',
                'name.min' => 'Tên thành viên phải có độ dài từ 3 cho đến 100 ký tự',
                'name.max' => 'Tên thành viên phải có độ dài từ 3 cho đến 100 ký tự',
                'email.required' => 'Bạn chưa nhập email',
                'email.unique' => 'Email đã được sử dụng',
                'password.required' => 'Bạn chưa nhập mật khẩu',
                'password.min' => 'Mật khẩu phải có độ dài từ 3 cho đến 32 ký tự',
                'password.max' => 'Tên thành viên phải có độ dài từ 3 cho đến 32 ký tự',
                'repassword.required' => 'Bạn chưa nhập mật khẩu xác nhận',
                'repassword.same' => 'Mật khẩu xác nhận không trùng khớp'
            ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->permissions = $request->permissions;
        $user->save();

        return redirect('admin/user/them')->with('thongbao', 'Thêm thành viên thành công');
    }

    public function getSua($id)
    {
        $user = User::find($id);
    	return view('admin.user.sua', ['user' => $user]);
    }

    public function postSua(Request $request, $id)
    {
        $user = User::find($id);
        $this->validate($request,
            [
                'name' => "required|unique:users,name,{$id}|min:3|max:100",
                'email' => "required|email|unique:users,email,{$id}",
                'password' => 'min:3|max:32',
                'repassword' => 'same:password'
            ],
            [
                'name.required' => 'Bạn chưa nhập tên thành viên',
                'name.unique' => 'Tên thành viên đã tồn tại',
                'name.min' => 'Tên thành viên phải có độ dài từ 3 cho đến 100 ký tự',
                'name.max' => 'Tên thành viên phải có độ dài từ 3 cho đến 100 ký tự',
                'email.required' => 'Bạn chưa nhập email',
                'email.unique' => 'Email đã được sử dụng',
                'password.min' => 'Mật khẩu phải có độ dài từ 3 cho đến 32 ký tự',
                'password.max' => 'Tên thành viên phải có độ dài từ 3 cho đến 32 ký tự',
                'repassword.same' => 'Mật khẩu xác nhận không trùng khớp'
            ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password != "")
        {
        	$user->password = bcrypt($request->password);
        }
        $user->permissions = $request->permissions;
        $user->save();

        return redirect('admin/user/sua/'.$id)->with('thongbao', 'Chỉnh sửa thành viên thành công');
    }

    public function getXoa($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('admin/user/danhsach')->with('thongbao', 'Xóa thành viên thành công');
    }

    public function getLogin()
    {
        return view('admin.login');
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ],[
            'email.required' => 'Bạn chưa nhập email',
            'password.required' => 'Bạn chưa nhập password'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            return redirect('admin/user/danhsach');
        }
        else
        {
            return redirect('admin/login')->with('thongbao', 'Email hoặc mật khẩu sai');
        }
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect('admin/login');
    }
}
