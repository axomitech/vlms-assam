@extends('layouts.app')

@section('content')
    @include('layouts.header')

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- PDF Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: "Poppins", sans-serif;
            background-color: #f4f6f9;
        }



        .issue-wrapper {
            background: #ffffff;
            border-radius: 18px;
            padding: 22px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
        }

        .issue-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 1px solid #eef2f6;
        }

        .issue-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
        }

        .issue-subtitle {
            font-size: 13px;
            color: #6b7280;
        }

        .total-issue-box {
            background: linear-gradient(135deg, #026FCC, #014a94);
            color: white;
            padding: 10px 20px;
            border-radius: 12px;
            text-align: center;
            min-width: 160px;
        }

        .total-issue-box h4 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
        }

        .total-issue-box span {
            font-size: 12px;
            opacity: .9;
        }



        .category-card {
            text-decoration: none !important;
            color: inherit !important;
        }

        .small-box {
            border-radius: 14px;
            transition: all .3s ease;
            transform: scale(0.85);

        }

        .small-box:hover {
            transform: scale(0.88);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
        }

        .inner {
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            background: #ffffff;
            padding: 8px !important;
            position: relative;
        }


        .inner .d-flex {
            min-height: 70px !important;
        }


        .inner img {
            width: 36px !important;
            height: 28px !important;
        }

        .inner span {
            top: 6px !important;
            left: 6px !important;
            padding: 4px 6px !important;
        }



        .count {
            font-size: 24px;
            font-weight: 700;
            color: #026FCC;
        }

        .category-name {
            font-size: 13px;
            font-weight: 600;
            color: #1f2937;
        }


        #lettersTable {
            border-radius: 18px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
        }


        #issueSummaryCard {
            border-radius: 18px !important;
            border: 1px solid #e5e7eb !important;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05) !important;
        }
    </style>








    <div class="row mt-3">
        <div class="col-md-12 text-center">
            <button class="btn btn-dark btn-sm" id="resetView" style="float:left;">
                <i class="fa fa-arrow-left"></i> Back
            </button>
            <h4 id="selectedCategoryName"><strong>Received</strong></h4>
        </div>
    </div>



    <div class="row mt-3" id="cardsContainer">
        <div class="box-body col-md-12">
            <section class="content">
                <div class="container-fluid">

                    <div class="issue-wrapper">


                        <div class="issue-header">
                            <div>
                                <div class="issue-title">
                                    All Category Received Letters
                                </div>
                                <div class="issue-subtitle">
                                    Overview of Received letters across all categories
                                </div>
                            </div>

                            <div class="total-issue-box">
                                <h4>{{ collect($categories)->sum('count') }}</h4>
                                <span>Total Received Letters</span>
                            </div>
                        </div>


                        <div id="loading-overlay" style="display:none;text-align:center;">
                            <p>Loading...</p>
                        </div>

                        @if (session('role') > 0)
                            <div class="row">

                                @foreach ($categories as $category)
                                    @if ($loop->index % 4 == 0 && !$loop->first)
                            </div>
                            <div class="row">
                        @endif

                        <div class="col-md-3 col-sm-6 mt-3">

                            <a href="#" class="category-card" data-category-id="{{ $category->id }}"
                                data-category-name="{{ $category->category_name }}">

                                <div class="small-box mx-2">

                                    <div class="inner p-3">


                                        <span
                                            style="position:absolute;top:12px;left:12px;
                                                      background:#f1f5f9;padding:6px 8px;
                                                      border-radius:12px;">
                                            <img src="{{ asset('banoshree/images/' . strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $category->category_name)) . '.png') }}"
                                                style="width:42px;height:32px;">
                                        </span>


                                        <div class="d-flex flex-column align-items-center justify-content-center"
                                            style="min-height:110px;">

                                            <div class="count">
                                                {{ $category->count }}
                                            </div>

                                            <div class="category-name mt-2 text-center">
                                                {{ $category->category_name }}
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach

                    </div>
                    @endif

                </div>

        </div>
        </section>
    </div>
    </div>


    <div class="bg-light mt-3">
        <div class="container-fluid p-4">
            <div class="row">
                <div id="receiptSummaryCard" class="col-md-12 p-4 bg-white"
                    style="border-radius:14px;border:1px solid #e9ecef;
box-shadow:0 6px 18px rgba(0,0,0,.04);">


                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h5 class="fw-semibold mb-0">Receipts Summary</h5>

                        <div class="d-flex align-items-center gap-4">

                            <div class="d-flex align-items-center gap-2">
                                <label class="fw-semibold mb-0 text-secondary">
                                    <i class="fa fa-calendar text-primary me-1"></i> Calendar Year
                                </label></br>
                                <select id="yearSelect" class="form-select form-select-sm" style="width:120px"></select>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <label class="fw-semibold mb-0 text-secondary">
                                    <i class="fa fa-calendar-alt text-primary me-1"></i> Month
                                </label>
                                <select id="monthSelect" class="form-select form-select-sm" style="width:130px">
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>

                            <button id="downloadReceiptReport" class="btn btn-primary btn-sm px-4">
                                <i class="fa fa-download me-1"></i> Report Download
                            </button>

                        </div>
                    </div>

                    <hr>

                    <div class="d-flex align-items-start mt-4">


                        <div style="width:280px;height:280px;position:relative">
                            <canvas id="myDonutChart"></canvas>
                            <div
                                style="position:absolute;top:50%;left:50%;
