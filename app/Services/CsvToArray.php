<?php

namespace App\Services;

class CsvToArray
{
      public function csvToArray($filename = '', $delimiter = ',', $enclosure = "\"")
      {
            if (!file_exists($filename) || !is_readable($filename))
                  return false;

            $header = null;
            $data = [];
            if (($handle = fopen($filename, 'r')) !== false) {
                  while (($row = fgetcsv($handle, 0, $delimiter, $enclosure)) !== false) {
                        // If header is not set yet
                        if (!$header) {
                              $header = $row;

                              // Count how many times each value appears in the header
                              $header_counts = array_count_values($header);

                              // For each value in the header
                              foreach ($header_counts as $key => $count) {
                                    // If the value is duplicated
                                    if ($count > 1) {
                                          $index = 1;
                                          $newKey = $key . "_$index";

                                          // Check if the new key already exists in the header
                                          while (in_array($newKey, $header)) {
                                                $index++;
                                                $newKey = $key . "_$index";
                                          }

                                          // Replace the duplicated value in the header with a new key containing an additional index
                                          $header[array_search($key, $header)] = $newKey;
                                    }
                              }
                        } else {
                              // Combine the header with the current row to form an associative array and add it to the data array
                              $data[] = array_combine($header, $row);
                        }
                  }
                  fclose($handle);
            }

            return $data;
      }

      public function convertToDate($x)
      {
            return \DateTime::createFromFormat('d/m/Y', $x);
      }

      public function groupByDateRange($data)
      {
            // Urutkan data berdasarkan tanggal
            usort($data, function ($a, $b) {
                  $xa = $a['Date'];
                  $xb = $b['Date'];
                  return strtotime($xa) - strtotime($xb);
            });
            $groupedData = [];
            $tempGroup = [];
            // dd($data);
            $stayStart = null;
            foreach ($data as $row) {
                  if (empty($tempGroup)) {
                        // Tambahkan baris pertama ke dalam tempGroup
                        $tempGroup[] = $row;
                        $stayStart = $row['Date']; // Tetapkan tanggal awal
                  } else {
                        // Ambil tanggal terakhir dari tempGroup
                        $lastDate = end($tempGroup)['Date'];
                        // Periksa selisih tanggal
                        $currentDate = $row['Date'];
                        $dateDiff = strtotime($currentDate) - strtotime($lastDate);

                        if ($dateDiff == 86400) {
                              // Jika selisih tanggal 1 dan semua kolom sama
                              $tempGroup[] = $row;
                        } else {
                              // Jika selisih tanggal lebih dari 1 atau data tidak sama
                              $stayEnd = date('d/m/Y', strtotime('-1 day', strtotime($lastDate)));
                              $groupedData[] = self::createUniqueGroup($tempGroup, $stayStart, $stayEnd);
                              $tempGroup = [$row];
                              $stayStart = $currentDate; // Tetapkan tanggal awal baru
                        }
                  }
            }
            // Tambahkan tempGroup terakhir
            if (!empty($tempGroup)) {
                  $stayEnd = end($tempGroup)['Date']; // Akhiri dengan tanggal terakhir
                  $groupedData[] = self::createUniqueGroup($tempGroup, $stayStart, $stayEnd);
            }

            return $groupedData;
      }

      public function createUniqueGroup($tempGroup, $stayStart, $stayEnd)
      {
            $uniqueGroup = [
                  'StayStart' => $stayStart,
                  'StayEnd' => $stayEnd,
            ];

            // Gabungkan semua kolom dari tempGroup ke dalam uniqueGroup
            foreach ($tempGroup[0] as $key => $value) {
                  if ($key !== 'Date') {
                        $uniqueGroup[$key] = $value;
                  }
            }

            return $uniqueGroup;
      }

      public function  getRecordService($dates, $newDates)
      {
            // $dates = ["01/04/2024", "02/04/2024", "03/04/2024", "07/04/2024", "08/04/2024", "11/04/2024", "12/04/2024", "13/04/2024"];

            // $newDates = []; 
            // dd($dates);
            $currentGroup = [];

            foreach ($dates as $date) {
                  // Pecah tanggal menjadi bagian-bagian (hari, bulan, tahun)
                  $dateParts = explode('/', $date);
                  $day = $dateParts[0];
                  $month = $dateParts[1];
                  $year = $dateParts[2];

                  // Format tanggal ke dalam "DD/MM/YYYY"
                  $formattedDate = sprintf("%02d/%02d/%04d", $day, $month, $year);

                  // Jika $currentGroup kosong atau tanggal saat ini tidak berurutan dengan tanggal terakhir di dalam grup
                  if (empty($currentGroup) || $day - (int) end($currentGroup) !== 1) {
                        // Tambahkan grup tanggal saat ini ke dalam $newDates
                        if (!empty($currentGroup)) {
                              $newDates[] = $currentGroup;
                        }
                        // Mulai grup baru dengan tanggal saat ini
                        $currentGroup = [$formattedDate];
                  } else {
                        // Tambahkan tanggal saat ini ke dalam grup saat ini
                        $currentGroup[] = $formattedDate;
                  }
            }

            // Pastikan grup tanggal terakhir juga dimasukkan ke dalam $newDates
            if (!empty($currentGroup)) {
                  $newDates[] = $currentGroup;
            }

            // dd($newDates);
            // foreach ($newDates as $index => $group) {
            //       echo "$index => [" . implode(', ', $group) . "]\n";
            // }
            return $newDates;
      }
}
