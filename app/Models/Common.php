<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Common extends Model
{
    use HasFactory;

    public static function getSingleColumnValue($tableName,$condition,$searchedColumn){

        return DB::table($tableName)->where($condition)->value($searchedColumn);
        
    }
}
