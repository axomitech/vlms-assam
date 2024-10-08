<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class Letter extends Model
{
    use HasFactory;

    public static function storeLetter($letterDetails)
    {
        $letter = new Letter;
        $letter->user_id = session('role_user');
        $letter->letter_category_id = $letterDetails[0];
        $letter->letter_sub_category_id = $letterDetails[10];
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
        $letter->receipt = true;
        $letter->legacy = true;
        if ($letterDetails[9] == 0) {
            $letter->receipt = false;
        }
        if ($letterDetails[11] == 0) {
            $letter->legacy = false;
        }
        $letter->save();
        return $letter->id;
    }


    public static function updateLetter($letterDetails,$letter)
    {
        $receipt = true;
        $legacy = true;
        if ($letterDetails[9] == 0) {
            $receipt = false;
        }
        if ($letterDetails[11] == 0) {
            $legacy = false;
        }
        Letter::where([
            'id'=>$letter->id
        ])->update([
            'letter_category_id' => $letterDetails[0],
            'letter_sub_category_id' => $letterDetails[10],
            'letter_priority_id' => $letterDetails[1],
            'letter_no' => $letterDetails[5],
            'letter_date' => $letterDetails[2],
            'received_date' => $letterDetails[3],
            'diary_date' => $letterDetails[4],
            'subject' => $letterDetails[6],
            'letter_path' => $letterDetails[7],
            'auto_ack' => $letterDetails[8],
            'stage_status' => 1,
            'department_id' => session('role_dept'),
            'receipt' => $receipt,
            'legacy' => $legacy,
            'crn' => $letterDetails[12],
        ]);
    }

    public static function showLetterAndSender($condition, $letters)
    {
        // Join the necessary tables and use CASE to handle conditional selection based on receipt
        $lettersDetails = Letter::leftJoin('senders', 'letters.id', '=', 'senders.letter_id')
            ->leftJoin('recipients', 'letters.id', '=', 'recipients.letter_id')
            ->join('user_departments', 'letters.user_id', '=', 'user_departments.id') // Add the join for user_departments
            ->join('letter_categories', 'letters.letter_category_id', '=', 'letter_categories.id') // Add the join for user_departments
            ->select(
                'letters.letter_no',
                'letters.receipt',
                'letters.subject',
                'recipients.recipient_name',
                'senders.sender_name',
                'senders.sender_designation',
                'senders.organization',
                'letters.letter_path',
                'letters.id AS letter_id',
                'recipients.organization as recipient_organization',
                'senders.organization as sender_organization',
                'senders.sender_phone',
                'senders.sender_email',
                'senders.address',
                'letters.crn',
                'letters.stage_status',
                'letters.diary_date',
                'letters.received_date',
                'letters.issue_date',
                'letters.letter_date',
                'letters.letter_category_id',
                'letters.letter_sub_category_id',
                'letters.legacy',
                'letters.letter_priority_id',
                'letter_categories.category_name'
            )
            ->where($condition);  // Apply the given condition
    
        // If letters array is not empty, filter the results further with whereIn
        if (count($letters) > 0) {
            $lettersDetails = $lettersDetails->whereIn('letters.id', $letters);
        }
    
        // Order by letters.id in descending order
        $lettersDetails = $lettersDetails->orderBy('letters.id', 'DESC')->get();
    
        return $lettersDetails;
    }
    



    public static function showInboxLetters($condition,$assignedLetterIds)
    {
        $receivedLetters = Letter::join('senders', 'letters.id', '=', 'senders.letter_id')
        ->join('action_sents', 'letters.id', '=', 'action_sents.letter_id')
        ->where($condition)
        ->groupBy('letter_no', 'subject', 'sender_name', 'letter_path', 'letters.id', 'organization', 'crn', 'stage_status')
        ->orderBy('letters.id', 'DESC')
        ->select('letter_no', 'subject', 'sender_name', 'letter_path', 'letters.id AS letter_id', 'organization', 'crn', 'stage_status')
        ->get();
        $assignedLetters = Letter::join('senders', 'letters.id', '=', 'senders.letter_id')
        ->join('letter_assigns', 'letters.id', '=', 'letter_assigns.letter_id')
        ->whereIn('letter_assigns.id',$assignedLetterIds)
        ->groupBy('letter_no', 'subject', 'sender_name', 'letter_path', 'letters.id', 'organization', 'crn', 'stage_status')
        ->orderBy('letters.id', 'DESC')
        ->select('letter_no', 'subject', 'sender_name', 'letter_path', 'letters.id AS letter_id', 'organization', 'crn', 'stage_status')
        ->get();
        return $assignedLetters->merge($receivedLetters);
    }

    public static function generateLetterCrn($crn)
    {

        return DB::table('letters')
            ->where('id', $crn[0])
            ->update(['crn' => $crn[1]]);
    }

    public static function finalizeLetter($letterId)
    {

        return DB::table('letters')
            ->where('id', $letterId)
            ->update([
                'draft_finalize' => true,
                'stage_status' => 2
            ]);
    }

    public static function changeLetterStage($letterId, $stageId)
    {

        return DB::table('letters')
            ->where('id', $letterId)
            ->update([
                'stage_status' => $stageId
            ]);
    }

    public static function showLetterAndRecipient($condition, $letters)
    {
        $lettersDetails =  Letter::join('recipients', 'letters.id', '=', 'recipients.letter_id')
            ->join('user_departments', 'letters.user_id', '=', 'user_departments.id')
            ->where($condition);
        if (count($letters) > 0) {
            $lettersDetails = $lettersDetails->whereIn('letters.id', $letters);
        }
        $lettersDetails = $lettersDetails->orderBy('letters.id', 'DESC')
            ->select('letter_no', 'subject', 'recipient_name', 'letter_path', 'letters.id AS letter_id', 'organization', 'crn', 'stage_status', 'receipt')
            ->get();

        return $lettersDetails;
    }
}
