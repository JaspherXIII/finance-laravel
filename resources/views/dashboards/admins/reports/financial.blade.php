@extends('layouts.app')
@section('title', 'OSave | Financial Reports')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between">
                    <div>
                        <h4 class="">Financial Report List</h4>
                    </div>
                    {{-- <a href="javascript:void(0)" id="createReport" class="btn btn-primary add-list"><i
                            class="las la-plus mr-3"></i>Add Financial Report</a> --}}
                </div>
            </div>
            <div class="col-md-12">
                <div class="ttl-amt py-2 px-3 d-flex justify-content-end mt-2"></div>
            </div>
            <div class="col-lg-12">
                <!-- Table Navigation Tabs -->
                <ul class="nav nav-tabs mb-3" id="reportTabs">
                    <li class="nav-item">
                        <a class="nav-link active" id="allReportsTab" data-toggle="tab" href="#allReports">All Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="summaryTab" data-toggle="tab" href="#summaryReport">Summary</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- All Reports Table -->
                    <div class="tab-pane fade show active" id="allReports">
                        <div class="table-responsive rounded mb-3">
                            <table class="table mb-0 report-table">
                                <thead>
                                    <tr class="ligth ligth-data">
                                        <th>No.</th>
                                        <th>Purchase Order No.</th>
                                        <th>Date</th>
                                        <th>Total Products</th>
                                        <th>Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="ligth-body">
                                    <!-- Data will be populated dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Summary Table -->
                    <div class="tab-pane fade" id="summaryReport">
                        <div class="table-responsive rounded mb-3">
                            <table class="table mb-0 summary-table">
                                <tbody class="ligth-body">
                                    <tr>
                                        <th>Total Purchase Orders</th>
                                        <td id="summaryTotalOrders">Loading...</td>
                                    </tr>
                                    <tr>
                                        <th>Total Products Ordered</th>
                                        <td id="summaryTotalProducts">Loading...</td>
                                    </tr>
                                    <tr>
                                        <th>Total Order Amount</th>
                                        <td id="summaryTotalAmount">Loading...</td>
                                    </tr>
                                    <tr>
                                        <th>Highest Order Value</th>
                                        <td id="summaryHighestOrder">Loading...</td>
                                    </tr>
                                    <tr>
                                        <th>Lowest Order Value</th>
                                        <td id="summaryLowestOrder">Loading...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="reportModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeading"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="reportForm" name="reportForm" class="form-horizontal">
                        <input type="hidden" name="report_id" id="report_id">
                        <input type="hidden" name="type" id="type" value="Financial">

                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label text-osave">Title*</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter title" required>
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="amount" class="col-sm-4 col-form-label text-osave">Amount*</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="amount" name="amount"
                                    placeholder="Enter amount" required>
                                <span class="text-danger error-text amount_error"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="month" class="col-sm-4 col-form-label text-osave">Month*</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="month" name="month" required>
                                    <option value="">Select month</option>
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>
                                <span class="text-danger error-text month_error"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="year" class="col-sm-4 col-form-label text-osave">Year*</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="year" name="year"
                                    placeholder="Enter year" required>
                                <span class="text-danger error-text year_error"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-sm-4 col-form-label text-osave">Status*</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="status" name="status" required>
                                    <option value="">Select status</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Approved">Approved</option>
                                </select>
                                <span class="text-danger error-text status_error"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="reportSaveBtn" value="create">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch("https://logistics.pup-qc-retail.online/api/getTotalOrdersForFinance")
                .then(response => response.json())
                .then(data => {
                    if (data.data) {
                        document.getElementById("summaryTotalOrders").textContent = data.data.total_orders;
                        document.getElementById("summaryTotalProducts").textContent = data.data.total_products;
                        document.getElementById("summaryTotalAmount").textContent = new Intl.NumberFormat()
                            .format(data.data.total_order_amount);

                        document.getElementById("summaryHighestOrder").textContent =
                            `${data.data.highest_order_value.purchase_order_no} - ₱${new Intl.NumberFormat().format(data.data.highest_order_value.amount)}`;

                        document.getElementById("summaryLowestOrder").textContent =
                            `${data.data.lowest_order_value.purchase_order_no} - ₱${new Intl.NumberFormat().format(data.data.lowest_order_value.amount)}`;
                    }
                })
                .catch(error => {
                    console.error("Error fetching summary data:", error);
                });
        });


        $(function() {
            // var reportTable = $('.report-table').DataTable({
            //     processing: true,
            //     responsive: true,
            //     autoWidth: false,
            //     lengthMenu: [10, 20, 50, 100],
            //     ajax: {
            //         url: "{{ route('reports.getFinancialReports') }}",
            //         method: 'GET',
            //         dataType: 'JSON'
            //     },
            //     columns: [{
            //             data: null,
            //             searchable: false,
            //             orderable: false,
            //             render: function(data, type, full, meta) {
            //                 return meta.row + 1;
            //             }
            //         },
            //         {
            //             data: 'name',
            //             name: 'name'
            //         },
            //         {
            //             data: 'amount',
            //             name: 'amount'
            //         },
            //         {
            //             data: 'month',
            //             name: 'month'
            //         },
            //         {
            //             data: 'year',
            //             name: 'year'
            //         },
            //         {
            //             data: 'status',
            //             name: 'status'
            //         },
            //         {
            //             data: null,
            //             searchable: false,
            //             orderable: false,
            //             render: function(data, type, full, meta) {
            //                 var editButton = '<a href="javascript:void(0)" data-id="' + full.id +
            //                     '" class="badge bg-info mr-2 editReport"><i class="ri-eye-line mr-0"></i></a>';
            //                 var deleteButton = '<a href="javascript:void(0)" data-id="' + full.id +
            //                     '" class="badge bg-warning deleteReport"><i class="ri-delete-bin-line mr-0"></i></a>';
            //                 return '<div class="d-flex align-items-center list-action">' +
            //                     editButton + deleteButton +
            //                     '</div>';
            //             }
            //         }
            //     ]
            // });

            var reportTable = $('.report-table').DataTable({
                processing: true,
                responsive: true,
                autoWidth: false,
                lengthMenu: [10, 20, 50, 100],
                ajax: {
                    url: "https://logistics.pup-qc-retail.online/api/getOrdersForFinance",
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
                        data: 'purchase_order_no',
                        name: 'purchase_order_no'
                    },
                    {
                        data: 'order_date',
                        name: 'order_date'
                    },
                    {
                        data: 'total_products',
                        name: 'total_products'
                    },
                    {
                        data: 'total_amount',
                        name: 'total_amount',
                        render: function(data, type, row) {
                            return '₱ ' + parseFloat(data).toLocaleString(undefined, {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    }


                ]
            });

            $("#createReport").click(function() {
                $('#report_id').val('');
                $('#reportForm').trigger('reset');
                $('#modalHeading').html('Add Report');
                $('#reportModal').modal('show');
            });

            $('#reportSaveBtn').click(function(e) {
                e.preventDefault();
                var $btn = $(this);

                if ($btn.hasClass('disabled')) {
                    return;
                }

                $btn.html('Saving...').addClass('disabled');

                $.ajax({
                    data: $("#reportForm").serialize(),
                    url: "{{ route('reports.store') }}",
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
                            $('#reportForm').trigger('reset');
                            $('#reportModal').modal('hide');
                            reportTable.ajax.reload();
                            Swal.fire("Success!", "Report data saved successfully!", "success");
                        }
                    },
                    error: function(data) {
                        console.log('Error', data);
                        $('#reportSaveBtn').html('Save');
                        Swal.fire("Oops!", "Something went wrong!", "error");
                    },
                    complete: function() {
                        $btn.removeClass('disabled').html('Save');
                    }
                });
            });

            $('body').on('click', '.deleteReport', function() {
                var report_id = $(this).data("id");
                Swal.fire({
                    title: 'Confirm Delete',
                    text: "Are you sure you want to delete this report?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('reports.store') }}" + '/' + report_id,
                            success: function(data) {
                                reportTable.ajax.reload();
                                Swal.fire('Deleted!', 'Report data has been deleted.',
                                    'success');
                            },
                            error: function(data) {
                                Swal.fire('Error!',
                                    'This report has associated data, cannot be deleted.',
                                    'error');
                            }
                        });
                    }
                });
            });

            $('body').on('click', '.editReport', function() {
                var report_id = $(this).data("id");
                $.get("{{ route('reports.index') }}" + "/" + report_id + "/edit", function(data) {
                    $("#modalHeading").html("Report Details");
                    $('#reportModal').modal('show');
                    $('#report_id').val(data.id);
                    $('#name').val(data.name);
                    $('#type').val(data.type);
                    $('#amount').val(data.amount);
                    $('#month').val(data.month);
                    $('#year').val(data.year);
                    $('#status').val(data.status);
                });
            });

        });
    </script>
@endsection
