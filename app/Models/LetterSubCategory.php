<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterSubCategory extends Model
{
    use HasFactory;

    public static function getLetterSubCategory($category_id){


        return LetterSubCategory::where([
            'letter_category_id'=>$category_id,
            'active_status'=>TRUE
        ])->select('id','sub_category_name')
        ->get();


    }
}
