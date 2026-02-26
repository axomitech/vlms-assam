<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getUserDetails($id)
    {
        $user = DB::table('user_departments')
            ->join('users', 'user_departments.user_id', '=', 'users.id')
            ->join('departments', 'user_departments.department_id', '=', 'departments.id')
            ->join('roles', 'user_departments.role_id', '=', 'roles.id')
            ->where('user_departments.id', $id)
            ->select(
                'users.name as user_name',
                'departments.department_name',
                'roles.role_name'
            )
            ->first();

        return response()->json($user);
    }
}
