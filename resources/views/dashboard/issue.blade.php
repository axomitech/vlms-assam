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
                <h4 id="selectedCategoryName"><strong>Issued</strong></h4>
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
                                        All Category Issue Letters
                                    </div>
                                    <div class="issue-subtitle">
                                        Overview of issued letters across all categories
                                    </div>
                                </div>

                                <div class="total-issue-box">
                                    <h4>{{ collect($categories)->sum('count') }}</h4>
                                    <span>Total Issued Letters</span>
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

                                <a class="category-card" data-category-id="{{ $category->id }}"
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



        <div class="bg-light">
            <div class="container-fluid p-4">
                <div class="row">
                    <div id="issueSummaryCard" class="col-md-12 p-4 bg-white"
                        style="border-radius:14px;border:1px solid #e9ecef;
box-shadow:0 6px 18px rgba(0,0,0,.04);">


                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-semibold mb-0">Issue Summary</h5>

                            <div class="d-flex align-items-center gap-4">

                                <div class="d-flex align-items-center gap-2">
                                    <label class="fw-semibold mb-0 text-secondary">
                                        <i class="fa fa-calendar text-primary me-1"></i> Calendar Year
                                    </label></br>
                                    <select id="issueYearSelect" class="form-select form-select-sm"
                                        style="width:120px"></select>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <label class="fw-semibold mb-0 text-secondary">
                                        <i class="fa fa-calendar-alt text-primary me-1"></i> Month
                                    </label>
                                    <select id="issueMonthSelect" class="form-select form-select-sm" style="width:130px">
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

                                <button id="downloadIssueReport" class="btn btn-primary btn-sm px-4">
                                    <i class="fa fa-download me-1"></i> Report Download
                                </button>

                            </div>
                        </div>

                        <hr>

                        <div class="d-flex align-items-start mt-4">


                            <div style="width:280px;height:280px;position:relative">
                                <canvas id="issueDonutChart"></canvas>
                                <div
                                    style="position:absolute;top:50%;left:50%;
