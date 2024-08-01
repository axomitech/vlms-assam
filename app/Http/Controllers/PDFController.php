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
use DB;

use Mpdf\Mpdf;

class PDFController extends Controller
{
    public function generatePDF($letter_id)
    {

        $ack_exist =AcknowledgeModel::get_acknowledge_letter_details($letter_id);
        $pdf_name='Acknowledge_letter_id_'.$letter_id.'.pdf';

        if ($ack_exist) {
            $data = [
                'ack_letter_text' => $ack_exist -> ack_letter_text,
            ];
        }
        else{
            $result =AcknowledgeModel::insertAcknowledgeLetters($letter_id);
        }
        $ack_letter_text = $ack_exist -> ack_letter_text;
        // return view('pdf_view',compact('ack_letter_text'));
        // $dompdf = new Dompdf();
        // $dompdf->loadHtml($html);
        // $dompdf->render();
        // $dompdf->stream();

        $html = view('pdf.pdf_ack', $data)->render();
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output($pdf_name, 'D');
    }

    public function downloadAll1($letter_id)
    {

        $result = AcknowledgeModel::get_letter_details($letter_id);
        $letter_path = $result->letter_path;


        $pdfPath = storage_path('app/'.$letter_path);

        // Check if the file exists
        if (!file_exists($pdfPath)) {
            return response()->json(['message' => 'File not found.'], 404);
        }

        // Initialize mPDF
        $mpdf = new Mpdf();

        // Set the source file to the existing PDF
        $mpdf->SetSourceFile($pdfPath);

        // Add pages from the existing PDF
        for ($i = 1; $i <= $mpdf->SetSourceFile($pdfPath); $i++) {
            $tplId = $mpdf->ImportPage($i);
            $mpdf->AddPage();
            $mpdf->UseTemplate($tplId);
        }
        $mpdf->Output('test.pdf', 'D');
    }

    public function createActionDetails($letter_id)
    {

        $results= AcknowledgeModel::get_action_details($letter_id);
        print_r($results);

        $table='<table class="table table-bordered" id="letter-table">
        <thead>
            <tr>
                <th colspan="3"><h3>Actions</h3></th>
            </tr>
            <tr>
                <th>Sl. No.</th><th>Desciprions</th><th>Created</th>
            </tr>
        </thead>
        <tbody>';

        $i=1;

        if(!empty($results)){
            foreach ($results as $result) {
                $table .='<tr>';
                $table .='<td>'.$i++.'.</td><td>'.$result->action_description.'</td><td>'.$result->created_at.'</td>';
                $table .='</tr>';
            }
        }

        $table .=  '    </tbody>
                    </table>';

        $data = [
            'ack_letter_text' => $table,
        ];

        $html = view('pdf.pdf_ack', $data)->render();
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output('test.pdf', 'D');

    }

    public function mergePdfs()
    {
        // Paths to the PDFs you want to merge
        $pdf1Path = storage_path('app/public/letters/vip/test1.pdf');
        $pdf2Path = storage_path('app/public/letters/vip/test2.pdf');

        // Initialize mPDF
        $mpdf = new Mpdf();

        // Load the first PDF
        $pdf1 = new PdfReader($pdf1Path);
        $totalPagesPdf1 = $pdf1->pageCount;

        // Import pages from the first PDF
        for ($i = 1; $i <= $totalPagesPdf1; $i++) {
            $mpdf->AddPage();
            $page = $pdf1->importPage($i);
            $mpdf->useTemplate($page);
        }

        // Load the second PDF
        $pdf2 = new PdfReader($pdf2Path);
        $totalPagesPdf2 = $pdf2->pageCount;

        // Import pages from the second PDF
        for ($i = 1; $i <= $totalPagesPdf2; $i++) {
            $mpdf->AddPage();
            $page = $pdf2->importPage($i);
            $mpdf->useTemplate($page);
        }

        // Output the merged PDF
        // return response($mpdf->Output('', Destination::STRING_RETURN), 200)
        //     ->header('Content-Type', 'application/pdf')
        //     ->header('Content-Disposition', 'inline; filename="merged.pdf"');

        $mpdf->Output('test.pdf', 'D');
    }
    public function downloadAll($letter_id){

        $letter = AcknowledgeModel::get_letter_details($letter_id);
        $letter_path = $letter->letter_path;

        $correspondance = AcknowledgeModel::get_correspondence_details($letter_id);

        $pdfFiles = [
            storage_path('app/'.$letter_path)
        ];

        foreach($correspondance as $c){
            array_push($pdfFiles,storage_path('app/'.$c->file_path));
        }

        // print_r($pdfFiles);
        // exit;

        $outputPath = storage_path('app/public/letters/vip/merged.pdf');

        $this->mergePdfsNew($pdfFiles, $outputPath);

    }

    public function mergePdfsNew(array $pdfFiles, string $outputPath): void
    {
        $mpdf = new Mpdf();

        foreach ($pdfFiles as $file) {
            $mpdf->AddPage();
            $pageCount = $mpdf->SetSourceFile($file);
            for ($i = 1; $i <= $pageCount; $i++) {
                
                $tplId = $mpdf->ImportPage($i);
                $size = $mpdf->getTemplateSize($tplId);//rahul
                $mpdf->useTemplate($tplId, 0, 0, $size['width'], $size['height'], true);//rahul
                // $mpdf->UseTemplate($tplId);
                if ($i < $pageCount) {
                        $mpdf->AddPage($size['orientation']);
                }
            }
        }

        // $page_format = $mpdf->GetPageFormat($page_number);
        // if ($page_format['orientation'] === 'L') {
        //     echo 'hi';
        // }
        // $mpdf->Output($outputPath, \Mpdf\Output\Destination::FILE);
        $mpdf->Output('test.pdf', 'D');
    }
}
