@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Ackwoledgement </div>

            <div class="card-body">
               
                <div class="row">
                    <div class="col-md-6 ">
                        <form id="letter-form">
                            <!-- hdhadh -->
                            <!-- <div class="form-group row">
                                <div class="col-md-12"><textarea class="form-control" name="acknowledge_text" id="acknowledge_text" readonly>{{ $default_ack}}</textarea>
                                    <label class="text text-danger subject fw-bold"></label>
                                </div>
                            </div> -->
                            <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><u>Send to : "{{ $sender_email}}"</u></h5>
                                        <p class="card-text"><p></p>Dear Sir/Madam,</p>
                                        <p class="card-text"><p></p>{{ $default_ack}}</p></p>
                                        <p class="card-text"><p></p>{{ $system_msg}}</p></p>
                                        <button type="button" class="btn" style="background-color: #173f5f;color: white;" id="btn-next">Sent</button>
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
<!-- Modal -->
<div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="fileModalLabel">Letter</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
        </div>
        <div class="modal-body">
          <div class="fileContent"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@section('scripts')
    <script src="{{asset('js/custom/common.js')}}"></script>
    <script type="text/javascript" src="{{ asset('tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    
@endsection
@endsection
