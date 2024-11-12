<?php

namespace App\Http\Controllers;

use App\Models\ReportModel;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function cat_wise_diarize_assign_forwarded(Request $request)
    {

        $categories = ReportModel::get_diarized_details();
        $diarized_count = ReportModel::get_diarized_count();
        $assigned_count = ReportModel::get_assigned_count();
        $forwarded_count = ReportModel::get_forwarded_count();
        
        return view('dashboard.report', compact('categories','diarized_count','assigned_count','forwarded_count'));
    }

    public function getCategoryData(Request $request)
    {
        $category = $request->query('category');

        
        // $diarized_details = ReportModel::get_diarized_details();
        // $assigned_details = ReportModel::get_assigned_details();
        // $forwarded_details = ReportModel::get_forwarded_details();

        // Retrieve category data from the database
        $data = [];
        if ($category == 'diarized') {
            $data = ReportModel::get_diarized_details();
        } elseif ($category == 'assigned') {
            $data = ReportModel::get_assigned_details();
        } elseif ($category == 'forwarded') {
            $data = ReportModel::get_forwarded_details();
        }

        // Return JSON response
        return response()->json($data);
    }

    public function report_by_category(Request $request){

        $category = $request->query('category');
        $category_id = $request->query('category_id');
        return response()->json([
            'category' => $category,
            'category_id' => $category_id,
        ]);

        // Retrieve category data from the database
        $data = [];
        if ($category == 'diarized') {
            return 'ok';
            $data = ReportModel::get_diarized_details();
        } elseif ($category == 'assigned') {
            $data = ReportModel::get_assigned_details();
        } elseif ($category == 'forwarded') {
            $data = ReportModel::get_forwarded_details();
        }

        // Return JSON response
        return response()->json($data);

    }
}
