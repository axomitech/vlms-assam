<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilePreviewController extends Controller
{
    public function index(){
        return view('diarize.file_view');
    }
}
