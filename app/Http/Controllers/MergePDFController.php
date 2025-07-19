<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Letter;
use Carbon\Carbon;
use setasign\Fpdi\Fpdi;

class MergePDFController extends Controller
{

    protected function getLetters($category, $subcategory, $year, $column = 'received_date', $month = null)
    {

        if ($subcategory === 'others' || $subcategory === 0 || $subcategory === '0') {
            $subcategory = null;
        }

        $query = Letter::where('letter_category_id', $category);

        if ($subcategory !== null) {
            $query->where('letter_sub_category_id', $subcategory);
        } else {
            $query->whereNull('letter_sub_category_id');
        }

        $query->whereYear($column, $year);

        if ($month !== null) {
            $query->whereMonth($column, $month);
        }

        return $query->orderBy($column)->get();
    }


    protected function generateMergedPDF($letters, $fileName)
    {
        if ($letters->isEmpty()) {
            return response('No PDFs found for the given criteria.', 404);
        }

        $pdf = new Fpdi();

        foreach ($letters as $letter) {
            $path = storage_path('app/' . str_replace('public/', 'public/', $letter->letter_path));

            if (file_exists($path)) {
                try {
                    $pageCount = $pdf->setSourceFile($path);

                    for ($i = 1; $i <= $pageCount; $i++) {
                        $templateId = $pdf->importPage($i);
                        $size = $pdf->getTemplateSize($templateId);
                        $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                        $pdf->useTemplate($templateId);
                    }
                } catch (\Exception $e) {

                    continue;
                }
            }
        }

        $outputPath = storage_path("app/public/merged/{$fileName}");

        if (!file_exists(dirname($outputPath))) {
            mkdir(dirname($outputPath), 0755, true);
        }

        $pdf->Output($outputPath, 'F');

        return response()->file($outputPath);
    }


    public function merge($category, $subcategory, $year)
    {
        $letters = $this->getLetters($category, $subcategory, $year);
        $fileName = "merged_{$category}_{$subcategory}_{$year}.pdf";
        return $this->generateMergedPDF($letters, $fileName);
    }


    public function IssueByYearMerge($category, $subcategory, $year)
    {
        $letters = $this->getLetters($category, $subcategory, $year, 'issue_date');
        $fileName = "merged_{$category}_{$subcategory}_{$year}.pdf";
        return $this->generateMergedPDF($letters, $fileName);
    }


    public function mergeByMonth($category, $subcategory, $year, $month)
    {
        $monthNum = Carbon::parse("{$month} 1, {$year}")->format('m');
        $letters = $this->getLetters($category, $subcategory, $year, 'received_date', $monthNum);
        $fileName = "merged_{$category}_{$subcategory}_{$year}_{$monthNum}.pdf";
        return $this->generateMergedPDF($letters, $fileName);
    }


    public function IssueMergeByMonth($category, $subcategory, $year, $month)
    {
        $monthNum = Carbon::parse("{$month} 1, {$year}")->format('m');
        $letters = $this->getLetters($category, $subcategory, $year, 'issue_date', $monthNum);
        $fileName = "merged_{$category}_{$subcategory}_{$year}_{$monthNum}.pdf";
        return $this->generateMergedPDF($letters, $fileName);
    }
}
