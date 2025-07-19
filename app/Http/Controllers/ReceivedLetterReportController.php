<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Letter;
use App\Models\LetterCategory;
use App\Models\LetterSubCategory;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ReceivedLetterReportController extends Controller
{

    public function organizeLettersIntoFolders()
    {

        $letters = Letter::with(['category', 'subCategory'])
            ->whereNotNull('received_date')
            ->get();

        foreach ($letters as $letter) {
            $categoryId = $letter->letter_category_id;
            $subCategoryId = $letter->letter_sub_category_id;
            $year = $letter->received_date ? Carbon::parse($letter->received_date)->format('Y') : 'UnknownYear';
            $month = $letter->received_date ? Carbon::parse($letter->received_date)->format('F') : 'UnknownMonth';

            $folderPath = "public/letters/$categoryId/$subCategoryId/$year/$month";

            if (!Storage::exists($folderPath)) {
                Storage::makeDirectory($folderPath);
            }

            if ($letter->letter_path && Storage::exists("public/letters/" . $letter->letter_path)) {
                $currentPath = "public/letters/" . $letter->letter_path;
                $fileName = basename($letter->letter_path);
                $newPath = "$folderPath/$fileName";

                if (!Storage::exists($newPath)) {
                    Storage::move($currentPath, $newPath);
                    $letter->letter_path = "$categoryId/$subCategoryId/$year/$month/$fileName";
                    $letter->save();
                }
            }
        }

        return redirect()->route('files.view')->with('success', 'Only issue date letters organized successfully.');
    }


    public function viewLettersFolderWise()
    {

        $letters = Letter::with(['category', 'subCategory'])
            ->whereNotNull('received_date')
            ->orderBy('letter_category_id')
            ->orderBy('letter_sub_category_id')
            ->orderBy('received_date')
            ->get()
            ->groupBy([
                'letter_category_id',
                'letter_sub_category_id',
                function ($letter) {
                    return $letter->received_date
                        ? Carbon::parse($letter->received_date)->format('Y')
                        : 'UnknownYear';
                },
                function ($letter) {
                    return $letter->received_date
                        ? Carbon::parse($letter->received_date)->format('F')
                        : 'UnknownMonth';
                }
            ]);

        $categories = LetterCategory::pluck('category_name', 'id');
        $subCategories = LetterSubCategory::pluck('sub_category_name', 'id');

        return view('files.received-letter-report', [
            'groupedLetters' => $letters,
            'categories' => $categories,
            'subCategories' => $subCategories,
        ]);
    }
}
