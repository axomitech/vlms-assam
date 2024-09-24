<?php

namespace App\Models;

use App\Traits\DbConstants;
use App\Traits\GlobalHelper;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminModel extends Model
{
    use HasFactory;

    public static function get_all_user_details()
    {
        return DB::table('user_departments')
            ->join('users', 'user_departments.user_id', '=', 'users.id')
            ->join('departments', 'user_departments.department_id', '=', 'departments.id')
            ->join('roles', 'user_departments.role_id', '=', 'roles.id')
            ->select(
                'users.id as u_id',
                'users.name as u_name',
                'users.email as u_email',
                'roles.id as role_id',
                'roles.role_name',
                'departments.department_name',
                'departments.id as dept_id',
                'user_departments.id as profile_id',
                'user_departments.default_access as default_access',
            )
            ->where('user_departments.user_id', '!=', Auth::user()->id)
            ->get();
    }

    public static function get_all_dept_user($dept_id)
    {
        return DB::table('user_departments')
            ->join('users', 'user_departments.user_id', '=', 'users.id')
            ->join('departments', 'user_departments.department_id', '=', 'departments.id')
            ->join('roles', 'user_departments.role_id', '=', 'roles.id')
            ->select(
                'users.id as u_id',
                'users.name as u_name',
                'users.email as u_email',
                'roles.id as role_id',
                'roles.role_name',
                'departments.department_name',
                'departments.id as dept_id',
                'user_departments.id as profile_id',
                'user_departments.default_access as default_access',
                'user_departments.first_receiver'
            )
            ->where('user_departments.department_id', $dept_id)
            ->where('user_departments.user_id', '!=', Auth::user()->id)
            ->get();
    }

    public static function getDepartmentalAdminRoles($dept_id)
{
    // Check if role 3 (HOD) exists for the department
    $role3Exists = UserDepartment::where('department_id', $dept_id)
        ->where('role_id', 3)
        ->exists();

    // Always return roles 1, 3, and 6 so they can be created
    $availableRoles = Role::select('id', 'role_name')
        ->whereIn('id', [1, 3, 6])  // Roles that can always be created
        ->get();

    // If role 3 exists, also allow role 2 (Delegate) to be selected
    if ($role3Exists) {
        $delegateRole = Role::select('id', 'role_name')
            ->where('id', 2)  // Role 2 is Delegate
            ->first();

        if ($delegateRole) {
            $availableRoles->push($delegateRole);  // Add Delegate role to the list
        }
    }

    return $availableRoles;
}

}
