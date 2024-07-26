<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\UserDepartment;
use App\Models\Common;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $sessionUser = UserDepartment::roleUser(Auth::user()->id);
        Log::channel('dblog')->info('This is a test log message.');
        return view('home',compact('sessionUser'));

    }

    public function test()
    {
        return view('test');
    }
    public function box()
    {
        $profile = UserDepartment::getDefaultAccess(Auth::user()->id);
        $userDepartmentId = "";
        $roleId = "";
        $departmentId = "";
        foreach($profile AS $value){
            $userDepartmentId = $value['id'];
            $roleId = $value['role_id'];
            $departmentId = $value['department_id'];
        }
        $this->sessionInitiate($userDepartmentId,$departmentId,$roleId);
        return view('home1');
    }

    private function sessionInitiate($user,$department,$role){

        session([
            'role_user'=>$user
        ]);

        session([
            'role_dept'=>$department
        ]);

        session([
            'role'=>$role
        ]);

        session([
            'department'=>Common::getSingleColumnValue('departments','id',session('role_dept'),'department_name')
        ]);
    }
}
