<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function getChartData(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');

        // Safety check
        if (!$year || !$month) {
            return response()->json([
                'received' => 0,
                'action' => 0,
                'issued' => 0,
                'archived' => 0,
                'error' => 'Year or Month missing'
            ]);
        }

        // Get data from database
        $received = DB::table('letters')->whereYear('received_date', $year)->whereMonth('received_date', $month)->where('status', 'received')->count();
        $action   = DB::table('letters')->whereYear('received_date', $year)->whereMonth('received_date', $month)->where('status', 'action')->count();
        $issued   = DB::table('letters')->whereYear('received_date', $year)->whereMonth('received_date', $month)->where('status', 'issued')->count();
        $archived = DB::table('letters')->whereYear('received_date', $year)->whereMonth('received_date', $month)->where('status', 'archived')->count();

        return response()->json([
            'received' => $received,
            'action'   => $action,
            'issued'   => $issued,
            'archived' => $archived,
        ]);
    }
}
