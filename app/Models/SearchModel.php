<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SearchModel extends Model
{
    use HasFactory;

    public static function get_letter_search($inputData)
    {
        $query = DB::table('letters')
            ->leftJoin('senders', 'letters.id', '=', 'senders.letter_id')
            ->leftJoin('recipients', 'letters.id', '=', 'recipients.letter_id')
            ->leftJoin('letter_categories', 'letters.letter_category_id', '=', 'letter_categories.id')
            ->leftJoin('letter_sub_categories', 'letters.letter_sub_category_id', '=', 'letter_sub_categories.id')
            ->select(
                'letters.id as letter_id',
                'letters.*',
                'senders.organization as sender_organization',
                'senders.sender_name as sender_name',
                'senders.sender_email as sender_email',
                'senders.sender_phone as sender_phone',
                'senders.sender_designation as sender_designation',
                'senders.sms_to as sms_to',
                'senders.email_to as email_to',
                'senders.address as address',
                'recipients.recipient_name as recipient_name',
                'recipients.recipient_email as recipient_email',
                'recipients.recipient_phone as recipient_phone',
                'recipients.recipient_designation as recipient_designation',
                'recipients.address as address',
                'recipients.organization as recipient_organization',
                'letter_categories.*',
                'letter_sub_categories.*'
            );

        if (!empty($inputData['text_search'])) {

            $searchTerm = strtolower(trim($inputData['text_search']));

            $query->where(function ($q) use ($searchTerm) {

                $q->orWhere(DB::raw("lower(REPLACE(letters.letter_no, '\\\\', ''))"), 'like', "%{$searchTerm}%")
                    ->orWhere(DB::raw('lower(letters.subject)'), 'like', "%{$searchTerm}%")
                    ->orWhere(DB::raw('lower(letters.ecr_no)'), 'like', "%{$searchTerm}%")
                    ->orWhere(DB::raw('lower(letters.crn)'), 'like', "%{$searchTerm}%")
                    ->orWhere(DB::raw('lower(letters.letter_other_sub_categories)'), 'like', "%{$searchTerm}%")
                    ->orWhere(DB::raw('lower(senders.sender_name)'), 'like', "%{$searchTerm}%")
                    ->orWhere(DB::raw('lower(recipients.recipient_name)'), 'like', "%{$searchTerm}%")
                    ->orWhere(DB::raw('lower(letter_categories.category_name)'), 'like', "%{$searchTerm}%")
                    ->orWhere(DB::raw('lower(letter_sub_categories.sub_category_name)'), 'like', "%{$searchTerm}%");
            });
        }

        if (!empty($inputData['category'])) {
            $query->where('letters.letter_category_id', '=', $inputData['category']);
        }

        if (!empty($inputData['subcategory'])) {
            $query->where('letters.letter_sub_category_id', '=', $inputData['subcategory']);
        }

        if (!empty($inputData['received_from']) && !empty($inputData['received_to'])) {
            $query->whereBetween('letter_date', [$inputData['received_from'], $inputData['received_to']]);
        }

        return $query->whereIn('legacy', [true, false])
            ->orderBy('letters.id', 'desc')
            ->get();
    }

    public static function get_all_letter_categories()
    {
        return DB::table('letter_categories')->get();
    }

    public static function get_all_letter_subcategories()
    {
        return DB::table('letter_sub_categories')->get();
    }

    public static function get_letter_full_movements($letterId)
    {
        $movements = [];

        $letter = DB::table('letters')
            ->join('user_departments', 'letters.user_id', '=', 'user_departments.id')
            ->join('users', 'user_departments.user_id', '=', 'users.id')
            ->leftJoin('senders', 'letters.id', '=', 'senders.letter_id')
            ->leftJoin('recipients', 'letters.id', '=', 'recipients.letter_id')
            ->where('letters.id', $letterId)
            ->select(
                'users.name as dept_user_name',
                'user_departments.id as sender_id',
                'letters.diary_date',
                'letters.issue_date',
                'letters.letter_path',
                'senders.sender_name',
                'recipients.recipient_name'
            )
            ->first();

        if ($letter) {

            $initialSender = $letter->dept_user_name;

            if (!empty($letter->issue_date)) {
                $initialReceiver = $letter->sender_name ?? $letter->recipient_name ?? 'N/A';
            } else {
                $initialReceiver = '';
            }

            $initialStatus = !empty($letter->issue_date) ? 'Completed' : 'Pending';

            $movements[] = (object)[
                'sender_name'        => $initialSender ?? 'N/A',
                'sender_id'          => $letter->sender_id ?? '',
                'receiver_name'      => $initialReceiver,
                'receiver_id'        => '',
                'sent_on'            => $letter->diary_date,
                'action_description' => 'Letter Diarized',
                'action_remarks'     => 'Initial Entry',
                'status_name'        => $initialStatus,
                'attachments'        => !empty($letter->letter_path)
                    ? [(object)['response_attachment' => $letter->letter_path]]
                    : []
            ];
        }


        $assignments = DB::table('letter_assigns')
            ->join('user_departments as sender_ud', 'letter_assigns.user_id', '=', 'sender_ud.id')
            ->join('users as sender', 'sender_ud.user_id', '=', 'sender.id')
            ->join('user_departments as receiver_ud', 'letter_assigns.receiver_id', '=', 'receiver_ud.id')
            ->join('users as receiver', 'receiver_ud.user_id', '=', 'receiver.id')
            ->where('letter_assigns.letter_id', $letterId)
            ->orderBy('letter_assigns.id', 'ASC')
            ->select(
                'sender.name as sender_name',
                'receiver.name as receiver_name',
                'sender_ud.id as sender_id',
                'receiver_ud.id as receiver_id',
                'letter_assigns.created_at as sent_on',
                'letter_assigns.remarks',
                'letter_assigns.in_hand'
            )
            ->get();

        foreach ($assignments as $assign) {

            $status = !empty($letter->issue_date)
                ? 'Completed'
                : ($assign->in_hand ? 'In Process' : 'Sent');

            $movements[] = (object)[
                'sender_name'        => $assign->sender_name ?? 'N/A',
                'sender_id'          => $assign->sender_id,
                'receiver_name'      => $assign->receiver_name ?? 'N/A',
                'receiver_id'        => $assign->receiver_id,
                'sent_on'            => $assign->sent_on,
                'action_description' => 'Letter Assigned',
                'action_remarks'     => $assign->remarks ?? '',
                'status_name'        => $status,
                'attachments'        => []
            ];
        }


        $forwards = DB::table('action_sents')
            ->join('user_departments as sender_ud', 'action_sents.sender_id', '=', 'sender_ud.id')
            ->join('users as sender', 'sender_ud.user_id', '=', 'sender.id')
            ->join('user_departments as receiver_ud', 'action_sents.receiver_id', '=', 'receiver_ud.id')
            ->join('users as receiver', 'receiver_ud.user_id', '=', 'receiver.id')
            ->leftJoin('action_department_maps', 'action_sents.act_dept_id', '=', 'action_department_maps.id')
            ->leftJoin('letter_actions', 'action_department_maps.letter_action_id', '=', 'letter_actions.id')
            ->leftJoin('letter_action_responses', 'letter_action_responses.act_dept_map_id', '=', 'action_sents.act_dept_id')
            ->leftJoin('action_statuses', 'letter_action_responses.action_status_id', '=', 'action_statuses.id')
            ->where('action_sents.letter_id', $letterId)
            ->orderBy('action_sents.id', 'ASC')
            ->select(
                'sender.name as sender_name',
                'receiver.name as receiver_name',
                'sender_ud.id as sender_id',
                'receiver_ud.id as receiver_id',
                'action_sents.created_at as sent_on',
                'letter_actions.action_description',
                'letter_action_responses.action_remarks',
                'action_statuses.status_name',
                'letter_action_responses.id as response_id'
            )
            ->get();

        foreach ($forwards as $move) {

            $attachments = DB::table('letter_response_attachments')
                ->where('response_id', $move->response_id)
                ->where('is_forwarding', 0)
                ->get();

            $status = !empty($letter->issue_date)
                ? 'Completed'
                : ($move->status_name ?? 'Pending');

            $movements[] = (object)[
                'sender_name'        => $move->sender_name ?? 'N/A',
                'sender_id'          => $move->sender_id,
                'receiver_name'      => $move->receiver_name ?? 'N/A',
                'receiver_id'        => $move->receiver_id,
                'sent_on'            => $move->sent_on,
                'action_description' => $move->action_description ?? 'Forwarded',
                'action_remarks'     => $move->action_remarks ?? '',
                'status_name'        => $status,
                'attachments'        => $attachments
            ];
        }

        return collect($movements)->sortBy('sent_on')->values();
    }
}
