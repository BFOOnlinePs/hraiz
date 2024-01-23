@extends('home')
@section('title')
    خطوط الانتاج
@endsection
@section('header_title')
    خطوط الانتاج
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    خطوط الانتاج
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')

    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-default">اضافة خط انتاج
    </button>
    <div class="card">
        <div class="card-header">
            <h3 class="text-center">قائمة خطوط الانتاج</h3>
        </div>
        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">

                    <div class="col-sm-12">
                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline"
                               aria-describedby="example1_info">
                            <thead>
                            <tr>
                                <th>صورة</th>
                                <th>اسم خط الانتاج</th>
                                <th>ملاحظات</th>
                                <th>العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($data->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center">لا توجد بيانات</td>
                                </tr>
                            @else
                                @foreach($data as $key)
                                    <tr>
                                        <td>
                                            <img width="100px" src="{{ asset('storage/production/'.$key->production_image) }}" alt="">
                                        </td>
                                        <td>{{ $key->production_name }}</td>
                                        <td>
                                            {{ $key->production_notes }}
                                        </td>
                                        <td>
                                            <a class="btn btn-success btn-sm" href="{{ route('production.edit',['id'=>$key->id]) }}"><span class="fa fa-edit"></span></a>
                                            <a class="btn btn-dark btn-sm" href="{{ route('production.production_inputs.index',['id'=>$key->id]) }}"><span class="fa fa-search"></span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <form action="{{ route('production.create') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">اضافة خط انتاج</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">اسم خط الانتاج</label>
                                    <input name="production_name" class="form-control" type="text"
                                           placeholder="اكتب اسم خط الانتاج" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">المنتج</label>
                                    <select class="form-control select2bs4" required name="product_id" id="">
                                        <option value="">اختر منتج ...</option>
                                        @foreach($products as $key)
                                            <option value="{{ $key->id }}">{{ $key->product_name_ar }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">صورة للعلم</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="production_image" class="custom-file-input"
                                                   id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">اختر ملف</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">رفع الصورة</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">ملاحظات</label>
                                    <textarea class="form-control" name="production_notes" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>

                </div>
            </form>

        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endsection

