@extends('layouts.app')

    @section('content')
        <div class="row">
            <div class="col-md-12 text-center">
                <h4>DASHBOARD</h4>
            </div>
        </div>
        <div class="row mt-1">
            <div class="box-body col-md-12">
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            @if (session('role') > 0)  
                                <div class="col-md-4 col-sm-4">
                                    <!-- small box -->
                                    <a href="{{route('receipt_box')}}">
                                    <div class="small-box" style="background-color: #55fe9b;">
                                        <div class="inner">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <h3 style="color:white;">{{ $receipt_count}} </h3>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <h3 style="font-size: 22px;color:white;">Receipt </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <span style="font-size: 40px;color:white;"><i class="fas fa-file-invoice"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <a href="{{route('letters')}}" class="small-box-footer">Diarized<i class="fas fa-arrow-circle-right"></i></a> -->
                                    </div>
                                    </a>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <!-- small box -->
                                    <a href="{{route('issue_box')}}">
                                    <div class="small-box" style="background-color: #e65d4b;">
                                        <div class="inner">
                                        <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <h3 style="color:white;">{{ $issue_count}} </h3>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <h3 style="font-size: 22px;color:white;">Issue</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <span style="font-size: 40px;color:white;"><i class="fas fa-file"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <a href="{{route('letters')}}" class="small-box-footer">Diarized<i class="fas fa-arrow-circle-right"></i></a> -->
                                    </div>
                                    </a>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <!-- small box -->
                                    <a href="{{route('letters')}}">
                                    <div class="small-box" style="background-color: #f8ed58;">
                                        <div class="inner">
                                        <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <h3 style="color:white;">{{ $action_count}} </h3>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <h3 style="font-size: 22px;color:white;">Actions </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <span style="font-size: 40px;color:white;"><i class="fas fa-tasks"></i></span>
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
            <div class="box-body col-md-12">
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            @if (session('role') > 0)  
                                <div class="col-md-4 col-sm-4">
                                    <!-- small box -->
                                    <a href="{{ route('letters', ['tab' => 'inbox']) }}">
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
                                <div class="col-md-4 col-sm-4">
                                    <!-- small box -->
                                    <a href="{{ route('letters', ['tab' => 'sent']) }}">
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
                                <div class="col-md-4 col-sm-4">
                                    <!-- small box -->
                                    <a href="{{ route('letters', ['tab' => 'archive']) }}">
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
            <div class="col-md-6">
                <div class="box shadow-lg p-3 mb-5 bg-white rounded min-vh-40">
                    <div class="box-header">
                        <div class="box-tools">
                        <p><small><b>Actions</b></small></p>
                        </div>
                    </div>
                    <div class="box-body">
                        <section class="content">
                            <div class="container-fluid">
                                <!-- Main row -->
                                 <div class="row">
                                    <div class="col-md-12 bg-danger1">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col"><small><b>Diarized No.</b></small></th>
                                                    <th scope="col"><small><b>Subject</b></small></th>
                                                    <th scope="col"><small><b>Department</b></small></th>
                                                    <th scope="col"><small><b>Pending</b></small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="table-danger">
                                                <td><small>1. CRN/CS/2024/10</small></td>
                                                <td><small>PM Awas Yojona</small></td>
                                                <td><small>Home & Political</small></td>
                                                <td><small>>60 Days</small></td>
                                                </tr>
                                                <tr>
                                                <td><small>2. CRN/CS/2024/09</small></td>
                                                <td><small>Jal Jeevan Misssion Scheme status</small></td>
                                                <td><small>Election Department</small></td>
                                                <td><small><'30 Days</small></td>
                                                </tr>
                                                <tr class="table-warning1">
                                                <td><small>3. CRN/CS/2024/08</small></td>
                                                <td><small>Home Ministry Query</small></td>
                                                <td><small>Fishery Department</small></td>
                                                <td><small><'30 Days</small></td>
                                                </tr>
                                                <tr class="table-warning">
                                                <td><small>4. CRN/CS/2024/07</small></td>
                                                <td><small>New Building Needed</small></td>
                                                <td><small>Excise Department</small></td>
                                                <td><small>>30 Days</small></td>
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
                <div class="box shadow-lg p-3 mb-5 bg-white rounded min-vh-40">
                    <div class="box-header">
                        <div class="box-tools">
                        <p><small><b>Letters</b></small></p>
                        </div>
                    </div>
                    <div class="box-body">
                        <section class="content">
                            <div class="container-fluid">
                                <!-- Main row -->
                                 <div class="row">
                                    <div class="col-md-12 bg-danger1">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col"><small><b>Diarized No.</b></small></th>
                                                    <th scope="col"><small><b>Subject</b></small></th>
                                                    <th scope="col"><small><b>Completed</b></small></th>
                                                    <th scope="col"><small><b>Pending</b></small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="table-danger1">
                                                <td><small>1. CRN/CS/2024/10</small></td>
                                                <td><small>PM Awas Yojona</small></td>
                                                <td><small>3/5</small></td>
                                                <td><small><30 Days</small></td>
                                                </tr>
                                                <tr class="table-warning">
                                                <td><small>2. CRN/CS/2024/09</small></td>
                                                <td><small>Jal Jeevan Misssion Scheme status</small></td>
                                                <td><small>1/2</small></td>
                                                <td><small>>30 Days</small></td>
                                                </tr>
                                                <tr class="table-warning1">
                                                <td><small>3. CRN/CS/2024/08</small></td>
                                                <td><small>Home Ministry Query</small></td>
                                                <td><small>2/4</small></td>
                                                <td><small><30 Days</small></td>
                                                </tr>
                                                <tr class="table-warning">
                                                <td><small>4. CRN/CS/2024/07</small></td>
                                                <td><small>New Building Needed</small></td>
                                                <td><small>5/6</small></td>
                                                <td><small>>30 Days</small></td>
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
                <div class="box shadow-lg p-3 mb-5 bg-white rounded min-vh-40">
                    <!-- <div class="box-header">
                        <div class="box-tools">
                        <p style="font-size:18px;font-weight:bold;margin-bottom: 9px; color:#173F5F;">Actions</p>
                        </div>
                    </div> -->
                    <div class="box-body">
                        <section class="content">
                            <div class="container-fluid">
                                <!-- Main row -->
                                 <div class="row">
                                    <div class="col-md-12 bg-danger1 text-center">
                                        <div style="width: 60%; margin: auto;">
                                            <canvas id="myChart1"></canvas>
                                            <span>Actions</span>
                                        </div>
                                    </div>
                                 </div>
                                <!-- Main row -->
                            </div><!-- /.container-fluid -->
                        </section>                 
                    </div>
                </div>
            </div>
            <div class="col-md-6">
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
                                    <div class="col-md-12 bg-danger1 text-center">
                                        <!-- <div style="width: 60%; margin: auto;"> -->
                                        <div style="width: 60%; margin: auto;">
                                            <canvas id="myChart2"></canvas>
                                            <span>Letters</span>
                                        </div>
                                    </div>
                                 </div>
                                <!-- Main row -->
                            </div><!-- /.container-fluid -->
                        </section>                 
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-12">
                <div class="box shadow-lg p-3 mb-5 bg-white rounded min-vh-100">
                    <!-- <div class="box-header">
                        <div class="box-tools">
                        <p style="font-size:18px;font-weight:bold;margin-bottom: 9px; color:#173F5F;">Status</p>
                        </div>
                    </div> -->
                    <div class="box-body">
                        <section class="content">
                            <div class="container-fluid">
                                <!-- Main row -->
                                 <div class="row">
                                    <div class="col-md-5 bg-danger1 text-right">
                                        <h6><b>Filter by Status:</b></h6>
                                    </div>
                                    <div class="col-md-3 bg-danger1 text-center">
                                        <!-- <div style="width: 60%; margin: auto;"> -->
                                        <div class="form-group">
                                            <select class="form-control" id="exampleFormControlSelect1">
                                            <option>All</option>
                                            <option>Pending</option>
                                            <option>Completed</option>
                                            <option>Archived</option>
                                            <option>Diarized</option>
                                            </select>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-12 bg-danger1">
                                        <table class="table table-responsive-lg table-bordered" id="letter-table">
                                            <thead>
                                                <tr>
                                                    <th>Sl No.</th><th>Letter No.</th><th>Subject</th><th>Sender</th><th>Pending</th>
                                                    <th>Completed</th><th>Letter</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = 1;
                                                @endphp
                                                @foreach ($letters as $value)
                                                    <tr>
                                                        <td>{{$i}}</td><td>{{$value['letter_no']}}</td><td>{{$value['subject']}}</td><td>{{$value['sender_name']}}</td>
                                                    <td>30 Days</td><td>4/5</td><td><a href="{{url('../storage/app/'.$value['letter_path'])}}"><i class="fas fa-file-pdf"></i></a></td>
                                                    </tr>
                                                    @php
                                                        $i++;
                                                    @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                 </div>
                                <!-- Main row -->
                            </div><!-- /.container-fluid -->
                        </section>                 
                    </div>
                </div>
            </div> --}}
        </div>
    @endsection
    @section('scripts')
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

        </script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-3d"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch('/dashboard-data')
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById('myChart3').getContext('2d');
                    const myChart = new Chart(ctx, {
                        type: 'pie',
                        data: data.chart1,
                        options: {
                            responsive: true,
                            plugins: {
                                datalabels: {
                                    color: 'blue',
                                    font: {
                                        size: 14,
                                        weight: 'bold'
                                    },
                                    formatter: (value, ctx) => {
                                        return value;
                                        // return ctx.chart.data.
                                        //     labels[ctx.dataIndex] + ': ' + value;
                                    }
                                },
                                legend: {
                                    position: 'right'
                                },
                            },
                            animation: {
                                animateRotate: true,
                                animateScale: true
                            },
                        }
                    });
                });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch('/dashboard-data')
                .then(response => response.json())
                .then(data1 => {
                    var ctx = document.getElementById('myChart5').getContext('2d');
                    

                    var doughnutChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: data1.chart2,
                        options: {
                            responsive: true,
                            plugins: {
                                datalabels: {
                                    color: 'blue',
                                    font: {
                                        size: 14,
                                        weight: 'bold'
                                    },
                                    formatter: (value, ctx) => {
                                        return ctx.chart.data.
                                            labels[ctx.dataIndex] + ': ' + value;
                                    }
                                },
                                legend: {
                                    position: 'right'
                                }
                            }
                        }
                    });
                });
            });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch('/dashboard-data')
                .then(response => response.json())
                .then(data3 => {
                    var ctx = document.getElementById('myChart2').getContext('2d');

                    var pieChart = new Chart(ctx, {
                        type: 'pie',
                        data: data3.chart1,
                        options: {
                            responsive: true,
                            plugins: {
                                datalabels: {
                                    color: 'black',
                                    font: {
                                        size: 14,
                                        weight: 'bold'
                                    },
                                    formatter: (value, ctx) => {
                                        return  value;
                                        // return ctx.chart.data.
                                        //     labels[ctx.dataIndex] + ': ' + value;
                                    }
                                },
                                legend: {
                                    position: 'right'
                                }
                            }
                        },
                        plugins: [ChartDataLabels]
                    });
                });
            });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch('/dashboard-data')
                .then(response => response.json())
                .then(data3 => {
                    var ctx = document.getElementById('myChart1').getContext('2d');

                    var pieChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: data3.chart2,
                        options: {
                            responsive: true,
                            plugins: {
                                datalabels: {
                                    color: 'black',
                                    font: {
                                        size: 14,
                                        weight: 'bold'
                                    },
                                    formatter: (value, ctx) => {
                                        return  value;
                                        // return ctx.chart.data.
                                        //     labels[ctx.dataIndex] + ': ' + value;
                                    }
                                },
                                legend: {
                                    position: 'right'
                                }
                            }
                        },
                        plugins: [ChartDataLabels]
                    });
                });
            });
    </script>
    @endsection
    