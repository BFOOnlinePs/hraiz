@extends('home')
@section('title')
    الموظفين
@endsection
@section('header_title')
    الموظفين
@endsection
@section('header_link')
@endsection
@section('header_title_link')
    الموظفين
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <a href="{{ route('hr.employees.add') }}" class="btn btn-dark mb-2">إضافة موظف</a>
    <div class="card">
        <div class="card-header">
            <h3 class="text-center">قائمة الموظفين</h3>
        </div>
        <div class="card-body">
            <div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <input type="text" onkeyup="employee_table()" class="form-control" id="search" placeholder="بحث">
                            </div>
                        </div>
                        <div id="employee_table">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            employee_table();
        });
        function updateStatus(id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ url('users/updateStatus') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id': id,
                    'user_status': document.getElementById('customSwitch' + id).checked
                },
                success: function(data) {
                    toastr.success('تم تعديل الحالة بنجاح');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                }
            });
        }
        function employee_table() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: "{{ route('hr.employees.employee_table') }}",
                method: 'post',
                headers: headers,
                data: {
                    'search': document.getElementById('search').value
                },
                success: function(data) {
                    $('#employee_table').html(data.view);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    </script>
@endsection
