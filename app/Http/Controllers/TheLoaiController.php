<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TheLoaiController extends Controller
{
    public function getDanhSach()
    {
    	return view('admin.theloai.danhsach');
    }

    public function getThem()
    {
    	return view('admin.theloai.them');
    }

    public function getSua()
    {
    	return view('admin.theloai.sua');
    }
}
