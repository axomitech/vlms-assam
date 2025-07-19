<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Letter;
use App\Models\LetterCategory;
use App\Models\LetterSubCategory;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ReceivedFilesDownloadController extends Controller
{

    public function organizeLettersIntoFolders()
    {
        $letters = Letter::with(['category', 'subCategory'])
            ->whereNotNull('received_date')
            ->get();

        foreach ($letters as $letter) {
            $categoryId = $letter->letter_category_id ?? 'unknown-category';
            $subCategoryId = $letter->letter_sub_category_id;


            $subFolder = ($subCategoryId === null || $subCategoryId == 0) ? 'others' : $subCategoryId;

            $year = Carbon::parse($letter->received_date)->format('Y');
            $folderPath = "public/letters/{$categoryId}/{$subFolder}/{$year}";

            if (!Storage::exists($folderPath)) {
                Storage::makeDirectory($folderPath);
            }

            if ($letter->letter_path && Storage::exists("public/letters/" . $letter->letter_path)) {
                $currentPath = "public/letters/" . $letter->letter_path;
                $fileName = basename($letter->letter_path);
                $newPath = "{$folderPath}/{$fileName}";

                if (!Storage::exists($newPath)) {
                    Storage::move($currentPath, $newPath);
                    $letter->letter_path = "{$categoryId}/{$subFolder}/{$year}/{$fileName}";
                    $letter->save();
                }
            }
        }

        return redirect()->route('files.received-view')->with('success', 'Letters organized into folders successfully.');
    }

    /**
     * View letters grouped by category > subcategory > year (received_date).
     */
    public function viewLettersFolderWise1()
    {
        $letters = Letter::with(['category', 'subCategory'])
            ->whereNotNull('received_date')
            ->orderBy('letter_category_id')
            ->orderBy('letter_sub_category_id')
            ->orderBy('received_date')
            ->get()
            ->groupBy([
                'letter_category_id',
                function ($letter) {
                    return ($letter->letter_sub_category_id === null || $letter->letter_sub_category_id == 0)
                        ? 'others'
                        : $letter->letter_sub_category_id;
                },
                function ($letter) {
                    return Carbon::parse($letter->received_date)->format('Y');
                }
            ]);

        $categories = LetterCategory::pluck('category_name', 'id')->toArray();
        $subCategories = LetterSubCategory::pluck('sub_category_name', 'id')->toArray();
        $subCategories['others'] = 'Others / Miscellaneous';

        return view('files.received_view', [
            'letters' => $letters,
            'categories' => $categories,
            'subCategories' => $subCategories,
        ]);
    }

    /**
     * Download individual letter file by category/subcategory/year/filename.
     */
    public function downloadLetter($categoryId, $subCategoryId, $year, $fileName)
    {
        $subFolder = ($subCategoryId === 'others' || $subCategoryId == 0 || $subCategoryId === null)
            ? 'others'
            : $subCategoryId;

        $path = "public/letters/{$categoryId}/{$subFolder}/{$year}/{$fileName}";

        if (Storage::exists($path)) {
            return Storage::download($path);
        } else {
            return back()->with('error', 'File not found.');
        }
    }
}
