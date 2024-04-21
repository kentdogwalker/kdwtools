<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Hotelbookings;

class BookingScheduleService
{
      public function getSchedule($startDate, $endDate)
      {
            $start = Carbon::parse($startDate)->format('Y-m-d');
            $end = Carbon::parse($endDate)->format('Y-m-d');
            $bookings = Hotelbookings::where(function ($query) use ($start, $end) {
                  $query->where('StayStart', '>=', $start)
                        ->where('StayEnd', '<=', $end);
            })
                  ->orWhere(function ($query) use ($start, $end) {
                        $query->where('StayStart', '<=', $start)
                              ->where('StayEnd', '>=', $end);
                  })
                  ->orWhere(function ($query) use ($start, $end) {
                        $query->where('StayStart', '>=', $start)
                              ->where('StayStart', '<=', $end)
                              ->where('StayEnd', '>=', $end);
                  })
                  ->orWhere(function ($query) use ($start, $end) {
                        $query->where('StayStart', '<=', $start)
                              ->where('StayEnd', '>=', $start)
                              ->where('StayEnd', '<=', $end);
                  })
                  ->get();

            $rooms = Room::all();
            $bookingDates = [];
            for ($i = 0; $i < 7; $i++) {
                  $dateTo = Carbon::parse($startDate)->addDays($i)->format('Y-m-d');
                  $bookingDates[] = [
                        'date' => $dateTo
                  ];
            }
            $data = [];
            foreach ($rooms as $room) {
                  $bookingsFix = [];
                  foreach ($bookingDates as $date) {
                        $clients = [];
                        $keyFound = null;
                        $countRoomID = 0;

                        foreach ($bookingDates as $key => $value) {
                              if ($value['date'] === $date['date']) {
                                    $keyFound = $key + 1;
                                    break;
                              }
                        }
                        foreach ($bookings as $booking) {
                              if ($booking->RoomID === $room->RoomID) {
                                    $clients[] = [
                                          'booking_id' => $booking->HotelBookingID,
                                          'room_id' => $booking->RoomID,
                                          'dog_name' => $booking->DogName,
                                          'breed' => $booking->pets->Breed,
                                          'gender' => $booking->pets->Gender,
                                          'dog_photo' => $booking->DogPhoto,
                                          'owner_name' => $booking->clients->FirstName . ' ' . $booking->clients->LastName,
                                          'start' => $booking->StayStart,
                                          'end' => $booking->StayEnd,
                                          'duration' => $booking->Duration
                                    ];
                              }
                        }
                        if (!empty($clients)) {
                              foreach ($clients as &$client) {
                                    if ($client['start'] == $date['date']) {
                                          if ($client['duration'] >= 7) {
                                                switch ($keyFound) {
                                                      case 1:
                                                            if ($client['duration'] > 7) {
                                                                  $client['duration'] = 7;
                                                                  $client['status'] = "More dates >>>";
                                                            }
                                                            break;
                                                      case 2:
                                                            $client['duration'] = 6;
                                                            $client['status'] = "More dates >>>";
                                                            break;
                                                      case 3:
                                                            $client['duration'] = 5;
                                                            $client['status'] = "More dates >>>";
                                                            break;
                                                      case 4:
                                                            $client['duration'] = 4;
                                                            $client['status'] = "More dates >>>";
                                                            break;
                                                      case 5:
                                                            $client['duration'] = 3;
                                                            $client['status'] = "More dates >>>";
                                                            break;
                                                      case 6:
                                                            $client['duration'] = 2;
                                                            $client['status'] = "More dates >>>";
                                                            break;
                                                      case 7:
                                                            $client['duration'] = 1;
                                                            $client['status'] = "More dates >>>";
                                                            break;
                                                }
                                          }
                                          if ($client['duration'] < 7) {
                                                switch ($keyFound) {
                                                      case 3:
                                                            if ($client['duration'] >= 6) {
                                                                  $client['duration'] = 5;
                                                                  $client['status'] = "More dates >>>";
                                                            }
                                                            break;
                                                      case 4:
                                                            if ($client['duration'] >= 5) {
                                                                  $client['duration'] = 4;
                                                                  $client['status'] = "More dates >>>";
                                                            }
                                                            break;
                                                      case 5:
                                                            if ($client['duration'] >= 4) {
                                                                  $client['duration'] = 3;
                                                                  $client['status'] = "More dates >>>";
                                                            }
                                                            break;
                                                      case 6:
                                                            if ($client['duration'] >= 3) {
                                                                  $client['duration'] = 2;
                                                                  $client['status'] = "More dates >>>";
                                                            }
                                                            break;
                                                      case 7:
                                                            if ($client['duration'] >= 2) {
                                                                  $client['duration'] = 1;
                                                                  $client['status'] = "More dates >>>";
                                                            }
                                                            break;
                                                }
                                          }
                                          $previous = [];
                                          for ($i = 1; $i < $keyFound; $i++) {
                                                $previousDate = date('Y-m-d', strtotime($date['date'] . " - $i day"));

                                                $previous[] = ['date' => $previousDate];
                                          }
                                          $previous = array_reverse($previous);
                                          $bookingsFix = array_merge($bookingsFix, $previous);
                                          $bookingsFix[] = [
                                                'date' => $date['date'],
                                                'clients' => $client
                                          ];
                                          if ($date['date'] == $client['end']) {
                                                $keyEnd = 7 - $keyFound;
                                                $next = [];
                                                for ($i = 0; $i < $keyEnd; $i++) {
                                                      $x = $i + 1;
                                                      $nextDate = date('Y-m-d', strtotime($date['date'] . " + $x day"));
                                                      $next[] = ['date' => $nextDate];
                                                }
                                                $bookingsFix = array_merge($bookingsFix, $next);
                                          }
                                    } else {
                                          if ($client['end'] == $date['date']) {
                                                $hasBookingId = false;
                                                foreach ($bookingsFix as $book) {
                                                      if (isset($book['clients']['booking_id']) && $book['clients']['booking_id'] == $client['booking_id']) {
                                                            $hasBookingId = true;
                                                            break;
                                                      }
                                                }
                                                $keyEnd = 7 - $keyFound;
                                                if ($hasBookingId) {
                                                      $next = [];
                                                      for ($i = 0; $i < $keyEnd; $i++) {
                                                            $x = $i + 1;
                                                            $nextDate = date('Y-m-d', strtotime($date['date'] . " + $x day"));
                                                            $next[] = ['date' => $nextDate];
                                                      }
                                                      $bookingsFix = array_merge($bookingsFix, $next);
                                                } else {
                                                      $client['duration'] = $keyFound;
                                                      $bookingsFix[] = [
                                                            'date' => $date['date'],
                                                            'clients' => $client
                                                      ];
                                                      $next = [];
                                                      for ($i = 0; $i < $keyEnd; $i++) {
                                                            $x = $i + 1;
                                                            $nextDate = date('Y-m-d', strtotime($date['date'] . " + $x day"));
                                                            $next[] = ['date' => $nextDate];
                                                      }
                                                      $bookingsFix = array_merge($bookingsFix, $next);
                                                }
                                          }
                                    }
                              }
                        } else {
                              $bookingsFix[] = [
                                    'date' => $date['date']
                              ];
                        }
                  }
                  $data[] = [
                        'room_id' => $room->RoomID,
                        'room_name' => $room->RoomName,
                        'booking' => $bookingsFix
                  ];
            }
            $uniqueData = $this->getUniqueSchedule($data);
            // dd($uniqueData);
            return $uniqueData;
      }

