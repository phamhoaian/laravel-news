<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Slide;

class SlideController extends Controller
{
    public function getDanhSach()
    {
        $slide = Slide::all();
    	return view('admin.slide.danhsach', ['slide' => $slide]);
    }

    public function getThem()
    {
    	return view('admin.slide.them');
    }

    public function postThem(Request $request)
    {
        $this->validate($request,
            [
                'Ten' => 'required|unique:Slide,Ten|min:3|max:100'
            ],
            [
                'Ten.required' => 'Bạn chưa nhập tên slide',
                'Ten.unique' => 'Tên slide đã tồn tại',
                'Ten.min' => 'Tên slide phải có độ dài từ 3 cho đến 100 ký tự',
                'Ten.max' => 'Tên slide phải có độ dài từ 3 cho đến 100 ký tự'
            ]);

        $slide = new Slide;
        $slide->Ten = $request->Ten;
        $slide->NoiDung = $request->NoiDung;
        $slide->link = $request->link;

        // check there is file update or not
        if($request->hasFile('Hinh'))
        {
            $file = $request->file('Hinh');
            $name = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();
            $allow_type = array('jpg', 'jpeg', 'png', 'gif');
            if(!in_array($ext, $allow_type))
            {
                return redirect('admin/slide/them')->with('loi', 'Chỉ cho phép upload hình ảnh');
            }
            $hinh = str_random(4)."_".$name;
            while (file_exists("upload/slide/".$hinh)) {
                $hinh = str_random(4)."_".$name;
            }
            $file->move("upload/slide", $hinh);
            $slide->Hinh = $hinh;
        }
        else
        {
            $slide->Hinh = "";
        }

        $slide->save();

        return redirect('admin/slide/them')->with('thongbao', 'Thêm slide thành công');
    }

    public function getSua($id)
    {
        $slide = Slide::find($id);
    	return view('admin.slide.sua', ['slide' => $slide]);
    }

    public function postSua(Request $request, $id)
    {
        $slide = Slide::find($id);
        $this->validate($request,
            [
                'Ten' => "required|unique:Slide,Ten,{$id}|min:3|max:100",
            ],
            [
                'Ten.required' => 'Bạn chưa nhập tên slide',
                'Ten.unique' => 'Tên slide đã tồn tại',
                'Ten.min' => 'Tên slide phải có độ dài từ 3 cho đến 100 ký tự',
                'Ten.max' => 'Tên slide phải có độ dài từ 3 cho đến 100 ký tự'
            ]);

        $slide->Ten = $request->Ten;
        $slide->NoiDung = $request->NoiDung;
        $slide->link = $request->link;

        // check there is file update or not
        if($request->hasFile('Hinh'))
        {
            $file = $request->file('Hinh');
            $name = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();
            $allow_type = array('jpg', 'jpeg', 'png', 'gif');
            if(!in_array($ext, $allow_type))
            {
                return redirect('admin/slide/them')->with('loi', 'Chỉ cho phép upload hình ảnh');
            }
            $hinh = str_random(4)."_".$name;
            while (file_exists("upload/slide/".$hinh)) {
                $hinh = str_random(4)."_".$name;
            }
            $file->move("upload/slide", $hinh);
            $slide->Hinh = $hinh;
        }
        else
        {
            $slide->Hinh = "";
        }

        $slide->save();

        return redirect('admin/slide/sua/'.$id)->with('thongbao', 'Chỉnh sửa slide thành công');
    }

    public function getXoa($id)
    {
        $slide = Slide::find($id);
        $slide->delete();

        return redirect('admin/slide/danhsach')->with('thongbao', 'Xóa slide thành công');
    }
}
