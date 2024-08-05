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
        if(!empty($inputData['letter_no']) && !empty($inputData['diarized_no']) && !empty($inputData['received_from']) && !empty($inputData['received_to'])
                 && !empty($inputData['category'])){

            return DB::table('letters')
            ->join('senders','letters.id','=','senders.letter_id')
            ->join('letter_categories','letters.letter_category_id','=','letter_categories.id')
            ->where(DB::raw('lower(letter_no)'),'like','%'.strtolower($inputData['letter_no']).'%')
            ->where(DB::raw('lower(crn)'),'like','%'.strtolower($inputData['diarized_no']).'%')
            ->where('letter_category_id','=',$inputData['category'])
            ->whereBetween('received_date',[$inputData['received_from'],$inputData['received_to']])
            ->orderBy('letters.id', 'desc') 
            ->select('letters.*', 'senders.sender_name','senders.sender_designation','senders.sender_organization','letter_categories.category_name',)
            ->get();
        }
        if(!empty($inputData['letter_no']) && !empty($inputData['diarized_no']) && !empty($inputData['received_from']) && !empty($inputData['received_to'])){
            return DB::table('letters')
            ->join('senders','letters.id','=','senders.letter_id')
            ->join('letter_categories','letters.letter_category_id','=','letter_categories.id')
            ->where(DB::raw('lower(letter_no)'),'like','%'.strtolower($inputData['letter_no']).'%')
            ->where(DB::raw('lower(crn)'),'like','%'.strtolower($inputData['diarized_no']).'%')
            ->whereBetween('received_date',[$inputData['received_from'],$inputData['received_to']])
            ->select('letters.*', 'senders.sender_name','senders.sender_designation','senders.organization','letter_categories.category_name')
            ->get();
        }
        if(!empty($inputData['letter_no']) && !empty($inputData['diarized_no']) && !empty($inputData['category'])){
            return DB::table('letters')
            ->join('senders','letters.id','=','senders.letter_id')
            ->join('letter_categories','letters.letter_category_id','=','letter_categories.id')
            ->where(DB::raw('lower(letter_no)'),'like','%'.strtolower($inputData['letter_no']).'%')
            ->where(DB::raw('lower(crn)'),'like','%'.strtolower($inputData['diarized_no']).'%')
            ->where('letter_category_id','=',$inputData['category'])
            ->select('letters.*', 'senders.sender_name','senders.sender_designation','senders.organization','letter_categories.category_name')
            ->get();
        }
        if(!empty($inputData['letter_no']) && !empty($inputData['received_from']) && !empty($inputData['received_to']) && !empty($inputData['category'])){
            return DB::table('letters')
            ->join('senders','letters.id','=','senders.letter_id')
            ->join('letter_categories','letters.letter_category_id','=','letter_categories.id')
            ->where(DB::raw('lower(letter_no)'),'like','%'.strtolower($inputData['letter_no']).'%')
            ->whereBetween('received_date',[$inputData['received_from'],$inputData['received_to']])
            ->where('letter_category_id','=',$inputData['category'])
            ->select('letters.*', 'senders.sender_name','senders.sender_designation','senders.organization','letter_categories.category_name')
            ->get();
        }
        if(!empty($inputData['diarized_no']) && !empty($inputData['received_from']) && !empty($inputData['received_to']) && !empty($inputData['category'])){
            return DB::table('letters')
            ->join('senders','letters.id','=','senders.letter_id')
            ->join('letter_categories','letters.letter_category_id','=','letter_categories.id')
            ->where(DB::raw('lower(crn)'),'like','%'.strtolower($inputData['diarized_no']).'%')
            ->whereBetween('received_date',[$inputData['received_from'],$inputData['received_to']])
            ->where('letter_category_id','=',$inputData['category'])
            ->select('letters.*', 'senders.sender_name','senders.sender_designation','senders.organization','letter_categories.category_name')
            ->get();
        }
        
        if(!empty($inputData['diarized_no']) && !empty($inputData['category'])){
            return DB::table('letters')
            ->join('senders','letters.id','=','senders.letter_id')
            ->join('letter_categories','letters.letter_category_id','=','letter_categories.id')
            ->where(DB::raw('lower(crn)'),'like','%'.strtolower($inputData['diarized_no']).'%')
            ->where('letter_category_id','=',$inputData['category'])
            ->select('letters.*', 'senders.sender_name','senders.sender_designation','senders.organization','letter_categories.category_name')
            ->get();
        }
        if(!empty($inputData['diarized_no']) && !empty($inputData['letter_no'])){
            return DB::table('letters')
            ->join('senders','letters.id','=','senders.letter_id')
            ->join('letter_categories','letters.letter_category_id','=','letter_categories.id')
            ->where(DB::raw('lower(crn)'),'like','%'.strtolower($inputData['diarized_no']).'%')
            ->where(DB::raw('lower(letter_no)'),'like','%'.strtolower($inputData['letter_no']).'%')
            ->select('letters.*', 'senders.sender_name','senders.sender_designation','senders.organization','letter_categories.category_name')
            ->get();
        }
        
        if(!empty($inputData['received_from']) && !empty($inputData['received_to']) && !empty($inputData['category'])){
            return DB::table('letters')
            ->join('senders','letters.id','=','senders.letter_id')
            ->join('letter_categories','letters.letter_category_id','=','letter_categories.id')
            ->whereBetween('received_date',[$inputData['received_from'],$inputData['received_to']])
            ->where('letter_category_id','=',$inputData['category'])
            ->select('letters.*', 'senders.sender_name','senders.sender_designation','senders.organization','letter_categories.category_name')
            ->get();
        }
        if(!empty($inputData['received_from']) && !empty($inputData['received_to']) && !empty($inputData['letter_no'])){
            return DB::table('letters')
            ->join('senders','letters.id','=','senders.letter_id')
            ->join('letter_categories','letters.letter_category_id','=','letter_categories.id')
            ->whereBetween('received_date',[$inputData['received_from'],$inputData['received_to']])
            ->where(DB::raw('lower(letter_no)'),'like','%'.strtolower($inputData['letter_no']).'%')
            ->select('letters.*', 'senders.sender_name','senders.sender_designation','senders.organization','letter_categories.category_name')
            ->get();
        }
        if(!empty($inputData['received_from']) && !empty($inputData['received_to']) && !empty($inputData['diarized_no'])){
            return DB::table('letters')
            ->join('senders','letters.id','=','senders.letter_id')
            ->join('letter_categories','letters.letter_category_id','=','letter_categories.id')
            ->whereBetween('received_date',[$inputData['received_from'],$inputData['received_to']])
            ->where(DB::raw('lower(crn)'),'like','%'.strtolower($inputData['diarized_no']).'%')
            ->select('letters.*', 'senders.sender_name','senders.sender_designation','senders.organization','letter_categories.category_name')
            ->get();
        }
        
        if(!empty($inputData['letter_no']) && !empty($inputData['category'])){
            return DB::table('letters')
            ->join('senders','letters.id','=','senders.letter_id')
            ->join('letter_categories','letters.letter_category_id','=','letter_categories.id')
            ->where(DB::raw('lower(letter_no)'),'like','%'.strtolower($inputData['letter_no']).'%')
            ->where('letter_category_id','=',$inputData['category'])
            ->select('letters.*', 'senders.sender_name','senders.sender_designation','senders.organization','letter_categories.category_name')
            ->get();
        }
        if(!empty($inputData['letter_no'])){
            return DB::table('letters')
            ->join('senders','letters.id','=','senders.letter_id')
            ->join('letter_categories','letters.letter_category_id','=','letter_categories.id')
            ->where(DB::raw('lower(letter_no)'),'like','%'.strtolower($inputData['letter_no']).'%')
            ->select('letters.*', 'senders.sender_name','senders.sender_designation','senders.organization','letter_categories.category_name')
            ->get();
        }
        if(!empty($inputData['category'])){
            return DB::table('letters')
            ->join('senders','letters.id','=','senders.letter_id')
            ->join('letter_categories','letters.letter_category_id','=','letter_categories.id')
            ->where('letter_category_id','=',$inputData['category'])
            ->select('letters.*', 'senders.sender_name','senders.sender_designation','senders.organization','letter_categories.category_name')
            ->get();
        }
        if(!empty($inputData['diarized_no'])){
            return DB::table('letters')
            ->join('senders','letters.id','=','senders.letter_id')
            ->join('letter_categories','letters.letter_category_id','=','letter_categories.id')
            ->where(DB::raw('lower(crn)'),'like','%'.strtolower($inputData['diarized_no']).'%')
            ->select('letters.*', 'senders.sender_name','senders.sender_designation','senders.organization','letter_categories.category_name')
            ->get();
        }
        if(!empty($inputData['received_from']) && !empty($inputData['received_to'])){
            return DB::table('letters')
            ->join('senders','letters.id','=','senders.letter_id')
            ->join('letter_categories','letters.letter_category_id','=','letter_categories.id')
            ->whereBetween('received_date',[$inputData['received_from'],$inputData['received_to']])
            ->select('letters.*', 'senders.sender_name','senders.sender_designation','senders.organization','letter_categories.category_name')
            ->get();
        }      
        else{
            return DB::table('letters')
            ->join('senders','letters.id','=','senders.letter_id')
            ->join('letter_categories','letters.letter_category_id','=','letter_categories.id')
            ->select('letters.*', 'senders.sender_name','senders.sender_designation','senders.organization','letter_categories.category_name')
            ->get();
        }
        
    }

    public static function get_all_letter_categories()
    {
        return DB::table('letter_categories')
            ->get();
    }
}
