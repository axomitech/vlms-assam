<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterAction extends Model
{
    use HasFactory;

    public static function storeLetterAction($actionDetails){
        $action = new LetterAction;
        $action->user_id = session('role_user');
        $action->letter_id = $actionDetails[0];
        $action->action_description = $actionDetails[1];
        $action->save();
        return $action->id;
    }

    public static function getDepartmentActions($letterId){
        return LetterAction::join('action_department_maps','letter_actions.id','=','action_department_maps.letter_action_id')
            ->join('letters','letter_actions.letter_id','=','letters.id')
            ->join('departments','action_department_maps.department_id','=','departments.id')
            ->where([
                'letter_actions.letter_id'=>$letterId
            ])
            ->orderBy('letter_actions.id','DESC')
            ->groupBY('action_id','subject','letter_no','letter_path','act_dept_id','dept_id','department_name')
            ->select('letter_actions.id AS action_id','action_description','letter_actions.created_at as action_date','subject','letter_no','letter_path','action_department_maps.id AS act_dept_id','action_department_maps.department_id AS dept_id','department_name')
            ->get();
    }
}
