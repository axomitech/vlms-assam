<?php

namespace App\Models;

use App\Traits\DbConstants;
use App\Traits\GlobalHelper;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SearchModel extends Model
{
    use HasFactory;
    public static function get_letter_search($diarized_no,$letter_id,$received_from,$received_to)
    {
        return DB::select("SELECT * FROM letters WHERE letter_no='".$letter_id."' or crn='".$diarized_no."' or received_date>='".$received_from."' and received_date<='".$received_to."'");
    }
}
