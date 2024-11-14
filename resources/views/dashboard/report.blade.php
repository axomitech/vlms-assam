@extends('layouts.app')
@section('content')
@include('layouts.header')

    <div class="row mt-3">
        <div class="col-md-12 text-center">
            <button class="btn btn-dark btn-sm" id="resetView" style="float: left;">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
            </button>
            <h4 id="selectedCategoryName"><strong>Report</strong></h4>
        </div>
    </div>

    <div class="row mt-1" id="cardsContainer">
        <div class="box-body col-md-12">
            <section class="content">
                <div class="container-fluid">
                    <!-- Loading Overlay -->
                    <div id="loading-overlay" style="display:none;">
                        <div class="spinner"></div>
                        <p>Loading...</p>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-6 mt-3">
                            <a href="#" data-category="diarized">
                                <div class="small-box"
                                    style="background-color: white; border-radius: 1rem;margin-left:15px; margin:right:15px;">
                                    <div class="inner p-3"
                                        style="border-radius: 1rem; border: 1px solid #ddd; box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.1); position: relative;"
                                        id="diarizedBox">
                                        <!-- Icon in the top-left corner -->
                                        <span
                                            style="position: absolute; top: 10px; left: 10px; color: black; background-color: #e9e2e2; padding: 5px; border-radius: 1rem;">
                                            <img src="{{ asset('banoshree/images/dakrecieved.png') }}" alt="Dak Received"
                                                style="width: 48px; height: 48px;">

                                        </span>
                                        <!-- Content container for count and category name -->
                                        <div class="d-flex flex-column align-items-center justify-content-center h-90">

                                            <!-- Count in the center -->
                                            <div class="count" style="color: #026FCC; font-size: 42px; font-weight: bold;">
                                                <strong>{{ $diarized_count }}</strong>
                                            </div>

                                            <!-- Category name at the bottom center -->
                                            <div class="category-name mt-auto text-center"
                                                style="font-size: 22px; color: black;">
                                                <strong>Diarized</strong>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-6 mt-3">
                            <a href="#" data-category="assigned">
                                <div class="small-box"
                                    style="background-color: white; border-radius: 1rem;margin-left:15px; margin:right:15px;">
                                    <div class="inner p-3"
                                        style="border-radius: 1rem; border: 1px solid #ddd; box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.1); position: relative;"
                                        id="assignedBox">
                                        <!-- Icon in the top-left corner -->
                                        <span
                                            style="position: absolute; top: 10px; left: 10px; color: black; background-color: #e9e2e2; padding: 5px; border-radius: 1rem;">
                                            <img src="{{ asset('banoshree/images/sent64x64.png') }}" alt="Dak Received"
                                                style="width: 48px; height: 48px;">

                                        </span>
                                        <!-- Content container for count and category name -->
                                        <div class="d-flex flex-column align-items-center justify-content-center h-90">

                                            <!-- Count in the center -->
                                            <div class="count" style="color: #026FCC; font-size: 42px; font-weight: bold;">
                                                <strong>{{ $assigned_count }}</strong>
                                            </div>

                                            <!-- Category name at the bottom center -->
                                            <div class="category-name mt-auto text-center"
                                                style="font-size: 22px; color: black;">
                                                <strong>Assigned</strong>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-6 mt-3">
                            <a href="#"  data-category="forwarded">
                                <div class="small-box"
                                    style="background-color: white; border-radius: 1rem;margin-left:15px; margin:right:15px;">
                                    <div class="inner p-3"
                                        style="border-radius: 1rem; border: 1px solid #ddd; box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.1); position: relative;"
                                        id="forwardedBox">
                                        <!-- Icon in the top-left corner -->
                                        <span
                                            style="position: absolute; top: 10px; left: 10px; color: black; background-color: #e9e2e2; padding: 5px; border-radius: 1rem;">
                                            <img src="{{ asset('banoshree/images/actiontaken.png') }}" alt="Dak Received"
                                                style="width: 48px; height: 48px;">

                                        </span>
                                        <!-- Content container for count and category name -->
                                        <div class="d-flex flex-column align-items-center justify-content-center h-90">

                                            <!-- Count in the center -->
                                            <div class="count" style="color: #026FCC; font-size: 42px; font-weight: bold;">
                                                <strong>{{ $forwarded_count }}</strong>
                                            </div>

                                            <!-- Category name at the bottom center -->
                                            <div class="category-name mt-auto text-center"
                                                style="font-size: 22px; color: black;">
                                                <strong>Forwarded</strong>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </a>
                        </div>
                    </div> <!-- End of the outer row -->
                </div>
            </section>
        </div>
    </div>
    <!-- Selected Category Title -->
    <hr>

    <!-- Cards Row for Dynamic Data Display -->
    <div class="row mt-4" id="categoryCardsContainer">
        <div class="box-body col-md-12">
            <section class="content">
                <div class="container-fluid">
                    <div id="categoryContent" class="row">
                        <!-- Dynamic content will be inserted here -->
                    </div>
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

    // Fetch and display category data when category card is clicked
    $(document).on('click', '.category-card', function(e) {
        e.preventDefault();        
        showLoading();
        let categoryId = $(this).data('category-id');
        let categoryName = $(this).data('category-name');
        let category = $(this).data('category');
        let url = `/getCategoryReport?category_id=${categoryId}&category=${encodeURIComponent(category)}`;
        // Fetch letters using AJAX
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                $('#selectedCategoryName').html('<strong>' + categoryName + '</strong>');
                let tableBody = '';
                let serialNumber = 1;

                // Build table rows for DataTable
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
                        <td><small>${letter.received_date}</small></td>
                        <td><small><a href="/pdf_downloadAll/${letter.letter_id}"><i class="fas fa-download" style="color: #174060"></i></a></small></td>
                    </tr>`;
                });

                // Update the DataTable
                dataTable.clear();  // Clear existing data
                dataTable.rows.add($(tableBody));  // Add the new rows
                dataTable.draw();  // Redraw the table

                // Show/hide views
                $('#cardsContainer').hide();
                $('#categoryCardsContainer').hide();
                $('#lettersTable').show();
                $('#resetView').show();
                hideLoading();
            },
            error: function(xhr, status, error) {
                $('#lettersList tbody').html('<tr><td colspan="7" class="text-center">Error loading data</td></tr>');
                hideLoading();

            }
        });
    });

    // Handle back button click to reset view
    $('#resetView').on('click', function() {
        if ($('#lettersTable').is(':visible')) {
            $('#lettersTable').hide();
            $('#cardsContainer').show();
            $('#categoryCardsContainer').show();
            document.getElementById("selectedCategoryName").innerHTML =
            `<strong>${capitalizeFirstLetter(category)} Report Category-Wise</strong>`;
        } else {
            window.location.href = "{{ route('dashboard') }}";
        }
    });
});

    </script>

    <script>
        // Function to fetch and display the selected category's content
        function showCategoryData(category) {
            // Show the loading overlay when the request starts
            document.getElementById('loading-overlay').style.display = 'flex';

            fetch(`{{ url('') }}/getCategoryData?category=${category}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById("categoryContent").innerHTML = ""; // Clear existing content

                    // Loop through the data and generate HTML for each item
                    data.forEach(item => {
                        // Generate image URL dynamically based on category_name
                        const imageUrl =
                            `{{ url('') }}/banoshree/images/${item.category_name.toLowerCase().replace(/[^a-zA-Z0-9]/g, '')}.png`;

                        // Construct the card HTML
                        const cardHtml = `
                    <div class="col-md-3 col-sm-6 mt-3 mb-3">
                        <a href="#" class="category-card" data-category-id="${item.id}" data-category="${category}" data-category-name="${item.category_name}">
                            <div class="small-box" style="background-color: white; border-radius: 1rem; margin-left: 15px; margin-right: 15px;">
                                <div class="inner p-3" style="border-radius: 1rem; border: 1px solid #ddd; box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.1); position: relative;">
                                    
                                    <!-- Icon in the top-left corner -->
                                    <span style="position: absolute; top: 10px; left: 10px; color: black; background-color: #e9e2e2; padding: 5px; border-radius: 1rem;">
                                        <img src="${imageUrl}" alt="Category Icon" style="width: 48px; height: 38px;">
                                    </span>

                                    <!-- Content container for count and category name -->
                                    <div class="d-flex flex-column align-items-center justify-content-center h-90">
                                        
                                        <!-- Count in the center -->
                                        <div class="count" style="color: #026FCC; font-size: 32px; font-weight: bold;">
                                            <strong>${item.count}</strong>
                                        </div>
                                        
                                        <!-- Category name at the bottom center -->
                                        <div class="category-name mt-auto text-center" style="font-size: 16px; color: black;">
                                            <strong>${item.category_name}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                `;

                        // Append the generated card HTML to the categoryContent container
                        document.getElementById("categoryContent").innerHTML += cardHtml;
                    });

                    // Update the selected category title with bold text
                    document.getElementById("selectedCategoryName").innerHTML =
                        `<strong>${capitalizeFirstLetter(category)} Report Category-Wise</strong>`;

                })
                .catch(error => console.error("Error fetching category data:", error))
                .finally(() => {
                    // Hide the loading overlay once the request is completed (either success or failure)
                    document.getElementById('loading-overlay').style.display = 'none';
                });
        }

        // Capitalize function
        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        // Function to highlight the active box and add "Active" label
        function setActiveBox(activeId) {
            const boxes = ["diarizedBox", "assignedBox", "forwardedBox"];

            // Loop through all boxes to remove the "active-box" class and active label
            boxes.forEach(id => {
                const boxElement = document.getElementById(id);
                if (boxElement) {
                    boxElement.classList.remove("active-box");

                    // Remove any existing active label
                    const activeLabel = boxElement.querySelector('.active-label');
                    if (activeLabel) {
                        activeLabel.remove();
                    }
                }
            });

            // Add "active-box" class and "Active" label to the selected box
            const activeBoxElement = document.getElementById(activeId);
            if (activeBoxElement) {
                activeBoxElement.classList.add("active-box");

                // Add the "Active" label at the bottom-right corner
                const activeLabelHtml = `
            <div class="active-label">
                <span class="circle"></span>
                Active
            </div>
        `;
                activeBoxElement.insertAdjacentHTML('beforeend', activeLabelHtml);
                console.log(`Active box set to: ${activeId}`); // Debugging
            }
        }

        // Event listeners for the boxes
        document.getElementById("diarizedBox").addEventListener("click", function(event) {
            event.preventDefault();
            showCategoryData("diarized");
            setActiveBox("diarizedBox");
        });
        document.getElementById("assignedBox").addEventListener("click", function(event) {
            event.preventDefault();
            showCategoryData("assigned");
            setActiveBox("assignedBox");
        });
        document.getElementById("forwardedBox").addEventListener("click", function(event) {
            event.preventDefault();
            showCategoryData("forwarded");
            setActiveBox("forwardedBox");
        });
    </script>
@endsection
