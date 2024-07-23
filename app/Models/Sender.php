<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sender extends Model
{
    use HasFactory;

    public static function storeSender($senderDetails){
        
        $sender = new Sender;
        $sender->letter_id = $senderDetails[0];
        $sender->sender_name = $senderDetails[1];
        $sender->sender_designation = $senderDetails[2];
        $sender->sender_phone = $senderDetails[3];
        $sender->sender_email = $senderDetails[4];
        $sender->sms_to = $senderDetails[3];
        $sender->email_to = $senderDetails[4];
        $sender->organization = $senderDetails[5];
        $sender->address = $senderDetails[6];
        $sender->save();
        return $sender->id;

    }
}
