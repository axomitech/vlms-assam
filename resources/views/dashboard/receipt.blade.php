@extends('layouts.app')

@section('content')
@include('layouts.header')


    <div class="row mt-3">
        <div class="col-md-12 text-center">
            <button class="btn btn-dark btn-sm" id="resetView" style="float: left;">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
            </button>
            <h4 id="selectedCategoryName"><strong>Receipts</strong></h4>
        </div>
    </div>

    <!-- Cards row -->
    <div class="row mt-1" id="cardsContainer">
        <div class="box-body col-md-12">
            <section class="content">
                <div class="container-fluid">
                    <!-- Loading Overlay -->
                    <div id="loading-overlay" style="display:none;">
                        <div class="spinner"></div>
                        <p>Loading...</p>
                    </div>
                    @if (session('role') > 0)
                        <!-- Start the outer row -->
                        <div class="row">
                            @foreach ($categories as $category)
                                <!-- Create a new row after every 3 cards -->
                                @if ($loop->index % 4 == 0 && !$loop->first)
                        </div>
                        <div class="row">
                    @endif

                    <div class="col-md-3 col-sm-6 mt-3">
                        <a href="#" class="category-card" data-category-id="{{ $category->id }}"
                            data-category-name="{{ $category->category_name }}">
                            <div class="small-box"
                                style="background-color: white; border-radius: 1rem;margin-left:15px; margin:right:15px;">
                                <div class="inner p-3"
                                    style="border-radius: 1rem; border: 1px solid #ddd; box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.1); position: relative;">
                                    <!-- Icon in the top-left corner -->
                                    <span
                                        style="position: absolute; top: 10px; left: 10px; color: black; background-color: #e9e2e2; padding: 5px; border-radius: 1rem;">
                                        <img src="{{ asset('banoshree/images/' . strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $category->category_name)) . '.png') }}"
                                            alt="Dak Received" style="width: 48px; height: 38px;">

                                    </span>
                                    <!-- Content container for count and category name -->
                                    <div class="d-flex flex-column align-items-center justify-content-center h-100">

                                        <!-- Count in the center -->
                                        <div class="count" style="color: #026FCC; font-size: 32px; font-weight: bold;">
                                            <strong>{{ $category->count }}</strong>
                                        </div>

                                        <!-- Category name at the bottom center -->
                                        <div class="category-name mt-auto text-center"
                                            style="font-size: 16px; color: black;">
                                            <strong>{{ $category->category_name }}</strong>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </a>
                    </div>
                    @endforeach
                </div> <!-- End of the outer row -->
                @endif
        </div>
        <div class="container-fluid p-4">
            <div class="row">
                <div class="col-md-12 p-5 bg-white"
                    style="border-radius: 1rem; border: 1px solid #ddd; box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.1); position: relative;">
                    <!-- Full width -->
                    <div class="d-flex justify-content-between align-items-center">
                        <!-- Flex container for heading and month select -->
                        <h5 class="px-5"><strong>Receipts Summary</strong></h5>
                        <select id="monthSelect" class="form-select" style="width: 200px;">
                            <option value="1" selected>January</option>
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
                    <hr style="border-top: 2px solid #ccc !important;">
                    <!-- Horizontal line below heading and month select -->
                    <div class="d-flex align-items-start mt-3"> <!-- Use align-items-start for vertical alignment -->
                        <div class="donut-chart-container me-4" style="position: relative; width: 280px; height: 280px;">
                            <canvas id="myDonutChart"></canvas>
                            <div
                                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                                <p><strong>Total Receipts</strong></p>
                                <h4 id="totalCount" style="margin: 0; font-weight:bold;"></h4>
                            </div>
                        </div>
                        <div class="labels-container d-flex flex-grow-1 justify-content-between" style="margin-left: 10%;">
                            <!-- Stretch to fill space -->
                            <div class="text-center">
                                <p
                                    style="margin: 0; font-weight: bold; border-bottom: 1px solid #ccc; padding-bottom: 5px;">
                                    Labels</p> <!-- Bottom border for header -->
                                <ul id="labelList"
                                    style="list-style-type: none; padding: 15px; margin-top: 10px; text-align: left;"></ul>
                                <!-- Left align labels -->
                            </div>
                            <div class="text-center">
                                <p
                                    style="margin: 0; font-weight: bold; border-bottom: 1px solid #ccc; padding-bottom: 5px;">
                                    Nos</p> <!-- Bottom border for header -->
                                <ul id="countList"
                                    style="list-style-type: none; padding: 15px; margin-top: 10px; text-align: right;"></ul>
                                <!-- Right align counts -->
                            </div>
                            <div class="text-center">
                                <p
                                    style="margin: 0; font-weight: bold; border-bottom: 1px solid #ccc; padding-bottom: 5px;">
                                    %</p> <!-- Bottom border for header -->
                                <ul id="percentList"
                                    style="list-style-type: none; padding: 15px; margin-top: 10px; text-align: right;"></ul>
                                <!-- Right align percentages -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <script>
                // Get data from Laravel
                const categories = @json($categories);

                // Prepare data for the donut chart
                const labels = categories.map(item => item.category_name);
                const dataValues = categories.map(item => item.count);

                // Calculate the total count of receipts
                const totalCount = dataValues.reduce((acc, val) => acc + val, 0);

                // Display the total count
                document.getElementById('totalCount').innerText = totalCount;

                // Create the donut chart
                const ctx = document.getElementById('myDonutChart').getContext('2d');
                const backgroundColors = [
                    'rgba(255, 0, 0, 0.8)', // Bright Red
                    'rgba(0, 255, 0, 0.8)', // Bright Green
                    'rgba(0, 0, 255, 0.8)', // Bright Blue
                    'rgba(255, 165, 0, 0.8)', // Bright Orange
                    'rgba(255, 255, 0, 0.8)', // Bright Yellow
                    'rgba(75, 0, 130, 0.8)', // Indigo
                    'rgba(238, 130, 238, 0.8)', // Violet
                    'rgba(0, 255, 255, 0.8)', // Aqua
                    'rgba(255, 105, 180, 0.8)', // Hot Pink
                    'rgba(0, 128, 128, 0.8)', // Teal
                    'rgba(255, 69, 0, 0.8)' // Orange Red
                ];

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Receipt Percentage by Category',
                            data: dataValues,
                            backgroundColor: backgroundColors,
                            borderColor: backgroundColors.map(color => color.replace(/0.2/,
                                '1')), // Darken the border color
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false // Disable the legend
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        let value = context.raw;
                                        let percentage = ((value / totalCount) * 100).toFixed(2);
                                        label += `: ${percentage}%`;
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });

                // Populate labels, counts, and percentages
                categories.forEach((item, index) => {
                    const labelItem = document.createElement('li');
                    labelItem.innerHTML =
                        `<span style="display:inline-block; width: 12px; height: 12px; background-color: ${backgroundColors[index % backgroundColors.length]}; border-radius: 50%; margin-right: 5px;"></span>${item.category_name}`;
                    labelItem.style.fontWeight = 'bold'; // Make bold
                    labelItem.style.marginBottom = '5px'; // Add space between labels
                    document.getElementById('labelList').appendChild(labelItem);

                    const countItem = document.createElement('li');
                    countItem.textContent = item.count;
                    countItem.style.fontWeight = 'bold'; // Make bold
                    countItem.style.marginBottom = '5px'; // Add space between counts
                    document.getElementById('countList').appendChild(countItem);

                    const percentItem = document.createElement('li');
                    const percentage = ((item.count / totalCount) * 100).toFixed(2);
                    percentItem.textContent = percentage + '%';
                    percentItem.style.fontWeight = 'bold'; // Make bold
                    percentItem.style.marginBottom = '5px'; // Add space between percentages
                    document.getElementById('percentList').appendChild(percentItem);
                });
            </script>
        </div>


        </section>
    </div>
    </div>

    <div class="box shadow-lg p-3 mb-5 mt-3 bg-white rounded min-vh-40" id="lettersTable" style="display: none;">
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
                                    <!-- AJAX response will populate here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('scripts')
