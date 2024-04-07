@extends('hotel.rooms.layout')

@section('content')
<!-- ROOM TITLE AND IMAGE -->
<div class="row" style="display: flex; width: 100%; position: relative;">
    <!-- Text Content -->
    <div style="flex: 1; z-index: 2; position: relative;">
        <h1 class="display-3 text-uppercase mb-0 pb-0" style="margin-bottom: 0; padding-bottom: 0; line-height: 1; color: white;">
            <span style="display: inline-block; position: relative; border-bottom: 1px solid transparent;">
                LONDON
                <span style="position: absolute; bottom: -2px; left: 0; width: 100%; border-bottom: 1px solid #FFF;"></span>
            </span> <!-- Custom thin line under text -->
        </h1>
        <h1 class="text-uppercase display-6 mt-0 pt-1" style="color: #E6348B; margin-bottom: 0; padding-bottom: 0; line-height: 1;">SUITE</h1>
    </div>

    <!-- Background with Linear Gradient and Image Adjusted for Vertical Fit -->
    <div style="
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 1;
        background: linear-gradient(to right, rgba(0, 0, 0, 1) 30%, rgba(0,0,0,0) 100%), url('{{ asset('assets') }}/img/room-icons/london.png') no-repeat right center / auto 100%;
        ">
    </div>
</div>

<!-- DOG OCCUPANT INFORMATION AND STATS -->
<div class="row mt-5 pt-3" style="display: flex; width: 100%;">

    <div
        class="bg-image"
        style="
        flex: 20%;
        background-image: url('{{ asset('assets') }}/img/dogs/arrow.jpg');
        background-size: 100% auto; /* Fit horizontally, maintain aspect ratio */
        background-repeat: no-repeat; /* Prevent the image from repeating */
        background-position: center center; /* Center the image vertically and horizontally */
        height: 200px;
        border: 6px solid #E6348B;
        border-top-left-radius: 35px;
        border-bottom-right-radius: 35px;
        ">
    </div>

    <div style="flex: 40%;" class="ml-4">
        <h1 class="display-4 text-uppercase" style="margin-bottom: 0; padding-bottom: 0; line-height: 1;">Arrow</h1>
        <p class="lead pt-2" style="margin-bottom: 0; padding-bottom: 0; line-height: 1;">Alaskan Malamute</p>
        <p class="lead">9 Years Old</span>
        <p style="strong; margin-bottom: 0; padding-bottom: 0; line-height: 1.5; color: #A1A0A0">Owner: <span>Jay Tikaani</span></p>
        <p style="strong; margin-bottom: 0; padding-bottom: 0; line-height: 1.5; color: #A1A0A0">Tel: <span>07123456789</span></p>

    </div>

    <div style="flex: 20%;">
        <!-- ENERGY LEVEL -->
        <div style="display: flex; align-items: center; margin-bottom: 10px;"> <!-- Adjust spacing as needed -->
            <img src="{{ asset('assets') }}/img/room-icons/energy-mid.png" style="width: 24px; height: 24px; margin-right: 8px;"> <!-- Adjust icon size as needed -->
            <span>Medium Energy</span>
        </div>

        <!-- DISABILITY INDICATOR -->
        <div style="display: flex; align-items: center; margin-bottom: 10px;"> <!-- Adjust spacing as needed -->
            <img src="{{ asset('assets') }}/img/room-icons/disabled-icon.png" style="width: 24px; height: 24px; margin-right: 8px;"> <!-- Adjust icon size as needed -->
            <span>Disabled</span>
        </div>

        <!-- ALLERGIES INDICATOR -->
        <div style="display: flex; align-items: center; margin-bottom: 10px;"> <!-- Adjust spacing as needed -->
            <img src="{{ asset('assets') }}/img/room-icons/allergies-icon.png" style="width: 24px; height: 24px; margin-right: 8px;"> <!-- Adjust icon size as needed -->
            <span>Known Allergies</span>
        </div>
    </div>
</div>

<!-- <h1 class="display-1 text-uppercase">{{ $room->RoomName }}</h1> -->

<!-- CHECK IN/OUT DATES -->
<div class="row mt-5 pt-1" style="display: flex; width: 100%;">
    <div style="flex: 50%;">
        <span style="font-size: 1.5rem; font-weight: lighter;">Check-In: </span>
        <span style="font-size: 1.5rem; font-weight: bold;">1 May 2024</span>
    </div>

    <div style="flex: 50%; display: flex; justify-content: flex-end;">
        <span style="font-size: 1.5rem; font-weight: lighter;">Check-Out: </span>
        <span style="font-size: 1.5rem; font-weight: bold;">5 May 2024</span>
    </div>
</div>


<!-- CHECK IN/OUT PROGRESS BAR -->
<div class="row mt-1" style="display: flex; width: 100%;">
    <div class="progress" style="width: 100%; height: 30px;">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%; background-color: #E6348B;">
            1 of 4 Nights Remaining
        </div>
    </div>
</div>

<!-- FEEDING INFORMATION -->
<div class="row mt-5" style="display: flex; width: 100%;">
    <div
    class="bg-image"
    style="
    flex: 20%;
    background-image: url('{{ asset('assets') }}/img/room-icons/feeding-icon.png');
    background-size: 70% auto; /* Fit horizontally, maintain aspect ratio */
    background-repeat: no-repeat; /* Prevent the image from repeating */
    background-position: center center; /* Center the image vertically and horizontally */
    height: 100px;
    ">
    </div>

    <div style="flex: 60%;">
        <h3 style="color: #E6348B;">FEEDING</h3>
        <span style="font-size: 1rem; font-weight: bold;">INSTRUCTIONS</span>
        <p>
            He likes to have his frozen duck wings in the evenings, 3 or 4. He may not eat at all. Don't worry he can go 3/4 days without wanting to eat and that is quite normal for his breed.
        </p>
    </div>

    <div class="pl-4" style="flex: 20%;">
        <div class="mt-4 pt-3">
            <span style="font-size: 1rem; font-weight: bold;">FEED TIMES</span>
        </div>
        <!-- MORNING -->
        <div class="pt-2" style="display: flex; align-items: center; margin-bottom: 5px;"> <!-- Adjust spacing as needed -->
            <img src="{{ asset('assets') }}/img/room-icons/cross.png" style="width: 20px; height: 20px; margin-right: 8px;"> <!-- Adjust icon size as needed -->
            <span>Morning</span>
        </div>

        <!-- AFTERNOON -->
        <div style="display: flex; align-items: center; margin-bottom: 5px;"> <!-- Adjust spacing as needed -->
            <img src="{{ asset('assets') }}/img/room-icons/cross.png" style="width: 20px; height: 20px; margin-right: 8px;"> <!-- Adjust icon size as needed -->
            <span>Afternoon</span>
        </div>

        <!-- EVENING -->
        <div style="display: flex; align-items: center; margin-bottom: 5px;"> <!-- Adjust spacing as needed -->
            <img src="{{ asset('assets') }}/img/room-icons/check.png" style="width: 20px; height: 20px; margin-right: 8px;"> <!-- Adjust icon size as needed -->
            <span>Evening</span>
        </div>
    </div>

</div>


@endsection
