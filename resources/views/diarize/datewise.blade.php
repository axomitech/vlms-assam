@extends('layouts.app')
@section('content')
    <div class="col-md-12 text-center">
        <button class="btn btn-dark btn-sm" id="resetView" style="float: left;">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
        </button>
        <h4><strong>Letter Download By Date</strong></h4>
    </div>
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-body">
                    <!-- Loading Overlay -->
                    <div id="loading-overlay" style="display:none;">
                        <div class="spinner"></div>
                        <p>Loading...</p>
                    </div>
                    <div class="row">
                        <div class="col-md-12 ">
                            <form id="letter-form">
                                <div class="card font-weight-bold" style="background-color:#f8f5ec">
                                    <div class="card-body" style="background-color: #eeefff;">
                                        <form>
                                            @csrf <!-- CSRF token for Laravel -->
                                            <div class="row mt-2">
                                                <div class="col-md-2">
                                                    Text Search:
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" id="text_search"
                                                        name="text_search"
                                                        placeholder="Search by letter number, subject, letter no, diarize no, sender, recipient, category, sub-category etc.">
                                                </div>
                                            </div>

                                            {{-- <div class="row mt-2">
                                                <div class="col-md-2">
                                                    Diarized Number:
                                                </div>
                                                <div class="col-md-3 text-left">
                                                    <input type="text" class="form-control" id="diarized_no"
                                                        placeholder="">
                                                </div>
                                                <div class="col-md-2 offset-md-1">
                                                    Letter Number:
                                                </div>
                                                <div class="col-md-3 text-left">
                                                    <input type="text" class="form-control" id="letter_no"
                                                        placeholder="">
                                                </div>
                                            </div> --}}

                                            <div class="row mt-4">
                                                <div class="col-md-2">
                                                    Category:
                                                </div>
                                                <div class="col-md-3 text-left">
                                                    <select class="form-control" id="category" name="category">
                                                        <option value=""
                                                            {{ request('category') == '' ? 'selected' : '' }}>Select
                                                        </option>
                                                        @foreach ($categories as $c)
                                                            <option value="{{ $c->id }}"
                                                                {{ request('category') == $c->id ? 'selected' : '' }}>
                                                                {{ $c->category_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                                <div class="col-md-2 offset-md-1">
                                                    Received/Issued Date:
                                                </div>
                                                <div class="col-md-2 text-left">
                                                    <input type="date" class="form-control" id="received_from"
                                                        placeholder="">
                                                    <small id="emailHelp" class="form-text text-muted">From</small>
                                                </div>
                                                <div class="col-md-2 text-left">
                                                    <input type="date" class="form-control" id="received_to"
                                                        placeholder="">
                                                    <small id="emailHelp" class="form-text text-muted">To</small>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-2">
                                                    Sub-Category:
                                                </div>
                                                <div class="col-md-3 text-left">
                                                    <select class="form-control" id="subcategory" name="subcategory">
                                                        <option value=""
                                                            {{ request('subcategory') == '' ? 'selected' : '' }}>Select
                                                        </option>
                                                        @foreach ($subcategory as $c)
                                                            <option value="{{ $c->id }}"
                                                                {{ request('subcategory') == $c->id ? 'selected' : '' }}>
                                                                {{ $c->sub_category_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                                <div class="col-md-2 offset-md-1">
                                                    Letter Category:
                                                </div>
                                                <div class="col-md-3 text-left">
                                                    <select class="form-control" id="letter_category">
                                                        <option value="">Select</option>
                                                        <option value="issue">Issue</option>
                                                        <option value="receipt">Receipt</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-12 text-center">
                                                    <button type="submit" class="btn" id="btn-search"
                                                        style="background-color: #174060;color: white;">Search</button>
                                                    &nbsp;
                                                    <button type="reset" class="btn" id="btn-reset"
                                                        style="background-color: #174060;color: white;">Reset</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- hdhadh -->
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <span class='table_span'>No Results</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong>Assign Letter Within CMO</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary card-outline card-outline-tabs plate">
                                <div class="card-body">
                                    <iframe src="" style="width: 100%; height: 400px;" id="letter-view"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@section('scripts')
    @include('layouts.scripts')
    <script>
        document.getElementById('resetView').addEventListener('click', function() {
            window.location.href = "{{ route('dashboard') }}";
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#btn-search').click(function(event) {
                event.preventDefault(); // Prevent default form submission

                // Serialize form data
                // tinymce.activeEditor.setContent("<p>Hello world!</p>");
                // var diarized_no = $('#diarized_no').val();
                // var letter_no = $('#letter_no').val();
                var received_from = $('#received_from').val();
                var received_to = $('#received_to').val();
                var category = $('#category').val();
                var subcategory = $('#subcategory').val();
                var letter_category = $('#letter_category').val();
                var text_search = $('#text_search').val(); // Include text search

                // var formData = $('#letter-form').serialize();
                // alert(text_search);
                // exit();
                var formData = {
                    // diarized_no: diarized_no,
                    // letter_no: letter_no,
                    received_from: received_from,
                    received_to: received_to,
                    category: category,
                    subcategory: subcategory,
                    letter_category: letter_category,
                    text_search: text_search, // Include text search

                    _token: '{{ csrf_token() }}' // Include CSRF token if using Laravel
                };
                // Ajax request
                showLoading();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('submit.datewise') }}', // Replace with your server-side script URL
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        // Handle success response
                        // var data = JSON.parse(response);
                        // alert("Letter saved successfully!");
                        $('.table_span').html(response.diarized_no);
                        $('#letter-table').DataTable({
                            "destroy": true, //use for reinitialize datatable
                        });
                        hideLoading();
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error('Error:', error);
                        hideLoading();
                    }
                });
            });
        });

        $(document).ready(function() {
            var category = $('#category').val();

            if (category) {
                $('#btn-search').click(); // Trigger the search button click programmatically
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#letter-table').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "destroy": true, // Reinitialize if needed
                "buttons": [{
                        extend: 'excelHtml5',
                        text: 'Export Excel',
                        className: 'btn btn-success'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'Export PDF',
                        className: 'btn btn-danger'
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        className: 'btn btn-primary'
                    },
                    {
                        extend: 'colvis',
                        text: 'Column Visibility',
                        className: 'btn btn-info'
                    }
                ]
            }).buttons().container().appendTo(
                '#letter-table_wrapper .col-md-6:eq(0)'); // Adjust the container as per your layout
        });
    </script>
    <script>
        $(document).on('click', '.assign-link', function() {
            $('#letter-view').attr('src', $(this).data('letter_path'));
            $('#exampleModalLabel').html("<strong>Letter No.: " + $(this).data('letter') + "</strong>");
        });
    </script>
@endsection
@endsection
