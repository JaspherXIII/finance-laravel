@extends('layouts.app')
@section('title', 'OSave | Time Sheet')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between">
                    <div>
                        <h4 class="">Time Sheet</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="ttl-amt py-2 px-3 d-flex justify-content-end mt-2"></div>
            </div>
            <div class="col-lg-8">
                <div class="table-responsive rounded mb-3">
                    <table class="table mb-0 timesheet-table">
                        <thead>
                            <tr class="ligth ligth-data">
                                <th>No.</th>
                                <th>Date</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th>Working Hours</th>
                            </tr>
                        </thead>
                        <tbody class="ligth-body">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="text-center">
                    <form id="timesheetForm" name="timesheetForm" class="form-horizontal">
                        <input type="hidden" name="employee_id" id="employee_id" value="{{ Auth::user()->employee->id }}">
                        <h5 class="mb-3">Today's Date & Time</h5>
                        <h3 class="text-primary" id="todaysDate"></h3>
                        <h4 class="text-secondary" id="currentTime"></h4>
                        <div class="mt-4">
                            <button class="btn btn-success btn-md" id="timeInBtn">Time In</button>
                            <button class="btn btn-danger btn-md" id="timeOutBtn">Time Out</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            function updateTime() {
                const now = new Date();
                const dateOptions = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                const timeOptions = {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: true
                };

                const formattedDate = now.toLocaleDateString('en-US', dateOptions);
                const formattedTime = now.toLocaleTimeString('en-US', timeOptions);

                $('#todaysDate').text(formattedDate);
                $('#currentTime').text(formattedTime);
            }

            updateTime();
            setInterval(updateTime, 1000);
        });
    </script>


    <script>
        $(function() {
            var timesheetTable = $('.timesheet-table').DataTable({
                processing: true,
                responsive: true,
                autoWidth: false,
                lengthMenu: [10, 20, 50, 100],
                ajax: {
                    url: "{{ route('user.getUserTimesheets') }}",
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

                            const formattedDate = new Intl.DateTimeFormat('en-US', {
                                month: 'long',
                                day: '2-digit',
                                year: 'numeric'
                            }).format(date);

                            return formattedDate;
                        }
                    }, 
                    {
                        data: 'time_in',
                        name: 'time_in'
                    },
                    {
                        data: 'time_out',
                        name: 'time_out'
                    },
                    {
                        data: 'working_hours',
                        name: 'working_hours'
                    }
                ]
            });

            $('#timeInBtn').click(function(e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "{{ route('time-sheet.store') }}",
                    data: {
                        employee_id: $('#employee_id').val(),
                        time_in: new Date().toLocaleString(),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire("Success!", "You have clocked in successfully!", "success");
                        $('.timesheet-table').DataTable().ajax.reload();
                    },
                    error: function() {
                        Swal.fire("Error!", "Failed to clock in!", "error");
                    }
                });
            });

            $('#timeOutBtn').click(function(e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "{{ route('time-sheet.store') }}",
                    data: {
                        employee_id: $('#employee_id').val(),
                        time_out: new Date().toLocaleString(),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire("Success!", "You have clocked out successfully!", "success");
                        $('.timesheet-table').DataTable().ajax.reload();
                    },
                    error: function() {
                        Swal.fire("Error!", "Failed to clock out!", "error");
                    }
                });
            });

        });
    </script>
@endsection
