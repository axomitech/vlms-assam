<?php

namespace App\Models;

use App\Traits\DbConstants;
use App\Traits\GlobalHelper;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AcknowledgeModel extends Model
{
    use HasFactory;

    public function insert_parichay_temp($record)
    {
        // $data = [
        //     'key1' => 'Value1',
        //     'key2' => 'Value2',
        // ];

        $affected = DB::table('parichay_temp')->insert($record);

        return $affected;
    }
    public static function insertAcknowledgeLetters($record)
    {

        $affected = DB::table('acknowledge_letters')->insert($record);

        return $affected;
    }
    public static function storeCorrespondence($record)
    {

        $affected = DB::table('correspondence')->insert($record);

        return $affected;
    }

    public static function get_acknowledge_letter_details($letter_id)
    {
        return DB::table('acknowledge_letters')
            ->select('ack_id', 'letter_id', 'ack_letter_text', 'saved_by','last_saved')
            ->where('letter_id', '=', $letter_id)
            ->first();
    }
    public static function get_correspondence_details($letter_id)
    {
        return DB::table('correspondence')
            // ->select('ack_id', 'letter_id', 'ack_letter_text', 'saved_by','last_saved')
            ->where('letter_id', '=', $letter_id)
            ->where('removed','!=', true)
            ->orderBy('upload_date', 'asc')
            ->get();
    }
    public static function removeCorrespondence($correspondence_id)
    {
        return DB::table('correspondence')
                ->where('c_id', $correspondence_id)
                ->update(['removed' => 1]);
    }
    public static function update_acknowledge_letter_details($record)
    {
        return DB::table('acknowledge_letters')
                ->where('letter_id', $record['letter_id'])
                ->update(['ack_letter_text' => $record['ack_letter_text'],
                        'last_saved' => $record['last_saved']]);
    }
    public static function get_letter_details($letter_id)
    {
        return DB::table('letters')
            // ->select('letter_no', 'subject', 'letter_path', 'diary_date','letter_date')
            ->where('id', '=', $letter_id)
            ->first();
    }
    public static function get_sender_details($letter_id)
    {
        return DB::table('senders')
            ->select('sender_email','sender_name','sender_designation', 'organization', 'address')
            ->where('letter_id', '=', $letter_id)
            ->first();
    }
    public static function get_action_details($letter_id)
    {
        return DB::table('letter_actions')
            ->select('letter_id','action_description','created_at')
            ->where('letter_id', '=', $letter_id)
            ->get();
    }
    function delete_parichay_temp($state_code)
    {
        return DB::table('parichay_temp')->where('state_code', '=', $state_code)->delete();
    }
}
