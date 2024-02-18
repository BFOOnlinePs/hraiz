<?php

namespace App\Http\Controllers;

use App\Models\SystemSettingModel;
use App\Models\TimeAttendanceDevicesModel;
use App\Models\WorkingHoursModel;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    public function index(){
        $data = SystemSettingModel::first();
        $time_attendance_device = TimeAttendanceDevicesModel::get();
        return view('admin.setting.system_setting.index',['data'=>$data,'time_attendance_device'=>$time_attendance_device]);
    }

    public function create(Request $request){
        $data = SystemSettingModel::findOrNew($request->id);
        $data->company_name = $request->company_name;
        $data->company_address = $request->company_address;
        $data->company_phone = $request->company_phone;
        $data->sidebar_color = $request->sidebar_color;
        $data->company_name_en = $request->company_name_en;
        $data->company_address_en = $request->company_address_en;
        $data->company_name_he = $request->company_name_he;
        $data->company_address_he = $request->company_address_he;

        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('setting', $filename, 'public');
            $data->company_logo = $filename;
        }
        if ($request->hasFile('letter_head_image')) {
            $file = $request->file('letter_head_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('setting', $filename, 'public');
            $data->letter_head_image = $filename;
        }
        if($data->save()){
            return redirect()->route('setting.system_setting.index')->with(['success'=>'تمت العملية بنجاح']);
        }
        else{
            return redirect()->route('setting.system_setting.index')->with(['fail'=>'لم تتم العملية بنجاح هناك مشكلة ما']);
        }
    }

    public function create_time_attendance_device_option(Request $request){
        $data = new TimeAttendanceDevicesModel();
        $data->ip = $request->ip;
        $data->port = $request->port;
        $data->user_name = $request->user_name;
        $data->password = $request->password;
        $data->status_right = $request->status_right;
        $data->status_left = $request->status_left;
        $data->status_up = $request->status_up;
        $data->status_down = $request->status_down;
        if ($data->save()){
            return redirect()->route('setting.system_setting.index')->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
        else{
            return redirect()->route('setting.system_setting.index')->with(['fail'=>'هناك خلل ما لم يتم اضافة البيانات']);
        }
    }
}
