@extends('layouts.app')
@section('title', 'OSave | Leaves')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between">
                    <div>
                        <h4 class="">Leave List</h4>
                    </div>
                    <a href="javascript:void(0)" id="createLeave" class="btn btn-primary add-list"><i
                            class="las la-plus mr-3"></i>Request Leave</a>
                </div>
            </div>
            <div class="col-md-12">
                <div class="ttl-amt py-2 px-3 d-flex justify-content-end mt-2"></div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive rounded mb-3">
                    <table class="table mb-0 leave-table">
                        <thead>
                            <tr class="ligth ligth-data">
                                <th>No.</th>
                                <th>Type</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="ligth-body">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="leaveModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeading"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="leaveForm" name="leaveForm" class="form-horizontal">
                        <input type="hidden" name="leave_id" id="leave_id">
                        <input type="hidden" name="employee_id" id="employee_id" value="{{ Auth::user()->employee->id }}">
                        <div class="form-group row">
                            <label for="type" class="col-sm-4 col-form-label text-osave">Leave Type*</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="type" name="type" required>
                                    <option value="" disabled selected>Select a Leave Type</option>
                                    <option value="Sick Leave">Sick Leave</option>
                                    <option value="Casual Leave">Casual Leave</option>
                                    <option value="Earned Leave">Earned Leave</option>
                                    <option value="Maternity Leave">Maternity Leave</option>
                                </select>
                                <span class="text-danger error-text type_error"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="reason" class="col-sm-4 col-form-label text-osave">Reason*</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="reason" name="reason" placeholder="Enter reason" required>
                                <span class="text-danger error-text reason_error"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="start_date" class="col-sm-4 col-form-label text-osave">Start Date*</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                                <span class="text-danger error-text start_date_error"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="end_date" class="col-sm-4 col-form-label text-osave">End Date*</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                                <span class="text-danger error-text end_date_error"></span>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="leaveSaveBtn" value="create">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            var leaveTable = $('.leave-table').DataTable({
                processing: true,
                responsive: true,
                autoWidth: false,
                lengthMenu: [10, 20, 50, 100],
                ajax: {
                    url: "{{ route('user.getUserLeaves') }}",
                    method: 'GET',
                    dataType: 'JSON'
                },
                columns: [{
                        data: null,
                        searchable: false,
                        orderable: false,
                        render: function(data, type, full, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: null,
                        searchable: false,
                        orderable: false,
                        render: function(data, type, full, meta) {
                            var editButton = '<a href="javascript:void(0)" data-id="' + full.id +
                                '" class="badge bg-info mr-2 editLeave"><i class="ri-eye-line mr-0"></i></a>';
                            var deleteButton = '<a href="javascript:void(0)" data-id="' + full.id +
                                '" class="badge bg-warning deleteLeave"><i class="ri-delete-bin-line mr-0"></i></a>';
                            return '<div class="d-flex align-items-center list-action">' +
                                editButton + deleteButton +
                                '</div>';
                        }
                    }
                ]
            });

            $("#createLeave").click(function() {
                $('#leave_id').val('');
                $('#leaveForm').trigger('reset');
                $('#modalHeading').html('Request Leave');
                $('#leaveModal').modal('show');
            });

            $('#leaveModal').on('hidden.bs.modal', function(e) {
                $(document).find('span.error-text').text('');
            });

            $('#leaveSaveBtn').click(function(e) {
                e.preventDefault();
                var $btn = $(this);

                if ($btn.hasClass('disabled')) {
                    return;
                }

                $btn.html('Saving...').addClass('disabled');

                $.ajax({
                    data: $("#leaveForm").serialize(),
                    url: "{{ route('leaves.store') }}",
                    type: "POST",
                    dataType: 'json',
                    beforeSend: function() {
                        $(document).find('span.error-text').text('');
                    },
                    success: function(data) {
                        if (data.status == 0) {
                            $.each(data.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else {
                            $('#leaveForm').trigger('reset');
                            $('#leaveModal').modal('hide');
                            leaveTable.ajax.reload();
                            Swal.fire("Success!", "Leave data saved successfully!",
                                "success");
                        }
                    },
                    error: function(data) {
                        console.log('Error', data);
                        $('#leaveSaveBtn').html('Save');
                        Swal.fire("Oops!", "Something went wrong!", "error");
                    },
                    complete: function() {
                        $btn.removeClass('disabled').html('Save');
                    }
                });
            });

            $('body').on('click', '.deleteLeave', function() {
                var leave_id = $(this).data("id");
                Swal.fire({
                    title: 'Confirm Delete',
                    text: "Are you sure you want to delete this leave?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('leaves.store') }}" + '/' + leave_id,
                            success: function(data) {
                                leaveTable.ajax.reload();
                                Swal.fire('Deleted!',
                                    'Leave data has been deleted.', 'success');
                            },
                            error: function(data) {
                                Swal.fire('Error!',
                                    'This leave has associated data, cannot be deleted.',
                                    'error');
                            }
                        });
                    }
                });
            });

            $('body').on('click', '.editLeave', function() {
                var leave_id = $(this).data("id");
                $.get("{{ route('user.leaves') }}" + "/" + leave_id + "/edit", function(data) {
                    $("#modalHeading").html("Leave Details");
                    $('#leaveModal').modal('show');
                    $('#leave_id').val(data.id);
                    $('#type').val(data.type);
                    $('#reason').val(data.reason);
                    $('#start_date').val(data.start_date);
                    $('#end_date').val(data.end_date);
                });
            });
        });
    </script>
@endsection
