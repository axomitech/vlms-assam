<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Letter;
use App\Models\LetterCategory;
use App\Models\LetterSubCategory;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class MonthwiseController extends Controller
{
    /**
     * Organize only letters with issue_date into year/month/category/subcategory folders.
     */
    public function organizeLettersIntoFolders()
    {
        $letters = Letter::with(['category', 'subCategory'])
            ->whereNotNull('issue_date')
            ->get();

        foreach ($letters as $letter) {
            $categoryId = $letter->letter_category_id ?? 'UnknownCategory';
            $subCategoryId = $letter->letter_sub_category_id ?? 'UnknownSubCategory';
            $year = Carbon::parse($letter->issue_date)->format('Y');
            $month = Carbon::parse($letter->issue_date)->format('F');

            $folderPath = "public/letters/$categoryId/$subCategoryId/$year/$month";

            // Create folder if not exists
            if (!Storage::exists($folderPath)) {
                Storage::makeDirectory($folderPath);
            }

            // Move the file if it exists
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

        return redirect()->route('files.view')->with('success', 'Letters with issue date organized successfully.');
    }

    /**
     * View folder-wise list of letters with issue_date.
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
                },
                function ($letter) {
                    return Carbon::parse($letter->issue_date)->format('F');
                }
            ]);

        $categories = LetterCategory::pluck('category_name', 'id');
        $subCategories = LetterSubCategory::pluck('sub_category_name', 'id');

        return view('files.month-view', [
            'groupedLetters' => $letters,
            'categories' => $categories,
            'subCategories' => $subCategories,
        ]);
    }
}
