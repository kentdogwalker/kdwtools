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
            // dd($this->date_filter);
            $parts = explode(' - ', $this->date_filter);
            $this->startDate = Carbon::createFromFormat('d/m/Y', $parts[0])->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', $parts[1])->endOfDay();
            $this->schedules = $this->bookingService->getSchedule($this->startDate, $endDate);
            // dd($this->schedules);
        } else {
            $this->startDate = Carbon::now()->startOfWeek();
            $endDate = $this->startDate->copy()->addDays(6);
            $formatStartDate = $this->startDate->format('d/m/Y');
            $formatEndDate = $endDate->format('d/m/Y');
            $this->date_filter = $formatStartDate . ' - ' . $formatEndDate;
            $this->schedules = $this->bookingService->getSchedule($this->startDate, $endDate);
            // dd($this->schedules);
        }

        return view('livewire.booking-schedules');
    }

    public function filter()
    {
    }

    public function previousWeek()
    {
        // dd($this->date_filter);
        $parts = explode(' - ', $this->date_filter);
        $endDate = $parts[0];
        $endDateObj = DateTime::createFromFormat('d/m/Y', $endDate);
        $startDateObj = DateTime::createFromFormat('d/m/Y', $endDate);
        $previousEndDateObj = $endDateObj->modify('-1 day');
        $previousStartDateObj = $startDateObj->modify('-7 day');
        $previousEndDate = $previousEndDateObj->format('d/m/Y');
        $previousStartDate = $previousStartDateObj->format('d/m/Y');
        $this->date_filter = $previousStartDate . ' - ' . $previousEndDate;
    }

    public function nextWeek()
    {
        $parts = explode(' - ', $this->date_filter);
        $startDate = $parts[1];
        $startDateObj = DateTime::createFromFormat('d/m/Y', $startDate);
        $endDateObj = DateTime::createFromFormat('d/m/Y', $startDate);
        $nextStartDateObj = $startDateObj->modify('+1 day');
        $nextStartDate = $nextStartDateObj->format('d/m/Y');
        $nextEndDateObj = $endDateObj->modify('+7 day');
        $nextEndDate = $nextEndDateObj->format('d/m/Y');
        $this->date_filter = $nextStartDate . ' - ' . $nextEndDate;
    }
}
