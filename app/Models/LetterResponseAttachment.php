<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterResponseAttachment extends Model
{
    use HasFactory;

    public static function storeAttachment($attachmentDetails){
        $attachment = new LetterResponseAttachment;
        $attachment->response_id = $attachmentDetails[0];
        $attachment->response_attachment = $attachmentDetails[1];
        $attachment->save();
        return $attachment->id;
    }
}
