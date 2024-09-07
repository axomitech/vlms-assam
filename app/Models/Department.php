<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public static function getAllDepartments(){

        return Department::select('id', 'department_name')
        ->where('id', '!=', 0)
        ->get();
    
    }

    public static function getDepartmentsWithoutAdmin(){
        return Department::select('departments.id', 'departments.department_name')
            ->leftJoin('user_departments', function($join) {
                $join->on('departments.id', '=', 'user_departments.department_id')
                     ->where('user_departments.role_id', '=', 4);
            })
            ->whereNull('user_departments.role_id')
            ->where('departments.id', '!=', 0)
            ->get();
    }
    

    public static function getAllDepartmentsWithAbbreviation(){

        return Department::select('id', 'department_name', 'abbreviation')
        ->where('id', '!=', 0)
        ->get();
    
    }

    public static function getDepartmentAbbreviation($departmentId){
        
        return Department::where([
            'id'=>$departmentId
        ])->value('abbreviation');

    }
}
