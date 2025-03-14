<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreLetterActionRequest;
use App\Http\Requests\UpdateLetterActionRequest;
use App\Models\AcknowledgeModel;
use App\Models\LetterAction;
use App\Models\Department;
use App\Models\LetterPriority;
use App\Models\ActionDepartmentMap;
use App\Models\LetterActionResponse;
use App\Models\ActionSent;
use App\Models\Letter;
use App\Models\Common;
use DB;

class LetterActionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $priorities = LetterPriority::getAllPriorities();
        $letters = Letter::showLetterAndSender();
        $departments = Department::getAllDepartments();
        return view('deligate.action_letters',compact('letters','departments','priorities'));
    }

    public function actions($id)
    {
        $letter_id = decrypt($id);
        $letterNo = Common::getSingleColumnValue('letters',['id'=>$letter_id],'letter_no');
        $letterSubject = Common::getSingleColumnValue('letters',['id'=>$letter_id],'subject');
        $senderName = Common::getSingleColumnValue('senders',['letter_id'=>$letter_id],'sender_name');
        $organization = Common::getSingleColumnValue('senders',['letter_id'=>$letter_id],'organization');
        $letterPath = Common::getSingleColumnValue('letters',['id'=>$letter_id],'letter_path');
        $letterCrn = Common::getSingleColumnValue('letters',['id'=>$letter_id],'crn');
        $finalizeStatus = Common::getSingleColumnValue('letters',['id'=>$letter_id],'draft_finalize');
        $completeStatus = Common::getSingleColumnValue('letters',['id'=>$letter_id],'stage_status');
        $forwardStatus = ActionSent::isLetterForwarded($letter_id);
        $correspondence = AcknowledgeModel::get_correspondence_details($letter_id);

        $notes = [];
        $i = 0;
        $actionDepartments = [];
        $letterActions = LetterAction::getLetterActions($letter_id);
        $i = 0;
        $responsesStatuses=[];
        $completeCount = 0;
        $actions = [];
        $actionIds = [];
        $k = 0;
        $departments = " ";
        foreach($letterActions AS $value){
            $j = 0;
            $actions[$k] = LetterAction::getDepartmentActions($letter_id,$value['action_id']);
            $actionIds[$k] = $value['action_id'];
            foreach($actions[$k] AS $value1){
                $note = LetterActionResponse::getActionLastNote($value['action_id']);
                if($note != null){
                    $notes[$i] = $note->action_remarks;
                }else{
                    $notes[$i] = '';

                }
                $actionDepartments[$i][$j] = $value1['department_name'];
                $departments .= $value1['department_name']."_";
                $responsesStatuses[$i][$j] = ActionSent::getResponseStatuses($value1['act_dept_id'],$value1['dept_id']);
                if($responsesStatuses[$i][$j] == "Completed"){
                    $completeCount += 1;
                }
                $j++;
            }
            $k++;
            $i++;
        }
        $markComplete = 0;
        if($completeCount == count(array_filter(explode("_",$departments)))){
            if($completeStatus < 4){

            $markComplete = 1;

            }
        }
        $departments = Department::getAllDepartments();
        return view('deligate.actions',compact('actions','letterNo','letterSubject','letter_id','notes','senderName','organization','letterPath','forwardStatus','letterCrn','finalizeStatus','actionDepartments','letterActions','responsesStatuses','markComplete','departments','completeStatus','correspondence'));
    }

    public function letterIndex()
    {
        $priorities = LetterPriority::getAllPriorities();
        $letters = Letter::showLetterAndSender();
        $departments = Department::getAllDepartments();
        return view('deligate.letter_lists',compact('letters','departments','priorities'));
    }
    public function letterActions($id)
    {
        // $letter_id = decrypt($id);
        // $letterNo = Common::getSingleColumnValue('letters',['id'=>$letter_id],'letter_no');
        // $letterSubject = Common::getSingleColumnValue('letters',['id'=>$letter_id],'subject');
        // $senderName = Common::getSingleColumnValue('senders',['letter_id'=>$letter_id],'sender_name');
        // $organization = Common::getSingleColumnValue('senders',['letter_id'=>$letter_id],'organization');
        // $letterPath = Common::getSingleColumnValue('letters',['id'=>$letter_id],'letter_path');
        // $letterCrn = Common::getSingleColumnValue('letters',['id'=>$letter_id],'crn');
        // $finalizeStatus = Common::getSingleColumnValue('letters',['id'=>$letter_id],'draft_finalize');
        // $forwardStatus = ActionSent::isLetterForwarded($letter_id);
        // $departments = Department::getAllDepartments();
        // $completeStatus = Common::getSingleColumnValue('letters',['id'=>$letter_id],'stage_status');
        // $completeCount = 0;
        // $actionDepartments = [];
        // $letterActions = LetterAction::getLetterActions($letter_id);
        // $responsesStatuses = [];
        // $actions = [];
        // $i = 0;
        // foreach($letterActions AS $value){
        //     $j = 0;
        //     $actions = LetterAction::getDepartmentActions($letter_id,$value['action_id']);
        //     foreach($actions AS $value1){
        //         $actionDepartments[$i][$j] = $value1['department_name'];
        //         $responsesStatuses[$i][$j] = ActionSent::getResponseStatuses($value1['act_dept_id'],$value1['dept_id']);
        //         if($responsesStatuses[$i][$j] == "Completed"){
        //             $completeCount += 1;
        //         }
        //         $j++;
        //     }
        //     $i++;
        // }
        // $markComplete = 0;
        // if($completeCount >= count($letterActions)){
        //     if($completeStatus < 4){

        //     $markComplete = 1;

        //     }
        // }
        // return view('deligate.action_list',compact('actions','letterNo','letterSubject','letter_id','senderName','organization','departments','letterPath','letterCrn','finalizeStatus','actionDepartments','letterActions','responsesStatuses','markComplete','forwardStatus'));
        $letter_id = decrypt($id);
        $letterNo = Common::getSingleColumnValue('letters',['id'=>$letter_id],'letter_no');
        $letterSubject = Common::getSingleColumnValue('letters',['id'=>$letter_id],'subject');
        $senderName = Common::getSingleColumnValue('senders',['letter_id'=>$letter_id],'sender_name');
        $organization = Common::getSingleColumnValue('senders',['letter_id'=>$letter_id],'organization');
        $letterPath = Common::getSingleColumnValue('letters',['id'=>$letter_id],'letter_path');
        $letterCrn = Common::getSingleColumnValue('letters',['id'=>$letter_id],'crn');
        $finalizeStatus = Common::getSingleColumnValue('letters',['id'=>$letter_id],'draft_finalize');
        $completeStatus = Common::getSingleColumnValue('letters',['id'=>$letter_id],'stage_status');
        $forwardStatus = ActionSent::isLetterForwarded($letter_id);
        $correspondence = AcknowledgeModel::get_correspondence_details($letter_id);

        $notes = [];
        $i = 0;
        $actionDepartments = [];
        $letterActions = LetterAction::getLetterActions($letter_id);
        $i = 0;
        $responsesStatuses=[];
        $completeCount = 0;
        $actions = [];
        $actionIds = [];
        $k = 0;
        $departments = " ";
        foreach($letterActions AS $value){
            $j = 0;
            $actions[$k] = LetterAction::getDepartmentActions($letter_id,$value['action_id']);
            $actionIds[$k] = $value['action_id'];
            foreach($actions[$k] AS $value1){
                $note = LetterActionResponse::getActionLastNote($value['action_id']);
                if($note != null){
                    $notes[$i] = $note->action_remarks;
                }else{
                    $notes[$i] = '';

                }
                $actionDepartments[$i][$j] = $value1['department_name'];
                $departments .= $value1['department_name']."_";
                $responsesStatuses[$i][$j] = ActionSent::getResponseStatuses($value1['act_dept_id'],$value1['dept_id']);
                if($responsesStatuses[$i][$j] == "Completed"){
                    $completeCount += 1;
                }
                $j++;
            }
            $k++;
            $i++;
        }
        $markComplete = 0;
        if($completeCount == count(array_filter(explode("_",$departments)))){
            if($completeStatus < 4){

            $markComplete = 1;

            }
        }
        $departments = Department::getAllDepartments();
        return view('deligate.action_list',compact('actions','letterNo','letterSubject','letter_id','notes','senderName','organization','letterPath','forwardStatus','letterCrn','finalizeStatus','actionDepartments','letterActions','responsesStatuses','markComplete','departments','completeStatus','correspondence'));
    }

    public function finalizeActions(Request $request){
        if($request->ajax()){
            $jData = [];

            $validate = $request->validate([
                'finalize_letter' => 'required|numeric|min:1',
            ]);
            if(!$validate){
                $jData[1] = [
                    'message'=>'Something went wrong! Please try again.'.$e->getMessage(),
                    'status'=>'error'
                ];
                return response()->json($jData,500);
            }
            
        
            DB::beginTransaction();
    
                try {

                    $letter = $request->finalize_letter;
                    Letter::finalizeLetter($letter);
                    DB::commit();
                    $jData[1] = [
                        'message'=>'Actions are successfully finalized.',
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLetterActionRequest $request)
    {
        if($request->ajax()){
            $jData = [];
        
            DB::beginTransaction();
    
                try {

                    $departments = $request->departments;
                    $actions = $request->letter_action;
                    $letter = $request->letter;
                    $actionId = LetterAction::storeLetterAction([
                        $letter,
                        $actions,
                    ]);
                    for($i = 0; $i < count($departments); $i++){
                        
                        
                        
                        ActionDepartmentMap::storeDepartmentActions([
                            $actionId,
                            $departments[$i]
                        ]);
                    }
                    DB::commit();
                    $jData[1] = [
                        'message'=>'Letter\'s action forwarded successfully',
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
    public function show(LetterAction $letterAction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LetterAction $letterAction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLetterActionRequest $request, LetterAction $letterAction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LetterAction $letterAction)
    {
        //
    }
}
