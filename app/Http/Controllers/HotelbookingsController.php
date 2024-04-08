<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Service;
use Illuminate\Http\Request;

class HotelbookingsController extends Controller
{
    public function index()
    {
        $services = Service::where('ServiceName', 'LIKE', "%Hotel Stay%")
            ->whereNot('Status', 'Cancelled')
            ->where('AssignStatus', 'Pending')
            ->get();
        return view('hotel.unassignedbookings', compact('services'));
    }

    public function assign(Request $request, $id)
    {
        dd($request->all());
    }
}
