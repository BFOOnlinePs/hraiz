<?php

namespace App\Http\Controllers;

use App\Models\BfoAttendance;
use App\Models\SystemSettingModel;
use App\Models\TimeAttendanceDevicesModel;
use App\Models\WorkingHoursModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Rats\Zkteco\Lib\Helper\Util;
use Rats\Zkteco\Lib\ZKTeco;

class SystemSettingController extends Controller
{
    public function index(){
        $data = SystemSettingModel::first();
        $time_attendance_device = TimeAttendanceDevicesModel::get();
        foreach ($time_attendance_device as $key){
//            $zk = new ZKTeco(''.$key->ip.'', $key->port);
//            $key->status_device = (!$zk->connect() == 1)?'fail':'success';
        }
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

    public function async_data_from_attendance_device($id){
        $attendance_device = TimeAttendanceDevicesModel::where('id',$id)->first();
        $zk = new ZKTeco('192.168.1.201',$attendance_device->port);
        $zk->connect();
        $zk->enableDevice();
        $attendances = $zk->getAttendance();
        $data = BfoAttendance::orderBy('id','desc')->latest('attendance_id')->first();
        foreach ($attendances as $key){
            if (!empty($data)){
                if ($data->attendance_id < $key['uid']){
                    $bfo_attendance = new BfoAttendance();
                    $bfo_attendance->activity_type = $key['type'];
                    $bfo_attendance->user_id = $key['id'];
                    $bfo_attendance->in_time = $key['timestamp'];
                    $bfo_attendance->out_time = $key['timestamp'];
                    $bfo_attendance->attendance_id = $key['uid'];
                    $bfo_attendance->device_id = $id;
                    $bfo_attendance->save();
                }
            }
            else{
                $bfo_attendance = new BfoAttendance();
                $bfo_attendance->activity_type = $key['type'];
                $bfo_attendance->user_id = $key['id'];
                $bfo_attendance->in_time = $key['timestamp'];
                $bfo_attendance->out_time = $key['timestamp'];
                $bfo_attendance->attendance_id = $key['uid'];
                $bfo_attendance->device_id = $id;
                $bfo_attendance->save();
            }
        }
    }

    public function check_connection_attendance_device_ajax(Request $request){
        $zk = new ZKTeco(''.$request->ip.'',$request->port);
        if ($zk->connect()){
            return response()->json([
                'success'=>'true',
                'message'=>'تم الاتصال بنجاح'
            ]);
        }
        else{
            return response()->json([
                'success'=>'false',
                'message'=>'هناك خطا بالاتصال'
            ]);
        }
    }
}
