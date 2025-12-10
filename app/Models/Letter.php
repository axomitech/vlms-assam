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
            $letter->issue_date = $letterDetails[3];
        } else {
            $letter->received_date = $letterDetails[3];
        }

        if ($letterDetails[11] == 0) {
            $letter->legacy = false;
        }

        $letter->letter_other_sub_categories = $letterDetails[12];
        $letter->ecr_no = $letterDetails[13];
        $letter->save();

        return $letter->id;
    }


    public static function updateLetter($letterDetails, $letter)
    {
        $receipt = $letterDetails[9] != 0;
        $legacy = $letterDetails[11] != 0;

        Letter::where([
            'id' => $letter->id
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
            'letter_other_sub_categories' => $letterDetails[13],
            'ecr_no' => $letterDetails[14]
        ]);
    }


    public static function showLetterAndSender($condition, $letters)
    {
        $lettersDetails = Letter::leftJoin('senders', 'letters.id', '=', 'senders.letter_id')
            ->leftJoin('recipients', 'letters.id', '=', 'recipients.letter_id')
            ->join('user_departments', 'letters.user_id', '=', 'user_departments.id')
            ->join('users', 'users.id', '=', 'user_departments.user_id')
            ->join('letter_categories', 'letters.letter_category_id', '=', 'letter_categories.id')
            ->select(
                'letters.letter_no',
                'letters.receipt',
                'letters.subject',
                'senders.sender_name',
                'senders.sender_designation',
                'senders.organization',
                'letters.letter_path',
                'letters.id AS letter_id',
                'recipients.recipient_name',
                'recipients.recipient_designation',
                'recipients.organization as recipient_organization',
                'recipients.recipient_phone',
                'recipients.recipient_email',
                'recipients.address AS recipient_address',
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
                'letter_categories.category_name',
                'letters.letter_path',
                'letters.letter_other_sub_categories',
                'letters.issue_date',
                'letters.user_id',
                'users.name',
                'users.id AS diarizer_id',
                'letters.ecr_no'
            );

        if (count($condition) > 0) {
            $lettersDetails = $lettersDetails->where($condition);
        }

        if (count($letters) > 0) {
            $lettersDetails = $lettersDetails->whereIn('letters.id', $letters);
        }

        if (count($letters) == 0 && count($condition) == 0) {
            return [];
        }

        return $lettersDetails->orderBy('letters.id', 'DESC')->get();
    }


    public static function showInboxLetters($condition, $assignedLetterIds)
    {
        $receivedLetters = Letter::join('senders', 'letters.id', '=', 'senders.letter_id')
            ->join('user_departments', 'letters.user_id', '=', 'user_departments.id')
            ->join('users', 'users.id', '=', 'user_departments.user_id')
            ->join('action_sents', 'letters.id', '=', 'action_sents.letter_id')
            ->join('letter_categories', 'letters.letter_category_id', '=', 'letter_categories.id')
            ->where($condition)
            ->groupBy('letter_no', 'subject', 'sender_name', 'letter_path', 'letters.id', 'organization', 'crn', 'stage_status', 'letter_categories.category_name', 'users.name')
            ->orderBy('letters.id', 'DESC')
            ->select('letter_no', 'subject', 'sender_name', 'letter_path', 'letters.id AS letter_id', 'organization', 'crn', 'stage_status', 'letter_categories.category_name', 'users.name')
            ->get();

        $assignedLetters = Letter::join('senders', 'letters.id', '=', 'senders.letter_id')
            ->join('user_departments', 'letters.user_id', '=', 'user_departments.id')
            ->join('users', 'users.id', '=', 'user_departments.user_id')
            ->join('letter_assigns', 'letters.id', '=', 'letter_assigns.letter_id')
            ->join('letter_categories', 'letters.letter_category_id', '=', 'letter_categories.id')
            ->whereIn('letter_assigns.id', $assignedLetterIds)
            ->groupBy('letter_no', 'subject', 'sender_name', 'letter_path', 'letters.id', 'organization', 'crn', 'stage_status', 'letter_categories.category_name', 'users.name')
            ->orderBy('letters.id', 'DESC')
            ->select('letter_no', 'subject', 'sender_name', 'letter_path', 'letters.id AS letter_id', 'organization', 'crn', 'stage_status', 'letter_categories.category_name', 'users.name')
            ->get();

        return [
            $receivedLetters,
            $assignedLetters
        ];
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
            ->update(['stage_status' => $stageId]);
    }


    public static function showLetterAndRecipient($condition, $letters)
    {
        $lettersDetails =  Letter::join('recipients', 'letters.id', '=', 'recipients.letter_id')
            ->join('user_departments', 'letters.user_id', '=', 'user_departments.id')
            ->where($condition);

        if (count($letters) > 0) {
            $lettersDetails = $lettersDetails->whereIn('letters.id', $letters);
        }

        return $lettersDetails->orderBy('letters.id', 'DESC')
            ->select('letter_no', 'subject', 'recipient_name', 'letter_path', 'letters.id AS letter_id', 'organization', 'crn', 'stage_status', 'receipt')
            ->get();
    }


    public static function actionTakenLetters($condition)
    {
        $letters = Letter::join('letter_actions', 'letters.id', '=', 'letter_actions.letter_id')
            ->join('action_department_maps', 'letter_actions.id', '=', 'action_department_maps.letter_action_id')
            ->where([
                'action_department_maps.department_id' => session('role_dept'),
            ])
            ->where([$condition])
            ->select('letters.id')
            ->get();

        $actionTakens = [];
        foreach ($letters as $value) {
            $actionTakens[] = $value['id'];
        }

        return $actionTakens;
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\LetterCategory::class, 'letter_category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(\App\Models\LetterSubCategory::class, 'letter_sub_category_id');
    }

    public function recipient()
    {
        return $this->hasOne(\App\Models\Recipient::class, 'letter_id', 'id');
    }

    public function sender()
    {
        return $this->hasOne(\App\Models\Sender::class, 'letter_id', 'id');
    }

    public static function getAllLetterNo()
    {
        return Letter::select('letter_no')->get();
    }

    public function diarizer()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
