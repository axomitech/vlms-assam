<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Common;
class SessionInitiationController extends Controller
{
    
    public function index($user,$department,$role){
        session([
            'role_user'=>$user
        ]);

        session([
            'role_dept'=>$department
        ]);

        session([
            'role'=>$role
        ]);

        session([
            'department'=>Common::getSingleColumnValue('departments',['id'=>session('role_dept')],'department_name')
        ]);
        
        if(session('role') == 1){
            return redirect('/diarize');
        }

        if(session('role') == 2){
            return redirect('/letters');
        }

        if(session('role') == 3){
            return redirect('/letters');
        }
        
    }

}
