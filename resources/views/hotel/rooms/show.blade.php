@extends('hotel.rooms.layout')

@section('content')
<div class="row" style="display: flex; width: 100%;">
    <!-- Left Column 75% -->
    <div style="flex: 75%;">
        <!-- Content for the left column goes here -->
        <h1>{{ $room->RoomName }}</h1>
        <p>SUITE</p>
    </div>
    <!-- Right Column 25% -->
    <div style="flex: 25%;">
        <!-- Content for the right column goes here -->
        <img src="{{ asset('assets') }}/img/rooms/london.png" width="100%">
    </div>
</div>

<!-- Row 2 -->
<div class="row" style="display: flex; width: 100%;">

    <div style="flex: 20%;">
        <!-- Content for the left column goes here -->
        <img src="{{ asset('assets') }}/img/dogs/arrow.jpg" width="100%">
    </div>

    <div style="flex: 40%;">
        <!-- Content for the right column goes here -->
        Dog Name & Info
    </div>

    <div style="flex: 20%;">
        <!-- Content for the right column goes here -->
        Dog Stats
    </div>
</div>


@endsection
