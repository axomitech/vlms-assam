<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PieChartController extends Controller
{
    public function getStatusData(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $month = $request->input('month', date('n'));

        $data = [
            'received' => DB::table('letters')
                ->whereYear('received_date', $year)
                ->whereMonth('received_date', $month)
                ->where('status', 'received')
                ->count(),

            'action' => DB::table('letters')
                ->whereYear('received_date', $year)
                ->whereMonth('received_date', $month)
                ->where('status', 'action')
                ->count(),

            'issued' => DB::table('letters')
                ->whereYear('received_date', $year)
                ->whereMonth('received_date', $month)
                ->where('status', 'issued')
                ->count(),

            'archived' => DB::table('letters')
                ->whereYear('received_date', $year)
                ->whereMonth('received_date', $month)
                ->where('status', 'archived')
                ->count(),
        ];

        return response()->json($data);
    }
}
