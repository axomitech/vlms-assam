@extends('layouts.app')
@section('content')
    @include('layouts.header')
    <div class="row">
        <div class="col-md-12 text-center py-2">
            <h4><strong>My Dashboard</strong></h4>
        </div>
    </div>
    <div class="row mt-1">
        <div class="box-body col-md-12">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        @if (session('role_dept') == 1)
                            <div class="col-md-3 col-sm-3">
                                <!-- small box -->
                                <a href="{{ route('receipt_box') }}">
                                    <div class="small-box pattern-background"
                                        style="background: #3087d8; padding:15px; border-radius:1rem;">
                                        <div class="inner">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <h3 style="color:white;">{{ $receipt_count }} </h3>
                                                    <h3 style="font-size: 18px;color:white;">Overall Dak Received</h3>
                                                </div>
                                                <div class="col-lg-4" style="padding: 0; margin: 0;">
                                                    <img src="{{ asset('banoshree/images/dakrecieved.png') }}"
                                                        alt="Dak Received"
                                                        style="width: 100%; height: 80%; margin: 0; padding: 0; display: block; border: 0;">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <!-- small box for Issued -->
                                <a href="{{ route('issue_box') }}">
                                    <div class="small-box pattern-background"
                                        style="background:#e66e0d; padding:15px; border-radius:1rem;">
                                        <div class="inner">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <h3 style="color:white;">{{ $issue_count }}</h3>
                                                    <h3 style="font-size: 18px;color:white;">Overall Issued</h3>
                                                </div>
                                                <div class="col-lg-4">
                                                    <img src="{{ asset('banoshree/images/issued.png') }}" alt="Dak Issued"
                                                        style="width: 100%; height: 80%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-6 col-sm-6">
                                <div class="row">
                                    <!-- small box for Action Taken (switched with Inbox) -->
                                    <div class="col-lg-6">
                                        <a href="{{ route('action_box') }}">
                                            <div class="small-box pattern-background"
                                                style="background:#39a013; padding:15px; border-radius:1rem;">
                                                <div class="inner">
                                                    <div class="row">
                                                        <div class="col-lg-8">
                                                            <h3 style="color:white;">{{ $action_count }} </h3>
                                                            <h3 style="font-size: 18px;color:white;">Overall Action Taken
                                                            </h3>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <img src="{{ asset('banoshree/images/actiontaken.png') }}"
                                                                alt="Dak Action" style="width: 100%; height: 80%;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <!-- small box for Archived (switched with Sent) -->
                                    <div class="col-lg-6">
                                        <a href="{{ route('letters', [encrypt(0), 'archive']) }}">
                                            <div class="small-box pattern-background"
                                                style="background: #d8a706; padding:15px; border-radius:1rem;">
                                                <div class="inner">
                                                    <div class="row">
                                                        <div class="col-lg-8">
                                                            <h3 style="color:white;">{{ $archive_count }}</h3>
                                                            <h3 style="font-size: 18px;color:white;">Overall Archived</h3>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <img src="{{ asset('banoshree/images/archived_dak.png') }}"
                                                                alt="Dak Archived" style="width: 100%; height: 80%;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-md-12 col-sm-12">
                            <div class="row">
                                <!-- small box for Inbox (previously Action Taken) -->
                                <div class="col-lg-3">
                                    <a href="{{ route('letters', [encrypt(0), 'tab' => 'inbox']) }}" data-tab="inbox">
                                        <div class="small-box pattern-background"
                                            style="background: #d3e0eb; padding:15px; border-radius:1rem;">
                                            <div class="inner">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <h3 style="color:#000100;">{{ $inbox_count }}</h3>
                                                        <h3 style="font-size: 18px;color:#000100;">My Inbox</h3>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <img src="{{ asset('banoshree/images/inbox64x64.png') }}"
                                                            alt="Dak Inbox" style="width: 100%; height: 80%;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                @if (session('role_dept') == 1)
                                    <!-- small box for Sent (previously Archived) -->
                                    <div class="col-lg-3">
                                        <a href="{{ route('letters', [encrypt(0), 'tab' => 'sent']) }}" data-tab="sent">
                                            <div class="small-box pattern-background"
                                                style="background:#d3e0eb; padding:15px; border-radius:1rem;">
                                                <div class="inner">
                                                    <div class="row">
                                                        <div class="col-lg-8">
                                                            <h3 style="color:#000100;">{{ $sent_count }}</h3>
                                                            <h3 style="font-size: 18px;color:#000100;">My Sent Items</h3>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <img src="{{ asset('banoshree/images/sent64x64.png') }}"
                                                                alt="Dak Sent" style="width: 100%; height: 80%;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                                @if (session('role_dept') > 1)
                                <div class="col-lg-3">
                                    <a href="{{ route('letters', [encrypt(0), 'tab' => 'sent']) }}" data-tab="sent">
                                        <div class="small-box pattern-background"
                                            style="background:#d3e0eb; padding:15px; border-radius:1rem;">
                                            <div class="inner">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <h3 style="color:#000100;">{{ $action_count }}</h3>
                                                        <h3 style="font-size: 18px;color:#000100;">Action Taken</h3>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <img src="{{ asset('banoshree/images/actiontaken.png') }}"
                                                            alt="Dak Sent" style="width: 100%; height: 80%;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3">
                                    <a href="{{ route('letters', [encrypt(0), 'tab' => 'sent']) }}" data-tab="sent">
                                        <div class="small-box pattern-background"
                                            style="background:#d3e0eb; padding:15px; border-radius:1rem;">
                                            <div class="inner">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <h3 style="color:#000100;">{{ $in_process_count }}</h3>
                                                        <h3 style="font-size: 18px;color:#000100;">In Process</h3>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <img src="{{ asset('banoshree/images/process.png') }}"
                                                            alt="Dak Sent" style="width: 100%; height: 80%;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3">
                                    <a href="{{ route('letters', [encrypt(0), 'tab' => 'sent']) }}" data-tab="sent">
                                        <div class="small-box pattern-background"
                                            style="background:#d3e0eb; padding:15px; border-radius:1rem;">
                                            <div class="inner">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <h3 style="color:#000100;">{{ $completed_count }}</h3>
                                                        <h3 style="font-size: 18px;color:#000100;">Completed</h3>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <img src="{{ asset('banoshree/images/completed.png') }}"
                                                            alt="Dak Sent" style="width: 100%; height: 80%;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>

    </div>
    @if (session('role_dept') == 1)
    <div class="row">
        <!-- Left Column: eDak Overview and Overview of Receipt stacked vertically -->
        <div class="col-md-7 col-sm-12">
            <!-- eDak Overview Section -->
            <div class="row box shadow-lg p-3 mb-5 bg-white rounded min-vh-40"
                style="margin: 10px; border-radius: 1rem !important;">
                <div class="col-md-4" style="padding: 20px;">
                    <h5 class="mb-4 font-weight-bold">eDak Overview</h5>
                    <select id="monthSelect" class="form-select mb-4">
                        <option value="">Select Month</option>
                        <!-- Month Options -->
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10" selected>October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                    <!-- Legend -->
                    <div>
                        <ul id="legend" style="list-style-type: none; padding: 0;">
                            <li style="margin-bottom: 10px;">
                                <span
                                    style="display: inline-block; width: 20px; height: 13px; background-color: #379FFF; margin-right: 5px; border-radius: 0.2rem;"></span>
                                Received
                            </li>
                            <li style="margin-bottom: 10px;">
                                <span
                                    style="display: inline-block; width: 20px; height: 13px; background-color: #42B518; margin-right: 5px; border-radius: 0.2rem;"></span>
                                Action Taken
                            </li>
                            <li style="margin-bottom: 10px;">
                                <span
                                    style="display: inline-block; width: 20px; height: 13px; background-color: #DE6909; margin-right: 5px; border-radius: 0.2rem;"></span>
                                Issued
                            </li>
                            <li style="margin-bottom: 10px;">
                                <span
                                    style="display: inline-block; width: 20px; height: 13px; background-color: #BF9203; margin-right: 5px; border-radius: 0.2rem;"></span>
                                Archived
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-8">
                    <canvas id="myPieChart" width="200" height="200" style="padding: 30px;"></canvas>
                </div>
            </div>

            <!-- Overview of Receipt Section -->
            <div class="row box shadow-lg p-4 mb-5 bg-white rounded min-vh-40"
                style="margin: 10px; border-radius: 1rem !important;">
                <div class="col-12">

                    <h5 class="mb-2 font-weight-bold text-left">Overview of Receipt</h5>
                </div>
                <!-- Total Count -->
                <div class="col-12">
                    <h2 id="totalCount" style="font-weight: bold; color: #333; padding-left: 5px; margin: 5px 0 0 5px;">15
                    </h2>
                </div>
                <!-- 'this month' label -->
                <div class="col-12">
                    <h6 style="color: #8b8383; padding-left: 5px; margin: 0;">this month</h6>
                </div>
                <!-- Bar Chart Section -->
                <div class="col-md-12 d-flex justify-content-center">
                    <canvas id="weekBarChart" width="250" height="150"></canvas>
                </div>
            </div>
        </div>


        <!-- Right Column: DAK Source Summary Section -->
        <div class="col-md-5 col-sm-12">
            <div class="box shadow-lg p-4 mb-5 bg-white rounded min-vh-40"
                style="margin: 10px;  border-radius:1rem !important;">
                <h5 class="mb-4 font-weight-bold text-left">DAK Source Summary</h5>
                <!-- Pie Chart Section -->
                <div class="col-md-12 d-flex justify-content-center">
                    <canvas id="dakPieChart" width="250" height="250"></canvas>
                </div>
                <!-- Category Names and Counts Below the Chart -->
                <div id="category-list" class="col-md-12 mt-3">
                    <!-- Category Names and Counts will appear here -->
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
@section('scripts')
    @include('layouts.scripts')

    <script>
        $(function() {
            // Initialize DataTable
            $("#letter-table").DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                buttons: ["excel", "pdf", "print"]
            }).buttons().container().appendTo('#letter-table_wrapper .col-md-6:eq(0)');
        });

        // Bar Chart for Weekly Data
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
                9: '#CACCCF',
                10: '#CC5170',
                11: '#285CAB'
            };

            const datasetMap = {};
            let totalCount = 0;

            data.forEach(entry => {
                const week = entry.week_of_month;
                const categoryId = entry.letter_category_id;
                const count = entry.count;
                const categoryName = entry.category_name;

                totalCount += count;

                if (!datasetMap[categoryId]) {
                    datasetMap[categoryId] = {
                        label: categoryName,
                        data: [0, 0, 0, 0],
                        backgroundColor: categoryColors[categoryId]
                    };
                }
                datasetMap[categoryId].data[week - 1] = count;
            });

            // Reverse data to match reversed week labels
            Object.values(datasetMap).forEach(dataset => dataset.data.reverse());

            const datasets = Object.values(datasetMap);

            new Chart(ctxWeekChart, {
                type: 'bar',
                data: {
                    labels: ['Week 4', 'Week 3', 'Week 2', 'Week 1'], // Reversed
                    datasets
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    scales: {
                        x: {
                            stacked: true,
                            grid: {
                                display: false
                            },
                        },
                        y: {
                            stacked: true,
                            grid: {
                                display: false
                            },
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                        }
                    }
                }
            });

            // Update total count
            document.getElementById('totalCount').innerText = totalCount;
        }

        function initializeDakPieChart(dakData) {
            const ctxDakPieChart = document.getElementById('dakPieChart').getContext('2d');
            const categoryNames = dakData.map(item => item.category_name);
            const categoryCounts = dakData.map(item => item.count);
            const colors = ['#3189E6', '#3A9E17', '#C75F08', '#AC8303', '#7A26CB', '#E65A40', '#E6C200', '#1D9E98',
                '#E660A2',
                '#5F52B5', '#E63F00'
            ];

            new Chart(ctxDakPieChart, {
                type: 'pie',
                data: {
                    labels: categoryNames,
                    datasets: [{
                        data: categoryCounts,
                        backgroundColor: colors,
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

            // Display category names with counts as clickable links
            const categoryList = document.getElementById('category-list');
            dakData.forEach((item, index) => {
                const categoryItem = document.createElement('div');
                categoryItem.style.display = 'flex';
                categoryItem.style.justifyContent = 'space-between';
                categoryItem.style.marginBottom = '10px';
                categoryItem.style.alignItems = 'center';

                // Create links for both category name and count
                const searchLink = `/search?category=${item.id}`; // Adjust the URL and query parameter as needed

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


        // Pie Chart for Letter Status
        function initializeStatusPieChart(receiptCount, actionCount, issueCount, archiveCount) {
            const ctxMyPieChart = document.getElementById('myPieChart').getContext('2d');

            new Chart(ctxMyPieChart, {
                type: 'pie',
                data: {
                    labels: ['Received', 'Action', 'Issued', 'Archived'],
                    datasets: [{
                        data: [receiptCount, actionCount, issueCount, archiveCount],
                        backgroundColor: ['#379FFF', '#42B518', '#DE6909', '#BF9203'],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        datalabels: {
                            formatter: (value, context) => {
                                const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                return `${((value / total) * 100).toFixed(1)}%`;
                            },
                            color: '#000',
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            align: 'end',
                            anchor: 'end',
                            offset: 5,
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        }

        // Initialize all charts
        initializeWeekBarChart(@json($receivedLetters));
        initializeDakPieChart(@json($letter_category));
        initializeStatusPieChart({{ $receipt_count }}, {{ $action_count }}, {{ $issue_count }}, {{ $archive_count }});
    </script>
@endsection
