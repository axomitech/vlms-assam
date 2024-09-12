@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 text-center">
            <button class="btn btn-dark btn-sm" id="resetView" style="float: left; display: none;">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
            </button>
            <h4 id="selectedCategoryName">Receipt</h4>
        </div>
    </div>

    <!-- Cards row -->
    <div class="row mt-1" id="cardsContainer">
        <div class="box-body col-md-12">
            <section class="content">
                <div class="container-fluid">
                    @if (session('role') > 0)
                        @php
                            $colors = ['#55fe9b', '#f39c12', '#00c0ef', '#dd4b39', '#00a65a', '#3c8dbc', '#f56954'];
                            $i = 0;
                        @endphp

                        <!-- Start the outer row -->
                        <div class="row">
                            @foreach ($categories as $category)
                                <!-- Create a new row after every 3 cards -->
                                @if ($loop->index % 3 == 0 && !$loop->first)
                        </div>
                        <div class="row">
                    @endif

                    <div class="col-md-4 col-sm-6">
                        <a href="#" class="category-card" data-category-id="{{ $category->id }}"
                            data-category-name="{{ $category->category_name }}">
                            <div class="small-box" style="background-color: {{ $colors[$i % count($colors)] }};">
                                <div class="inner">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h3 style="color:white;">{{ $category->count }} </h3>
                                                </div>
                                                <div class="col-lg-12">
                                                    <h3 style="font-size: 22px;color:white;">
                                                        {{ $category->category_name }} </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <span style="font-size: 40px;color:white;">
                                                <i class="fas fa-file-invoice"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    @php
                        $i++;
                    @endphp
                    @endforeach
                </div> <!-- End of the outer row -->
                @endif
        </div>
        </section>
    </div>
    </div>

    <div class="box shadow-lg p-3 mb-5 bg-white rounded min-vh-40" id="lettersTable" style="display: none;">
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
    <!-- DataTables  & Plugins -->
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
    <script>
        $(document).ready(function() {
    // Handle card click
    $('.category-card').on('click', function(e) {
        e.preventDefault();

        // Get category info
        let categoryId = $(this).data('category-id');
        let categoryName = $(this).data('category-name');

        // Fetch letters using AJAX
        $.ajax({
            url: '/receipt/' + categoryId,
            type: 'GET',
            success: function(response) {
                console.log(response);
                
                // Show selected category name
                $('#selectedCategoryName').text('Receipts from ' + categoryName);

                // Populate table with letters
                let tableBody = '';
                let serialNumber = 1; // Initialize serial number

                response.forEach(function(letter) {
                    let truncatedSubject = letter.subject.length > 100
                        ? `<div class="text-block" id="textBlock${letter.id}">
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
                          </div>`
                        : `<p>${letter.subject}</p>`;

                    tableBody += `<tr>
                        <td><small>${serialNumber++}</small></td>
                        <td><small>${letter.crn}</small></td>
                        <td style="width: 30%;">${truncatedSubject}</td>
                        <td><small>${letter.letter_no}</small></td>
                        <td><small>${letter.sender_name}</small></td>
                        <td><small>${letter.received_date}</small></td>
                    </tr>`;
                });

                $('#lettersList tbody').html(tableBody);

                // Show the table and back button, hide cards
                $('#cardsContainer').hide();
                $('#lettersTable').show();
                $('#resetView').show();
            }
        });
    });

    // Handle back button click to reset view
    $('#resetView').on('click', function() {
        $('#lettersTable').hide();
        $('#resetView').hide();
        $('#cardsContainer').show();
        $('#selectedCategoryName').text('Receipt');
    });

    // Handle Read More/Read Less click
    $(document).on('click', '.readMore', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        $(`#textBlock${id} .shortText`).hide();
        $(`#textBlock${id} .longText`).show();
    });

    $(document).on('click', '.readLess', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        $(`#textBlock${id} .shortText`).show();
        $(`#textBlock${id} .longText`).hide();
    });
});

    </script>
    <script>
        $(function() {
            $("#letter-table").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["excel", "pdf", "print"]
            }).buttons().container().appendTo('#letter-table_wrapper .col-md-6:eq(0)');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-3d"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
@endsection
