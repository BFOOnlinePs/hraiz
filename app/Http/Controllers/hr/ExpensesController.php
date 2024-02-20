<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\BfoExpensesModel;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    public function create(Request $request){
        $data = new BfoExpensesModel();
        $data->expense_date = $request->expense_date;
        $data->category_id = $request->category_id;
        $data->description = $request->description;
        $data->amount = $request->amount;
        if ($request->hasFile('files')) {
            $file = $request->file('files');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('expenses', $filename, 'public');
            $data->files = $filename;
        }
        $data->title = $request->title;
        $data->user_id = auth()->user()->id;
        $data->repeat_every = $request->repeat_every;
        $data->repeat_type = $request->repeat_type;
        $data->no_of_cycles = $request->no_of_cycles;
        if ($data->save()){
            return redirect()->route('users.employees.details',['id'=>$request->employee_id])->with(['success'=>'تم اضافة البيانات بنجاح','tab_id'=>12]);
        }
        else{
            return redirect()->route('users.employees.details',['id'=>$request->employee_id])->with(['success'=>'هناك خلل ما لم يتم اضافة البيانات','tab_id'=>12]);
        }
    }

    public function update(Request $request){
        $data = BfoExpensesModel::where('id',$request->expenses_id)->first();
        $data->expense_date = $request->expense_date;
        $data->category_id = $request->category_id;
        $data->description = $request->description;
        $data->amount = $request->amount;
        if ($request->hasFile('files')) {
            $file = $request->file('files');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('expenses', $filename, 'public');
            $data->files = $filename;
        }
        $data->title = $request->title;
        $data->user_id = auth()->user()->id;
        $data->repeat_every = $request->repeat_every;
        $data->repeat_type = $request->repeat_type;
        $data->no_of_cycles = $request->no_of_cycles;
        if ($data->save()){
            return redirect()->route('users.employees.details',['id'=>$request->employee_id])->with(['success'=>'تم تعديل البيانات بنجاح','tab_id'=>12]);
        }
        else{
            return redirect()->route('users.employees.details',['id'=>$request->employee_id])->with(['success'=>'هناك خلل ما لم يتم تعديل البيانات','tab_id'=>12]);
        }
    }
}
