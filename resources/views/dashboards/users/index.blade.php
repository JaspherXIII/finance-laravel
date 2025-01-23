@extends('layouts.app')
@section('title', 'OSave | My Profile')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="profile-img position-relative">
                                        <img src="{{ Auth::user()->picture }}"
                                            class="img-fluid rounded avatar-110 user_picture" alt="profile-image">
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="mb-1">{{ Auth::user()->employee->name }}</h4>
                                        <p class="mb-2">{{ Auth::user()->employee->job->title }} at
                                            {{ Auth::user()->employee->department->title }}</p>
                                        <input type="file" name="user_image" id="user_image"
                                            style="opacity: 0; height:1px;display:none;">
                                        <a href="javascript:void(0)" id="change_picture_btn"
                                            class="btn btn-primary font-size-14">Change Picture</a>
                                    </div>
                                </div>
                                <ul class="list-inline p-0 m-0">
                                    <li class="mb-2">
                                        <div class="d-flex align-items-center">
                                            <svg class="svg-icon mr-3" height="16" width="16"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <p class="mb-0">{{ Auth::user()->employee->address }}</p>
                                        </div>
                                    </li>
                                    <li class="mb-2">
                                        <div class="d-flex align-items-center">
                                            <svg class="svg-icon mr-3" height="16" width="16"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            <p class="mb-0">O! Save, Trading Corporation</p>
                                        </div>
                                    </li>
                                    <li class="mb-2">
                                        <div class="d-flex align-items-center">
                                            <svg class="svg-icon mr-3" height="16" width="16"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            <p class="mb-0">{{ Auth::user()->employee->mobile_number }}</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <svg class="svg-icon mr-3" height="16" width="16"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            <p class="mb-0 user_email">{{ Auth::user()->email }}</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <ul class="d-flex nav nav-pills mb-3 text-center profile-tab" id="profile-pills-tab"
                                    role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active show" data-toggle="pill" href="#profile1" role="tab"
                                            aria-selected="false">Account Information</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#profile2" role="tab"
                                            aria-selected="false">Change Password </a>
                                    </li>
                                </ul>
                                <div class="profile-content tab-content">
                                    <div id="profile1" class="tab-pane fade active show">
                                        <form class="form-horizontal" method="POST" action="{{ route('userUpdateInfo') }}"
                                            id="userUpdateForm">
                                            <div class="container">
                                                <div class="form-group row">
                                                    <label for="name"
                                                        class="col-sm-4 col-form-label text-osave">Username*</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="username"
                                                            name="username" value="{{ Auth::user()->name }}">
                                                        <span class="text-danger error-text username_error"></span>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="email"
                                                        class="col-sm-4 col-form-label text-osave">Email*</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="email"
                                                            name="email" value="{{ Auth::user()->email }}">
                                                        <span class="text-danger error-text email_error"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-sm-8 offset-sm-4">
                                                    <button type="submit" class="btn btn-danger">Save changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="profile2" class="tab-pane fade">
                                        <form class="form-horizontal" method="POST"
                                            action="{{ route('userChangePassword') }}" id="changePassworduserForm">
                                            @csrf
                                            <input type="hidden" name="employee_id" id="employee_id"
                                                value="{{ Auth::user()->id }}">

                                            <div class="container">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label text-osave">Old Password*</label>
                                                    <div class="col-sm-8">
                                                        <div class="input-group">
                                                            <input type="password" class="form-control" id="password"
                                                                placeholder="Enter current password" name="oldpassword">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text toggle-password text-dark"><i
                                                                        class="fas fa-eye"></i></span>
                                                            </div>
                                                        </div>
                                                        <span class="text-danger error-text oldpassword_error"></span>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label text-osave">New Password*</label>
                                                    <div class="col-sm-8">
                                                        <div class="input-group">
                                                            <input type="password" class="form-control" id="newpassword"
                                                                placeholder="Enter new password" name="newpassword">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text toggle-password text-dark"><i
                                                                        class="fas fa-eye"></i></span>
                                                            </div>
                                                        </div>
                                                        <span class="text-danger error-text newpassword_error"></span>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label text-osave">Confirm
                                                        Password*</label>
                                                    <div class="col-sm-8">
                                                        <div class="input-group">
                                                            <div class="input-group">
                                                                <input type="password" class="form-control"
                                                                    id="cnewpassword" placeholder="Re-enter new password"
                                                                    name="cnewpassword">
                                                                <div class="input-group-append">
                                                                    <span
                                                                        class="input-group-text toggle-password text-dark"><i
                                                                            class="fas fa-eye"></i></span>
                                                                </div>
                                                            </div>
                                                            <span class="text-danger error-text cnewpassword_error"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-8 offset-sm-4">
                                                        <button type="submit" class="btn btn-danger">Update
                                                            Password</button>
                                                    </div>
                                                </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    </div>



@endsection

@section('scripts')

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

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
            $('#userUpdateForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
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
                            $('.user_name').text($('#name').val());
                            $('.user_email').text($('#email').val());
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: data.msg,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });



            $('#UserInfoForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
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

                            $('.user_name').text($('#inputNameAccount').val());

                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: data.msg,
                            });
                        }
                    }
                });
            });


            $(document).on('click', '#change_picture_btn', function() {
                $('#user_image').click();
            });

            $('#user_image').ijaboCropTool({
                preview: '.user_picture',
                setRatio: 1,
                allowedExtensions: ['jpg', 'jpeg', 'png'],
                buttonsText: ['CROP', 'QUIT'],
                buttonsColor: ['#30bf7d', '#ee5155', -15],
                processUrl: '{{ route('userPictureUpdate') }}',
                onSuccess: function(message, element, status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: message,
                    });
                },
                onError: function(message, element, status) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: message,
                    });
                }
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
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: data.msg,
                            });
                        }
                    }
                });
            });


        });
    </script>


@endsection
