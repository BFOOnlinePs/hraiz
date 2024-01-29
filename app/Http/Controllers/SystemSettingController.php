<?php

namespace App\Http\Controllers;

use App\Models\SystemSettingModel;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    public function index(){
        $data = SystemSettingModel::first();
        return view('admin.setting.system_setting.index',['data'=>$data]);
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
}
