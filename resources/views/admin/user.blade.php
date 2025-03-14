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
                                    <button type="button" class="btn btn-sm col-3"
                                        style="background-color: #173f5f;color: white;" id="btn-modal" data-toggle="modal"
                                        data-target="#addUserModal">Add<i class="fas fa-plus-circle"
                                            style="color: #24a0ed"></i></button>

                                </div>
                            </div>
                        </div>
                        <!-- Loading Overlay -->
                    <div id="loading-overlay" style="display:none;">
                        <div class="spinner"></div>
                        <p>Loading...</p>
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
                                                                    data-first-receiver="{{ $value->first_receiver ? 'true' : 'false' }}"
                                                                    style="color:#173f5f;" data-toggle="tooltip"
                                                                    data-placement="top" title="View/Update">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <!-- Toggle button for default_access -->
                                                                <button
                                                                    class="btn btn-sm {{ $value->default_access ? 'btn-success' : 'btn-danger' }} toggle-access"
                                                                    data-user-id="{{ $value->u_id }}"
                                                                    data-dept-id="{{ $value->dept_id }}"
                                                                    data-role-id="{{ $value->role_id }}"
                                                                    title="{{ $value->default_access ? 'Active - Click to deactivate' : 'Inactive - Click to activate' }}">
                                                                    <i
                                                                        class="fa {{ $value->default_access ? 'fa-unlock' : 'fa-lock' }}"></i>
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
                        <!-- First Receiver Checkbox -->
                        <div class="row mt-2" id="firstReceiverRow" style="display: none;">
                            <div class="col-md-2 text-right">
                                <input type="checkbox" id="edit_first_receiver" name="first_receiver" value="">
                            </div>
                            <div class="col-md-10">
                                <label for="edit_first_receiver">Assign as First Receiver for Diarized Letter</label>
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
                                        <input type="text" class="form-control" id="u_name" name="u_name"
                                            required>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <label for="email">Govt. Email</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="email" class="form-control" id="email" name="email"
                                            required>
                                    </div>
                                </div>
                                @if (session('role') == 5)
                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <label for="dept_id">Department</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-control" id="dept_id" name="dept_id" required>
                                                <option value="">Select Department</option>
                                                @foreach ($departmentsWithoutAdmin as $dept)
                                                    <option value="{{ $dept->id }}">{{ $dept->department_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <input type="hidden" name="dept_id" value="{{ session('role_dept') }}">
                                @endif
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <label for="role_id">Role</label>
                                    </div>
                                    <div class="col-md-9">
                                        <select class="form-control" id="role_id" name="role_id" required>
                                            <option value="">Select Role</option>
                                            @foreach ($rolesForAdmins as $role)
                                                <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- HOD Selection Dropdown (Initially Hidden) -->
                                <div class="row mt-2" id="hod_selection_row" style="visibility: hidden;">
                                    <div class="col-md-3">
                                        <label for="hod_id">Department User / HOD</label>
                                    </div>
                                    <div class="col-md-9">
                                        <select class="form-control" id="hod_id" name="hod_id">
                                            <option value="">Select User</option>
                                            @foreach ($departmentHODs as $hod)
                                                <option value="{{ $hod->id }}">{{ $hod->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- First Receiver Checkbox (Initially Hidden) -->
                                <div class="form-check mt-2" id="first_receiver_checkbox" style="visibility: hidden;">
                                    <input class="form-check-input" type="checkbox" id="first_receiver"
                                        name="first_receiver">
                                    <label class="form-check-label" for="first_receiver">
                                        Assign as First Receiver for Diarized Letter
                                    </label>
                                </div>

                                <div class="row mt-4">
                                    <div class="text-center col-md-12">
                                        <button type="submit" class="btn btn-primary btn-sm col-3"
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
            </div>
        </div>
    </div>


    <!-- Modal END-->

@section('scripts')
@include('layouts.scripts')
    <script>
        $(document).on('click', '.file-btn', function() {
            $('#letter-view').attr('src', $(this).data('letter_path'));
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.toggle-access').click(function(event) {
                event
                    .preventDefault(); // Prevent the default behavior (e.g., form submission or link action)

                var userId = $(this).data('user-id');
                var deptId = $(this).data('dept-id');
                var roleId = $(this).data('role-id');

                // Check if the current icon is fa-lock (inactive) or fa-unlock (active)
                var icon = $(this).find('i');
                var currentState = icon.hasClass('fa-unlock'); // true if active, false if inactive
                var newState = !currentState; // Toggle the state

                // Cache the button for further use
                var button = $(this);
                var action = newState ? 'activate' : 'deactivate'; // Define action for confirmation message

                // Display SweetAlert2 confirmation dialog
                Swal.fire({
                    title: `Are you sure you want to ${action} this user?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: `Yes, ${action} it!`,
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If confirmed, proceed with the AJAX request
                        showLoading();
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
                                    // Toggle the icon based on new state
                                    if (newState) {
                                        icon.removeClass('fa-lock').addClass(
                                            'fa-unlock'); // Show unlock icon
                                        button.removeClass('btn-danger').addClass(
                                            'btn-success'); // Change to green
                                        button.attr('title',
                                            'Active - Click to deactivate'
                                        ); // Update title
                                        hideLoading();
                                    } else {
                                        icon.removeClass('fa-unlock').addClass(
                                            'fa-lock'); // Show lock icon
                                        button.removeClass('btn-success').addClass(
                                            'btn-danger'); // Change to red
                                        button.attr('title',
                                            'Inactive - Click to activate'
                                        ); // Update title
                                        hideLoading();
                                    }
                                    // Show success message using SweetAlert2
                                    Swal.fire(
                                        'Success!',
                                        `User has been ${action}d successfully.`,
                                        'success'
                                    ).then(() => {
                                        // Reload the page after the success message
                                    });
                                } else {
                                    hideLoading();
                                    Swal.fire('Error!', 'Error updating access status.',
                                        'error');

                                }
                            },
                            error: function(xhr) {
                                hideLoading();
                                Swal.fire('Error!', 'An error occurred.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
    <script>
        document.getElementById('role_id').addEventListener('change', function() {
            var selectedRole = this.value;
            var hodSelectionRow = document.getElementById('hod_selection_row');
            var assignCheckboxRow = document.getElementById(
                'first_receiver_checkbox'); // Row for the "Assign First Receiver" checkbox

            // Show or hide the HOD selection based on the selected role
            if (selectedRole == 2) {
                hodSelectionRow.style.visibility = 'visible';
                hodSelectionRow.style.height = 'auto'; // Restore height when visible
            } else {
                hodSelectionRow.style.visibility = 'hidden';
                hodSelectionRow.style.height = '0'; // Hide but keep layout intact
            }

            // Show or hide the "Assign First Receiver" checkbox when role_id > 1
            if (selectedRole > 1) {
                assignCheckboxRow.style.visibility = 'visible';
                assignCheckboxRow.style.height = 'auto'; // Restore height when visible
            } else {
                assignCheckboxRow.style.visibility = 'hidden';
                assignCheckboxRow.style.height = '0'; // Hide but keep layout intact
            }
        });
        $(document).on('change', '#edit_first_receiver', function() {
            // Update the value based on whether the checkbox is checked or not
            $(this).val(this.checked); // Set the value to 'true' or 'false'
        });


        $(document).on('click', '.edit-user', function() {
            var userId = $(this).data('id');
            var userName = $(this).data('name');
            var userEmail = $(this).data('email');
            var deptId = $(this).data('dept-id');
            var roleId = $(this).data('role-id');
            var firstReceiver = $(this).data('first-receiver');

            $('#edit_user_id').val(userId);
            $('#edit_u_name').val(userName);
            $('#edit_email').val(userEmail);
            $('#edit_dept_id').val(deptId);
            $('#edit_role_id').val(roleId);
            $('#edit_first_receiver').val(firstReceiver);

            // Show or hide the checkbox based on role_id
            if (roleId === 2 || roleId === 3 || roleId === 6) {
                $('#firstReceiverRow').show(); // Show the checkbox row
                $('#edit_first_receiver').prop('checked', firstReceiver === true || firstReceiver ===
                    'true'); // Set the checkbox state
                $('#edit_first_receiver').val($('#edit_first_receiver').is(
                    ':checked')); // Update the value attribute
            } else {
                $('#firstReceiverRow').hide(); // Hide the checkbox row
                $('#edit_first_receiver').prop('checked', false); // Uncheck the checkbox
                $('#edit_first_receiver').val(false); // Ensure value is set to false
            }

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