transform:translate(-50%,-50%);text-align:center">
                                <p class="mb-1 text-muted fw-semibold">Total Receipts</p>
                                <h4 id="totalCount" class="fw-bold"></h4>
                            </div>
                        </div>


                        <div class="d-flex flex-grow-1 justify-content-between ms-5">

                            <ul id="labelList" style="list-style:none;padding:0;width:60%;font-weight:500;"></ul>
                            <ul id="countList"
                                style="list-style:none;padding:0;width:20%;text-align:right;font-weight:600;"></ul>
                            <ul id="percentList"
                                style="list-style:none;padding:0;width:20%;text-align:right;font-weight:600;"></ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    </section>
    </div>
    </div>

    {{-- <div class="box shadow-lg p-3 mb-5 mt-3 bg-white rounded min-vh-40" id="lettersTable" style="display: none;">
        <div class="box-body">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover" id="lettersList">
                                <thead>
                                    <tr>
                                        <th scope="col"><small><b>Sl No.</b></small></th>
                                        <th scope="col"><small><b>Diarize No.</b></small></th>
                                        <th scope="col"><small><b>Subject</b></small></th>
                                        <th scope="col"><small><b>Letter No.</b></small></th>
                                        <th scope="col"><small><b>Sender Name</b></small></th>
                                        <th scope="col"><small><b>Received Date</b></small></th>
                                        <th scope="col"><small><b>Download</b></small></th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div> --}}
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong>Assign Letter Within CMO</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card card-primary card-outline card-outline-tabs plate">
                                <div class="card-body">
                                    <iframe src="" style="width: 100%; height: 400px;" id="letter-view"></iframe>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5" id="refer-letter-div" hidden>
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-body">
                                    <iframe src="" style="width: 100%; height: 400px;"
                                        id="refer-letter-view"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="refers" class="row">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('layouts.scripts')

    <script>
        let donutChart;

        document.addEventListener("DOMContentLoaded", function() {

            const monthSelect = document.getElementById("monthSelect");
            const yearSelect = document.getElementById("yearSelect");

            const now = new Date();
            monthSelect.value = now.getMonth() + 1;

            for (let y = now.getFullYear() - 5; y <= now.getFullYear() + 5; y++) {
                let opt = document.createElement("option");
                opt.value = y;
                opt.text = y;
                if (y === now.getFullYear()) opt.selected = true;
                yearSelect.appendChild(opt);
            }

            function loadData() {
                fetch(`/dashboard/receipt-summary?month=${monthSelect.value}&year=${yearSelect.value}`)
                    .then(res => res.json())
                    .then(updateChart);
            }

            monthSelect.addEventListener("change", loadData);
            yearSelect.addEventListener("change", loadData);

            document.getElementById("downloadReceiptReport")
                .addEventListener("click", downloadPDF);

            loadData();
        });


        function updateChart(categories) {


            categories.sort((a, b) => b.count - a.count);

            const labels = categories.map(c => c.category_name);
            const data = categories.map(c => c.count);
            const total = data.reduce((a, b) => a + b, 0);

            document.getElementById('totalCount').innerText = total;

            const ctx = document.getElementById('myDonutChart').getContext('2d');

            if (donutChart) donutChart.destroy();

            const colors = [
                '#dc3545', '#198754', '#0d6efd',
                '#fd7e14', '#ffc107', '#6f42c1',
                '#20c997', '#6610f2', '#0dcaf0', '#d63384'
            ];

            donutChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels,
                    datasets: [{
                        data,
                        backgroundColor: colors
                    }]
                },
                options: {
                    cutout: '70%',
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            labelList.innerHTML = '';
            countList.innerHTML = '';
            percentList.innerHTML = '';


            labelList.innerHTML = `
        <li class="fw-bold border-bottom pb-2 mb-2 text-secondary">Labels</li>`;
            countList.innerHTML = `
        <li class="fw-bold border-bottom pb-2 mb-2 text-secondary text-end">Nos</li>`;
            percentList.innerHTML = `
        <li class="fw-bold border-bottom pb-2 mb-2 text-secondary text-end">%</li>`;

            categories.forEach((c, i) => {

                const percent = total ? ((c.count / total) * 100).toFixed(2) : 0;

                labelList.innerHTML += `
        <li class="py-2 border-bottom">
            <span style="
                display:inline-block;
                width:10px;
                height:10px;
                background:${colors[i]};
                border-radius:50%;
                margin-right:8px">
            </span>
            ${c.category_name}
        </li>`;

                countList.innerHTML += `
        <li class="py-2 border-bottom text-end">${c.count}</li>`;

                percentList.innerHTML += `
        <li class="py-2 border-bottom text-end">${percent}%</li>`;
            });
        }


        function downloadPDF() {

            const {
                jsPDF
            } = window.jspdf;
            const card = document.getElementById("receiptSummaryCard");

            html2canvas(card, {
                scale: 2
            }).then(canvas => {

                const imgData = canvas.toDataURL("image/png");
                const pdf = new jsPDF("p", "mm", "a4");

                const imgWidth = 190;
                const imgHeight = canvas.height * imgWidth / canvas.width;

                pdf.addImage(imgData, "PNG", 10, 10, imgWidth, imgHeight);

                const monthText = document.getElementById("monthSelect")
                    .options[document.getElementById("monthSelect").selectedIndex].text;

                const year = document.getElementById("yearSelect").value;

                pdf.save(`Receipts_Summary_${monthText}_${year}.pdf`);
            });
        }
    </script>

    <script>
        $(document).ready(function() {

            const dataTable = $('#lettersList').DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                buttons: ["excel", "pdf", "print"]
            });

            $('.category-card').on('click', function(e) {
                e.preventDefault();

                let categoryId = $(this).data('category-id');
                let categoryName = $(this).data('category-name');
                let url = '{{ route('receipt_by_category', ['category_id' => ':category_id']) }}'.replace(
                    ':category_id', categoryId);

                showLoading();

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {


                        $('#selectedCategoryName').html('<strong>Receipts from ' +
                            categoryName + '</strong>');
                        let tableBody = '';
                        let serialNumber = 1;


                        response.forEach(function(letter) {
                            let letterPath = letter.letter_path.replace("public/", "");
                            let truncatedSubject = letter.subject.length > 100 ?
                                `<div class="text-block" id="textBlock${letter.id}">
                            <p class="shortText text-justify text-sm">
                                ${letter.subject.substring(0, 100)}...
                                <a href="#" class="readMore" data-id="${letter.id}">Read more</a>
                            </p>
                            <div class="longText" style="display: none;">
                                <p class="text-sm text-justify">
                                    ${letter.subject}
                                    <a href="#" class="readLess" data-id="${letter.id}">Read less</a>
                                </p>
                            </div>
                        </div>` :
                                `<p>${letter.subject}</p>`;

                            tableBody += `<tr>
                        <td><small>${serialNumber++}</small></td>
                        <td>
                            <small>
                                <a href="#" class="assign-link"
                                data-id="${letter.letter_id}"
                                data-toggle="modal"
                                data-target=".bd-example-modal-lg"
                                data-letter="${letter.letter_no}"
                                data-letter_path="${url}">
                                ${letter.crn}
                                </a>
                            </small>
                            <br>Diarized By: ${letter.name}
                        </td>
                            </small>
                            <br>Diarized By: ${letter.name}
                        </td>
                        <td style="width: 30%;">${truncatedSubject}</td>
                        <td>
                            <small>
                                <b>${letter.letter_no}</b>
                                <br>
                                <b>${letter.ecr_no}</b>
                            </small>
                        </td>
                        <td><small><b>${letter.sender_name}</b></small></td>
                        <td><small>${letter.received_date}</small></td>
                        <td><small><a href="/pdf_downloadAll/${letter.letter_id}"><i class="fas fa-download" style="color: #174060"></i></a></small></td>
                    </tr>`;
                        });


                        dataTable.clear();
                        dataTable.rows.add($(tableBody));
                        dataTable.draw();


                        $('#cardsContainer').hide();
                        $('#lettersTable').show();
                        $('#resetView').show();
                        hideLoading();
                    },
                    error: function(xhr, status, error) {
                        $('#lettersList tbody').html(
                            '<tr><td colspan="7" class="text-center">Error loading data</td></tr>'
                        );
                        hideLoading();

                    }
                });
            });

            const dashboardUrl = "{{ route('dashboard') }}";


            $('#resetView').on('click', function() {

                if ($('#lettersTable').is(':visible')) {

                    $('#lettersTable').hide();
                    $('#cardsContainer').show();
                    $('#selectedCategoryName').html('<strong>Receipts</strong>');
                } else {

                    window.location.href = dashboardUrl;
                }
            });
        });
    </script>
    <script>
        $(document).on('click', '.assign-link', function() {


            let id = $(this).data('id');
            $('#letter-view').attr('src', '/download/' + id);

            $('#assign-div').show();
            $('#exampleModalLabel').html("<strong>Letter No.: " + $(this).data('letter') + "</strong>");

            $.get("{{ route('reference') }}", {
                letter: id
            }, function(j) {

                if (j.length > 1) {

                    var div = "";
                    for (var i = 1; i < j.length; i++) {

                        div += "<div class='col-md-2'>" +
                            "<a href='' class='refer-letter-link' " +
                            "data-id='" + j[i].letter_id + "'>" +
                            "<b>" + j[i].letter_no + "</b></a></div>";
                    }

                    $('#refers').html("<div class='col-md-2'>Reference Letter:</div>" + div);
                } else {
                    $('#refer-letter-div').hide();
                }
            });
        });

        $(document).on('click', '.refer-letter-link', function(e) {
            e.preventDefault();

            let id = $(this).data('id');


            $('#refer-letter-div').removeAttr("hidden").show();
            $('#refer-letter-view').attr('src', '/download/' + id);
        });
    </script>
@endsection
