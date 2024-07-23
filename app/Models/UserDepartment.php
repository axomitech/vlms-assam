<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDepartment extends Model
{
    use HasFactory;

    public static function roleUser($userId){
        return UserDepartment::join('departments','user_departments.department_id','=','departments.id')
        ->join('roles','user_departments.role_id','=','roles.id')
        ->where([
            'user_id'=>$userId
        ])->select('department_name','role_name','user_departments.id as session_user','department_id','role_id')
        ->get();
    }

    public static function getDepartmentUser($department,$role){

        return UserDepartment::where([
            'department_id'=>$department,
            'role_id'=>$role
        ])->value('id');
        
    }

    public static function getUser($userId){

        return UserDepartment::where([
            'user_id'=>$userId
        ])->value('id');
        
    }
}
