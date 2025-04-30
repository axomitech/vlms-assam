<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;
    protected $table = "letter_references";
    public static function storeReferences($references){
        $reference = new Reference;
        $reference->refer_letter_id = $references[0];
        $reference->reference_letter_id = $references[1];
        $reference->save();
        return $reference->id;
    }

    public static function checkReferenceExist($references){
        return Reference::Where([
            'refer_letter_id'=> $references[0],
            'reference_letter_id'=> $references[1]
        ])->count();
    }

    public static function getReference($letter){
        return Reference::Where([
            'refer_letter_id'=> $letter
        ])->join('letters','letters.id','=','letter_references.reference_letter_id')
        ->select('letter_no','letter_path','reference_letter_id')
        ->get();
    }
}
