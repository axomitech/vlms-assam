<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Letter extends Model
{
    use HasFactory;

    public static function storeLetter($letterDetails){
        $letter = new Letter;
        $letter->user_id = session('role_user');
        $letter->letter_category_id = $letterDetails[0];
        $letter->letter_priority_id = $letterDetails[1];
        $letter->letter_no = $letterDetails[5];
        $letter->letter_date = $letterDetails[2];
        $letter->received_date = $letterDetails[3];
        $letter->diary_date = $letterDetails[4];
        $letter->subject = $letterDetails[6];
        $letter->letter_path = $letterDetails[7];
        $letter->auto_ack = $letterDetails[8];
        $letter->stage_status = 1;
        $letter->department_id = session('role_dept');
        $letter->save();
        return $letter->id;
    }

    public static function showLetterAndSender(){
        return Letter::join('senders','letters.id','=','senders.letter_id')
               ->join('user_departments','letters.user_id','=','user_departments.id')
               ->where([
                'user_departments.department_id'=>session('role_dept')
               ])
               ->orderBy('letters.id','DESC')
               ->select('letter_no','subject','sender_name','letter_path','letters.id AS letter_id','organization','crn','stage_status')
               ->get();
    }

    public static function showInboxLetters(){
        return Letter::join('senders','letters.id','=','senders.letter_id')
               ->join('action_sents','letters.id','=','action_sents.letter_id')
               ->where([
                'action_sents.receiver_id'=>session('role_dept')
               ])
               ->groupBy('letter_no','subject','sender_name','letter_path','letters.id','organization','crn','stage_status')
               ->orderBy('letters.id','DESC')
               ->select('letter_no','subject','sender_name','letter_path','letters.id AS letter_id','organization','crn','stage_status')
               ->get();
    }

    public static function generateLetterCrn($crn){

        return DB::table('letters')
        ->where('id', $crn[0])
        ->update(['crn' => $crn[1]]);

    }

    public static function finalizeLetter($letterId){

        return DB::table('letters')
        ->where('id', $letterId)
        ->update([
            'draft_finalize' => true,
            'stage_status'=>2
        ]);

    }

    public static function changeLetterStage($letterId,$stageId){

        return DB::table('letters')
        ->where('id', $letterId)
        ->update([
            'stage_status'=>$stageId
        ]);

    }
}
