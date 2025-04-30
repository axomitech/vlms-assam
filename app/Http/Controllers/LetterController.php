<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLetterRequest;
use App\Http\Requests\UpdateLetterRequest;
use App\Http\Requests\StageLetterRequest;
use App\Models\Letter;
use App\Models\Sender;
use App\Models\ActionSent;
use App\Models\Department;
use App\Models\UserDepartment;
use App\Models\LetterPriority;
use App\Models\LetterAssign;
use App\Models\LetterCategory;
use App\Models\AssignDeligate;
use App\Models\Common;
use App\Models\Recipient;
use Carbon\Carbon;
use Auth;
use DB;

class LetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($receipt,$legacy)
    {
        $receipt = decrypt($receipt);
        $legacy = decrypt($legacy);
        $priorities = LetterPriority::getAllPriorities();
        $letterCategories = LetterCategory::getAllLetterCategories();
        return view('diarize.diarize', compact('priorities', 'letterCategories', 'receipt','legacy'));
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
        if ($request->ajax()) {
            $jData = [];
            $letterPath = "";
            if ($request->hasFile('letter')) {

                if ($request->file('letter')->isValid()) {

                    $letterPath = $request->letter->store('public/letters');
                } else {

                    $jData[1] = [
                        'message' => 'The letter upload was unsuccessful! Please try again.',
                        'candidate' => '',
                        'status' => 'error'
                    ];
                }
            } else {

                $jData[1] = [
                    'message' => 'The uploaded letter is absent! Please try again.',
                    'candidate' => '',
                    'status' => 'error'
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
                    $request->sub_category,
                    $request->legacy,
                    $request->other_sub_category,
                    $request->ecr_no
                ];

                $letterId = Letter::storeLetter($letterDetails);
                $abbreviation = Department::getDepartmentAbbreviation(session('role_dept'));
                $year = Carbon::now()->year;
                $crn = [
                    $letterId,
                    "CRN/" . $abbreviation . "/" . $year . "/" . $letterId
                ];
                Letter::generateLetterCrn($crn);
                if ($request->receipt == 1) {
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
                } else {
                    $recipientDetails = [
                        $letterId,
                        $request->recipient_name,
                        $request->recipient_designation,
                        $request->recipient_mobile,
                        $request->recipient_email,
                        $request->organization,
                        $request->address
                    ];
                    Recipient::storeRecipient($recipientDetails);
                }
                DB::commit();
                $jData[1] = [
                    'message' => 'Letter is successfully diarized.',
                    'status' => 'success',
                    'letter_id' => $letterId,
                    'ack_check' => $request->auto_ack
                ];

                session()->flash('letter_id', $letterId);
                session()->flash('ack_check', $request->auto_ack);
            } catch (\Exception $e) {
                DB::rollback();
                $jData[1] = [
                    'message' => 'Something went wrong! Please try again.' . $e->getMessage(),
                    'candidate' => '',
                    'status' => 'error'
                ];
            }

            return response()->json($jData, 200);
        }
    }

    public function changeLetterStage(StageLetterRequest $request)
    {
        if ($request->ajax()) {
            $jData = [];
            $message = "";
            if ($request->stage == 4) {
                $message = "Letter is successfully marked completed!";
            }

            if ($request->stage == 5) {
                $message = "Letter is successfully archived!";
            }
            DB::beginTransaction();

            try {

                Letter::changeLetterStage($request->stage_letter, $request->stage);

                DB::commit();
                $jData[1] = [
                    'message' => $message,
                    'status' => 'success',
                ];
            } catch (\Exception $e) {
                DB::rollback();
                $jData[1] = [
                    'message' => 'Something went wrong! Please try again.' . $e->getMessage(),
                    'candidate' => '',
                    'status' => 'error'
                ];
            }

            return response()->json($jData, 200);
        }
    }


    public function showLetters($legacy)
    {  
        $legacy = decrypt($legacy);
        $legacyStatus = false;
        if($legacy == 1){
            $legacyStatus = true;
        }
        $letters = Letter::showLetterAndSender([
            'user_departments.department_id'=>session('role_dept'),
            'stage_status'=>1,
            'legacy'=>$legacyStatus
        ],[]);
        $assignedLetters = [];
        $assignedSentLetters = [];
        $delegatgeLetters = [];
        $i = 0;
        $condition = [];
        $hod = Common::getSingleColumnValue('assign_deligates',[
            'deligate_id'=>session('role_user')
        ],'hod_id');
        $assignedByDeligate = [];
        foreach($letters AS $value){
            if(session('role') == 1){
                $condition = [
                    'letter_id'=>$value['letter_id'],
                    'user_id'=>session('role_user')
                ];
            }else if(session('role') == 3){
                $condition = [
                    'letter_id'=>$value['letter_id'],
                    'receiver_id'=>session('role_user'),
                    'in_hand'=> true,
                ];
            }else if(session('role') == 2){
                $assignCount = LetterAssign::checkLetterAssign($value['letter_id']);
                if($assignCount > 0){
                    $assignedByDeligate[$i] = $value['letter_id'];
                }
                $condition = [
                    'letter_id'=>$value['letter_id'],
                    // 'receiver_id'=>Common::getSingleColumnValue('assign_deligates',[
                    //     'deligate_id'=>session('role_user')
                    // ],'hod_id'),
                    'receiver_id'=>session('role_user'),
                    'in_hand'=> true,
                ];
            }
            //$assignedLetters[$i] = LetterAssign::checkLetterAssign($value['letter_id']);
            $assignedLetters[$i] = Common::getSingleColumnValue('letter_assigns',$condition,'id');
            $assignedLetters[$i] = Common::getSingleColumnValue('letter_assigns',$condition,'id');
            $delegatgeLetters[$i] = AssignDeligate::hodDeligateForLetter($value['letter_id']);
            $i++;
        }
        $actionSents = ActionSent::getForwardedActions();
        $letterIds = [];
        $i = 0;
        foreach ($actionSents as $value) {
            $letterIds[$i] = $value['letter_id'];
            $condition = [
                'letter_id'=>$value['letter_id'],
                'receiver_id'=>session('role_user'),
                'in_hand'=> true,
            ];
            $assignedSentLetters[$i] = Common::getSingleColumnValue('letter_assigns',$condition,'id');
            
            $i++;
        }
        $sentLetters = Letter::showLetterAndSender([
           ['user_departments.department_id','=',session('role_dept')],
            ['stage_status','>=',3]
        ],$letterIds);
        
        $receiverId = Common::getSingleColumnValue('user_departments',[
            'department_id'=>session('role_dept'),
            'user_id'=>Auth::user()->id,
            'role_id'=>session('role')
        ],'id');
        $deligateId = Common::getSingleColumnValue('assign_deligates',[
            'hod_id'=>session('role_user')
        ],'deligate_id');
        $inboxLetters = Letter::showInboxLetters([
            'action_sents.receiver_id' => session('role_user'),
        ],$assignedLetters);
        
        $completedLetters = Letter::showLetterAndSender([
            'user_departments.department_id'=>session('role_dept'),
            'stage_status'=>4
        ],[]);
        $actionTakenLetters = Letter::actionTakenLetters(['action_status_id','>',1]);
        $actionLetters = Letter::showLetterAndSender([
            
        ],$actionTakenLetters);
        $archivedLetters = Letter::showLetterAndSender([
            'user_departments.department_id'=>session('role_dept'),
            'stage_status'=>5
        ],[]);
        $inProcess = Letter::actionTakenLetters(['action_status_id','=',2]);
        $inProcessLetters = Letter::showLetterAndSender([
            
        ],$inProcess);
        $completed = Letter::actionTakenLetters(['action_status_id','=',3]);
        $deptCompletedLetters = Letter::showLetterAndSender([
            
        ],$completed);
        $archivedLetters = Letter::showLetterAndSender([
            'user_departments.department_id'=>session('role_dept'),
            'stage_status'=>5
        ],[]);
        if(session('role') == 1 ){
            $departmentUsers = UserDepartment::getFirstReceiverDepartment(session('role_dept'));
        }else{
            $departmentUsers = UserDepartment::getAllUserDepartment(session('role_dept'),3);

        }
        
        $deligateAssignedLetters = Letter::showLetterAndSender([
            ['user_departments.department_id','=',session('role_dept')]
        ]
            ,$assignedByDeligate);
    $letterNos = Letter::getAllLetterNo();  
       if($legacy <= 0){
           return view('diarize.letters',compact('letters','sentLetters','inboxLetters','archivedLetters','completedLetters','actionLetters','departmentUsers','assignedLetters','deligateId','delegatgeLetters','assignedSentLetters','legacy','inProcessLetters','deptCompletedLetters','hod','deligateAssignedLetters','letterNos'));


        }else{
            
        return view('diarize.legacy_letters',compact('letters','sentLetters','inboxLetters','archivedLetters','completedLetters','actionLetters','departmentUsers','assignedLetters','deligateId','delegatgeLetters','assignedSentLetters','legacy','deligateAssignedLetters','letterNos'));

        }
    }

   public function editDiarized($letterId){
        $letterId = decrypt($letterId);
        $letters = Letter::showLetterAndSender([
            'letters.id'=>$letterId
        ],[]);
        $letterData = [];
        foreach($letters AS $value){
            $letterData['letter_no'] = $value['letter_no'];
            $letterData['letter_date'] = $value['letter_date'];
            $letterData['receipt'] = $value['receipt'];
            $letterData['subject'] = $value['subject'];
            $letterData['recipient_name'] = $value['recipient_name'];
            $letterData['recipient_designation'] = $value['recipient_designation'];
            $letterData['recipient_phone'] = $value['recipient_phone'];
            $letterData['recipient_email'] = $value['recipient_email'];
            $letterData['recipient_address'] = $value['recipient_address'];
            $letterData['sender_name'] = $value['sender_name'];
            $letterData['sender_phone'] = $value['sender_phone'];
            $letterData['sender_email'] = $value['sender_email'];
            $letterData['address'] = $value['address'];
            $letterData['sender_designation'] = $value['sender_designation'];
            $letterData['organization'] = $value['organization'];
            $letterData['letter_id'] = $value['letter_id'];
            $letterData['recipient_organization'] = $value['recipient_organization'];
            $letterData['sender_organization'] = $value['sender_organization'];
            $letterData['stage_status'] = $value['stage_status'];
            $letterData['diary_date'] = $value['diary_date'];
            $letterData['received_date'] = $value['received_date'];
            $letterData['letter_category_id'] = $value['letter_category_id'];
            $letterData['letter_sub_category_id'] = $value['letter_sub_category_id'];
            $letterData['legacy'] = $value['legacy'];
            $letterData['letter_priority_id'] = $value['letter_priority_id'];
            $letterData['letter_path'] = $value['letter_path'];
            $letterData['other_sub_category'] = $value['letter_other_sub_categories'];
            $letterData['issue_date'] = $value['issue_date'];
            $letterData['ecr_no'] = $value['ecr_no'];
        }
        $priorities = LetterPriority::getAllPriorities();
        $letterCategories = LetterCategory::getAllLetterCategories();
        return view('diarize.edit_diarize', compact('priorities', 'letterCategories', 'letterData'));
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
        if ($request->ajax()) {
            $jData = [];
            $letterPath = "";
            if ($request->hasFile('letter')) {

                if ($request->file('letter')->isValid()) {

                    $letterPath = $request->letter->store('public/letters');
                } else {

                    $jData[1] = [
                        'message' => 'The letter upload was unsuccessful! Please try again.',
                        'candidate' => '',
                        'status' => 'error'
                    ];
                }
            } else {

                $letterPath = Common::getSingleColumnValue('letters',[
                    'id'=>$letter->id
                ],'letter_path');
            }
            DB::beginTransaction();

            try {
                $crn = Common::getSingleColumnValue('letters',[
                    'id'=>$letter->id
                ],'crn');
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
                    $request->sub_category,
                    $request->legacy,
                    $crn,
                    $request->other_sub_category,
                    $request->ecr_no
                ];

                Letter::updateLetter($letterDetails,$letter);
                $abbreviation = Department::getDepartmentAbbreviation(session('role_dept'));
                $year = Carbon::now()->year;
                
                if ($request->receipt == 1) {
                    $senderDetails = [

                        $letter->id,
                        $request->sender_name,
                        $request->sender_designation,
                        $request->sender_mobile,
                        $request->sender_email,
                        $request->organization,
                        $request->address

                    ];
                    Sender::updateSender($senderDetails);
                } else {
                    $recipientDetails = [
                        $letter->id,
                        $request->recipient_name,
                        $request->recipient_designation,
                        $request->recipient_mobile,
                        $request->recipient_email,
                        $request->organization,
                        $request->address
                    ];
                    Recipient::updateRecipient($recipientDetails);
                }
                DB::commit();
                $jData[1] = [
                    'message' => 'Letter is successfully diarized.',
                    'status' => 'success',
                    'letter_id' => $letter->id,
                    'ack_check' => $request->auto_ack
                ];

                session()->flash('letter_id', $letter->id);
                session()->flash('ack_check', $request->auto_ack);
            } catch (\Exception $e) {
                DB::rollback();
                $jData[1] = [
                    'message' => 'Something went wrong! Please try again.' . $e->getMessage(),
                    'candidate' => '',
                    'status' => 'error'
                ];
            }

            return response()->json($jData, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Letter $letter)
    {
        //
    }
}
