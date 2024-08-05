@extends('layouts.app')

@section('content')
<form id="letter-complete-form">
  <input type="hidden" id="stage_letter" name="stage_letter">
  <input type="hidden" id="stage" name="stage" value="5">
</form>
<div class="row">
  <div class="col-md-12">
    <div class="box shadow-lg p-3 mb-5 bg-white rounded min-vh-40">
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
 </div>

@section('scripts')

<script>
  $(document).on('click','.file-btn',function(){
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
    $("#letter-table").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": [ "excel", "pdf", "print"]
    }).buttons().container().appendTo('#letter-table_wrapper .col-md-6:eq(0)');
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

    
    </script>
@endsection
@endsection
