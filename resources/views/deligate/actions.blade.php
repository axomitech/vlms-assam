@extends('layouts.app')

@section('content')

<div class="row">
  <div class="col-md-7">
    <div class="card card-primary card-outline card-outline-tabs">
      <div class="card-header">
        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Actions</a>
          </li>
          <li class="nav-item">
            @php
                  $disabled = "disabled";
            @endphp
            @if($forwardStatus <= 0)
              @if($finalizeStatus)
                @php
                  $disabled = "";
                @endphp
              @endif
            @endif
            <a class="nav-link {{$disabled}}" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Forward</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Correspondence</a>
          </li>
        </ul>
      </div>
      <div class="card-body">
        <div class="tab-content" id="custom-tabs-four-tabContent">
          <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
            <div>
              <table class="table table-sm table-striped" id="letter-table">
                <thead>
                    <tr>
                        <th>Description</th><th>Department</th><th>Status</th><th>Responses</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($letterActions as $value)
                        <tr>
                            <td>{{$i}}. &nbsp;{{$value['action_description']}}<br>Dated: {{\Carbon\Carbon::parse($value['action_date'])->format('d/m/Y')}}</td>
                            <td>
                                <ul class="list-group">
                                    @for($j = 0; $j < count($actionDepartments[$i-1]); $j++)
                                      <li class="list-group-item">{{$actionDepartments[$i-1][$j]}}</li>
                                    @endfor
                                </ul>
                            </td>
                            <td>

                            </td>
                            
                            <td>
                              <a href="" class="note-link" data-action="{{$value['action_id']}}" data-toggle="modal" data-target="#noteModal" data-action_text="{{$value['action_description']}}"><i class="fas fa-eye"></i><a>
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
          <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
            <form id="note-form">
              @foreach ($actions as $value)
                  <input type="hidden" name="action_map[]" value="{{$value['act_dept_id']}}">  
                  <input type="hidden" name="action_dept[]" value="{{$value['dept_id']}}">
                  @endforeach
                  <input type="hidden" name="forward_letter" value="{{$letter_id}}">
              <div class="row">
               <div class="col-md-12">
                 <label>Add Note</label>
                 <textarea class="form-control" name="note" rows="5"></textarea>
                 <label class="text text-danger note"></label>
               </div>
              </div>
              <div class="form-group row">
                @foreach ($actions as $value)
                <input type="hidden" name="letter_action[]" id="letter_action" value="{{$value['action_id']}}">
                @endforeach
               <button type="button" class="btn btn-primary save-btn ml-2" data-url="{{ route('store_note') }}" data-form="#note-form" data-message="That you want to direct a note to this action!" id="save-note-btn">SAVE</button>
             </div>
             </form>
          </div>
          <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
             Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna.
          </div>
          <div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">
             Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate. Morbi euismod molestie tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec interdum placerat urna nec pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc et felis ut nisl commodo dignissim. In hac habitasse platea dictumst. Praesent imperdiet accumsan ex sit amet facilisis.
          </div>
        </div>
      </div>
    </div>
    
  </div>
  <div class=" col-md-5">
    <iframe src="{{config('constants.options.storage_url')}}{{$letterPath}}" style="width:100%; height: 100%;">
    </iframe>
  </div>
</div>
{{-- <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header"><b>{{$letterCrn}}</b><button type="button" class="btn btn-outline-primary btn-sm offset-8" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">VIEW LETTER</button>
              
            </div>

            <div class="card-body">
               
               <div class="collapse" id="collapseExample">
                <button type="button" class="btn btn-outline-danger btn-sm offset-11 mb-1" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">CLOSE</button>
                <div class="card card-body" style="height: 50rem;">
                  <iframe src="{{config('constants.options.storage_url')}}{{$letterPath}}" style="width:100%; height: 100%;">
                  </iframe>
                </div>
              </div>
               <br>
               <div class="row" style="overflow: scroll; height: 300px;">
                  <div class="col-md-12">
                    <table class="table table-responsive-lg table-bordered" id="letter-table">
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
                 </table>
                  </div>
               </div>
               <div class="row">
                <div class="col-md-7">
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
                                        
                                        
                                        
                                    </div>
                                 </div>
                                <!-- Main row -->
                            </div><!-- /.container-fluid -->
                        </section>                 
                    </div>
                </div>
                 </div>
                 <div class="col-md-5">
                  <div class="box shadow-lg p-3 mb-5 bg-white rounded min-vh-40" style="height:22rem;">
                    <div class="box-body">
                        <section class="content">
                            <div class="container-fluid">
                                <!-- Main row -->
                                <div class="col-md-12 bg-danger1">
                                  <!-- <div style="width: 60%; margin: auto;"> -->
                                    <iframe src="{{config('constants.options.storage_url')}}{{$letterPath}}" style="width:22rem; height: 20rem;">
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
</div> --}}
<!-- Modal -->
<div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="actionModalLabel">Note Entry</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
        </div>
        <div class="modal-body">
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="noteModalLabel">File Preview</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <table class="table table-responsive-lg table-bordered">
                <thead>
                  <tr><th>Sl No.</th><th>Name</th><th>Notes</th><th>Date</th><th>Time</th></tr>
                </thead>
                <tbody id="note-body">

                </tbody>
              </table>
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
