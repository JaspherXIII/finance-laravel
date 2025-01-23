@extends('layouts.app')
@section('title', 'OSave | Users')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between">
                    <div>
                        <h4 class="">User List</h4>
                    </div>
                    <a href="javascript:void(0)" id="createUser" class="btn btn-primary add-list"><i
                            class="las la-plus mr-3"></i>Add Account</a>
                </div>
            </div>
            <div class="col-md-12">
                <div class="ttl-amt py-2 px-3 d-flex justify-content-end mt-2"></div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive rounded mb-3">
                    <table class="table mb-0 user-table">
                        <thead>
                            <tr class="ligth ligth-data">
                                <th>No.</th>
                                <th>Name</th>
                                <th>Email</th>
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

    <div class="modal fade" id="userModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeading"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="userForm" name="userForm" class="form-horizontal">
                        <input type="hidden" name="user_id" id="user_id">
                        <input type="hidden" name="role" id="role" value="1">
                        <input type="hidden" id="password" name="password" value="Admin123" required>

                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label text-osave">Name*</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter name" required>
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-osave">Email*</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter email" required>
                                <span class="text-danger error-text email_error"></span>
                            </div>
                        </div>


                    </form>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="userSaveBtn" value="create">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            var userTable = $('.user-table').DataTable({
                processing: true,
                responsive: true,
                autoWidth: false,
                lengthMenu: [10, 20, 50, 100],
                ajax: {
                    url: "{{ route('users.getUsers') }}",
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
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: null,
                        searchable: false,
                        orderable: false,
                        render: function(data, type, full, meta) {
                            var editButton = '<a href="javascript:void(0)" data-id="' + full.id +
                                '" class="badge bg-info mr-2 editUser"><i class="ri-eye-line mr-0"></i></a>';
                            var deleteButton = '<a href="javascript:void(0)" data-id="' + full.id +
                                '" class="badge bg-warning deleteUser"><i class="ri-delete-bin-line mr-0"></i></a>';
                            return '<div class="d-flex align-items-center list-action">' +
                                deleteButton +
                                '</div>';
                        }
                    }
                ]
            });

            $("#createUser").click(function() {
                $('#user_id').val('');
                $('#userForm').trigger('reset');
                $('#modalHeading').html('Add User');
                $('#userModal').modal('show');
            });

            $('#userSaveBtn').click(function(e) {
                e.preventDefault();
                var $btn = $(this);

                if ($btn.hasClass('disabled')) {
                    return;
                }

                $btn.html('Saving...').addClass('disabled');

                $.ajax({
                    data: $("#userForm").serialize(),
                    url: "{{ route('accounts.store') }}",
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
                            $('#userForm').trigger('reset');
                            $('#userModal').modal('hide');
                            userTable.ajax.reload();
                            Swal.fire("Success!", "User data saved successfully!", "success");
                        }
                    },
                    error: function(data) {
                        console.log('Error', data);
                        $('#userSaveBtn').html('Save');
                        Swal.fire("Oops!", "Something went wrong!", "error");
                    },
                    complete: function() {
                        $btn.removeClass('disabled').html('Save');
                    }
                });
            });

            $('body').on('click', '.deleteUser', function() {
                var user_id = $(this).data("id");
                Swal.fire({
                    title: 'Confirm Delete',
                    text: "Are you sure you want to delete this user?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('accounts.store') }}" + '/' + user_id,
                            success: function(data) {
                                userTable.ajax.reload();
                                Swal.fire('Deleted!', 'User data has been deleted.',
                                    'success');
                            },
                            error: function(data) {
                                Swal.fire('Error!',
                                    'This user has associated data, cannot be deleted.',
                                    'error');
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
