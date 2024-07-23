@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">LETTER ACTIONS</div>

            <div class="card-body">
               
               <table class="table table-responsive-lg table-bordered" id="letter-table">
                    <thead>
                        <tr>
                            <th>Sl No.</th><th>Letter No.</th><th>Subject</th><th>Sender</th><th>Letter</th><th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($letters as $value)
                            <tr>
                                <td>{{$i}}</td><td>{{$value['letter_no']}}</td><td>{{$value['subject']}}</td><td>{{$value['sender_name']}}</td><td><a href="{{ Storage::url($value['letter_path']) }}" target="__blank"><i class="fas fa-file-pdf"></i></a></td><td><a href="{{route('actions',[$value['letter_id'],$value['letter_no'],$value['subject'],$value['sender_name'],$value['organization'],encrypt($value['letter_path'])])}}" data-letter="{{$value['letter_id']}}" data-subject="{{$value['subject']}}" class="action-link"><i class="fas fa-pen"></i></a></td>
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
<!-- Modal -->
<div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="actionModalLabel">File Preview</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
        </div>
        <div class="modal-body">
          <form id="action-form">
            <div class="form-group row">
              <div class="col-md-4">
                <label class="form-label fw-bold">Action Priority</label>
                <select class="form-control" name="priority" id="priority" rows="5">
                    <option value="">SELECT PRIORITY</option>
                    @foreach ($priorities as $value)
                      <option value="{{$value['id']}}">{{$value['priority_name']}}</option>
                    @endforeach
                </select>
                <label class="text text-danger priority fw-bold"></label>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-12">
                <label class="form-label fw-bold">Action Plan</label>
                <textarea class="form-control" name="letter_action" id="letter_action" rows="5"></textarea>
                <label class="text text-danger letter_action fw-bold"></label>
              </div>
            </div>
            <div class="form-group row">
              {{-- @foreach ($departments as $value)
              <div class="col-md-4">
                <label class="form-label fw-bold text-justify"><input type="checkbox" name="departments[]" value="{{$value['id']}}">&nbsp;{{$value['department_name']}}</label>
              </div>
              @endforeach
            </div> --}}
            {{-- <div class="row"> --}}
                <div class="col-md-6">
                    <div class="form-group">
                      <label>Departments</label>
                      <select class="js-example-basic-multiple" multiple="multiple" data-placeholder="Select a Department" style="width: 100%;" name="departments[]">
                        @foreach ($departments as $value)
                        <option value="{{$value['id']}}">{{$value['department_name']}}</option>
                        @endforeach
                      </select>
                    </div>
                    <!-- /.form-group -->
                   
                  </div>
            </div>
            <div class="form-group row">
              <input type="hidden" id="letter" name="letter">
              <button type="button" class="btn btn-primary save-btn" data-url="{{ route('store_action') }}" data-form="#action-form" data-message="That you want to direct action to this letter!" id="save-action-btn">SAVE</button>
            </div>
          </form>
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
    
  });

  $(document).on('click','.action-link',function(){
    $('.modal-title').text($(this).data('subject'));
    $('#letter').val($(this).data('letter'));
  });

  $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
    });
</script>
@endsection
@endsection
