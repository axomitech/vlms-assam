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
            'department_id'=>$actionDetails[0],
            'letter_action_id'=>$actionDetails[1],
        ])->value('id'); 
   }

   public static function changeActionStatus($actionStatusDetails){
        return ActionDepartmentMap::where([
            'id'=>$actionStatusDetails[0]
        ])->update([
            'action_status_id'=>$actionStatusDetails[1]
        ]);
   }

   public static function confirmActionCompletion($actionId){
    $completedActions =  ActionDepartmentMap::where([
            'letter_action_id'=>$actionId,
            'action_status_id'=>3
        ])->count();

        $actionDepartments =  ActionDepartmentMap::where([
            'letter_action_id'=>$actionId
        ])->distinct()->count('department_id');

        return [
            $completedActions,
            $actionDepartments
        ];
   }
}
