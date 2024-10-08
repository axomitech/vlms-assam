@extends('layouts.app')

@section('content')
              @php
                  $disabled = "disabled";
              @endphp
              @if($forwardStatus <= 0)
                @php
                  $disabled = "";
                @endphp
              @endif
<div class="row">
  @php
      $disable = "";
  @endphp 
  @if (!$finalizeStatus)
      @if (count($actions) > 0)
      {{--<form id="finalize-form">
        <input type="hidden" name="finalize_letter" id="finalize_letter" value="{{$letter_id}}">
      </form>
      <button type="button" class="btn btn-outline-primary btn-sm save-btn mb-1" data-form="#finalize-form" data-message="That you want to save and send these actions for HOD!" id="save-finalize-btn" data-url="{{route('finalize_letter')}}">SAVE & SENT</button>--}}
      
      @endif
    @else
      @php
      $disable = "disabled";
      @endphp  
    @endif
  @if(count($actions) > 0)
  <div class="col-md-5">
  <div class="col-md-5">
    <button type="button" class="btn btn-warning btn-sm mb-1" data-toggle="modal" data-target=".bd-example-modal-lg" {{$disabled}}>FORWARD</button>
    @if($completeStatus == 4)
    <form id="letter-complete-form" hidden>
      <input type="hidden" name="stage_letter" value="{{$letter_id}}">
      <input type="hidden" name="stage" value="5">
    </form>
    <button type="button" class="btn btn-sm btn-danger mb-1 save-btn" data-url="{{ route('change_stage') }}" data-form="#letter-complete-form" data-message="That you want to archive the letter!" id="save-complete-btn">Archive Letter</button>
  @endif
    @if($completeStatus == 4)
    <form id="letter-complete-form" hidden>
      <input type="hidden" name="stage_letter" value="{{$letter_id}}">
      <input type="hidden" name="stage" value="5">
    </form>
    <button type="button" class="btn btn-sm btn-danger mb-1 save-btn" data-url="{{ route('change_stage') }}" data-form="#letter-complete-form" data-message="That you want to archive the letter!" id="save-complete-btn">Archive Letter</button>
  @endif
  </div>
  @endif
</div>

