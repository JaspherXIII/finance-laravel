@extends('layouts.app')
@section('title', 'OSave | Time Discrepancy')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div>
                        <h4 class="">Time Discrepancy List</h4>
                    </div>
                    <a href="javascript:void(0)" id="createDiscrepancy" class="btn btn-primary add-list"><i
                            class="las la-plus mr-3"></i>Request Time Discrepancy</a>
                </div>
            </div>
            <div class="col-md-12">
                <div class="ttl-amt py-2 px-3 d-flex justify-content-end mt-2"></div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive rounded mb-3">
                    <table class="table mb-0 discrepancy-table">
                        <thead>
                            <tr class="ligth ligth-data">
                                <th>No.</th>
                                <th>Type</th>
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

    <div class="modal fade" id="discrepancyModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeading"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="discrepancyForm" name="discrepancyForm" class="form-horizontal">
                        <input type="hidden" name="discrepancy_id" id="discrepancy_id">
                        <input type="hidden" name="employee_id" id="employee_id" value="{{ Auth::user()->employee->id }}">
                        <div class="form-group row">
                            <label for="type" class="col-sm-4 col-form-label text-osave">Discrepancy Type*</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="type" name="type" required>
                                    <option value="" disabled selected>Select a Discrepancy Type</option>
                                    <option value="Time In">Time In</option>
                                    <option value="Time Out">Time Out</option>
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

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="discrepancySaveBtn" value="create">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            var discrepancyTable = $('.discrepancy-table').DataTable({
                processing: true,
                responsive: true,
                autoWidth: false,
                lengthMenu: [10, 20, 50, 100],
                ajax: {
                    url: "{{ route('user.getUserDiscrepancies') }}",
                    method: 'GET',
                    dataType: 'JSON'
                },
                columns: [
                    {
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
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: null,
                        searchable: false,
                        orderable: false,
                        render: function(data, type, full, meta) {
                            var editButton = '<a href="javascript:void(0)" data-id="' + full.id +
                                '" class="badge bg-info mr-2 editDiscrepancy"><i class="ri-eye-line mr-0"></i></a>';
                            var deleteButton = '<a href="javascript:void(0)" data-id="' + full.id +
                                '" class="badge bg-warning deleteDiscrepancy"><i class="ri-delete-bin-line mr-0"></i></a>';
                            return '<div class="d-flex align-items-center list-action">' +
                                editButton + deleteButton +
                                '</div>';
                        }
                    }
                ]
            });

            $("#createDiscrepancy").click(function() {
                $('#discrepancy_id').val('');
                $('#discrepancyForm').trigger('reset');
                $('#modalHeading').html('Report Discrepancy');
                $('#discrepancyModal').modal('show');
            });

            $('#discrepancyModal').on('hidden.bs.modal', function(e) {
                $(document).find('span.error-text').text('');
            });

            $('#discrepancySaveBtn').click(function(e) {
                e.preventDefault();
                var $btn = $(this);

                if ($btn.hasClass('disabled')) {
                    return;
                }

                $btn.html('Saving...').addClass('disabled');

                $.ajax({
                    data: $("#discrepancyForm").serialize(),
                    url: "{{ route('time-discrepancy.store') }}",
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
                            $('#discrepancyForm').trigger('reset');
                            $('#discrepancyModal').modal('hide');
                            discrepancyTable.ajax.reload();
                            Swal.fire("Success!", "Discrepancy data saved successfully!",
                                "success");
                        }
                    },
                    error: function(data) {
                        console.log('Error', data);
                        $('#discrepancySaveBtn').html('Save');
                        Swal.fire("Oops!", "Something went wrong!", "error");
                    },
                    complete: function() {
                        $btn.removeClass('disabled').html('Save');
                    }
                });
            });

            $('body').on('click', '.deleteDiscrepancy', function() {
                var discrepancy_id = $(this).data("id");
                Swal.fire({
                    title: 'Confirm Delete',
                    text: "Are you sure you want to delete this discrepancy?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('time-discrepancy.store') }}" + '/' + discrepancy_id,
                            success: function(data) {
                                discrepancyTable.ajax.reload();
                                Swal.fire('Deleted!',
                                    'Discrepancy data has been deleted.', 'success');
                            },
                            error: function(data) {
                                Swal.fire('Error!',
                                    'This discrepancy has associated data, cannot be deleted.',
                                    'error');
                            }
                        });
                    }
                });
            });

            $('body').on('click', '.editDiscrepancy', function() {
                var discrepancy_id = $(this).data("id");
                $.get("{{ route('user.time-discrepancy') }}" + "/" + discrepancy_id + "/edit", function(data) {
                    $("#modalHeading").html("Time Discrepancy Details");
                    $('#discrepancyModal').modal('show');
                    $('#discrepancy_id').val(data.id);
                    $('#type').val(data.type);
                    $('#reason').val(data.reason);
                });
            });
        });
    </script>
@endsection
