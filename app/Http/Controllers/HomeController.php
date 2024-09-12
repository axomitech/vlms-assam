<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\UserDepartment;
use App\Models\Common;
use App\Models\HomeModel;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

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
        return view('home', compact('sessionUser'));
    }

    public function test()
    {
        return view('test');
    }
    public function box()
    {
        $profile = UserDepartment::getDefaultAccess(FacadesAuth::user()->id);
        // Check if no profile has default access
        if ($profile->isEmpty()) {
            // Redirect to unauthorized page if no default access found
            return abort(403, 'Unauthorized Access');
        }
        $userDepartmentId = "";
        $roleId = "";
        $departmentId = "";
        foreach ($profile as $value) {
            $userDepartmentId = $value['id'];
            $roleId = $value['role_id'];
            $departmentId = $value['department_id'];
        }
        $this->sessionInitiate($userDepartmentId, $departmentId, $roleId);

        $diarized_count = HomeModel::get_diarized_count();
        $sent_count = HomeModel::get_sent_count();
        $archive_count = HomeModel::get_archive_count();
        $diarized_details = HomeModel::get_diarized_details();
        $inbox_count = HomeModel::get_inbox_count();
        // print_r($diarized_details);
        // exit;
        // return view('home1',compact('diarized_count','diarized_details','sent_count','archive_count','inbox_count'));
        return Redirect::away(route('letters'));
    }

    private function sessionInitiate($user, $department, $role)
    {

        session([
            'role_user' => $user
        ]);

        session([
            'role_dept' => $department
        ]);

        session([
            'role' => $role
        ]);

        session([
            'department' => Common::getSingleColumnValue('departments', [
                'id' => session('role_dept')
            ], 'department_name')
        ]);
    }
}
