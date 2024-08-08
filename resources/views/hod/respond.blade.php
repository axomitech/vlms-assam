@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-primary card-outline card-outline-tabs">
      <div class="card-header p-0 pt-1">
        <ul class="nav nav-pills nav-fill" id="custom-tabs-one-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Responses</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{$disableResponse}}" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Respond</a>
          </li>
        </ul>
      </div>
      <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">
          <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
             <table class="table table-sm table-striped table-hover table-responsive text text-sm text-justify">
                <thead>
                  <tr class="text-sm">
                    <th>Sl no.</th><th>Response</th><th>Response Status</th><th>Response Attached</th>
                  </tr>
                </thead>
                @php
                  $i = 1;
                @endphp
                <tbody>
                  @foreach ($responses as $value)
                  <tr class="text-sm">
                    <td>{{$i}}.</td>
                    <td style="width: 45%;"> {{$value['action_remarks']}}<br><b>Response Date:{{\Carbon\Carbon::parse($value['response_date'])->format('d/m/Y')}}</b></td><td>{{$value['status_name']}}</td><td><a class="file-btn"  data-toggle="modal" data-target="#modal-lg" data-letter_path="{{config('constants.options.storage_url')}}{{$value['response_attachment']}}"><i class="fas fa-file-pdf"></i></a></td>
                  </tr>
                  @php
                    $i++;
                  @endphp
                  @endforeach
                </tbody>
             </table>
          </div>
          <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
            <form id="note-form">
              <div class="row">
                  <div class="col-md-12">
                      <label class="form-label">Action Status</label>
                      <select class="form-control" id="action_status" name="action_status" >
                          <option value="">Select Status</option>
                          @foreach ($actionStatuses as $value)
                           <option value="{{$value['id']}}">{{$value['status_name']}}</option>   
                          @endforeach
                      </select>
                      <label class="action_status text text-danger"></label>
                  </div>
              </div>
              <div class="row">
               <div class="col-md-12">
                 <label>Response Note</label>
                 <textarea class="form-control" name="note" rows="5"></textarea>
                 <label class="text text-danger note"></label>
               </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                    <label class="form-label">Response Attachment</label>
                    <input type="file" class="form-control" name="action_response" id="action_response">
                    <label class="text text-danger action_response" ></label>
                </div>
              </div>
              <input type="hidden" name="act_sent" value="{{$actionSentId}}">
              <input type="hidden" name="act_dept" value="{{$actionDeptId}}">
              <div class="form-group row">
               <button type="button" class="btn btn-primary save-btn ml-2" data-url="{{ route('store_response') }}" data-form="#note-form" data-message="That you want to respond to the forwared actions!" id="save-response-btn">SAVE</button>
             </div>
             </form>
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
    $(".buttons-html5").addClass("btn btn-outline-info ml-1");
    $(".buttons-html5").removeClass('btn-secondary');
    $(".buttons-print").addClass("btn btn-outline-info ml-1");
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
