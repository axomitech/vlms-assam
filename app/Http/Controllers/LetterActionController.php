<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreLetterActionRequest;
use App\Http\Requests\UpdateLetterActionRequest;
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
        $letterNo = Common::getSingleColumnValue('letters','id',$letter_id,'letter_no');
        $letterSubject = Common::getSingleColumnValue('letters','id',$letter_id,'subject');
        $senderName = Common::getSingleColumnValue('senders','letter_id',$letter_id,'sender_name');
        $organization = Common::getSingleColumnValue('senders','letter_id',$letter_id,'organization');
        $letterPath = Common::getSingleColumnValue('letters','id',$letter_id,'letter_path');
        $letterCrn = Common::getSingleColumnValue('letters','id',$letter_id,'crn');
        $finalizeStatus = Common::getSingleColumnValue('letters','id',$letter_id,'finalize_status');
        $actions = LetterAction::getDepartmentActions($letter_id);
        $forwardStatus = ActionSent::isLetterForwarded($letter_id);
        $notes = [];
        $i = 0;
        foreach($actions AS $value){
            $note = LetterActionResponse::getActionLastNote($value['action_id']);
            if($note != null){
                $notes[$i] = $note->action_remarks;
            }else{
                $notes[$i] = '';

            }
            $i++;
        }
        return view('deligate.actions',compact('actions','letterNo','letterSubject','letter_id','notes','senderName','organization','letterPath','forwardStatus','letterCrn','finalizeStatus'));
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
        $letter_id = decrypt($id);
        $letterNo = Common::getSingleColumnValue('letters','id',$letter_id,'letter_no');
        $letterSubject = Common::getSingleColumnValue('letters','id',$letter_id,'subject');
        $senderName = Common::getSingleColumnValue('senders','letter_id',$letter_id,'sender_name');
        $organization = Common::getSingleColumnValue('senders','letter_id',$letter_id,'organization');
        $letterPath = Common::getSingleColumnValue('letters','id',$letter_id,'letter_path');
        $letterCrn = Common::getSingleColumnValue('letters','id',$letter_id,'crn');
        $finalizeStatus = Common::getSingleColumnValue('letters','id',$letter_id,'finalize_status');
        $forwardStatus = ActionSent::isLetterForwarded($letter_id);
        $departments = Department::getAllDepartments();
        $actions = LetterAction::getDepartmentActions($letter_id);
        
        return view('deligate.action_list',compact('actions','letterNo','letterSubject','letter_id','senderName','organization','departments','letterPath','letterCrn','finalizeStatus'));
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
                    for($i = 0; $i < count($departments); $i++){
                        
                        $actionId = LetterAction::storeLetterAction([
                            $letter,
                            $actions,
                        ]);
                        
                        ActionDepartmentMap::storeDepartmentActions([
                            $actionId,
                            $departments[$i]
                        ]);
                    }
                    DB::commit();
                    $jData[1] = [
                        'message'=>'Letter\'s action is successfully stored.',
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
