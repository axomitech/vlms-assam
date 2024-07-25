@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
            <div class="card-body">
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
                                                <input type="text" class="form-control" id="diarized_no" placeholder="">
                                            </div>
                                            <div class="col-md-2 offset-md-1">
                                                Letter Number:
                                            </div>
                                            <div class="col-md-3 text-left">
                                                <input type="text" class="form-control" id="letter_no" placeholder="">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-2">
                                                Category:
                                            </div>
                                            <div class="col-md-3 text-left">
                                                <select class="form-control" id="category">
                                                    <option>Select</option>
                                                    <option value="pmo">Prime Minister Office</option>
                                                    <option value="pmo">President Office</option>
                                                    <option value="pmo">Governor Officer</option>
                                                    <option>MP</option>
                                                    <option>MLA</option>
                                                    <option>Others</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 offset-md-1">
                                                Received Date:
                                            </div>
                                            <div class="col-md-2 text-left">
                                                <input type="date" class="form-control" id="received_from" placeholder="">
                                                <small id="emailHelp" class="form-text text-muted">From</small>
                                            </div>
                                            <div class="col-md-2 text-left">
                                                <input type="date" class="form-control" id="received_to" placeholder="">
                                                <small id="emailHelp" class="form-text text-muted">To</small>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-12 text-center">
                                                <button type="submit" class="btn" id="btn-search" style="background-color: #174060;color: white;">Search</button>
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
<script src="{{asset('js/custom/common.js')}}"></script>

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
                // var formData = $('#letter-form').serialize();
                // alert(diarized_no);
                // exit();
                var formData = {
                    diarized_no: diarized_no,
                    letter_no: letter_no,
                    received_from: received_from,
                    received_to: received_to,
                    category: category,
                    _token: '{{ csrf_token() }}' // Include CSRF token if using Laravel
                };
                // Ajax request
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
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
    <script>
       $(function () {
                $("#letter-table").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": [ "excel", "pdf", "print"]
                }).buttons().container().appendTo('#letter-table_wrapper .col-md-6:eq(0)');
                
            });

    </script>
    
@endsection
@endsection
