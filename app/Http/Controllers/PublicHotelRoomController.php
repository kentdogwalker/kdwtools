<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class PublicHotelRoomController extends Controller
{
    public function show($roomID) {
        // Find the room by RoomID. Use firstOrFail to automatically throw a 404 exception if not found.
        $room = Room::where('RoomID', $roomID)->firstOrFail();

        // Return the view with the room data.
        return view('hotel.rooms.show', ['room' => $room]);
    }


}
