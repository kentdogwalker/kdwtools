<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="hotelschedule"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Hotel Booking Schedule"></x-navbars.navs.auth>
        <!-- End Navbar -->


        <div class="container-fluid py-4">

            <!-- HOTEL BOOKINGS TABLE - EXTRACTED FROM HOTELS TABLE -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-calendar my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-secondary shadow-secondary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Hotel Bookings</h6>
                                <p class="text-xs text-white ps-3 mb-0">All bookings schedule</p>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <!-- INSERT CODE TO DISPLAY SCHEDULE HERE -->
                            @livewire('BookingSchedule')
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
