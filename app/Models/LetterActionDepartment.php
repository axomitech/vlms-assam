<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterActionDepartment extends Model
{
    use HasFactory;

    public static function storeDepartmentActions($departmentAction){

        $actionDepartment = new LetterActionDepartment;
        $actionDepartment->letter_action_id = $departmentAction[0];
        $actionDepartment->department_id = $departmentAction[1];
        $actionDepartment->save();
        return $actionDepartment->id;
    }
}
