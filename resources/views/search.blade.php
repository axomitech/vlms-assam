@extends('layouts.app')

@section('content')
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
                                    <div class="card-body">
                                        <form>
                                            @csrf <!-- CSRF token for Laravel -->
                                            <div class="row">
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
                                            </div>
                                            
                                            <div class="row mt-2">
                                                <div class="col-md-2">
                                                    Category:
                                                </div>
                                                <div class="col-md-3 text-left">
                                                    <select class="form-control" id="category" name="category">
                                                        <option value="" {{ request('category') == '' ? 'selected' : '' }}>Select</option>
                                                        @foreach ($categories as $c)
                                                            <option value="{{ $c->id }}" {{ request('category') == $c->id ? 'selected' : '' }}>
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
                                                    <button type="reset" class="btn" id="btn-search"
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
@section('scripts')
@include('layouts.scripts')
    <script>
        $(document).ready(function() {


            $('#btn-search').click(function(event) {
                event.preventDefault(); // Prevent default form submission

                // Serialize form data
                // tinymce.activeEditor.setContent("<p>Hello world!</p>");
                var diarized_no = $('#diarized_no').val();
                var letter_no = $('#letter_no').val();
                var received_from = $('#received_from').val();
                var received_to = $('#received_to').val();
                var category = $('#category').val();
                var letter_category = $('#letter_category').val();
                // var formData = $('#letter-form').serialize();
                // alert(diarized_no);
                // exit();
                var formData = {
                    diarized_no: diarized_no,
                    letter_no: letter_no,
                    received_from: received_from,
                    received_to: received_to,
                    category: category,
                    letter_category: letter_category,
                    _token: '{{ csrf_token() }}' // Include CSRF token if using Laravel
                };
                // Ajax request
                showLoading();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('submit.search') }}', // Replace with your server-side script URL
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
@endsection
@endsection
