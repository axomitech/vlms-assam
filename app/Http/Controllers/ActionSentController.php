<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreActionSentRequest;
use App\Http\Requests\UpdateActionSentRequest;
use App\Models\LetterActionResponse;
use App\Models\UserDepartment;
use App\Models\ActionStatus;
use App\Models\ActionSent;
use App\Models\Letter;
use App\Models\Common;
use Carbon\Carbon;
use Auth;
use DB;

class ActionSentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($letterId)
    {
        $letterId = decrypt($letterId);
        $forwards = ActionSent::inbox($letterId);
        return view('hod.inbox',compact('forwards'));
    }

    public function inbox(){
        $receiverId = Common::getSingleColumnValue('user_departments',[
            'department_id'=>session('role_dept'),
            'user_id'=>Auth::user()->id,
            'role_id'=>session('role')
        ],'id');
        $letters = Letter::showInboxLetters([
            'action_sents.receiver_id'=>$receiverId
           ]);
        return view('hod.inbox_letter',compact('letters'));
    }

    public function outbox()
    {
        $forwardActions = ActionSent::getForwardedActions();
        $forwards = [];
        $i = 0;
        foreach($forwardActions AS $value){
            $forwards[$i] = ActionSent::outbox($value['action_id']);
            $i++;
        }
        // $timeSpans = [];
        // foreach($forwards AS $value){
        //     $timeSpans[$i] = Carbon::parse()
        //     $timeSpans[$i] = Carbon::parse($)
        // }
        return view('hod.outbox',compact('forwards','forwardActions'));
    }

    public function response($actionSentId,$actionDeptId,$letterId){
        $actionSentId = decrypt($actionSentId);
        $actionDeptId = decrypt($actionDeptId);
        $letterId = decrypt($letterId);
        $letterPath = Common::getSingleColumnValue('letters',[
            'id'=>$letterId,
        ],'letter_path');
        $actionStatuses = ActionStatus::getAllActionStatus();
        $responses = LetterActionResponse::getResponses($actionSentId);
        $disableResponse = "";
        foreach($responses AS $value){
            if($value['status_name'] == "Completed"){
                $disableResponse = "disabled";
            }
        }
        return view('hod.respond',compact('actionSentId','letterId','letterPath','actionStatuses','actionDeptId','responses','disableResponse'));
    }

    public function getActionResponses(Request $request){
        $jdata = [];
        if($request->ajax()){
            $jdata[0] = [
                'remarks'=>'',
                'status'=>'',
                'response_date'=>'',
                'attachment'
            ];
            $responses = LetterActionResponse::getResponses($request->action_sent);
            $i = 1;
            foreach($responses AS $value){
                $jdata[$i] = [
                    'remarks'=>$value['action_remarks'],
                    'status'=>$value['status_name'],
                    'response_date'=>Carbon::parse($value['response_date'])->format('d/m/Y'),
                    'attachment'=>config('constants.options.storage_url')."".$value['response_attachment'],
                ];
                $i++;
            }
        }

        return response()->json($jdata);
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