<div class="row  bg-danger1">
  <div class="col-md-7">
    <div class="card card-primary card-outline card-outline-tabs h-100">
      <div class="card-header">
        <ul class="nav nav-pills nav-fill nav-justified" id="custom-tabs-four-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Action List</a>
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
              <div class="col-md-2">
                <button type="button" class="btn btn-warning btn-sm mb-1" data-toggle="modal" data-target=".bd-example-modal-lg-action" {{$disable}}><i class="fas fa-plus"></i></button>
              </div>
              <table class="table table-sm table-striped text text-sm text-justify" id="letter-table">
                <thead>
                    <tr>
                        <th>Sl no.</th><th>Description</th><th>Department</th><th>Responses</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @if(count($letterActions) == 0)
                    <tr>
                      <td colspan="4" class="text text-danger">No response is available.</td>
                    </tr>
                    @else
                    @if(count($letterActions) == 0)
                    <tr>
                      <td colspan="4" class="text text-danger">No response is available.</td>
                    </tr>
                    @else
                    @foreach ($letterActions as $value)
                    <tr>
                      <td>
                        {{$i}}
                      </td>
                        <td>
                          @if(strlen($value['action_description']) > 100)
                    <tr>
                      <td>
                        {{$i}}
                      </td>
                        <td>
                          @if(strlen($value['action_description']) > 100)

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
                          
                          @else
                            {{$value['action_description']}}
                          @endif
                          <br>Dated: {{\Carbon\Carbon::parse($value['action_date'])->format('d/m/Y')}}</td>
                        <td>
                          <table class="table-bordered">
                            @for($j = 0; $j < count($actionDepartments[$i-1]); $j++)
                                  <tr><td>{{$actionDepartments[$i-1][$j]}}</td><td>{{$responsesStatuses[$i-1][$j]}}</td></tr>
                              @endfor
                          </table>
                        </td>
                        <td>
                          <a href="" class="note-link" data-action="{{$value['action_id']}}" data-toggle="modal" data-target="#noteModal" data-action_text="{{$value['action_description']}}"><i class="fas fa-eye"></i><a>
                        </td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
                    @endif
                   
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
                          
                          @else
                            {{$value['action_description']}}
                          @endif
                          <br>Dated: {{\Carbon\Carbon::parse($value['action_date'])->format('d/m/Y')}}</td>
                        <td>
                          <table class="table-bordered">
                            @for($j = 0; $j < count($actionDepartments[$i-1]); $j++)
                                  <tr><td>{{$actionDepartments[$i-1][$j]}}</td><td>{{$responsesStatuses[$i-1][$j]}}</td></tr>
                              @endfor
                          </table>
                        </td>
                        <td>
                          <a href="" class="note-link" data-action="{{$value['action_id']}}" data-toggle="modal" data-target="#noteModal" data-action_text="{{$value['action_description']}}"><i class="fas fa-eye"></i><a>
                        </td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
                    @endif
                   
                </tbody>
              </table>
            </div>
          </div>
          <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-12 text-left">
                  <button type="button" class="btn btn-sm" style="background-color: #173f5f;color: white;" id="btn-modal" data-toggle="modal" data-target="addCorrespondenceModal">Add<i class="fas fa-plus-circle" style="color: #24a0ed"></i></button>
              </div>
                  <form id="letter-form">
                      <div class="card">
                          <div class="card-body">
                              <table class="table table-striped table-sm small">
                                  <thead>
                                      <tr>
                                      <th scope="col">Subject</th>
                                      <th scope="col">Letter Date</th>
                                      <th scope="col">Uploaded By</th>
                                      <th scope="col">Upload Time</th>
                                      <th scope="col">Actions</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @php
                                      $i=1;
                                      @endphp
                                      @if (count($correspondence) > 0)
                                          @foreach ($correspondence as $result)
                                          <tr>
                                              <td>{{ $i++.'. '.$result->c_title }}</td>
                                              <td>{{ $result->letter_date}}</td>
                                              <td>{{ $result->upload_by}}</td>
                                              <td>{{ $result->upload_date}}</td>
                                              <td>
                                                  <button type="button" class="btn btn-sm" style="background-color: #ffb308;color: white1;" id="btn-modal{{$result->c_id}}" data-toggle="modal" data-target="viewCorrespondenceModal{{$result->c_id}}"><i class="fa fa-eye"></i> </button>
                                                  &nbsp;
                                                  <button type="button" class="btn btn-sm bg-danger"  id="btn-remove{{$result->c_id}}"><i class="fa fa-trash"></i> </button>
                                              </td>
                                          </tr>
                                          @endforeach
                                      @else
                                          <tr class="text-center">
                                              <td colspan="5">No file</td>     
                                          </tr>
                                      @endif
                                      
                                  </tbody>
                              </table>
                          </div>
                      </div>
                      <!-- hdhadh -->
                  </form>
              </div>
          </div>
          </div>
        </div>
      </div>
    </div>
    
  </div>
  <div class="col-md-5">
    <div class="card h-100">
      <div class="card-body">
        <iframe class="w-100" style="height:22.5rem" src="{{storageUrl($letterPath)}}">
        </iframe>
      </div>
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
                  <iframe src="{{storageUrl($letterPath)}}" style="width:100%; height: 100%;">
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
                                    <iframe src="{{storageUrl($letterPath)}}" style="width:22rem; height: 20rem;">
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
<!-- Modal addCorrespondenceModalTitle-->
<div class="modal fade" id="addCorrespondenceModal" tabindex="-1" role="dialog" aria-labelledby="addCorrespondenceModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="addCorrespondenceModalTitle">Upload Correspondence</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body" id="description_view">
              <div id="parent">
                  <div id="add">
                      <form id="uploadForm" class="form-horizontal">
                          @csrf <!-- CSRF token for Laravel -->
                          <div class="row">	
                              <div class="col-md-3">
                                  <label>Attachment Subject:</label>
                              </div>
                              <div class="col-md-6">
                                  <textarea class="form-control" rows="3" id="attachment_name" name="attachment_name"></textarea>                  
                              </div>
                          </div>		
                          <div class="row mt-3">	
                              <div class="col-md-3">
                                  <label>Letter Date:</label>
                                  <input type="hidden" name="letter_id" value="{{ $letter_id}}">
                              </div>
                              <div class="col-md-4">
                                  <input type="date" class="form-control" id="letter_date" name="letter_date" placeholder="">                 
                              </div>
                          </div>		
                          <div class="row mt-3">	
                              <div class="col-md-3">
                                  <label>Upload:</label>
                              </div>
                              <div class="col-md-4">
                              <input  type="file" class="form-control-file" id="attachment_file" name="attachment_file">                
                              </div>
                          </div>		
                          <div class="row mt-5">	
                              <div class="col-md-7 text-center">
                                  <button type="button" class="btn btn-primary save-btn btn-sm " data-url="{{ route('store_correspondence') }}" data-form="#uploadForm"
                                    id="uploadBtn" data-message="Do you want to upload?" style="background-color: #173f5f;color: white;">Submit</button>               
                              </div>
                          </div>		
                          <!-- <div class="row" id="row1">		
                              <div class=" text-left col-md-5" id="col1">
                                   <label>Letter Date:</label><br>
                                  <input type="text" class="form-control" id="attachment_name" name="attachment_name">
                                  <br>                    
                              </div>
                              <div class=" text-left col-sm-5" id="col1">
                                   <label>Letter Date:</label><br>
                                   <input type="date" class="form-control" id="letter_date" placeholder="">
                                  <br>                    
                              </div>
                              <input type="hidden" name="letter_id" value="{{ $letter_id}}">
                              <div class="  col-sm-4" id="col2">
                                  <label class = "text-left">Upload:</label><br>
                                  <input  type="file" class="form-control-file" id="attachment_file" name="attachment_file" />
                                  <br>                   
                              </div>
                              <div class=" text-left col-sm-2" id="col3">
                                  <label >Action:</label><br>
                                  <button type="button" class="btn btn-primary save-btn btn-sm " data-url="{{ route('store_correspondence') }}" data-form="#uploadForm"
                                    id="uploadBtn" data-message="Do you want to upload?" style="background-color: #173f5f;color: white;">Submit</button>
                                  <input type="button" class="btn btn-primary btn-sm " value="Submit" name="Submit"  id="uploadBtn">
                                  <br>                   
                              </div>    
                          </div> -->
                      </form>
                  </div>
              </div>       
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

          </div>
      </div>
  </div>
