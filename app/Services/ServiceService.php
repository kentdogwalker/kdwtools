<?php

namespace App\Services;

use App\Models\Service;

class ServiceService
{
      public function getDataFormat($key, $currentGroup = null)
      {
            return [
                  "Service" => $key["Service"],
                  "Display Time" => $key["Display Time"],
                  "Schedule Time" => $key["Schedule Time"],
                  "Nominal Service Duration" => $key["Nominal Service Duration"],
                  "DiaryRef" => $key["DiaryRef"],
                  "Staff FirstName" => $key["Staff FirstName"],
                  "Staff LastName" => $key["Staff LastName"],
                  "Client FirstName" => $key["Client FirstName"],
                  "Client LastName" => $key["Client LastName"],
                  "Area" => $key["Area"],
                  "ClientID" => $key["ClientID"],
                  "StaffID" => $key["StaffID"],
                  "Acknowledged" => $key["Acknowledged"],
                  "Status" => $key["Status"],
                  "CheckIn" => $key["CheckIn"],
                  "CheckOut" => $key["CheckOut"],
                  "Qty" => $key["Qty"],
                  "Unit Price" => $key["Unit Price"],
                  "Total" => $key["Total"],
                  "Staff Pay" => $key["Staff Pay"],
                  "Invoice" => $key["Invoice"],
                  "Address-line1 [Main Contact-Client Details]" => $key["Address-line1 [Main Contact-Client Details]"],
                  "Address-line2 [Main Contact-Client Details]" => $key["Address-line2 [Main Contact-Client Details]"],
                  "Address-line3 [Main Contact-Client Details]" => $key["Address-line3 [Main Contact-Client Details]"],
                  "Address-town [Main Contact-Client Details]" => $key["Address-town [Main Contact-Client Details]"],
                  "Address-state [Main Contact-Client Details]" => $key["Address-state [Main Contact-Client Details]"],
                  "Address-zip [Main Contact-Client Details]" => $key["Address-zip [Main Contact-Client Details]"],
                  "Date" => $currentGroup ?? $key['Date']
            ];
      }

      public function getHotelStayAndOtherData($csv)
      {
            $hotelStay = [];
            $otherData = [];
            foreach ($csv as $key) {
                  if (strtolower($key['Service']) === "hotel stay " || strtolower($key['Service']) === "hotel stay") {
                        $hotelStay[] = $this->getDataFormat($key);
                  } else {
                        $otherData[] = $this->getDataFormat($key);
                  }
            }

            return [
                  'hotelStay' => $hotelStay,
                  'otherData' => $otherData
            ];
      }

      public function getTemps($records, $temp)
      {
            $temps = array_unique($temp, SORT_REGULAR);

            foreach ($temps as &$key) {
                  $date = [];
                  foreach ($records as $record) {
                        $key2 = $record;
                        unset($key2['Date']);
                        if (array_values($key2) === array_values($key)) {
                              $key2['Date'] = $record['Date'];
                              $date[] = $key2['Date'];
                        }
                  }
                  $key['Date'] = $date;
            }

            return $temps;
      }

      public function getManipulationDate($temps)
      {
            $newTemps = [];
            foreach ($temps as &$key) {
                  $v = [];
                  foreach ($key['Date'] as $value) {
                        $v[] = $value;
                  }
                  $currentGroup = [];

                  foreach ($v as $date) {
                        // Split the date into parts (day, month, year)
                        $dateParts = explode('/', $date);
                        $day = $dateParts[0];
                        $month = $dateParts[1];
                        $year = $dateParts[2];

                        // Convert date to "DD/MM/YYYY"
                        $formattedDate = sprintf("%02d/%02d/%04d", $day, $month, $year);

                        // If $currentGroup is empty or the date is not consecutive, start a new group
                        if (empty($currentGroup) || $day - (int) end($currentGroup) !== 1) {
                              // If $currentGroup is not empty, add it to $newTemps
                              if (!empty($currentGroup)) {
                                    $newTemps[] = $this->getDataFormat($key, $currentGroup);
                              }
                              // Start a new group with the current date
                              $currentGroup = [$formattedDate];
                        } else {
                              // Add the current date to the current group
                              $currentGroup[] = $formattedDate;
                        }
                  }

                  // Add the last group to $newTemps
                  if (!empty($currentGroup)) {
                        $newTemps[] = $this->getDataFormat($key, $currentGroup);
                  }
            }

            return $newTemps;
      }

