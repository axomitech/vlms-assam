<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLetterActionResponseRequest;
use App\Http\Requests\UpdateLetterActionResponseRequest;
use App\Http\Requests\ActionResponseRequest;
use App\Models\LetterActionResponse;
use App\Models\LetterResponseAttachment;
use App\Models\ActionDepartmentMap;
use App\Models\UserDepartment;
use App\Models\ActionSent;
use App\Models\Letter;
use Carbon\Carbon;
use Auth;
use DB;
class LetterActionResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreLetterActionResponseRequest $request)
    {
        if($request->ajax()){
            
            DB::beginTransaction();
            $actMap = $request->action_map;
            $actDept = $request->action_dept;
            $letter = $request->forward_letter;
            Letter::finalizeLetter($letter);
            $forwardingPath = "";
            if ($request->hasFile('forwarding')) {
                
                if ($request->file('forwarding')->isValid()) {

                    $forwardingPath = $request->forwarding->store('public/forwarding');

                }else{

                    $jData[1] = [
                        'message'=>'The forwarding upload was unsuccessful! Please try again.',
                        'status'=>'error'
                    ];
                }

            }else{

                $jData[1] = [
                    'message'=>'The uploaded forwarding is absent! Please try again.',
                    'status'=>'error'
                ];
            }
            for($i = 0; $i < count($actDept); $i++){

                ActionSent::storeActionForward([
                    $actMap[$i],
                    UserDepartment::getUser(Auth::user()->id),
                    UserDepartment::getDepartmentUser($actDept[$i],3),
                    $letter,
                ]);

            }

            $actions = $request->letter_action;
                try {

                    for($i = 0; $i < count($actDept); $i++){
                        
                        $noteDetails = [

                            ActionDepartmentMap::getActionDepartment([
                                $actDept[$i],
                                $actions[$i]
                            ]),
    
                            $request->note,
                            null
    
                        ];
                        
                    $noteId = LetterActionResponse::storeNote($noteDetails);
                    
                        Letter::changeLetterStage($letter,3);

                        $attachmentId = LetterResponseAttachment::storeAttachment([
                            $noteId,
                            $forwardingPath,
                            true
                        ]);
                    
                        DB::commit();
                    }
                    
                    
                    $jData[1] = [
                        'message'=>'Letter data is successfully stored.',
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

    public function actionNotes(Request $request){
        $jdata = [];
        if($request->ajax()){
            $jdata[0] = [
                'note'=>'',
                'date_time'=>'',
                'name'=>'',
                'attach'=>'',
            ];
            $i = 1;
            $notes = LetterActionResponse::getAllActionNotes($request->action);
            $attachment = "";
            foreach($notes AS $value){
                if($value['response_attachment'] != ""){
                    $attachment = config('constants.options.storage_url')."".$value['response_attachment'];
                }
                $jdata[$i] = [
                    'note'=>$value['action_remarks'],
                    'date_day'=>Carbon::parse($value['created_at'])->format('d/m/Y'),
                    'date_time'=>Carbon::parse($value['created_at'])->format('H:m:s'),
                    'name'=>$value['name'],
                    'attach'=> $attachment,
                ];
                $i++;
            }

            return response()->json($jdata);

        }else{
            return response()->json($jdata);
        }
    }

    public function storeResponse(ActionResponseRequest $request){
        if($request->ajax()){
            $responsePath = "";
            if ($request->hasFile('action_response')) {
                
                if ($request->file('action_response')->isValid()) {

                    $responsePath = $request->action_response->store('public/action_response');

                }else{

                    $jData[1] = [
                        'message'=>'The response upload was unsuccessful! Please try again.',
                        'status'=>'error'
                    ];
                }

            }else{

                $jData[1] = [
                    'message'=>'The uploaded response is absent! Please try again.',
                    'status'=>'error'
                ];
            }
            DB::beginTransaction();

                $actionsentId = $request->act_sent;
                $actionDeptId = $request->act_dept;
                $actionStatus = $request->action_status;
                $note = $request->note;
                
                try {

                    $noteId = LetterActionResponse::storeNote([
                        $actionDeptId,
                        $note,
                        $actionStatus
                    ]);
                    
                    $attachmentId = LetterResponseAttachment::storeAttachment([
                        $noteId,
                        $responsePath,
                        false
                    ]);
                    ActionDepartmentMap::changeActionStatus([
                        $actionDeptId,
                        $actionStatus
                    ]);
                    $completedCount = 0;
                    $actionDepartment = 0;
                    $responseActions = $request->acts;
                    for($i = 0; $i < count($responseActions); $i++){
                        $completeConfirm = ActionDepartmentMap::confirmActionCompletion($responseActions[$i]);
                        $completedCount += $completeConfirm[0];
                        $actionDepartment += $completeConfirm[1];
                    }
                    if($completedCount == $actionDepartment){
                    
                        Letter::changeLetterStage($request->letter,4);
                        //Letter::changeLetterStage($request->letter,5);

                    }else if($completedCount < $actionDepartment){
                        Letter::changeLetterStage($request->letter,6);

                    }

                    DB::commit();
                    $jData[1] = [
                        'message'=>'Response is successfully stored.',
                        'status'=>'success'
                    ];
                    
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

    /**
     * Display the specified resource.
     */
    public function show(LetterActionResponse $letterActionResponse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LetterActionResponse $letterActionResponse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLetterActionResponseRequest $request, LetterActionResponse $letterActionResponse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LetterActionResponse $letterActionResponse)
    {
        //
    }
}
