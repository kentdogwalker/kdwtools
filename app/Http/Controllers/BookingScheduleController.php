<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class BookingScheduleController extends Controller
{
    public function index()
    {
        return view('hotel.schedule');
    }
}
