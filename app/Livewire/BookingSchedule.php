<?php

namespace App\Livewire;

use DateTime;
use Carbon\Carbon;
use Livewire\Component;
use App\Services\BookingScheduleService;

class BookingSchedule extends Component
{
    public $date_filter;
    public $startDate;
    public $schedules;
    protected $bookingService;

    public function __construct()
    {
        $this->bookingService = new BookingScheduleService;
    }

    public function render()
    {
        if ($this->date_filter) {
            $parts = explode(' - ', $this->date_filter);
            $this->startDate = $parts[0];
            $endDate = $parts[1];
            $this->schedules = $this->bookingService->getSchedule($this->startDate, $endDate);
        } else {
            $this->startDate = Carbon::now()->startOfWeek();
            $endDate = $this->startDate->copy()->addDays(6);
            $formatStartDate = $this->startDate->format('m/d/Y');
            $formatEndDate = $endDate->format('m/d/Y');
            $this->date_filter = $formatStartDate . ' - ' . $formatEndDate;
            $this->schedules = $this->bookingService->getSchedule($this->startDate, $endDate);
        }

        return view('livewire.booking-schedules');
    }

    public function filter()
    {
    }

    public function previousWeek()
    {
        $parts = explode(' - ', $this->date_filter);
        $endDate = $parts[0];
        $endDateObj = new DateTime($endDate);
        $startDateObj = new DateTime($endDate);
        $previousEndDateObj = $endDateObj->modify('-1 day');
        $previousStartDateObj = $startDateObj->modify('-7 day');
        $previousEndDate = $previousEndDateObj->format('m/d/Y');
        $previousStartDate = $previousStartDateObj->format('m/d/Y');
        $this->date_filter = $previousStartDate . ' - ' . $previousEndDate;
    }

    public function nextWeek()
    {
        $parts = explode(' - ', $this->date_filter);
        $startDate = $parts[1];
        $startDateObj = new DateTime($startDate);
        $endDateObj = new DateTime($startDate);
        $nextStartDateObj = $startDateObj->modify('+1 day');
        $nextStartDate = $nextStartDateObj->format('m/d/Y');
        $nextEndDateObj = $endDateObj->modify('+7 day');
        $nextEndDate = $nextEndDateObj->format('m/d/Y');
        $this->date_filter = $nextStartDate . ' - ' . $nextEndDate;
    }
}
