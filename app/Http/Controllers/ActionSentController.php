<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActionSentRequest;
use App\Http\Requests\UpdateActionSentRequest;
use App\Models\UserDepartment;
use App\Models\ActionStatus;
use App\Models\ActionSent;
use App\Models\Common;
use Carbon\Carbon;
use Auth;
use DB;

class ActionSentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forwards = ActionSent::inbox();
        return view('hod.inbox',compact('forwards'));
    }

    public function outbox()
    {
        $forwards = ActionSent::outbox();
        // $timeSpans = [];
        // foreach($forwards AS $value){
        //     $timeSpans[$i] = Carbon::parse()
        //     $timeSpans[$i] = Carbon::parse($)
        // }
        return view('hod.outbox',compact('forwards'));
    }

    public function response($actionSentId,$actionDeptId,$letterId){
        $actionSentId = decrypt($actionSentId);
        $actionDeptId = decrypt($actionDeptId);
        $letterId = decrypt($letterId);
        $letterPath = config('constants.options.storage_url').
        Common::getSingleColumnValue('letters','id',$letterId,'letter_path');
        $actionStatuses = ActionStatus::getAllActionStatus();
        return view('hod.respond',compact('actionSentId','letterId','letterPath','actionStatuses','actionDeptId'));
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreActionSentRequest $request)
    {
        

        if($request->ajax()){
            $jData = [];
        
            DB::beginTransaction();
    
                try {

                    $actMap = $request->action_map;
                    $actDept = $request->action_dept;
                    $letter = $request->forward_letter;

                    for($i = 0; $i < count($actDept); $i++){

                        ActionSent::storeActionForward([
                            $actMap[$i],
                            UserDepartment::getUser(Auth::user()->id),
                            UserDepartment::getDepartmentUser($actDept[$i],3),
                            $letter,
                        ]);

                    }
                    DB::commit();
                    $jData[1] = [
                        'message'=>'Actions are successfully forwarded.',
                        'status'=>'success'
                    ];
                    
                } catch (\Exception $e) {
                    DB::rollback();
                    $jData[1] = [
                        'message'=>'Something went wrong! Please try again.'.$e->getMessage(),
                        'candidate'=>'',
                        'status'=>'error'
                    ];
                }

                return response()->json($jData,200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ActionSent $actionSent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActionSent $actionSent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateActionSentRequest $request, ActionSent $actionSent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActionSent $actionSent)
    {
        //
    }
}
