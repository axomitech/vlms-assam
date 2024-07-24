<?php

namespace App\Models;

use App\Traits\DbConstants;
use App\Traits\GlobalHelper;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdminModel extends Model
{
    use HasFactory;

    public static function get_all_user_details(){
        return DB::table('user_departments')
                    ->join('users','user_departments.user_id','=','users.id')
                    ->join('departments','user_departments.department_id','=','departments.id')
                    ->join('roles','user_departments.role_id','=','roles.id')
                    ->select('users.id as u_id',
                            'users.name as u_name',
                            'users.email as u_email',
                            'roles.id as role_id',
                            'roles.role_name',
                            'departments.department_name',
                            'departments.id as dept_id',
                            'user_departments.id as profile_id'
                    )
                    ->get();
    }
}
