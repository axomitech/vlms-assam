@extends('layouts.app')

@section('content')
    <style>
        .custom-dropdown-width {
            min-width: 200px;
            /* Adjust width to fit longest item */
            margin-right: 100px;
            /* Adds space from left edge */
        }
    </style>
    <form id="letter-complete-form">
        <input type="hidden" id="stage_letter" name="stage_letter">
        <input type="hidden" id="stage" name="stage" value="5">
    </form>
    <div class="row">
        <div class="col-md-12">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link btn-lg active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home"
                        type="button" role="tab" aria-controls="nav-home"
                        aria-selected="true"><strong>Diarized</strong></button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="box shadow-lg p-3 mb-5 bg-white rounded">
                        <div class="box-body">
                            <table class="table table-sm table-hover table-striped letter-table" id="diarized-table">
                                <thead>
                                    <tr>
                                        <th colspan="6" class="text text-center">Diarized Letters</th>
                                    </tr>
                                    <tr class="text text-sm text-justify">
                                        <th>Sl no.</th>
                                        <th>Diarized Details</th>
                                        <th>Subject</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Letter</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($letters as $value)
                                        <tr class="text text-sm text-justify">
                                            <td>{{ $i }}</td>
                                            <td>

                                                <a href="javascript:void(0)" class="letter-link" data-toggle="modal"
                                                    data-target=".bd-example-modal-lg" data-letter="{{ $value->id }}"
                                                    data-letter_path="{{ route('letter.download', $value->id) }}">
                                                    {{ $value->crn }}
                                                </a>


                                                <br>
                                                ECR No.: <b>{{ $value->ecr_no }}</b>
                                                <br>Diarize Date:
                                                {{ \Carbon\Carbon::parse($value->diary_date)->format('d/m/Y') }}
                                                <br>Received Date:
                                                {{ \Carbon\Carbon::parse($value->received_date)->format('d/m/Y') }}
                                                <br>Diarized By: {{ $letter->diarizer->name ?? 'N/A' }}
                                            </td>

                                            <td style="width: 30%;">
                                                @if (strlen($value['subject']) > 100)
                                                    <div class="text-block" id="textBlock1">
                                                        <p class="shortText text-justify text-sm">
                                                            {{ substr($value['subject'], 0, 100) }}...
                                                            <a href="#" class="readMore">Read more</a>
                                                        </p>
                                                        <div class="longText" style="display: none;">
                                                            <p class="text-sm text-justify">
                                                                {{ $value['subject'] }}
                                                                <a href="#" class="readLess">Read less</a>
                                                            </p>
                                                        </div>
                                                    @else
                                                        {{ $value['subject'] }}
                                                @endif
                                                <br>Letter No: <b>{{ $value['letter_no'] }}</b>
                                                <br>Letter Date:
                                                {{ \Carbon\Carbon::parse($value['letter_date'])->format('d/m/Y') }}
                                            </td>
                                            <td>

                                                @if ($value->receipt == 0)
                                                    {{ $value->recipient->recipient_name ?? 'No Recipient' }},
                                                    <br>
                                                    {{ $value->recipient->recipient_designation ?? '' }},
                                                    <br>
                                                    {{ $value->recipient->organization ?? '' }}
                                                @else
                                                    {{ $value->sender->sender_name ?? 'No Sender' }},
                                                    <br>
                                                    {{ $value->sender->sender_designation ?? '' }},
                                                    <br>
                                                    {{ $value->sender->organization ?? '' }}
                                                @endif

                                            </td>

                                            <td>{{ $value->category->category_name ?? 'N/A' }}</td>
                                            <td>{{ $value->subcategory->sub_category_name ?? 'N/A' }}</td>
                                            <td>
                                                @if ($value['receipt'] == true)
                                                    Receipt
                                                @else
                                                    Issued
                                                @endif
                                            </td>

                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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

                        <div class="col-md-5" id="refer-div">
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-body">
                                    <form id="refer-form">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">Reference Letter<span
                                                    class="text text-danger fw-bold">*</span></label>
                                            <select class="form-control js-example-basic-multiple" name="refer_letters[]"
                                                id="refer_letters" multiple="multiple">
                                                <option value="">Letter No</option>
                                                @foreach ($letterNos as $value)
                                                    <option value="{{ $value['letter_no'] }}">
                                                        {{ $value['letter_no'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label class="text text-danger refer_letters fw-bold"></label>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="assign_letter" class="assign_letter" value="">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5" id="refer-letter-div" hidden>
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-body">
                                    <iframe src="" style="width: 100%; height: 400px;"
                                        id="refer-letter-view"></iframe>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="card card-primary card-outline card-outline-tabs plate">
                                <div class="card-body">
                                    <iframe src="" style="width: 100%; height: 400px;" id="letter-view"></iframe>
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

@section('scripts')
    <script>
        $(document).on('click', '.file-btn, .assign-link, .letter-link', function() {
            $('#letter-view').attr('src', $(this).data('letter_path'));
            $('#assign-div').show();
            $('#refer-div').hide();
            $('#exampleModalLabel').html("<strong>Assign Letter within CMO</strong>");
        });
        $(document).on('click', '.file-btn, .refer-link', function() {
            $('#letter-view').attr('src', $(this).data('letter_path'));
            $('#assign-div').hide();
            $('#refer-div').show();
            $('#exampleModalLabel').html("<strong>Add Reference Letter(s)</strong>");
        });
    </script>

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
    <script>
        $(document).on('click', '.archive', function() {
            $('#stage_letter').val($(this).data('letter'));
        });
    </script>
    <script src="{{ asset('js/custom/common.js') }}"></script>
    <script>
        $(document).on('click', '.letter-link', function() {

            let letterId = $(this).data('letter');
            let url = "/letter/download/" + letterId;

            $('#letter-view').attr('src', url);
        });
    </script>
    <script>
        $(function() {
            $("#archive-table").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": [{
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel green" style="color:green"></i>',
                    titleAttr: 'Excel'
                }, {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf" style="color:red"></i>',
                    titleAttr: 'PDF'
                }]
            }).buttons().container().appendTo('#archive-table_wrapper  .col-md-6:eq(0)');
            $(".buttons-html5").addClass("btn-sm");
            $(".buttons-html5").removeClass('btn-secondary');
            $(".buttons-print").addClass("btn-sm");
            $(".buttons-print").removeClass('btn-secondary');

            $("#sent-table").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": [{
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel green" style="color:green"></i>',
                    titleAttr: 'Excel'
                }, {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf" style="color:red"></i>',
                    titleAttr: 'PDF'
                }]
            }).buttons().container().appendTo('#sent-table_wrapper .col-md-6:eq(0)');
            $(".buttons-html5").addClass("btn-sm");
            $(".buttons-html5").removeClass('btn-secondary');
            $(".buttons-print").addClass("btn-sm");
            $(".buttons-print").removeClass('btn-secondary');

            $("#inbox-table").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": [{
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel green" style="color:green"></i>',
                    titleAttr: 'Excel'
                }, {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf" style="color:red"></i>',
                    titleAttr: 'PDF'
                }]
            }).buttons().container().appendTo('#inbox-table_wrapper .col-md-6:eq(0)');
            $(".buttons-html5").addClass("btn-sm");
            $(".buttons-html5").removeClass('btn-secondary');
            $(".buttons-print").addClass("btn-sm");
            $(".buttons-print").removeClass('btn-secondary');

            $("#action-table").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": [{
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel green" style="color:green"></i>',
                    titleAttr: 'Excel'
                }, {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf" style="color:red"></i>',
                    titleAttr: 'PDF'
                }]
            }).buttons().container().appendTo('#action-table_wrapper .col-md-6:eq(0)');
            $(".buttons-html5").addClass("btn-sm");
            $(".buttons-html5").removeClass('btn-secondary');
            $(".buttons-print").addClass("btn-sm");
            $(".buttons-print").removeClass('btn-secondary');

            $("#process-table").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": [{
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel green" style="color:green"></i>',
                    titleAttr: 'Excel'
                }, {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf" style="color:red"></i>',
                    titleAttr: 'PDF'
                }]
            }).buttons().container().appendTo('#process-table_wrapper .col-md-6:eq(0)');
            $(".buttons-html5").addClass("btn-sm");
            $(".buttons-html5").removeClass('btn-secondary');
            $(".buttons-print").addClass("btn-sm");
            $(".buttons-print").removeClass('btn-secondary');

            $("#completed-table").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": [{
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel green" style="color:green"></i>',
                    titleAttr: 'Excel'
                }, {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf" style="color:red"></i>',
                    titleAttr: 'PDF'
                }]
            }).buttons().container().appendTo('#completed-table_wrapper .col-md-6:eq(0)');
            $(".buttons-html5").addClass("btn-sm");
            $(".buttons-html5").removeClass('btn-secondary');
            $(".buttons-print").addClass("btn-sm");
            $(".buttons-print").removeClass('btn-secondary');

            $("#diarized-table").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": [{
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel green" style="color:green"></i>',
                    titleAttr: 'Excel'
                }, {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf" style="color:red"></i>',
                    titleAttr: 'PDF'
                }]
            }).buttons().container().appendTo('#diarized-table_wrapper .col-md-6:eq(0)');
            $(".buttons-html5").addClass("btn-sm");
            $(".buttons-html5").removeClass('btn-secondary');
            $(".buttons-print").addClass("btn-sm");
            $(".buttons-print").removeClass('btn-secondary');
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.readMore').on('click', function(event) {
                event.preventDefault();
                var textBlock = $(this).closest('.text-block');
                textBlock.find('.shortText').hide();
                textBlock.find('.longText').show();
            });

            $('.readLess').on('click', function(event) {
                event.preventDefault();
                var textBlock = $(this).closest('.text-block');
                textBlock.find('.longText').hide();
                textBlock.find('.shortText').show();
            });
        });

        $(document).on('click', '.assign-link,.refer-link', function() {
            $('#refers').html("");
            $('#refer-letter-div').hide();
            $('.assign_letter').val($(this).data('letter'));
            $('.forward_from').val($(this).data('forward'));

        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const segments = window.location.href.split("/");
            const tab = segments[segments.length - 1];
            // Check if 'tab' exists and switch to the appropriate tab
            if (tab) {
                if (tab === 'inbox') {
                    document.getElementById('nav-inbox-tab').click(); // Switch to Inbox tab
                } else if (tab === 'sent') {
                    document.getElementById('nav-sent-tab').click(); // Switch to Sent tab
                } else if (tab === 'archive') {
                    document.getElementById('nav-archive-tab').click(); // Switch to Archive tab
                } else if (tab === 'process') {
                    document.getElementById('nav-process-tab').click(); // Switch to Archive tab
                } else if (tab === 'completed') {
                    document.getElementById('nav-completed-tab').click(); // Switch to Archive tab
                } else if (tab === 'action') {
                    document.getElementById('nav-action-tab').click(); // Switch to Archive tab
                }
            }
        });

        $(document).on('click', '#hod-forward', function() {

        });
        $(document).on('click', '.letter-link', function() {
            $('#refers').html("");
            $('#assign-div').hide();
            $('#letter-view').attr('src', $(this).data('letter_path'));
            $.get("{{ route('reference') }}", {
                letter: $(this).data('letter')
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
        $('.js-example-basic-multiple').select2();
        $(document).on('click', '.refer-letter-link', function(e) {
            e.preventDefault();
            $('#refer-letter-div').removeAttr("hidden");
            $('#refer-letter-div').show();
            $('#refer-letter-view').attr('src', $(this).data('refer_letter_path'));

        });
    </script>
@endsection
@endsection
