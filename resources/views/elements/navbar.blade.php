  <!-- Nav Bar -->
  <div class="iq-top-navbar">
      <div class="iq-navbar-custom">
          <nav class="navbar navbar-expand-lg navbar-light p-0">
              <div class="iq-navbar-logo d-flex align-items-center justify-content-between">
                  <i class="ri-menu-line wrapper-menu"></i>
                  <a href="/logistic-backend/index.html" class="header-logo">
                      <img src="/logistic-assets/images/logo2.png" class="img-fluid " alt="logo">
                      <h5 class="logo-title2 text-osave ml-1 font-weight-900">save</h5>

                  </a>
              </div>
              <div class="iq-search-bar device-search">
              </div>
              <div class="d-flex align-items-center">
                  <button class="navbar-toggler" type="button" data-toggle="collapse"
                      data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                      aria-label="Toggle navigation">
                      <i class="ri-menu-3-line"></i>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                      <ul class="navbar-nav ml-auto navbar-list align-items-center">
                          <li class="nav-item nav-icon dropdown">
                              <a href="#" class="search-toggle dropdown-toggle" id="dropdownMenuButton2"
                                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <span class="bg-primary"></span>
                              </a>

                          </li>
                          <li class="nav-item nav-icon dropdown caption-content">
                              <a href="#" class="search-toggle dropdown-toggle" id="dropdownMenuButton4"
                                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <img src="/logistic-assets/images/user/1.png" class="img-fluid rounded user_picture"
                                      alt="user">
                              </a>
                              <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <div class="card shadow-none m-0">
                                      <div class="card-body p-0 text-center">
                                          <div class="media-body profile-detail text-center">
                                              <img src="/logistic-assets/images/page-img/profile-bg.jpg"
                                                  alt="profile-bg" class="rounded-top img-fluid mb-4">
                                              <img src="/logistic-assets/images/user/1.png" alt="profile-img"
                                                  class="rounded profile-img img-fluid avatar-70 user_picture">
                                          </div>
                                          <div class="p-3">
                                              <h5 class="mb-1 user_email">{{ Auth::user()->email }}</h5>
                                              <div class="d-flex align-items-center justify-content-center mt-3">
                                                  {{-- @if (auth()->user()->role == 1)
                                                      <a href="javascript:void(0)" id="changePassword"
                                                          class="btn border mr-2">Change Password</a>
                                                  @endif --}}
                                                  <a class="nav-link" class="btn border" href="{{ route('logout') }}"
                                                      onclick="event.preventDefault();
                                                        Swal.fire({
                                                                title: 'Logout',
                                                                text: 'Are you sure you want to logout?',
                                                                icon: 'warning',
                                                                showCancelButton: true,
                                                                confirmButtonColor: '#3085d6',
                                                                cancelButtonColor: '#d33',
                                                                confirmButtonText: 'Yes, logout'
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {
                                                                
                                                                    document.getElementById('logout-form').submit();
                                                                }
                                                            });">
                                                      Sign Out
                                                  </a>

                                                  <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                      class="d-none">
                                                      @csrf
                                                  </form>

                                                  </a>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </li>
                      </ul>
                  </div>
              </div>
          </nav>
      </div>
  </div>

  <div class="modal fade" id="changePasswordModal" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="changePasswordModalHeading"></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" method="POST" action="{{ route('adminChangePassword') }}"
                      id="changePassworduserForm">
                      @csrf
                      <input type="hidden" name="employee_id" id="employee_id" value="{{ Auth::user()->id }}">

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
                                          <input type="password" class="form-control" id="cnewpassword"
                                              placeholder="Re-enter new password" name="cnewpassword">
                                          <div class="input-group-append">
                                              <span class="input-group-text toggle-password text-dark"><i
                                                      class="fas fa-eye"></i></span>
                                          </div>
                                      </div>
                                      <span class="text-danger error-text cnewpassword_error"></span>
                                  </div>
                              </div>
                          </div>
               
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Update Password</button>
              </div>
            </form>
          </div>
      </div>
  </div>
</div>
