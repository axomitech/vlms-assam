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


        .user-details {
            color: #0d6efd;
            text-decoration: none;
            cursor: pointer;
        }

        @media print {

            @page {
                margin: 20mm;
            }

            .user-details {
                text-decoration: none !important;
                color: black !important;
                pointer-events: none !important;
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


        .eoffice-popup {
            position: absolute;
            width: 480px;
            background: #fff;
            border: 2px solid #3b82f6;
            border-radius: 3px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
            z-index: 9999;
            font-size: 14px;
        }

        .popup-header {
            background: #f1f3f5;
            padding: 6px 10px;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ccc;
        }

        .popup-close {
            cursor: pointer;
            font-size: 14px;
            background: #e0e0e0;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            text-align: center;
            line-height: 18px;
        }

        .popup-close:hover {
            background: #d00000;
            color: #fff;
        }

        .popup-body {
            padding: 8px;
        }

        .popup-table {
            width: 100%;
            border-collapse: collapse;
        }

        .popup-table td {
            border: 1px solid #dee2e6;
            padding: 6px 8px;
        }

        .popup-table .label {
            background: #f8f9fa;
            font-weight: 600;
            width: 35%;
        }

        .badge-sent {
            background-color: #3b82f6;
            color: #fff;
            border-radius: 16px;
            padding: 5px 10px;
            font-size: 12px;
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


                    <table class="table table-bordered table-sm table-hover mb-4">
                        <tbody>

                            <tr>
                                <th width="15%">CRN No</th>
                                <td width="35%">{{ $letter->crn }}</td>
                                <th width="15%">Letter No</th>
                                <td width="35%">{{ $letter->letter_no ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th>Category</th>
                                <td>{{ optional($letter->Category)->category_name ?? 'N/A' }}</td>
                                <th>Sub Category</th>
                                <td>{{ optional($letter->subCategory)->sub_category_name ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th>Diarize Date</th>
                                <td>{{ date('d/m/Y', strtotime($letter->diary_date)) }}</td>
                                <th>Diarized By</th>
                                <td>{{ $diarizedBy ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th>Received Date</th>
                                <td>{{ $letter->received_date ? date('d/m/Y', strtotime($letter->received_date)) : 'N/A' }}
                                </td>
                                <th>ECR No</th>
                                <td>{{ $letter->ecr_no ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th>Issue Date</th>
                                <td>{{ $letter->issue_date ? date('d/m/Y', strtotime($letter->issue_date)) : 'N/A' }}</td>
                                <th>Letter Type</th>
                                <td>
                                    @if ($letter->issue_date)
                                        Issue Letter
                                    @elseif($letter->received_date)
                                        Received Letter
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Subject</th>
                                <td>{{ $letter->subject }}</td>
                                <th>Letter</th>
                                <td>
                                    <a href="{{ route('pdf_view', $letter->id) }}"
                                        class="btn btn-sm btn-outline-primary shadow-sm" target="_blank">
                                        <i class="fa fa-file-pdf"></i> Download PDF
                                    </a>
                                </td>
                            </tr>

                        </tbody>
                    </table>


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
                                                        $badgeClass = 'badge-sent';
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
                                                <td>
                                                    @if ($move->sender_id)
                                                        <a href="javascript:void(0)" class="user-details text-primary"
                                                            data-id="{{ $move->sender_id }}">
                                                            {{ $move->sender_name }}
                                                        </a>
                                                    @else
                                                        {{ $move->sender_name }}
                                                    @endif
                                                </td>

                                                <td>
                                                    {{ $move->sent_on ? date('d/m/Y h:i A', strtotime($move->sent_on)) : '' }}
                                                </td>

                                                <td>
                                                    @if ($move->receiver_id)
                                                        <a href="javascript:void(0)" class="user-details text-primary"
                                                            data-id="{{ $move->receiver_id }}">
                                                            {{ $move->receiver_name }}
                                                        </a>
                                                    @else
                                                        {{ $move->receiver_name }}
                                                    @endif
                                                </td>

                                                <td>
                                                    <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                                                </td>

                                                <td>{{ $move->action_description }}</td>

                                                <td>{{ $move->action_remarks }}</td>

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

    <div id="userInfoBox" class="eoffice-popup" style="display:none;">

        <div class="popup-header">
            <span>User Details</span>
            <span class="popup-close" onclick="closeUserBox()">×</span>
        </div>

        <div class="popup-body">
            <table class="popup-table">
                <tr>
                    <td class="label">Name</td>
                    <td id="infoName"></td>
                </tr>
                <tr>
                    <td class="label">Department</td>
                    <td id="infoDepartment"></td>
                </tr>
                <tr>
                    <td class="label">Role</td>
                    <td id="infoRole"></td>
                </tr>
            </table>
        </div>

    </div>


    <script>
        document.querySelectorAll(".user-details").forEach(function(element) {

            element.addEventListener("click", function(e) {

                let userId = this.getAttribute("data-id");
                let box = document.getElementById("userInfoBox");

                fetch('/user-details/' + userId)
                    .then(response => response.json())
                    .then(data => {

                        document.getElementById("infoName").innerText = data.user_name;
                        document.getElementById("infoDepartment").innerText = data.department_name;
                        document.getElementById("infoRole").innerText = data.role_name;

                        box.style.display = "block";

                        let rect = this.getBoundingClientRect();
                        let boxHeight = box.offsetHeight;
                        let windowHeight = window.innerHeight;

                        let topPosition;

                        if (rect.bottom + boxHeight > windowHeight) {
                            topPosition = window.scrollY + rect.top - boxHeight - 5;
                        } else {
                            topPosition = window.scrollY + rect.bottom + 5;
                        }

                        box.style.top = topPosition + "px";
                        box.style.left = (window.scrollX + rect.left) + "px";
                    });
            });

        });

        function closeUserBox() {
            document.getElementById("userInfoBox").style.display = "none";
        }

        document.addEventListener("click", function(event) {
            let box = document.getElementById("userInfoBox");
            if (!event.target.closest(".user-details") &&
                !event.target.closest("#userInfoBox")) {
                box.style.display = "none";
            }
        });
    </script>
@endsection
