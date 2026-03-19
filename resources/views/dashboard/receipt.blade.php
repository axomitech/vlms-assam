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

    <link rel="stylesheet" href="{{ asset('css/receipt-issue.css') }}">


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

                            <a class="category-card" data-category-id="{{ $category->id }}"
                                data-category-name="{{ $category->category_name }}">

                                <div class="small-box mx-2">

                                    <div class="inner p-3">

                                        <span
                                            style="position:absolute;top:12px;left:12px;
                                        background:#f1f5f9;padding:6px 8px;border-radius:12px;">
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


            <div class="row mb-3">

                <div id="receiptSummaryCard" class="col-md-12 p-4 bg-white"
                    style="border-radius:14px;border:1px solid #e9ecef;
                box-shadow:0 6px 18px rgba(0,0,0,.04);">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h5 class="fw-semibold mb-0">Receipt Summary (Month-wise)</h5>

                        <div class="d-flex align-items-center gap-4">

                            <div class="d-flex align-items-center gap-2">
                                <label class="fw-semibold mb-0 text-secondary">
                                    <i class="fa fa-calendar text-primary me-1"></i> Calendar Year
                                </label>

                                <select id="yearSelect" class="form-select form-select-sm" style="width:120px">
                                </select>
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

                                <p class="mb-1 text-muted fw-semibold">
                                    Total Receipts
                                </p>

                                <h4 id="totalCount" class="fw-bold"></h4>

                            </div>

                        </div>

                        <div class="d-flex flex-grow-1 justify-content-between ms-5">

                            <ul id="labelList" style="list-style:none;padding:0;width:60%;font-weight:500;">
                            </ul>

                            <ul id="countList"
                                style="list-style:none;padding:0;width:20%;text-align:right;font-weight:600;">
                            </ul>

                            <ul id="percentList"
                                style="list-style:none;padding:0;width:20%;text-align:right;font-weight:600;">
                            </ul>

                        </div>

                    </div>

                </div>

            </div>



            <div class="row">

                <div id="receiptSummaryCardRange" class="col-md-12 p-4 bg-white"
                    style="border-radius:14px;border:1px solid #e9ecef;
                box-shadow:0 6px 18px rgba(0,0,0,.04);">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h5 class="fw-semibold mb-0">
                            Receipt Summary (Date Range)
                        </h5>

                        <div class="d-flex align-items-center gap-4">

                            <div class="d-flex align-items-center gap-2">

                                <label class="fw-semibold mb-0 text-secondary">
                                    <i class="fa fa-calendar text-primary me-1"></i> From
                                </label>

                                <input type="date" id="fromDate" class="form-control form-control-sm"
                                    style="width:160px">

                            </div>

                            <div class="d-flex align-items-center gap-2">

                                <label class="fw-semibold mb-0 text-secondary">
                                    <i class="fa fa-calendar text-primary me-1"></i> To
                                </label>

                                <input type="date" id="toDate" class="form-control form-control-sm"
                                    style="width:160px">

                            </div>

                            <button id="searchRange" class="btn btn-primary btn-sm px-4">
                                <i class="fa fa-search me-1"></i> Search
                            </button>

                            <button id="downloadReceiptReportRange" class="btn btn-primary btn-sm px-4">
                                <i class="fa fa-download me-1"></i> Report Download
                            </button>

                        </div>

                    </div>

                    <hr>

                    <div class="d-flex align-items-start mt-4">

                        <div style="width:310px;height:310px;position:relative">

                            <canvas id="myDonutChartRange"></canvas>

                            <div
                                style="position:absolute;top:50%;left:50%;
                        transform:translate(-50%,-50%);text-align:center">

                                <p class="mb-1 text-muted fw-semibold">
                                    Total Receipts
                                </p>

                                <h4 id="totalCountRange" class="fw-bold">
                                </h4>

                            </div>

                        </div>

                        <div class="d-flex flex-grow-1 justify-content-between ms-5">

                            <ul id="labelListRange" style="list-style:none;padding:0;width:60%;font-weight:500;">
                            </ul>

                            <ul id="countListRange"
                                style="list-style:none;padding:0;width:20%;text-align:right;font-weight:600;">
                            </ul>

                            <ul id="percentListRange"
                                style="list-style:none;padding:0;width:20%;text-align:right;font-weight:600;">
                            </ul>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

    </section>
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
        let donutChartRange;

        document.addEventListener("DOMContentLoaded", function() {

            document.getElementById("searchRange").addEventListener("click", loadRangeData);
            document.getElementById("downloadReceiptReportRange")
                .addEventListener("click", downloadPDFRange);
            loadRangeData();

        });


        function loadRangeData() {

            let from = document.getElementById("fromDate").value;
            let to = document.getElementById("toDate").value;

            if (!from || !to) {

                const today = new Date();

                const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
                const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);

                const format = (date) => date.toISOString().split('T')[0];

                from = format(firstDay);
                to = format(lastDay);
            }

            fetch(`/dashboard/receipt-summary-range?from=${from}&to=${to}`)
                .then(res => res.json())
                .then(updateRangeChart);
        }


        function updateRangeChart(categories) {

            categories.sort((a, b) => b.count - a.count);

            const labels = categories.map(c => c.category_name);
            const data = categories.map(c => c.count);
            const total = data.reduce((a, b) => a + b, 0);

            document.getElementById('totalCountRange').innerText = total;

            const ctx = document.getElementById('myDonutChartRange').getContext('2d');

            if (donutChartRange) donutChartRange.destroy();

            const colors = [
                '#ff6b6b', '#4dabf7', '#51cf66',
                '#ffd43b', '#845ef7', '#ff922b',
                '#20c997', '#f06595', '#339af0', '#94d82d'
            ];

            donutChartRange = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels,
                    datasets: [{
                        data,
                        backgroundColor: colors,
                        borderColor: '#ffffff',
                        borderWidth: 3,
                        hoverOffset: 20
                    }]
                },
                options: {
                    responsive: true,
                    layout: {
                        padding: 20
                    },
                    animation: {
                        animateRotate: true,
                        animateScale: true,
                        duration: 1200,
                        easing: 'easeOutQuart'
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#111',
                            padding: 12,
                            cornerRadius: 8,
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            },
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw;
                                    const percent = total ? ((value / total) * 100).toFixed(2) : 0;
                                    return `${context.label}: ${value} (${percent}%)`;
                                }
                            }
                        }
                    }
                }
            });

            const labelList = document.getElementById('labelListRange');
            const countList = document.getElementById('countListRange');
            const percentList = document.getElementById('percentListRange');

            labelList.innerHTML = '<li class="fw-bold border-bottom pb-2 mb-2 text-secondary">Labels</li>';
            countList.innerHTML = '<li class="fw-bold border-bottom pb-2 mb-2 text-secondary text-end">Nos</li>';
            percentList.innerHTML = '<li class="fw-bold border-bottom pb-2 mb-2 text-secondary text-end">%</li>';

            categories.forEach((c, i) => {

                const percent = total ? ((c.count / total) * 100).toFixed(2) : 0;

                labelList.innerHTML += `
    <li class="py-2 border-bottom">
        <span style="display:inline-block;width:10px;height:10px;
        background:${colors[i]};border-radius:50%;margin-right:8px"></span>
        ${c.category_name}
    </li>`;

                countList.innerHTML += `
    <li class="py-2 border-bottom text-end">${c.count}</li>`;

                percentList.innerHTML += `
    <li class="py-2 border-bottom text-end">${percent}%</li>`;
            });
        }
    </script>

    <script>
        function downloadPDFRange() {

            const {
                jsPDF
            } = window.jspdf;
            const card = document.getElementById("receiptSummaryCardRange");

            html2canvas(card, {
                scale: 2
            }).then(canvas => {

                const imgData = canvas.toDataURL("image/png");
                const pdf = new jsPDF("p", "mm", "a4");

                const imgWidth = 190;
                const imgHeight = canvas.height * imgWidth / canvas.width;

                const fromDate = document.getElementById("fromDate").value;
                const toDate = document.getElementById("toDate").value;

                pdf.setFont("helvetica", "bold");
                pdf.setFontSize(16);
                pdf.text("Receipt Summary (Date Range)", 105, 15, {
                    align: "center"
                });

                pdf.setFontSize(11);
                pdf.setFont("helvetica", "normal");
                pdf.text("Department: {{ session('department') }}", 14, 22);
                pdf.text(`From: ${fromDate}  To: ${toDate}`, 140, 22);

                pdf.setDrawColor(230);
                pdf.setLineWidth(0.4);
                pdf.rect(10, 28, 190, imgHeight + 4);

                pdf.addImage(imgData, "PNG", 12, 30, imgWidth - 4, imgHeight - 4);

                const pageHeight = pdf.internal.pageSize.height;
                pdf.line(10, pageHeight - 15, 200, pageHeight - 15);

                pdf.setFontSize(10);
                pdf.setTextColor(120);

                const now = new Date();

                const day = String(now.getDate()).padStart(2, '0');
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const fullYear = now.getFullYear();

                let hours = now.getHours();
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');

                const ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12;
                hours = String(hours).padStart(2, '0');

                const formattedDateTime = `${day}:${month}:${fullYear} ${hours}:${minutes}:${seconds} ${ampm}`;

                pdf.text(
                    `Generated from eDak by : {{ Auth::user()->name }} | ${formattedDateTime}`,
                    105,
                    pageHeight - 8, {
                        align: "center"
                    }
                );

                pdf.save(`Receipts_Summary_${fromDate}_to_${toDate}.pdf`);
            });
        }
    </script>

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

            const labelList = document.getElementById('labelList');
            const countList = document.getElementById('countList');
            const percentList = document.getElementById('percentList');

            labelList.innerHTML = '<li class="fw-bold border-bottom pb-2 mb-2 text-secondary">Labels</li>';
            countList.innerHTML = '<li class="fw-bold border-bottom pb-2 mb-2 text-secondary text-end">Nos</li>';
            percentList.innerHTML = '<li class="fw-bold border-bottom pb-2 mb-2 text-secondary text-end">%</li>';

            categories.forEach((c, i) => {

                const percent = total ? ((c.count / total) * 100).toFixed(2) : 0;

                labelList.innerHTML += `
            <li class="py-2 border-bottom">
                <span style="display:inline-block;width:10px;height:10px;
                background:${colors[i]};border-radius:50%;margin-right:8px"></span>
                ${c.category_name}
            </li>`;

                countList.innerHTML += `
            <li class="py-2 border-bottom text-end">${c.count}</li>`;

                percentList.innerHTML += `
            <li class="py-2 border-bottom text-end">${percent}%</li>`;
            });
        }
    </script>
    <script>
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

                const monthText = document.getElementById("monthSelect")
                    .options[document.getElementById("monthSelect").selectedIndex].text;

                const year = document.getElementById("yearSelect").value;

                pdf.setFont("helvetica", "bold");
                pdf.setFontSize(16);
                pdf.text("Monthly Receipt Summary", 105, 15, {
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

                const day = String(now.getDate()).padStart(2, '0');
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const fullYear = now.getFullYear();

                let hours = now.getHours();
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');

                const ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12; // 0 should be 12
                hours = String(hours).padStart(2, '0');

                const formattedDateTime = `${day}:${month}:${fullYear} ${hours}:${minutes}:${seconds} ${ampm}`;

                pdf.text(
                    `Generated from eDak by : {{ Auth::user()->name }} | ${formattedDateTime}`,
                    105,
                    pageHeight - 8, {
                        align: "center"
                    }
                );

                pdf.save(`Receipts_Summary_${monthText}_${year}.pdf`);
            });
        }
    </script>
    <script>
        document.getElementById("resetView").addEventListener("click", function() {
            window.location.href = "{{ route('dashboard') }}";
        });
    </script>
@endsection
