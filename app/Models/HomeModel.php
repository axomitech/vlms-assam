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
            ->where('stage_status', '=', 1)
            ->count();
    }
    public static function get_sent_count()
    {
        return DB::table('letters')
            ->where('department_id', '=', session('role_dept'))
            ->where('stage_status', '=', 2)
            ->count();
    }
    public static function get_archive_count()
    {
        return DB::table('letters')
            ->where('department_id', '=', session('role_dept'))
            ->where('stage_status', '=', 3)
            ->count();
    }
    public static function get_diarized_details()
    {
        return DB::table('letters')
            ->join('senders','letters.id','=','senders.letter_id')
            ->where('letters.department_id', '=', session('role_dept'))
            ->where('letters.stage_status', '=', 1)
            ->select('letters.id as letter_id','letters.crn as crn','letters.subject as subject','senders.sender_name as sender_name',
            'draft_finalize','diary_date')
            ->get();
    }
}
