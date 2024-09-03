<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLetterAssignRequest;
use App\Http\Requests\UpdateLetterAssignRequest;
use App\Models\LetterAssign;
use DB;

class LetterAssignController extends Controller
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
    public function store(StoreLetterAssignRequest $request)
    {
        if($request->ajax()){
            
            DB::beginTransaction();
    
                try {
                    
                    if(session('role') == 1){

                        $id = LetterAssign::assignLetter([

                            $request->assign_letter,
                            $request->assignee,
                            $request->assign_remarks,
                            
                        ]);
                    }else if(session('role') == 3){
                        LetterAssign::forwardFrom($request->forward_from);
                        $id = LetterAssign::assignLetter([

                            $request->assign_letter,
                            $request->assignee,
                            $request->assign_remarks,
                            
                        ]);

                    }
                    DB::commit();
                    $jData[1] = [
                        'message'=>'Letter is successfully assigned.',
                        'status'=>'success',
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
    public function show(LetterAssign $letterAssign)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LetterAssign $letterAssign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLetterAssignRequest $request, LetterAssign $letterAssign)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LetterAssign $letterAssign)
    {
        //
    }
}
