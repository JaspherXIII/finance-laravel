@extends('layouts.app')
@section('title', 'OSave | Payslip')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between">
                    <div>
                        <h4 class="">Payslip List</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="ttl-amt py-2 px-3 d-flex justify-content-end mt-2"></div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive rounded mb-3">
                    <table class="table mb-0 emp-payroll-table">
                        <thead>
                            <tr class="ligth ligth-data">
                                <th>No.</th>
                                <th>Date</th>
                                <th>Gross Salary</th>
                                <th>Total Deduction</th>
                                <th>Net Salary</th>
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

    <div class="modal fade" id="empPayrollModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeading"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="empPayrollForm" name="empPayrollForm" class="form-horizontal">
                        <input type="hidden" name="emp_payroll_id" id="emp_payroll_id">
                        <input type="hidden" name="employee_id" id="employee_id" value="{{ Auth::user()->employee->id }}">
                        <div class="form-group row">
                            <label for="type" class="col-sm-4 col-form-label text-osave">Payroll Type*</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="type" name="type" required>
                                    <option value="" disabled selected>Select a Payroll Type</option>
                                    <option value="Completion">Completion</option>
                                    <option value="Attendance">Attendance</option>
                                    <option value="Participation">Participation</option>
                                    <option value="Employment">Employment</option>
                                </select>
                                <span class="text-danger error-text type_error"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-sm-4 col-form-label text-osave">Description*</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="description" name="description"
                                    placeholder="Enter description" required>
                                <span class="text-danger error-text description_error"></span>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="empPayrollSaveBtn" value="create">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
         function viewPayslip(emppayrollId) {
            $.ajax({
                url: '{{route('user.viewPayslip')}}',
                type: 'GET',
                data: {
                    id: emppayrollId
                },
                success: function(response) {
                    window.location.href = '{{route('user.viewPayslip')}}?id=' + emppayrollId;
                },
                error: function(xhr) {
                    console.error('Error fetching payslip details:', xhr);
                }
            });
        }
        
        $(function() {
            var empPayrollTable = $('.emp-payroll-table').DataTable({
                processing: true,
                responsive: true,
                autoWidth: false,
                lengthMenu: [10, 20, 50, 100],
                ajax: {
                    url: "{{ route('user.getUserEmpPayroll') }}",
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
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, row) {
                            const date = new Date(data);

                            const formattedDate = new Intl.DateTimeFormat(
                                'en-US', {
                                    month: 'long',
                                    day: '2-digit',
                                    year: 'numeric'
                                }).format(date);

                            return formattedDate;
                        }
                    },
                    {
                        data: 'gross_salary',
                        name: 'gross_salary'
                    },
                    {
                        data: 'total_deductions',
                        name: 'total_deductions'
                    },
                    {
                        data: 'net_salary',
                        name: 'net_salary'
                    },
                    {
                        data: null,
                        searchable: false,
                        orderable: false,
                        render: function(data, type, full, meta) {
                            var editButton = '<a href="javascript:void(0)" data-id="' + full.id +
                                '" onclick="viewPayslip(' + full.id +
                                    ')" class="badge bg-info mr-2"><i class="ri-eye-line mr-0"></i></a>';
                            return '<div class="d-flex align-items-center list-action">' +
                                editButton +
                                '</div>';
                        }
                    }
                ]
            });




        });
    </script>
@endsection
