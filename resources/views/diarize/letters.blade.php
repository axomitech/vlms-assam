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
                    @if (session('role') == 1)
                        <button class="nav-link btn-lg active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home"
                            type="button" role="tab" aria-controls="nav-home"
                            aria-selected="true"><strong>Diarized</strong></button>
                    @else
                        <button class="nav-link btn-lg active" id="nav-inbox-tab" data-toggle="tab"
                            data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                            aria-selected="false"><strong>Inbox</strong></button>
                        @if (session('role_dept') == 1)
                            <button class="nav-link btn-lg" id="nav-sent-tab" data-toggle="tab" data-target="#nav-contact"
                                type="button" role="tab" aria-controls="nav-contact"
                                aria-selected="false"><strong>Sent</strong></button>
                            <button class="nav-link btn-lg" id="nav-archive-tab" data-toggle="tab"
                                data-target="#nav-archive" type="button" role="tab" aria-controls="nav-profile"
                                aria-selected="false"><strong>Archived</strong></button>
                        @elseif (session('role_dept') > 1)
                            <button class="nav-link btn-lg" id="nav-action-tab" data-toggle="tab" data-target="#nav-action"
                                type="button" role="tab" aria-controls="nav-action"
                                aria-selected="false"><strong>Action Taken</strong></button>

                            <button class="nav-link btn-lg" id="nav-process-tab" data-toggle="tab" data-target="#nav-process"
                                type="button" role="tab" aria-controls="nav-process"
                                aria-selected="false"><strong>In Process</strong></button>
                            <button class="nav-link btn-lg" id="nav-completed-tab" data-toggle="tab" data-target="#nav-completed"
                                type="button" role="tab" aria-controls="nav-completed"
                                aria-selected="false"><strong>Completed</strong></button>
                        @endif
                    @endif
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                @if (session('role') == 1)
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
                                                <td><a href="" href="" class="letter-link" data-toggle="modal"
                                                    data-target=".bd-example-modal-lg"
                                                    data-letter="{{ $value['letter_id'] }}" data-letter_path="{{ storageUrl($value['letter_path']) }}">{{ $value['crn'] }}</a>
                                                    <br>
                                                    ECR No.:<b>{{$value['ecr_no']}}</b>
                                                    <br>Diarize
                                                    Date:{{ \Carbon\Carbon::parse($value['diary_date'])->format('d/m/Y') }}
                                                    <br>Recieved
                                                    Date:{{ \Carbon\Carbon::parse($value['received_date'])->format('d/m/Y') }}
                                                    <br> Diarized By: {{$value['name']}}
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
                                                    <b>{{ $value->recipient_name }}
                                                    {{ $value->sender_name }},
                                                    <br>
                                                    {{ $value->sender_designation }},{{ $value['organization'] }}</b>
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
                                                    @if (session('role') == 1)
                                                    <a href="" class="refer-link"
                                                                            data-toggle="modal"
                                                                            data-target=".bd-example-modal-lg"
                                                                            data-letter="{{ $value['letter_id'] }}"
                                                                            data-letter_path="{{ storageUrl($value['letter_path']) }}">
                                                                            <span
                                                                                class="btn btn-sm btn-warning w-100 d-flex align-items-center justify-content-center"
                                                                                title="Refer Letter"
                                                                                style="min-height: 30px; font-size: 12px;">
                                                                                Refer a Letter
                                                                                <i class="fas fa-paper-plane ml-1"></i>
                                                                            </span>
                                                                        </a>
                                                    @if ($value['stage_status'] == 1) 
                                                    @if ($value['receipt'] == true)
                                                                        <div class="mb-1">

                                                                            <a href="" class="assign-link "
                                                                        data-toggle="modal"
                                                                        data-target=".bd-example-modal-lg"
                                                                        data-letter="{{ $value['letter_id'] }}"
                                                                        data-letter_path="{{ storageUrl($value['letter_path']) }}">
                                                                        <span
                                                                            class="btn btn-sm btn-danger w-100 d-flex align-items-center justify-content-center"
                                                                            title="Assign Letter"
                                                                            style="min-height: 30px; font-size: 12px;">
                                                                            @if (Auth::user()->id == $value['diarizer_id'])
                                                                            Pull Up
                                                                            <i class="fas fa-arrow-up ml-1"></i>
                                                                            @else
                                                                            Pull Back
                                                                            <i class="fas fa-arrow-left ml-1"></i>
                                                                            @endif
                                                                            
                                                                        </span>
                                                                    </a>
                                                                        
                                                                        </div>
                                                                   
                                                                    @endif  
                                                                        @endif
                                                                        
                                                        @if (!$assignedLetters[$i - 1])
                                                            <div class="mb-1">
                                                                @if (Auth::user()->id == $value['diarizer_id'])
                                                                @if ($legacy == 0)
                                                                    @if ($value['receipt'] == true)
                                                                    
                                                                        <a href="" class="assign-link"
                                                                            data-toggle="modal"
                                                                            data-target=".bd-example-modal-lg"
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
                                                                    
                                                                @endif

                                                            </div>
                                                        @endif
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
                    <div class="tab-pane fade show active" id="nav-profile" role="tabpanel"
                        aria-labelledby="nav-inbox-tab">
                        <div class="box shadow-lg p-3 mb-5 bg-white rounded">
                            <div class="box-body">
                                <table class="table table-sm table-hover table-striped" id="inbox-table">
                                    <thead>
                                        <tr>
                                            <th colspan="6" class="text text-center">Inbox Letters</th>
                                        </tr>
                                        <tr class="text text-sm text-justify">
                                            <th>Sl No.</th>
                                            <th>Diarized Details</th>
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
                                        @foreach ($inboxLetters[0] as $value)
                                            <tr class="text text-sm text-justify">
                                                <td>{{ $i }}</td>
                                                <td><a href="" href="" class="letter-link" data-toggle="modal"
                                                    data-target=".bd-example-modal-lg"
                                                    data-letter="{{ $value['letter_id'] }}" data-letter_path="{{ storageUrl($value['letter_path']) }}">{{ $value['crn'] }}</a>
                                                    <br>Diarize
                                                    Date:{{ \Carbon\Carbon::parse($value['diary_date'])->format('d/m/Y') }}
                                                    <br>Recieved
                                                    Date:{{ \Carbon\Carbon::parse($value['received_date'])->format('d/m/Y') }}
                                                    <br> ECR No.:<b>{{$value['ecr_no']}}</b>
                                                    <br> Diarized By: {{$value['name']}}
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

                                                <td><b>{{ $value['sender_name'] }},<br>
                                                    {{ $value['sender_designation'] }},{{ $value['organization'] }}</b></td>
                                                <td>{{ $value['category_name'] }}</td>
                                                <td>
                                                    @if ($value['stage_status']  == 1 || $value['stage_status']  == 2 || $value['stage_status'] == 6 || $value['stage_status'] == 3)
                                                    @if (session('role') == 3)
                                                    <div class="mb-1">
                                                        <a href="{{ route('inbox', [encrypt($value['letter_id'])]) }}"
                                                            class="action-link btn btn-sm btn-warning w-100 d-flex align-items-center justify-content-center"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="Correspondences"
                                                            style="min-height: 30px; font-size: 12px;">
                                                            <i class="fas fa-reply mr-1"></i> Respond
                                                        </a>
                                                    </div>
                                                    @endif
                                                    @endif
                                                </td>


                                            </tr>
                                            @php
                                            $i++;
                                        @endphp
                                        @endforeach
                                        @foreach ($inboxLetters[1] as $value)
                                        <tr class="text text-sm text-justify">
                                            <td>{{ $i }}</td>
                                            <td><a href="" href="" class="letter-link" data-toggle="modal"
                                                data-target=".bd-example-modal-lg"
                                                data-letter="{{ $value['letter_id'] }}" data-letter_path="{{ storageUrl($value['letter_path']) }}">{{ $value['crn'] }}</a>
                                                <br>Diarize
                                                Date:{{ \Carbon\Carbon::parse($value['diary_date'])->format('d/m/Y') }}
                                                <br>Recieved
                                                Date:{{ \Carbon\Carbon::parse($value['received_date'])->format('d/m/Y') }}
                                                <br> ECR No.:<b>{{$value['ecr_no']}}</b>
                                                <br> Diarized By: {{$value['name']}}
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

                                            <td><b>{{ $value['sender_name'] }},<br>
                                                {{ $value['sender_designation'] }},{{ $value['organization'] }}</td>
                                            <td>{{ $value['category_name'] }}</b></td>
                                            <td>
                                                @if (session('role') == 2)
                                                    <div class="mb-1">
                                                        <a href="{{ route('action_lists', [encrypt($value['letter_id'])]) }}" class="btn btn-sm btn-primary w-100 d-flex align-items-center justify-content-center" style="min-height: 30px; font-size: 12px;">
                                                            <i class="fas fa-edit mr-1"></i> Add Actions
                                                        </a>
                                                    </div>
                                                    <div class="mb-1">
                                                        <form id="for-hod-form" text>
                                                            <input type="hidden" name="assign_letter" value="{{$value['letter_id']}}">
                                                            <input type="hidden" name="assignee" value="{{$hod}}">
                                                        </form>
                                                        {{-- <button type="button" class="btn btn-sm btn-warning w-100 d-flex align-items-center justify-content-center save-btn" data-url="{{route('assign_letter')}}" data-form="#for-hod-form" data-message="That you want to send the letter for forwarding?" style="min-height: 30px; font-size: 12px;" id="hod-forward">
                                                            <i class="fas fa-forward mr-1"></i> Send for Forwarding
                                                        </button> --}}
                                                        
                                                        <a href="" class="assign-link"
                                                                            data-toggle="modal"
                                                                            data-target=".bd-example-modal-lg"
                                                                            data-letter="{{ $value['letter_id'] }}"
                                                                            data-letter_path="{{ storageUrl($value['letter_path']) }}">
                                                                            <span
                                                                                class="btn btn-sm btn-warning w-100 d-flex align-items-center justify-content-center"
                                                                                title="Assign Letter"
                                                                                style="min-height: 30px; font-size: 12px;">
                                                                                Send for Forwarding
                                                                                <i class="fas fa-forward ml-1"></i>
                                                                            </span>
                                                                        </a>
                                                    </div>
                                                @endif
                                                
                                                @if (session('role') == 3)
                                                    <div class="btn-group w-100 mt-2">
                                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle w-100" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="min-height: 30px; font-size: 12px;">
                                                            Actions
                                                            
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-left custom-dropdown-width" style="font-size: 12px;">
                                                           @if(isset($assignedLetters[$i - 1]))
                                                                @if ($assignedLetters[$i - 1] > 0)
                                                                    @if ($legacy == 0)
                                                                        <a href="javascript:void(0);" class="dropdown-item d-flex justify-content-between file-btn" data-toggle="modal" data-target=".bd-example-modal-lg" data-letter="{{ $value['letter_id'] }}" data-letter_path="{{ storageUrl($value['letter_path']) }}">
                                                                            Assign Within CMO <i class="fas fa-paper-plane ml-1"></i>
                                                                        </a>
                                                                    @endif
                                                                    {{-- <a href="{{ route('edit_diarize', [encrypt($value['letter_id'])]) }}" class="dropdown-item d-flex justify-content-between">
                                                                        Edit <i class="fas fa-edit ml-1"></i>
                                                                    </a> --}}
                                                                @endif
                                                            @else
                                                            @if ($legacy == 0)
                                                            <a href="javascript:void(0);" class="dropdown-item d-flex justify-content-between file-btn" data-toggle="modal" data-target=".bd-example-modal-lg" data-letter="{{ $value['letter_id'] }}" data-letter_path="{{ storageUrl($value['letter_path']) }}">
                                                                Assign Within CMO <i class="fas fa-paper-plane ml-1"></i>
                                                            </a>
                                                            @endif
                                                            @endif
                                                            @if ($value['stage_status'] < 3)
                                                            <a href="{{ route('actions', [encrypt($value['letter_id'])]) }}" class="dropdown-item d-flex justify-content-between">
                                                                Send to Department <i class="fas fa-list ml-1"></i>
                                                            </a>
                                                                @if(isset($assignedLetters[$i - 1]))
                                                                    @if ($assignedLetters[$i - 1] > 0)
                                                                        
                                                                    @endif
                                                                @endif
                                                            @endif
                                            
                                                            <a href="{{ route('acknowledge_letter', [$value['letter_id']]) }}" class="dropdown-item d-flex justify-content-between">
                                                                Acknowledge <i class="fas fa-envelope-open-text ml-1"></i>
                                                            </a>
                                            
                                                            <a href="{{ route('inbox', [encrypt($value['letter_id'])]) }}" class="dropdown-item d-flex justify-content-between">
                                                                Respond <i class="fas fa-reply ml-1"></i>
                                                            </a>
                                            
                                                            <a href="{{ route('correspondences', [$value['letter_id']]) }}" class="dropdown-item d-flex justify-content-between">
                                                                Correspondences <i class="fas fa-file-alt ml-1"></i>
                                                            </a>
                                                        </div>
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
                    @if (session('role_dept') == 1)
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
                                            <th>Diarized Details</th>
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
                                                    <a href="" href="" class="letter-link" data-toggle="modal"
                                                    data-target=".bd-example-modal-lg"
                                                    data-letter="{{ $value['letter_id'] }}" data-letter_path="{{ storageUrl($value['letter_path']) }}">{{ $value['crn'] }}</a>
                                                    <br>
                                                    Diarize
                                                    Date:{{ \Carbon\Carbon::parse($value['diary_date'])->format('d/m/Y') }}
                                                    <br>
                                                    Recieved
                                                    Date:{{ \Carbon\Carbon::parse($value['received_date'])->format('d/m/Y') }}
                                                    <br> ECR No.:<b>{{$value['ecr_no']}}</b>
                                                    <br> Diarized By: {{$value['name']}}
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

                                                <td><b>{{ $value['sender_name'] }},<br>
                                                    {{ $value['sender_designation'] }},{{ $value['organization'] }}</b>
                                                </td>
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
                                                    @if (session('role') == 1)
                                                        <a href="{{ route('actions', [encrypt($value['letter_id'])]) }}"
                                                            class="action-link btn btn-sm btn-primary w-100 d-flex align-items-center justify-content-center"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="Send to Department"
                                                            style="min-height: 30px; font-size: 12px;">
                                                            <i class="fas fa-edit mr-1"></i> Send to Department
                                                        </a>
                                                    @endif
                                                    @if (session('role') == 3)
                                                        <div class="mb-1">
                                                            <a href="{{ route('actions', [encrypt($value['letter_id'])]) }}"
                                                                class="action-link btn btn-sm btn-primary w-100 d-flex align-items-center justify-content-center"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Send to Department"
                                                                style="min-height: 30px; font-size: 12px;">
                                                                <i class="fas fa-edit mr-1"></i> Check Response
                                                            </a>
                                                            @if ($value['stage_status'] < 3)
                                                                @isset($assignedLetters[$i - 1])
                                                                    @if ($assignedLetters[$i - 1] > 0)
                                                                        <a href="{{ route('actions', [encrypt($value['letter_id'])]) }}"
                                                                            class="action-link btn btn-sm btn-primary w-100 d-flex align-items-center justify-content-center"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            title="Send to Department"
                                                                            style="min-height: 30px; font-size: 12px;">
                                                                            <i class="fas fa-edit mr-1"></i> Send to Department
                                                                        </a>
                                                                    @endif
                                                                @endisset
                                                            @endif
                                                        </div>

                                                        <div class="mb-1">
                                                            <a href="{{ route('acknowledge_letter', [$value['letter_id']]) }}"
                                                                class="action-link btn btn-sm btn-success w-100 d-flex align-items-center justify-content-center"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Acknowledge"
                                                                style="min-height: 30px; font-size: 12px;">
                                                                <i class="fas fa-envelope-open-text mr-1"></i> Acknowledge
                                                            </a>
                                                        </div>

                                                        <div class="mb-1">
                                                            <a href="{{ route('correspondences', [$value['letter_id']]) }}"
                                                                class="action-link btn btn-sm btn-warning w-100 d-flex align-items-center justify-content-center"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Correspondences"
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
                                        @if(session('role') == 2)
                                        @foreach ($deligateAssignedLetters as $value)
                                        <tr class="text text-sm text-justify">
                                            <td>{{ $i }}</td>
                                            <td>
                                                <a href="" href="" class="letter-link" data-toggle="modal"
                                                    data-target=".bd-example-modal-lg"
                                                    data-letter="{{ $value['letter_id'] }}" data-letter_path="{{ storageUrl($value['letter_path']) }}">{{ $value['crn'] }}</a>
                                                <br>
                                                Diarize
                                                Date:{{ \Carbon\Carbon::parse($value['diary_date'])->format('d/m/Y') }}
                                                <br>
                                                Recieved
                                                Date:{{ \Carbon\Carbon::parse($value['received_date'])->format('d/m/Y') }}
                                                <br> ECR No.:<b>{{$value['ecr_no']}}</b>
                                                <br> Diarized By: {{$value['name']}}
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

                                            <td><b>{{ $value['sender_name'] }},<br>
                                                {{ $value['sender_designation'] }},{{ $value['organization'] }}</b>
                                            </td>
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
                                                @if (session('role') == 1)
                                                    <a href="{{ route('actions', [encrypt($value['letter_id'])]) }}"
                                                        class="action-link btn btn-sm btn-primary w-100 d-flex align-items-center justify-content-center"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Send to Department"
                                                        style="min-height: 30px; font-size: 12px;">
                                                        <i class="fas fa-edit mr-1"></i> Send to Department
                                                    </a>
                                                @endif
                                                @if (session('role') == 3)
                                                    <div class="mb-1">
                                                        <a href="{{ route('actions', [encrypt($value['letter_id'])]) }}"
                                                            class="action-link btn btn-sm btn-primary w-100 d-flex align-items-center justify-content-center"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="Send to Department"
                                                            style="min-height: 30px; font-size: 12px;">
                                                            <i class="fas fa-edit mr-1"></i> Check Response
                                                        </a>
                                                        @if ($value['stage_status'] < 3)
                                                            @isset($assignedLetters[$i - 1])
                                                                @if ($assignedLetters[$i - 1] > 0)
                                                                    <a href="{{ route('actions', [encrypt($value['letter_id'])]) }}"
                                                                        class="action-link btn btn-sm btn-primary w-100 d-flex align-items-center justify-content-center"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="Send to Department"
                                                                        style="min-height: 30px; font-size: 12px;">
                                                                        <i class="fas fa-edit mr-1"></i> Send to Department
                                                                    </a>
                                                                @endif
                                                            @endisset
                                                        @endif
                                                    </div>

                                                    <div class="mb-1">
                                                        <a href="{{ route('acknowledge_letter', [$value['letter_id']]) }}"
                                                            class="action-link btn btn-sm btn-success w-100 d-flex align-items-center justify-content-center"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="Acknowledge"
                                                            style="min-height: 30px; font-size: 12px;">
                                                            <i class="fas fa-envelope-open-text mr-1"></i> Acknowledge
                                                        </a>
                                                    </div>

                                                    <div class="mb-1">
                                                        <a href="{{ route('correspondences', [$value['letter_id']]) }}"
                                                            class="action-link btn btn-sm btn-warning w-100 d-flex align-items-center justify-content-center"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="Correspondences"
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
                                        @endif
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
                                            <th>Diarized Details</th>
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
                                                    <a href="" href="" class="letter-link" data-toggle="modal"
                                                    data-target=".bd-example-modal-lg"
                                                    data-letter="{{ $value['letter_id'] }}" data-letter_path="{{ storageUrl($value['letter_path']) }}">{{ $value['crn'] }}</a>
                                                    <br>
                                                    Diarize
                                                    Date:{{ \Carbon\Carbon::parse($value['diary_date'])->format('d/m/Y') }}
                                                    <br>
                                                    Recieved
                                                    Date:{{ \Carbon\Carbon::parse($value['received_date'])->format('d/m/Y') }}
                                                    <br> ECR No.:<b>{{$value['ecr_no']}}</b>
                                                    <br> Diarized By: {{$value['name']}}
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
                                                    Letter No: <b>{{ $value['letter_no'] }}</b>
                                                    <br>
                                                    Letter Date:
                                                    {{ \Carbon\Carbon::parse($value['letter_date'])->format('d/m/Y') }}
                                                </td>

                                                <td><b>{{ $value['sender_name'] }}<br>{{ $value['sender_designation'] }},{{ $value['organization'] }}</b>
                                                </td>
                                                <td>{{ $value['category_name'] }},{{ $value['organization'] }}</td>
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
                                                        <div class="mb-1">
                                                            <a href="{{ route('actions', [encrypt($value['letter_id'])]) }}"
                                                                class="action-link btn btn-sm btn-primary w-100 d-flex align-items-center justify-content-center"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="View/Update"
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
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Correspondences"
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
                    @elseif (session('role_dept') > 2)
                    <div class="tab-pane fade" id="nav-action" role="tabpanel" aria-labelledby="nav-action-tab">
                        <div class="box shadow-lg p-3 mb-5 bg-white rounded">
                            <div class="box-body">
                                <table class="table table-sm table-hover table-striped letter-table" id="action-table">
                                    <thead>
                                        <tr>
                                            <th colspan="6" class="text text-center">Action Taken Letters</th>
                                        </tr>
                                        <tr class="text text-sm text-justify">
                                            <th>Sl no.</th>
                                            <th>Diarized Details</th>
                                            <th>Subject</th>
                                            <th>Sender</th>
                                            <th>Category</th>
                                            {{-- <th>Options</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($actionLetters as $value)
                                            <tr class="text text-sm text-justify">
                                                <td>{{ $i }}</td>
                                                <td>
                                                    <a href="" href="" class="letter-link" data-toggle="modal"
                                                    data-target=".bd-example-modal-lg"
                                                    data-letter="{{ $value['letter_id'] }}" data-letter_path="{{ storageUrl($value['letter_path']) }}">{{ $value['crn'] }}</a>
                                                    <br>
                                                    Diarize
                                                    Date:{{ \Carbon\Carbon::parse($value['diary_date'])->format('d/m/Y') }}
                                                    <br>
                                                    Recieved
                                                    Date:{{ \Carbon\Carbon::parse($value['received_date'])->format('d/m/Y') }}
                                                    <br> ECR No.:<b>{{$value['ecr_no']}}</b>
                                                    <br> Diarized By: {{$value['name']}}
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

                                                <td><b>{{ $value['sender_name'] }},<br>
                                                    {{ $value['sender_designation'] }},{{ $value['organization'] }}</b>
                                                </td>
                                                <td>{{ $value['category_name'] }}</td>
                                                {{-- <td>

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
                                                    @if (session('role') == 1)
                                                        <a href="{{ route('actions', [encrypt($value['letter_id'])]) }}"
                                                            class="action-link btn btn-sm btn-primary w-100 d-flex align-items-center justify-content-center"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="Send to Department"
                                                            style="min-height: 30px; font-size: 12px;">
                                                            <i class="fas fa-edit mr-1"></i> Send to Department
                                                        </a>
                                                    @endif
                                                    @if (session('role') == 3)
                                                        <div class="mb-1">
                                                            <a href="{{ route('actions', [encrypt($value['letter_id'])]) }}"
                                                                class="action-link btn btn-sm btn-primary w-100 d-flex align-items-center justify-content-center"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Send to Department"
                                                                style="min-height: 30px; font-size: 12px;">
                                                                <i class="fas fa-edit mr-1"></i> Send to Department
                                                            </a>
                                                            @if ($value['stage_status'] < 3)
                                                                @isset($assignedLetters[$i - 1])
                                                                    @if ($assignedLetters[$i - 1] > 0)
                                                                        <a href="{{ route('actions', [encrypt($value['letter_id'])]) }}"
                                                                            class="action-link btn btn-sm btn-primary w-100 d-flex align-items-center justify-content-center"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            title="Send to Department"
                                                                            style="min-height: 30px; font-size: 12px;">
                                                                            <i class="fas fa-edit mr-1"></i> Send to Department
                                                                        </a>
                                                                    @endif
                                                                @endisset
                                                            @endif
                                                        </div>

                                                        <div class="mb-1">
                                                            <a href="{{ route('acknowledge_letter', [$value['letter_id']]) }}"
                                                                class="action-link btn btn-sm btn-success w-100 d-flex align-items-center justify-content-center"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Acknowledge"
                                                                style="min-height: 30px; font-size: 12px;">
                                                                <i class="fas fa-envelope-open-text mr-1"></i> Acknowledge
                                                            </a>
                                                        </div>

                                                        <div class="mb-1">
                                                            <a href="{{ route('correspondences', [$value['letter_id']]) }}"
                                                                class="action-link btn btn-sm btn-warning w-100 d-flex align-items-center justify-content-center"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Correspondences"
                                                                style="min-height: 30px; font-size: 12px;">
                                                                <i class="fas fa-file mr-1"></i> Correspondences
                                                            </a>
                                                        </div>
                                                    @endif

                                                </td> --}}
                                                <td>
                                                    @if ($value['stage_status']  == 1 || $value['stage_status']  == 2 || $value['stage_status'] == 6)
                                                    @if (session('role') == 3)
                                                    <div class="mb-1">
                                                        <a href="{{ route('inbox', [encrypt($value['letter_id'])]) }}"
                                                            class="action-link btn btn-sm btn-warning w-100 d-flex align-items-center justify-content-center"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="Correspondences"
                                                            style="min-height: 30px; font-size: 12px;">
                                                            <i class="fas fa-reply mr-1"></i> Respond
                                                        </a>
                                                    </div>
                                                    @endif
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
                    <div class="tab-pane fade" id="nav-process" role="tabpanel" aria-labelledby="nav-process-tab">
                        <div class="box shadow-lg p-3 mb-5 bg-white rounded">
                            <div class="box-body">
                                <div class="letter-table_wrapper">

                                </div>
                                <table class="table table-sm table-hover table-striped letter-table" id="process-table">
                                    <thead>
                                        <tr>
                                            <th colspan="6" class="text text-center">In Process Letters</th>
                                        </tr>
                                        <tr class="text text-sm text-justify">
                                            <th>Sl no.</th>
                                            <th>Diarized Details</th>
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
                                        @foreach ($inProcessLetters as $value)
                                            <tr class="text text-sm text-justify">
                                                <td>{{ $i }}</td>
                                                <td>
                                                    <a href="" href="" class="letter-link" data-toggle="modal"
                                                    data-target=".bd-example-modal-lg"
                                                    data-letter="{{ $value['letter_id'] }}" data-letter_path="{{ storageUrl($value['letter_path']) }}">{{ $value['crn'] }}</a>
                                                    <br>
                                                    Diarize
                                                    Date:{{ \Carbon\Carbon::parse($value['diary_date'])->format('d/m/Y') }}
                                                    <br>
                                                    Recieved
                                                    Date:{{ \Carbon\Carbon::parse($value['received_date'])->format('d/m/Y') }}
                                                    <br> ECR No.:<b>{{$value['ecr_no']}}</b>
                                                    <br> Diarized By: {{$value['name']}}
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
                                                    Letter No: <b>{{ $value['letter_no'] }}</b>
                                                    <br>
                                                    Letter Date:
                                                    {{ \Carbon\Carbon::parse($value['letter_date'])->format('d/m/Y') }}
                                                </td>

                                                <td><b>{{ $value['sender_name'] }}<br>{{ $value['sender_designation'] }},{{ $value['organization'] }}</b>
                                                </td>
                                                <td>{{ $value['category_name'] }},<br>{{ $value['organization'] }}</td>
                                                {{-- <td>
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
                                                        <div class="mb-1">
                                                            <a href="{{ route('actions', [encrypt($value['letter_id'])]) }}"
                                                                class="action-link btn btn-sm btn-primary w-100 d-flex align-items-center justify-content-center"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="View/Update"
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
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Correspondences"
                                                                style="min-height: 30px; font-size: 12px;">
                                                                <i class="fas fa-file mr-1"></i> Correspondences
                                                            </a>
                                                        </div>
                                                    @endif
                                                </td> --}}
                                                <td>
                                                    @if ($value['stage_status']  == 1 || $value['stage_status']  == 2 || $value['stage_status'] == 6)
                                                    @if (session('role') == 3)
                                                        {{-- <div class="mb-1">
                                                            <a href="{{ route('actions', [encrypt($value['letter_id'])]) }}"
                                                                class="action-link btn btn-sm btn-primary w-100 d-flex align-items-center justify-content-center"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="View/Update"
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
                                                        </div> --}}

                                                        <div class="mb-1">
                                                            <a href="{{ route('inbox', [encrypt($value['letter_id'])]) }}"
                                                                class="action-link btn btn-sm btn-warning w-100 d-flex align-items-center justify-content-center"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Correspondences"
                                                                style="min-height: 30px; font-size: 12px;">
                                                                <i class="fas fa-reply mr-1"></i> Respond
                                                            </a>
                                                        </div>
                                                    @endif
                                                  
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
                    <div class="tab-pane fade" id="nav-completed" role="tabpanel" aria-labelledby="nav-completed-tab">
                        <div class="box shadow-lg p-3 mb-5 bg-white rounded">
                            <div class="box-body">
                                <div class="letter-table_wrapper">

                                </div>
                                <table class="table table-sm table-hover table-striped letter-table" id="completed-table">
                                    <thead>
                                        <tr>
                                            <th colspan="6" class="text text-center">Completed Letters</th>
                                        </tr>
                                        <tr class="text text-sm text-justify">
                                            <th>Sl no.</th>
                                            <th>Diarized Details</th>
                                            <th>Subject</th>
                                            <th>Sender</th>
                                            <th>Category</th>
                                            {{-- <th>Options</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($deptCompletedLetters as $value)
                                            <tr class="text text-sm text-justify">
                                                <td>{{ $i }}</td>
                                                <td>
                                                    <a href="" href="" class="letter-link" data-toggle="modal"
                                                    data-target=".bd-example-modal-lg"
                                                    data-letter="{{ $value['letter_id'] }}" data-letter_path="{{ storageUrl($value['letter_path']) }}">{{ $value['crn'] }}</a>
                                                    <br>
                                                    Diarize
                                                    Date:{{ \Carbon\Carbon::parse($value['diary_date'])->format('d/m/Y') }}
                                                    <br>
                                                    Recieved
                                                    Date:{{ \Carbon\Carbon::parse($value['received_date'])->format('d/m/Y') }}
                                                    <br> ECR No.:<b>{{$value['ecr_no']}}</b>
                                                    <br> Diarized By: {{$value['name']}}
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
                                                    Letter No: <b>{{ $value['letter_no'] }}</b>
                                                    <br>
                                                    Letter Date:
                                                    {{ \Carbon\Carbon::parse($value['letter_date'])->format('d/m/Y') }}
                                                </td>

                                                <td><b>{{ $value['sender_name'] }}<br>{{ $value['sender_designation'] }},{{ $value['organization'] }}</b>
                                                </td>
                                                <td>{{ $value['category_name'] }},{{ $value['organization'] }}</td>
                                                {{-- <td>
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
                                                        <div class="mb-1">
                                                            <a href="{{ route('actions', [encrypt($value['letter_id'])]) }}"
                                                                class="action-link btn btn-sm btn-primary w-100 d-flex align-items-center justify-content-center"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="View/Update"
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
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Correspondences"
                                                                style="min-height: 30px; font-size: 12px;">
                                                                <i class="fas fa-file mr-1"></i> Correspondences
                                                            </a>
                                                        </div>
                                                    @endif
                                                </td> --}}

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
                @endif
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
                        <div class="col-md-5" id="assign-div">
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-body">
                                    <form id="assign-form">
                                        <div class="form-group">
                                            <label for="assignee" class="col-form-label">Assignee</label>
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
                                            <input type="hidden" name="assign_letter" class="assign_letter"
                                                value="">
                                        </div>
                                        <button type="button" class="btn btn-primary save-btn"
                                            data-url="{{route('refer')}}" data-form="#refer-form"
                                            data-message="That you want to refer to this letter!"
                                            id="refer-btn">REFER</button>
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

@section('scripts')
    <script>
        $(document).on('click', '.file-btn, .assign-link, .letter-link', function() {
            $('#letter-view').attr('src', $(this).data('letter_path'));
            $('#assign-div').show();
            $('#refer-div').hide();
            $('#exampleModalLabel').html("<strong>Assign Letter within CMO</strong>");
        });$(document).on('click', '.file-btn, .refer-link', function() {
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
                } else if (tab === 'process') {
                    document.getElementById('nav-process-tab').click(); // Switch to Archive tab
                } else if (tab === 'completed') {
                    document.getElementById('nav-completed-tab').click(); // Switch to Archive tab
                } else if (tab === 'action') {
                    document.getElementById('nav-action-tab').click(); // Switch to Archive tab
                }
            }
        });
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
                } else if (tab === 'process') {
                    document.getElementById('nav-process-tab').click(); // Switch to Archive tab
                } else if (tab === 'completed') {
                    document.getElementById('nav-completed-tab').click(); // Switch to Archive tab
                } else if (tab === 'action') {
                    document.getElementById('nav-action-tab').click(); // Switch to Archive tab
                }
            }
        });

        $(document).on('click','#hod-forward',function(){

        });
        $(document).on('click','.letter-link',function(){
            $('#assign-div').hide();
            $('#letter-view').attr('src', $(this).data('letter_path'));
        });
        $('.js-example-basic-multiple').select2();
    </script>
@endsection
@endsection