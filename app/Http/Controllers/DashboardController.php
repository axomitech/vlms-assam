<?php

namespace App\Http\Controllers;

use App\Models\HomeModel;
use Illuminate\Http\Request;
use App\Models\Letter;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $letters = Letter::showLetterAndSender([
            'user_departments.department_id' => session('role_dept')
        ], []);
        $diarized_count = HomeModel::get_diarized_count();
        $sent_count = HomeModel::get_sent_count();
        $archive_count = HomeModel::get_archive_count();
        $diarized_details = HomeModel::get_diarized_details();
        $inbox_count = HomeModel::get_inbox_count();
        $issue_count = HomeModel::get_issue_count();

        $receipt_count = HomeModel::get_receipt_count();
        $action_count = HomeModel::get_actions_count();

        return view('dashboard.dashboard', compact('letters', 'diarized_count', 'sent_count', 'archive_count', 'diarized_details', 'inbox_count', 'receipt_count', 'issue_count', 'action_count'));
        // return response()->json($data);
    }
    public function dashboard_data()
    {

        $data1 = [
            'labels' => ['Not started', 'In process', 'Completed'],
            'datasets' => [
                [
                    'label' => 'Action points',
                    'data' => [5, 2, 10],
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(102, 255, 102)'
                    ],
                    'hoverOffset' => 4
                ]
            ]
        ];

        $data2 = [
            'labels' => ['In process', 'Not started', 'completed', 'Archived'],
            'datasets' => [
                [
                    'data' => [12, 5, 10, 5],
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    'borderColor' => [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    'borderWidth' => 1
                ]
            ]
        ];

        // return view('dashboard.dashboard',compact('data'));
        return response()->json([
            'chart1' => $data1,
            'chart2' => $data2
        ]);
    }

    public function receipt_box()
    {
        $categories = HomeModel::get_receipt_count_by_category();
        return view('dashboard.receipt', compact('categories'));
    }

    public function issue_box(){
        $categories = HomeModel::get_issue_count_by_category();
        return view('dashboard.issue',compact('categories'));
    }

    public function fetchReceiptByCategory($category_id)
    {
        $letters = HomeModel::get_receipt_by_category($category_id);
        return response()->json($letters);
    }

    public function fetchIssueByCategory($category_id)
    {
        $letters = HomeModel::get_issue_by_category($category_id);
        return response()->json($letters);
    }
}
