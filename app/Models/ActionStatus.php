<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionStatus extends Model
{
    use HasFactory;

    public static function getAllActionStatus(){
        return ActionStatus::select('id','status_name')->orderBy('id')->get();
    }
}
