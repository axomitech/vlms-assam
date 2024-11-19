<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use Illuminate\Http\Request;
use App\Models\SearchModel;

class SearchController extends Controller
{
    public function index()
    {
        $categories = SearchModel::get_all_letter_categories();
        $subcategory = SearchModel::get_all_letter_subcategories();
        // return Letter::all();
        return view('search', compact('categories', 'subcategory'));
    }

    public function search(Request $request)
    {
        $inputData = $request->all();
        $results = SearchModel::get_letter_search($inputData);
        // return $results;

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

                $status = !$result->receipt ? 'Issued' : 'Received';
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

        return response()->json(['diarized_no' => $table]);
    }
}
