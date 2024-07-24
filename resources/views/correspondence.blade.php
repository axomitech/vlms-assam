@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-3">
                    Correspondences
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
                                <div class="card-body">
                                    <table class="table table-striped table-sm">
                                        <thead>
                                            <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Uploaded By</th>
                                            <th scope="col">Upload Time</th>
                                            <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $i=1;
                                            @endphp
                                            @if (count($results) > 0)
                                                @foreach ($results as $result)
                                                <tr>
                                                    <td>{{ $i++.'. '.$result->c_title }}</td>
                                                    <td>{{ $result->upload_by}}</td>
                                                    <td>{{ $result->upload_date}}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm" style="background-color: #ffb308;color: white1;" id="btn-modal{{$result->c_id}}" data-toggle="modal" data-target="viewCorrespondenceModal{{$result->c_id}}">View</button>
                                                        &nbsp;
                                                        <button type="button" class="btn btn-sm bg-danger"  id="btn-remove{{$result->c_id}}">Remove</button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr class="text-center">
                                                    <td colspan="4">No file</td>     
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
<!-- Modal addCorrespondenceModalTitle-->
<div class="modal fade" id="addCorrespondenceModal" tabindex="-1" role="dialog" aria-labelledby="addCorrespondenceModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCorrespondenceModalTitle">Add Correspondence</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="description_view">
                <div id="parent">
                    <div id="add">
                        <form id="uploadForm" class="form-horizontal">
                            @csrf <!-- CSRF token for Laravel -->		
                            <div class="row" id="row1">		
                                <div class=" text-left col-sm-4" id="col1">
                                     <label>Attachment Title:</label><br>
                                    <input type="text" id="attachment_name" name="attachment_name" />
                                    <br>                    
                                </div>
                                <input type="hidden" name="letter_id" value="{{ $letter_id}}">
                                <div class="  col-sm-4" id="col2">
                                    <label class = "text-left">Upload:</label><br>
                                    <input  type="file" id="attachment_file" name="attachment_file" />
                                    <br>                   
                                </div>
                                <div class=" text-left col-sm-4" id="col3">
                                    <label >Action:</label><br>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
<!-- Modal END-->

<!-- Modal viewCorrespondenceModal-->
<div class="modal fade" id="viewCorrespondenceModal" tabindex="-1" role="dialog" aria-labelledby="viewCorrespondenceModalTitle"
aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewannxModalTitle">View</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="description_view">
            <iframe id="annx" src="" title="Agenda File"  width="100%" height="500px"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
  <!-- Modal END-->

@section('scripts')
    <script src="{{asset('js/custom/common.js')}}"></script>
    <!-- Bootstrap JS and dependencies -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
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

    @foreach ($results as $result)
        <script>
            $('#btn-modal{{$result->c_id}}').click(function() {

                // var iframe = modal.find('#annx');
                    $("#annx").attr('src', '{{config('constants.options.storage_url')}}{{$result->file_path}}');

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
