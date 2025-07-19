<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Letter;
use App\Models\LetterCategory;
use App\Models\LetterSubCategory;
use Carbon\Carbon;

class ReceivedMinistryController extends Controller
{

    public function showDownloadView1()
    {

        $letters = Letter::with(['category', 'subCategory'])
            ->whereNotNull('received_date')
            ->orderBy('letter_category_id')
            ->orderBy('letter_sub_category_id')
            ->orderBy('received_date')
            ->get();

        $groupedLetters = [];

        foreach ($letters as $letter) {
            $categoryId = $letter->letter_category_id ?? 'unknown-category';


            $subCategoryId = ($letter->letter_sub_category_id === null || $letter->letter_sub_category_id == 0)
                ? 'others'
                : $letter->letter_sub_category_id;

            try {
                $carbonDate = Carbon::parse($letter->received_date);
                $year = $carbonDate->format('Y');
                $month = $carbonDate->format('F');
            } catch (\Exception $e) {
                $year = 'UnknownYear';
                $month = 'UnknownMonth';
            }

            $groupedLetters[$categoryId][$subCategoryId][$year][$month][] = $letter;
        }


        $categories = LetterCategory::pluck('category_name', 'id')->toArray();
        $subCategories = LetterSubCategory::pluck('sub_category_name', 'id')->toArray();


        $subCategories['others'] = 'Others / Miscellaneous';

        return view('files.received_ministry_letter_download', [
            'groupedLetters' => $groupedLetters,
            'categories'     => $categories,
            'subCategories'  => $subCategories
        ]);
    }
}
