<?php

namespace App\Models;

use App\Traits\DbConstants;
use App\Traits\GlobalHelper;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HomeModel extends Model
{
    use HasFactory;

    public static function get_diarized_count()
    {
        return DB::table('letters')
            ->where('department_id', '=', session('role_dept'))
            ->whereIn('letters.stage_status', [1, 2])
            ->count();
    }
    public static function get_sent_count()
    {
        return DB::table('letters')
            ->where('department_id', '=', session('role_dept'))
            ->where('stage_status', '=', 3)
            ->count();
    }
    public static function get_archive_count()
    {
        return DB::table('letters')
            ->where('department_id', '=', session('role_dept'))
            ->where('stage_status', '=', 5)
            ->count();
    }
    public static function get_inbox_count()
    {
        return DB::table('action_sents')
            ->join('action_department_maps', 'action_sents.act_dept_id', '=', 'action_department_maps.id')
            ->where('action_department_maps.department_id', '=', session('role_dept'))
            ->count();
    }
    public static function get_diarized_details()
    {
        return DB::table('letters')
            ->join('senders', 'letters.id', '=', 'senders.letter_id')
            ->where('letters.department_id', '=', session('role_dept'))
            ->whereIn('letters.stage_status', [1, 2])
            ->select(
                'letters.id as letter_id',
                'letters.crn as crn',
                'letters.subject as subject',
                'stage_status',
                'senders.sender_name as sender_name',
                'draft_finalize',
                'diary_date',
                'sender_designation',
                'organization'
            )
            ->orderBy('letters.id', 'desc')
            ->get();
    }

    public static function get_issue_count()
    {
        return DB::table('letters')
            ->where('department_id', '=', session('role_dept'))
            ->where('receipt', '=', false)
            ->count();
    }

    public static function get_receipt_count()
    {
        return DB::table('letters')
            ->where('department_id', '=', session('role_dept'))
            ->where('receipt', '=', true)
            ->count();
    }

    public static function get_receipt_count_by_category()
    {
        return DB::table('letters')
            ->join('letter_categories', 'letters.letter_category_id', '=', 'letter_categories.id')
            ->select('letter_categories.id', 'letter_categories.category_name', DB::raw('COUNT(*) as count'))
            ->where('letters.department_id', '=', session('role_dept'))
            ->where('letters.receipt', '=', true)
            ->groupBy('letters.letter_category_id', 'letter_categories.id', 'letter_categories.category_name')
            ->get();
    }

    public static function get_issue_count_by_category()
    {
        return DB::table('letters')
            ->join('letter_categories', 'letters.letter_category_id', '=', 'letter_categories.id')
            ->select('letter_categories.id', 'letter_categories.category_name', DB::raw('COUNT(*) as count'))
            ->where('letters.department_id', '=', session('role_dept'))
            ->where('letters.receipt', '=', false)
            ->groupBy('letters.letter_category_id', 'letter_categories.id', 'letter_categories.category_name')
            ->get();
    }

    public static function get_receipt_by_category($category_id)
    {
        return DB::table('letters')
            ->join('senders', 'letters.id', '=', 'senders.letter_id')

            ->where('letters.department_id', '=', session('role_dept'))
            ->where('letter_category_id', $category_id)
            ->where('letters.receipt', '=', true)
            ->get();
    }

    public static function get_issue_by_category($category_id)
    {
        return DB::table('letters')
            ->join('senders', 'letters.id', '=', 'senders.letter_id')
            ->where('letters.department_id', '=', session('role_dept'))
            ->where('letter_category_id', $category_id)
            ->where('letters.receipt', '=', false)
            ->get();
    }

    public static function get_action_count_by_category()
    {
        return DB::table('letters')
            ->join('letter_categories', 'letters.letter_category_id', '=', 'letter_categories.id')
            ->join('letter_actions', 'letters.id', '=', 'letter_actions.letter_id')
            ->join('action_department_maps', 'letter_actions.id', '=', 'action_department_maps.letter_action_id')
            ->select('letter_categories.id', 'letter_categories.category_name', DB::raw('COUNT(letters.id) as count'))
            ->where('action_department_maps.department_id', session('role_dept'))
            ->where('action_department_maps.action_status_id', 3)
            ->groupBy('letter_categories.id', 'letter_categories.category_name')
            ->get();
    }


    public static function get_action_by_category($category_id)
    {
        return DB::table('letters')
        ->join('letter_categories', 'letters.letter_category_id', '=', 'letter_categories.id')
        ->join('letter_actions', 'letters.id', '=', 'letter_actions.letter_id')
        ->join('action_department_maps', 'letter_actions.id', '=', 'action_department_maps.letter_action_id')
        ->join('senders', 'letters.id', '=', 'senders.letter_id')
        ->where('action_department_maps.department_id', session('role_dept'))
        ->where('action_department_maps.action_status_id', 3)
        ->where('letters.letter_category_id', $category_id)
        ->get();
    }

    public static function get_actions_count()
    {
        return DB::table('action_department_maps')
            ->where('department_id', '=', session('role_dept'))
            ->where('action_status_id', 3)
            ->count();
    }
}
