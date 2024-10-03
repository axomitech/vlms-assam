<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLetterSubCategoryRequest;
use App\Http\Requests\UpdateLetterSubCategoryRequest;
use Illuminate\Http\Request;
use App\Models\LetterSubCategory;

class LetterSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getLetterSubCategory(Request $request){

        $jdata[0] = [
            'category_id'=>'',
            'category_name'=>''
        ];

        if($request->ajax()){
            $subCategories = LetterSubCategory::getLetterSubCategory($request->category);
            $i = 1;
            foreach($subCategories AS $value){
                $jdata[$i] = [
                    'category_id'=>$value['id'],
                    'category_name'=>$value['sub_category_name']
                ];
                $i++;
            }

            return response()->json($jdata);
        }

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
    public function store(StoreLetterSubCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(LetterSubCategory $letterSubCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LetterSubCategory $letterSubCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLetterSubCategoryRequest $request, LetterSubCategory $letterSubCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LetterSubCategory $letterSubCategory)
    {
        //
    }
}
