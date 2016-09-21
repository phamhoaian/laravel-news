<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TinTuc;
use App\LoaiTin;
use App\TheLoai;
use App\Comment;

class TinTucController extends Controller
{
    public function getDanhSach()
    {
        $tintuc = TinTuc::orderBy('id', 'DESC')->get();
    	return view('admin.tintuc.danhsach', ['tintuc' => $tintuc]);
    }

    public function getThem()
    {
        $theloai = TheLoai::all();
    	$loaitin = LoaiTin::all();
    	return view('admin.tintuc.them', ['theloai' => $theloai, 'loaitin' => $loaitin]);
    }

    public function postThem(Request $request)
    {
        $this->validate($request,
            [
                'LoaiTin' => 'required',
                'TieuDe' => 'required|unique:TinTuc,TieuDe|min:3|max:100',
                'TomTat' => 'required',
                'NoiDung' => 'required'
            ],
            [
                'LoaiTin.required' => 'Bạn chưa chọn loại tin',
                'TieuDe.required' => 'Bạn chưa nhập tiêu đề',
                'TieuDe.unique' => 'Tiêu đề đã tồn tại',
                'TieuDe.min' => 'Tiêu đề phải có độ dài từ 3 cho đến 100 ký tự',
                'TieuDe.max' => 'Tiêu đề phải có độ dài từ 3 cho đến 100 ký tự',
                'TomTat.required' => 'Bạn chưa nhập tóm tắt',
                'NoiDung.required' => 'Bạn chưa nhập nội dung'
            ]);

        $tintuc = new TinTuc;
        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;
        $tintuc->NoiBat = $request->NoiBat;

        // check there is file update or not
        if($request->hasFile('Hinh'))
        {
            $file = $request->file('Hinh');
            $name = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();
            $allow_type = array('jpg', 'jpeg', 'png', 'gif');
            if(!in_array($ext, $allow_type))
            {
                return redirect('admin/tintuc/them')->with('loi', 'Chỉ cho phép upload hình ảnh');
            }
            $hinh = str_random(4)."_".$name;
            while (file_exists("upload/tintuc/".$hinh)) {
                $hinh = str_random(4)."_".$name;
            }
            $file->move("upload/tintuc", $hinh);
            $tintuc->Hinh = $hinh;
        }
        else
        {
            $tintuc->Hinh = "";
        }

        $tintuc->save();

        return redirect('admin/tintuc/them')->with('thongbao', 'Thêm tin tức thành công');
    }

    public function getSua($id)
    {
        $tintuc = TinTuc::find($id);
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
    	return view('admin.tintuc.sua', ['tintuc' => $tintuc, 'loaitin' => $loaitin, 'theloai' => $theloai]);
    }

    public function postSua(Request $request, $id)
    {
        $tintuc = TinTuc::find($id);
        $this->validate($request,
            [
                'LoaiTin' => 'required',
                'TieuDe' => 'required|unique:TinTuc,TieuDe,{$id}|min:3|max:100',
                'TomTat' => 'required',
                'NoiDung' => 'required'
            ],
            [
                'LoaiTin.required' => 'Bạn chưa chọn loại tin',
                'TieuDe.required' => 'Bạn chưa nhập tiêu đề',
                'TieuDe.unique' => 'Tiêu đề đã tồn tại',
                'TieuDe.min' => 'Tiêu đề phải có độ dài từ 3 cho đến 100 ký tự',
                'TieuDe.max' => 'Tiêu đề phải có độ dài từ 3 cho đến 100 ký tự',
                'TomTat.required' => 'Bạn chưa nhập tóm tắt',
                'NoiDung.required' => 'Bạn chưa nhập nội dung'
            ]);

        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;
        $tintuc->NoiBat = $request->NoiBat;

        // check there is file update or not
        if($request->hasFile('Hinh'))
        {
            $file = $request->file('Hinh');
            $name = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();
            $allow_type = array('jpg', 'jpeg', 'png', 'gif');
            if(!in_array($ext, $allow_type))
            {
                return redirect('admin/tintuc/them')->with('loi', 'Chỉ cho phép upload hình ảnh');
            }
            $hinh = str_random(4)."_".$name;
            while (file_exists("upload/tintuc/".$hinh)) {
                $hinh = str_random(4)."_".$name;
            }
            $file->move("upload/tintuc", $hinh);
            unlink("upload/tintuc/".$tintuc->Hinh);
            $tintuc->Hinh = $hinh;
        }

        $tintuc->save();
        return redirect('admin/tintuc/sua/'.$id)->with('thongbao', 'Chỉnh sửa tin tức thành công');
    }

    public function getXoa($id)
    {
        $tintuc = TinTuc::find($id);
        $tintuc->delete();

        return redirect('admin/tintuc/danhsach')->with('thongbao', 'Xóa tin tức thành công');
    }
}
