<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ActionSent extends Model
{
    use HasFactory;

    public static function isLetterForwarded($letterId){

        return ActionSent::where([
            'letter_id'=>$letterId
        ])->count();


    }

    public static function storeActionForward($forwards){

        $sent = new ActionSent;
        $sent->act_dept_id = $forwards[0];
        $sent->sender_id = $forwards[1];
        $sent->receiver_id = $forwards[2];
        $sent->letter_id = $forwards[3];
        $sent->save();
        return $sent->id;

    }

    public static function inbox(){
        return ActionSent::join('action_department_maps','action_department_maps.id','=','action_sents.act_dept_id')
                        ->join('letter_actions','action_department_maps.letter_action_id','=','letter_actions.id')
                        ->join('user_departments','action_sents.sender_id','=','user_departments.id')
                        ->join('users','user_departments.user_id','=','users.id')
                        ->join('departments','user_departments.department_id','=','departments.id')
                        ->join('letters','letters.id','=','letter_actions.letter_id')
                        ->where([
                            'receiver_id'=>session('role_user'),
                            
                        ])
                        ->whereIn('action_status_id',[1])
                        ->select('action_sents.id AS action_sent_id','action_department_maps.id AS act_dept_id',
                        'letter_actions.action_description',
                        'action_sents.created_at',
                        'users.name AS sender_name',
                        'department_name','letters.letter_path','letters.id AS letter_id')
                        ->orderBy('action_sents.id','DESC')
                        ->get();
    }

    public static function outbox(){
        return ActionSent::join('action_department_maps','action_department_maps.id','=','action_sents.act_dept_id')
                        ->join('letter_actions','action_department_maps.letter_action_id','=','letter_actions.id')
                        ->join('user_departments','action_sents.receiver_id','=','user_departments.id')
                        ->join('users','user_departments.user_id','=','users.id')
                        ->join('departments','user_departments.department_id','=','departments.id')
                        ->join('letters','letters.id','=','letter_actions.letter_id')
                        ->orderBy('action_sents.id','DESC')
                        ->where([
                            'sender_id'=>session('role_user')
                        ])
                        ->select('action_sents.id AS action_sent_id','action_department_maps.id AS act_dept_id',
                        'letter_actions.action_description',
                        'action_sents.created_at',
                        'users.name AS receiver_name',
                        'department_name','letters.letter_path')
                        ->orderBy('action_sents.id','DESC')
                        ->get();
    }

    public static function updateActionStatus($actionSentId,$actionStatus){

        return DB::table('action_sents')
        ->where('id', $actionSentId)
        ->update(['action_status_id' => $actionStatus]);

    }

}
