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
        ])->get();

        $departmentUsers = User::all();
        $letterNos = Letter::select('letter_no')->get();

        return view('hod.hod_letter', compact('letters', 'departmentUsers', 'letterNos'));
    }

    public function download($id)
    {
        $letter = Letter::findOrFail($id);
        return response()->file(storage_path('app/' . $letter->letter_path));
    }


    // public function assignLetter(Request $request)
    // {
    //     Letter::where('letter_id', $request->assign_letter)
    //         ->update([
    //             'assigned_to' => $request->assignee,
    //             'assign_remarks' => $request->assign_remarks
    //         ]);

    //     return response()->json(['status' => true]);
    // }

    // public function refer(Request $request)
    // {
    //     foreach ($request->refer_letters as $letterNo) {
    //         ReferenceLetter::create([
    //             'main_letter_id' => $request->assign_letter,
    //             'letter_no'      => $letterNo
    //         ]);
    //     }

    //     return response()->json(['status' => true]);
    // }

    // public function reference(Request $request)
    // {
    //     return ReferenceLetter::where('main_letter_id', $request->letter)->get();
    // }
}
