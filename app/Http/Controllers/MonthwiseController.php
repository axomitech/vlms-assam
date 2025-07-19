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

    public function organizeLettersIntoFolders()
    {
        $letters = Letter::with(['category', 'subCategory'])
            ->whereNotNull('issue_date')
            ->get();

        foreach ($letters as $letter) {
            $categoryId = $letter->letter_category_id ?? 'unknown-category';
            $subCategoryId = $letter->letter_sub_category_id;


            $subFolder = ($subCategoryId === null || $subCategoryId == 0) ? 'others' : $subCategoryId;

            $year = Carbon::parse($letter->issue_date)->format('Y');
            $month = Carbon::parse($letter->issue_date)->format('F');

            $folderPath = "public/letters/{$categoryId}/{$subFolder}/{$year}/{$month}";

            if (!Storage::exists($folderPath)) {
                Storage::makeDirectory($folderPath);
            }

            if ($letter->letter_path && Storage::exists("public/letters/" . $letter->letter_path)) {
                $currentPath = "public/letters/" . $letter->letter_path;
                $fileName = basename($letter->letter_path);
                $newPath = "{$folderPath}/{$fileName}";

                if (!Storage::exists($newPath)) {
                    Storage::move($currentPath, $newPath);
                    $letter->letter_path = "{$categoryId}/{$subFolder}/{$year}/{$month}/{$fileName}";
                    $letter->save();
                }
            }
        }

        return redirect()->route('files.month-view')->with('success', 'Letters with issue date organized successfully.');
    }


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
                function ($letter) {
                    return ($letter->letter_sub_category_id === null || $letter->letter_sub_category_id == 0)
                        ? 'others'
                        : $letter->letter_sub_category_id;
                },
                function ($letter) {
                    return Carbon::parse($letter->issue_date)->format('Y');
                },
                function ($letter) {
                    return Carbon::parse($letter->issue_date)->format('F');
                }
            ]);

        $categories = LetterCategory::pluck('category_name', 'id')->toArray();
        $subCategories = LetterSubCategory::pluck('sub_category_name', 'id')->toArray();
        $subCategories['others'] = 'Others / Miscellaneous';

        return view('files.month-view', [
            'groupedLetters' => $letters,
            'categories' => $categories,
            'subCategories' => $subCategories,
        ]);
    }
}
