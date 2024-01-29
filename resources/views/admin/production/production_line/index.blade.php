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

    <div class="row">
        <div class="col-md-10">
            <input onkeyup="production_lines_table_ajax()" type="text" id="search_production_line" class="form-control" placeholder="البحث عن خط انتاج">
            <div class="card mt-3">
                {{--        <div class="card-header">--}}
                {{--            <h3 class="text-center">قائمة خطوط الانتاج</h3>--}}
                {{--        </div>--}}
                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <div id="production_lines_table">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-sm form-control btn-dark mb-2" data-toggle="modal" data-target="#modal-default">اضافة خط انتاج
            </button>
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
                                    <label for="">المنتج</label>
                                    <select onchange="get_product_name_for_add_production_name_ajax()" class="form-control select2bs4" required name="product_id" id="selected_product">
                                        <option value="">اختر منتج ...</option>
                                        @foreach($products as $key)
                                            <option value="{{ $key->id }}">{{ $key->product_name_ar }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">اسم خط الانتاج</label>
                                    <input id="production_name" name="production_name" class="form-control" type="text"
                                           placeholder="اكتب اسم خط الانتاج" required>
                                </div>
                            </div>
{{--                            <div class="col-md-12">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">صورة المنتج</label>--}}
{{--                                    <div class="input-group">--}}
{{--                                        <div class="custom-file">--}}
{{--                                            <input type="file" name="production_image" class="custom-file-input"--}}
{{--                                                   id="exampleInputFile">--}}
{{--                                            <label class="custom-file-label" for="exampleInputFile">اختر ملف</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="input-group-append">--}}
{{--                                            <span class="input-group-text">رفع الصورة</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
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
                        <button type="submit" class="btn btn-dark">حفظ</button>
                    </div>

                </div>
            </form>

        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            production_lines_table_ajax();
        });
        function production_lines_table_ajax(){
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('production.production_inputs.production_lines_table_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'search_production_line': document.getElementById('search_production_line').value,
                },
                success: function (data) {
                    if(data.success == 'true'){
                        $('#production_lines_table').html(data.view);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function get_product_name_for_add_production_name_ajax(){
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('production.get_product_name_for_add_production_name_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'product_id': document.getElementById('selected_product').value,
                },
                success: function (data) {
                    if(data.success == 'true'){
                        document.getElementById('production_name').value = `خط - ${data.data.product_name_ar}`;
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }
    </script>

    <script>
        $(function () {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endsection

