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
                                <p class="text-xs text-white ps-3 mb-0">Bookings that need to be assigned a hotel room
                                </p>
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
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Select Dog</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Dog Name</th>
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
                                        @forelse ($services as $service)
                                            <form id="assignForm{{ $service->id }}"
                                                action="{{ route('hotel-unassignedbookings.assign', $service->id) }}"
                                                method="post" enctype="multipart/form-data">
                                                @csrf
                                                @method('PATCH')
                                                <tr>
                                                    <td>
                                                        <div class="align-middle px-3">
                                                            <h6 class="mb-0 text-sm text-capitalize">
                                                                {{ strtolower($service->DiaryRef) }}</h6>
                                                            <input type="hidden" name="DiaryRef"
                                                                value="{{ $service->DiaryRef }}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <p class="text-xs font-weight-bold mb-0 text-capitalize">
                                                                {{ $service->clients->FirstName . ' ' . $service->clients->LastName }}
                                                            </p>
                                                            <p class="text-xs text-secondary mb-0">
                                                                {{ $service->clients->MobilePhone }}</p>
                                                            <input type="hidden" name="ClientID"
                                                                value="{{ $service->ClientID }}">
                                                        </div>
                                                    </td>
                                                    @php
                                                        $clientID = $service->clients->ClientID;
                                                        $petsToClient = App\Models\Pet::where(
                                                            'ClientID',
                                                            $clientID,
                                                        )->get();
                                                    @endphp
                                                    <td class="align-middle">
                                                        <select
                                                            class="form-select form-select-sm @error('PetID') is-invalid @enderror"
                                                            aria-label=".form-select-sm example" name="PetID"
                                                            id="PetID{{ $service->id }}">
                                                            <option value="" selected>Select Dog</option>
                                                            @foreach ($petsToClient as $pet)
                                                                <option value="{{ $pet->PetID }}">
                                                                    {{ $pet->Name . ' (' . $pet->Breed . ')' }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('PetID')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </td>
                                                    <td class="align-middle text-sm">
                                                        <input type="text"
                                                            class="form-control form-control-sm border text-capitalize @error('DogName') is-invalid @enderror"
                                                            id="DogName{{ $service->id }}" name="DogName"
                                                            placeholder="Select a dog first">
                                                        @error('DogName')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <p class="text-xs font-weight-bold mb-0">
                                                                {{ date('d M Y', strtotime($service->StayStart)) }} >
                                                                {{ date('d M Y', strtotime($service->StayEnd)) }}</span>
                                                            <p class="text-xs text-secondary mb-0">
                                                                {{ $service->Duration }}
                                                                Nights</p>
                                                        </div>
                                                    </td>
                                                    @php
                                                        $startDate = $service->StayStart;
                                                        $endDate = $service->StayEnd;
                                                        $rooms = App\Models\Room::whereDoesntHave(
                                                            'hotelbookings',
                                                            function ($query) use ($startDate, $endDate) {
                                                                $query->where(function ($query) use (
                                                                    $startDate,
                                                                    $endDate,
                                                                ) {
                                                                    $query
                                                                        ->whereDate('StayStart', '>=', $startDate)
                                                                        ->whereDate('StayStart', '<=', $endDate)
                                                                        ->orWhere(function ($query) use (
                                                                            $startDate,
                                                                            $endDate,
                                                                        ) {
                                                                            $query
                                                                                ->whereDate('StayEnd', '>=', $startDate)
                                                                                ->whereDate('StayEnd', '<=', $endDate);
                                                                        });
                                                                });
                                                            },
                                                        )->get();
                                                    @endphp
                                                    <td class="align-middle">
                                                        <select
                                                            class="form-select form-select-sm @error('RoomID') is-invalid @enderror"
                                                            aria-label=".form-select-sm example" name="RoomID">
                                                            <option value="" selected>Assign Room</option>
                                                            @foreach ($rooms as $room)
                                                                <option value="{{ $room->RoomID }}">
                                                                    {{ $room->RoomName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('RoomID')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </td>
                                                    <td class="align-middle text-end">
                                                        <div
                                                            class="d-grid gap-2 d-flex justify-content-end align-items-center">
                                                            <button
                                                                class="btn btn-outline-secondary btn-sm me-2 add-photo-btn"
                                                                type="button"
                                                                data-service-id="{{ $service->id }}">Add
                                                                Photo</button>
                                                            <button class="btn btn-primary btn-sm assign-button"
                                                                type="button"
                                                                data-form-id="assignForm{{ $service->id }}">Assign</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </form>
                                        @empty
                                            <tr>
                                                <td colspan="6" style="text-align: center"
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Data is empty.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="photoModalLabel">Add Photo</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="service_id" id="service_id">
                                            <div class="mb-3">
                                                <label for="photo" class="form-label"></label>
                                                <input type="file" class="form-control-sm form-control-file"
                                                    id="photo" name="photo" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary"
                                                id="uploadPhotoBtn">Upload</button>
                                        </div>
                                    </div>
                                </div>
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
                                <p class="text-xs text-white ps-3 mb-0">All bookings that have been assigned to a hotel
                                    room</p>
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
                                        @forelse ($bookings as $booking)
                                            <form id="updateAssignForm{{ $booking->HotelBookingID }}"
                                                action="{{ route('hotel-assignedbookings.update', $booking->HotelBookingID) }}"
                                                method="post">
                                                @csrf
                                                @method('PATCH')
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            @php
                                                                if ($booking->DogPhoto === null) {
                                                                    $breed_image_path =
                                                                        'assets/img/dogs/breeds/' .
                                                                        $booking->Pets->Breed;
                                                                    $src_image = asset(
                                                                        file_exists(public_path($breed_image_path))
                                                                            ? $breed_image_path
                                                                            : 'assets/img/dogs/breeds/default.jpg',
                                                                    );
                                                                } else {
                                                                    $src_image = asset(
                                                                        'storage/dog-photos/' . $booking->DogPhoto,
                                                                    );
                                                                }
                                                            @endphp
                                                            <div>
                                                                <img src="{{ $src_image }}"
                                                                    class="avatar avatar-sm me-3 border-radius-lg"
                                                                    alt="{{ $booking->DogName }}">
                                                            </div>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $booking->DogName }}</h6>
                                                                <p class="text-xs text-secondary mb-0">
                                                                    {{ $booking->pets->Breed }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <p class="text-xs font-weight-bold mb-0">
                                                                {{ $booking->clients->FirstName . ' ' . $booking->clients->LastName }}
                                                            </p>
                                                            <p class="text-xs text-secondary mb-0">
                                                                {{ $booking->clients->MobilePhone }}</p>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <p class="text-xs font-weight-bold mb-0">
                                                                {{ date('d M Y', strtotime($booking->StayStart)) }} >
                                                                {{ date('d M Y', strtotime($booking->StayEnd)) }}</span>
                                                            <p class="text-xs text-secondary mb-0">
                                                                {{ $booking->Duration }} Nights</p>
                                                        </div>
                                                    </td>
                                                    @php
                                                        $startDateBooking = Carbon\Carbon::parse($booking->StayStart);
                                                        $endDateBooking = Carbon\Carbon::parse($booking->StayEnd);
                                                        $bookingRooms = App\Models\Room::whereDoesntHave(
                                                            'hotelbookings',
                                                            function ($query) use ($startDateBooking, $endDateBooking) {
                                                                $query->where(function ($query) use (
                                                                    $startDateBooking,
                                                                    $endDateBooking,
                                                                ) {
                                                                    $query
                                                                        ->whereBetween('StayStart', [
                                                                            $startDateBooking,
                                                                            $endDateBooking,
                                                                        ])
                                                                        ->orWhereBetween('StayEnd', [
                                                                            $startDateBooking,
                                                                            $endDateBooking,
                                                                        ]);
                                                                });
                                                            },
                                                        )->get();
                                                    @endphp
                                                    <td class="align-middle">
                                                        <select
                                                            class="form-select form-select-sm @error('RoomBookingID') is-invalid @enderror"
                                                            aria-label=".form-select-sm example" name="RoomBookingID">
                                                            <option value="{{ $booking->RoomID }}" selected>
                                                                {{ $booking->rooms->RoomName }}
                                                            </option>
                                                            @foreach ($bookingRooms as $bookingRoom)
                                                                <option value="{{ $bookingRoom->RoomID }}">
                                                                    {{ $bookingRoom->RoomName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('RoomBookingID')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </td>
                                                    <td class="align-middle text-end">
                                                        <div
                                                            class="d-grid gap-2 d-flex justify-content-end align-items-center">
                                                            <button class="btn btn-outline-secondary btn-sm me-2"
                                                                type="button" data-bs-toggle="modal"
                                                                data-bs-target="#photoUpdateModal{{ $booking->HotelBookingID }}">Add
                                                                Photo</button>
                                                            <button class="btn btn-primary btn-sm update-assign-button"
                                                                type="button"
                                                                data-form-id="updateAssignForm{{ $booking->HotelBookingID }}">Update</button>
                                                            <a type="button" class="btn btn-outline-secondary btn-sm"
                                                                href="{{ route('hotel-assignedbookings.delete', $booking->HotelBookingID) }}"
                                                                data-confirm-delete="true">
                                                                <span class="delete-btn">
                                                                    <i class="material-icons"
                                                                        style="font-size: 1rem">delete</i>
                                                                </span>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </form>
                                            <div class="modal fade"
                                                id="photoUpdateModal{{ $booking->HotelBookingID }}" tabindex="-1"
                                                aria-labelledby="photoUpdateModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="photoUpdateModalLabel">Add
                                                                Photo
                                                            </h5>
                                                            <button type="button"
                                                                class="btn-sm btn-close btn-close-white"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('hotel-assignedbookings.upload-dog-photo', $booking->HotelBookingID) }}"
                                                                method="post" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="mb-3">
                                                                    <input type="file"
                                                                        class="form-control-sm form-control-file @error('DogPhoto') is-invalid @enderror"
                                                                        id="photoBooking{{ $booking->HotelBookingID }}"
                                                                        name="DogPhoto" required>
                                                                    @error('DogPhoto')
                                                                        <div class="invalid-feedback">
                                                                            {{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Upload</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <tr>
                                                <td colspan="6" style="text-align: center"
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Data is empty.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="position-fixed top-1 end-1 z-index-2">
                <div class="toast fade hide p-2 bg-gradient-success" role="alert" aria-live="assertive"
                    id="successToast" aria-atomic="true">
                    <div class="toast-header border-0">
                        <i class="material-icons text-success me-2">
                            check
                        </i>
                        <span class="me-auto font-weight-bold">Success </span>
                        <i class="fas fa-times text-md ms-3 cursor-pointer" data-bs-dismiss="toast"
                            aria-label="Close"></i>
                    </div>
                    <hr class="horizontal dark m-0">
                    <div class="toast-body text-white">
                    </div>
                </div>
            </div>

            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
    @push('js')
        {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script>
            var services = @json($services);
            var pets = @json($pets);
            services.forEach(item => {
                var PetID = document.getElementById('PetID' + item.id);
                PetID.addEventListener("change", function() {
                    var idPet = this.value;
                    var DogName = document.getElementById('DogName' + item.id);
                    var pet = pets.find(p => p.PetID == idPet);
                    DogName.value = pet.Name;
                });
            });

            $('.add-photo-btn').on('click', function() {
                var serviceId = $(this).data('service-id');
                $('#service_id').val(serviceId);
                $('#photoModal').modal('show');
            });

            $('#uploadPhotoBtn').on('click', function() {
                var formData = new FormData();
                formData.append('service_id', $('#service_id').val());
                formData.append('photo', $('#photo')[0].files[0]);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: "{{ route('hotel-unassignedbookings.upload-service-photo') }}",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#photoModal').modal('hide');
                        $('.toast-body').html(response.message);
                        $('#successToast').toast('show');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.assign-button').forEach(item => {
                    item.addEventListener('click', event => {
                        event.preventDefault();

                        const formId = item.getAttribute('data-form-id');

                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You want to assign this booking?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#2778c4',
                            cancelButtonColor: '#757575',
                            confirmButtonText: 'Yes, I am'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById(formId).submit();
                            }
                        });
                    });
                });
                document.querySelectorAll('.update-assign-button').forEach(item => {
                    item.addEventListener('click', event => {
                        event.preventDefault();

                        const formId = item.getAttribute('data-form-id');

                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You want to update this assigned booking?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#2778c4',
                            cancelButtonColor: '#757575',
                            confirmButtonText: 'Yes, I am'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById(formId).submit();
                            }
                        });
                    });
                });
            });

            $(document).ready(function() {
                $('.delete-btn').on('click', function(e) {
                    e.preventDefault();

                    var deleteUrl = $(this).closest('a').attr('href');

                    // Tampilkan sweet alert
                    Swal.fire({
                            title: "Are you sure?",
                            text: "You want to delete this booking?",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: '#2778c4',
                            cancelButtonColor: '#757575',
                            confirmButtonText: 'Yes, delete it!'
                        })
                        .then((result) => {
                            if (result.isConfirmed) {
                                // Jika pengguna mengonfirmasi penghapusan, alihkan ke URL penghapusan
                                window.location.href = deleteUrl;
                            }
                        });
                });
            });
        </script>
    @endpush
</x-layout>
