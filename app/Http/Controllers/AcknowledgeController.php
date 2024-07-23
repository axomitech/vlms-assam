<?php

namespace App\Http\Controllers;

use App\Models\AcknowledgeModel;
use Illuminate\Http\Request;

use DB;

class AcknowledgeController extends Controller
{
    public function index($id)
    {
        // $input = $request->only('letter_id');
        $letter_id = $id;
        $result = AcknowledgeModel::get_letter_details($letter_id);
        // $result = $this->AcknowledgeModel->get_letter_details($letter_id);
        $letter_no = $result->letter_no;
        $diarize_no = $result->diary_date;
        $letter_subject = $result->subject;
        $letter_path = $result->letter_path;
        $letter_date = $result->letter_date;

        $sender_details = AcknowledgeModel::get_sender_details($letter_id);
        $sender_email = $sender_details->sender_email;
        $default_ack = 'Your letter [No.- '.$letter_no.', Dated- '.$letter_date.'] has been received and duly noted.';
        $system_msg = 'This is a system-generated email, so  please do not reply to  this email address.';

        return view('acknowledge_email',compact('letter_no','sender_email','default_ack','system_msg'));
        // return view('acknowledge',compact('letter_id'));
    }
    public function ack_letter_save(Request $request)
    {
        // $input = $request->only('letter_id','ack_letter_text','');
        $validatedData = $request->validate([
            'letter_id' => 'required',
            'ack_letter_text' => 'required',
        ]);

        $letter_id = $validatedData['letter_id'];
        $ack_letter_text = $validatedData['ack_letter_text'];
        $validatedData['last_saved']=date('d-m-Y H:i:s');

        $ack_exist =AcknowledgeModel::get_acknowledge_letter_details($letter_id);
        if ($ack_exist) {
            $result =AcknowledgeModel::update_acknowledge_letter_details($validatedData);
        }
        else{
            $result =AcknowledgeModel::insertAcknowledgeLetters($validatedData);
        }
         $data = ['last_saved' => $validatedData['last_saved']];
         return response()->json($data);
    }

    public function ack_letter_generation($id)
    {
        // $input = $request->only('letter_id');
        $letter_id = $id;

        // try{        
            $result = AcknowledgeModel::get_letter_details($letter_id);
        // $result = $this->AcknowledgeModel->get_letter_details($letter_id);
            $letter_no = $result->letter_no;
            $diarize_no = $result->diary_date;
            $letter_subject = $result->subject;
            $letter_path = $result->letter_path;
            $letter_date = $result->letter_date;

            $sender_details = AcknowledgeModel::get_sender_details($letter_id);
            $sender_email = $sender_details->sender_email;
            $sender_name = $sender_details->sender_name;
            $sender_designation = $sender_details->sender_designation;
            $organization = $sender_details->organization;
            $address = $sender_details->address;
            $last_saved= 'Never';//last saved time

            $ack_exist =AcknowledgeModel::get_acknowledge_letter_details($letter_id);
            if ($ack_exist) {
                $default_ack= $ack_exist->ack_letter_text;//last saved text
                $last_saved= $ack_exist->last_saved;//last saved time
            }
            else{
                $ack_no='<div style="overflow: hidden;"><span style="float: left;">No.: CRN/ACK/2024/10</span><span style="float: right;">Dated: '.date("d/m/Y").'</span></div>';
                // $dated = '<h6 style="text-align: right;">Dated: '.date("d/m/Y").'</h6>';
                $default_subject = '<u>Acknowledgment of Receipt of Your Letter "No.- '.$letter_no.', Dated- '.$letter_date.'".</u>';
                $ref= 'Letter No.- '.$letter_no.', Dated- '.$letter_date.', subject: "'. $letter_subject.'"';
                
                $letter_body='<p>Dear Sir/Madam, <p>I am writing to confirm receipt of your letter dated "'.$letter_date.'" and letter no. "'.$letter_no
                .'". I appreciate your prompt communication on this matter.<p>Please be assured that I have reviewed the contents of your letter
                thoroughly. I will ensure to keep you updated on any developments pertaining to this matter.<p>I look forward to
                our continued correspondence.';

                $letter_bottom='<p>Thanking You.<p><p>Sincerely,<p><p>Shri XYZ, IAS/ACS<p>Government of Assam';
                
                $default_ack = $ack_no.'To,<br>'.$sender_name.'<br>'.$sender_designation.'<br>'.$organization.'<br>'.$address
                                .'<p><b>Subject: '.$default_subject.'</b><p>Ref.: '.$ref.$letter_body.$letter_bottom;

                $record = [
                    'letter_id' => $letter_id,
                    'ack_letter_text' => $default_ack,
                ];             
                $result =AcknowledgeModel::insertAcknowledgeLetters($record);
            }

            return view('acknowledge_letter',compact('letter_no','diarize_no','letter_subject','letter_path','letter_id','sender_email','default_ack',
                    'last_saved'));
        // }
        // catch(\Exception  $ex) {
        //     //  return $ex->getMessage(); 
        //     abort(404, 'User not found1 '.$ex->getMessage());
        //     }
    }

    public function store_correspondence(Request $request)
    {
        if ($request->hasFile('attachment_file')) {
                
            if ($request->file('attachment_file')->isValid()) {

                $correspondencePath = $request->attachment_file->store('public/letters/vip');

            }else{

                return 'file store error';
            }

        }else{
            return 'file hasFile error';
        }

        $correspondenceDetails = [

            'letter_id' => $request->letter_id,
            'c_title' => $request->attachment_name,
            'upload_by' => 'Test',
            'file_path' => $correspondencePath,
            'upload_date' => date("d-m-Y h:i:sa")

        ];

        $result = AcknowledgeModel::storeCorrespondence($correspondenceDetails);

        if($result){
            return 'file uploaded and insert';
        }else{
            return 'insert error';
        }
        
    }
}
