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
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Hotel Bookings</h6>
                                <p class="text-xs text-white ps-3 mb-0">All bookings</p>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">

                            <!-- INSERT CODE TO DISPLAY SCHEDULE HERE -->
                            <div class="row p-4">
                                <div class="calendar" data-bs-toggle="calendar" id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
    @push('js')
        <script src="{{ asset('assets') }}/js/fullcalendar.min.js"></script>
        <script>
            var calendar = new FullCalendar.Calendar(document.getElementById("calendar"), {
                initialView: "dayGridMonth",
                headerToolbar: {
                    start: 'title', // will normally be on the left. if RTL, will be on the right
                    center: '',
                    end: 'today prev,next' // will normally be on the right. if RTL, will be on the left
                },
                selectable: true,
                editable: true,
                initialDate: '2020-12-01',
                events: [{
                        title: 'Call with Dave',
                        start: '2020-11-18',
                        end: '2020-11-18',
                        className: 'bg-gradient-danger'
                    },

                    {
                        title: 'Lunch meeting',
                        start: '2020-11-21',
                        end: '2020-11-22',
                        className: 'bg-gradient-warning'
                    },

                    {
                        title: 'All day conference',
                        start: '2020-11-29',
                        end: '2020-11-29',
                        className: 'bg-gradient-success'
                    },

                    {
                        title: 'Meeting with Mary',
                        start: '2020-12-01',
                        end: '2020-12-01',
                        className: 'bg-gradient-info'
                    },

                    {
                        title: 'Winter Hackaton',
                        start: '2020-12-03',
                        end: '2020-12-03',
                        className: 'bg-gradient-danger'
                    },

                    {
                        title: 'Digital event',
                        start: '2020-12-07',
                        end: '2020-12-09',
                        className: 'bg-gradient-warning'
                    },

                    {
                        title: 'Marketing event',
                        start: '2020-12-10',
                        end: '2020-12-10',
                        className: 'bg-gradient-primary'
                    },

                    {
                        title: 'Dinner with Family',
                        start: '2020-12-19',
                        end: '2020-12-19',
                        className: 'bg-gradient-danger'
                    },

                    {
                        title: 'Black Friday',
                        start: '2020-12-23',
                        end: '2020-12-23',
                        className: 'bg-gradient-info'
                    },

                    {
                        title: 'Cyber Week',
                        start: '2020-12-02',
                        end: '2020-12-02',
                        className: 'bg-gradient-warning'
                    },

                ],
                views: {
                    month: {
                        titleFormat: {
                            month: "long",
                            year: "numeric"
                        }
                    },
                    agendaWeek: {
                        titleFormat: {
                            month: "long",
                            year: "numeric",
                            day: "numeric"
                        }
                    },
                    agendaDay: {
                        titleFormat: {
                            month: "short",
                            year: "numeric",
                            day: "numeric"
                        }
                    }
                },
            });

            calendar.render();
        </script>
    @endpush
</x-layout>
