<?php

namespace App\Services;

use DateTime;
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
                  $item['Duration'] = $duration + 1;
            }

            return $newTemps;
      }

      public function createToServices($key, $type)
      {
            $data = $this->getFormatToCreate($key, $type);
            if ($type === 'hotel stays') {
                  $hotelStays = $this->getDataHotelStays();
                  if ($hotelStays) {
                        $result = $this->getMergeData($data, $hotelStays);
                  } else {
                        $result = $data;
                  }
                  $existing = $this->getExistingHotelStays($result);
                  if (!$existing) {
                        Service::create($result);
                  }
            } else {
                  $existing = $this->getExistingOtherData($key);
                  if (!$existing) {
                        Service::create($data);
                  }
            }
      }

      private function getDataHotelStays()
      {
            return Service::where('ServiceName', 'LIKE', "%Hotel Stay%")->get()->toArray();
      }

      public function getExistingHotelStays($key)
      {
            $result = Service::where('ClientID', $key["ClientID"])
                  ->where('StaffID', $key["StaffID"])
                  ->where('ServiceName', $key["ServiceName"])
                  ->where('StayStart', $key["StayStart"])
                  ->where('StayEnd', $key["StayEnd"])
                  ->where('NominalServiceDuration', $key["NominalServiceDuration"])
                  ->where('Duration', $key["Duration"])
                  ->where('DisplayTime', $key["DisplayTime"])
                  ->where('ScheduleTime', $key["ScheduleTime"])
                  ->where('DiaryRef', $key["DiaryRef"])
                  ->where('StaffFirstName', $key["StaffFirstName"])
                  ->where('StaffLastName', $key["StaffLastName"])
                  ->where('Acknowledged', $key["Acknowledged"])
                  ->where('Area', $key["Area"])
                  ->where('Status', $key["Status"])
                  ->where('CheckIn', $key["CheckIn"])
                  ->where('CheckOut', $key["CheckOut"])
                  ->where('Qty', $key["Qty"])
                  ->where('UnitPrice', $key["UnitPrice"])
                  ->where('Total', $key["Total"])
                  ->where('StaffPay', $key["StaffPay"])
                  ->where('invoice', $key["invoice"])
                  ->where('Address1', $key["Address1"])
                  ->where('Address2', $key["Address2"])
                  ->where('Address3', $key["Address3"])
                  ->where('AddressTown', $key["AddressTown"])
                  ->where('AddressState', $key["AddressState"])
                  ->where('AddressZip', $key["AddressZip"])
                  ->first();
            return $result;
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
                  ->where('invoice', $key["Invoice"])
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
                  "invoice" => $key["Invoice"],
                  "Address1" => $key["Address-line1 [Main Contact-Client Details]"],
                  "Address2" => $key["Address-line2 [Main Contact-Client Details]"],
                  "Address3" => $key["Address-line3 [Main Contact-Client Details]"],
                  "AddressTown" => $key["Address-town [Main Contact-Client Details]"],
                  "AddressState" => $key["Address-state [Main Contact-Client Details]"],
                  "AddressZip" => $key["Address-zip [Main Contact-Client Details]"],
                  "DogPhoto" => null
            ];
      }

      private function getMergeData($data, $hotelStays)
      {
            $result = null;
            foreach ($hotelStays as $value) {
                  // Check if date range items from $a and $b can be merged
                  $condition = $this->getParamCondition($data, $value);
                  if ($condition) {
                        // If items can be merged, merge the data and add to the result
                        if ($result === null) {
                              $result = $this->mergeData($data, $value);
                        } else {
                              $result = $this->mergeData($result, $value);
                        }
                        $service = Service::find($value['id']);
                        $service->delete();
                  }
            }
            // If no matching item is found, add item from array $a to the result
            if ($result === null) {
                  return $result = $data;
            }
            return $result;
      }

      private function mergeData($data, $value)
      {
            // Convert dates to DateTime objects
            $stayStart = min($data['StayStart'], $value['StayStart']);
            $stayEnd = max($data['StayEnd'], $value['StayEnd']);
            $startDate = \DateTime::createFromFormat('Y-m-d', $stayStart);
            $endDate = \DateTime::createFromFormat('Y-m-d', $stayEnd);

            if ($data['StayStart'] == $value['StayStart'] && $data['StayEnd'] == $value['StayEnd']) {
                  $assignStatus = $value['AssignStatus'];
            } else {
                  $assignStatus = $data['AssignStatus'];
            }
            // calculate duration
            $duration = $startDate->diff($endDate)->days;
            $duration = $duration + 1;

            // Merge two data items into one with expanded date range
            return [
                  "ClientID" => $data['ClientID'],
                  "StaffID" => $data['StaffID'],
                  "ServiceName" => $data['ServiceName'],
                  "Date" => $data['Date'],
                  "StayStart" => $stayStart,
                  "StayEnd" => $stayEnd,
                  "NominalServiceDuration" => $data['NominalServiceDuration'],
                  "Duration" => $duration,
                  "DisplayTime" => $data['DisplayTime'],
                  "ScheduleTime" => $data['ScheduleTime'],
                  "DiaryRef" => $data['DiaryRef'],
                  "StaffFirstName" => $data['StaffFirstName'],
                  "StaffLastName" => $data['StaffLastName'],
                  "Acknowledged" => $data['Acknowledged'],
                  "Area" => $data['Area'],
                  "Status" => $data['Status'],
                  "AssignStatus" => $assignStatus,
                  "CheckIn" => $data['CheckIn'],
                  "CheckOut" => $data['CheckOut'],
                  "Qty" => $data['Qty'],
                  "UnitPrice" => $data['UnitPrice'],
                  "Total" => $data['UnitPrice'],
                  "StaffPay" => $data['StaffPay'],
                  "invoice" => $data['invoice'],
                  "Address1" => $data['Address1'],
                  "Address2" => $data['Address2'],
                  "Address3" => $data['Address3'],
                  "AddressTown" => $data['AddressTown'],
                  "AddressState" => $data['AddressState'],
                  "AddressZip" => $data['AddressZip'],
                  "DogPhoto" => $data['DogPhoto']
            ];
      }

      private function getParamCondition($data, $value)
      {
            // Check if two data items meet the conditions to be merged based on date range and name
            $startDateA = new DateTime($data['StayStart']);
            $endDateA = new DateTime($data['StayEnd']);
            $startDateB = new DateTime($value['StayStart']);
            $endDateB = new DateTime($value['StayEnd']);
            $diffOne = $endDateA->diff($startDateB)->days;
            $diffTwo = $endDateB->diff($startDateA)->days;

            //Get Conditions
            $datesCondition = ($diffOne === 1 || $diffTwo === 1 || $data['StayEnd'] === $value['StayStart'] || $value['StayEnd'] === $data['StayStart'] ||
                  ($endDateA > $startDateB && $endDateA < $endDateB) || ($endDateB > $startDateA && $endDateB < $endDateA) ||
                  $data['StayStart'] === $value['StayStart'] || $data['StayEnd'] === $value['StayEnd']);

            $identityCondition = $data['ClientID'] == $value['ClientID'] && $data['StaffID'] == $value['StaffID'] && $data['DisplayTime'] == $value['DisplayTime'] &&
                  $data['ScheduleTime'] == $value['ScheduleTime'] && $data['DiaryRef'] == $value['DiaryRef'] && $data['StaffFirstName'] == $value['StaffFirstName'] &&
                  $data['StaffLastName'] == $value['StaffLastName'] && $data['Area'] == $value['Area'] && $data['Status'] == $value['Status'] &&
                  $data['CheckIn'] == $value['CheckIn'] && $data['CheckOut'] == $value['CheckOut'] && $data['Qty'] == $value['Qty'] &&
                  $data['UnitPrice'] == $value['UnitPrice'] && $data['Total'] == $value['Total'] && $data['StaffPay'] == $value['StaffPay'] &&
                  $data['invoice'] == $value['invoice'];

            $addressCondition = $data['Address1'] == $value['Address1'] && $data['Address2'] == $value['Address2'] &&
                  $data['Address3'] == $value['Address3'] && $data['AddressTown'] == $value['AddressTown'] && $data['AddressState'] == $value['AddressState'] &&
                  $data['AddressZip'] == $value['AddressZip'];

            $conditions = $datesCondition && $identityCondition && $addressCondition;

            return $conditions;
      }
}
