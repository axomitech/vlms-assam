@extends('layouts.app')

@section('content')
    <style>
        table.table {
            width: 100%;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            font-size: 14px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        table.table th {
            background: #f0f3f7 !important;
            font-weight: 700 !important;
            color: #2c3e50 !important;
            padding: 12px 10px !important;
            text-transform: uppercase;
            border-bottom: 2px solid #d6dce5 !important;
            letter-spacing: 0.4px;
        }

        table.table td {
            background: #ffffff !important;
            padding: 11px 9px !important;
            color: #2b2b2b;
        }

        table.table-bordered td,
        table.table-bordered th {
            border: 1px solid #d9d9d9 !important;
        }

        table.table-hover tbody tr:hover td {
            background: #eef5ff !important;
            transition: 0.15s ease-in-out;
        }

        .thead-light th {
            background: #e6ecf5 !important;
            font-size: 13px;
        }

        .details-heading {
            padding: 15px 18px;
            background: #ffffff;
            border-left: 5px solid #007bff;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }
    </style>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body p-4">

                    <div>
                        <h5 class="font-weight-bold mb-3">Details for CRN No: {{ $letter->crn }}</h5>
                    </div>

                    <div class="d-flex justify-content-end mb-3 no-print">
                        <button onclick="window.print()" class="btn btn-success btn-sm mr-2">
                            <i class="fa fa-print"></i> Print
                        </button>

                        <a href="{{ route('search') }}" class="btn btn-danger btn-sm">
                            <i class="fa fa-times"></i> Close
                        </a>
                    </div>

                    <div class="container mt-2">
                        <h5 class="font-weight-bold mb-3">Letter Information</h5>

                        <table class="table table-bordered table-sm mb-4 table-hover">
                            <tr>
                                <th>CRN No:</th>
                                <td>{{ $letter->crn }}</td>

                                <th>Letter No:</th>
                                <td>{{ $letter->letter_no ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th>ECR No:</th>
                                <td>{{ $letter->ecr_no ?? 'N/A' }}</td>

                                <th>Category:</th>
                                <td>
                                    {{ optional($letter->Category)->category_name ?? ($letter->letter_other_sub_categories ?? 'Others/Miscellaneous Department') }}
                                </td>
                            </tr>

                            <tr>
                                <th>Diarize Date:</th>
                                <td>{{ date('d/m/Y', strtotime($letter->diary_date)) }}</td>

                                <th>Sub Category:</th>
                                <td>
                                    {{ optional($letter->subCategory)->sub_category_name ?? ($letter->letter_other_sub_categories ?? 'Others/Miscellaneous Department') }}
                                </td>
                            </tr>

                            <tr>
                                <th>Issue Date:</th>
                                <td>{{ $letter->issue_date ? date('d/m/Y', strtotime($letter->issue_date)) : 'N/A' }}</td>

                                <th>Received Date:</th>
                                <td>{{ $letter->received_date ? date('d/m/Y', strtotime($letter->received_date)) : 'N/A' }}
                                </td>
                            </tr>

                            <tr>
                                <th>Diarized By:</th>
                                <td colspan="3">{{ $diarizedBy ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th>Subject:</th>
                                <td colspan="3">{{ $letter->subject }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="container mt-4">
                        <h5 class="font-weight-bold mb-3">Action Summary</h5>

                        <ul class="nav nav-tabs" id="letterTabs" role="tablist" style="font-size: 14px;">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tab1">Letter Movement</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab2">Letter Details</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab3">Dispatch</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab4">Close</a>
                            </li>
                        </ul>

                        <div class="tab-content">


                            <div class="tab-pane fade show active p-3" id="tab1">
                                <table class="table table-bordered table-sm table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Sent By</th>
                                            <th>Sent On</th>
                                            <th>Sent To</th>
                                            <th>Action Status</th>
                                            <th>Movement</th>
                                            <th>Remarks</th>
                                            <th>Encloser</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-3">
                                                No Action data available
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                            <div class="tab-pane fade p-3" id="tab2">
                                <table class="table table-bordered table-sm table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Letter Download</th>
                                            <th>Subject</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <a href="{{ route('pdf_view', $letter->id) }}"
                                                    class="btn btn-sm btn-primary shadow-sm" target="_blank">
                                                    Download PDF
                                                </a>
                                            </td>
                                            <td>{{ $letter->subject }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                            <div class="tab-pane fade p-3" id="tab3">
                                <table class="table table-bordered table-sm table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Dispatch Date</th>
                                            <th>Dispatched To</th>
                                            <th>Mode</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-3">
                                                No dispatch data available
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                            <div class="tab-pane fade p-3" id="tab4">

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="font-weight-bold text-primary" style="font-size: 16px;">
                                        Close Status
                                    </h6>

                                    <button class="btn btn-sm btn-primary shadow-sm" data-toggle="modal"
                                        data-target="#closeModal">
                                        <i class="fa fa-check-circle"></i> Close Letter
                                    </button>
                                </div>

                                <table class="table table-bordered table-sm table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Closed By</th>
                                            <th>Closed On</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-3">
                                                No closing data available
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                        </div>

                        <div class="text-right mt-3" style="font-size: 14px; font-weight:600; color:#2c3e50;">
                            Report Timestamp: {{ now()->format('d-m-Y, H:i') }}
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="closeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content shadow-lg" style="border-radius: 12px;">

                <div class="modal-header bg-primary text-white"
                    style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h5 class="modal-title">
                        <i class="fa fa-lock"></i> Close This Letter
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                {{-- <form action="{{ route('letter.close', $letter->id) }}" method="POST"> --}}
                <form action="" method="POST">

                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                Remarks <span class="text-danger">*</span>
                            </label>

                            <textarea name="close_remarks" class="form-control" rows="4" placeholder="Enter closing remarks..." required></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fa fa-check"></i> Submit Close
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
