@extends('layouts.app')

@section('title', 'Letter Details Report - ' . $letter->crn)

@section('content')

    <link rel="stylesheet" href="{{ asset('css/letter-details.css') }}">

    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            font-size: 13px;
        }

        .badge {
            padding: 6px 12px;
            font-size: 11px;
            border-radius: 20px;
            font-weight: 600;
            display: inline-block;
            color: #fff !important;
        }

        .badge-primary {
            background-color: #0d6efd !important;
        }

        .badge-info {
            background-color: #0dcaf0 !important;
        }

        .badge-secondary {
            background-color: #6c757d !important;
        }

        .badge-warning {
            background-color: #ffc107 !important;
            color: #000 !important;
        }

        .badge-success {
            background-color: #198754 !important;
        }

        .badge-dark {
            background-color: #212529 !important;
        }

        .section-title {
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 2px solid #e9ecef;
            color: #2c3e50;
        }

        table {
            font-size: 12.5px;
        }

        th {
            background: #f1f3f5;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: .5px;
        }

        td,
        th {
            vertical-align: middle !important;
        }

        .pdf-header,
        .pdf-footer {
            display: none;
        }

        @media print {

            @page {
                margin: 20mm;
            }

            body::after {
                content: "Page " counter(page) " of " counter(pages);
                position: fixed;
                bottom: 10px;
                right: 20px;
                font-size: 12px;
                color: #495057;
            }

            .no-print {
                display: none !important;
            }

            .pdf-header,
            .pdf-footer {
                display: block !important;
            }

            .pdf-header {
                text-align: center;
                margin-bottom: 25px;
                padding-bottom: 12px;
                border-bottom: 2px solid #dee2e6;
            }

            .pdf-header h2 {
                margin: 0;
                font-size: 20px;
                font-weight: 700;
                letter-spacing: 1px;
                color: #2c3e50;
            }

            .pdf-header .sub-title {
                font-size: 13px;
                margin-top: 5px;
                color: #6c757d;
            }

            .pdf-footer {
                margin-top: 40px;
                padding-top: 12px;
                border-top: 1px solid #dee2e6;
                font-size: 12px;
                color: #495057;
            }

            .pdf-footer table {
                width: 100%;
            }

            .badge {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .card {
                box-shadow: none !important;
                border: none !important;
            }
        }
    </style>


    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body p-4">

                    <div class="pdf-header">
                        <h2>Letter Details Report</h2>
                        <div class="sub-title">
                            Official Letter Movement & Action Summary
                        </div>
                    </div>

                    <h5 class="font-weight-bold mb-3">
                        Details for CRN No: {{ $letter->crn }}
                    </h5>

                    <div class="d-flex justify-content-end mb-3 no-print">
                        <button onclick="window.print()" class="btn btn-success btn-sm mr-2">
                            <i class="fa fa-print"></i> Print
                        </button>
                        <a href="{{ route('search') }}" class="btn btn-danger btn-sm">
                            <i class="fa fa-times"></i> Close
                        </a>
                    </div>

                    <div class="section-title">Letter Information</div>

                    <table class="table table-bordered table-sm mb-4">
                        <tr>
                            <th width="15%">CRN No</th>
                            <td width="35%">{{ $letter->crn }}</td>
                            <th width="15%">Letter No</th>
                            <td width="35%">{{ $letter->letter_no ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>ECR No</th>
                            <td>{{ $letter->ecr_no ?? 'N/A' }}</td>
                            <th>Category</th>
                            <td>{{ optional($letter->Category)->category_name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Diarize Date</th>
                            <td>{{ date('d/m/Y', strtotime($letter->diary_date)) }}</td>
                            <th>Sub Category</th>
                            <td>{{ optional($letter->subCategory)->sub_category_name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Issue Date</th>
                            <td>{{ $letter->issue_date ? date('d/m/Y', strtotime($letter->issue_date)) : 'N/A' }}</td>
                            <th>Received Date</th>
                            <td>{{ $letter->received_date ? date('d/m/Y', strtotime($letter->received_date)) : 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Letter</th>
                            <td>
                                <a href="{{ route('pdf_view', $letter->id) }}" class="btn btn-sm btn-primary shadow-sm"
                                    target="_blank">
                                    Download PDF
                                </a>
                            </td>
                            <th>Subject</th>
                            <td>{{ $letter->subject }}</td>
                        </tr>
                        <tr>
                            <th>Diarized By</th>
                            <td colspan="3">{{ $diarizedBy ?? 'N/A' }}</td>
                        </tr>
                    </table>


                    <ul class="nav nav-tabs no-print" id="letterTabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tab1">Letter Movement</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab4">Close</a>
                        </li>
                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane fade show active p-3" id="tab1">

                            <div class="section-title">Action Summary</div>

                            <table class="table table-bordered table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Sent By</th>
                                        <th>Sent On</th>
                                        <th>Sent To</th>
                                        <th>Status</th>
                                        <th>Movement</th>
                                        <th>Remarks</th>
                                        <th>Encloser</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($movements) && $movements->count() > 0)
                                        @foreach ($movements as $move)
                                            @php
                                                $status = $move->status_name ?? 'Pending';
                                                switch ($status) {
                                                    case 'Diarized':
                                                        $badgeClass = 'badge-primary';
                                                        break;
                                                    case 'Finalized':
                                                        $badgeClass = 'badge-info';
                                                        break;
                                                    case 'Sent':
                                                        $badgeClass = 'badge-secondary';
                                                        break;
                                                    case 'In Process':
                                                        $badgeClass = 'badge-warning';
                                                        break;
                                                    case 'Completed':
                                                        $badgeClass = 'badge-success';
                                                        break;
                                                    case 'Archived':
                                                        $badgeClass = 'badge-dark';
                                                        break;
                                                    default:
                                                        $badgeClass = 'badge-secondary';
                                                }
                                            @endphp
                                            <tr>
                                                <td>{{ $move->sender_name ?? 'N/A' }}</td>
                                                <td>{{ $move->sent_on ? date('d/m/Y h:i A', strtotime($move->sent_on)) : 'N/A' }}
                                                </td>
                                                <td>{{ $move->receiver_name ?? 'N/A' }}</td>
                                                <td><span class="badge {{ $badgeClass }}">{{ $status }}</span>
                                                </td>
                                                <td>{{ $move->action_description ?? 'N/A' }}</td>
                                                <td>{{ $move->action_remarks ?? 'N/A' }}</td>
                                                <td>
                                                    @if (isset($move->attachments) && count($move->attachments) > 0)
                                                        @foreach ($move->attachments as $file)
                                                            @php
                                                                $cleanPath = str_replace(
                                                                    'public/',
                                                                    '',
                                                                    $file->response_attachment,
                                                                );
                                                            @endphp

                                                            <a href="{{ asset('storage/' . $cleanPath) }}" target="_blank"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="fa fa-file-pdf"></i> View PDF
                                                            </a>
                                                        @endforeach
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-3">
                                                No Action data available
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                        </div>

                        <div class="tab-pane fade p-3" id="tab4">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="font-weight-bold text-primary" style="font-size:16px;">
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

                    <div class="pdf-footer">
                        <table>
                            <tr>
                                <td style="text-align:left;">
                                    <div style="font-weight:600;">Generated By</div>
                                    {{ auth()->user()->name ?? 'System' }}
                                </td>
                                <td style="text-align:right;">
                                    <div style="font-weight:600;">Report Generated On</div>
                                    {{ now()->format('d-m-Y, h:i A') }}
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="closeModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg" style="border-radius:12px;">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fa fa-lock"></i> Close This Letter
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

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
