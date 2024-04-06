<?php

namespace App\Services;

use App\Models\Vet;

class VetService
{
      public function csvUpdateOrCreate($row)
      {
            // Sanitize each field in the row to remove line breaks
            $sanitizedRow = array_map(function ($field) {
                  return str_replace(["\r\n", "\n", "\r"], ' ', $field);
            }, $row);
            // Process the sanitized row
            Vet::updateOrCreate(['VetID' => $sanitizedRow[0]], [
                  'Practice_Name' => $sanitizedRow[1] ?? null,
                  'Veterinarian_Name' => $sanitizedRow[2] ?? null,
                  'Address_line1' => $sanitizedRow[3] ?? null,
                  'Address_line2' => $sanitizedRow[4] ?? null,
                  'Address_line3' => $sanitizedRow[5] ?? null,
                  'Address_town' => $sanitizedRow[6] ?? null,
                  'Address_state' => $sanitizedRow[7] ?? null,
                  'Address_zip' => $sanitizedRow[8] ?? null,
                  'Phone' => $sanitizedRow[9] ?? null,
            ]);
      }
}
