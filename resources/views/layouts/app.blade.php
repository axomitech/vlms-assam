<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>eDAK</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('dist/img/ashoka.jpg') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('banoshree/node_modules/boxicons/css/boxicons.min.css') }}">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300&display=swap" rel="stylesheet">
    <!-- Include Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Include Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <style>
        .sidebar a {
            color: #fff !important;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"
                        style="display: flex; align-items: center;">
                        <div
                            style="width: 36px; height: 36px; background-color: #ECF0F3; border-radius: 50%; display: flex; justify-content: center; align-items: center; margin-right: 10px;">
                            <i class="fas fa-arrow-left" style="color: #333;"></i>
                        </div>
                    </a>
                </li>
                <!-- Spacer Item -->
                <li class="nav-item" style="width: 250px;"> <!-- Adjust width as needed -->
                    <a class="nav-link" href="#" style="pointer-events: none;"></a> <!-- Non-clickable -->
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto d-flex align-items-center" style="flex-grow: 1;">
                <!-- Navbar Search -->
                <a href="{{ route('search') }}" style="text-decoration: none;">

                <li class="nav-item" style="flex-grow: 1; position: relative;">
                    <input type="text" class="form-control" placeholder="Search for a DAK.."
                        style="width: 100%; background-color: #ECF0F3; padding: 8px 12px; border-radius: 0.5rem; padding-right: 40px; border: 1px solid white;">
                    <a class="nav-link" data-widget="navbar-search1" href="{{ route('search') }}" role="button"
                        style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                        <i class="fas fa-search"></i>
                    </a>
                </li>
            </a>

                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <div class="user-panel pb-3 mb-5">
                            <div class="image">
                                <img src="{{ asset('dist/img/ashoka.jpg') }}" class="img-circle elevation-2"
                                    alt="User Image">
                                &nbsp;{{ Auth::user()->name }}
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">{{ session('department') }}</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#myModal"><i class="fas fa-user-shield mr-2"></i>Change Password</a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-door-open mr-2"></i> Logout
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt mt-2"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #0F276D;">
            <!-- Brand Logo -->
            {{-- <a href="{{ route('dashboard') }}" class="brand-link">
                <span class="brand-text font-weight-light">VIP Letter</span>
            </a> --}}

            <a href="{{ route('dashboard') }}" class="brand-link navbar-white navbar-light p-0">
                <img src="{{ asset('banoshree/images/Assam-National-Emblem.784d95da6ad451954fb8.png') }}"
                    alt="Dak Received" style="width: 36px; height: 52px; margin-left:15%;">
                <span style="font-weight: bold; font-size: 34px" class="text-danger">eDAK</span>

            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class=" mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        {{-- <img src="{{asset('dist/img/ashoka.jpg')}}" class="img-circle elevation-2" alt="User Image"> --}}
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">

                            {{-- {{Auth::user()->name}} --}}


                        </a>
                    </div>
                </div>



                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        @if (session('role') > 1)
                            <li class="nav-item mb-2">
                                <a href="{{ route('dashboard') }}" class="nav-link d-flex align-items-center">
                                    <i class='bx bxs-dashboard' style="font-size: 24px;"></i>
                                    <p style="margin: 0; padding-left: 8px;">
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                
                            <li class="nav-item mb-2">
                                <a href="{{ route('home1') }}" class="nav-link d-flex align-items-center">
                                    <i class='bx bxs-inbox' style="font-size: 24px;"></i>
                                    <p style="margin: 0; padding-left: 8px;">
                                        Inbox
                                    </p>
                                </a>
                            </li>
                            @if (session('role_dept') == 1)                                
                            <li class="nav-item mb-2">
                                <a href="{{ route('letters', [encrypt(0), 'tab' => 'sent']) }}"
                                    class="nav-link d-flex align-items-center">
                                    <i class='bx bxs-send' style="font-size: 24px;"></i>
                                    <p style="margin: 0; padding-left: 8px;">
                                        Sent Items
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item mb-2">
                                <a href="{{ route('issue_box') }}" class="nav-link d-flex align-items-center">
                                    <i class='bx bxs-edit' style="font-size: 24px;"></i>
                                    <p style="margin: 0; padding-left: 8px;">
                                        Issued Items
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('action_box') }}" class="nav-link d-flex align-items-center">
                                    <i class='bx bxs-message-alt-check' style="font-size: 24px;"></i>
                                    <p style="margin: 0; padding-left: 8px;">
                                        Action Taken
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('letters', [encrypt(0), 'tab' => 'archive']) }}"
                                    class="nav-link d-flex align-items-center">
                                    <i class='bx bxs-archive-in' style="font-size: 24px;"></i>
                                    <p style="margin: 0; padding-left: 8px;">
                                        Archived
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('reports') }}" class="nav-link d-flex align-items-center">
                                    <i class='bx bxs-report' style="font-size: 24px;"></i>
                                    <p style="margin: 0; padding-left: 8px;">
                                        Reports
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('letters', [encrypt(1)]) }}"
                                    class="nav-link d-flex align-items-center">
                                    <i class='bx bx-history' style="font-size: 24px;"></i>
                                    <p style="margin: 0; padding-left: 8px;">
                                        Legacy Letters
                                    </p>
                                </a>
                            </li>
                            @endif
                            @if (session('role_dept') > 1 )                                
                            <li class="nav-item mb-2">
                                <a href="{{ route('letters', [encrypt(0), 'tab' => 'action']) }}"
                                    class="nav-link d-flex align-items-center">
                                    <i class='bx bxs-message-alt-check' style="font-size: 24px;"></i>
                                    <p style="margin: 0; padding-left: 8px;">
                                        Action Taken
                                    </p>
                                </a>
                            </li>                            
                            <li class="nav-item mb-2">
                                <a href="{{ route('letters', [encrypt(0), 'tab' => 'process']) }}"
                                    class="nav-link d-flex align-items-center">
                                    <i class='bx bxs-bar-chart-square' style="font-size: 24px;"></i>
                                    <p style="margin: 0; padding-left: 8px;">
                                        In Process
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('letters', [encrypt(0), 'tab' => 'completed']) }}"
                                    class="nav-link d-flex align-items-center">
                                    <i class='bx bxs-badge-check' style="font-size: 24px;"></i>
                                    <p style="margin: 0; padding-left: 8px;">
                                        Completed
                                    </p>
                                </a>
                            </li>
                            @endif
                        @endif
                        @if (session('role') == 1)
                            <li class="nav-item mb-2">
                                <a href="{{ route('home1') }}" class="nav-link d-flex align-items-center">
                                    <i class='bx bxs-inbox' style="font-size: 24px;"></i>
                                    <p style="margin: 0; padding-left: 8px;">
                                        Diarized
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('letters', [encrypt(1)]) }}" class="nav-link d-flex align-items-center">
                                    <i class='bx bx-history' style="font-size: 24px;"></i>
                                    <p style="margin: 0; padding-left: 8px;">
                                        Legacy Letters
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item menu-is-opening menu-open">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-user-cog"></i>
                                    <p>
                                        Diarize
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('diarize', [encrypt(1), encrypt(0)]) }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Receipt</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('diarize', [encrypt(0), encrypt(0)]) }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Issue</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item  menu-is-opening menu-open">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-user-cog"></i>
                                    <p>
                                        Legacy Diarize
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('diarize', [encrypt(1), encrypt(1)]) }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Receipt</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('diarize', [encrypt(0), encrypt(1)]) }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Issue</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        {{-- <li class="nav-item">
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        @if (session('role') > 1)
                            <li class="nav-item">
                                <a href="{{ route('dashboard') }}" class="nav-link">
                                    <i class="nav-icon bx bxs-dashboard"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('home1') }}" class="nav-link">
                                <i class="nav-icon fas fa-envelope"></i>
                                <p>
                                    Letters
                                </p>
                            </a>
                        </li>
                        @if (session('role') == 1)
                            <li class="nav-item menu-is-opening menu-open">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-user-cog"></i>
                                    <p>
                                        Diarize
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('diarize', [encrypt(1), encrypt(0)]) }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Receipt</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('diarize', [encrypt(0), encrypt(0)]) }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Issue</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item  menu-is-opening menu-open">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-user-cog"></i>
                                    <p>
                                        Legacy Diarize
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('diarize', [encrypt(1), encrypt(1)]) }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Receipt</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('diarize', [encrypt(0), encrypt(1)]) }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Issue</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        {{-- <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-envelope"></i>
              <p>
              Letters
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('letters') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Diarized</p>
                </a>
              </li>
              @if (session('role') > 1)  
                <li class="nav-item">
                  <a href="{{ route('inbox_letters') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Inbox</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('outbox') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Sent</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Archived</p>
                  </a>
                </li>
                @endif
            </ul>
          </li> --}}
                        @if (session('role') > 3)

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-user-cog"></i>
                                    <p>
                                        Settings
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('user') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>User</p>
                                        </a>
                                    </li>
                                    @if (session('role') > 4)
                                        <li class="nav-item">
                                            <a href="{{ route('department.index') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Department</p>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="border-top: 1px solid #4f5962;">
                    <div class="info">
                        <a href="#" class="d-block mt-3">
                            {{ Auth::user()->name }} <br>
                            {{ Auth::user()->email }}
                        </a>
                    </div>
                </div>
                <nav>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item p-3">
                            <a href="#" class="nav-link"
                                style="background-color: #B58C18; width:90%; border-radius:0.75rem" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>

            </div>

            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1></h1>
                        </div>
                        <div class="col-sm-6">
                            {{-- <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Layout</a></li>
              <li class="breadcrumb-item active">Fixed Layout</li>
            </ol> --}}
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="container-fluid">
                    @yield('content')
                </div>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                Designed & Developed by <b>National Informatics Center, Assam.</b>
            </div>
            <strong>Copyright &copy; Government of Assam</strong> &nbsp; All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          
          <h4 class="modal-title">Password Change Form</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-7">
                    <form id="change-password-form">
                        <div class="form-group row">
                            <div class="col-md-8">
                                <label>Old Password</label>
                            <input type="password" name="old_password" class="form-control" placeholder="Your old password">
                            <label class="text text-danger old_password"></label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-8">
                                <label>New Password</label>
                                <input type="password" name="new_password" class="form-control" placeholder="Your new password">
                                <label class="text text-danger new_password"></label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary btn-sm save-btn" data-url="{{ route('change_password') }}"
                                data-form="#change-password-form"
                                data-message="Do you want to change your password?">UPDATE</button>
                            </div>
                        </div>
                  </form>
                </div>
                <div class="col-md-5">
                    <h5 class="text text-center text-warning">Password Rules</h5>
                    <hr>
                    <ol>
                        <li class="text-danger">Password must be minimum 8 characters long.</li>
                        <li class="text-danger">Password must contain atleast 1 upper case letter</li>
                        <li class="text-danger">Password must contain atleast 1 lower case letter</li>
                        <li class="text-danger">Password must contain atleast 1 number</li>
                        <li class="text-danger">Password must contain atleast 1 special characters such as @,#,$ etc.</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dist/js/demo.js') }}"></script>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"></script>
    @yield('scripts')
</body>

</html>
