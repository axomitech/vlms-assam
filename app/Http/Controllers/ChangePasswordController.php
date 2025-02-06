<?php

namespace App\Http\Controllers;
use App\Http\Requests\PasswordChangeRequest;
use App\Models\User;
use Auth;
use DB;

use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{
    public function changePassword(PasswordChangeRequest $request){
        if($request->ajax()){
            $jData = [];
        
            DB::beginTransaction();
    
                try {

                    $updateStatus = User::changePassword([
                        Auth::user()->id,
                        $request->old_password,
                        $request->new_password
                    ]);
                    if($updateStatus > 0){
                        DB::commit();
                        $jData[1] = [
                            'message'=>'Your password is successfully updated.',
                            'status'=>'success'
                        ];
                    }else{
                        $jData[1] = [
                            'message'=>'Something went wrong! Please try again.',
                            'status'=>'error'
                        ];
                    }
                    
                } catch (\Exception $e) {
                    DB::rollback();
                    $jData[1] = [
                        'message'=>'Something went wrong! Please try again.'.$e->getMessage(),
                        'status'=>'error'
                    ];
                }

                return response()->json($jData,200);
        }
    }
}
