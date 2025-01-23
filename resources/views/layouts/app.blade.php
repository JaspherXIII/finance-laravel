<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="shortcut icon" href="/logistic-assets/images/favicon-osave.ico" />
    <link rel="stylesheet" href="/logistic-assets/css/backend-plugin.min.css">
    <link rel="stylesheet" href="/logistic-assets/css/backend.css?v=1.0.0">
    <link rel="stylesheet" href="/logistic-assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/logistic-assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="/logistic-assets/vendor/remixicon/fonts/remixicon.css">
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/CropTool/ijaboCropTool.min.css">

    <!-- DataTables Buttons CSS -->
    <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">

</head>

<body class="  ">

    @include('elements.navbar')
    @include('elements.sidebar')


    <div class="content-page">
        @yield('content')
    </div>




    <script src="/logistic-assets/js/backend-bundle.min.js"></script>
    <script src="/logistic-assets/js/app.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>

    <script src="https://cdn.datatables.net/plug-ins/1.10.20/api/makeCellsEditable.js"></script>
    <script src="/CropTool/ijaboCropTool.min.js"></script>


    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield('scripts')

    <script>
        $(document).ready(function() {
            $(".toggle-password").click(function() {
                $(this).toggleClass("active");
                var input = $(this).closest(".input-group").find("input");
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                    $(this).find('i').removeClass('fas fa-eye').addClass('fas fa-eye-slash');
                } else {
                    input.attr("type", "password");
                    $(this).find('i').removeClass('fas fa-eye-slash').addClass('fas fa-eye');
                }
            });
        });

        $(function() {

            $("#changePassword").click(function() {
                $('#changePassworduserForm').trigger('reset');
                $('#changePasswordModalHeading').html('Change Password');
                $('#changePasswordModal').modal('show');
            });


            $('#changePassworduserForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: new FormData(this),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(document).find('span.error-text').text('');
                    },
                    success: function(data) {
                        if (data.status == 0) {
                            $.each(data.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else {
                            $('#changePassworduserForm')[0].reset();
                            $('#changePasswordModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: data.msg,
                            });
                        }
                    }
                });
            });

            $('#changePasswordModal').on('hidden.bs.modal', function() {
                $('#changePassworduserForm').trigger('reset');
                $(document).find('span.error-text').text(''); 
            });


        });
    </script>
</body>

</html>
