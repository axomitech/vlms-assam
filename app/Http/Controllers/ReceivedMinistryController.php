<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Letter;
use App\Models\LetterCategory;
use App\Models\LetterSubCategory;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class ReceivedMinistryController extends Controller
{

    public function showDownloadView1()
    {
        // Fetch letters that have a received_date and eager load category and sub-category
        $letters = Letter::with(['category', 'subCategory'])
            ->whereNotNull('received_date') // ✅ Filter: received_date must be present
            ->orderBy('letter_category_id')
            ->orderBy('letter_sub_category_id')
            ->orderBy('received_date') // ✅ Sort by received_date
            ->get();

        $groupedLetters = [];

        // Group letters by category -> subcategory -> year -> month (based on received_date)
        foreach ($letters as $letter) {
            $categoryId = $letter->letter_category_id;
            $subCategoryId = $letter->letter_sub_category_id;

            try {
                $carbonDate = Carbon::parse($letter->received_date); // ✅ Parse received_date
                $year = $carbonDate->format('Y');
                $month = $carbonDate->format('F');
            } catch (\Exception $e) {
                $year = 'UnknownYear';
                $month = 'UnknownMonth';
            }

            $groupedLetters[$categoryId][$subCategoryId][$year][$month][] = $letter;
        }

        // Fetch category and sub-category names for mapping
        $categories = LetterCategory::pluck('category_name', 'id');
        $subCategories = LetterSubCategory::pluck('sub_category_name', 'id');

        // Pass grouped data to the blade view
        return view('files.received_ministry_letter_download', [
            'groupedLetters' => $groupedLetters,
            'categories' => $categories,
            'subCategories' => $subCategories
        ]);
    }
}
