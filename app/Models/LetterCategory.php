<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterCategory extends Model
{
    use HasFactory;
    public static function getAllLetterCategories(){
        return LetterCategory::select('id','category_name')->get();
    }
}
