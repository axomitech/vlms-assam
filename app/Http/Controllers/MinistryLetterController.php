<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Letter;
use App\Models\LetterCategory;
use App\Models\LetterSubCategory;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class MinistryLetterController extends Controller
{
    /**
     * Display only ministry letters that have a valid issue_date.
     */
    public function showDownloadView()
    {
        $letters = Letter::with(['category', 'subCategory'])
            ->whereNotNull('issue_date') // ✅ Only include letters with issue_date
            ->orderBy('letter_category_id')
            ->orderBy('letter_sub_category_id')
            ->orderBy('issue_date') // ✅ Sort by issue_date
            ->get();

        $groupedLetters = [];

        foreach ($letters as $letter) {
            $categoryId = $letter->letter_category_id;
            $subCategoryId = $letter->letter_sub_category_id;

            try {
                $carbonDate = Carbon::parse($letter->issue_date); // ✅ use issue_date
                $year = $carbonDate->format('Y');
                $month = $carbonDate->format('F');
            } catch (\Exception $e) {
                $year = 'UnknownYear';
                $month = 'UnknownMonth';
            }

            $groupedLetters[$categoryId][$subCategoryId][$year][$month][] = $letter;
        }

        $categories = LetterCategory::pluck('category_name', 'id');
        $subCategories = LetterSubCategory::pluck('sub_category_name', 'id');

        return view('files.ministry_letter_download', [
            'groupedLetters' => $groupedLetters,
            'categories' => $categories,
            'subCategories' => $subCategories
        ]);
    }
}
