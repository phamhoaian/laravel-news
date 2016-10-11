<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\TheLoai;
use App\Slide;

class PagesController extends Controller
{
	function __construct()
	{
		$theloai = TheLoai::all();
		$slide = Slide::all();
		view()->share('theloai', $theloai);
		view()->share('slide', $slide);
	}

    public function home()
    {
    	return view('pages.home');
    }
}
