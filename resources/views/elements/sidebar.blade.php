<div class="wrapper">

    <div class="iq-sidebar  sidebar-default ">
        <div class="iq-sidebar-logo d-flex align-items-center justify-content-between">
            @if (auth()->user()->role == 1)
                <a href="/admin/dashboard" class="header-logo">
                    <h5 class="logo-title light-logo ml-2">HR</h5>
                </a>
            @endif
            @if (auth()->user()->role == 2)
                <a href="/user/dashboard" class="header-logo">
                    <h5 class="logo-title light-logo ml-2">HR</h5>
                </a>
            @endif
            <div class="iq-menu-bt-sidebar ml-2">
                <i class="las la-bars wrapper-menu"></i>
            </div>
        </div>
        <div class="data-scrollbar" data-scroll="1">
            <nav class="iq-sidebar-menu">
                <ul id="iq-sidebar-toggle" class="iq-menu">
                    @if (auth()->user()->role == 1)
                        <li class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                            <a href="/admin/dashboard" class="svg-icon">
                                <svg class="svg-icon" id="p-dash1" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                    </path>
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                </svg>
                                <span class="ml-3">Dashboard</span>
                            </a>
                        </li>

                        <li class=" ">
                            <a href="#management" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <svg class="svg-icon" id="p-dash5" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z">
                                    </path>
                                </svg>
                                <span class="ml-3">Management</span>
                                <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="10 15 15 20 20 15"></polyline>
                                    <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                </svg>
                            </a>
                            <ul id="management" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">

                                <li class="{{ request()->is('admin/departments') ? 'active' : '' }}">
                                    <a href="/admin/departments">
                                        <i class="las la-minus"></i><span>Departments</span>
                                    </a>
                                </li>

                                <li class="{{ request()->is('admin/jobs') ? 'active' : '' }}">
                                    <a href="/admin/jobs">
                                        <i class="las la-minus"></i><span>Jobs</span>
                                    </a>
                                </li>

                                <li class="{{ request()->is('admin/employees') ? 'active' : '' }}">
                                    <a href="/admin/employees">
                                        <i class="las la-minus"></i><span>Employees</span>
                                    </a>
                                </li>

                                <li class="{{ request()->is('admin/certificates') ? 'active' : '' }}">
                                    <a href="/admin/certificates">
                                        <i class="las la-minus"></i><span>Certificates</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#salary" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <svg class="svg-icon" id="p-dash5" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2">
                                    </rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                </svg>
                                <span class="ml-4">Salary</span>
                                <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="10 15 15 20 20 15"></polyline>
                                    <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                </svg>
                            </a>
                            <ul id="salary" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                <li class="{{ request()->is('admin/deductions') ? 'active' : '' }}">
                                    <a href="/admin/deductions">
                                        <i class="las la-minus"></i><span>Deductions</span>
                                    </a>
                                </li>
                                <li class="{{ request()->is('admin/payrolls') ? 'active' : '' }}">
                                    <a href="/admin/payrolls">
                                        <i class="las la-minus"></i><span>Payrolls</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="#timesheet" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <svg class="svg-icon" id="p-dash5" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M13 14.0619V22H4C4 17.5817 7.58172 14 12 14C12.3387 14 12.6724 14.021 13 14.0619ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM17.7929 19.9142L21.3284 16.3787L22.7426 17.7929L17.7929 22.7426L14.2574 19.2071L15.6716 17.7929L17.7929 19.9142Z">
                                    </path>
                                </svg>
                                <span class="ml-4">Time Entries</span>
                                <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="10 15 15 20 20 15"></polyline>
                                    <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                </svg>
                            </a>
                            <ul id="timesheet" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                <li class="{{ request()->is('admin/time-tracking') ? 'active' : '' }}">
                                    <a href="/admin/time-tracking">
                                        <i class="las la-minus"></i><span>Time Tracking</span>
                                    </a>
                                </li>
                                <li class="{{ request()->is('admin/time-discrepancy') ? 'active' : '' }}">
                                    <a href="/admin/time-discrepancy">
                                        <i class="las la-minus"></i><span>Time Discrepancy</span>
                                    </a>
                                </li>
                                <li class="{{ request()->is('admin/leaves') ? 'active' : '' }}">
                                    <a href="/admin/leaves">
                                        <i class="las la-minus"></i><span>Leaves</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @if (auth()->user()->role == 2)
                        <li class="{{ request()->is('user/my-profile') ? 'active' : '' }}">
                            <a href="/user/my-profile" class="svg-icon">
                                <svg class="svg-icon" id="p-dash1" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                    </path>
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                </svg>
                                <span class="ml-3">My Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="#timesheet" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <svg class="svg-icon" id="p-dash5" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M13 14.0619V22H4C4 17.5817 7.58172 14 12 14C12.3387 14 12.6724 14.021 13 14.0619ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM17.7929 19.9142L21.3284 16.3787L22.7426 17.7929L17.7929 22.7426L14.2574 19.2071L15.6716 17.7929L17.7929 19.9142Z">
                                    </path>
                                </svg>
                                <span class="ml-4">Time Entries</span>
                                <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="10 15 15 20 20 15"></polyline>
                                    <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                </svg>
                            </a>
                            <ul id="timesheet" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                <li class="{{ request()->is('user/time-sheet') ? 'active' : '' }}">
                                    <a href="/user/time-sheet">
                                        <i class="las la-minus"></i><span>Time Sheet</span>
                                    </a>
                                </li>
                                <li class="{{ request()->is('user/time-discrepancy') ? 'active' : '' }}">
                                    <a href="/user/time-discrepancy">
                                        <i class="las la-minus"></i><span>Time Discrepancy</span>
                                    </a>
                                </li>
                                <li class="{{ request()->is('user/leaves') ? 'active' : '' }}">
                                    <a href="/user/leaves">
                                        <i class="las la-minus"></i><span>Leaves</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="{{ request()->is('user/payslip') ? 'active' : '' }}">
                            <a href="/user/payslip" class="svg-icon">
                                <svg class="svg-icon" id="p-dash5" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M19 22H5C3.34315 22 2 20.6569 2 19V3C2 2.44772 2.44772 2 3 2H17C17.5523 2 18 2.44772 18 3V15H22V19C22 20.6569 20.6569 22 19 22ZM18 17V19C18 19.5523 18.4477 20 19 20C19.5523 20 20 19.5523 20 19V17H18ZM16 20V4H4V19C4 19.5523 4.44772 20 5 20H16ZM6 7H14V9H6V7ZM6 11H14V13H6V11ZM6 15H11V17H6V15Z">
                                    </path>
                                </svg>
                                <span class="ml-3">Payslip</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('user/certificates') ? 'active' : '' }}">
                            <a href="/user/certificates" class="svg-icon">
                                <svg class="svg-icon" id="certificate-icon" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <circle cx="12" cy="8" r="7"></circle>
                                    <path d="M12 1v14"></path>
                                    <path d="M4.93 19.07l1.41-1.41"></path>
                                    <path d="M19.07 19.07l-1.41-1.41"></path>
                                </svg>
                                <span class="ml-3">Certificates</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
            <div class="p-3"></div>
        </div>
    </div>
</div>
