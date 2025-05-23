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
                                        <th scope="col"><small><b>Received/Issue Date</b></small></th>
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
                                <iframe src="" style="width: 100%; height: 400px;" id="refer-letter-view"></iframe>
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
       $(document).ready(function() {
    // Initialize DataTable
    const dataTable = $('#lettersList').DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        lengthMenu: [
        [10, 25, 50, -1], // values
        [10, 25, 50, 'All'] // labels
    ],
    pageLength: 5, 
       buttons: [
        {
            extend: 'excelHtml5',
            text: 'Export Excel',
            className: 'btn btn-primary btn-sm me-2'
        },
        {
            extend: 'pdfHtml5',
            text: 'Export PDF',
            className: 'btn btn-info btn-sm me-2 ml-1'
        },
        {
            extend: 'print',
            text: 'Print',
            className: 'btn btn-success btn-sm ml-1'
        }
    ]
    });

    // Fetch and display category data when category card is clicked
    $(document).on('click', '.category-card', function(e) {
        e.preventDefault();        
        showLoading();
        let categoryId = $(this).data('category-id');
        let categoryName = $(this).data('category-name');
        let category = $(this).data('category');
        
        let url = `{{url('getCategoryReport')}}?category_id=${categoryId}&category=${encodeURIComponent(category)}`;
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
                    let letterIssueReceiveDate = ''
                    if(letter.received_date != null){
                        letterIssueReceiveDate = letter.received_date
                    }
                    else{
                        letterIssueReceiveDate = letter.received_date
                    }
                    let ecr_no = letter.ecr_no;
                    if(ecr_no == null){
                        ecr_no = "";
                    }
                    let letterPath = letter.letter_path.replace("public/","");
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
                        <td><small><a href="" class="assign-link"           data-id="${letter.letter_id}"
                                                                            data-toggle="modal"
                                                                            data-target=".bd-example-modal-lg"
                                                                            data-letter="${letter.letter_no}"
                                                                            data-letter_path="{{ storageUrl('${letterPath}') }}">${letter.crn}</a></small>
                                                                            <br>
                                                                            Diarized By: ${letter.name}
                                                                            </td>
                        <td style="width: 30%;">${truncatedSubject}</td>
                        <td><small>
                            <b>${letter.letter_no}</b>
                            <br>
                            <b>${ecr_no}</b>
                            <br>
                            Sender:<b>${letter.sender_name}</b>
                            <br>
                            ${letter.sender_designation}
                            <br>
                            ${letter.organization}
                            </small></td>
                        <td><small>${letterIssueReceiveDate}</small></td>
                        <td><small><a href="/pdf_downloadAll/${letter.letter_id}"><i class="fas fa-download" style="color: #174060"></i></a></small></td>
                    </tr>`;
                });

                // Update the DataTable
                dataTable.clear();  // Clear existing data
                dataTable.rows.add($(tableBody));  // Add the new rows
                dataTable.draw();  // Redraw the table
                dataTable.buttons().container().appendTo('#lettersList_wrapper .col-md-6:eq(0)');
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
    <script>
        $(document).on('click', '.assign-link', function() {
            $('#letter-view').attr('src', $(this).data('letter_path'));
            $('#assign-div').show();
            $('#exampleModalLabel').html("<strong>Letter No.: "+$(this).data('letter')+"</strong>");
            $.get("{{route('reference')}}",{
                letter:$(this).data('id')
            },function(j){
                if(j.length > 1){
                    var div = "";
                    for(var i = 1; i < j.length; i++){
                        div += "<div class='col-md-2'><a href='' class= 'refer-letter-link' data-letter='"+j[i].letter_id+"' data-refer_letter_path='"+j[i].letter_path+"'><b>"+j[i].letter_no+"</b></a></div>";
                    }
                    $('#refers').html("<div class='col-md-2'>Reference Letter:</div>"+div);
                }else{
                    $('#refer-letter-div').hide();
                }
            });
        });

        $(document).on('click','.refer-letter-link',function(e){
            e.preventDefault();
            $('#refer-letter-div').removeAttr("hidden");
            $('#refer-letter-div').show();
            $('#refer-letter-view').attr('src', $(this).data('refer_letter_path'));

        });

    </script>
@endsection
