<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="unassignedbookings"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Hotel Room Management"></x-navbars.navs.auth>
        <!-- End Navbar -->


        <div class="container-fluid py-4">

            <!-- UNASSIGNED BOOKINGS TABLE -->
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Unassigned Bookings</h6>
                                <p class="text-xs text-white ps-3 mb-0">Bookings that need to be assigned a hotel room</p>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">

                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Dog</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Client</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Stay Start/End</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Assign Room</th>
                                            <th
                                                class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>

                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="{{ asset('assets') }}/img/dogs/arrow.jpg"
                                                            class="avatar avatar-sm me-3 border-radius-lg"
                                                            alt="user1">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">Arrow</h6>
                                                        <p class="text-xs text-secondary mb-0">Alaskan Malamute
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <p class="text-xs font-weight-bold mb-0">Jamie Tikaani</p>
                                                    <p class="text-xs text-secondary mb-0">07393549921 jamie@kentdogwalker.co.uk</p>
                                                </div>
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <p class="text-xs font-weight-bold mb-0">8 May 2024 > 15 May 2024</span>
                                                    <p class="text-xs text-secondary mb-0">7 Nights</p>
                                                </div>
                                            </td>

                                            <td class="align-middle">
                                                <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                                                    <option selected>Assign Room</option>
                                                    <option value="1">London Suite</option>
                                                    <option value="2">Parisian Suite</option>
                                                    <option value="3">New York Suite</option>
                                                  </select>
                                            </td>

                                            <td class="align-middle text-end">
                                                <div class="d-grid gap-2 d-flex justify-content-end align-items-center">
                                                    <button class="btn btn-outline-secondary btn-sm me-2" type="button">Add Photo</button>
                                                    <button class="btn btn-primary btn-sm" type="button">Assign</button>
                                                  </div>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ALREADY ASSIGNED BOOKINGS TABLE -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-secondary shadow-secondary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Assigned Bookings</h6>
                                <p class="text-xs text-white ps-3 mb-0">All bookings that have been assigned to a hotel room</p>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">

                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Dog</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Client</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Stay Start/End</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Assign Room</th>
                                            <th
                                                class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>

                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="{{ asset('assets') }}/img/dogs/arrow.jpg"
                                                            class="avatar avatar-sm me-3 border-radius-lg"
                                                            alt="user1">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">Arrow</h6>
                                                        <p class="text-xs text-secondary mb-0">Alaskan Malamute
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <p class="text-xs font-weight-bold mb-0">Jamie Tikaani</p>
                                                    <p class="text-xs text-secondary mb-0">07393549921 jamie@kentdogwalker.co.uk</p>
                                                </div>
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <p class="text-xs font-weight-bold mb-0">8 May 2024 > 15 May 2024</span>
                                                    <p class="text-xs text-secondary mb-0">7 Nights</p>
                                                </div>
                                            </td>

                                            <td class="align-middle">
                                                <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                                                    <option selected>London Suite</option>
                                                    <option value="1">London Suite</option>
                                                    <option value="2">Parisian Suite</option>
                                                    <option value="3">New York Suite</option>
                                                  </select>
                                            </td>

                                            <td class="align-middle text-end">
                                                <div class="d-grid gap-2 d-flex justify-content-end align-items-center">
                                                    <button class="btn btn-outline-secondary btn-sm me-2" type="button">Add Photo</button>
                                                    <button class="btn btn-primary btn-sm" type="button">Update</button>
                                                  </div>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>

</x-layout>
