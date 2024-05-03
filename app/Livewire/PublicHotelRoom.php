<?php

namespace App\Livewire;

use DateTime;
use Carbon\Carbon;
use App\Models\Room;
use Livewire\Component;
use App\Models\Hotelbookings;
use App\Services\ImageService;
use Livewire\Attributes\Layout;

class PublicHotelRoom extends Component
{
    #[Layout('hotel.rooms.layout')]

    protected $imageService;
    public $roomStatus;
    public $booking;
    public $room;


    public function __construct()
    {
        $this->imageService = new ImageService;
    }

    public function mount($roomID)
    {
        $this->fetchData($roomID);
    }

    public function fetchData($roomID)
    {
        // Find the room by RoomID. Use firstOrFail to automatically throw a 404 exception if not found.
        $room = Room::where('RoomID', $roomID)->firstOrFail()->toArray();
        $room = $this->getRoomData($room);
        $now = Carbon::now()->format('Y-m-d');
        $hotelBooking = $this->getHotelBooking($now, $roomID);
        $roomStatus = 'occupied';
        // If no booking found for the current date, find the next available booking
        if (!$hotelBooking) {
            $hotelBooking = $this->getNextBooking($now, $roomID);
            $roomStatus = 'vacant';
        }
        $this->roomStatus = $roomStatus;
        $this->booking = $hotelBooking;
        $this->room = $room;
        // dd($this->room);
    }

    public function pollData()
    {
        $this->fetchData($this->room['RoomID']);
    }

    public function render()
    {
        return view('livewire.public-hotel-room');
    }

    public function getRoomData($room)
    {
        $room['name'] = str_replace('Suite', '', $room['RoomName']);
        $room['image'] = $this->imageService->getRoomImage($room['name']);
        return $room;
    }

    public function getNextBooking($now, $roomID)
    {
        $hotelBooking = null;
        $nextBooking = Hotelbookings::with(['clients', 'rooms', 'pets'])->where('StayStart', '>', $now)
            ->where('RoomID', $roomID)
            ->orderBy('StayStart', 'asc')
            ->first();
        // If there's a next booking, use it
        if ($nextBooking) {
            $hotelBooking = $nextBooking->toArray();
            if (isset($hotelBooking['DogPhoto']) || isset($hotelBooking['StayStart']) || isset($hotelBooking['StayEnd'])) {
                $breed = $hotelBooking['pets']['Breed'] ?? null;
                $hotelBooking['DogPhoto'] = $this->imageService->getDogImage($hotelBooking['DogPhoto'], $breed);
                $hotelBooking['BookingDate'] = date('d M', strtotime($hotelBooking['StayStart'])) . ' > ' . date('d M', strtotime($hotelBooking['StayEnd']));
            }
        }
        return $hotelBooking;
    }

