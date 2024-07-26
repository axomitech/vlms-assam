@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">LETTER ACTIONS FORWARDED</div>

            <div class="card-body">
               <div class="row" >
                  <div class="col-md-12">
                  
                  </div>
                  
               </div>
               <br>
               <div class="row">
                <div class="col-md-12">
                   <div class="collapse" id="collapseExample">
                     <a class="offset-11 btn btn-outline-danger mb-1" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                       CLOSE
                     </a>
                     <div class="card card-body">
                       
                     </div>
                   </div>
                 </div>
               </div>
               <div class="row" style="overflow: scroll; height: 300px;">
                  <div class="col-md-12">
                    <table class="table table-sm table-striped table-hover" id="letter-table">
                      <thead>
                          <tr class="text-sm">
                              <th>Action Forwarded</th><th>From</th><th>Respond</th>
                          </tr>
                      </thead>
                      <tbody>
                          @php
                              $i = 1;
                          @endphp
                          @foreach ($forwards as $value)
                            @php
                                $createdAt = \Carbon\Carbon::parse($value['created_at']);
                                $timeSpan = $createdAt->diffForHumans();
                            @endphp
                              <tr class="text-sm">
                                <td>{{$i}}. {{$value['action_description']}}<br><b>Delivered: {{$timeSpan}}</b></td><td>{{$value['sender_name']}}, {{$value['department_name']}}</td><td><a class="file-btn"  data-toggle="modal" data-target="#modal-lg" data-letter_path="{{config('constants.options.storage_url')}}{{$value['letter_path']}}"><i class="fas fa-file-pdf"></i></a>&emsp;<a href="{{route('responds',[encrypt($value['action_sent_id']),encrypt($value['act_dept_id']),encrypt($value['letter_id'])])}}"><i class="fas fa-pen"></i></a></td>
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
<!-- /.modal -->

<div class="modal fade" id="modal-lg">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <embed src="" type="application/pdf" id="letter-view" style="width:100%; height:350px">
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
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

  $(document).on('click','.action-link',function(){
    $('.modal-title').text($(this).data('subject'));
    $('#letter_action').val($(this).data('action'));
  });

  $(document).on('click','.note-link',function(e){
      e.preventDefault();
      $('.modal-title').text($(this).data('action_text'));
      var action = $(this).data('action');
      $.get("{{route('action_notes')}}",{
        'action':action
      },function(j){
        var tr = "";
        for(var i = 1; i < j.length; i++){
          tr += "<tr><td>"+i+"</td><td>"+j[i].name+"</td><td>"+j[i].note+"</td><td>"+j[i].date_day+"</td><td>"+j[i].date_time+"</td></tr>";
        }
        $('#note-body').html(tr);
      });

  })
</script>
@endsection
@endsection
