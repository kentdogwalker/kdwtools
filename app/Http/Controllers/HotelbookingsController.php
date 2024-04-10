<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\Hotelbookings;
use App\Services\ImageService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UploadServicePhotoRequest;
use App\Http\Requests\HotelbookingsAssignRequest;
use App\Http\Requests\HotelbookingsUpdateRequest;

class HotelbookingsController extends Controller
{
    protected $imageService;

    public function __construct()
    {
        $this->imageService = new ImageService;
    }

    public function index()
    {
        $services = Service::where('ServiceName', 'LIKE', "%Hotel Stay%")
            ->whereNot('Status', 'Cancelled')
            ->where('AssignStatus', 'Pending')
            ->get();
        $pets = Pet::all();
        $bookings = Hotelbookings::all();
        return view('hotel.unassignedbookings', compact('services', 'pets', 'bookings'));
    }

    public function uploadServicePhoto(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|integer|exists:services,id',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Example: Maximum 2MB
        ]);

        // If validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $id = $request->input('service_id');
        if ($request->hasFile('photo')) {
            // Delete previous photo if exists
            self::deleteDogPhotoService($id, 'assign');

            // Upload new photo
            $photo = $request->file('photo');
            $imageName = $this->imageService->getImageName('DOGPHOTO', $photo);
            $this->imageService->uploadImage($photo, $imageName, 'dog-photos');

            // Save new photo name to the database
            Service::where('id', $id)->update([
                'DogPhoto' => $imageName
            ]);

            // Provide success response
            return response()->json(['message' => 'Photo has been uploaded successfully!'], 200);
        }

        // If no file uploaded
        return response()->json(['message' => 'No photo uploaded.'], 400);
    }

    public function uploadDogPhoto(UploadServicePhotoRequest $request, $id)
    {
        if ($request->file('DogPhoto') != null) {
            self::deleteDogPhotoService($id, 'update');
            $imageName = $this->imageService->getImageName('DOGPHOTO', $request->file('DogPhoto'));
            $this->imageService->uploadImage($request->file('DogPhoto'), $imageName, 'dog-photos');
            Hotelbookings::where('HotelBookingID', $id)->update([
                'DogPhoto' => $imageName
            ]);
        }

        alert()->success('Success', 'Photo has been uploaded successfully!');
        return redirect()->back();
    }

    public function assign(HotelbookingsAssignRequest $request, $id)
    {
        $service = Service::find($id);
        if ($service) {
            Hotelbookings::create([
                'ClientID' => $request->input('ClientID'),
                'PetID' => $request->input('PetID'),
                'RoomID' => $request->input('RoomID'),
                'DogName' => $request->input('DogName'),
                'Duration' => $service->Duration,
                'StayStart' => $service->StayStart,
                'StayEnd' => $service->StayEnd,
                'DogPhoto' => $service->DogPhoto,
                'Status' => $service->Status
            ]);
            $service->update([
                'AssignStatus' => 'Completed'
            ]);
        }
        alert()->success('Success', 'The data has been successfully assigned.');
        return redirect()->back();
    }

    public function update(HotelbookingsUpdateRequest $request, $id)
    {
        $hotelBookings = Hotelbookings::find($id);
        if ($hotelBookings) {
            $hotelBookings->update([
                'RoomID' => $request->input('RoomBookingID')
            ]);
        }
        alert()->success('Success', 'The data has been successfully updated.');
        return redirect()->back();
    }

    public function deleteDogPhotoService($id, $type)
    {
        $imageName = '';
        if ($type === 'assign') {
            $service = Service::where('id', $id)->first();
            $imageName = $service->DogPhoto;
        } else {
            $hotelBookings = Hotelbookings::where('HotelBookingID', $id)->first();
            $imageName = $hotelBookings->DogPhoto;
        }

        $filePath = 'public/dog-photos/' . $imageName;
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
    }
}
