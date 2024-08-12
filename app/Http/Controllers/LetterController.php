<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLetterRequest;
use App\Http\Requests\UpdateLetterRequest;
use App\Http\Requests\StageLetterRequest;
use App\Models\Letter;
use App\Models\Sender;
use App\Models\ActionSent;
use App\Models\Department;
use App\Models\LetterPriority;
use App\Models\LetterCategory;
use App\Models\Common;
use Carbon\Carbon;
use Auth;
use DB;

class LetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($receipt)
    {   $receipt = decrypt($receipt);
        $priorities = LetterPriority::getAllPriorities();
        $letterCategories = LetterCategory::getAllLetterCategories();
        return view('diarize.diarize',compact('priorities','letterCategories','receipt'));
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
    public function store(StoreLetterRequest $request)
    {
        if($request->ajax()){
            $jData = [];
            $letterPath = "";
            if ($request->hasFile('letter')) {
                
                if ($request->file('letter')->isValid()) {

                    $letterPath = $request->letter->store('public/letters');

                }else{

                    $jData[1] = [
                        'message'=>'The letter upload was unsuccessful! Please try again.',
                        'candidate'=>'',
                        'status'=>'error'
                    ];
                }

            }else{

                $jData[1] = [
                    'message'=>'The uploaded letter is absent! Please try again.',
                    'candidate'=>'',
                    'status'=>'error'
                ];
            }
            DB::beginTransaction();
    
                try {

                    $letterDetails = [

                        $request->category,
                        $request->priority,
                        $request->letter_date,
                        $request->received_date,
                        $request->diary_date,
                        $request->letter_no,
                        $request->subject,
                        $letterPath,
                        $request->auto_ack,
                        $request->receipt,
                    ];

                    $letterId = Letter::storeLetter($letterDetails);
                    $abbreviation = Department::getDepartmentAbbreviation(session('role_dept'));
                    $year = Carbon::now()->year;
                    $crn = [
                        $letterId,
                        "CRN/".$abbreviation."/".$year."/".$letterId
                    ];
                    Letter::generateLetterCrn($crn);
                    $senderDetails = [

                        $letterId,
                        $request->sender_name,
                        $request->sender_designation,
                        $request->sender_mobile,
                        $request->sender_email,
                        $request->organization,
                        $request->address

                    ];
                    Sender::storeSender($senderDetails);
                    DB::commit();
                    $jData[1] = [
                        'message'=>'Letter is successfully diarized.',
                        'status'=>'success',
                        'letter_id'=>$letterId,
                        'ack_check'=>$request->auto_ack
                    ];

                    session()->flash('letter_id', $letterId);
                    session()->flash('ack_check', $request->auto_ack);
                    
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

    public function changeLetterStage(StageLetterRequest $request)
    {
        if($request->ajax()){
            $jData = [];
            $message = "";
            if($request->stage == 4){
                $message = "Letter is successfully marked completed!";
            }

            if($request->stage == 5){
                $message = "Letter is successfully archived!";
            }
            DB::beginTransaction();
    
                try {

                    Letter::changeLetterStage($request->stage_letter,$request->stage);
                   
                    DB::commit();
                    $jData[1] = [
                        'message'=>$message,
                        'status'=>'success',
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


    public function showLetters()
    {
        $letters = Letter::showLetterAndSender([
            'user_departments.department_id'=>session('role_dept'),
        ],[]);
       
        $actionSents = ActionSent::getForwardedActions();
        $letterIds = [];
        $i = 0;
        foreach($actionSents AS $value){
            $letterIds[$i] = $value['letter_id'];
            $i++;
        }
        $sentLetters = Letter::showLetterAndSender([
            'user_departments.department_id'=>session('role_dept')
        ],$letterIds);
        $receiverId = Common::getSingleColumnValue('user_departments',[
            'department_id'=>session('role_dept'),
            'user_id'=>Auth::user()->id,
            'role_id'=>session('role')
        ],'id');

        $inboxLetters = Letter::showInboxLetters([
            'action_sents.receiver_id'=>$receiverId,
        ]);
        $archivedLetters = Letter::showLetterAndSender([
            'user_departments.department_id'=>session('role_dept'),
            'stage_status'=>5
        ],[]);
        return view('diarize.letters',compact('letters','sentLetters','inboxLetters','archivedLetters'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Letter $letter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Letter $letter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLetterRequest $request, Letter $letter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Letter $letter)
    {
        //
    }
}
