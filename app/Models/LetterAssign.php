<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterAssign extends Model
{
    use HasFactory;

    public static function assignLetter($assignee){
        $assign = new LetterAssign;
        $assign->letter_id = $assignee[0];
        $assign->user_id = session('role_user');
        $assign->receiver_id = $assignee[1];
        $assign->remarks = $assignee[2];
        $assign->save();
        return $assign->id;
    }

    public static function forwardFrom($forwardFrom){

        return LetterAssign::where([
            'letter_id'=>$forwardFrom
        ])->update([
            'in_hand'=>false
        ]);

    }

    public static function checkLetterAssign($letterId){

        return LetterAssign::where([
            'letter_id'=>$letterId,
            'user_id'=>session('role_user')
        ])->count();

    }
}
