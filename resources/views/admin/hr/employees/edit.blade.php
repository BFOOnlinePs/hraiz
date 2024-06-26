@extends('home')
@section('title')
    الموظفين
@endsection
@section('header_title')
    الموظفين
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    الموظفين
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="card">

        <div class="card-header text-center">
            <h5 class="text-bold">تعديل الموظف ( {{ $data->name }} )</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('users.update',['id'=>$data->id]) }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <div class="card card-warning">
                                <div class="card-header text-center">
                                    <span>المعلومات العامة</span>
                                </div>
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="">الاسم الكامل</label>
                                                <input value="{{ old('name',$data->name) }}" placeholder="الاسم الكامل"
                                                       name="name" class="form-control"
                                                       type="text">
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">الايميل</label>
                                                <input value="{{ old('email',$data->email) }}" name="email"
                                                       placeholder="الايميل" class="form-control"
                                                       type="text">
                                                @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">كلمة المرور</label>
                                                <input {{ old('password') }} placeholder="كلمة المرور" name="password"
                                                       class="form-control"
                                                       type="text">
                                                @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="row form-group">
                                                <div class="col">
                                                    <label>رقم الهاتف الاول</label>
                                                    <input value="{{ old('user_phone1',$data->user_phone1) }}"
                                                           placeholder="رقم الهاتف الاول" class="form-control"
                                                           name="user_phone1" type="text">
                                                    @error('user_phone1')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col">
                                                    <label for="">رقم الهاتف الثاني</label>
                                                    <input value="{{ old('user_phone2',$data->user_phone2) }}"
                                                           placeholder="رقم الهاتف الثاني" class="form-control"
                                                           name="user_phone2" type="text">
                                                    @error('user_phone2')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                                <div class="form-group">
                                                    <label for="">الراتب الاساسي</label>
                                                    <input class="form-control" type="number" name="main_salary" placeholder="الراتب الاساسي">
                                                </div>
                                            <div class="form-group">
                                                <label for="">العنوان الكامل</label>
                                                <textarea class="form-control" placeholder="العنوان الكامل"
                                                          name="user_address" id="" cols="30"
                                                          rows="3">{{ old('user_address',$data->user_address) }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-5 text-center">

                                                        <img width="150"
                                                             src="{{ asset('storage/user_photo/'. $data->user_photo) }}"
                                                             alt="">
                                                        <br>
                                                        <label for="exampleInputFile">الصورة الشخصية</label>

                                                    </div>
                                                    <div class="col-md-7 pt-5">
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="exampleInputFile">
                                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                            </div>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">رفع</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                @error('user_photo')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <h5 class="alert alert-warning">الصلاحيات</h5>
                                                <br>
                                                @php
                                                    $user_role_array = json_decode($data->user_role??'[]');
                                                @endphp
                                                <div class="row">
                                                  @foreach ($user_role as $key)
                                                  <div class="col-md-3">
                                                    <input @if(in_array($key->id,$user_role_array)) checked @endif name="role_level[]" value="{{ $key->id }}" id="user_role_{{ $loop->index }}" type="checkbox">
                                                    <label for="user_role_{{ $loop->index }}">{{ $key->name }}</label>
                                                  </div>
                                                @endforeach
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">ملاحظات</label>
                                                <textarea placeholder="الملاحظات" class="form-control" name="user_notes"
                                                          id="" cols="30"
                                                          rows="5">{{ old('user_notes',$data->user_notes) }}</textarea>
                                                @error('user_notes')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <button type="submit" class="btn btn-success btn-block"><i
                        class="fa-solid fa-floppy-disk"></i> تعديل
                </button>

            </form>
        </div>
    </div>
@endsection
@section('script')

@endsection
