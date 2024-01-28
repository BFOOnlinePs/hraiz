@extends('home')
@section('title')
    تفاصيل الموظف
@endsection
@section('header_title')
    تفاصيل الموظف
@endsection
@section('header_link')
    الموظفين
@endsection
@section('header_title_link')
    تفاصيل الموظف
@endsection
@section('style')
    <style>
        .active {
            color: black !important;
        }
        </style>
        <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
@include('admin.messge_alert.success')
@include('admin.messge_alert.fail')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="pb-3">{{ $data->name }}</h3>
                    <ul class="nav nav-tabs alert-info text-white" style="" id="custom-content-below-tab"
                            role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(session('tab_id') == 1) active @endif text-white"
                                    id="custom-content-below-home-tab"
                                    data-toggle="pill"
                                    href="#custom-content-below-home" role="tab"
                                    aria-controls="custom-content-below-home"
                                    aria-selected="@if(\Illuminate\Support\Facades\Session::has('tab_id')) @if(session('tab_id') == 1) true @else false @endif @endif">معلومات الموظف</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white @if(session('tab_id') == 2) active @endif"
                                    id="custom-content-below-attendance-tab" data-toggle="pill"
                                    href="#custom-content-below-attendance" role="tab"
                                    aria-controls="custom-content-below-attendance" aria-selected="false">سجل الحضور والمغادرة</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(session('tab_id') == 3) active @endif text-white"
                                    id="custom-content-below-messages-tab" data-toggle="pill"
                                    href="#custom-content-below-messages" role="tab"
                                    aria-controls="custom-content-below-messages"
                                    aria-selected="@if(\Illuminate\Support\Facades\Session::has('tab_id')) @if(session('tab_id') == 2) true @else false @endif @endif">الرواتب</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white @if(session('tab_id') == 4) active @endif"
                                    id="custom-content-below-orders-tab" data-toggle="pill"
                                    href="#custom-content-below-orders" role="tab"
                                    aria-controls="custom-content-below-orders" aria-selected="false">المهام</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white @if(session('tab_id') == 5) active @endif"
                                    id="custom-content-below-rewards-tab" data-toggle="pill"
                                    href="#custom-content-below-rewards" role="tab"
                                    aria-controls="custom-content-below-rewards" aria-selected="false">المكافآت</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white @if(session('tab_id') == 6) active @endif"
                                    id="custom-content-below-discounts-tab" data-toggle="pill"
                                    href="#custom-content-below-discounts" role="tab"
                                    aria-controls="custom-content-below-discounts" aria-selected="false">الحسومات</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white @if(session('tab_id') == 7) active @endif"
                                    id="custom-content-below-advances-tab" data-toggle="pill"
                                    href="#custom-content-below-advances" role="tab"
                                    aria-controls="custom-content-below-advances" aria-selected="false">السُلف</a>
                            </li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="tab-content" id="custom-content-below-tabContent">
                        <div class="tab-pane fade @if(session('tab_id') == null) show active @endif  @if(session('tab_id') == 1) active show @endif" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                            <div class="p-2">
                                <div class="row">
                                    <div class="col-md-8 p-5">
                                        <div class="form-group">
                                            <label for="">الاسم :</label>
                                            <span class="form-control">{{ $data->name }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label for="">الايميل :</label>
                                            <span class="form-control">{{ $data->email }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label for="">رقم الهاتف الاول :</label>
                                            <span class="form-control">{{ $data->user_phone1 }}</span>
                                        </div>
                                        <div class="form-group">
                                            @if($data->user_phone2 == '')
                                                <label for="">رقم الهاتف الثاني :</label>
                                                <span class="form-control">لا يوجد</span>
                                            @else
                                                <label for="">رقم الهاتف الثاني :</label>
                                                <span class="form-control">{{ $data->user_phone2 }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="">حالة المستخدم :</label>
                                            @if($data->user_status == 1)
                                                <span class="form-control text-success">فعال</span>
                                            @elseif($data->user_status == 0)
                                                <span class="text-danger form-control">غير فعال</span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="">ملاحظات : </label>
                                            <textarea readonly class="form-control" name="" id="" cols="30" rows="3">{{ $data->user_notes }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="">العنوان :</label>
                                            <textarea readonly class="form-control" name="" id="" cols="30"
                                                    rows="3">{{ $data->user_address }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4 pt-5 text-center">
                                        <div class="form-group text-center">
                                            <img width="150" src="{{ asset('storage/user_photo/'.$data->user_photo) }}" alt="">
                                        </div>
                                        <div>
                                            <h4 class="text-center">{{ $data->name }}</h4>
                                            <hr>
                                            <p>يحتوي هذا القسم على المعلومات الأساسية للموظف</p>
                                            <a href="{{ route('hr.employees.edit',['id'=>$data->id]) }}" class="btn btn-info">تعديل بيانات الموظف</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade @if(session('tab_id') == 2) active show @endif" id="custom-content-below-attendance" role="tabpanel" aria-labelledby="custom-content-below-attendance-tab">
                            <div class="p-2">
                                <div class="row">
                                    <button onclick="add_attendance()" class="btn btn-dark mb-2">تسجيل حضور</button>
                                </div>

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending">#
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">وقت الدخول</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">وقت الخروج</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">الحالة</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">الملاحظات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($bfo_attendances->isEmpty())
                                            <tr>
                                                <td colspan="5" class="text-center">لا توجد نتائج</td>
                                            </tr>
                                        @endif
                                        @foreach ($bfo_attendances as $key)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $key->in_time }}</td>
                                                <td>{{ $key->out_time }}</td>
                                                <td>{{ $key->status}}</td>
                                                <td>{{$key->note}}</td>
                                                <td>
                                                    <button class="btn btn-dark mb-2" onclick="edit_out_time_attendance('{{$key->note}}' , {{$key->id}} , '{{$key->activity_type}}')">تسجيل مغادرة</button>
                                                    <button class="btn btn-danger btn-sm" onclick="delete_bfo_attendance({{$key->id}})"><span class="fa fa-trash pt-1"></span></button>
                                                    <button class="btn btn-success btn-sm" onclick="edit_attendance({{$key->id}} , '{{$key->activity_type}}' , '{{$key->note}}' , '{{$key->in_time}}' , '{{$key->out_time}}')"><span class="fa fa-edit pt-1"></span></button>
                                                    {{-- <a class="btn btn-dark btn-sm" href="{{ route('hr.employees.details', ['id' => $key->id]) }}"><span class="fa fa-search"></span></a> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$bfo_attendances->links()}}

                            </div>
                        </div>
                        <div class="tab-pane fade @if(session('tab_id') == 5) active show @endif" id="custom-content-below-rewards" role="tabpanel" aria-labelledby="custom-content-below-attendance-tab">
                            <div class="p-2">
                                <div class="row">
                                    <button onclick="add_reward()" class="btn btn-dark mb-2">إضافة مكافأة</button>
                                </div>

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending">#
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">القيمة</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">العملة</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">تمت عملية الإضافة بواسطة</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">الملاحظات</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">الملف المرفق</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">العمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($rewards->isEmpty())
                                            <tr>
                                                <td colspan="7" class="text-center">لا توجد نتائج</td>
                                            </tr>
                                        @endif
                                        @foreach ($rewards as $key)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $key->value }}</td>
                                                <td>{{ $key->currency->currency_name }}</td>
                                                <td>{{ $key->user->name}}</td>
                                                <td>{{$key->notes}}</td>
                                                <td>
                                                <a target="_blank" href="{{ asset('storage/discounts_rewards_attachment/'.$key->attached_file) }}" download="attachment">تحميل الملف</a>
                                                </td>
                                                <td>
                                                    <button class="btn btn-success btn-sm" onclick="edit_reward({{$key->id}} , '{{$key->value}}' , {{$key->currency_id}} , '{{$key->currency->currency_name}}' , '{{$key->notes}}' , '{{$key->attached_file}}')"><span class="fa fa-edit pt-1"></span></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$rewards->links()}}

                            </div>
                        </div>
                        <div class="tab-pane fade @if(session('tab_id') == 6) active show @endif" id="custom-content-below-discounts" role="tabpanel" aria-labelledby="custom-content-below-discounts-tab">
                            <div class="p-2">
                                <div class="row">
                                    <button onclick="add_discount()" class="btn btn-dark mb-2">إضافة حسم</button>
                                </div>

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending">#
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">القيمة</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">العملة</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">تمت عملية الإضافة بواسطة</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">الملاحظات</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">الملف المرفق</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">العمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($discounts->isEmpty())
                                            <tr>
                                                <td colspan="7" class="text-center">لا توجد نتائج</td>
                                            </tr>
                                        @endif
                                        @foreach ($discounts as $key)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $key->value }}</td>
                                                <td>{{ $key->currency->currency_name}}</td>
                                                <td>{{ $key->user->name}}</td>
                                                <td>{{$key->notes}}</td>
                                                <td>
                                                <a target="_blank" href="{{ asset('storage/discounts_rewards_attachment/'.$key->attached_file) }}" download="attachment">تحميل الملف</a>
                                                </td>
                                                <td>
                                                    <button class="btn btn-success btn-sm" onclick="edit_discount({{$key->id}} , '{{$key->value}}' , {{$key->currency_id}} , '{{$key->currency->currency_name}}' , '{{$key->notes}}' , '{{$key->attached_file}}')"><span class="fa fa-edit pt-1"></span></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$rewards->links()}}

                            </div>
                        </div>
                        <div class="tab-pane fade @if(session('tab_id') == 7) active show @endif" id="custom-content-below-advances" role="tabpanel" aria-labelledby="custom-content-below-advances-tab">
                            <div class="p-2">
                                <div class="row">
                                    <button onclick="add_advance()" class="btn btn-dark mb-2">إضافة سُلفة</button>
                                </div>

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending">#
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">القيمة</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">العملة</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">تمت عملية الإضافة بواسطة</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">الملاحظات</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">الملف المرفق</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">العمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($advances->isEmpty())
                                            <tr>
                                                <td colspan="7" class="text-center">لا توجد نتائج</td>
                                            </tr>
                                        @endif
                                        @foreach ($advances as $key)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $key->value }}</td>
                                                <td>{{ $key->currency->currency_name}}</td>
                                                <td>{{ $key->user->name}}</td>
                                                <td>{{$key->notes}}</td>
                                                <td>
                                                <a target="_blank" href="{{ asset('storage/discounts_rewards_attachment/'.$key->attached_file) }}" download="attachment">تحميل الملف</a>
                                                </td>
                                                <td>
                                                    <button class="btn btn-success btn-sm" onclick="edit_advance({{$key->id}} , '{{$key->value}}' , {{$key->currency_id}} , '{{$key->currency->currency_name}}' , '{{$key->notes}}' , '{{$key->attached_file}}')"><span class="fa fa-edit pt-1"></span></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$rewards->links()}}

                            </div>
                        </div>
                    </div>
                </div>
                @include('admin.hr.employees.modals.attendanceCreate')
                @include('admin.hr.employees.modals.attendanceEditOutTime')
                @include('admin.hr.employees.modals.attendanceDelete')
                @include('admin.hr.employees.modals.attendanceEdit')
                @include('admin.hr.employees.modals.rewardCreate')
                @include('admin.hr.employees.modals.rewardEdit')
                @include('admin.hr.employees.modals.discountCreate')
                @include('admin.hr.employees.modals.discountEdit')
                @include('admin.hr.employees.modals.advanceCreate')
                @include('admin.hr.employees.modals.advanceEdit')
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        function edit_advance(id , value , currency_id , currency_name , notes , attached_file) 
        {
            document.getElementById('id_advanceEdit').value = id;
            document.getElementById('value_advanceEdit').value = value;
            document.getElementById('notes_advanceEdit').value = notes;
            let selectCurrency = document.getElementById('currency_id_advanceEdit');
            selectCurrency.innerHTML = "";
            let option = document.createElement('option');
            option.value = currency_id;
            option.text = currency_name;
            selectCurrency.append(option);
            selectCurrency.innerHTML += document.getElementById('currency_id_advanceCreate').innerHTML;
            document.getElementById('attached_file_advanceEdit').href = `{{ asset('storage/discounts_rewards_attachment/${attached_file}') }}`;
            $('#edit_advance_modal').modal('show');
        }
        function add_advance()
        {
            $('#create_advance_modal').modal('show');
        }
        function edit_discount(id , value , currency_id , currency_name , notes , attached_file) 
        {
            document.getElementById('id_discountEdit').value = id;
            document.getElementById('value_discountEdit').value = value;
            document.getElementById('notes_discountEdit').value = notes;
            let selectCurrency = document.getElementById('currency_id_discountEdit');
            selectCurrency.innerHTML = "";
            let option = document.createElement('option');
            option.value = currency_id;
            option.text = currency_name;
            selectCurrency.append(option);
            selectCurrency.innerHTML += document.getElementById('currency_id_discountCreate').innerHTML;
            document.getElementById('attached_file_discountEdit').href = `{{ asset('storage/discounts_rewards_attachment/${attached_file}') }}`;
            $('#edit_discount_modal').modal('show');
        }
        function add_discount()
        {
            $('#create_discount_modal').modal('show');
        }
        function edit_reward(id , value , currency_id , currency_name , notes , attached_file) 
        {
            document.getElementById('id_rewardEdit').value = id;
            document.getElementById('value_rewardEdit').value = value;
            document.getElementById('notes_rewardEdit').value = notes;
            let selectCurrency = document.getElementById('currency_id_rewardEdit');
            selectCurrency.innerHTML = "";
            let option = document.createElement('option');
            option.value = currency_id;
            option.text = currency_name;
            selectCurrency.append(option);
            selectCurrency.innerHTML += document.getElementById('currency_id_rewardCreate').innerHTML;
            document.getElementById('attached_file_rewardEdit').href = `{{ asset('storage/discounts_rewards_attachment/${attached_file}') }}`;
            $('#edit_reward_modal').modal('show');
        }
        function add_reward()
        {
            $('#create_reward_modal').modal('show');
        }
        function add_attendance()
        {
            $('#attendance_in_time').modal('show');
        }
        function edit_out_time_attendance(note , bfo_attendance_id , activity_type)
        {
            document.getElementById('bfo_attendance_id_attendanceEditOutTimeModal').value = bfo_attendance_id;
            document.getElementById('notes_attendanceEditOutTimeModal').value = note;
            let selectElement = document.getElementById('activity_type');
            selectElement.innerHTML = "";
            let activityTypes = ['دوام' , 'خاص' , 'ميداني'];
            let option = document.createElement('option');
            option.value = activity_type;
            option.text = activity_type;
            selectElement.appendChild(option);
            activityTypes.forEach(function(type) {
                if(type !== activity_type) {
                    let option = document.createElement('option');
                    option.value = type;
                    option.text = type;
                    selectElement.appendChild(option);
                }
            });
            $('#attendance_edit_out_time').modal('show');
        }
        function delete_bfo_attendance(id) {
            document.getElementById('bfo_attendance_id_attendanceDeleteModal').value = id;
            $('#attendance_delete').modal('show');
        }
        function edit_attendance(bfo_attendance_id , activity_type , notes , in_time , out_time)
        {
            let selectElement = document.getElementById('activity_type_edit_modal');
            selectElement.innerHTML = "";
            let activityTypes = ['دوام' , 'خاص' , 'ميداني'];
            let option = document.createElement('option');
            option.value = activity_type;
            option.text = activity_type;
            selectElement.appendChild(option);
            activityTypes.forEach(function(type) {
                if(type !== activity_type) {
                    let option = document.createElement('option');
                    option.value = type;
                    option.text = type;
                    selectElement.appendChild(option);
                }
            });
            document.getElementById('notes_edit_modal').value = notes;
            document.getElementById('in_time_time_edit_modal').value = in_time.split(' ')[1];
            document.getElementById('in_time_date_edit_modal').value = in_time.split(' ')[0];
            document.getElementById('out_time_time_edit_modal').value = out_time.split(' ')[1];
            document.getElementById('out_time_date_edit_modal').value = out_time.split(' ')[0];
            if(out_time !== '') {
            }
            document.getElementById('bfo_attendance_id_attendanceEdit').value = bfo_attendance_id;
            $('#edit_attendance').modal('show');
        }
        $(function(){
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
@endsection
