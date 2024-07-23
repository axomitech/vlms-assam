<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterPriority extends Model
{
    use HasFactory;

    public static function getAllPriorities(){
        return LetterPriority::select('id','priority_name')->get();
    }
}
