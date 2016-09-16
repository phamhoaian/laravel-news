<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function(){
	Route::group(['prefix' => 'theloai'], function(){
		Route::get('danhsach', 'TheLoaiController@getDanhSach');
		Route::get('sua', 'TheLoaiController@getSua');
		Route::get('them', 'TheLoaiController@getThem');
	});

	Route::group(['prefix' => 'loaitin'], function(){
		Route::get('danhsach', 'LoaiTinController@getDanhSach');
		Route::get('sua', 'LoaiTinController@getSua');
		Route::get('them', 'LoaiTinController@getThem');
	});

	Route::group(['prefix' => 'tintuc'], function(){
		Route::get('danhsach', 'TinTucController@getDanhSach');
		Route::get('sua', 'TinTucController@getSua');
		Route::get('them', 'TinTucController@getThem');
	});

	Route::group(['prefix' => 'comment'], function(){
		Route::get('danhsach', 'CommentController@getDanhSach');
		Route::get('sua', 'CommentController@getSua');
		Route::get('them', 'CommentController@getThem');
	});

	Route::group(['prefix' => 'slide'], function(){
		Route::get('danhsach', 'SlideController@getDanhSach');
		Route::get('sua', 'SlideController@getSua');
		Route::get('them', 'SlideController@getThem');
	});
});