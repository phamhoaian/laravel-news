@extends('admin.layout.index')

@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Tin tức
                    <small>chỉnh sửa</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">
                @if(count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $err)
                            <li>{{$err}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('thongbao'))
                    <div class="alert alert-success">
                        {{session('thongbao')}}
                    </div>
                @endif

                @if(session('loi'))
                    <div class="alert alert-danger">
                        {{session('loi')}}
                    </div>
                @endif
                <form action="admin/tintuc/sua/{{$tintuc->id}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                        <label>Thể loại</label>
                        <select class="form-control" name="TheLoai" id="TheLoai">
                            <option value="">Chọn thể loại</option>
                            @foreach($theloai as $row)
                            <option value="{{$row->id}}" @if($row->id == $tintuc->loaitin->idTheLoai) {{"selected"}} @endif>{{$row->Ten}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Loại tin</label>
                        <select class="form-control" name="LoaiTin" id="LoaiTin">
                            <option value="">Chọn loại tin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tiêu đề</label>
                        <input class="form-control" name="TieuDe" placeholder="Nhập tiêu đề tin tức" value="{{$tintuc->TieuDe}}"/>
                    </div>
                    <div class="form-group">
                        <label>Tóm tắt</label>
                        <textarea class="form-control ckeditor" name="TomTat" cols="30" rows="10" placeholder="Nhập mô tả ngắn của tin tức">{{$tintuc->TomTat}}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Nội dung</label>
                        <textarea class="form-control ckeditor" name="NoiDung" cols="30" rows="10" placeholder="Nhập nội dung đầy đủ của tin tức">{{$tintuc->NoiDung}}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Hình ảnh</label>
                        @if($tintuc->Hinh)
                        <img src="upload/tintuc/{{$tintuc->Hinh}}" alt="{{$tintuc->Hinh}}" width="100">
                        @else
                        <input type="file" name="Hinh" class="form-control">
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Nổi bật</label>
                        <label class="radio-inline">
                            <input name="NoiBat" value="1" type="radio" @if($tintuc->NoiBat) {{"checked"}} @endif>Có
                        </label>
                        <label class="radio-inline">
                            <input name="NoiBat" value="2" type="radio" @if(!$tintuc->NoiBat) {{"checked"}} @endif>Không
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Chỉnh sửa</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                <form>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Bình luận
                    <small>danh sách</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr align="center">
                        <th>ID</th>
                        <th>Người dùng</th>
                        <th>Nội dung</th>
                        <th>Ngày đăng</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($tintuc->comment as $row)
                    <tr class="odd gradeX" align="center">
                        <td>{{$row->id}}</td>
                        <td>{{$row->user->name}}</td>
                        <td>{{$row->NoiDung}}</td>
                        <td>{{$row->created_at}}</td>
                        <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/comment/xoa/{{$row->id}}/{{$tintuc->id}}"> Xóa</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            var idTheLoai = $('#TheLoai').val();
            $.get('admin/ajax/loaitin/' + idTheLoai, function(data){
                $('#LoaiTin').html(data);
            });

            $('#TheLoai').on('change', function(){
                var idTheLoai = $(this).val();
                $.get('admin/ajax/loaitin/' + idTheLoai, function(data){
                    $('#LoaiTin').html(data);
                });
            });
        });
    </script>
@endsection