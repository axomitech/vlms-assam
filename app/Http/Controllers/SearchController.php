<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use Illuminate\Http\Request;
use App\Models\SearchModel;
use App\Models\Common;

class SearchController extends Controller
{
    public function index()
    {
        $categories = SearchModel::get_all_letter_categories();
        $subcategory = SearchModel::get_all_letter_subcategories();
        return view('search', compact('categories', 'subcategory'));
    }

    public function letterDetails($id)
    {
        $letter = Letter::findOrFail($id);

        $category = \DB::table('letter_categories')
            ->where('id', $letter->letter_category_id)
            ->first();

        $subcategory = \DB::table('letter_sub_categories')
            ->where('id', $letter->letter_sub_category_id)
            ->first();

        $letterUserId = Common::getSingleColumnValue('letters', [
            'id' => $letter->id
        ], 'user_id');

        $userId = Common::getSingleColumnValue('user_departments', [
            'id' => $letterUserId
        ], 'user_id');

        $diarizedBy = Common::getSingleColumnValue('users', [
            'id' => $userId
        ], 'name');

        $movements = SearchModel::get_letter_full_movements($id);

        return view('letter-details', compact(
            'letter',
            'category',
            'subcategory',
            'diarizedBy',
            'movements'
        ));
    }

    public function viewPdf($id)
    {
        $letter = Letter::findOrFail($id);

        $path = storage_path('app/' . $letter->letter_path);

        if (!file_exists($path)) {
            abort(404, 'File not found');
        }

        return response()->file($path, [
            'Content-Disposition' => 'inline; filename="' . $letter->letter_no . '.pdf"'
        ]);
    }

    public function pdfDownloadAll($id)
    {
        $letter = Letter::findOrFail($id);

        $path = storage_path('app/' . $letter->letter_path);

        if (!file_exists($path)) {
            abort(404, 'File not found');
        }

        $filename = str_replace(['/', '\\'], '-', $letter->letter_no) . '.pdf';

        return response()->download($path, $filename);
    }

    public function search(Request $request)
    {
        $inputData = $request->all();
        $results = SearchModel::get_letter_search($inputData);

        $table = '<table class="table table-hover table-sm align-middle" id="letter-table" style="font-size:16px;">
        <thead style="background:#f8fafc;">
        <tr>
            <th style="width:3%">#</th>
            <th style="width:14%">Diarize</th>
            <th style="width:32%">Letter Details</th>
            <th style="width:15%">Office</th>
            <th style="width:10%">Category</th>
            <th style="width:10%">Sub Category</th>
            <th style="width:5%">PDF</th>
            <th style="width:6%">Type</th>
            <th style="width:5%">Action</th>
        </tr>
        </thead>
        <tbody>';

        $i = 1;
        $has_data = 0;
        $diarizedBy = [];
        $diarizerName = [];

        if (!empty($results)) {
            foreach ($results as $result) {

                $diarizedBy[$result->crn] = Common::getSingleColumnValue('letters', [
                    'id' => $result->letter_id
                ], 'user_id');

                $userId = Common::getSingleColumnValue('user_departments', [
                    'id' => $diarizedBy[$result->crn]
                ], 'user_id');

                $diarizerName[$result->crn] = Common::getSingleColumnValue('users', [
                    'id' => $userId
                ], 'name');

                $has_data = 1;

                $status = !$result->receipt ? 'Issued' : 'Received';

                $rowStyle = !$result->receipt
                    ? 'background-color:#f1fdf5;'
                    : 'background-color:#f2f7ff;';

                $from_to = !$result->receipt ? 'To' : 'From';

                $name_designation = !$result->receipt
                    ? ($result->recipient_organization ? $result->recipient_organization : 'N/A')
                    : ($result->sender_organization ? $result->sender_organization : 'N/A');

                $table .= '<tr style="' . $rowStyle . ';border-bottom:1px solid #eef2f7;">';

                $table .= '<td style="font-weight:600;">' . $i++ . '</td>';

                $table .= '<td><small><a href="" class="assign-link"
                                                                       data-toggle="modal"
                                                                            data-target=".bd-example-modal-lg"
                                                                            data-letter="' . $result->letter_no . '"
                                                                            data-letter_path="' . route('pdf_view', $result->letter_id) . '"><b>' . $result->crn . '</b></a><br><i>Diarized</i>: ' . date_format(date_create($result->diary_date), "d/m/Y") . '<br><i>' . $status . '</i>: ' . date_format(date_create($result->received_date), "d/m/Y") . '<br>Diarized By: ' . $diarizerName[$result->crn] . '</small></td>';


                $table .= '<td>
                <small style="line-height:1.5;">
                <span style="font-weight:600;color:#2c3e50;">' . $result->subject . '</span><br>
                <span style="color:#6c757d;">Letter No: ' . $result->letter_no . '</span><br>
                <span style="color:#6c757d;">Date: ' . date_format(date_create($result->letter_date), "d/m/Y") . '</span>
                </small>
                </td>';

                $table .= '<td>
                <small>
                <span style="color:#6c757d;">' . $from_to . '</span><br>
                <b>' . $name_designation . '</b>
                </small>
                </td>';

                $table .= '<td><small>' . $result->category_name . '</small></td>';

                $table .= '<td><small>' .
                    (!empty($result->sub_category_name)
                        ? $result->sub_category_name
                        : $result->letter_other_sub_categories)
                    . '</small></td>';

                $table .= '<td style="text-align:center;">
                <a href="' . route('pdf_downloadAll', ['id' => $result->letter_id]) . '">
                <i class="fas fa-file-pdf" style="color:#c82333;font-size:16px;"></i>
                </a>
                </td>';

                $table .= '<td><small>' . $status . '</small></td>';

                $table .= '<td>
                <a href="' . route('letter.details', ['id' => $result->letter_id]) . '"
                class="btn btn-sm btn-outline-primary"
                style="font-size:12px;padding:3px 10px;">
                View
                </a>
                </td>';

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
