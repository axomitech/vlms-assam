@extends('layouts.app')

    @section('content')
        <div class="row">
            <div class="col-md-6">
                <div class="box shadow-lg p-1 mb-3 bg-white rounded min-vh-20" style="height1: 300px;">
                    <div class="box-header">
                        <div class="box-tools">
                        <p style="font-size:15px;font-weight:bold;margin-bottom: 9px; color:#173F5F;">Home</p>
                        </div>
                    </div>
                    <div class="box-body">
                        <section class="content">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-6 col-sm-3">
                                        <!-- small box -->
                                        <a href="{{route('letters')}}">
                                        <div class="small-box" style="background-color: #58a6ff;">
                                            <div class="inner">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <h3 style="color:white;">{{ $diarized_count}} </h3>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <h3 style="font-size: 22px;color:white;">Diarized </h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <span style="font-size: 40px;color:white;"><i class="fas fa-book"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <a href="{{route('letters')}}" class="small-box-footer">Diarized<i class="fas fa-arrow-circle-right"></i></a> -->
                                        </div>
                                        </a>
                                    </div>
                                    @if (session('role') > 0)  
                                        <div class="col-md-6 col-sm-3">
                                            <!-- small box -->
                                            <a href="{{route('inbox_letters')}}">
                                            <div class="small-box" style="background-color: #8355fe;">
                                                <div class="inner">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <h3 style="color:white;">{{ $inbox_count}} </h3>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <h3 style="font-size: 22px;color:white;">Inbox </h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <span style="font-size: 40px;color:white;"><i class="far fa-envelope"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <a href="{{route('letters')}}" class="small-box-footer">Diarized<i class="fas fa-arrow-circle-right"></i></a> -->
                                            </div>
                                            </a>
                                        </div>
                                        <div class="col-md-6 col-sm-3">
                                            <!-- small box -->
                                            <a href="{{route('outbox')}}">
                                            <div class="small-box" style="background-color: #3CAEA3;">
                                                <div class="inner">
                                                <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <h3 style="color:white;">{{ $sent_count}} </h3>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <h3 style="font-size: 22px;color:white;">Sent</h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <span style="font-size: 40px;color:white;"><i class="fas fa-share-square"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <a href="{{route('letters')}}" class="small-box-footer">Diarized<i class="fas fa-arrow-circle-right"></i></a> -->
                                            </div>
                                            </a>
                                        </div>
                                        <div class="col-md-6 col-sm-3">
                                            <!-- small box -->
                                            <a href="{{route('letters')}}">
                                            <div class="small-box" style="background-color: #ff9e69;">
                                                <div class="inner">
                                                <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <h3 style="color:white;">{{ $archive_count}} </h3>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <h3 style="font-size: 22px;color:white;">Archived </h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <span style="font-size: 40px;color:white;"><i class="fas fa-file-archive"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <a href="{{route('letters')}}" class="small-box-footer">Diarized<i class="fas fa-arrow-circle-right"></i></a> -->
                                            </div>
                                            </a>
                                        </div>
                                    @endif  
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="box shadow-lg p-2 mb-3 bg-white rounded d-inline-block overflow-auto w-100" style="height: 300px;">
                    <div class="box-header">
                        <div class="box-tools">
                            <div class="row">
                                <div class="col-md-3">
                                    <p style="font-size:15px;font-weight:bold;margin-bottom: 9px; color:#173F5F;">Recent Diarized</p>
                                </div>
                                <div class="col-md-3 text-right">
                                    <span class="bg-success rounded"> <small>Pending with HOD</small></span>
                                </div>
                                <div class="col-md-3 text-left text-white">
                                    <span class="bg-warning rounded"> <small>Pending with DU</small></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <section class="content">
                            <div class="container-fluid">
                                <!-- Main row -->
                                 <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th scope="col"><small><b>Diarized No.</b></small></th>
                                                    <th scope="col"><small><b>Subject</b></small></th>
                                                    <th scope="col"><small><b>From</b></small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $i=1;
                                                @endphp
                                                @if (count($diarized_details) > 0)
                                                    @foreach ($diarized_details as $value)
                                                    @if ($value->stage_status==2)
                                                        @if (session('role')== 2)
                                                            <tr class="table-success clickable-row" data-href="{{route('action_lists',[encrypt($value->letter_id)])}}" style="cursor: pointer;">
                                                        @else
                                                            <tr class="table-success clickable-row" data-href="{{route('actions',[encrypt($value->letter_id)])}}" style="cursor: pointer;">
                                                        @endif
                                                    @else
                                                        <tr class="table-warning clickable-row" data-href="{{route('action_lists',[encrypt($value->letter_id)])}}" style="cursor: pointer;">
                                                    @endif
                                                            <td><small>{{$i++.'.'.$value->crn}} <br> Date- {{$value->diary_date }}
                                                                
                                                                </small>
                                                            </td>
                                                            <td><small>{{ $value->subject}}                                                       
                                                                </small>
                                                            </td>
                                                            <td><small>{{ $value->sender_name}}<br>
                                                                    {{$value->sender_designation}},
                                                                    {{$value->organization}}                                                      
                                                                </small>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr class="text-center w-100">
                                                        <td colspan="4">No recent diarized</td>     
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                 </div>
                                <!-- Main row -->
                            </div><!-- /.container-fluid -->
                        </section>                 
                    </div>
                </div>
            </div>
        </div>
        @if (session('role') > 1)  
            <div class="row">
                <div class="col-md-6">
                    <div class="box shadow-lg p-2 mb-3 bg-white rounded min1-vh-80 d1-inline-block overflow-auto" style="height: 300px;">
                        <div class="box-header">
                            <div class="box-tools">
                            <p style="font-size:15px;font-weight:bold;margin-bottom: 9px; color:#173F5F;">Inbox Pending</p>
                            </div>
                        </div>
                        <div class="box-body">
                            <section class="content">
                                <div class="container-fluid">
                                    <!-- Main row -->
                                    <div class="row">
                                        <div class="col-md-12 bg-danger1">
                                        <table class="table table-hover table-sm">
                                            <thead>
                                                <tr>
                                                <th scope="col"><small><b>Diarized No.</b></small></th>
                                                <th scope="col"><small><b>Subject</b></small></th>
                                                <th scope="col"><small><b>Status</b></small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="table-warning">
                                                    <td><small>1. CRN/HOME/2024/08<br>
                                                                Received- 10-07-24<br>
                                                                Department- Home & Political
                                                        </small>
                                                    </td>
                                                    <td><small>VIP visit Security Plan </small></td>
                                                    <td><small>In process</small></td>
                                                </tr>
                                                <tr class="table-danger">
                                                    <td><small>1. CRN/HOME/2024/08<br>
                                                                Received- 10-07-24<br>
                                                                Department- Home & Political
                                                        </small>
                                                    </td>
                                                    <td><small>Qui expedita soluta sit alias nihil non temporibus alias aut galisum odit. Cum harum molestiae aut nihil maiores a temporibus aperiam et obcaecati quae.</small></td>
                                                    <td><small>Not started</small></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                    <!-- Main row -->
                                </div><!-- /.container-fluid -->
                            </section>                 
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box shadow-lg p-2 mb-3 bg-white rounded min1-vh-80 overflow-auto" style="height: 300px;">
                        <div class="box-header">
                            <div class="box-tools">
                            <p style="font-size:15px;font-weight:bold;margin-bottom: 9px; color:#173F5F;">Recent Responces</p>
                            </div>
                        </div>
                        <div class="box-body">
                            <section class="content">
                                <div class="container-fluid">
                                    <!-- Main row -->
                                    <div class="row">
                                        <div class="col-md-12 bg-danger1">
                                        <table class="table table-hover table-sm">
                                            <thead>
                                                <tr>
                                                <th scope="col"><small><b>Action</b></small></th>
                                                <th scope="col"><small><b>Status</b></small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="table-info">
                                                    <td><small>1. VIP visit Security Plan <br>Diarized No. <b>CRN/HOME/2024/08</b></small></td>
                                                    <td>
                                                        <small>Department- <b>Finance</b>
                                                            <br>Status- <b>Completed</b><br>
                                                            <u>Remarks</u>- We are working on it.
                                                            <br>
                                                            Date- 18-07-24
                                                        </small>
                                                    </td>
                                                </tr>
                                                <tr class="table-info1" style="background-color:#f2e6e6">
                                                    <td><small>2. Lorem ipsum dolor sit amet. Aut neque omnis et eveniet <br>Diarized No. <b>CRN/HOME/2024/08</b></small></td>
                                                    <td>
                                                        <small>Department- <b>Social Welfare</b>
                                                            <br>Status- <b>In process</b><br>
                                                            <u>Remarks</u>- We are working on it.
                                                            <br>
                                                            Date- 18-07-24
                                                        </small>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                    <!-- Main row -->
                                </div><!-- /.container-fluid -->
                            </section>                 
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endsection
    @section('scripts')
    <script>
        $(document).ready(function () {
            $(".clickable-row").click(function () {
                window.open($(this).data("href"), '_blank');
            });
        });
    </script>
    @endsection