      public function getHotelStayFix($hotelStay)
      {
            $records = array_unique($hotelStay, SORT_REGULAR);

            $temp = array_map(function ($array) {
                  unset($array['Date']);
                  return $array;
            }, $records);

            $temps = $this->getTemps($records, $temp);

            $newTemps = $this->getManipulationDate($temps);

            foreach ($newTemps as &$item) {
                  $stayStart = reset($item['Date']);
                  $stayEnd = end($item['Date']);
                  unset($item['Date']);
                  // Convert dates to DateTime objects
                  $startDate = \DateTime::createFromFormat('d/m/Y', $stayStart);
                  $endDate = \DateTime::createFromFormat('d/m/Y', $stayEnd);

                  // calculate duration
                  $duration = $startDate->diff($endDate)->days;
                  $item['StayStart'] = $stayStart;
                  $item['StayEnd'] = $stayEnd;
                  $item['Duration'] = $duration;
            }

            return $newTemps;
      }

      public function createToServices($key, $type)
      {
            $existing = $type === 'hotel stays' ? $this->getExistingHotelStays($key) : $this->getExistingOtherData($key);

            if (!$existing) {
                  $data = $this->getFormatToCreate($key, $type);
                  Service::create($data);
            }
      }

      public function getExistingHotelStays($key)
      {
            $StayStart = \DateTime::createFromFormat('d/m/Y', $key['StayStart']);
            $StayEnd = \DateTime::createFromFormat('d/m/Y', $key['StayEnd']);
            $start = $StayStart->format('Y-m-d');
            $end = $StayEnd->format('Y-m-d');
            $assignStatus = $key['Status'] === 'Cancelled' ? 'Cancelled' : 'Pending';
            $Acknowledged = filter_var($key["Acknowledged"], FILTER_VALIDATE_BOOLEAN);
            return Service::where('ClientID', $key["ClientID"])
                  ->where('StaffID', $key["StaffID"])
                  ->where('ServiceName', $key["Service"])
                  ->where('StayStart', $start)
                  ->where('StayEnd', $end)
                  ->where('NominalServiceDuration', $key["Nominal Service Duration"])
                  ->where('Duration', $key["Duration"])
                  ->where('DisplayTime', $key["Display Time"])
                  ->where('ScheduleTime', $key["Schedule Time"])
                  ->where('DiaryRef', $key["DiaryRef"])
                  ->where('StaffFirstName', $key["Staff FirstName"])
                  ->where('StaffLastName', $key["Staff LastName"])
                  ->where('Acknowledged', $Acknowledged)
                  ->where('Area', $key["Area"])
                  ->where('Status', $key["Status"])
                  ->where('AssignStatus', $assignStatus)
                  ->where('CheckIn', $key["CheckIn"])
                  ->where('CheckOut', $key["CheckOut"])
                  ->where('Qty', $key["Qty"])
                  ->where('UnitPrice', $key["Unit Price"])
                  ->where('Total', $key["Total"])
                  ->where('StaffPay', $key["Staff Pay"])
                  ->where('Invoice', $key["Invoice"])
                  ->where('Address1', $key["Address-line1 [Main Contact-Client Details]"])
                  ->where('Address2', $key["Address-line2 [Main Contact-Client Details]"])
                  ->where('Address3', $key["Address-line3 [Main Contact-Client Details]"])
                  ->where('AddressTown', $key["Address-town [Main Contact-Client Details]"])
                  ->where('AddressState', $key["Address-state [Main Contact-Client Details]"])
                  ->where('AddressZip', $key["Address-zip [Main Contact-Client Details]"])
                  ->first();
      }

