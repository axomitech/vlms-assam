@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="box shadow-lg p-3 mb-5 bg-white rounded">
                    <div class="box-body">
                        <table class="table table-sm table-hover table-striped letter-table" id="inbox-table">
                            <thead>
                                <tr>
                                    <th colspan="6" class="text text-center">Diarized Legacy Letters</th>
                                </tr>
                                <tr class="text text-sm text-justify">
                                    <th>Sl no.</th>
                                    <th>Diary</th>
                                    <th>Subject</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Letter</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($letters as $value)
                                    <tr class="text text-sm text-justify">
                                        <td>{{ $i }}</td>
                                        <td> &nbsp;{{ $value['crn'] }}
                                            <br>Diarize Date:{{ \Carbon\Carbon::parse($value['diary_date'])->format('d/m/Y') }}
                                            <br>Recieved
                                            Date:{{ \Carbon\Carbon::parse($value['received_date'])->format('d/m/Y') }}
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
                                            <br>Letter No: {{ $value['letter_no'] }}
                                            <br>Letter Date:
                                            {{ \Carbon\Carbon::parse($value['letter_date'])->format('d/m/Y') }}
                                        </td>


                                        <td>
                                            {{ $value->recipient_name }}
                                            {{ $value->sender_name }},
                                            <br>
                                            {{ $value->sender_designation }},{{ $value['organization'] }}
                                        </td>
                                        <td>{{ $value['category_name'] }}</td>
                                        <td>
                                            @if ($value['receipt'] == true)
                                                Receipt
                                            @else
                                                Issued
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('edit_diarize', [encrypt($value['letter_id'])]) }}">
                                                <span
                                                    class="btn btn-sm btn-warning w-100 d-flex align-items-center mt-2 justify-content-center"
                                                    title="Edit Letter"
                                                    style="min-height: 30px; font-size: 12px;">
                                                    Edit
                                                    <i class="fas fa-edit ml-1"></i>
                                                </span>
                                            </a>
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
@section('scripts')
    <script>
        $(document).on('click', '.file-btn, .assign-link', function() {
            $('#letter-view').attr('src', $(this).data('letter_path'));
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

        $(document).on('click', '.assign-link', function() {

            $('.assign_letter').val($(this).data('letter'));
            $('.forward_from').val($(this).data('forward'));

        });
    </script>
    <!-- Add the JavaScript to handle tab switching based on the URL parameter -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the URL parameter 'tab'
            const urlParams = new URLSearchParams(window.location.search);
            const tab = urlParams.get('tab');

            // Check if 'tab' exists and switch to the appropriate tab
            if (tab) {
                if (tab === 'inbox') {
                    document.getElementById('nav-inbox-tab').click(); // Switch to Inbox tab
                } else if (tab === 'sent') {
                    document.getElementById('nav-sent-tab').click(); // Switch to Sent tab
                } else if (tab === 'archive') {
                    document.getElementById('nav-archive-tab').click(); // Switch to Archive tab
                }
            }
        });
    </script>
    </script>
    <!-- Add the JavaScript to handle tab switching based on the URL parameter -->
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
                }
            }
        });
    </script>
@endsection
@endsection
