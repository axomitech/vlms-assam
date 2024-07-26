<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\UserDepartment;
use App\Models\HomeModel;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $sessionUser = UserDepartment::roleUser(Auth::user()->id);
        Log::channel('dblog')->info('This is a test log message.');
        return view('home',compact('sessionUser'));

    }

    public function test()
    {
        return view('test');
    }
    public function box()
    {

        $diarized_count = HomeModel::get_diarized_count();
        $sent_count = HomeModel::get_sent_count();
        $archive_count = HomeModel::get_archive_count();
        $diarized_details = HomeModel::get_diarized_details();
        // print_r($diarized_details);
        // exit;
        return view('home1',compact('diarized_count','diarized_details','sent_count','archive_count'));
    }
}
