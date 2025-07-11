<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Letter;
use App\Models\LetterCategory;
use App\Models\LetterSubCategory;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class FilesDownloadController extends Controller
{
    /**
     * Organize letters into year-wise folders based on category and subcategory.
     */
    public function organizeLettersIntoFolders()
    {
        $letters = Letter::with(['category', 'subCategory'])
            ->whereNotNull('issue_date') // Only letters with issue_date
            ->get();

        foreach ($letters as $letter) {
            $categoryId = $letter->letter_category_id;
            $subCategoryId = $letter->letter_sub_category_id;
            $year = Carbon::parse($letter->issue_date)->format('Y');

            $folderPath = "public/letters/$categoryId/$subCategoryId/$year";

            if (!Storage::exists($folderPath)) {
                Storage::makeDirectory($folderPath);
            }

            if ($letter->letter_path && Storage::exists("public/letters/" . $letter->letter_path)) {
                $currentPath = "public/letters/" . $letter->letter_path;
                $fileName = basename($letter->letter_path);
                $newPath = "$folderPath/$fileName";

                if (!Storage::exists($newPath)) {
                    Storage::move($currentPath, $newPath);
                    $letter->letter_path = "$categoryId/$subCategoryId/$year/$fileName";
                    $letter->save();
                }
            }
        }

        return redirect()->route('files.view')->with('success', 'Letters organized into folders successfully.');
    }

    /**
     * View letters grouped by category > subcategory > year.
     */
    public function viewLettersFolderWise()
    {
        $letters = Letter::with(['category', 'subCategory'])
            ->whereNotNull('issue_date')
            ->orderBy('letter_category_id')
            ->orderBy('letter_sub_category_id')
            ->orderBy('issue_date')
            ->get()
            ->groupBy([
                'letter_category_id',
                'letter_sub_category_id',
                function ($letter) {
                    return Carbon::parse($letter->issue_date)->format('Y');
                }
            ]);

        $categories = LetterCategory::pluck('category_name', 'id');
        $subCategories = LetterSubCategory::pluck('sub_category_name', 'id');

        return view('files.view', compact('letters', 'categories', 'subCategories'));
    }

    /**
     * Download individual letter file by path.
     */
    public function downloadLetter($categoryId, $subCategoryId, $year, $fileName)
    {
        $path = "public/letters/$categoryId/$subCategoryId/$year/$fileName";

        if (Storage::exists($path)) {
            return Storage::download($path);
        } else {
            return back()->with('error', 'File not found.');
        }
    }
}
