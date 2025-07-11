<?php

namespace App\Http\Controllers;

use App\Models\HomeModel;
use Illuminate\Http\Request;
use App\Models\Letter;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $selectedMonth = request('month', date('n'));
        $selectedYear = request('year', date('Y'));

        $isOverall = $selectedYear === 'all';
        $selectedMonth = $isOverall ? null : (int) $selectedMonth;
        $selectedYearInt = $isOverall ? null : (int) $selectedYear;

        $departmentId = session('role_dept');

        // Base query
        $baseQuery = DB::table('letters')
            ->where('department_id', $departmentId);

        // Weekly Receipt Data
        $weeklyReceiptDataQuery = DB::table('letters')
            ->join('letter_categories', 'letters.letter_category_id', '=', 'letter_categories.id')
            ->selectRaw("
            letter_categories.category_name,
            letter_category_id,
            CEIL(EXTRACT(DAY FROM received_date)::numeric / 7) AS week_of_month,
            COUNT(*) AS count
        ")
            ->where('letters.receipt', true)
            ->where('letters.department_id', $departmentId);

        if (!$isOverall) {
            $weeklyReceiptDataQuery->whereRaw('EXTRACT(YEAR FROM received_date) = ?', [$selectedYearInt])
                ->whereRaw('EXTRACT(MONTH FROM received_date) = ?', [$selectedMonth]);
        }

        $weeklyReceiptData = $weeklyReceiptDataQuery
            ->groupBy('letter_category_id', 'week_of_month', 'letter_categories.category_name')
            ->get();

        $receivedLetters = $weeklyReceiptData;

        // General letters and categories
        $letters = Letter::showLetterAndSender(['user_departments.department_id' => $departmentId], []);

        $letter_category = Letter::join('letter_categories', 'letters.letter_category_id', '=', 'letter_categories.id')
            ->select('letter_categories.id', 'letter_categories.category_name', DB::raw('COUNT(*) as count'))
            ->groupBy('letters.letter_category_id', 'letter_categories.id', 'letter_categories.category_name')
            ->get();

        // Filters for count queries
        $filteredQuery = DB::table('letters')
            ->where('department_id', '=', $departmentId);

        if (!$isOverall) {
            $filteredQuery->whereRaw('EXTRACT(YEAR FROM letter_date) = ?', [$selectedYearInt])
                ->whereRaw('EXTRACT(MONTH FROM letter_date) = ?', [$selectedMonth]);
        }

        $receipt_count = (clone $filteredQuery)->where('receipt', '=', true)->count();
        // dd($receipt_count);
        $issue_count = (clone $filteredQuery)->where('receipt', '=', false)->count();
        // $issue_count = (clone $filteredQuery)->whereNotNull('letter_date')->count();

        // dd($issue_count);
        $archive_count = (clone $filteredQuery)->where('stage_status', '=', 5)->count();

        // dd($archive_count);

        // Other stats
        $diarized_count = HomeModel::get_diarized_count();
        $sent_count = HomeModel::get_sent_count();
        $diarized_details = HomeModel::get_diarized_details();
        $inbox_count = HomeModel::get_inbox_count();
        $action_count = HomeModel::get_actions_count();
        $in_process_count = HomeModel::get_in_process_count();
        $completed_count = HomeModel::get_completed_count();

        $monthName = !$isOverall
            ? Carbon::createFromDate($selectedYearInt, $selectedMonth, 1)->format('F Y')
            : 'OverAll';

        $sessionMonth = 0;
        $sessionYear = 0;
        if (session('year') && session('month')) {
            $sessionMonth = session('month');
            $sessionYear = session('year');
            session()->forget('month');
            session()->forget('year');
        }

        return view('dashboard.dashboard', compact(
            'letters',
            'letter_category',
            'receivedLetters',
            'weeklyReceiptData',
            'monthName',
            'diarized_count',
            'sent_count',
            'archive_count',
            'diarized_details',
            'inbox_count',
            'issue_count',
            'receipt_count',
            'action_count',
            'in_process_count',
            'completed_count',
            'sessionYear',
            'sessionMonth'
        ));
    }


    public function receipt_box()
    {
        $categories = HomeModel::get_receipt_count_by_category();
        return view('dashboard.receipt', compact('categories'));
    }

    public function action_box()
    {
        $categories = HomeModel::get_action_count_by_category();
        return view('dashboard.action', compact('categories'));
    }

    public function issue_box()
    {
        $categories = HomeModel::get_issue_count_by_category();
        return view('dashboard.issue', compact('categories'));
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

    public function fetchActionByCategory($category_id)
    {
        $letters = HomeModel::get_action_by_category($category_id);
        return response()->json($letters);
    }
}
