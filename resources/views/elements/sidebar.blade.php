<div class="wrapper">

    <div class="iq-sidebar  sidebar-default ">
        <div class="iq-sidebar-logo d-flex align-items-center justify-content-between">
            @if (auth()->user()->role == 1)
                <a href="/admin/dashboard" class="header-logo">
                    <h5 class="logo-title light-logo ml-2">Finance</h5>
                </a>
            @endif
            @if (auth()->user()->role == 2)
                <a href="/user/dashboard" class="header-logo">
                    <h5 class="logo-title light-logo ml-2">Finance</h5>
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

                        <li class="{{ request()->is('admin/payrolls') ? 'active' : '' }}">
                            <a href="/admin/payrolls" class="svg-icon">
                                <svg class="svg-icon" id="p-dash5" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M19 22H5C3.34315 22 2 20.6569 2 19V3C2 2.44772 2.44772 2 3 2H17C17.5523 2 18 2.44772 18 3V15H22V19C22 20.6569 20.6569 22 19 22ZM18 17V19C18 19.5523 18.4477 20 19 20C19.5523 20 20 19.5523 20 19V17H18ZM16 20V4H4V19C4 19.5523 4.44772 20 5 20H16ZM6 7H14V9H6V7ZM6 11H14V13H6V11ZM6 15H11V17H6V15Z">
                                    </path>
                                </svg>
                                <span class="ml-3">Payrolls</span>
                            </a>
                        </li>

                        <li class=" ">
                            <a href="#reports" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <svg lass="svg-icon iq-arrow-right arrow-active" width="20"
                                    height="20"xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M5 3V19H21V21H3V3H5ZM19.9393 5.93934L22.0607 8.06066L16 14.1213L13 11.121L9.06066 15.0607L6.93934 12.9393L13 6.87868L16 9.879L19.9393 5.93934Z">
                                    </path>
                                </svg>
                                <span class="ml-3">BI & Report</span>
                                <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="10 15 15 20 20 15"></polyline>
                                    <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                </svg>
                            </a>
                            <ul id="reports" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">

                                <li class="{{ request()->is('admin/financial-reports') ? 'active' : '' }}">
                                    <a href="/admin/financial-reports">
                                        <i class="las la-minus"></i><span>Financial Reports</span>
                                    </a>
                                </li>

                                <li class="{{ request()->is('admin/revenue-reports') ? 'active' : '' }}">
                                    <a href="/admin/revenue-reports">
                                        <i class="las la-minus"></i><span>Revenue Reports</span>
                                    </a>
                                </li>

                                <li class="{{ request()->is('admin/budget-planning') ? 'active' : '' }}">
                                    <a href="/admin/budget-planning">
                                        <i class="las la-minus"></i><span>Budget Planning</span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        {{-- <li class="{{ request()->is('admin/accounts') ? 'active' : '' }}">
                            <a href="/admin/accounts" class="svg-icon">
                                <svg class="svg-icon" id="p-dash5" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M19 22H5C3.34315 22 2 20.6569 2 19V3C2 2.44772 2.44772 2 3 2H17C17.5523 2 18 2.44772 18 3V15H22V19C22 20.6569 20.6569 22 19 22ZM18 17V19C18 19.5523 18.4477 20 19 20C19.5523 20 20 19.5523 20 19V17H18ZM16 20V4H4V19C4 19.5523 4.44772 20 5 20H16ZM6 7H14V9H6V7ZM6 11H14V13H6V11ZM6 15H11V17H6V15Z">
                                    </path>
                                </svg>
                                <span class="ml-3">Accounts</span>
                            </a>
                        </li> --}}
    
                    @endif

                   
                </ul>
            </nav>
            <div class="p-3"></div>
        </div>
    </div>
</div>
