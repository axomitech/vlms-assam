@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-12">
            @include('layouts.alert')
            <div class="box shadow-lg p-3 mb-5 bg-white rounded min-vh-40">
                <div class="box-body">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-3">
                                    Users
                                </div>
                                <div class="col-md-7 text-right">
                                    <button type="button" class="btn btn-sm" style="background-color: #173f5f;color: white;"
                                        id="btn-modal" data-toggle="modal" data-target="#addUserModal">Add<i
                                            class="fas fa-plus-circle" style="color: #24a0ed"></i></button>

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
                                                        <th>Sl No.</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Department</th>
                                                        <th>Role</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($results as $value)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $value->u_name }}</td>
                                                            <td>{{ $value->u_email }}</td>
                                                            <td>{{ $value->department_name }}</td>
                                                            <td>{{ $value->role_name }}</td>
                                                            <td>
                                                                <a href="#" class="action-link edit-user"
                                                                    data-toggle="modal" data-target="#editUserModal"
                                                                    data-id="{{ $value->u_id }}"
                                                                    data-name="{{ $value->u_name }}"
                                                                    data-email="{{ $value->u_email }}"
                                                                    data-dept-id="{{ $value->dept_id }}"
                                                                    data-role-id="{{ $value->role_id }}"
                                                                    style="color:#173f5f;" data-toggle="tooltip"
                                                                    data-placement="top" title="View/Update">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <!-- Toggle button for default_access -->
                                                                <button
                                                                    class="btn btn-sm {{ $value->default_access ? 'btn-success' : 'btn-danger' }} toggle-access"
                                                                    data-user-id="{{ $value->u_id }}"
                                                                    data-dept-id="{{ $value->dept_id }}"
                                                                    data-role-id="{{ $value->role_id }}">
                                                                    {{ $value->default_access ? 'Active' : 'Inactive' }}
                                                                </button>

                                                            </td>

                                                        </tr>
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
    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalTitle">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" class="form-horizontal" method="POST" action="{{ route('user.edit') }}">
                        @csrf <!-- CSRF token for Laravel -->
                        <input type="hidden" id="edit_user_id" name="user_id">

                        <div class="row">
                            <div class="col-md-3">
                                <label>User Name</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="edit_u_name" name="u_name" required>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <label>Govt. Email</label>
                            </div>
                            <div class="col-md-9">
                                <input type="email" class="form-control" id="edit_email" name="email" required>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <label>Department</label>
                            </div>
                            <div class="col-md-9">
                                <select class="form-control" id="edit_dept_id" name="dept_id" required>
                                    <option value="" disabled>---Select Department---</option>
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
                                <select class="form-control" id="edit_role_id" name="role_id" required>
                                    <option value="" disabled>---Select Role---</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="text-center col-md-12">
                                <button type="submit" class="btn btn-primary btn-sm" id="updateBtn"
                                    style="background-color: #173f5f;color: white;">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal addUserModalTitle-->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalTitle">Add New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="description_view">
                    <div id="parent">
                        <div id="add">
                            <form id="addUserForm" class="form-horizontal" action="{{ route('user.add') }}"
                                method="POST">
                                @csrf <!-- CSRF token for Laravel -->
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="u_name">User Name</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="u_name" name="u_name" required>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <label for="email">Govt. Email</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <label for="dept_id">Department</label>
                                    </div>
                                    <div class="col-md-9">
                                        <select class="form-control" id="dept_id" name="dept_id" required>
                                            <option value="">Select Department</option>
                                            @foreach ($departments as $dept)
                                                <option value="{{ $dept->id }}">{{ $dept->department_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <label for="role_id">Role</label>
                                    </div>
                                    <div class="col-md-9">
                                        <select class="form-control" id="role_id" name="role_id" required>
                                            <option value="">Select Role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="text-center col-md-12">
                                        <button type="submit" class="btn btn-primary btn-sm"
                                            style="background-color: #173f5f; color: white;">
                                            Submit
                                        </button>
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
        $(document).on('click', '.file-btn', function() {
            $('#letter-view').attr('src', $(this).data('letter_path'));
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.toggle-access').click(function() {
                var userId = $(this).data('user-id');
                var deptId = $(this).data('dept-id');
                var roleId = $(this).data('role-id');
                var currentState = $(this).text().trim() === 'Active';
                var newState = !currentState;

                $.ajax({
                    url: "{{ route('user.default.access') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        user_id: userId,
                        department_id: deptId,
                        role_id: roleId,
                        default_access: newState
                    },
                    success: function(response) {
                        if (response.success) {
                        } else {
                            alert('Error updating access status.');
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred.');
                    }
                });
            });
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
    <script src="{{ asset('js/custom/common.js') }}"></script>
    <script>
        $(document).on('click', '.edit-user', function() {
            var userId = $(this).data('id');
            var userName = $(this).data('name');
            var userEmail = $(this).data('email');
            var deptId = $(this).data('dept-id'); 
            var roleId = $(this).data('role-id');

            $('#edit_user_id').val(userId);
            $('#edit_u_name').val(userName);
            $('#edit_email').val(userEmail);
            $('#edit_dept_id').val(deptId);
            $('#edit_role_id').val(roleId);

            $('#editUserModal').modal('show');
        });

        $(function() {
            $("#letter-table").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["excel", "pdf", "print"]
            }).buttons().container().appendTo('#letter-table_wrapper .col-md-6:eq(0)');
            $(".buttons-html5").addClass("btn btn-outline-info ml-1 btn-sm");
            $(".buttons-html5").removeClass('btn-secondary');
            $(".buttons-print").addClass("btn btn-outline-info ml-1 btn-sm");
            $(".buttons-print").removeClass('btn-secondary');
        });
    </script>
    <script>
        $('#btn-modal').click(function() {
            $('#addUserModal').modal({
                backdrop: 'static',
                keyboard: false
            });
        });
    </script>
@endsection
@endsection
