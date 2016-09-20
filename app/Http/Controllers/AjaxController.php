<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\LoaiTin;

class AjaxController extends Controller
{
	public function getLoaiTin($idTheLoai)
	{
		$loaitin = LoaiTin::where('idTheLoai', $idTheLoai)->get();
		foreach ($loaitin as $row) {
			echo "<option value='".$row->id."'>".$row->Ten."</option>";
		}
	}
}
