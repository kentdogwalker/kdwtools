@extends('hotel.rooms.layout')

@section('content')
    @livewire('public-hotel-room', ['roomID' => $roomID])
@endsection
