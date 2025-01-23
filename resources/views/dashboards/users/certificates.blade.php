@extends('layouts.app')
@section('title', 'OSave | Certificates')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between">
                    <div>
                        <h4 class="">Certificate List</h4>
                    </div>
                    <a href="javascript:void(0)" id="createCertificate" class="btn btn-primary add-list"><i
                            class="las la-plus mr-3"></i>Request Certificate</a>
                </div>
            </div>
            <div class="col-md-12">
                <div class="ttl-amt py-2 px-3 d-flex justify-content-end mt-2"></div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive rounded mb-3">
                    <table class="table mb-0 certificate-table">
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

    <div class="modal fade" id="certModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeading"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="certificateForm" name="certificateForm" class="form-horizontal">
                        <input type="hidden" name="certificate_id" id="certificate_id">
                        <input type="hidden" name="employee_id" id="employee_id" value="{{ Auth::user()->employee->id }}">
                        <div class="form-group row">
                            <label for="type" class="col-sm-4 col-form-label text-osave">Certificate Type*</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="type" name="type" required>
                                    <option value="" disabled selected>Select a Certificate Type</option>
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
                                <input type="text" class="form-control" id="description" name="description" placeholder="Enter description" required>
                                <span class="text-danger error-text description_error"></span>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="certSaveBtn" value="create">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            var certificateTable = $('.certificate-table').DataTable({
                processing: true,
                responsive: true,
                autoWidth: false,
                lengthMenu: [10, 20, 50, 100],
                ajax: {
                    url: "{{ route('user.getUserCertificates') }}",
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
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: null,
                        searchable: false,
                        orderable: false,
                        render: function(data, type, full, meta) {
                            var editButton = '<a href="javascript:void(0)" data-id="' + full.id +
                                '" class="badge bg-info mr-2 editCertificate"><i class="ri-eye-line mr-0"></i></a>';
                            var deleteButton = '<a href="javascript:void(0)" data-id="' + full.id +
                                '" class="badge bg-warning deleteCertificate"><i class="ri-delete-bin-line mr-0"></i></a>';
                            return '<div class="d-flex align-items-center list-action">' +
                                editButton + deleteButton +
                                '</div>';
                        }
                    }
                ]
            });

            $("#createCertificate").click(function() {
                $('#certificate_id').val('');
                $('#certificateForm').trigger('reset');
                $('#modalHeading').html('Request Certificate');
                $('#certModal').modal('show');
            });

            $('#certModal').on('hidden.bs.modal', function(e) {
                $(document).find('span.error-text').text('');
            });

            $('#certSaveBtn').click(function(e) {
                e.preventDefault();
                var $btn = $(this);

                if ($btn.hasClass('disabled')) {
                    return;
                }

                $btn.html('Saving...').addClass('disabled');

                $.ajax({
                    data: $("#certificateForm").serialize(),
                    url: "{{ route('certificates.store') }}",
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
                            $('#certificateForm').trigger('reset');
                            $('#certModal').modal('hide');
                            certificateTable.ajax.reload();
                            Swal.fire("Success!", "Certificate data saved successfully!",
                                "success");
                        }
                    },
                    error: function(data) {
                        console.log('Error', data);
                        $('#certSaveBtn').html('Save');
                        Swal.fire("Oops!", "Something went wrong!", "error");
                    },
                    complete: function() {
                        $btn.removeClass('disabled').html('Save');
                    }
                });
            });

            $('body').on('click', '.deleteCertificate', function() {
                var certificate_id = $(this).data("id");
                Swal.fire({
                    title: 'Confirm Delete',
                    text: "Are you sure you want to delete this certificate?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('certificates.store') }}" + '/' + certificate_id,
                            success: function(data) {
                                certificateTable.ajax.reload();
                                Swal.fire('Deleted!',
                                    'Certificate data has been deleted.', 'success');
                            },
                            error: function(data) {
                                Swal.fire('Error!',
                                    'This certificate has associated data, cannot be deleted.',
                                    'error');
                            }
                        });
                    }
                });
            });

            $('body').on('click', '.editCertificate', function() {
                var certificate_id = $(this).data("id");
                $.get("{{ route('user.certificates') }}" + "/" + certificate_id + "/edit", function(data) {
                    $("#modalHeading").html("Certificate Details");
                    $('#certModal').modal('show');
                    $('#certificate_id').val(data.id);
                    $('#type').val(data.type);
                    $('#description').val(data.description);
                });
            });
        });
    </script>
@endsection
