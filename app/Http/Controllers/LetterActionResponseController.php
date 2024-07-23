<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLetterActionResponseRequest;
use App\Http\Requests\UpdateLetterActionResponseRequest;
use App\Http\Requests\ActionResponseRequest;
use App\Models\LetterActionResponse;
use App\Models\LetterResponseAttachment;
use App\Models\ActionDepartmentMap;
use App\Models\ActionSent;
use Carbon\Carbon;

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

                $actions = $request->letter_action;
                try {

                    for($i = 0; $i < count($actions); $i++){
                        
                        $noteDetails = [

                            ActionDepartmentMap::getActionDepartment([
                                $actions[$i]
                            ]),
    
                            $request->note
    
                        ];
                        
                    $noteId = LetterActionResponse::storeNote($noteDetails);
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
            ];
            $i = 1;
            $notes = LetterActionResponse::getAllActionNotes($request->action);
            foreach($notes AS $value){
                $jdata[$i] = [
                    'note'=>$value['action_remarks'],
                    'date_day'=>Carbon::parse($value['created_at'])->format('d/m/Y'),
                    'date_time'=>Carbon::parse($value['created_at'])->format('H:m:s'),
                    'name'=>$value['name'],
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
            if ($request->hasFile('action_response')) {
                $responsePath = "";
                if ($request->file('action_response')->isValid()) {

                    $responsePath = $request->action_response->store('public/action_response/');

                }else{

                    $jData[1] = [
                        'message'=>'The letter upload was unsuccessful! Please try again.',
                        'status'=>'error'
                    ];
                }

            }else{

                $jData[1] = [
                    'message'=>'The uploaded letter is absent! Please try again.',
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
                        $note
                    ]);
                    
                    $attachmentId = LetterResponseAttachment::storeAttachment([
                        $noteId,
                        $responsePath
                    ]);
                    ActionSent::updateActionStatus($actionsentId,$actionStatus);
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
