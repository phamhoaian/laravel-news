@extends('admin.layout.index')

@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Tin tức
                    <small>danh sách</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            @if(session('thongbao'))
            <div class="alert alert-success">
                {{session('thongbao')}}
            </div>
            @endif
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr align="center">
                        <th>ID</th>
                        <th>Hình ảnh</th>
                        <th>Tiêu đề</th>
                        <th>Thể loại</th>
                        <th>Loại tin</th>
                        <th>Nổi bật</th>
                        <th>Lượt xem</th>
                        <th>Chỉnh sửa</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($tintuc as $row)
                    <tr class="odd gradeX" align="center">
                        <td>{{$row->id}}</td>
                        <td>
                            <img src="upload/tintuc/{{$row->Hinh}}" alt="{{$row->TieuDe}}">
                        </td>
                        <td>{{$row->TieuDe}}</td>
                        <td>{{$row->loaitin->theloai->Ten}}</td>
                        <td>{{$row->loaitin->Ten}}</td>
                        <td>
                        @if($row->NoiBat)
                            {{'Có'}}
                        @else
                            {{'Không'}}
                        @endif
                        </td>
                        <td>{{$row->SoLuotXem}}</td>
                        <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="admin/tintuc/sua/{{$row->id}}">Chỉnh sửa</a></td>
                        <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/tintuc/xoa/{{$row->id}}"> Xóa</a></td>
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