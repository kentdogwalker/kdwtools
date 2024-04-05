@extends('hotel.rooms.layout')

@section('content')
<div class="row" style="display: flex; width: 100%;">
    <!-- Left Column 75% -->
    <div style="flex: 70%;">
        <!-- Content for the left column goes here -->
        <h1 class="display-3 text-uppercase mb-0 pb-0">AMSTERDAM</h1>
        <h1 style="color: #E6348B"" class="text-uppercase display-6 mt-0 pt-0">SUITE</h1>
    </div>
    <!-- Right Column 25% -->
    <div class="align-top" style="flex: 30%;">
        <!-- Content for the right column goes here -->
        <img src="{{ asset('assets') }}/img/rooms/london.png" width="100%">
    </div>
</div>

<!-- Row 2 -->
<div class="row mt-5" style="display: flex; width: 100%;">

    <div
        class="bg-image border"
        style="
        flex: 20%;
        background-image: url('{{ asset('assets') }}/img/dogs/arrow.jpg');
        height: 200px;

        ">
        <!-- Content for the left column goes here -->

    </div>

    <div style="flex: 40%;" class="ml-3">
        <!-- Content for the right column goes here -->
        <h1 class="display-4 text-uppercase">Rex</h1>
        <p>Boxer</p>
        <p>4 Years Old</p>

    </div>

    <div style="flex: 20%;">
        <!-- Content for the right column goes here -->
        Dog Stats
    </div>
</div>

<!-- <h1 class="display-1 text-uppercase">{{ $room->RoomName }}</h1> -->

@endsection
