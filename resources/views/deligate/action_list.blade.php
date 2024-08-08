@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-12">
    <form id="finalize-form" hidden>
      <input type="hidden" name="finalize_letter" id="finalize_letter" value="{{$letter_id}}">
    </form>
    &nbsp;
    @php
      $disable = ""
    @endphp
    @if (!$finalizeStatus)
    @if (count($actions) > 0)

    <button type="button" class="btn btn-outline-primary btn-sm save-btn mb-1" data-form="#finalize-form" data-message="That you want to finalize these actions!" id="save-finalize-btn" data-url="{{route('finalize_letter')}}">FINALIZE</button></div> 
    
    @endif
    @else
      @php
      $disable = "disabled";
      @endphp  
    @endif
  </div>
</div>
<div class="row">
  <div class="col-md-7">
    <div class="card card-primary card-outline card-outline-tabs">
      <div class="card-header">
        <ul class="nav nav-pills nav-fill" id="custom-tabs-four-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Actions</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{$disable}}" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false" disabled>Add Action</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Correspondence</a>
          </li>
        </ul>
      </div>
      <div class="card-body">
        <div class="tab-content" id="custom-tabs-four-tabContent">
          <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
            <div style="overflow-x:auto;">
              <table class="table table-sm table-striped" id="letter-table">
                <thead>
                    <tr class="text-sm">
                        <th>Description</th><th>Department</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($letterActions as $value)
                        <tr class="text-sm">
                            <td>{{$i}}. &nbsp;
                              <div class="text-block" id="textBlock1">
                                <p class="shortText">
                                  {{substr($value['action_description'], 0, 100)}}... 
                                  <a href="#" class="readMore">Read more</a>
                                </p>
                                <div class="longText" style="display: none;">
                                  <p>
                                    {{$value['action_description']}}
                                    <a href="#" class="readLess">Read less</a>
                                  </p>
                                </div>
                              <br>Dated:{{\Carbon\Carbon::parse($value['action_date'])->format('d/m/Y')}}
                            </td>
                            <td>
                                <table class="table-bordered">
                                  @for($j = 0; $j < count($actionDepartments[$i-1]); $j++)
                                      <tr>
                                          <td>
                                            {{$actionDepartments[$i-1][$j]}}
                                          </td>
                                          <td>
                                            {{$responsesStatuses[$i-1][$j]}}
                                          </td>
                                      </tr>
                                    @endfor
                                </table>
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
            <form id="action-form">
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
    
    $(".buttons-html5").addClass("btn btn-outline-info ml-1 btn-sm");
    $(".buttons-html5").removeClass('btn-secondary');
    $(".buttons-print").addClass("btn btn-outline-info ml-1 btn-sm");
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