@include('layouts.scripts')

    <script>
        $(document).ready(function() {
            // Initialize DataTable
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
                // Fetch letters using AJAX
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {


                        $('#selectedCategoryName').html('<strong>Receipts from ' +
                            categoryName + '</strong>');
                        let tableBody = '';
                        let serialNumber = 1;

                        // Build table rows
                        response.forEach(function(letter) {
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
                        <td><small>${letter.crn}</small></td>
                        <td style="width: 30%;">${truncatedSubject}</td>
                        <td><small>${letter.letter_no}</small></td>
                        <td><small>${letter.sender_name}</small></td>
                        <td><small>${letter.received_date}</small></td>
                        <td><small><a href="/pdf_downloadAll/${letter.letter_id}"><i class="fas fa-download" style="color: #174060"></i></a></small></td>
                    </tr>`;
                        });

                        // Update the DataTable
                        dataTable.clear(); // Clear the existing data
                        dataTable.rows.add($(tableBody)); // Add the new data
                        dataTable.draw(); // Redraw the table

                        // Show the table and hide the cards
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

            // Handle back button click to reset view
            $('#resetView').on('click', function() {
                // Check if the letters table is visible
                if ($('#lettersTable').is(':visible')) {
                    // If on the category page, reset to the main view
                    $('#lettersTable').hide();
                    $('#cardsContainer').show();
                    $('#selectedCategoryName').html('<strong>Receipts</strong>');
                } else {
                    // Redirect to the dashboard if on the initial view
                    window.location.href = dashboardUrl;
                }
            });
        });
    </script>
@endsection
