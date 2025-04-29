<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;
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
}
