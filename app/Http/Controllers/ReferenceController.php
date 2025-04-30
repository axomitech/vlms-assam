<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReferenceRequest;
use App\Http\Requests\UpdateReferenceRequest;
use App\Models\Reference;
use App\Models\Common;
use Illuminate\Http\Request;
use DB;
class ReferenceController extends Controller
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
    public function store(StoreReferenceRequest $request)
    {
        $jData = [];
        if($request->ajax()){
            
        
            DB::beginTransaction();
    
                try {

                    $refers = $request->refer_letters;
                    $letter = $request->assign_letter;
                    $references = [];
                    for($i = 0; $i < count($refers); $i++){
                        
                        
                        $letterId =  Common::getSingleColumnValue('letters',[
                            'letter_no'=>$refers[$i]
                        ],'id');
                        $referenceCount = Reference::checkReferenceExist([
                            $letter,
                            $letterId
                        ]);
                        // echo $referenceCount;
                        // die();
                        if($referenceCount <= 0){

                            $references[$i] = Reference::storeReferences([
                                $letter,
                                $letterId
                            ]);
                        }
                    }
                    DB::commit();
                    $jData[1] = [
                        'message'=>'Letter is refered successfully.',
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
    public function show(Reference $reference)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reference $reference)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReferenceRequest $request, Reference $reference)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reference $reference)
    {
        //
    }

    public function getReferenceLetter(Request $request){
        $jData[0] = [
            'letter_id'=>'',
            'letter_no'=>'',
            'letter_path'=>''
        ];
        if($request->ajax()){
            $referenceLetters = Reference::getReference($request->letter);
            $i = 1;
            foreach($referenceLetters AS $value){
                $jData[$i] = [
                    'letter_id'=>$value['reference_letter_id'],
                    'letter_no'=>$value['letter_no'],
                    'letter_path'=>storageUrl($value['letter_path'])
                ];
                $i++;
            }
        }
        return response()->json($jData,200);
    }
}
