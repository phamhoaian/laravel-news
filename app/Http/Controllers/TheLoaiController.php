<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TheLoai;

class TheLoaiController extends Controller
{
    public function getDanhSach()
    {
        $theloai = TheLoai::all();
    	return view('admin.theloai.danhsach', ['theloai' => $theloai]);
    }

    public function getThem()
    {
    	return view('admin.theloai.them');
    }

    public function postThem(Request $request)
    {
        $this->validate($request,
            [
                'Ten' => 'required|unique:TheLoai,Ten|min:3|max:100'
            ],
            [
                'Ten.required' => 'Bạn chưa nhập tên thể loại',
                'Ten.unique' => 'Tên thể loại đã tồn tại',
                'Ten.min' => 'Tên thể loại phải có độ dài từ 3 cho đến 100 ký tự',
                'Ten.max' => 'Tên thể loại phải có độ dài từ 3 cho đến 100 ký tự'
            ]);

        $theloai = new TheLoai;
        $theloai->Ten = $request->Ten;
        $theloai->TenKhongDau = changeTitle($request->Ten);
        $theloai->save();

        return redirect('admin/theloai/them')->with('thongbao', 'Thêm thể loại thành công');
    }

    public function getSua($id)
    {
        $theloai = TheLoai::find($id);
    	return view('admin.theloai.sua', ['theloai' => $theloai]);
    }

    public function postSua(Request $request, $id)
    {
        $theloai = TheLoai::find($id);
        $this->validate($request,
            [
                'Ten' => "required|unique:TheLoai,Ten,{$id}|min:3|max:100"   
            ],
            [
                'Ten.required' => 'Bạn chưa nhập tên thể loại',
                'Ten.unique' => 'Tên thể loại đã tồn tại',
                'Ten.min' => 'Tên thể loại phải có độ dài từ 3 cho đến 100 ký tự',
                'Ten.max' => 'Tên thể loại phải có độ dài từ 3 cho đến 100 ký tự'
            ]);

        $theloai->Ten = $request->Ten;
        $theloai->TenKhongDau = changeTitle($request->Ten);
        $theloai->save();

        return redirect('admin/theloai/sua/'.$id)->with('thongbao', 'Chỉnh sửa thể loại thành công');
    }

    public function getXoa($id)
    {
        $theloai = TheLoai::find($id);
        $theloai->delete();

        return redirect('admin/theloai/danhsach')->with('thongbao', 'Xóa thể loại thành công');
    }
}
