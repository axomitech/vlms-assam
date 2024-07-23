<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LetterAction;
use App\Models\Department;
use App\Models\LetterPriority;
use App\Models\ActionDepartmentMap;
use App\Models\LetterActionResponse;
use App\Models\ActionSent;
use App\Models\Letter;
use App\Models\SearchModel;
use DB;

class SearchController extends Controller
{
    public function index()
    {
        return view('search');
    }
    public function search(Request $request)
    {
        $inputData = $request->all();

        $diarized_no = $request->input('diarized_no');
        $letter_no = $request->input('letter_no');
        $received_from = $request->input('received_from')??'2024-01-01';
        $received_to = $request->input('received_to')?? date("Y-m-d");
        $category = $request->input('category');


        $results =SearchModel::get_letter_search($diarized_no,$letter_no,$received_from,$received_to);
        
        $table='<table class="table table-hover table-sm" id="letter-table">
        <thead>
            <tr>
                <th>Diarized No.</th><th>Diarized Date</th><th>Letter No.</th><th>Subject</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>';

        $i=1;
        $has_data=0;

        if(!empty($results)){
            foreach ($results as $result) {
                $received_date= $result->subject;
                $has_data=1;
                $table .='<tr>';
                $table .='<td>'.$i++.'. '.$result->crn.'</td><td>'.$result->diary_date.'</td><td>'.$result->letter_no.'</td><td>'.$result->subject.'</td>';
                $table .='<td><a href="'.route('pdf_downloadAll', ['id' => $result->id]).'"><i class="fas fa-download" style="color: #174060"></i><a></td>';
                $table .='</tr>';
            }
        }

        $table .=  '    </tbody>
                    </table>';

        if($has_data==0){
            $table = 'No results founds';
        }


        

        $data = ['diarized_no' => $table];
         return response()->json($data);
    }
}