      public function getExistingOtherData($key)
      {
            $dateOther = \DateTime::createFromFormat('d/m/Y', $key['Date']);
            $date = $dateOther->format('Y-m-d');
            $Acknowledged = filter_var($key["Acknowledged"], FILTER_VALIDATE_BOOLEAN);
            return Service::where('ClientID', $key["ClientID"])
                  ->where('StaffID', $key["StaffID"])
                  ->where('ServiceName', $key["Service"])
                  ->where('Date', $date)
                  ->where('NominalServiceDuration', $key["Nominal Service Duration"])
                  ->where('DisplayTime', $key["Display Time"])
                  ->where('ScheduleTime', $key["Schedule Time"])
                  ->where('DiaryRef', $key["DiaryRef"])
                  ->where('StaffFirstName', $key["Staff FirstName"])
                  ->where('StaffLastName', $key["Staff LastName"])
                  ->where('Acknowledged', $Acknowledged)
                  ->where('Area', $key["Area"])
                  ->where('Status', $key["Status"])
                  ->where('CheckIn', $key["CheckIn"])
                  ->where('CheckOut', $key["CheckOut"])
                  ->where('Qty', $key["Qty"])
                  ->where('UnitPrice', $key["Unit Price"])
                  ->where('Total', $key["Total"])
                  ->where('StaffPay', $key["Staff Pay"])
                  ->where('Invoice', $key["Invoice"])
                  ->where('Address1', $key["Address-line1 [Main Contact-Client Details]"])
                  ->where('Address2', $key["Address-line2 [Main Contact-Client Details]"])
                  ->where('Address3', $key["Address-line3 [Main Contact-Client Details]"])
                  ->where('AddressTown', $key["Address-town [Main Contact-Client Details]"])
                  ->where('AddressState', $key["Address-state [Main Contact-Client Details]"])
                  ->where('AddressZip', $key["Address-zip [Main Contact-Client Details]"])
                  ->first();
      }

      public function getFormatToCreate($key, $type)
      {
            if ($type === 'other') {
                  $dateOther = \DateTime::createFromFormat('d/m/Y', $key['Date']);
                  $date = $dateOther->format('Y-m-d');
            }

            if ($type === 'hotel stays') {
                  $StayStart = \DateTime::createFromFormat('d/m/Y', $key['StayStart']);
                  $start = $StayStart->format('Y-m-d');
                  $StayEnd = \DateTime::createFromFormat('d/m/Y', $key['StayEnd']);
                  $end = $StayEnd->format('Y-m-d');
            }

            $assignStatus = $type === 'hotel stays' ? ($key['Status'] === 'Cancelled' ? 'Cancelled' : 'Pending') : null;
            $Acknowledged = filter_var($key["Acknowledged"], FILTER_VALIDATE_BOOLEAN);

            return [
                  "ClientID" => $key["ClientID"],
                  "StaffID" => $key["StaffID"],
                  "ServiceName" => $key["Service"],
                  "Date" => $date ?? null,
                  "StayStart" => $start ?? null,
                  "StayEnd" => $end ?? null,
                  "NominalServiceDuration" => $key["Nominal Service Duration"],
                  "Duration" => $key["Duration"] ?? 0,
                  "DisplayTime" => $key["Display Time"],
                  "ScheduleTime" => $key["Schedule Time"],
                  "DiaryRef" => $key["DiaryRef"],
                  "StaffFirstName" => $key["Staff FirstName"],
                  "StaffLastName" => $key["Staff LastName"],
                  "Acknowledged" => $Acknowledged,
                  "Area" => $key["Area"],
                  "Status" => $key["Status"],
                  "AssignStatus" => $assignStatus,
                  "CheckIn" => $key["CheckIn"],
                  "CheckOut" => $key["CheckOut"],
                  "Qty" => $key["Qty"],
                  "UnitPrice" => $key["Unit Price"],
                  "Total" => $key["Total"],
                  "StaffPay" => $key["Staff Pay"],
                  "Invoice" => $key["Invoice"],
                  "Address1" => $key["Address-line1 [Main Contact-Client Details]"],
                  "Address2" => $key["Address-line2 [Main Contact-Client Details]"],
                  "Address3" => $key["Address-line3 [Main Contact-Client Details]"],
                  "AddressTown" => $key["Address-town [Main Contact-Client Details]"],
                  "AddressState" => $key["Address-state [Main Contact-Client Details]"],
                  "AddressZip" => $key["Address-zip [Main Contact-Client Details]"],
            ];
      }
}
