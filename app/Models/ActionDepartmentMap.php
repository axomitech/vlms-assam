<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class ActionDepartmentMap extends Model
{
    use HasFactory;
    
   public static function storeDepartmentActions($departmentAction){
    $actionDepartment = new ActionDepartmentMap;
    $actionDepartment->letter_action_id = $departmentAction[0];
    $actionDepartment->department_id = $departmentAction[1];
    $actionDepartment->save();
    return $actionDepartment->id;
   }

   public static function getActionDepartment($actionDetails){
        return ActionDepartmentMap::where([
            'letter_action_id'=>$actionDetails[0],
        ])->value('id'); 
   }
}
