@props(['activePage'])

<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 d-flex text-wrap align-items-center" href=" {{ route('dashboard') }} ">
            <img src="{{ asset('assets') }}/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-2 font-weight-bold text-white">KDW Management Tools</span>
        </a>
    </div>

    <hr class="horizontal light mt-0 mb-1">
    <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">

            <!-- DASHBOARD SECTION -->
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Dashboards</h6>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'dashboard' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('dashboard') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>


            <!-- UPLOADER SECTION
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Uploader</h6>
            </li>

            <li class="nav-item mt-0">
                <a class="nav-link text-white {{ $activePage == 'upload' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('psp.upload.form') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">cloud_upload</i>
                    </div>
                    <span class="nav-link-text ms-1">PSP Data Uploader</span>
                </a>
            </li>
            -->


            <!-- BILLING SECTION -->
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Billing</h6>
            </li>

            <li class="nav-item mt-0">
                <a class="nav-link text-white {{ $activePage == 'billing' ? ' active bg-gradient-primary' : '' }}  "
                    href="{{ route('billing') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">price_change</i>
                    </div>
                    <span class="nav-link-text ms-1">Direct Debit Uploader</span>
                </a>
            </li>


            <!-- DAILY SHEETS SECTION -->
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Daily Sheets</h6>
            </li>

            <li class="nav-item mt-0">
                <a class="nav-link text-white {{ $activePage == 'virtual-reality' ? ' active bg-gradient-primary' : '' }}  "
                    href="{{ route('virtual-reality') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">nature_people</i>
                    </div>
                    <span class="nav-link-text ms-1">The Meadow</span>
                </a>
            </li>

            <li class="nav-item mt-0">
                <a class="nav-link text-white {{ $activePage == 'rtl' ? ' active bg-gradient-primary' : '' }}  "
                    href="{{ route('rtl') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">pets</i>
                    </div>
                    <span class="nav-link-text ms-1">Daycare</span>
                </a>
            </li>


            <!-- HOTEL MANAGEMENT SECTION -->
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Hotel Management
                </h6>
            </li>


            <li class="nav-item mt-0">
                <a class="nav-link text-white {{ $activePage == 'unassignedbookings' ? ' active bg-gradient-primary' : '' }}  "
                    href="{{ route('hotel-unassignedbookings') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">pending_actions</i>
                    </div>
                    <span class="nav-link-text ms-1">Unassigned Bookings</span>
                </a>
            </li>

            <li class="nav-item mt-0">
                <a class="nav-link text-white {{ $activePage == 'hotelschedule' ? ' active bg-gradient-primary' : '' }}  "
                    href="{{ route('hotel-booking-schedule') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">event_note</i>
                    </div>
                    <span class="nav-link-text ms-1">Booking Schedule</span>
                </a>
            </li>


            <!-- IT MANAGEMENT SECTION -->
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">IT Management</h6>
            </li>

            <li class="nav-item mt-0">
                <a class="nav-link text-white" href="">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">videocam</i>
                    </div>
                    <span class="nav-link-text ms-1">View CCTV</span>
                </a>
            </li>

            <!-- Server Management - Collapsible Trigger -->
            <li class="nav-item">
                <a class="nav-link text-white collapsed" href="#serverManagementCollapse" data-bs-toggle="collapse"
                    role="button" aria-expanded="false" aria-controls="serverManagementCollapse">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dvr</i>
                    </div>
                    <span class="nav-link-text ms-1">Server Management</span>
                </a>
            </li>

            <!-- Collapsible Content for Server Management -->
            <div class="collapse" id="serverManagementCollapse">
                <ul class="navbar-nav">
                    <li class="nav-item mt-0">
                        <a class="nav-link text-white " href="">
                            <div
                                class="text-white text-center ms-2 me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10" style="font-size: 16px;">screenshot_monitor</i>
                            </div>
                            <span class="nav-link-text ms-1">Citadel (Unraid)</span>
                        </a>
                    </li>
                    <li class="nav-item mt-0">
                        <a class="nav-link text-white " href="">
                            <div
                                class="text-white text-center ms-2 me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10" style="font-size: 16px;">screenshot_monitor</i>
                            </div>
                            <span class="nav-link-text ms-1">The Ark (Unraid)</span>
                        </a>
                    </li>
                    <li class="nav-item mt-0">
                        <a class="nav-link text-white " href="">
                            <div
                                class="text-white text-center ms-2 me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10" style="font-size: 16px;">screenshot_monitor</i>
                            </div>
                            <span class="nav-link-text ms-1">Webserver (Citadel-VM)</span>
                        </a>
                    </li>
                    <!-- Add more links as needed -->
                </ul>
            </div>



            <!-- USER PROFILE SECTION -->
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">User</h6>
            </li>

            <li class="nav-item mt-0">
                <a class="nav-link text-white {{ $activePage == 'profile' ? ' active bg-gradient-primary' : '' }}  "
                    href="{{ route('profile') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>

        </ul>
    </div>


    <div class="sidenav-footer position-absolute w-100 bottom-0 align-items-center">
        <div class="mx-3">
            <a class="btn btn-primary w-100" href="{{ route('psp.upload.form') }}" type="button">
                <i style="font-size: 1rem;" class="material-icons opacity-10 ps-0 pe-2 text-center">cloud_upload</i>
                <span class="ms-1">Upload PSP Data</span>
            </a>
        </div>

        <div class="mx-3">
            <a class="btn btn-outline-primary w-100" href="https://0508kentdogwalkergroup.petsoftware.net/"
                target="_blank" type="button" style="color: #5AB7B7; border-color: #5AB7B7;">
                <i style="font-size: 1rem;" class="fas fa-paw ps-0 pe-2 text-center"></i>
                <span class="ms-1">Pet Sitter Plus</span>
            </a>
        </div>

        <div class="mx-3">
            <a class="btn btn-outline-primary w-100" href="https://manage.gocardless.com/" target="_blank"
                type="button" style="color: #f1f252; border-color: #f1f252;">
                <i style="font-size: 1rem;" class="fas fa-credit-card ps-0 pe-2 text-center"></i>
                <span class="ms-1">GoCardless</span>
            </a>
        </div>



    </div>


</aside>
