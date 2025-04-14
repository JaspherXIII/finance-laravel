@extends('layouts.app')
@section('title', 'OSave | Payrolls')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div>
                        <h4 class="">Payroll List</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="ttl-amt py-2 px-3 d-flex justify-content-end mt-2"></div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive rounded mb-3">
                    <table class="table mb-0 payroll-table">
                        <thead>
                            <tr class="ligth ligth-data">
                                <th>No.</th>
                                <th>Reference No.</th>
                                <th>Date From</th>
                                <th>Date To</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="ligth-body"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Payroll Modal -->
    <div class="modal fade" id="payrollModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeading"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="payrollForm" name="payrollForm" class="form-horizontal">
                        <input type="hidden" name="payroll_id" id="payroll_id">
                        <div class="form-group row">
                            <label for="date_from" class="col-sm-4 col-form-label text-osave">Date From*</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="date_from" name="date_from" required>
                                <span class="text-danger error-text date_from_error"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="date_to" class="col-sm-4 col-form-label text-osave">Date To*</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="date_to" name="date_to" required>
                                <span class="text-danger error-text date_to_error"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="payrollSaveBtn" value="create">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewPayroll" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="viewPayrollLabel">Payroll Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover payroll-details">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Gross Salary</th>
                                    <th>Total Deduction</th>
                                    <th>Net Salary</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            var payrollTable = $('.payroll-table').DataTable({
                processing: true,
                responsive: true,
                autoWidth: false,
                lengthMenu: [10, 20, 50, 100],
                ajax: {
                    url: "https://osave.cloud/api/getPayrolls",
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
                        data: 'reference_number',
                        name: 'reference_number'
                    },
                    {
                        data: 'date_from',
                        name: 'date_from'
                    },
                    {
                        data: 'date_to',
                        name: 'date_to'
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
                                '" class="badge bg-info mr-2 viewPayroll"><i class="ri-eye-line mr-0"></i></a>';
                            var approveButton = '';
                            var rejectButton = '';
                            if (full.status === 'Pending') {
                                approveButton = '<a href="javascript:void(0)" data-id="' + full.id +
                                    '" class="badge bg-success mr-2 approvePayroll"><i class="ri-check-line mr-0"></i></a>';
                                rejectButton = '<a href="javascript:void(0)" data-id="' + full.id +
                                    '" class="badge bg-danger rejectPayroll"><i class="ri-close-line mr-0"></i></a>';
                            }

                            return '<div class="d-flex align-items-center list-action">' +
                                editButton + approveButton + rejectButton +
                                '</div>';
                        }
                    }
                ]
            });

            $('body').on('click', '.viewPayroll', function() {
                var employee_id = $(this).data("id");

                $.get("https://osave.cloud/api/payrolls" + "/" + employee_id, function(data) {
                    $('#viewPayroll').modal('show');
                    $('#pname').text(data.name);

                    $('.payroll-details').DataTable({
                        processing: true,
                        responsive: true,
                        autoWidth: false,
                        lengthMenu: [10, 20, 50, 100],
                        destroy: true,
                        data: data.emppayrolls,
                        columns: [{
                                data: null,
                                searchable: false,
                                orderable: false,
                                render: function(data, type, full, meta) {
                                    return meta.row + 1;
                                }
                            },
                            {
                                data: 'employee_name',
                                name: 'employee_name'
                            },
                            {
                                data: 'gross_salary',
                                name: 'gross_salary',
                                render: function(data, type, row) {
                                    return '₱ ' + parseFloat(data).toLocaleString();
                                }
                            },
                            {
                                data: 'total_deductions',
                                name: 'total_deductions',
                                render: function(data, type, row) {
                                    return '₱ ' + parseFloat(data).toLocaleString();
                                }
                            },
                            {
                                data: 'net_salary',
                                name: 'net_salary',
                                render: function(data, type, row) {
                                    return '₱ ' + parseFloat(data).toLocaleString();
                                }
                            }
                        ]
                    });
                });
            });

            $('body').on('click', '.approvePayroll', function() {
                var payrollId = $(this).data("id");
                Swal.fire({
                    title: 'Confirm Approval',
                    text: "Are you sure you want to approve this payroll?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, approve it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = "https://osave.cloud/api/payrolls/approve/" +
                            payrollId;
                        $.ajax({
                            url: url,
                            type: "POST",
                            success: function(response) {
                                Swal.fire('Approved!', response.message, 'success');
                                $('.payroll-table').DataTable().ajax.reload();
                            },
                            error: function() {
                                Swal.fire('Error!', 'Failed to approve payroll.',
                                    'error');
                            }
                        });
                    }
                });
            });

            $('body').on('click', '.rejectPayroll', function() {
                var payrollId = $(this).data("id");
                Swal.fire({
                    title: 'Confirm Rejection',
                    text: "Are you sure you want to reject this payroll?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, reject it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = "https://osave.cloud/api/payrolls/reject/" +
                        payrollId;
                        $.ajax({
                            url: url,
                            type: "POST",
                            success: function(response) {
                                Swal.fire('Rejected!', response.message, 'success');
                                $('.payroll-table').DataTable().ajax.reload();
                            },
                            error: function() {
                                Swal.fire('Error!', 'Failed to reject payroll.',
                                    'error');
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
