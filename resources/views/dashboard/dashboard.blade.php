@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    @include('layouts.header')
    <div class="row">
        <div class="col-md-12 text-center py-2">
            <h4><strong> <i class="fa-solid fa-chart-line me-2 text-dark" style="font-size: 20px;"></i>Dashboard</strong>
            </h4>
        </div>
    </div>

    <div class="row mt-1">
        <div class="col-md-12">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">

                        @if (session('role_dept') == 1)
                            <div class="col-md-3 col-sm-6 mb-3">
                                <a href="{{ route('receipt_box') }}">
                                    <div class="dashboard-box bg-received">
                                        <div class="row">
                                            <div class="col-8">
                                                <h3>{{ $receipt_count }}</h3>
                                                <h3>Overall Dak Received</h3>
                                            </div>
                                            <div class="col-4 p-0">
                                                <img src="{{ asset('banoshree/images/dakrecieved.png') }}"
                                                    alt="Dak Received">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3 col-sm-6 mb-3">
                                <a href="{{ route('issue_box') }}">
                                    <div class="dashboard-box bg-issued">
                                        <div class="row">
                                            <div class="col-8">
                                                <h3>{{ $issue_count }}</h3>
                                                <h3>Overall Issued</h3>
                                            </div>
                                            <div class="col-4 p-0">
                                                <img src="{{ asset('banoshree/images/issued.png') }}" alt="Dak Issued">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="dashboard-box bg-total-letter">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <h3>{{ $diarized_count }}</h3>
                                            <h3>Overall Total Letters</h3>
                                        </div>
                                        <div class="col-4 text-end">
                                            <span style="font-size:45px;">📩</span>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>

                            <div class="col-md-3 col-sm-6 mb-3">
                                <a href="{{ route('action_box') }}">
                                    <div class="dashboard-box bg-action">
                                        <div class="row">
                                            <div class="col-8">
                                                <h3>{{ $action_count }}</h3>
                                                <h3>Overall Action Taken</h3>
                                            </div>
                                            <div class="col-4 p-0">
                                                <img src="{{ asset('banoshree/images/actiontaken.png') }}"
                                                    alt="Dak Action">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3 col-sm-6 mb-3">
                                <a href="{{ route('letters', [encrypt(0), 'archive']) }}">
                                    <div class="dashboard-box bg-archive">
                                        <div class="row">
                                            <div class="col-8">
                                                <h3>{{ $archive_count }}</h3>
                                                <h3>Overall Archived</h3>
                                            </div>
                                            <div class="col-4 p-0">
                                                <img src="{{ asset('banoshree/images/archived_dak.png') }}"
                                                    alt="Dak Archived">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif

                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="{{ route('letters', [encrypt(0), 'tab' => 'inbox']) }}">
                                <div class="dashboard-box bg-light-box">
                                    <div class="row">
                                        <div class="col-8">
                                            <h3>{{ $inbox_count }}</h3>
                                            <h3>My Inbox</h3>
                                        </div>
                                        <div class="col-4 p-0">
                                            <img src="{{ asset('banoshree/images/inbox64x64.png') }}" alt="Dak Inbox">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        @if (session('role_dept') == 1)
                            <div class="col-md-3 col-sm-6 mb-3">
                                <a href="{{ route('letters', [encrypt(0), 'tab' => 'sent']) }}">
                                    <div class="dashboard-box bg-light-box">
                                        <div class="row">
                                            <div class="col-8">
                                                <h3>{{ $sent_count }}</h3>
                                                <h3>My Sent Items</h3>
                                            </div>
                                            <div class="col-4 p-0">
                                                <img src="{{ asset('banoshree/images/sent64x64.png') }}" alt="Dak Sent">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif

                        @if (session('role_dept') > 1)
                            <div class="col-md-3 col-sm-6 mb-3">
                                <a href="{{ route('letters', [encrypt(0), 'tab' => 'action']) }}">
                                    <div class="dashboard-box bg-light-box">
                                        <div class="row">
                                            <div class="col-8">
                                                <h3>{{ $action_count }}</h3>
                                                <h3>Action Taken</h3>
                                            </div>
                                            <div class="col-4 p-0">
                                                <img src="{{ asset('banoshree/images/actiontaken.png') }}"
                                                    alt="Dak Action">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3 col-sm-6 mb-3">
                                <a href="{{ route('letters', [encrypt(0), 'tab' => 'process']) }}">
                                    <div class="dashboard-box bg-light-box">
                                        <div class="row">
                                            <div class="col-8">
                                                <h3>{{ $in_process_count }}</h3>
                                                <h3>In Process</h3>
                                            </div>
                                            <div class="col-4 p-0">
                                                <img src="{{ asset('banoshree/images/process.png') }}" alt="In Process">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3 col-sm-6 mb-3">
                                <a href="{{ route('letters', [encrypt(0), 'tab' => 'completed']) }}">
                                    <div class="dashboard-box bg-light-box">
                                        <div class="row">
                                            <div class="col-8">
                                                <h3>{{ $completed_count }}</h3>
                                                <h3>Completed</h3>
                                            </div>
                                            <div class="col-4 p-0">
                                                <img src="{{ asset('banoshree/images/completed.png') }}" alt="Completed">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif

                    </div>
                </div>
            </section>
        </div>
    </div>
    @if (session('role_dept') == 1)
        @php
            $currentMonth = request('month', date('n'));
            $currentYear = request('year', date('Y'));
            $monthNames = [
                1 => 'January',
                2 => 'February',
                3 => 'March',
                4 => 'April',
                5 => 'May',
                6 => 'June',
                7 => 'July',
                8 => 'August',
                9 => 'September',
                10 => 'October',
                11 => 'November',
                12 => 'December',
            ];
        @endphp

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

        <div class="row">
            <div class="col-md-7 col-sm-12">
                <div class="box">
                    <h5 class="section-heading mb-3" style="font-size: 20px; color: #007bff;">
                        <i class="fas fa-chart-pie me-2"></i>Overview
                    </h5>
                    <div class="row align-items-start">
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label class="modern-label">📅 Calendar Year</label>
                                <select id="yearSelect" class="modern-select shadow-sm">
                                    <option value="all" {{ $currentYear == 'all' ? 'selected' : '' }}>📊 OverAll
                                    </option>
                                    @for ($year = date('Y'); $year >= 2020; $year--)
                                        <option value="{{ $year }}"
                                            {{ $year == $currentYear ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div id="monthSection">
                                <div class="mb-3">
                                    <label class="modern-label">📆 Month</label>
                                    <select id="monthSelect" class="modern-select shadow-sm">
                                        @foreach ($monthNames as $monthNum => $monthName)
                                            <option value="{{ $monthNum }}"
                                                {{ $monthNum == $currentMonth ? 'selected' : '' }}>
                                                {{ $monthName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button id="viewDataButton" onclick="handleViewDataClick()" class="btn-view-data">
                                    📊 View
                                </button>
                            </div>
                        </div>

                        <div class="col-md-7 d-flex justify-content-center align-items-center">
                            <div id="myPieChart"></div>
                        </div>

                        <div class="col-12 mt-3">
                            <ul id="legend" style="list-style: none; padding: 0;">
                                <li class="mb-2">
                                    <span class="legend-color-box" style="background-color: #379FFF;"></span>
                                    <a href="{{ route('receipt_box') }}">Received</a>
                                </li>
                                <li class="mb-2">
                                    <span class="legend-color-box" style="background-color: #42B518;"></span>
                                    <a href="{{ route('action_box') }}">Action Taken</a>
                                </li>
                                <li class="mb-2">
                                    <span class="legend-color-box" style="background-color: #DE6909;"></span>
                                    <a href="{{ route('issue_box') }}">Issued</a>
                                </li>
                                <li class="mb-2">
                                    <span class="legend-color-box" style="background-color: #BF9203;"></span>
                                    <a href="{{ route('letters', [encrypt(0), 'archive']) }}">Archived</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="box">
                    <h5 class="section-heading" style="font-size: 20px; color: #007bff;"> 📊Overview of Receipt</h5>
                    <div>
                        <h2 id="totalCount" style="font-weight: bold; color: #333;"></h2>
                        <h6 id="monthLabel" style="color: #8b8383;"></h6>
                    </div>
                    <div style="max-width: 800px; margin: auto;">
                        <canvas id="weekBarChart" height="300"></canvas>
                    </div>
                    <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
                        <div class="legend-item" style="--color:#E55674;">President's Secretariat</div>
                        <div class="legend-item" style="--color:#3090CF;">PMO</div>
                        <div class="legend-item" style="--color:#E07D38;">Union Minister</div>
                        <div class="legend-item" style="--color:#8759E6;">GoI/Ministry/Department</div>
                        <div class="legend-item" style="--color:#E6B84B;">MP</div>
                        <div class="legend-item" style="--color:#285CAB;">Foreign Delegates</div>
                        <div class="legend-item" style="--color:#D0D2D7;">MLA</div>
                        <div class="legend-item" style="--color:#a451a5;">Governor's Secretariat</div>
                        <div class="legend-item" style="--color:#CC8136;">GoA Department</div>
                        <div class="legend-item" style="--color:#42A7A7;">Supreme Court/High Court</div>
                        <div class="legend-item" style="--color:#CC5170;">Others/Miscellaneous</div>
                    </div>
                </div>
            </div>

            <div class="col-md-5 col-sm-12">
                <div class="box">
                    <h5 class="section-heading" style="font-size: 20px; color: #007bff;">📈Source Summary</h5>
                    <div class="d-flex justify-content-center">
                        <canvas id="dakPieChart" width="100%" height="250"></canvas>
                    </div>
                    <div id="category-list" class="mt-3"></div>
                </div>
            </div>
        </div>

        <script>
            const monthSelect = document.getElementById('monthSelect');
            const yearSelect = document.getElementById('yearSelect');
            const viewButton = document.getElementById('viewDataButton');

            function updateButtonLabel() {
                const year = yearSelect.value;
                const month = monthSelect.options[monthSelect.selectedIndex]?.text;
                if (year === 'all') {
                    viewButton.innerHTML = `📊 View`;
                } else {
                    viewButton.innerHTML = `📊 View`;
                }
            }

            function handleViewDataClick() {
                const year = yearSelect.value;
                const month = monthSelect.value;
                let url = `/letters/filter/year/${year}`;
                if (year !== 'all') {
                    url += `/month/${month}`;
                }
                window.location.href = url;
            }

            function redirectToUpdatedDashboard() {
                const year = yearSelect.value;
                const month = monthSelect.value;
                if (year === 'all') {
                    window.location.href = `?year=all`;
                } else {
                    window.location.href = `?year=${year}&month=${month}`;
                }
            }

            function toggleMonthVisibility() {
                const year = yearSelect.value;
                const monthSection = document.getElementById('monthSection');
                if (year === 'all') {
                    monthSection.style.display = 'none';
                    viewButton.style.display = 'none';
                } else {
                    monthSection.style.display = 'block';
                    viewButton.style.display = 'block';
                }
            }

            yearSelect.addEventListener('change', () => {
                toggleMonthVisibility();
                updateButtonLabel();
                redirectToUpdatedDashboard();
            });

            monthSelect.addEventListener('change', () => {
                updateButtonLabel();
                redirectToUpdatedDashboard();
            });

            updateButtonLabel();
            toggleMonthVisibility();
        </script>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {
                packages: ['corechart']
            });
            google.charts.setOnLoadCallback(drawPieChart);

            function drawPieChart() {
                const receiptCount = {{ $receipt_count }};
                const issueCount = {{ $issue_count }};
                const archiveCount = {{ $archive_count }};

                const data = google.visualization.arrayToDataTable([
                    ['Status', 'Count'],
                    ['Received', receiptCount],
                    ['Issued', issueCount],
                    ['Archived', archiveCount]
                ]);

                const options = {
                    pieHole: 0,
                    legend: 'none',
                    pieSliceText: 'percentage',
                    pieSliceTextStyle: {
                        color: 'white',
                        fontSize: 16,
                        bold: true
                    },
                    chartArea: {
                        width: '100%',
                        height: '100%'
                    },
                    backgroundColor: 'transparent',
                    colors: ['#3366cc', '#dc3912', '#ff9900'],
                    tooltip: {
                        text: 'percentage'
                    },
                    fontName: 'Segoe UI'
                };

                const chart = new google.visualization.PieChart(document.getElementById('myPieChart'));
                chart.draw(data, options);
            }
        </script>
    @endif
@endsection
@section('scripts')
    @include('layouts.scripts')

    <script>
        let originalDatasets = [];
        let activeCategoryLabels = new Set();
        let chartInstance;

        function setupInteractiveLegend(chartInstance) {
            const legendItems = document.querySelectorAll('.legend-item');

            legendItems.forEach(item => {
                const label = item.innerText.trim();
                activeCategoryLabels.add(label);
                item.style.cursor = 'pointer';
                item.style.opacity = 1;

                item.addEventListener('click', () => {
                    if (activeCategoryLabels.has(label)) {
                        activeCategoryLabels.delete(label);
                        item.style.opacity = 0.4;
                    } else {
                        activeCategoryLabels.add(label);
                        item.style.opacity = 1;
                    }

                    const filtered = originalDatasets.filter(ds =>
                        activeCategoryLabels.has(ds.label)
                    );

                    chartInstance.data.datasets = filtered;
                    chartInstance.update();
                });
            });
        }

        function initializeWeekBarChart(data) {
            const ctxWeekChart = document.getElementById('weekBarChart').getContext('2d');

            const categoryColors = {
                1: '#E55674',
                2: '#3090CF',
                3: '#E07D38',
                4: '#E6B84B',
                5: '#D0D2D7',
                6: '#42A7A7',
                7: '#8759E6',
                8: '#CC8136',
                9: '#a451a5',
                10: '#CC5170',
                11: '#285CAB'
            };

            const monthMap = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            const today = new Date();
            const currentMonthName = monthMap[today.getMonth()];
            // document.getElementById('monthLabel').innerText = `Month: ${currentMonthName}`;

            const weekLabels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'].map(week => `${week} `);
            const categoryMap = {};
            let totalCount = 0;

            data.forEach(entry => {
                const week = parseInt(entry.week_of_month);
                const categoryId = parseInt(entry.letter_category_id);
                const count = parseInt(entry.count);
                const categoryName = entry.category_name;

                totalCount += count;

                if (!categoryMap[categoryId]) {
                    categoryMap[categoryId] = {
                        label: categoryName,
                        data: [0, 0, 0, 0],
                        backgroundColor: categoryColors[categoryId] || '#999'
                    };
                }

                if (week >= 1 && week <= 4) {
                    categoryMap[categoryId].data[week - 1] += count;
                }
            });

            const datasets = Object.values(categoryMap).map(dataset => ({
                ...dataset,
                barThickness: 20,
                categoryPercentage: 0.8,
                barPercentage: 0.7
            }));

            chartInstance = new Chart(ctxWeekChart, {
                type: 'bar',
                data: {
                    labels: weekLabels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: true,
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Total Letters',
                                color: '#444',
                                font: {
                                    weight: 'bold',
                                    size: 12
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.dataset.label}: ${context.parsed.y}`;
                                }
                            }
                        },
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // Deep clone to prevent mutation
            originalDatasets = datasets.map(ds => ({
                ...ds,
                data: [...ds.data]
            }));

            setupInteractiveLegend(chartInstance);
            document.getElementById('totalCount').innerText = totalCount;


            document.getElementById('weekBarChart').onclick = function(evt) {
                const points = chartInstance.getElementsAtEventForMode(evt, 'nearest', {
                    intersect: true
                }, true);

                if (points.length) {
                    const firstPoint = points[0];
                    const datasetIndex = firstPoint.datasetIndex;
                    const weekIndex = firstPoint.index;
                    const dataset = chartInstance.data.datasets[datasetIndex];

                    const categoryLabel = dataset.label;
                    const value = dataset.data[weekIndex];

                    if (value > 0) {
                        const filteredDataset = originalDatasets.find(ds => ds.label === categoryLabel);
                        if (filteredDataset) {
                            chartInstance.data.datasets = [filteredDataset];
                            chartInstance.update();
                        }

                        document.querySelectorAll('.legend-item').forEach(item => {
                            const label = item.innerText.trim();
                            item.style.opacity = label === categoryLabel ? 1 : 0.4;
                        });

                        activeCategoryLabels.clear();
                        activeCategoryLabels.add(categoryLabel);
                    }
                }
            };
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const monthSelect = document.getElementById("monthSelect");
            const overviewMonthLabel = document.createElement("h6");
            overviewMonthLabel.style.color = "#8b8383";
            overviewMonthLabel.style.paddingLeft = "5px";
            overviewMonthLabel.style.margin = "0";

            const monthNames = [
                "", "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            const selectedMonth = monthSelect ? parseInt(monthSelect.value) : new Date().getMonth() + 1;
            overviewMonthLabel.textContent = `(${monthNames[selectedMonth]})`;

            const target = document.querySelector("#totalCount");
            if (target && target.parentElement) {
                target.parentElement.appendChild(overviewMonthLabel);
            }


            $("#letter-table").DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                buttons: ["excel", "pdf", "print"]
            }).buttons().container().appendTo('#letter-table_wrapper .col-md-6:eq(0)');


            initializeWeekBarChart(@json($receivedLetters));
            initializeDakPieChart(@json($letter_category));
            initializeStatusPieChart({{ $receipt_count }}, {{ $action_count }}, {{ $issue_count }},
                {{ $archive_count }});
        });


        function initializeDakPieChart(dakData) {
            const ctxDakPieChart = document.getElementById('dakPieChart').getContext('2d');
            const categoryNames = dakData.map(item => item.category_name);
            const categoryCounts = dakData.map(item => item.count);
            const colors = ['#3189E6', '#3A9E17', '#C75F08', '#AC8303', '#7A26CB', '#E65A40',
                '#E6C200', '#1D9E98', '#E660A2', '#5F52B5', '#E63F00'
            ];

            new Chart(ctxDakPieChart, {
                type: 'pie',
                data: {
                    labels: categoryNames,
                    datasets: [{
                        data: categoryCounts,
                        backgroundColor: colors
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            const categoryList = document.getElementById('category-list');
            dakData.forEach((item, index) => {
                const categoryItem = document.createElement('div');
                categoryItem.style.display = 'flex';
                categoryItem.style.justifyContent = 'space-between';
                categoryItem.style.marginBottom = '10px';
                categoryItem.style.alignItems = 'center';

                const searchLink = `/search?category=${item.id}`;

                categoryItem.innerHTML = `
                    <div>
                        <a href="${searchLink}" font-size: 16px;">
                            <span style="color: ${colors[index]}; font-size: 16px;">&#9679;</span>
                            ${item.category_name}
                        </a>
                    </div>
                    <div>
                        <a href="${searchLink}" style="color: blue; font-size: 16px;">
                            <strong>${item.count}</strong>
                        </a>
                    </div>
                `;
                categoryList.appendChild(categoryItem);
            });
        }
    </script>
@endsection
