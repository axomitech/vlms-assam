<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public static function getAllDepartments(){

        return Department::select('id','department_name')->get();

    }

    public static function getDepartmentAbbreviation($departmentId){
        
        return Department::where([
            'id'=>$departmentId
        ])->value('abbreviation');

    }
}
