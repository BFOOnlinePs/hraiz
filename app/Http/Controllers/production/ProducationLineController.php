<?php

namespace App\Http\Controllers\production;

use App\Http\Controllers\Controller;
use App\Models\ProducationLinesModel;
use App\Models\ProductionInputsModel;
use App\Models\ProductionOrdersModel;
use App\Models\ProductionSettingModel;
use App\Models\ProductModel;
use App\Models\ProjectAttachmentModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helper\Helper;

class ProducationLineController extends Controller
{

    public function index(){
        $data = ProducationLinesModel::get();
        $products = ProductModel::get();
        return view('admin.production.production_line.index',['data'=>$data,'products'=>$products]);
    }

    public function create(Request $request){
        $data = new ProducationLinesModel();
        $data->production_name = $request->production_name;
        $data->production_notes = $request->production_notes;
        if ($request->hasFile('production_image')) {
            $file = $request->file('production_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('production', $filename, 'public');
            $data->production_image = $filename;
        }
        $data->product_id = $request->product_id;
        if ($data->save()){
            return redirect()->route('production.index')->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
        else{
            return redirect()->route('production.index')->with(['fail'=>'هناك خلل ما لم يتم اضافة البيانات']);
        }
    }

    public function edit($id){
        $data = ProducationLinesModel::where('id',$id)->first();
        $products = ProductModel::get();
        return view('admin.production.production_line.edit',['data'=>$data,'products'=>$products]);
    }

    public function update(Request $request){
        $data = ProducationLinesModel::where('id',$request->id)->first();
        $data->production_name = $request->production_name;
        $data->production_notes = $request->production_notes;
        if ($request->hasFile('production_image')) {
            $file = $request->file('production_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('production', $filename, 'public');
            $data->production_image = $filename;
        }
        $data->product_id = $request->product_id;
        if ($data->save()){
            return redirect()->route('production.index')->with(['success'=>'تم تعديل البيانات بنجاح']);
        }
        else{
            return redirect()->route('production.index')->with(['fail'=>'هناك خلل ما لم يتم تعديل البيانات']);
        }
    }

    public function production_input($id){
        $production_lines = ProducationLinesModel::where('id',$id)->first();
        $production_lines['product'] = ProductModel::where('id',$production_lines->product_id)->first();
        $data = ProductionInputsModel::where('production_lines_id',$id)->get();
        foreach ($data as $key){
            $key->product = ProductModel::where('id',$key->product_id)->first();
        }
        $products = ProductModel::get();
        $production_orders = ProductionOrdersModel::where('production_line_id',$id)->get();
        foreach ($production_orders as $key){
            $key->user = User::where('id',$key->employee_id)->first();
        }
        $employees = User::whereJsonContains('user_role','11')->get();
        $production_settings = ProductionSettingModel::where('production_line_id',$id)->get();
        return view('admin.production.production_line.production_inputs',['data'=>$data,'products'=>$products,'production_input'=>$id,'production_orders'=>$production_orders,'employees'=>$employees,'production_lines'=>$production_lines,'production_settings'=>$production_settings]);
    }

    public function production_input_create(Request $request){
        $data = new ProductionInputsModel();
        $data->product_id = $request->product_id?$request->product_id:-1;
        $data->production_input_notes = $request->production_input_notes;
        $data->production_lines_id = $request->production_lines_id;
        if ($request->operation == 'product'){
            $data->production_input_name = ProductModel::where('id',$request->product_id)->first()->product_name_ar;
        }
        if ($request->operation == 'workers'){
            $data->production_input_name = 'عمال';
        }
        if ($request->operation == 'others'){
            $data->production_input_name = $request->production_input_name;
        }
        $data->qty = $request->qty;
        $data->estimated_cost = $request->estimated_cost??0;
        if ($data->save()){
            return redirect()->route('production.production_inputs.index',['id'=>$request->production_lines_id])->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
        else{
            return redirect()->route('production.production_inputs.index',['id'=>$request->production_lines_id])->with(['fail'=>'هناك خلل ما لم يتم اضافة البيانات']);
        }
    }

    public function production_input_edit($id){
        $data = ProducationLinesModel::where('id',$id)->first();
        return view('admin.production.');
    }

    public function production_input_delete($id){
        $data = ProductionInputsModel::where('id',$id)->first();
        $production_line_id = $data->production_lines_id;
        if ($data->delete()){
            return redirect()->route('production.production_inputs.index',['id'=>$production_line_id])->with(['success'=>'تم حذف العنصر بنجاح']);
        }
        else{
            return redirect()->route('production.production_inputs.index',['id'=>$production_line_id])->with(['fail'=>'هناك خلل ما لم يتم حذف الباينات']);
        }
    }

    public function add_attachment_ajax(Request $request){
//        $data = Helper::project_attachment(
//            '',
//            'production_inputs',
//
//        );
    }

    public function upload_attachment(Request $request){
        $images = $request->file('images');

        foreach ($images as $image) {
            // Save each image to the database or storage
            $path = $image->store('images', 'public');

            // Save the path to the database if needed
            Image::create(['path' => $path]);
        }

        return response()->json(['success' => true, 'message' => 'Images saved successfully']);

    }

    public function create_production_orders(Request $request){
        $data = new ProductionOrdersModel();
        $data->production_line_id = $request->production_line_id;
        $data->employee_id = $request->employee_id;
        $data->status = 'new';
        $data->insert_at = Carbon::now();
        $data->submission_date = $request->submission_date;
        $data->notes = $request->notes;
        if ($data->save()){
            return redirect()->route('production.production_inputs.index',['id'=>$request->production_line_id])->with(['success'=>'تم اضافة البيانات بنجاح','tab_id'=>3]);
        }
        else{
            return redirect()->route('production.production_inputs.index',['id'=>$request->production_line_id])->with(['fail'=>'لم بتم اضافة البيانات بنجاح','tab_id'=>3]);
        }
    }

    public function edit_production_orders($id){
        $data = ProductionOrdersModel::where('id',$id)->first();
        $data->user = User::where('id',$data->employee_id)->first();
        $employees = User::whereJsonContains('user_role','11')->get();
        return view('admin.production.production_line.edit_production_orders',['data'=>$data,'employees'=>$employees]);
    }

    public function update_production_orders(Request $request){
        $data = ProductionOrdersModel::where('id',$request->id)->first();
        $data->employee_id = $request->employee_id;
        $data->status = $request->status;
//        $data->insert_at = $request->insert_at;
        $data->submission_date = $request->submission_date;
        $data->notes = $request->notes;
        if ($data->save()){
            return redirect()->route('production.production_inputs.index',['id'=>$request->id])->with(['success'=>'تم تعديل البيانات بنجاح','tab_id'=>3]);
        }
        else{
            return redirect()->route('production.production_inputs.index',['id'=>$request->id])->with(['fail'=>'لم يتم تعديل البيانات بنجاح','tab_id'=>3]);
        }
    }

    public function upload_image(Request $request){
        $data = new ProjectAttachmentModel();
        $data->attachment_table = 'production';
        $data->attachemnt_table_id = $request->attachemnt_table_id;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('production', $filename, 'public');
            $data->attachment = $filename;
        }

        if ($data->save()){
            return response()->json([
                'success' => 'true',
                'message' => 'تم اضافة الصورة بنجاح'
            ]);
        } else {
            return response()->json([
                'success' => 'false',
                'message' => 'هناك خلل ما لم يتم اضافة الصورة بنجاح'
            ]);
        }
    }

    public function list_image(Request $request){
        $data = ProjectAttachmentModel::where('attachment_table','production')->where('attachemnt_table_id',$request->attachment_table_id)->get();
        return response()->json([
            'success'=>'true',
            'view'=>view('admin.production.production_line.ajax.list_image',['data'=>$data])->render(),
        ]);
    }

    public function delete_image(Request $request){
        $data = ProjectAttachmentModel::where('id',$request->id)->first();
        if ($data->delete()){
            return response()->json([
                'success'=>'true',
                'message'=>'تم حذف الصورة بنجاح'
            ]);
        }
        else{
            return response()->json([
                'success'=>'false',
                'message'=>'هناك خلل ما لم يتم حذف الرسالة'
            ]);
        }
    }

    public function delete_production_orders($id){
        $data = ProductionOrdersModel::where('id',$id)->first();
        $production_line_id = $data->production_line_id;
        if ($data->delete()){
            return redirect()->route('production.production_inputs.index',['id'=>$production_line_id])->with(['success'=>'تم حذف البيانات بنجاح','tab_id'=>3]);
        }
        else{
            return redirect()->route('production.production_inputs.index',['id'=>$production_line_id])->with(['fail'=>'هناك خلل ما لم يتم حذف البيانات','tab_id'=>3]);
        }
    }

    public function update_product_and_qty_for_production_lines_ajax(Request $request){
        $data = ProducationLinesModel::where('id',$request->production_line_id)->first();
        if ($request->operation == 'product'){
            $data->product_id = $request->value;
        }
        if ($request->operation == 'qty'){
            $data->production_output_count = $request->value;
        }
        if ($data->save()){
           return response()->json([
               'success'=>'true',
               'message'=>'تم تعديل البيانات بنجاح'
           ]);
        }
    }

    public function update_production_order_status(Request $request){
        $data = ProductionOrdersModel::where('id',$request->id)->first();
        $data->status = $request->status;
        if ($data->save()){
            return response()->json([
                'success'=>'true',
                'message'=>'تم تغيير الحالة بنجاح'
            ]);
        }
    }

    public function production_order_table_ajax(Request $request){
        $data = ProductionOrdersModel::where('production_line_id',$request->id)->paginate(5);
        foreach ($data as $key){
            $key->user = User::where('id',$key->employee_id)->first();
        }
        return response()->json([
            'success'=>'true',
            'view'=>view('admin.production.production_line.ajax.production_order_table',['data'=>$data])->render(),
        ]);
    }
}
