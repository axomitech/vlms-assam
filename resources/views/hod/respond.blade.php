@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">LETTER RESPONSES</div>

            <div class="card-body">
               
               <div class="row" style="overflow: scroll; height: 300px;">
                  <div class="col-md-12">
                    {{-- <table class="table table-responsive-lg table-bordered" id="letter-table">
                      <thead>
                          <tr>
                              <th>Sl No.</th><th>Department</th><th>Description</th><th>Registered Date</th><th>Note</th><th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          @php
                              $i = 1;
                          @endphp
                          @foreach ($actions as $value)
                              <tr>
                                  <td>{{$i}}</td><td>{{$value['department_name']}}</td><td>{{$value['action_description']}}</td><td>{{\Carbon\Carbon::parse($value['action_date'])->format('d/m/Y')}}</td><td>{{$notes[$i-1]}}</td><td><a data-toggle="modal" data-target="#actionModal" href="#" data-letter="{{$value['letter_id']}}" data-subject="{{$value['action_description']}}" class="action-link" data-action="{{$value['action_id']}}"><i class="fas fa-pen"></i></a>&emsp;<a href="" class="note-link" data-action="{{$value['action_id']}}" data-toggle="modal" data-target="#noteModal" data-action_text="{{$value['action_description']}}"><i class="fas fa-eye"></i><a></td>
                              </tr>
                              @php
                                  $i++;
                              @endphp
                          @endforeach
                      </tbody>
                    </table> --}}
                  </div>
               </div>
               <div class="row">
                <div class="col-md-5">
                  <div class="box shadow-lg p-3 mb-5 bg-white rounded min-vh-40">
                    <!-- <div class="box-header">
                        <div class="box-tools">
                        <p style="font-size:18px;font-weight:bold;margin-bottom: 9px; color:#173F5F;">Letters</p>
                        </div>
                    </div> -->
                    <div class="box-body">
                        <section class="content">
                            <div class="container-fluid">
                                <!-- Main row -->
                                 <div class="row">
                                    <div class="col-md-12 bg-danger1">
                                        <form id="note-form" style="margin-top: 5rem;">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form-label">Response Attachment</label>
                                                    <input type="file" class="form-control" name="action_response" id="action_response">
                                                    <label class="text text-danger action_response" ></label>
                                                </div>
                                            </div>
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
                                            <input type="hidden" name="act_sent" value="{{$actionSentId}}">
                                            <input type="hidden" name="act_dept" value="{{$actionDeptId}}">
                                            <div class="form-group row">
                                             <button type="button" class="btn btn-primary save-btn ml-2" data-url="{{ route('store_response') }}" data-form="#note-form" data-message="That you want to respond to the forwared actions!" id="save-response-btn">SAVE</button>
                                           </div>
                                           </form>
                                        
                                        
                                    </div>
                                 </div>
                                <!-- Main row -->
                            </div><!-- /.container-fluid -->
                        </section>                 
                    </div>
                </div>
                 </div>
                 <div class="col-md-7">
                  <div class="box shadow-lg p-3 mb-5 bg-white rounded min-vh-40" style="height:22rem;">
                    <div class="box-body">
                        <section class="content">
                            <div class="container-fluid">
                                <!-- Main row -->
                                <div class="col-md-12 bg-danger1">
                                  <!-- <div style="width: 60%; margin: auto;"> -->
                                    <iframe src="{{$letterPath}}" style="width:32rem; height: 20rem;">
                                    </iframe>
                              </div>
                            </div><!-- /.container-fluid -->
                        </section>                 
                    </div>
                  </div>
                 </div>
              </div>
                
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
