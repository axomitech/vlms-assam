<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Letter;
use App\Models\User;
use App\Models\ReferenceLetter;
use App\Models\Recipient;
use App\Models\Sender;

class NewLetterController extends Controller
{

    public function diarized()
    {
        $letters = Letter::with([
            'category',
            'subcategory',
            'recipient',
            'sender'
        ])
            ->where('legacy', 0)
            ->orderBy('id', 'DESC')
            ->get();

        $departmentUsers = User::all();

        $letterNos = Letter::select('letter_no')->get();

        return view('hod.hod_letter', compact(
            'letters',
            'departmentUsers',
            'letterNos'
        ));
    }


    public function download($id)
    {
        $letter = Letter::findOrFail($id);

        $path = storage_path('app/' . $letter->letter_path);

        if (!file_exists($path)) {
            return "FILE NOT FOUND: " . $path;
        }

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $letter->letter_no . '.pdf"'
        ]);
    }
}
