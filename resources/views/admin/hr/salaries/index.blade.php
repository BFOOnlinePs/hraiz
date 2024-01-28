@extends('home')
@section('title')
    الموظفين
@endsection
@section('header_title')
    الرواتب
@endsection
@section('header_link')
@endsection
@section('header_title_link')
    الرواتب
@endsection
@section('style')
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <button onclick="showCreateSalaryModal()" class="btn btn-dark mb-2">إضافة راتب</button>
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
                                <!-- <input type="text" onkeyup="employee_table()" class="form-control" id="search" placeholder="بحث"> -->
                            </div>
                        </div>
                        <div id="employee_table">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.hr.salaries.modals.salaryCreate')
@endsection

@section('script')
    <script>
        function showCreateSalaryModal()
        {
            $('#create_salary_modal').modal('show');
        }
    </script>
@endsection
