<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
class LetterActionResponse extends Model
{
    use HasFactory;

    public static function storeNote($noteDetails){
        $response = new LetterActionResponse;
        $response->act_dept_map_id = $noteDetails[0];
        $response->user_id = session('role_user');
        $response->action_remarks = $noteDetails[1];
        $response->action_status_id = $noteDetails[2];
        $response->save();
        return $response->id;
        
    }

    public static function getActionLastNote($actionId){
        return LetterActionResponse::join('action_department_maps','letter_action_responses.act_dept_map_id','=','action_department_maps.id')
        ->where([
            'action_department_maps.letter_action_id'=>$actionId,
            'letter_action_responses.user_id'=>session('role_user')
        ])->orderBy('letter_action_responses.created_at', 'asc')->first();
    }

    public static function getAllActionNotes($actionId){

        return LetterActionResponse::join('action_department_maps','letter_action_responses.act_dept_map_id','=','action_department_maps.id')
        ->join('letter_actions','letter_actions.id','=','action_department_maps.letter_action_id')
        ->join('user_departments','letter_action_responses.user_id','=','user_departments.id')
        ->join('users','user_departments.user_id','=','users.id')
        ->where([
            'action_department_maps.letter_action_id'=>$actionId,
        ])
        ->orderBy('letter_action_responses.updated_at', 'ASC')
        ->select('action_remarks','letter_action_responses.created_at','users.name')
        ->groupBy('letter_action_id','action_remarks','letter_action_responses.created_at','users.name','letter_action_responses.updated_at')
        ->get();
          
    }

    public static function getResponses($actionSentId){
        return LetterActionResponse::join('letter_response_attachments',
        'letter_action_responses.id','=','letter_response_attachments.response_id')
        ->join('action_sents','letter_action_responses.act_dept_map_id','=','action_sents.act_dept_id')
        ->join('action_statuses','letter_action_responses.action_status_id','=','action_statuses.id')
        ->where([
           'action_sents.id' =>$actionSentId
        ])->select('action_remarks','status_name','letter_action_responses.created_at AS response_date','response_attachment')
        ->get();
    }
}
