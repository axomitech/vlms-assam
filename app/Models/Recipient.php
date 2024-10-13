<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    use HasFactory;

    public static function storeRecipient($recipientDetails){
        
        $recipient = new Recipient;
        $recipient->letter_id = $recipientDetails[0];
        $recipient->recipient_name = $recipientDetails[1];
        $recipient->recipient_designation = $recipientDetails[2];
        $recipient->recipient_phone = $recipientDetails[3];
        $recipient->recipient_email = $recipientDetails[4];
        $recipient->sms_to = $recipientDetails[3];
        $recipient->email_to = $recipientDetails[4];
        $recipient->organization = $recipientDetails[5];
        $recipient->address = $recipientDetails[6];
        $recipient->save();
        return $recipient->id;

    }

    public static function updateRecipient($recipientDetails){

        Recipient::where([
            'letter_id'=>$recipientDetails[0]
        ])->update([
            'recipient_name' => $recipientDetails[1],
            'recipient_designation' => $recipientDetails[2],
            'recipient_phone' => $recipientDetails[3],
            'recipient_email' => $recipientDetails[4],
            'sms_to' => $recipientDetails[3],
            'email_to' => $recipientDetails[4],
            'organization' => $recipientDetails[5],
            'address' => $recipientDetails[6],
        ]);

    }
}