transform:translate(-50%,-50%);text-align:center">
                                    <p class="mb-1 text-muted fw-semibold">Total Issued</p>
                                    <h4 id="issueTotalCount" class="fw-bold"></h4>
                                </div>
                            </div>


                            <div class="d-flex flex-grow-1 justify-content-between ms-5">

                                <ul id="issueLabelList" style="list-style:none;padding:0;width:60%;font-weight:500;"></ul>
                                <ul id="issueCountList"
                                    style="list-style:none;padding:0;width:20%;text-align:right;font-weight:600;"></ul>
                                <ul id="issuePercentList"
                                    style="list-style:none;padding:0;width:20%;text-align:right;font-weight:600;"></ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        </div>


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
                                        <iframe src="" style="width: 100%; height: 400px;"
                                            id="letter-view"></iframe>
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
            let issueChart;

            document.addEventListener("DOMContentLoaded", function() {

                const monthSelect = document.getElementById("issueMonthSelect");
                const yearSelect = document.getElementById("issueYearSelect");

                const now = new Date();
                monthSelect.value = now.getMonth() + 1;

                for (let y = now.getFullYear() - 5; y <= now.getFullYear() + 5; y++) {
                    const opt = document.createElement("option");
                    opt.value = y;
                    opt.text = y;
                    if (y === now.getFullYear()) opt.selected = true;
                    yearSelect.appendChild(opt);
                }

                function loadIssueData() {
                    fetch(`/dashboard/issue-summary?month=${monthSelect.value}&year=${yearSelect.value}`)
                        .then(res => res.json())
                        .then(updateIssueChart);
                }

                monthSelect.addEventListener("change", loadIssueData);
                yearSelect.addEventListener("change", loadIssueData);

                document.getElementById("downloadIssueReport")
                    .addEventListener("click", downloadPDF);

                loadIssueData();
            });


            function updateIssueChart(categories) {


                categories.sort((a, b) => b.count - a.count);

                const labels = categories.map(c => c.category_name);
                const data = categories.map(c => c.count);
                const total = data.reduce((a, b) => a + b, 0);

                document.getElementById('issueTotalCount').innerText = total;

                const ctx = document.getElementById('issueDonutChart').getContext('2d');

                if (issueChart) issueChart.destroy();

                const colors = [
                    '#dc3545', '#198754', '#0d6efd',
                    '#fd7e14', '#ffc107', '#6f42c1',
                    '#20c997', '#6610f2', '#0dcaf0', '#d63384'
                ];

                issueChart = new Chart(ctx, {
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

                issueLabelList.innerHTML = '';
                issueCountList.innerHTML = '';
                issuePercentList.innerHTML = '';


                issueLabelList.innerHTML = `
        <li class="fw-bold border-bottom pb-2 mb-2 text-secondary">Labels</li>`;
                issueCountList.innerHTML = `
        <li class="fw-bold border-bottom pb-2 mb-2 text-secondary text-end">Nos</li>`;
                issuePercentList.innerHTML = `
        <li class="fw-bold border-bottom pb-2 mb-2 text-secondary text-end">%</li>`;

                categories.forEach((c, i) => {

                    const percent = total ? ((c.count / total) * 100).toFixed(2) : 0;

                    issueLabelList.innerHTML += `
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

                    issueCountList.innerHTML += `
        <li class="py-2 border-bottom text-end">${c.count}</li>`;

                    issuePercentList.innerHTML += `
        <li class="py-2 border-bottom text-end">${percent}%</li>`;
                });
            }


            function downloadPDF() {

                const {
                    jsPDF
                } = window.jspdf;
                const card = document.getElementById("issueSummaryCard");

                html2canvas(card, {
                    scale: 2
                }).then(canvas => {

                    const imgData = canvas.toDataURL("image/png");
                    const pdf = new jsPDF("p", "mm", "a4");

                    const imgWidth = 190;
                    const imgHeight = canvas.height * imgWidth / canvas.width;

                    pdf.addImage(imgData, "PNG", 10, 10, imgWidth, imgHeight);

                    const monthText = document.getElementById("issueMonthSelect")
                        .options[document.getElementById("issueMonthSelect").selectedIndex].text;

                    const year = document.getElementById("issueYearSelect").value;

                    pdf.save(`Issue_Summary_${monthText}_${year}.pdf`);
                });
            }
        </script>

        <script>
            function downloadPDF() {

                const {
                    jsPDF
                } = window.jspdf;
                const card = document.getElementById("issueSummaryCard");

                html2canvas(card, {
                    scale: 2
                }).then(canvas => {

                    const imgData = canvas.toDataURL("image/png");
                    const pdf = new jsPDF("p", "mm", "a4");

                    const imgWidth = 190;
                    const imgHeight = canvas.height * imgWidth / canvas.width;

                    const monthText = document.getElementById("issueMonthSelect")
                        .options[document.getElementById("issueMonthSelect").selectedIndex].text;

                    const year = document.getElementById("issueYearSelect").value;


                    pdf.setFont("helvetica", "bold");
                    pdf.setFontSize(16);
                    pdf.text("Monthly Issue Summary", 105, 15, {
                        align: "center"
                    });

                    pdf.setFontSize(11);
                    pdf.setFont("helvetica", "normal");
                    pdf.text("Department: {{ session('department') }}", 14, 22);
                    pdf.text(`Month: ${monthText} ${year}`, 150, 22);


                    pdf.setDrawColor(230);
                    pdf.setLineWidth(0.4);
                    pdf.rect(10, 28, 190, imgHeight + 4);


                    pdf.addImage(imgData, "PNG", 12, 30, imgWidth - 4, imgHeight - 4);


                    const pageHeight = pdf.internal.pageSize.height;
                    pdf.line(10, pageHeight - 15, 200, pageHeight - 15);

                    pdf.setFontSize(10);
                    pdf.setTextColor(120);

                    const now = new Date();
                    const formattedDateTime = now.toLocaleString();

                    pdf.text(
                        `Generated from eDak by : {{ Auth::user()->name }} | ${formattedDateTime}`,
                        105,
                        pageHeight - 8, {
                            align: "center"
                        }
                    );

                    pdf.save(`Issue_Summary_${monthText}_${year}.pdf`);
                });
            }
        </script>
    @endsection
