<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index()
    {
        $users = User::whereJsonContains('user_role' , '11')
        ->get();
        return view('admin.hr.salaries.index' , ['users' => $users]);
    }
}
