@extends('layouts.app')

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="box shadow-lg p-3 mb-5 bg-white rounded min-vh-40">
      <div class="box-body">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-3">
                    Users
                    </div>
                    <div class="col-md-7 text-right">
                        <button type="button" class="btn btn-sm" style="background-color: #173f5f;color: white;" id="btn-modal" data-toggle="modal" data-target="addCorrespondenceModal">Add<i class="fas fa-plus-circle" style="color: #24a0ed"></i></button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="letter-form">
                            <div class="card">
                                <div class="card-body"></div>
                                    <table class="table table-sm table-hover table-striped" id="letter-table">
                                        <thead>
                                            <tr>
                                                <th>Name</th><th>Email</th><th>Department</th><th>Role</th><th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($results as $value)
                                                <tr>
                                                    <td>{{$i}}. &nbsp;{{$value->u_name}}</td><td>{{$value->u_email}}</td><td>{{$value->department_name}}</td><td>{{$value->role_name}}</td>
                                                    <td><a href="" class="action-link"><i class="fas fa-edit" style="color:#173f5f;" data-toggle="tooltip" data-placement="top" title="View/Update"></i></a></td>
                                                </tr>
                                                @php
                                                    $i++;
                                                @endphp
                                            @endforeach
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
 </div>

 <!-- Modal addCorrespondenceModalTitle-->
<div class="modal fade" id="addCorrespondenceModal" tabindex="-1" role="dialog" aria-labelledby="addCorrespondenceModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCorrespondenceModalTitle">Add New User</h5>
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
                                    <label>User Name</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="u_name" name="u_name">                   
                                </div>
                            </div>
                            <div class="row mt-2">	
                                <div class="col-md-3">
                                    <label>Govt. Email</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="email" name="email">                   
                                </div>
                            </div>
                            <div class="row mt-2">	
                                <div class="col-md-3">
                                    <label>Department</label>
                                </div>
                                <div class="col-md-9">
                                    <select class="form-control" id="dept_id">
                                        <option>Select Department</option>
                                        @foreach ($departments as $dept)
                                            <option value="{{ $dept->id }}">{{ $dept->department_name }}</option>
                                        @endforeach
                                    </select>                  
                                </div>
                            </div>
                            <div class="row mt-2">	
                                <div class="col-md-3">
                                    <label>Role</label>
                                </div>
                                <div class="col-md-9">
                                    <select class="form-control" id="dept_id">
                                        <option>Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                        @endforeach
                                    </select>                  
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class=" text-center col-md-12">
                                    <button type="button" class="btn btn-primary save-btn btn-sm " data-url="{{ route('store_correspondence') }}" data-form="#uploadForm"
                                      id="uploadBtn" data-message="Do you want to upload?" style="background-color: #173f5f;color: white;">Submit</button>
                                    <!-- <input type="button" class="btn btn-primary btn-sm " value="Submit" name="Submit"  id="uploadBtn"> -->
                                    <br>                   
                                </div>    
                            </div>
                        </form>
                    </div>
                </div>       
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div> -->
        </div>
    </div>
</div>
<!-- Modal END-->

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

    </script>
    <script>
            $('#btn-modal').click(function() {
                    $('#addCorrespondenceModal').modal({
                                backdrop: 'static',
                                keyboard: false
                    });
                });
        </script>
@endsection
@endsection
