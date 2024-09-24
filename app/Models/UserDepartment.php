<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDepartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department_id',
        'role_id',
        'default_access',
        'first_receiver'
    ];

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

    public static function getDefaultAccess($userId){
        return UserDepartment::where([
            'user_id'=>$userId,
            'default_access'=>true
        ])->select('id','department_id','role_id')->get();
    }

    public static function getFirstReceiverDepartment($department){
        return UserDepartment::where('department_id', $department)
        ->join('users','user_departments.user_id','=','users.id')
        ->select('user_departments.id AS user_id','name')
        ->where('first_receiver', true)
        ->where('default_access',true)
        ->where('role_id','>', 1)
        ->get();
    }
    public static function getAllUserDepartment($department,$role){
        return UserDepartment::where([
            'department_id'=>$department,
            'role_id'=>$role
        ])->join('users','user_departments.user_id','=','users.id')
        ->select('user_departments.id AS user_id','name')
        ->get();
    }
}
