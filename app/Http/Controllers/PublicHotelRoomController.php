<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class PublicHotelRoomController extends Controller
{
    public function show($roomID)
    {
        // Return the view with the room data.
        return view('hotel.rooms.show', ['roomID' => $roomID]);
    }
}
