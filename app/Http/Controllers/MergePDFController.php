<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Letter;
use Carbon\Carbon;
use setasign\Fpdi\Fpdi;

class MergePDFController extends Controller
{
    /**
     * Merge PDFs by category, subcategory, and year
     */
    public function merge($category, $subcategory, $year)
    {
        $letters = Letter::where('letter_category_id', $category)
            ->where('letter_sub_category_id', $subcategory)
            ->whereYear('received_date', $year)
            ->orderBy('received_date')
            ->get();

        if ($letters->isEmpty()) {
            return response('No PDFs found for this year.', 404);
        }

        $pdf = new Fpdi();

        foreach ($letters as $letter) {
            $path = storage_path('app/' . str_replace('public/', 'public/', $letter->letter_path));

            if (file_exists($path)) {
                $pageCount = $pdf->setSourceFile($path);

                for ($i = 1; $i <= $pageCount; $i++) {
                    $templateId = $pdf->importPage($i);
                    $size = $pdf->getTemplateSize($templateId);

                    $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                    $pdf->useTemplate($templateId);
                }
            }
        }

        $fileName = "merged_{$category}_{$subcategory}_{$year}.pdf";
        $outputPath = storage_path("app/public/merged/{$fileName}");

        if (!file_exists(dirname($outputPath))) {
            mkdir(dirname($outputPath), 0755, true);
        }

        $pdf->Output($outputPath, 'F');

        return response()->file($outputPath);
    }

    public function IssueByYearMerge($category, $subcategory, $year)
    {
        $letters = Letter::where('letter_category_id', $category)
            ->where('letter_sub_category_id', $subcategory)
            ->whereYear('issue_date', $year)
            ->orderBy('issue_date')
            ->get();

        if ($letters->isEmpty()) {
            return response('No PDFs found for this year.', 404);
        }

        $pdf = new Fpdi();

        foreach ($letters as $letter) {
            $path = storage_path('app/' . str_replace('public/', 'public/', $letter->letter_path));

            if (file_exists($path)) {
                $pageCount = $pdf->setSourceFile($path);

                for ($i = 1; $i <= $pageCount; $i++) {
                    $templateId = $pdf->importPage($i);
                    $size = $pdf->getTemplateSize($templateId);

                    $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                    $pdf->useTemplate($templateId);
                }
            }
        }

        $fileName = "merged_{$category}_{$subcategory}_{$year}.pdf";
        $outputPath = storage_path("app/public/merged/{$fileName}");

        if (!file_exists(dirname($outputPath))) {
            mkdir(dirname($outputPath), 0755, true);
        }

        $pdf->Output($outputPath, 'F');

        return response()->file($outputPath);
    }

    /**
     * Merge PDFs by category, subcategory, year, and month
     */
    public function mergeByMonth($category, $subcategory, $year, $month)
    {
        $monthDate = Carbon::parse($month . ' 1, 2025');
        $month = $monthDate->format('m');

        $letters = Letter::where('letter_category_id', $category)
            ->where('letter_sub_category_id', $subcategory)
            ->whereYear('received_date', $year)
            ->whereMonth('received_date', $month)
            ->orderBy('received_date')
            ->get();

        if ($letters->isEmpty()) {
            return response('No PDFs found for this month.', 404);
        }

        $pdf = new Fpdi();

        foreach ($letters as $letter) {
            $path = storage_path('app/' . str_replace('public/', 'public/', $letter->letter_path));

            if (file_exists($path)) {
                $pageCount = $pdf->setSourceFile($path);

                for ($i = 1; $i <= $pageCount; $i++) {
                    $templateId = $pdf->importPage($i);
                    $size = $pdf->getTemplateSize($templateId);

                    $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                    $pdf->useTemplate($templateId);
                }
            }
        }

        $fileName = "merged_{$category}_{$subcategory}_{$year}_{$month}.pdf";
        $outputPath = storage_path("app/public/merged/{$fileName}");

        if (!file_exists(dirname($outputPath))) {
            mkdir(dirname($outputPath), 0755, true);
        }

        $pdf->Output($outputPath, 'F');

        return response()->file($outputPath);
    }


    public function IssueMergeByMonth($category, $subcategory, $year, $month)
    {
        $monthDate = Carbon::parse($month . ' 1, 2025');
        $month = $monthDate->format('m');

        $letters = Letter::where('letter_category_id', $category)
            ->where('letter_sub_category_id', $subcategory)
            ->whereYear('issue_date', $year)
            ->whereMonth('issue_date', $month)
            ->orderBy('issue_date')
            ->get();

        if ($letters->isEmpty()) {
            return response('No PDFs found for this month.', 404);
        }

        $pdf = new Fpdi();

        foreach ($letters as $letter) {
            $path = storage_path('app/' . str_replace('public/', 'public/', $letter->letter_path));

            if (file_exists($path)) {
                $pageCount = $pdf->setSourceFile($path);

                for ($i = 1; $i <= $pageCount; $i++) {
                    $templateId = $pdf->importPage($i);
                    $size = $pdf->getTemplateSize($templateId);

                    $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                    $pdf->useTemplate($templateId);
                }
            }
        }

        $fileName = "merged_{$category}_{$subcategory}_{$year}_{$month}.pdf";
        $outputPath = storage_path("app/public/merged/{$fileName}");

        if (!file_exists(dirname($outputPath))) {
            mkdir(dirname($outputPath), 0755, true);
        }

        $pdf->Output($outputPath, 'F');

        return response()->file($outputPath);
    }
}
