<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\AcknowledgeModel;
use App\Models\LetterAction;
use App\Models\Department;
use App\Models\LetterPriority;
use App\Models\ActionDepartmentMap;
use App\Models\LetterActionResponse;
use App\Models\ActionSent;
use App\Models\Letter;
use App\Models\SearchModel;

use Carbon\Carbon;
use DB;
use Mpdf\Mpdf;

class PDFController extends Controller
{
    private function getMpdfInstance()
    {

        $config = [
            'tempDir' => storage_path('app/mpdf'),
        ];


        if (!is_dir($config['tempDir'])) {
            mkdir($config['tempDir'], 0775, true);
        }

        return new Mpdf($config);
    }

    public function generatePDF($letter_id)
    {
        $ack_exist = AcknowledgeModel::get_acknowledge_letter_details($letter_id);
        $pdf_name = 'Acknowledge_letter_id_' . $letter_id . '.pdf';

        if ($ack_exist) {
            $data = [
                'ack_letter_text' => $ack_exist->ack_letter_text,
            ];
        } else {
            $result = AcknowledgeModel::insertAcknowledgeLetters($letter_id);
            $data = ['ack_letter_text' => $result->ack_letter_text ?? ''];
        }

        $html = view('pdf.pdf_ack', $data)->render();
        $mpdf = $this->getMpdfInstance();
        $mpdf->WriteHTML($html);
        $mpdf->Output($pdf_name, 'D');
    }

    public function downloadAll1($letter_id)
    {
        $result = AcknowledgeModel::get_letter_details($letter_id);
        $letter_path = $result->letter_path;

        $pdfPath = storage_path('app/' . $letter_path);

        if (!file_exists($pdfPath)) {
            return response()->json(['message' => 'File not found.'], 404);
        }

        $mpdf = $this->getMpdfInstance();
        $pageCount = $mpdf->SetSourceFile($pdfPath);

        for ($i = 1; $i <= $pageCount; $i++) {
            $tplId = $mpdf->ImportPage($i);
            $size = $mpdf->getTemplateSize($tplId);
            $mpdf->AddPage($size['orientation']);
            $mpdf->useTemplate($tplId, 0, 0, $size['width'], $size['height']);
        }

        $mpdf->Output($result->letter_no . '_' . Carbon::now()->format('Ymd_His') . '.pdf', 'D');
    }

    public function createActionDetails($letter_id)
    {
        $results = AcknowledgeModel::get_action_details($letter_id);

        $table = '<table class="table table-bordered" id="letter-table">
        <thead>
            <tr><th colspan="3"><h3>Actions</h3></th></tr>
            <tr><th>Sl. No.</th><th>Descriptions</th><th>Created</th></tr>
        </thead><tbody>';

        $i = 1;
        foreach ($results as $result) {
            $table .= '<tr>';
            $table .= '<td>' . $i++ . '.</td><td>' . $result->action_description . '</td><td>' . $result->created_at . '</td>';
            $table .= '</tr>';
        }
        $table .= '</tbody></table>';

        $data = ['ack_letter_text' => $table];

        $html = view('pdf.pdf_ack', $data)->render();
        $mpdf = $this->getMpdfInstance();
        $mpdf->WriteHTML($html);
        $mpdf->Output('action_details.pdf', 'D');
    }

    public function downloadAll($letter_id)
    {
        $letter = AcknowledgeModel::get_letter_details($letter_id);
        $letter_path = $letter->letter_path;
        $correspondance = AcknowledgeModel::get_correspondence_details($letter_id);

        $pdfFiles = [storage_path('app/' . $letter_path)];
        foreach ($correspondance as $c) {
            $pdfFiles[] = storage_path('app/' . $c->file_path);
        }

        $this->mergePdfsNew($pdfFiles);
    }

    public function mergePdfsNew(array $pdfFiles): void
    {
        $mpdf = $this->getMpdfInstance();

        foreach ($pdfFiles as $file) {
            $pageCount = $mpdf->SetSourceFile($file);
            for ($i = 1; $i <= $pageCount; $i++) {
                $tplId = $mpdf->ImportPage($i);
                $size = $mpdf->getTemplateSize($tplId);
                $mpdf->AddPage($size['orientation']);
                $mpdf->useTemplate($tplId, 0, 0, $size['width'], $size['height']);
            }
        }

        $mpdf->Output('merged_' . Carbon::now()->format('Ymd_His') . '.pdf', 'D');
    }
}
