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
             
               <div class="row" style="overflow: scroll; height: 300px;">
                  <div class="col-md-12">
                    <table class="table table-sm table-hover table-striped table-responsive text text-sm text-justify" id="letter-table">
                      <thead>
                          <tr>
                              <th>Sl no.</th><th>Action Forwarded</th><th>To</th><th>Sent</th>
                          </tr>
                      </thead>
                      <tbody>
                          @php
                              $i = 1;
                          @endphp
                          @foreach ($forwardActions as $value)
                            @php
                                 $timeSpan = "";
                            @endphp
                              <tr>
                                  <td>{{$i}}</td>
                                  <td style="width: 35%;"> {{$value['action_description']}}</td><td>
                                    @foreach ($forwards[$i-1] as $forward)
                                        
                                    @endforeach 
                                    <ul class="list-group">
                                        @foreach ($forwards[$i-1] as $forward)
                                        @php
                                            $createdAt = \Carbon\Carbon::parse($forward['created_at']);
                                            $timeSpan = $createdAt->diffForHumans();
                                        @endphp
                                        <li class="list-group-item"><a href="" data-toggle="modal" data-target="#exampleModal" class="response-link" data-action_sent="{{$forward['action_sent_id']}}">{{$forward['receiver_name']}},{{$forward['department_name']}}</a></li>
                                        @endforeach
                                       
                                      </ul>   
                                </td><td>
                                    <ul class="list-group">
                                        @foreach ($forwards[$i-1] as $forward)
                                        @php
                                            $createdAt = \Carbon\Carbon::parse($forward['created_at']);
                                            $timeSpan = $createdAt->diffForHumans();
                                        @endphp
                                        <li class="list-group-item"> {{$timeSpan}}</li>
                                        @endforeach
                                       
                                      </ul>
                                    
                                    
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <table class="table table-sm table-striped table-hover table-responsive text text-sm text-justify" id="outbox-table">
                <thead>
                  <tr class="text-sm">
                    <th>Sl no.</th>
                    <th>Response</th><th>Response Status</th><th>Response Attached</th>
                  </tr>
                </thead>
               <tbody id="response-body">
                  
                </tbody>
             </table>
             <div class="collapse" id="collapseExample">
                <div class="card card-body">
                    <embed src="" type="application/pdf" id="letter-view" style="width:100%; height:350px">
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
  
  $(function () {
    $("#outbox-table").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": [ "excel", "pdf", "print"]
    })
  });


  $(document).on('click','.response-link',function(){
    $.get("{{route('action_response')}}",{
        action_sent:$(this).data('action_sent')
    },function(j){
        var tr = "";
        for(var i = 1; i < j.length; i++){
            tr += "<tr><td>"+i+"</td><td>"+j[i].remarks+"<br><b>Responded:"+j[i].response_date+"</b></td><td>"+j[i].status+"</td><td><a class='file-btn'  data-toggle='collapse' href='#collapseExample' data-letter_path="+j[i].attachment+"><i class='fas fa-file-pdf'></i></a></td></tr>";
        }
        $('#response-body').html(tr);
    });
  });
  $(document).on('click','.file-btn',function(){
     $('#letter-view').attr('src',$(this).data('letter_path'));
  });
</script>
@endsection
@endsection
