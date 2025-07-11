@extends('layouts.app')

@section('content')
    @include('layouts.header')
    <div class="box shadow-lg p-3 mb-5 mt-3 bg-white rounded min-vh-40" id="lettersTable">
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
                        <td><small><a href="" class="assign-link"
                                                                            data-id="${letter.letter_id}"
                                                                            data-toggle="modal"
                                                                            data-target=".bd-example-modal-lg"
                                                                            data-letter="${letter.letter_no}"
                                                                            data-letter_path="{{ storageUrl('${letterPath}') }}">${letter.crn}</a></small><br>Diarized By:${letter.name}</td>
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
    <script>
        $(document).on('click', '.assign-link', function() {
            $('#letter-view').attr('src', $(this).data('letter_path'));
            $('#assign-div').show();
            $('#exampleModalLabel').html("<strong>Letter No.: " + $(this).data('letter') + "</strong>");
            $.get("{{ route('reference') }}", {
                letter: $(this).data('id')
            }, function(j) {
                if (j.length > 1) {
                    var div = "";
                    for (var i = 1; i < j.length; i++) {
                        div += "<div class='col-md-2'><a href='' class= 'refer-letter-link' data-letter='" +
                            j[i].letter_id + "' data-refer_letter_path='" + j[i].letter_path + "'><b>" + j[
                                i].letter_no + "</b></a></div>";
                    }
                    $('#refers').html("<div class='col-md-2'>Reference Letter:</div>" + div);
                } else {
                    $('#refer-letter-div').hide();
                }
            });
        });

        $(document).on('click', '.refer-letter-link', function(e) {
            e.preventDefault();
            $('#refer-letter-div').removeAttr("hidden");
            $('#refer-letter-div').show();
            $('#refer-letter-view').attr('src', $(this).data('refer_letter_path'));

        });
    </script>
@endsection
