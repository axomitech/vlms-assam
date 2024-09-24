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
        $categories = SearchModel::get_all_letter_categories();
        return view('search', compact('categories'));
    }
    public function search(Request $request)
    {
        $where = '';
        $inputData = $request->all();
        // print_r($inputData);
        // exit;
        // $diarized_no = $request->input('diarized_no');
        // $letter_no = $request->input('letter_no');
        // $received_from = $request->input('received_from')??'2024-01-01';
        // $received_to = $request->input('received_to')?? date("Y-m-d");
        // $category = $request->input('category');


        $results = SearchModel::get_letter_search($inputData);

        $table = '<table class="table table-hover table-striped table-sm table-responsive" id="letter-table">
        <thead>
            <tr>
                <th>#</th>
                <th style="width:12%">Diarize</th>
                <th style="width:50%">Letter</th>
                <th>Office Details</th>
                <th>Category</th>
                <th>Download</th>
            </tr>
        </thead>
        <tbody>';

        $i = 1;
        $has_data = 0;

        if (!empty($results)) {
            foreach ($results as $result) {
                $has_data = 1;

                // Determine the status for the first column based on receipt (Issue/Receipt)
                $status = !$result->receipt ? 'Issued' : 'Received';

                // Determine "From" or "To" based on receipt
                $from_to = !$result->receipt ? 'To' : 'From';
                $name_designation = !$result->receipt
                    ? ($result->recipient_organization ? $result->recipient_organization : 'N/A')
                    : ($result->sender_organization ? $result->sender_organization : 'N/A');

                $table .= '<tr>';
                $table .= '<td>' . $i++ . '.</td>';
                $table .= '<td><small><b>' . $result->crn . '</b><br><i>Diarized</i>: ' . date_format(date_create($result->diary_date), "d/m/Y") . '<br><i>' . $status . '</i>: ' . date_format(date_create($result->received_date), "d/m/Y") . '</small></td>';
                $table .= '<td><small><i>Subject</i>: ' . $result->subject . '<br><i>Letter No.</i>: ' . $result->letter_no . '<br><i>Letter Date</i>: ' . date_format(date_create($result->letter_date), "d/m/Y") . '</small></td>';
                $table .= '<td><small><i>' . $from_to . '</i>: ' . $name_designation . '</small></td>';
                $table .= '<td><small>' . $result->category_name . '</small></td>';
                $table .= '<td><a href="' . route('pdf_downloadAll', ['id' => $result->id]) . '"><i class="fas fa-download" style="color: #174060"></i></a></td>';
                $table .= '</tr>';
            }
        }

        $table .= '</tbody></table>';

        if ($has_data == 0) {
            $table = '<h6 style="color:red;">No results found. Please enter a correct combination.</h6>';
        }

        $data = ['diarized_no' => $table];
        return response()->json($data);
    }
}
