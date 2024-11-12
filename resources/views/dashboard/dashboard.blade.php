@extends('layouts.app')
<style>
    .pattern-background::before,
    .pattern-background::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.082);
        /* Slightly increased opacity for better visibility */
        box-shadow: 0px 6px 12px rgba(255, 255, 255, 0.2);
        /* Adjusted for more subtle shadow effect */
    }

    /* Top-left Circle */
    .pattern-background::before {
        top: -25px;
        /* Slightly adjusted positioning */
        left: -25px;
        /* Slightly adjusted positioning */
        width: 90px;
        /* Increased size for a more pronounced effect */
        height: 90px;
        /* Increased size for consistency */
    }

    /* Bottom-right Circle */
    .pattern-background::after {
        bottom: -25px;
        /* Slightly adjusted positioning */
        right: -25px;
        /* Slightly adjusted positioning */
        width: 110px;
        /* Increased size for a more balanced look */
        height: 110px;
        /* Increased size for consistency */
    }
</style>
@section('content')
    @php
        $hour = \Carbon\Carbon::now()->format('H');
        if ($hour < 12) {
            $greeting = 'Good Morning';
            $icon = 'bx bxs-sun'; // Morning sun icon
        } elseif ($hour < 18) {
            $greeting = 'Good Afternoon';
            $icon = 'fas fa-cloud-sun'; // Afternoon icon with sun and cloud
        } else {
            $greeting = 'Good Evening';
            $icon = 'bx bxs-moon'; // Evening moon icon
        }
    @endphp
    <div class="row">
        <div class="col-md-6 mb-2">
            <h6><i class='{{ $icon }}'></i>
                {{ $greeting }} {{ Auth::user()->name }}</h6>
        </div>
        <div class="col-md-6 text-right">
            <h6> <i class='bx bxs-calendar'></i> Today is {{ \Carbon\Carbon::now()->format('j F Y (l)') }}</h6>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 px-3">
            <h4><strong>Dashboard</strong></h4>
        </div>
    </div>
    <div class="row mt-1">
        <div class="box-body col-md-12">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        @if (session('role') > 0)
                            <div class="col-md-3 col-sm-3">
                                <!-- small box -->
                                <a href="{{ route('receipt_box') }}">
                                    <div class="small-box pattern-background"
                                        style="background: #206fb9; padding:15px; border-radius:1rem;">

                                        <div class="inner">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <h3 style="color:white;">{{ $receipt_count }} </h3>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <h3 style="font-size: 22px;color:white;">Dak Received </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <span style="font-size: 40px; color: white;">
                                                        <img src="{{ asset('banoshree/images/dakrecieved.png') }}"
                                                            alt="Dak Received" style="width: 100%; height: 80%;">
                                                    </span>
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
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <h3 style="color:white;">{{ $issue_count }}</h3>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <h3 style="font-size: 22px;color:white;">Issued</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <span style="font-size: 40px; color: white;">
                                                        <img src="{{ asset('banoshree/images/issued.png') }}"
                                                            alt="Dak Issued" style="width: 100%; height: 80%;">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-6 col-sm-6">
                                <div class="row">
                                    <!-- small box for Inbox -->
                                    <div class="col-lg-6">
                                        <a href="{{ route('letters', [encrypt(0), 'tab' => 'inbox']) }}" data-tab="inbox">
                                            <div class="small-box pattern-background"
                                                style="background: #d3e0eb; padding:15px; border-radius:1rem;">
                                                <div class="inner">
                                                    <div class="row">
                                                        <div class="col-lg-8">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <h3 style="color:#000100;">{{ $inbox_count }}</h3>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <h3 style="font-size: 22px;color:#000100;">Inbox</h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <span style="font-size: 40px; color: white;">
                                                                <img src="{{ asset('banoshree/images/inbox64x64.png') }}"
                                                                    alt="Dak Inbox" style="width: 100%; height: 80%;">
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <!-- small box for Sent -->
                                    <div class="col-lg-6">
                                        <a href="{{ route('letters', [encrypt(0), 'tab' => 'sent']) }}" data-tab="sent">
                                            <div class="small-box pattern-background"
                                                style="background:#d3e0eb; padding:15px; border-radius:1rem;">
                                                <div class="inner">
                                                    <div class="row">
                                                        <div class="col-lg-8">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <h3 style="color:#000100;">{{ $sent_count }}</h3>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <h3 style="font-size: 22px;color:#000100;">Sent</h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <span style="font-size: 40px; color: white;">
                                                                <img src="{{ asset('banoshree/images/sent64x64.png') }}"
                                                                    alt="Dak Inbox" style="width: 100%; height: 80%;">
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        </div>
        <div class="box-body col-md-12">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        @if (session('role') > 0)
                            <div class="col-md-3 col-sm-3">
                                <!-- small box -->
                                <a href="{{ route('action_box') }}">
                                    <div class="small-box pattern-background"
                                        style="background:#39a013; padding:15px; border-radius:1rem;">
                                        <div class="inner">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <h3 style="color:white;">{{ $action_count }} </h3>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <h3 style="font-size: 22px;color:white;">Action Taken </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <span style="font-size: 40px; color: white;">
                                                        <img src="{{ asset('banoshree/images/actiontaken.png') }}"
                                                            alt="Dak Inbox" style="width: 100%; height: 80%;">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <a href="{{ route('letters') }}" class="small-box-footer">Diarized<i class="fas fa-arrow-circle-right"></i></a> --}}
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <!-- small box -->
                                <a href="{{ route('letters', [encrypt(0), 'archive']) }}">
                                    <div class="small-box pattern-background"
                                        style="background: #d8a706; padding:15px; border-radius:1rem;">
                                        <div class="inner">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <h3 style="color:white;">{{ $archive_count }} </h3>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <h3 style="font-size: 22px;color:white;">Archived </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <span style="font-size: 40px; color: white;">
                                                        <img src="{{ asset('banoshree/images/archived_dak.png') }}"
                                                            alt="Dak Archived" style="width: 100%; height: 80%;">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <a href="{{ route('letters') }}" class="small-box-footer">Diarized<i class="fas fa-arrow-circle-right"></i></a> --}}
                                    </div>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </div>
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
@endsection
@section('scripts')
    <!-- DataTables & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('js/custom/common.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <script>
        $(function() {
            // Initialize DataTable
            $("#letter-table").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["excel", "pdf", "print"]
            }).buttons().container().appendTo('#letter-table_wrapper .col-md-6:eq(0)');
        });
        const data = @json($receivedLetters);
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
        let totalCount = 0; // Variable to hold total count of letters

        data.forEach(entry => {
            const week = entry.week_of_month;
            const categoryId = entry.letter_category_id;
            const count = entry.count;
            const categoryName = entry.category_name;

            totalCount += count; // Accumulate the total count

            if (!datasetMap[categoryId]) {
                datasetMap[categoryId] = {
                    label: categoryName,
                    data: [0, 0, 0, 0],
                    backgroundColor: categoryColors[categoryId]
                };
            }
            datasetMap[categoryId].data[week - 1] = count; // Set count for the respective week
        });

        // Reverse data for each dataset to match reversed week labels
        Object.keys(datasetMap).forEach(categoryId => {
            datasetMap[categoryId].data.reverse(); // Reverse the data array for each dataset
        });

        // Update the total count in the HTML
        document.getElementById('totalCount').innerText = totalCount;

        const datasets = Object.values(datasetMap);
        const weekBarChart = new Chart(ctxWeekChart, {
            type: 'bar',
            data: {
                labels: ['Week 4', 'Week 3', 'Week 2', 'Week 1'], // Reversed order of weeks
                datasets: datasets
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                scales: {
                    x: {
                        stacked: true,
                        grid: {
                            display: false, // Disable grid lines for x-axis
                        },
                        title: {
                            display: false // Disable x-axis title
                        }
                    },
                    y: {
                        stacked: true,
                        grid: {
                            display: false, // Disable grid lines for y-axis
                        },
                        title: {
                            display: false // Disable y-axis title
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            boxWidth: 15, // Adjust the width of the legend color box
                            boxHeight: 11, // You can also add this to control the height
                            font: {
                                size: 14 // Adjust the font size of the legend labels
                            }
                        }
                    }
                }
            }
        });


        // Pie chart for letter categories
        const dakData = @json($letter_category);
        const ctxDakPieChart = document.getElementById('dakPieChart').getContext('2d');
        const categoryNames = dakData.map(item => item.category_name);
        const categoryCounts = dakData.map(item => item.count);
        const colors = ['#3189E6', '#3A9E17', '#C75F08', '#AC8303', '#7A26CB', '#E65A40', '#E6C200', '#1D9E98', '#E660A2',
            '#5F52B5', '#E63F00'
        ];

        const dakPieChart = new Chart(ctxDakPieChart, {
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

        // Display category names with counts
        const categoryList = document.getElementById('category-list');
        dakData.forEach((item, index) => {
            const categoryItem = document.createElement('div');
            categoryItem.style.display = 'flex';
            categoryItem.style.justifyContent = 'space-between';
            categoryItem.style.marginBottom = '10px';
            categoryItem.style.alignItems = 'center';

            categoryItem.innerHTML = `
                <div>
                    <span style="color: ${colors[index]}; font-size: 16px;">&#9679;</span>
                    ${item.category_name}
                </div>
                <div><strong>${item.count}</strong></div>
            `;
            categoryList.appendChild(categoryItem);
        });

        const receipt_count = {{ $receipt_count }};
        const action_count = {{ $action_count }};
        const issue_count = {{ $issue_count }};
        const archive_count = {{ $archive_count }};

        const ctxMyPieChart = document.getElementById('myPieChart').getContext('2d');
        const myPieChart = new Chart(ctxMyPieChart, {
            type: 'pie',
            data: {
                labels: ['Received', 'Action', 'Issued', 'Archived'],
                datasets: [{
                    data: [receipt_count, action_count, issue_count, archive_count],
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
                            const percentage = ((value / total) * 100).toFixed(
                                1); // Show percentage to 1 decimal place
                            return `${percentage}%`; // Show percentage outside the pie
                        },
                        color: '#000',
                        font: {
                            size: 14,
                            weight: 'bold'
                        },
                        align: 'end',
                        anchor: 'end',
                        offset: 5, // Adjust the position of the percentage labels
                        padding: 0
                    }
                }
            },
            plugins: [ChartDataLabels] // Ensure the DataLabels plugin is being used
        });
    </script>
@endsection
