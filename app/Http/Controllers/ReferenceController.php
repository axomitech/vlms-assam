<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReferenceRequest;
use App\Http\Requests\UpdateReferenceRequest;
use App\Models\Reference;
use App\Models\Common;
use App\Models\Letter;
use Illuminate\Http\Request;
use DB;

class ReferenceController extends Controller
{

    public function store(StoreReferenceRequest $request)
    {
        $jData = [];

        if ($request->ajax()) {

            DB::beginTransaction();

            try {

                $refers = $request->refer_letters;
                $letter = $request->assign_letter;

                for ($i = 0; $i < count($refers); $i++) {

                    $letterId = Common::getSingleColumnValue('letters', [
                        'letter_no' => $refers[$i]
                    ], 'id');

                    $referenceCount = Reference::checkReferenceExist([
                        $letter,
                        $letterId
                    ]);

                    if ($referenceCount <= 0) {

                        Reference::storeReferences([
                            $letter,
                            $letterId
                        ]);
                    }
                }

                DB::commit();

                $jData[1] = [
                    'message' => 'Letter is referred successfully.',
                    'status' => 'success'
                ];
            } catch (\Exception $e) {

                DB::rollback();

                $jData[1] = [
                    'message' => 'Something went wrong! ' . $e->getMessage(),
                    'status' => 'error'
                ];
            }

            return response()->json($jData, 200);
        }
    }


    public function download($id)
    {
        $letter = Letter::findOrFail($id);

        $path = storage_path('app/' . $letter->letter_path);

        if (!file_exists($path)) {
            return "FILE NOT FOUND: " . $path;
        }

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $letter->letter_no . '.pdf"'
        ]);
    }



    public function getReferenceLetter(Request $request)
    {

        $jData[0] = [
            'letter_id' => '',
            'letter_no' => '',
            'letter_path' => ''
        ];

        if ($request->ajax()) {

            $referenceLetters = Reference::getReference($request->letter);

            $i = 1;

            foreach ($referenceLetters as $value) {

                $jData[$i] = [
                    'letter_id' => $value['reference_letter_id'],
                    'letter_no' => $value['letter_no'],
                    'letter_path' => route('reference.download', $value['reference_letter_id'])
                ];

                $i++;
            }
        }

        return response()->json($jData, 200);
    }
}
