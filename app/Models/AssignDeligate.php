<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignDeligate extends Model
{
    use HasFactory;

    protected $fillable = [
        'deligate_id',
        'hod_id',
    ];

    public static function hodDeligateForLetter($letterId){

        return AssignDeligate::join('letter_assigns','hod_id','=','receiver_id')
        ->where([
            'deligate_id'=>session('role_user'),
            'in_hand'=>true,
            'letter_id'=>$letterId
        ])->count();

    }
}
