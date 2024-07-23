@extends('layouts.app')

    @section('content')
        <div class="row ">
            <div class="col-md-12">
                <div class="box shadow-lg p-3 mb-5 bg-white rounded min-vh-20">
                    <div class="box-header">
                        <div class="box-tools">
                        <p style="font-size:18px;font-weight:bold;margin-bottom: 9px; color:#173F5F;">Home</p>
                        </div>
                    </div>
                    <div class="box-body">
                        <section class="content">
                            <div class="container-fluid">
                                <!-- Main row -->
                                <div class="row">
                                    <div class="col-lg-3 col-3">
                                        <!-- small box -->
                                        <div class="small-box" style="background-color: #58a6ff;">
                                        <div class="inner">
                                            <h3 style="color:white;">{{ 3}} </h3>
                                            <p style="font-size: 22px;color:white;">Diarized</p>
                                            <b style="font-size: 22px;color:white;"></b>
                                        </div>
                                        <div class="icon">
                                            <!-- <i class="fas fa-folder-open" style="font-size: 50px !important;color: white;"></i> -->
                                            <i class="fa-solid fa-arrow-down-to-square"></i>
                                        </div>
                                        <a href="{{route('letters')}}" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                    <!-- ./col -->
                                    
                                    <div class="col-lg-3 col-3">
                                        <!-- small box -->
                                        <div class="small-box" style="background-color: #8355fe;">
                                        <div class="inner">
                                            <h3 style="color:white;">{{ '1';}}</h3>
                                            <p style="font-size: 22px;color:white;">Inbox</p>
                                            <b style="font-size: 22px;color:white;"></b>
                                        </div>
                                        <div class="icon">
                                            <!-- <i class="fas fa-tasks" style="font-size: 50px;color: white;"></i> -->
                                            <i class="fa-solid fa-arrow-up-from-square"></i>
                                        </div>
                                        <a href="{{"hi"}}" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                    

                                    
                                    <div class="col-lg-3 col-3">
                                        <!-- small box -->
                                        <div class="small-box" style="background-color: #3CAEA3;">
                                        <div class="inner">
                                            <h3 style="color:white;">{{ 2; }}</h3>
                                            <p style="font-size: 22px;color:white;">Sent</p>
                                            <b style="font-size: 22px;color:white;"></b>
                                        </div>
                                        <div class="icon">
                                            <!-- <i class="fas fa-tasks" style="font-size: 50px;color: white;"></i> -->
                                            <i class="fa-solid fa-arrow-up-from-square"></i>
                                        </div>
                                            <a href="{{"hi"}}" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-3">
                                        <!-- small box -->
                                        <div class="small-box" style="background-color: #ff9e69;">
                                        <div class="inner">
                                            <h3 style="color:white;">{{ 2; }}</h3>
                                            <p style="font-size: 22px;color:white;">Archived</p>
                                            <b style="font-size: 22px;color:white;"></b>
                                        </div>
                                        <div class="icon">
                                            <!-- <i class="fas fa-tasks" style="font-size: 50px;color: white;"></i> -->
                                            <i class="fa-solid fa-arrow-up-from-square"></i>
                                        </div>
                                            <a href="{{"hi"}}" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
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
                <div class="box shadow-lg p-3 mb-5 bg-white rounded min-vh-60">
                    <div class="box-header">
                        <div class="box-tools">
                            <div class="row">
                                <div class="col-md-3">
                                    <p style="font-size:18px;font-weight:bold;margin-bottom: 9px; color:#173F5F;">Recent Diarized</p>
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
                                    <div class="col-md-12 bg-danger1">
                                        <table class="table table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th scope="col"><small><b>Diarized No.</b></small></th>
                                                    <th scope="col"><small><b>Subject</b></small></th>
                                                    <th scope="col"><small><b>From</b></small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="table-success">
                                                <td><small>1. CRN/CS/2024/10, 07/07/2024</small></td>
                                                <td><small>PM Awas Yojona</small></td>
                                                <td><small>Prime Minister Office</small></td>
                                                </tr>
                                                <tr class="table-warning">
                                                <td><small>2. CRN/CS/2024/09, 19/06/2024</small></td>
                                                <td><small>Jal Jeevan Misssion Scheme status</small></td>
                                                <td><small>PHE Central Govt.</small></td>
                                                </tr>
                                                <tr class="table-success">
                                                <td><small>3. CRN/CS/2024/08, 01/07/2024</small></td>
                                                <td><small>Home Ministry Query</small></td>
                                                <td><small>Home Ministry, GOI</small></td>
                                                </tr>
                                                <tr class="table-warning">
                                                <td><small>4. CRN/CS/2024/07, 17/07/2024</small></td>
                                                <td><small>Lorem ipsum dolor sit amet. Est voluptatem quos qui quas nulla qui velit quae. 
                                                    Et vero quasi sit reprehenderit sunt sed consequuntur pariatur eum dolores tempore ut
                                                     eligendi ratione.</small></td>
                                                <td><small>Railway Ministry</small></td>
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
                <div class="box shadow-lg p-3 mb-5 bg-white rounded min-vh-80">
                    <div class="box-header">
                        <div class="box-tools">
                        <p style="font-size:18px;font-weight:bold;margin-bottom: 9px; color:#173F5F;">Inbox Pending</p>
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
                                            <th scope="col"><small><b>Received</b></small></th>
                                            <th scope="col"><small><b>Status</b></small></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><small>1. CRN/HOME/2024/08</small></td>
                                                <td><small>VIP visit Security Plan</small></td>
                                                <td><small>10-07-24</small></td>
                                                <td><small>In process</small></td>
                                            </tr>
                                            <tr>
                                                <td><small>2. CRN/PNRD/2024/10</small></td>
                                                <td><small>Panchayat Plan</small></td>
                                                <td><small>18-07-24</small></td>
                                                <td><small>New</small></td>
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
    @endsection