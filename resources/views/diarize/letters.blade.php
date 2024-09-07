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
        <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Diarized</button>
        <button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Inbox</button>
        <button class="nav-link" id="nav-contact-tab" data-toggle="tab" data-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Sent</button>
        <button class="nav-link" id="nav-archive-tab" data-toggle="tab" data-target="#nav-archive" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Archived</button>
        <button class="nav-link" id="nav-issue-tab" data-toggle="tab" data-target="#nav-issue" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Issue</button>
      </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
       <div class="box shadow-lg p-3 mb-5 bg-white rounded">
          <div class="box-body">
            <table class="table table-sm table-hover table-striped letter-table" id="">
              <thead>
                  <tr>
                    <th colspan="6" class="text text-center">Diarized Letters</th>
                  </tr>
                  <tr class="text text-sm text-justify">
                    <th>Sl no.</th><th>Diarize No.</th><th>Subject</th><th>Letter No.</th><th>Sender</th><th>Category</th><th>Letter</th>
                  </tr>
              </thead>
              <tbody>
                  @php
                      $i = 1;
                  @endphp
                  @foreach ($letters as $value)
                      <tr class="text text-sm text-justify">
                        <td>{{$i}}</td>
                        <td> &nbsp;{{$value['crn']}}</td>
                        <td style="width: 30%;">
                            @if(strlen($value['subject']) > 100)
                            <div class="text-block" id="textBlock1">
                              <p class="shortText text-justify text-sm">
                                {{substr($value['subject'], 0, 100)}}... 
                                <a href="#" class="readMore">Read more</a>
                              </p>
                              <div class="longText" style="display: none;">
                                <p class="text-sm text-justify">
                                  {{$value['subject']}}
                                  <a href="#" class="readLess">Read less</a>
                                </p>
                              </div>
                          
                            @else
                            {{$value['subject']}}
                            @endif
                          </td>
                          
                          <td>{{$value['letter_no']}}</td><td>{{$value['sender_name']}}</td>
                          <td>
                            @if($value['receipt'] == true)
                              Receipt
                            @else
                              Issued
                            @endif
                          </td>
                          <td>
                            @if (session('role') == 1)
                            &nbsp;
                            @if($assignedLetters[$i-1] <= 0)
                            <a href="" class="assign-link" data-toggle="modal" data-target=".bd-example-modal-lg" data-letter="{{$value['letter_id']}}" data-letter_path="{{config('constants.options.storage_url')}}{{$value['letter_path']}}"><i class="fas fa-paper-plane" style="color:#173f5f;" data-toggle="tooltip" data-placement="top" title="View/Update"></i></a>
                            @endif
                            @endif
                           @if (session('role') == 2)
                            &nbsp;
                            @if($delegatgeLetters[$i-1] > 0)
                            <a href="{{route('action_lists',[encrypt($value['letter_id'])])}}" class="action-link"><i class="fas fa-edit" style="color:#173f5f;" data-toggle="tooltip" data-placement="top" title="View/Update"></i></a>
                            @endif
                            @endif
                           @if (session('role') == 3)
                            
                            &nbsp;
                            @if($assignedLetters[$i-1] > 0)
                            <a href="{{route('actions',[encrypt($value['letter_id'])])}}" class="action-link"><i class="fas fa-edit" style="color:#173f5f;" data-toggle="tooltip" data-placement="top" title="View/Update" ></i></a>
                            @endif
                            &nbsp;
                            <a class="file-btn" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" target="__blank" data-letter_path="{{config('constants.options.storage_url')}}{{$value['letter_path']}}"><i class="fas fa-file-pdf text-danger"></i></a>
                            &nbsp;
                            <a href="{{route('acknowledge_letter',[$value['letter_id']])}}" class="action-link"><i class="fas fa-envelope-open-text text-success" data-toggle="tooltip" data-placement="top" title="Acknowledgement Letter Generation"></i></a>
                            &nbsp;
                            <a href="{{route('correspondences',[$value['letter_id']])}}" class="action-link"><i class="fas fa-file" style="color:#fd9f01;" data-toggle="tooltip" data-placement="top" title="Correspondences"></i></a>
                              @if($value['stage_status'] == 4)
                              &nbsp;
                              <a href="#" class="action-link save-btn archive" data-letter="{{$value['letter_id']}}" data-url="{{ route('change_stage') }}" data-form="#letter-complete-form" data-message="That you want to archive the letter!" id="save-archive-btn"><i class="fas fa-folder" style="color:#01fd4d;" data-toggle="tooltip" data-placement="top" title="Correspondences"></i></a>
                              
                              @endif
                              &nbsp;
                              @if($assignedLetters[$i-1] > 0)
                                <a href="" class="assign-link" data-toggle="modal" data-target=".bd-example-modal-lg" data-letter="{{$value['letter_id']}}" data-forward="{{$assignedLetters[$i-1]}}" data-letter_path="{{config('constants.options.storage_url')}}{{$value['letter_path']}}"><i class="fas fa-paper-plane" style="color:#173f5f;" data-toggle="tooltip" data-placement="top" title="View/Update"></i></a>
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
      <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <div class="box shadow-lg p-3 mb-5 bg-white rounded">
          <div class="box-body">
            <table class="table table-sm table-hover table-striped" id="letter-table">
              <thead>
                  <tr class="text text-sm text-justify">
                    <th>Sl no.</th><th>Diarize No.</th><th>Subject</th><th>Letter No.</th><th>Sender</th><th>Letter</th>
                  </tr>
              </thead>
              <tbody>
                  @php
                      $i = 1;
                  @endphp
                  @foreach ($inboxLetters as $value)
                      <tr class="text text-sm text-justify">
                        <td>{{$i}}</td>
                        <td> &nbsp;{{$value['crn']}}</td>
                        <td style="width: 30%;">
                            @if(strlen($value['subject']) > 100)
                            <div class="text-block" id="textBlock1">
                              <p class="shortText text-justify text-sm">
                                {{substr($value['subject'], 0, 100)}}... 
                                <a href="#" class="readMore">Read more</a>
                              </p>
                              <div class="longText" style="display: none;">
                                <p class="text-sm text-justify">
                                  {{$value['subject']}}
                                  <a href="#" class="readLess">Read less</a>
                                </p>
                              </div>
                          
                            @else
                            {{$value['subject']}}
                            @endif
                          </td>
                          <td>{{$value['letter_no']}}</td><td>{{$value['sender_name']}}</td>
                          <td>
                            @if (session('role') == 3)
                            <a href="{{route('inbox',[encrypt($value['letter_id'])])}}" class="action-link"><i class="fas fa-envelope-open-text text-success" data-toggle="tooltip" data-placement="top" title="Forwarded actions"></i></a>
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
      <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
        <div class="box shadow-lg p-3 mb-5 bg-white rounded">
          <div class="box-body">
            <table class="table table-sm table-hover table-striped letter-table" id="">
              <thead>
                  <tr>
                    <th colspan="6" class="text text-center">Sent Letters</th>
                  </tr>
                  <tr class="text text-sm text-justify">
                    <th>Sl no.</th><th>Diarize No.</th><th>Subject</th><th>Letter No.</th><th>Sender</th><th>Letter</th>
                  </tr>
              </thead>
              <tbody>
                  @php
                      $i = 1;
                  @endphp
                  @foreach ($sentLetters as $value)
                      <tr class="text text-sm text-justify">
                        <td>{{$i}}</td>
                        <td> &nbsp;{{$value['crn']}}</td>
                        <td style="width: 30%;">
                            @if(strlen($value['subject']) > 100)
                            <div class="text-block" id="textBlock1">
                              <p class="shortText text-justify text-sm">
                                {{substr($value['subject'], 0, 100)}}... 
                                <a href="#" class="readMore">Read more</a>
                              </p>
                              <div class="longText" style="display: none;">
                                <p class="text-sm text-justify">
                                  {{$value['subject']}}
                                  <a href="#" class="readLess">Read less</a>
                                </p>
                              </div>
                          
                            @else
                            {{$value['subject']}}
                            @endif
                          </td>
                          <td>{{$value['letter_no']}}</td><td>{{$value['sender_name']}}</td><td>
                           @if (session('role') == 2)
                            &nbsp;
                            <a href="{{route('action_lists',[encrypt($value['letter_id'])])}}" class="action-link"><i class="fas fa-edit" style="color:#173f5f;" data-toggle="tooltip" data-placement="top" title="View/Update"></i></a>
                           @endif
                           @if (session('role') == 3)
                            &nbsp;
                            @if ($assignedSentLetters[$i-1] > 0)
                            <a href="{{route('actions',[encrypt($value['letter_id'])])}}" class="action-link"><i class="fas fa-edit" style="color:#173f5f;" data-toggle="tooltip" data-placement="top" title="View/Update" ></i></a>
                            @endif
                            @endif
                            @if (session('role') == 3)
                            &nbsp;
                            <a class="file-btn" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" target="__blank" data-letter_path="{{config('constants.options.storage_url')}}{{$value['letter_path']}}"><i class="fas fa-file-pdf text-danger"></i></a>
                            &nbsp;
                            <a href="{{route('acknowledge_letter',[$value['letter_id']])}}" class="action-link"><i class="fas fa-envelope-open-text text-success" data-toggle="tooltip" data-placement="top" title="Acknowledgement Letter Generation"></i></a>
                            &nbsp;
                            <a href="{{route('correspondences',[$value['letter_id']])}}" class="action-link"><i class="fas fa-file" style="color:#fd9f01;" data-toggle="tooltip" data-placement="top" title="Correspondences"></i></a>
                              @if($value['stage_status'] == 4)
                              &nbsp;
                              <a href="#" class="action-link save-btn archive" data-letter="{{$value['letter_id']}}" data-url="{{ route('change_stage') }}" data-form="#letter-complete-form" data-message="That you want to archive the letter!" id="save-archive-btn"><i class="fas fa-folder" style="color:#01fd4d;" data-toggle="tooltip" data-placement="top" title="Correspondences"></i></a>
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
      <div class="tab-pane fade" id="nav-archive" role="tabpanel" aria-labelledby="nav-archive-tab">
        <div class="box shadow-lg p-3 mb-5 bg-white rounded">
          <div class="box-body">
            <table class="table table-sm table-hover table-striped letter-table" id="">
              <thead>
                  <tr>
                    <th colspan="6" class="text text-center">Archived Letters</th>
                  </tr>
                  <tr class="text text-sm text-justify">
                    <th>Sl no.</th><th>Diarize No.</th><th>Subject</th><th>Letter No.</th><th>Sender</th><th>Letter</th>
                  </tr>
              </thead>
              <tbody>
                  @php
                      $i = 1;
                  @endphp
                  @foreach ($archivedLetters as $value)
                      <tr class="text text-sm text-justify">
                        <td>{{$i}}</td>
                        <td> &nbsp;{{$value['crn']}}</td>
                        <td style="width: 30%;">
                            @if(strlen($value['subject']) > 100)
                            <div class="text-block" id="textBlock1">
                              <p class="shortText text-justify text-sm">
                                {{substr($value['subject'], 0, 100)}}... 
                                <a href="#" class="readMore">Read more</a>
                              </p>
                              <div class="longText" style="display: none;">
                                <p class="text-sm text-justify">
                                  {{$value['subject']}}
                                  <a href="#" class="readLess">Read less</a>
                                </p>
                              </div>
                          
                            @else
                            {{$value['subject']}}
                            @endif
                          </td>
                          <td>{{$value['letter_no']}}</td><td>{{$value['sender_name']}}</td><td>
                           @if (session('role') == 2)
                            &nbsp;
                            <a href="{{route('action_lists',[encrypt($value['letter_id'])])}}" class="action-link"><i class="fas fa-edit" style="color:#173f5f;" data-toggle="tooltip" data-placement="top" title="View/Update"></i></a>
                           @endif
                           @if (session('role') == 3)
                            &nbsp;
                            <a href="{{route('actions',[encrypt($value['letter_id'])])}}" class="action-link"><i class="fas fa-edit" style="color:#173f5f;" data-toggle="tooltip" data-placement="top" title="View/Update" ></i></a>
                            @endif
                            @if (session('role') == 3)
                            &nbsp;
                            <a class="file-btn" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" target="__blank" data-letter_path="{{config('constants.options.storage_url')}}{{$value['letter_path']}}"><i class="fas fa-file-pdf text-danger"></i></a>
                            &nbsp;
                            <a href="{{route('acknowledge_letter',[$value['letter_id']])}}" class="action-link"><i class="fas fa-envelope-open-text text-success" data-toggle="tooltip" data-placement="top" title="Acknowledgement Letter Generation"></i></a>
                            &nbsp;
                            <a href="{{route('correspondences',[$value['letter_id']])}}" class="action-link"><i class="fas fa-file" style="color:#fd9f01;" data-toggle="tooltip" data-placement="top" title="Correspondences"></i></a>
                              @if($value['stage_status'] == 4)
                              &nbsp;
                              <a href="#" class="action-link save-btn archive" data-letter="{{$value['letter_id']}}" data-url="{{ route('change_stage') }}" data-form="#letter-complete-form" data-message="That you want to archive the letter!" id="save-archive-btn"><i class="fas fa-folder" style="color:#01fd4d;" data-toggle="tooltip" data-placement="top" title="Correspondences"></i></a>
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
      <div class="tab-pane fade" id="nav-issue" role="tabpanel" aria-labelledby="nav-issue-tab">
        <div class="box shadow-lg p-3 mb-5 bg-white rounded">
           <div class="box-body">
             <table class="table table-sm table-hover table-striped letter-table" id="">
               <thead>
                   <tr>
                     <th colspan="6" class="text text-center">Issued Letters</th>
                   </tr>
                   <tr class="text text-sm text-justify">
                     <th>Sl no.</th><th>Diarize No.</th><th>Subject</th><th>Letter No.</th><th>Recipient</th><th>Category</th><th>Letter</th>
                   </tr>
               </thead>
               <tbody>
                   @php
                       $i = 1;
                   @endphp
                   @foreach ($issueLetters as $value)
                       <tr class="text text-sm text-justify">
                         <td>{{$i}}</td>
                         <td> &nbsp;{{$value['crn']}}</td>
                         <td style="width: 30%;">
                             @if(strlen($value['subject']) > 100)
                             <div class="text-block" id="textBlock1">
                               <p class="shortText text-justify text-sm">
                                 {{substr($value['subject'], 0, 100)}}... 
                                 <a href="#" class="readMore">Read more</a>
                               </p>
                               <div class="longText" style="display: none;">
                                 <p class="text-sm text-justify">
                                   {{$value['subject']}}
                                   <a href="#" class="readLess">Read less</a>
                                 </p>
                               </div>
                           
                             @else
                             {{$value['subject']}}
                             @endif
                           </td>
                           
                           <td>{{$value['letter_no']}}</td><td>{{$value['recipient_name']}}</td>
                           <td>
                             @if($value['receipt'] == true)
                               Receipt
                             @else
                               Issued
                             @endif
                           </td>
                           <td>
                            @if (session('role') == 2)
                             &nbsp;
                             <a href="{{route('action_lists',[encrypt($value['letter_id'])])}}" class="action-link"><i class="fas fa-edit" style="color:#173f5f;" data-toggle="tooltip" data-placement="top" title="View/Update"></i></a>
                            @endif
                            @if (session('role') == 3)
                             &nbsp;
                             <a href="{{route('actions',[encrypt($value['letter_id'])])}}" class="action-link"><i class="fas fa-edit" style="color:#173f5f;" data-toggle="tooltip" data-placement="top" title="View/Update" ></i></a>
                             @endif
                             @if (session('role') == 3)
                             &nbsp;
                             <a class="file-btn" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" target="__blank" data-letter_path="{{config('constants.options.storage_url')}}{{$value['letter_path']}}"><i class="fas fa-file-pdf text-danger"></i></a>
                             &nbsp;
                             <a href="{{route('acknowledge_letter',[$value['letter_id']])}}" class="action-link"><i class="fas fa-envelope-open-text text-success" data-toggle="tooltip" data-placement="top" title="Acknowledgement Letter Generation"></i></a>
                             &nbsp;
                             <a href="{{route('correspondences',[$value['letter_id']])}}" class="action-link"><i class="fas fa-file" style="color:#fd9f01;" data-toggle="tooltip" data-placement="top" title="Correspondences"></i></a>
                               @if($value['stage_status'] == 4)
                               &nbsp;
                               <a href="#" class="action-link save-btn archive" data-letter="{{$value['letter_id']}}" data-url="{{ route('change_stage') }}" data-form="#letter-complete-form" data-message="That you want to archive the letter!" id="save-archive-btn"><i class="fas fa-folder" style="color:#01fd4d;" data-toggle="tooltip" data-placement="top" title="Correspondences"></i></a>
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
    </div>
    
   </div>
 </div>
 <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Send Letter</h5>
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
                      @foreach ($departmentUsers AS $value)
                        @if(session('role_user') != $value['user_id'] )
                        <option value="{{$value['user_id']}}">{{$value['name']}}</option>
                        @endif
                        @endforeach
                    </select>
                    <label class="text text-danger assignee"></label>
                  </div>
                  <div class="form-group">
                    <input type="hidden" name="assign_letter" class="assign_letter" value="">
                    <input type="hidden" name="forward_from" class="forward_from" value="">
                    <label for="assign_remarks" class="col-form-label">Remarks:</label>
                    <textarea class="form-control" id="assign_remarks" name="assign_remarks" rows="4"></textarea>
                    <label class="text text-danger assign_remarks"></label>
                  </div>
                  <button type="button" class="btn btn-primary save-btn" data-url="{{ route('assign_letter') }}" data-form="#assign-form" data-message="That you want to assign this letter!" id="assign-btn">SEND</button>
                </form>
              </div>
            </div>
            
          </div>
          <div cclass="col-md-7">
            <div class="card card-primary card-outline card-outline-tabs">
              <div class="card-body">
                <iframe src="" style="width: 25rem; height:20rem;" id="letter-view">
                </iframe>
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
  $(document).on('click','.file-btn, .assign-link',function(){
     $('#letter-view').attr('src',$(this).data('letter_path'));
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
  $(document).on('click','.archive',function(){
      $('#stage_letter').val($(this).data('letter'));
    });
</script>
<script src="{{asset('js/custom/common.js')}}"></script>
    <script>
       $(function () {
    $(".letter-table").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": [ "excel", "pdf", "print"]
    }).buttons().container().appendTo('.letter-table_wrapper .col-md-6:eq(0)');
    $(".buttons-html5").addClass("btn btn-outline-info ml-1 btn-sm");
    $(".buttons-html5").removeClass('btn-secondary');
    $(".buttons-print").addClass("btn btn-outline-info ml-1 btn-sm");
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

    $(document).on('click','.assign-link',function(){

      $('.assign_letter').val($(this).data('letter'));
      $('.forward_from').val($(this).data('forward'));

    });
    </script>
@endsection
@endsection
