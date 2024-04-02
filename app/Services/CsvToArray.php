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
}
