@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-7">
    <div class="card card-primary card-outline card-outline-tabs">
      <div class="card-header">
        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Messages</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">Settings</a>
          </li>
        </ul>
      </div>
      <div class="card-body">
        <div class="tab-content" id="custom-tabs-four-tabContent">
          <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
             Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin malesuada lacus ullamcorper dui molestie, sit amet congue quam finibus. Etiam ultricies nunc non magna feugiat commodo. Etiam odio magna, mollis auctor felis vitae, ullamcorper ornare ligula. Proin pellentesque tincidunt nisi, vitae ullamcorper felis aliquam id. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin id orci eu lectus blandit suscipit. Phasellus porta, ante et varius ornare, sem enim sollicitudin eros, at commodo leo est vitae lacus. Etiam ut porta sem. Proin porttitor porta nisl, id tempor risus rhoncus quis. In in quam a nibh cursus pulvinar non consequat neque. Mauris lacus elit, condimentum ac condimentum at, semper vitae lectus. Cras lacinia erat eget sapien porta consectetur.
          </div>
          <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
             Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam.
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
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header"><b>{{$letterCrn}} </b>&emsp;&emsp;&emsp;&emsp;&emsp;<button type="button" class="btn btn-outline-primary btn-sm offset-7" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">VIEW LETTER</button>
              <form id="finalize-form" hidden>
                <input type="hidden" name="finalize_letter" id="finalize_letter" value="{{$letter_id}}">
              </form>
              &nbsp;
              @if (!$finalizeStatus)
              <button type="button" class="btn btn-outline-primary btn-sm save-btn" data-form="#finalize-form" data-message="That you want to finalize these actions!" id="save-finalize-btn" data-url="{{route('finalize_letter')}}">FINALIZE</button></div> 
              @endif

            <div class="card-body">
             
               <div class="collapse" id="collapseExample">
                <button type="button" class="btn btn-outline-danger btn-sm offset-11 mb-1" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">CLOSE</button>
                <div class="card card-body" style="height: 50rem;">
                  <iframe src="{{config('constants.options.storage_url')}}{{$letterPath}}" style="width:100%; height: 100%;">
                  </iframe>
                </div>
              </div>
               <br>
               <div class="row">
                  <div class="col-md-12">
                    <div style="overflow:scroll;">
                      <table class="table table-responsive-lg table-bordered" id="letter-table">
                        <thead>
                            <tr>
                                <th>Sl No.</th><th>Department</th><th>Description</th><th>Registered Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($actions as $value)
                                <tr>
                                    <td>{{$i}}</td><td>{{$value['department_name']}}</td><td>{{$value['action_description']}}</td><td>{{\Carbon\Carbon::parse($value['action_date'])->format('d/m/Y')}}</td>
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
               
               <div class="row">
                  <div class="col-md-5">
                    
                  </div>
               </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
  <div class="col-md-7">
    <div class="box shadow-lg p-3 mb-5 bg-white rounded min-vh-40">
      <div class="box-body">
          <section class="content">
              <div class="container-fluid">
                  <!-- Main row -->
                  <div class="row">
                      <div class="col-md-12 bg-danger1">
                        <form id="action-form">
                          <div class="row">
                            {{-- <div class="offset-10 col-md-1 mr-5">
                              <br>
                            <button type="button" class="btn btn-outline-success btn-xs add-action"><i class="fa fa-plus"></i></button>
                            </div> --}}
                            
                          </div>
                          <div class="form-group row first-div">
                            <div class="col-md-12">
                              <label class="form-label fw-bold">Action Point</label>
                              <textarea class="form-control" name="letter_action" id="letter_action" rows="4"></textarea>
                              <label class="text text-danger letter_action fw-bold"></label>
                            </div>
                            <div class="col-md-12">
                              <label>Departments</label>
                              <select class="form-control js-example-basic-multiple" name="departments[]" multiple="multiple">
                                <option value="">SELECT DEPARTMENT</option>
                                @foreach ($departments as $value)
                                <option value="{{$value['id']}}">{{$value['department_name']}}</option>
                                @endforeach
                              </select>
                              <label class="text text-danger departments0"></label>
                            </div>
                            <div class="col-md-2">
                              &nbsp;
                            </div>
                          </div>
                      
                        
                          <div class="form-group row button-div">
                            <input type="hidden" id="letter" name="letter" value="{{$letter_id}}">
                            <button type="button" class="btn btn-primary save-btn ml-1" data-url="{{ route('store_action') }}" data-form="#action-form" data-message="That you want to direct action to this letter!" id="save-action-btn">SAVE</button>
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
  <div class="col-md-5">
    <div class="box shadow-lg p-3 mb-5 bg-white rounded min-vh-40">
      <div class="box-body">
          <section class="content">
              <div class="container-fluid">
                  <!-- Main row -->
                  <div class="row">
                      <div class="col-md-12 bg-danger1" style="height: 22rem;">
                        <iframe src="{{config('constants.options.storage_url')}}{{$letterPath}}" style="width:100%; height: 100%;">
                        </iframe>
                      </div>
                  </div>
                  <!-- Main row -->
              </div><!-- /.container-fluid -->
          </section>                 
      </div>
   </div>
  </div>
</div>
{{-- <div hidden >
  <div class="action-clone col-md-12">
    <div class="row">
      <div class="col-md-12">
        <label class="form-label fw-bold">Action Point</label>
        <textarea class="form-control" name="letter_action[]"></textarea>
        <label class="text text-danger letter_action fw-bold"></label>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <label>Departments</label>
        <select class="form-control js-example-basic-multiple" name="departments[]" multiple="multiple">
          <option value="">SELECT DEPARTMENT</option>
          @foreach ($departments as $value)
          <option value="{{$value['id']}}">{{$value['department_name']}}</option>
          @endforeach
        </select>
      </div>
      </div>
      <div class="col-md-2">
        <button type="button" class="btn btn-outline-danger btn-xs mt-5 remove"><i class="fa fa-minus"></i></button>
      </div>
    </div>
  </div> --}}
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
      "buttons": [ "excel", "pdf", "print"],
    }).buttons().container().appendTo('#letter-table_wrapper .col-md-6:eq(0)');
    
    $(".buttons-html5").addClass("btn btn-outline-info ml-1");
    $(".buttons-html5").removeClass('btn-secondary');
    $(".buttons-print").addClass("btn btn-outline-info ml-1");
    $(".buttons-print").removeClass('btn-secondary');
  });
  
  $(document).on('click','.action-link',function(){
    $('.modal-title').text($(this).data('subject'));
    $('#letter').val($(this).data('letter'));
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
          tr += "<tr><td>"+j[i].note+"</td></tr>";
        }
        $('#note-body').html(tr);
      });

  })
  $(document).ready(function() {
    var actionClone = $('.action-clone').clone();
      $(document).on('click','.add-action',function(){
        $('.js-example-basic-multiple').select2();
      $('.first-div').append(actionClone.clone());
      
    });
    $('form').on('click', '.remove', function () {
          $(this).parent().parent().remove();
      });
    });

    $('.js-example-basic-multiple').select2();

    
</script>
@endsection
@endsection