</div>
<!-- Modal END-->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
       <div class="modal-header">
          <h5 class="modal-title text-primary">Forward</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-5">
              <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-body">
                  <form id="note-form">
                    @for ($i = 0; $i < count($actions); $i++)
                    @foreach ($actions[$i] as $value)
                    <input type="hidden" name="action_map[]" value="{{$value['act_dept_id']}}">  
                    <input type="hidden" name="action_dept[]" value="{{$value['dept_id']}}">
                    <input type="hidden" name="letter_action[]" id="letter_action" value="{{$value['action_id']}}">
                    @endforeach
                    @endfor
                    <input type="hidden" name="forward_letter" value="{{$letter_id}}">
                  <div class="row">
                   <div class="col-md-12">
                     <label>Add Note</label>
                     <textarea class="form-control" name="note" rows="8"></textarea>
                     <label class="text text-danger note"></label>
                   </div>
                  </div>
                  <div class="form-group row">
                    <button type="button" class="btn btn-primary save-btn ml-2" data-url="{{ route('store_note') }}" data-form="#note-form" data-message="That you want to direct a note to this action!" id="save-note-btn">SAVE</button>
                 </div>
                 </form>
                </div>
              </div>
              
            </div>
            <div class="col-md-7">
              <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-body">
                  <iframe src="{{storageUrl($letterPath)}}" style="width: 25rem; height:20rem;">
                  </iframe>
                </div>
              </div>
            </div>
        </div>
        </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-lg-action" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
       <div class="modal-header">
          <h5 class="modal-title text-primary">Add Action</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-5">
              <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-body">
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
                          @if($value['id'] != session('role_dept'))
                          <option value="{{$value['id']}}">{{$value['department_name']}}</option>
                          @endif
                          @endforeach
                        </select>
                        <label class="text text-danger departments0"></label>
                      </div>
                    </div>
                    <div class="form-group row button-div">
                      <input type="hidden" id="letter" name="letter" value="{{$letter_id}}">
                      <button type="button" class="btn btn-primary save-btn ml-1" data-url="{{ route('store_action') }}" data-form="#action-form" data-message="That you want to direct action to this letter!" id="save-action-btn">SAVE</button>
                    </div>
                  </form>
                </div>
              </div>
              
            </div>
            <div cclass="col-md-7">
              <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-body">
                  <iframe src="{{storageUrl($letterPath)}}" style="width: 25rem; height:20rem;">
                  </iframe>
                </div>
              </div>
            </div>
        </div>
        </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h7 class="modal-title text-sm text-justify" id="actionModalLabel">Note Entry</h7>
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
          <h5 class="modal-title text text-sm text-justify" id="noteModalLabel">File Preview</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-5">
              <table class="table table-striped">
              <table class="table table-striped">
                <thead>
                  <tr><th>Responses</th></tr>
                </thead>
                <tbody id="note-body">
                  
                  
                </tbody>
              </table>
            </div>
            <div class="col-md-7">
              <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-body">
                  <iframe src="{{storageUrl($letterPath)}}" style="width: 25rem; height:20rem;" id="responseAttached">
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
// $(function () {
//     $("#letter-table").DataTable({
//       "responsive": true, "lengthChange": false, "autoWidth": false,
//       "buttons": [ "excel", "pdf", "print"]
//     }).buttons().container().appendTo('#letter-table_wrapper .col-md-6:eq(0)');
//     $(".buttons-html5").addClass("btn btn-outline-info ml-1 btn-sm");
//     $(".buttons-html5").removeClass('btn-secondary');
//     $(".buttons-print").addClass("btn btn-outline-info ml-1 btn-sm");
//     $(".buttons-print").removeClass('btn-secondary');
//   });

  $(document).on('click','.action-link',function(){
    $('.modal-title').text($(this).data('subject'));
    $('#letter_action').val($(this).data('action'));
  });

  $(document).on('click','.note-link',function(e){
      e.preventDefault();
     $('.modal-title').text($(this).data('action_text'));
     $('.modal-title').text($(this).data('action_text'));
      var action = $(this).data('action');
      $.get("{{route('action_notes')}}",{
        'action':action
      },function(j){
        var tr = "";
        var attachment = "";
       if(j.length > 1){
       if(j.length > 1){
          for(var i = 1; i < j.length; i++){
          if(j[i].attach != ""){
            attachment = "<a href='#' class='attach' data-attach='"+j[i].attach+"'><i class='fas fa-file-pdf text-danger'></i></a>";
          }
          tr += "<tr><td><b>"+j[i].name+"</b> : "+j[i].note+"<br>Dated:<b>"+j[i].date_day+","+j[i].date_time+"&nbsp;"+attachment+"</b></td></tr>";
          attachment = "";
          }
            $('#note-body').html(tr);
          }else{
            $('#note-body').html("<tr><td class='text text-danger'>No responses yet received!</td></tr>");
          }else{
            $('#note-body').html("<tr><td class='text text-danger'>No responses yet received!</td></tr>");
          }
      });

  })
  $(document).on('click','.attach',function(){
    $('#responseAttached').attr('src',$(this).data('attach'));
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
$('.js-example-basic-multiple').select2();
</script>
@if (session('correspondence_upload'))
      <script>
        location.reload(true);
      </script>
    @endif
    
        <script>
            $('#btn-modal').click(function() {
                    $('#addCorrespondenceModal').modal({
                                backdrop: 'static',
                                keyboard: false
                    });
                });
        </script>

    @foreach ($correspondence as $result)
        <script>
            $('#btn-modal{{$result->c_id}}').click(function() {

                // var iframe = modal.find('#annx');
                    $("#annx").attr('src', '{{storageUrl($result->file_path)}}');

                    $('#viewCorrespondenceModal').modal({
                                backdrop: 'static',
                                keyboard: false
                    });
                });
        </script>
        <script>
            $('#btn-remove{{$result->c_id}}').click(function(){

                if(confirm("Do you want to remove?")!=true){
                    exit();
                }
                var formData = {
                    correspondence_id: {{$result->c_id}},
                    _token: '{{ csrf_token() }}' // Include CSRF token if using Laravel
                    };
                // alert(correspondence_id);
                $.ajax({
                url: '{{ route('remove_correspondences') }}',
                type: 'POST',
                data:formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token in headers
                },
                success: function(response){
                    alert("Correspondence removed successfully!");
                    location.reload(true);
                }
                });
            });
        </script>
    @endforeach

@endsection
@endsection
