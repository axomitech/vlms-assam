<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Letter;

class DashboardController extends Controller
{
    public function index()
    {
        $letters = Letter::showLetterAndSender();
        return view('dashboard.dashboard', compact('letters'));
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
            'datasets'=> [
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
}
