<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\BfoAttendance;
use App\Models\User;
use App\Models\UserLevels;
use App\Models\UserRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeesController extends Controller
{
    public function index()
    {
        return view('admin.hr.employees.index');
    }
    public function add()
    {
        return view('admin.hr.employees.add');
    }
    public function employee_table(Request $request){
        $data = User::whereJsonContains('user_role','11')
        ->where(function($query) use($request){
            $query->where('name','like','%'.$request->search.'%');
        })
        ->get();
        return response()->json([
            'success'=>'true',
            'view'=>view('admin.hr.employees.ajax.employee_table',['data' => $data])->render()
        ]);
    }
    public function details($id)
    {
        $data = User::find($id);
        $bfo_attendances = BfoAttendance::where('user_id' , $id)
        ->where('deleted', 0)
        ->paginate(10);
        return view('admin.hr.employees.details' , ['data' => $data , 'bfo_attendances' => $bfo_attendances]);
    }
    public function edit($id)
    {
        $data = User::find($id);
        $user_role = UserRole::get();
        return view('admin.hr.employees.edit' , ['data' => $data , 'user_role' => $user_role]);
    }
}