      public function getUniqueSchedule($array)
      {
            $newArray = $array;

            $tempBookings = [];

            // Loop through each entry in the array
            foreach ($array as $key => $value) {
                  // Reset temporary array
                  $tempBookings = [];
                  // Loop through each booking in this entry
                  foreach ($value["booking"] as $bookingKey => $booking) {
                        // If the booking date already exists in the temporary array
                        if (isset($tempBookings[$booking["date"]])) {
                              // Merge client information into existing booking if "clients" key exists
                              if (isset($booking["clients"])) {
                                    $tempBookings[$booking["date"]]["clients"] = $booking["clients"];
                              }
                        } else {
                              // Add booking to the temporary array
                              $tempBookings[$booking["date"]] = $booking;
                        }
                  }
                  // Replace booking with the result of the temporary array
                  $newArray[$key]["booking"] = array_values($tempBookings);
            }

            foreach ($newArray as $key => &$arr) {
                  $last_client_index = null;
                  $countClient = 0;
                  $duration = null;
                  foreach ($arr['booking'] as $key => $booking) {
                        if (isset($booking['clients'])) {
                              $last_client_index = $key;
                              $countClient++;
                              $duration = $booking['clients']['duration'];
                        }
                  }
                  if ($countClient > 1) {
                        if ($last_client_index !== null) {
                              if ($duration) {
                                    $fixDuration = $duration - 1;
                                    $fixDuration = $fixDuration < 0 ? 0 : $fixDuration;
                                    $param = count($arr['booking']);
                                    $paramFix = $param + $fixDuration;
                                    $x = $last_client_index + 1;
                                    for ($i = $x; $i < $paramFix; $i++) {
                                          if (isset($arr['booking'][$i]['date'])) {
                                                unset($arr['booking'][$i]);
                                          }
                                    }
                              }
                        }

                        $totalDuration = 0;
                        foreach ($arr['booking'] as $book) {
                              if (isset($book['clients']) && isset($book['clients']['duration'])) {
                                    $totalDuration += $book['clients']['duration'];
                              } else {
                                    $totalDuration += 1;
                              }
                        }
                        if ($totalDuration < 7) {
                              $lastBookingDate = end($arr['booking'])['date'];
                              $diff = 7 - $totalDuration;
                              for ($i = 0; $i < $diff; $i++) {
                                    $nextDate = date('Y-m-d', strtotime($lastBookingDate . ' + ' . ($i + 1) . ' days'));
                                    $arr['booking'][] = ["date" => $nextDate];
                              }
                        }
                  }
            }

            return $newArray;
      }
}
