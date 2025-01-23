@extends('layouts.app')
@section('title', 'OSave | Budgets')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between">
                    <div>
                        <h4 class="">Budget List</h4>
                    </div>
                    <a href="javascript:void(0)" id="createBudget" class="btn btn-primary add-list"><i
                            class="las la-plus mr-3"></i>Add Budget</a>
                </div>
            </div>
            <div class="col-md-12">
                <div class="ttl-amt py-2 px-3 d-flex justify-content-end mt-2"></div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive rounded mb-3">
                    <table class="table mb-0 budget-table">
                        <thead>
                            <tr class="ligth ligth-data">
                                <th>No.</th>
                                <th>Title</th>
                                <th>Amount</th>
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

    <div class="modal fade" id="budgetModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeading"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="budgetForm" name="budgetForm" class="form-horizontal">
                        <input type="hidden" name="budget_id" id="budget_id">
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label text-osave">Title*</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
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
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="budgetSaveBtn" value="create">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            var budgetTable = $('.budget-table').DataTable({
                processing: true,
                responsive: true,
                autoWidth: false,
                lengthMenu: [10, 20, 50, 100],
                ajax: {
                    url: "{{ route('budgets.getBudgets') }}",
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
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: null,
                        searchable: false,
                        orderable: false,
                        render: function(data, type, full, meta) {
                            var editButton = '<a href="javascript:void(0)" data-id="' + full.id +
                                '" class="badge bg-info mr-2 editBudget"><i class="ri-eye-line mr-0"></i></a>';
                            var deleteButton = '<a href="javascript:void(0)" data-id="' + full.id +
                                '" class="badge bg-warning deleteBudget"><i class="ri-delete-bin-line mr-0"></i></a>';
                            return '<div class="d-flex align-items-center list-action">' +
                                editButton + deleteButton +
                                '</div>';
                        }
                    }
                ]
            });

            $("#createBudget").click(function() {
                $('#budget_id').val('');
                $('#budgetForm').trigger('reset');
                $('#modalHeading').html('Add Budget');
                $('#budgetModal').modal('show');
            });

            $('#budgetSaveBtn').click(function(e) {
                e.preventDefault();
                var $btn = $(this);

                if ($btn.hasClass('disabled')) {
                    return;
                }

                $btn.html('Saving...').addClass('disabled');

                $.ajax({
                    data: $("#budgetForm").serialize(),
                    url: "{{ route('budget-planning.store') }}",
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
                            $('#budgetForm').trigger('reset');
                            $('#budgetModal').modal('hide');
                            budgetTable.ajax.reload();
                            Swal.fire("Success!", "Budget data saved successfully!", "success");
                        }
                    },
                    error: function(data) {
                        console.log('Error', data);
                        $('#budgetSaveBtn').html('Save');
                        Swal.fire("Oops!", "Something went wrong!", "error");
                    },
                    complete: function() {
                        $btn.removeClass('disabled').html('Save');
                    }
                });
            });

            $('body').on('click', '.deleteBudget', function() {
                var budget_id = $(this).data("id");
                Swal.fire({
                    title: 'Confirm Delete',
                    text: "Are you sure you want to delete this budget?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('budget-planning.store') }}" + '/' + budget_id,
                            success: function(data) {
                                budgetTable.ajax.reload();
                                Swal.fire('Deleted!', 'Budget data has been deleted.',
                                    'success');
                            },
                            error: function(data) {
                                Swal.fire('Error!',
                                    'This budget has associated data, cannot be deleted.',
                                    'error');
                            }
                        });
                    }
                });
            });

            $('body').on('click', '.editBudget', function() {
                var budget_id = $(this).data("id");
                $.get("{{ route('budget-planning.index') }}" + "/" + budget_id + "/edit", function(data) {
                    $("#modalHeading").html("Budget Details");
                    $('#budgetModal').modal('show');
                    $('#budget_id').val(data.id);
                    $('#name').val(data.name);
                    $('#amount').val(data.amount); 
                });
            });
        });
    </script>
@endsection
