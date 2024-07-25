<?php

namespace App\Models;

use App\Traits\DbConstants;
use App\Traits\GlobalHelper;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SearchModel extends Model
{
    use HasFactory;
    public static function get_letter_search($inputData)
    {
        // return DB::select("SELECT * FROM letters WHERE letter_no='".$letter_id."' or crn='".$diarized_no."' or received_date>='".$received_from."' and received_date<='".$received_to."'");
        if(!empty($inputData['letter_no']) && !empty($inputData['diarized_no']) && !empty($inputData['received_from']) && !empty($inputData['received_to'])){
            return DB::table('letters')
            ->where(DB::raw('lower(letter_no)'),'like','%'.$inputData['letter_no'].'%')
            ->where(DB::raw('lower(crn)'),'like','%'.$inputData['diarized_no'].'%')
            ->whereBetween('received_date',[$inputData['received_from'],$inputData['received_to']])
            ->get();
        }
        if(!empty($inputData['letter_no']) && !empty($inputData['diarized_no'])){
            return DB::table('letters')
            ->where(DB::raw('lower(letter_no)'),'like','%'.$inputData['letter_no'].'%')
            ->where(DB::raw('lower(crn)'),'like','%'.$inputData['diarized_no'].'%')
            ->get();
        }
        if(!empty($inputData['letter_no']) && !empty($inputData['received_from']) && !empty($inputData['received_to'])){
            return DB::table('letters')
            ->where('letter_no','like','%'.$inputData['letter_no'].'%')
            ->whereBetween('received_date',[$inputData['received_from'],$inputData['received_to']])
            ->get();
        }
        if(!empty($inputData['diarized_no']) && !empty($inputData['received_from']) && !empty($inputData['received_to'])){
            return DB::table('letters')
            ->where('crn','like','%'.$inputData['diarized_no'].'%')
            ->whereBetween('received_date',[$inputData['received_from'],$inputData['received_to']])
            ->get();
        }
        
        if(!empty($inputData['diarized_no'])){
            return DB::table('letters')
            ->where(DB::raw('lower(crn)'),'like','%'.strtolower($inputData['diarized_no']).'%')
            ->get();
        }
        
        if(!empty($inputData['received_from']) && !empty($inputData['received_to'])){
            return DB::table('letters')
            ->whereBetween('received_date',[$inputData['received_from'],$inputData['received_to']])
            ->get();
        }
        
        if(!empty($inputData['letter_no'])){
            return DB::table('letters')
            ->where('letter_no','like','%'.$inputData['letter_no'].'%')
            ->get();
        }else{
            return DB::table('letters')
            ->get();
        }
        
    }
}
