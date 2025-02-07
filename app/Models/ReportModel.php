<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReportModel extends Model
{
    use HasFactory;

    public static function get_diarized_count()
    {
        return DB::table('letters')
            ->where('department_id', '=', session('role_dept'))
            ->where('letters.stage_status', 1)
            ->count();
    }

    public static function get_assigned_count()
    {
        return DB::table('letters')
            ->where('department_id', '=', session('role_dept'))
            ->where('letters.stage_status', 2)
            ->count();
    }

    public static function get_forwarded_count()
    {
        return DB::table('letters')
            ->where('department_id', '=', session('role_dept'))
            ->where('letters.stage_status', 3)
            ->count();
    }

    public static function get_diarized_details()
    {
        return DB::table('letters')
            ->join('letter_categories', 'letters.letter_category_id', '=', 'letter_categories.id')
            ->where('letters.department_id', '=', session('role_dept'))
            ->where('letters.stage_status', 1)
            ->select(
                'letter_categories.id',
                'letter_categories.category_name',
                DB::raw('COUNT(letters.id) as count')
            )
            ->groupBy('letter_categories.id', 'letter_categories.category_name')  // Group by category only
            ->orderBy('count', 'desc')  // You can order by count to get the most frequent category first
            ->get();
    }


    public static function get_assigned_details()
    {
        return DB::table('letters')
        ->join('letter_categories', 'letters.letter_category_id', '=', 'letter_categories.id')
        ->where('letters.department_id', '=', session('role_dept'))
        ->where('letters.stage_status', 2)
        ->select(
            'letter_categories.id',
            'letter_categories.category_name',
            DB::raw('COUNT(letters.id) as count')
        )
        ->groupBy('letter_categories.id', 'letter_categories.category_name')  // Group by category only
        ->orderBy('count', 'desc')  // You can order by count to get the most frequent category first
        ->get();
    }

    public static function get_forwarded_details()
    {
        return DB::table('letters')
        ->join('letter_categories', 'letters.letter_category_id', '=', 'letter_categories.id')
        ->where('letters.department_id', '=', session('role_dept'))
        ->where('letters.stage_status', 3)
        ->select(
            'letter_categories.id',
            'letter_categories.category_name',
            DB::raw('COUNT(letters.id) as count')
        )
        ->groupBy('letter_categories.id', 'letter_categories.category_name')  // Group by category only
        ->orderBy('count', 'desc')  // You can order by count to get the most frequent category first
        ->get();
    }

    public static function get_diarized_report($category_id)
    {
        return DB::table('letters')
            ->join('letter_categories', 'letters.letter_category_id', '=', 'letter_categories.id')
            ->join('user_departments','user_departments.id','=','letters.user_id')
            ->join('users','users.id','=','user_departments.user_id')
            ->select('crn','subject','letter_no','received_date','letter_path','letters.id AS letter_id','name','issue_date')
            ->where('letters.department_id', '=', session('role_dept'))
            ->where('letters.letter_category_id', '=', $category_id)
            ->where('letters.stage_status', 1)
            ->get();
    }
}
