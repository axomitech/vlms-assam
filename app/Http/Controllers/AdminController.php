<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminModel;
use App\Models\Department;
use App\Models\Role;
use Auth;

use DB;

class AdminController extends Controller
{
    public function show_user()
    {
        $results = AdminModel::get_all_user_details();
        $departments = Department::getAllDepartments();
        $roles = Role::getAllRoles();
        // print_r($departments);
        // exit;
        return view('admin.user',compact('results','departments','roles'));
    }
}
