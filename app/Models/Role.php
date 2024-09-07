<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public static function getAllRoles(){
        return Role::select('id','role_name')->get();
    }

    public static function getSuperAdminRoles(){
        return Role::select('id','role_name')->where('id',4)->get();
    }
    public static function getDepartmentalAdminRoles(){
        return Role::select('id','role_name')->whereIn('id',[1,2,3])->get();

    }
}
