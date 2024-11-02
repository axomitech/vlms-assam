@extends('layouts.app')

@section('content')
    <form id="letter-complete-form">
        <input type="hidden" id="stage_letter" name="stage_letter">
        <input type="hidden" id="stage" name="stage" value="5">
    </form>
    <div class="row">
        <div class="col-md-12">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    @if (session('role') == 1)
                        <button class="nav-link btn-lg active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home"
                            type="button" role="tab" aria-controls="nav-home"
                            aria-selected="true"><strong>Diarized</strong></button>
                    @else
                        <button class="nav-link btn-lg active" id="nav-inbox-tab" data-toggle="tab"
                            data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                            aria-selected="false"><strong>Inbox</strong></button>
                        <button class="nav-link btn-lg" id="nav-sent-tab" data-toggle="tab" data-target="#nav-contact"
                            type="button" role="tab" aria-controls="nav-contact"
                            aria-selected="false"><strong>Sent</strong></button>
                        <button class="nav-link btn-lg" id="nav-archive-tab" data-toggle="tab" data-target="#nav-archive"
                            type="button" role="tab" aria-controls="nav-profile"
                            aria-selected="false"><strong>Archived</strong></button>
                    @endif
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                @if (session('role') == 1)
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="box shadow-lg p-3 mb-5 bg-white rounded">
                            <div class="box-body">
                                <table class="table table-sm table-hover table-striped letter-table" id="inbox-table">
                                    <thead>
                                        <tr>
                                            <th colspan="6" class="text text-center">Diarized Letters</th>
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
                                                    @if ($assignedLetters[$i - 1] <= 0)
                                                        <div class="mb-1">
                                                            @if ($legacy == 0)
                                                                <a href="javascript:void(0);" class="assign-link"
                                                                    data-toggle="modal" data-target=".bd-example-modal-lg"
                                                                    data-letter="{{ $value['letter_id'] }}"
                                                                    data-letter_path="{{ storageUrl($value['letter_path']) }}">
                                                                    <span
                                                                        class="btn btn-sm btn-primary w-100 d-flex align-items-center justify-content-center"
                                                                        title="Assign Letter"
                                                                        style="min-height: 30px; font-size: 12px;">
                                                                        Assign
                                                                        <i class="fas fa-paper-plane ml-1"></i>
                                                                    </span>
                                                                </a>
                                                            @endif
                                                            <a
                                                                href="{{ route('edit_diarize', [encrypt($value['letter_id'])]) }}">
                                                                <span
                                                                    class="btn btn-sm btn-warning w-100 d-flex align-items-center mt-2 justify-content-center"
                                                                    title="Edit Letter"
                                                                    style="min-height: 30px; font-size: 12px;">
                                                                    Edit
                                                                    <i class="fas fa-edit ml-1"></i>
                                                                </span>
                                                            </a>

                                                        </div>
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
                @else
                    <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-inbox-tab">
                        <div class="box shadow-lg p-3 mb-5 bg-white rounded">
                            <div class="box-body">
                                <table class="table table-sm table-hover table-striped" id="letter-table">
                                    <thead>
                                        <tr class="text text-sm text-justify">
                                            <th>Sl no.</th>
                                            <th>Diary</th>
                                            <th>Subject</th>
                                            <th>Sender</th>
                                            <th>Category</th>
                                            <th>Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($inboxLetters as $value)
                                            <tr class="text text-sm text-justify">
                                                <td>{{ $i }}</td>
                                                <td>{{ $value['crn'] }}
                                                    <br>Diarize
                                                    Date:{{ \Carbon\Carbon::parse($value['diary_date'])->format('d/m/Y') }}
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

                                                <td>{{ $value['sender_name'] }},<br>
                                                    {{ $value['sender_designation'] }},{{ $value['organization'] }}</td>
                                                <td>{{ $value['category_name'] }}</td>
                                                <td>
                                                    @if (session('role') == 2)
                                                        <div class="mb-1">
                                                            <a href="{{ route('action_lists', [encrypt($value['letter_id'])]) }}"
                                                                class="action-link btn btn-sm btn-primary w-100 d-flex align-items-center justify-content-center"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="View/Update"
                                                                style="min-height: 30px; font-size: 12px;">
                                                                <i class="fas fa-edit mr-1"></i> View/Update
                                                            </a>
                                                        </div>
                                                    @endif


                                                    @if (session('role') == 3)
                                                        &nbsp;
                                                <td>
                                                    @isset($assignedSentLetters[$i - 1])
                                                        @if ($assignedSentLetters[$i - 1] > 0)
                                                            <div class="mb-1">
                                                                <a href="{{ route('actions', [encrypt($value['letter_id'])]) }}"
                                                                    class="action-link btn btn-sm btn-primary w-100 d-flex align-items-center justify-content-center"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title="Add Action Points"
                                                                    style="min-height: 30px; font-size: 12px;">
                                                                    <i class="fas fa-edit mr-1"></i> Add Actions
                                                                </a>
                                                            </div>
                                                        @else
                                                        @endif
                                                    @endisset

                                                    <div class="mb-1">
                                                        <a href="{{ route('acknowledge_letter', [$value['letter_id']]) }}"
                                                            class="action-link btn btn-sm btn-success w-100 d-flex align-items-center justify-content-center"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="Acknowledgement Letter Generation"
                                                            style="min-height: 30px; font-size: 12px;">
                                                            <i class="fas fa-envelope-open-text mr-1"></i> Acknowledge
                                                        </a>
                                                    </div>
                                                    <div class="mb-1">
                                                        <a href="{{ route('inbox', [encrypt($value['letter_id'])]) }}"
                                                            class="action-link btn btn-sm btn-info w-100 d-flex align-items-center justify-content-center"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="Acknowledgement Letter Generation"
                                                            style="min-height: 30px; font-size: 12px;">
                                                            <i class="fas fa-envelope-open-text mr-1"></i> Respond
                                                        </a>

                                                    </div>
                                                    <div class="mb-1">
                                                        <a href="{{ route('correspondences', [$value['letter_id']]) }}"
                                                            class="action-link btn btn-sm btn-warning w-100 d-flex align-items-center justify-content-center"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="Correspondences"
                                                            style="min-height: 30px; font-size: 12px;">
                                                            <i class="fas fa-file-alt mr-1"></i> Correspondences
                                                        </a>
                                                    </div>
                                                </td>
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
    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-sent-tab">
        <div class="box shadow-lg p-3 mb-5 bg-white rounded">
            <div class="box-body">
                <table class="table table-sm table-hover table-striped letter-table" id="sent-table">
                    <thead>
                        <tr>
                            <th colspan="6" class="text text-center">Sent Letters</th>
                        </tr>
                        <tr class="text text-sm text-justify">
                            <th>Sl no.</th>
                            <th>Diary</th>
                            <th>Subject</th>
                            <th>Sender</th>
                            <th>Category</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($sentLetters as $value)
                            <tr class="text text-sm text-justify">
                                <td>{{ $i }}</td>
                                <td>
                                    {{ $value['crn'] }}
                                    <br>
                                    Diarize
                                    Date:{{ \Carbon\Carbon::parse($value['diary_date'])->format('d/m/Y') }}
                                    <br>
                                    Recieved
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

                                <td>{{ $value['sender_name'] }},<br>
                                    {{ $value['sender_designation'] }},{{ $value['organization'] }}
                                </td>
                                <td>{{ $value['category_name'] }}</td>
                                <td>
                                    @if (session('role') == 2)
                                        <div class="mb-1">
                                            <a href="{{ route('action_lists', [encrypt($value['letter_id'])]) }}"
                                                class="action-link btn btn-sm btn-primary w-100 d-flex align-items-center justify-content-center"
                                                data-toggle="tooltip" data-placement="top" title="View/Update"
                                                style="min-height: 30px; font-size: 12px;">
                                                <i class="fas fa-edit mr-1"></i> View/Update
                                            </a>
                                        </div>
                                    @endif

                                    @if (session('role') == 3)
                                        <div class="mb-1">
                                            @if ($assignedSentLetters[$i - 1] > 0)
                                                <a href="{{ route('actions', [encrypt($value['letter_id'])]) }}"
                                                    class="action-link btn btn-sm btn-primary w-100 d-flex align-items-center justify-content-center"
                                                    data-toggle="tooltip" data-placement="top" title="Add Actions"
                                                    style="min-height: 30px; font-size: 12px;">
                                                    <i class="fas fa-edit mr-1"></i> Add Actions
                                                </a>
                                            @endif
                                        </div>

                                        <div class="mb-1">
                                            <a href="{{ route('acknowledge_letter', [$value['letter_id']]) }}"
                                                class="action-link btn btn-sm btn-success w-100 d-flex align-items-center justify-content-center"
                                                data-toggle="tooltip" data-placement="top" title="Acknowledge"
                                                style="min-height: 30px; font-size: 12px;">
                                                <i class="fas fa-envelope-open-text mr-1"></i> Acknowledge
                                            </a>
                                        </div>

                                        <div class="mb-1">
                                            <a href="{{ route('correspondences', [$value['letter_id']]) }}"
                                                class="action-link btn btn-sm btn-warning w-100 d-flex align-items-center justify-content-center"
                                                data-toggle="tooltip" data-placement="top" title="Correspondences"
                                                style="min-height: 30px; font-size: 12px;">
                                                <i class="fas fa-file mr-1"></i> Correspondences
                                            </a>
                                        </div>
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
    <div class="tab-pane fade" id="nav-archive" role="tabpanel" aria-labelledby="nav-archive-tab">
        <div class="box shadow-lg p-3 mb-5 bg-white rounded">
            <div class="box-body">
                <div class="letter-table_wrapper">

                </div>
                <table class="table table-sm table-hover table-striped letter-table" id="archive-table">
                    <thead>
                        <tr>
                            <th colspan="6" class="text text-center">Archived Letters</th>
                        </tr>
                        <tr class="text text-sm text-justify">
                            <th>Sl no.</th>
                            <th>Diary</th>
                            <th>Subject</th>
                            <th>Sender</th>
                            <th>Category</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($archivedLetters as $value)
                            <tr class="text text-sm text-justify">
                                <td>{{ $i }}</td>
                                <td>
                                    {{ $value['crn'] }}
                                    <br>
                                    Diarize
                                    Date:{{ \Carbon\Carbon::parse($value['diary_date'])->format('d/m/Y') }}
                                    <br>
                                    Recieved
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
                                    <br>
                                    Letter No: {{ $value['letter_no'] }}
                                    <br>
                                    Letter Date:
                                    {{ \Carbon\Carbon::parse($value['letter_date'])->format('d/m/Y') }}
                                </td>

                                <td>{{ $value['sender_name'] }}<br>{{ $value['sender_designation'] }},{{ $value['organization'] }}
                                </td>
                                <td>{{ $value['category_name'] }},{{ $value['organization'] }}</td>
                                <td>
                                    @if (session('role') == 2)
                                        <div class="mb-1">
                                            <a href="{{ route('action_lists', [encrypt($value['letter_id'])]) }}"
                                                class="action-link btn btn-sm btn-primary w-100 d-flex align-items-center justify-content-center"
                                                data-toggle="tooltip" data-placement="top" title="View/Update"
                                                style="min-height: 30px; font-size: 12px;">
                                                <i class="fas fa-edit mr-1"></i> View/Update
                                            </a>
                                        </div>
                                    @endif

                                    @if (session('role') == 3)
                                        <div class="mb-1">
                                            <a href="{{ route('actions', [encrypt($value['letter_id'])]) }}"
                                                class="action-link btn btn-sm btn-primary w-100 d-flex align-items-center justify-content-center"
                                                data-toggle="tooltip" data-placement="top" title="View/Update"
                                                style="min-height: 30px; font-size: 12px;">
                                                <i class="fas fa-edit mr-1"></i> View/Update
                                            </a>
                                        </div>

                                        <div class="mb-1">
                                            <a href="{{ route('acknowledge_letter', [$value['letter_id']]) }}"
                                                class="action-link btn btn-sm btn-success w-100 d-flex align-items-center justify-content-center"
                                                data-toggle="tooltip" data-placement="top"
                                                title="Acknowledgement Letter Generation"
                                                style="min-height: 30px; font-size: 12px;">
                                                <i class="fas fa-envelope-open-text mr-1"></i> Acknowledge
                                            </a>
                                        </div>

                                        <div class="mb-1">
                                            <a href="{{ route('correspondences', [$value['letter_id']]) }}"
                                                class="action-link btn btn-sm btn-warning w-100 d-flex align-items-center justify-content-center"
                                                data-toggle="tooltip" data-placement="top" title="Correspondences"
                                                style="min-height: 30px; font-size: 12px;">
                                                <i class="fas fa-file mr-1"></i> Correspondences
                                            </a>
                                        </div>
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
    @endif

    </div>

    </div>
    </div>
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong>Send Letter</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-body">
                                    <form id="assign-form">
                                        <div class="form-group">
                                            <label for="assignee" class="col-form-label">Assign</label>
                                            <select class="form-control" name="assignee" id="assignee">
                                                <option value="">Select Assignee</option>
                                                @foreach ($departmentUsers as $value)
                                                    @if (session('role_user') != $value['user_id'])
                                                        <option value="{{ $value['user_id'] }}">{{ $value['name'] }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <label class="text text-danger assignee"></label>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="assign_letter" class="assign_letter"
                                                value="">
                                            <input type="hidden" name="forward_from" class="forward_from"
                                                value="">
                                            @if (session('role') != 1)
                                                <label for="assign_remarks" class="col-form-label">Remarks:</label>
                                                <textarea class="form-control" id="assign_remarks" name="assign_remarks" rows="4"></textarea>
                                                <label class="text text-danger assign_remarks"></label>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-primary save-btn"
                                            data-url="{{ route('assign_letter') }}" data-form="#assign-form"
                                            data-message="That you want to assign this letter!"
                                            id="assign-btn">ASSIGN</button>
                                    </form>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