    public function getHotelBooking($now, $roomID)
    {
        $booking = Hotelbookings::with(['clients', 'rooms', 'pets', 'pets.vets'])
            ->where('RoomID', $roomID)
            ->where(function ($query) use ($now) {
                $query->where(function ($query) use ($now) {
                    $query->where('StayStart', '>=', $now)
                        ->where('StayEnd', '<=', $now);
                })
                    ->orWhere(function ($query) use ($now) {
                        $query->where('StayStart', '<=', $now)
                            ->where('StayEnd', '>=', $now);
                    })
                    ->orWhere(function ($query) use ($now) {
                        $query->where('StayStart', '>=', $now)
                            ->where('StayStart', '<=', $now)
                            ->where('StayEnd', '>=', $now);
                    })
                    ->orWhere(function ($query) use ($now) {
                        $query->where('StayStart', '<=', $now)
                            ->where('StayEnd', '>=', $now)
                            ->where('StayEnd', '<=', $now);
                    });
            })->first();

        // Make sure $booking is not null
        if ($booking) {
            $booking = $booking->toArray();
            if (isset($booking['DogPhoto']) || isset($booking['pets']['DateOfBirth'])) {
                $breed = $booking['pets']['Breed'] ?? null;
                $booking['DogPhoto'] = $this->imageService->getDogImage($booking['DogPhoto'], $breed);
                $booking['Age'] = $this->getPetAge($booking['pets']['DateOfBirth']);
                $booking['Owner'] = $booking['clients']['FirstName'] . ' ' . $booking['clients']['LastName'];
                $booking['EnergyLevel'] = $this->getEnergyLevel($booking['pets']['FitnessLevel']);
                $booking['DisabilitiesIcon'] = $this->imageService->getPetsDisabilitiesIcon($booking['pets']['Disabilities']);
                $booking['AllergiesIcon'] = $this->imageService->getPetsAllergiesIcon($booking['pets']['Allergies']);
                $booking['Progress'] = $this->getProgressBooking($booking['StayStart'], $booking['StayEnd'], $booking['Duration']);
                $booking['HotelFeedTime'] = $this->getHotelFeedTime($booking['pets']);
                $booking['pets']['UsualWakeTime'] = $booking['pets']['UsualWakeTime'] === '' || $booking['pets']['UsualWakeTime'] === null ? 'Not Specified' : $booking['pets']['UsualWakeTime'];
                $booking['pets']['UsualBedTime'] = $booking['pets']['UsualBedTime'] === '' || $booking['pets']['UsualBedTime'] === null ? 'Not Specified' : $booking['pets']['UsualBedTime'];
            }
        }
        // dd($booking);
        return $booking;
    }

    public function getPetAge($dateOfBirth)
    {
        $now = new DateTime('today');
        $birth = DateTime::createFromFormat('Y-m-d', $dateOfBirth);
        $age = $now->diff($birth)->y . ' Years Old';
        return $age;
    }

    public function getProgressBooking($start, $end, $duration)
    {
        $now = new DateTime('today');
        $start = DateTime::createFromFormat('Y-m-d', $start);
        $end = DateTime::createFromFormat('Y-m-d', $end);
        $distance = ($now->diff($end)->days) + 1;
        $stay = ($duration - $distance) + 1;
        $valueNow = ($stay / $duration) * 100;
        if (floor($valueNow) == $valueNow) {
            $valueNowFormatted = number_format($valueNow, 0);
        } else {
            $valueNowFormatted = number_format($valueNow, 2);
        }

        $percentValue = $valueNowFormatted . '%';
        $info = 'Nights Remaining';
        if ($duration == 1) {
            $info = 'Night Remaining';
        }

        return [
            'ariaValueNow' => $valueNowFormatted,
            'percentValue' => $percentValue,
            'stayInformation' => $stay . ' of ' . $duration . ' ' . $info
        ];
    }

    public function getEnergyLevel($level)
    {
        $level_image = asset('assets/img/room-icons/energy-mid.png');
        $level_status = "Mid Energy";
        if ($level === 'High') {
            $level_image = asset('assets/img/room-icons/energy-high.png');
            $level_status = "High Energy";
        }
        if ($level === 'Low') {
            $level_image = asset('assets/img/room-icons/energy-low.png');
            $level_status = "Low Energy";
        }
        return [
            'status' => $level_status,
            'src' => $level_image
        ];
    }

    public function getHotelFeedTime($pet)
    {
        $am = asset('assets/img/room-icons/cross.png');
        $mid = asset('assets/img/room-icons/cross.png');
        $pm = asset('assets/img/room-icons/cross.png');
        if ($pet['HotelFeedTimeAM'] === 1) {
            $am = asset('assets/img/room-icons/check.png');
        }
        if ($pet['HotelFeedTimeMid'] === 1) {
            $mid = asset('assets/img/room-icons/check.png');
        }
        if ($pet['HotelFeedTimePM'] === 1) {
            $pm = asset('assets/img/room-icons/check.png');
        }

        return [
            'Am' => $am,
            'Mid' => $mid,
            'Pm' => $pm
        ];
    }
}
