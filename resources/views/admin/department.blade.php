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
                                    Departments
                                </div>
                                <div class="col-md-7 text-right">
                                    <button type="button" class="btn btn-sm col-3"
                                        style="background-color: #173f5f;color: white;" id="btn-modal" data-toggle="modal"
                                        data-target="#addDeptModal">Add<i class="fas fa-plus-circle"
                                            style="color: #24a0ed"></i></button>

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
                                                        <th>Department Name</th>
                                                        <th>Abbreviation</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($departments as $value)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $value->department_name }}</td>
                                                            <td>{{ $value->abbreviation }}</td>
                                                            <td>
                                                                <a href="#" class="action-link edit-dept"
                                                                    data-toggle="modal" data-target="#editDeptModal"
                                                                    data-id="{{ $value->id }}"
                                                                    data-name="{{ $value->department_name }}"
                                                                    data-abbr="{{ $value->abbreviation }}"
                                                                    style="color:#173f5f;" data-toggle="tooltip"
                                                                    data-placement="top" title="View/Update">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <!-- Toggle button for default_access -->


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
    <!-- Edit Dept Modal -->
    <div class="modal fade" id="editDeptModal" tabindex="-1" role="dialog" aria-labelledby="editDeptModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDeptModalTitle">Edit Dept</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editDeptForm" class="form-horizontal" method="POST" action="{{ route('department.edit') }}">
                        @csrf <!-- CSRF token for Laravel -->
                        <input type="hidden" id="edit_dept_id" name="dept_id">

                        <div class="row">
                            <div class="col-md-4">
                                <label>Department Name</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="edit_dept_name" name="dept_name" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label>Abbreviation</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="edit_dept_abbr" name="dept_abbr" required>
                            </div>
                        </div>


                        <div class="row mt-3">
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



    <!-- Modal addDeptModalTitle-->
    <div class="modal fade" id="addDeptModal" tabindex="-1" role="dialog" aria-labelledby="addDeptModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDeptModalTitle">Add New Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="description_view">
                    <div id="parent">
                        <div id="add">
                            <form id="addDeptForm" class="form-horizontal" action="{{ route('department.add') }}"
                                method="POST">
                                @csrf <!-- CSRF token for Laravel -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="dept_name">Department Name</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="dept_name" name="dept_name"
                                            required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="dept_abbr">Abbreviation</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="dept_abbr" name="dept_abbr"
                                            required>
                                    </div>
                                </div>

                                <div class="row mt-3">
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
        $(document).on('click', '.edit-dept', function() {
            var deptId = $(this).data('id');
            var deptName = $(this).data('name');
            var deptAbbr = $(this).data('abbr');

            $('#edit_dept_id').val(deptId);
            $('#edit_dept_name').val(deptName);
            $('#edit_dept_abbr').val(deptAbbr);

            $('#editDeptModal').modal('show');
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
            $('#addDeptModal').modal({
                backdrop: 'static',
                keyboard: false
            });
        });
    </script>
@endsection
@endsection
