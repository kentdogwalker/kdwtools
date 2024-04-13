<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\UploadedDate;

class UploadedService
{
      public function getInformation($id)
      {
            $data = UploadedDate::find($id);
            $class = 'text-danger';
            $info = "WARNING: No data stored. Upload now!";
            if ($data) {
                  if ($data->status === 'Not Yet') {
                        $info = "WARNING: No data stored. Upload now!";
                  } else {
                        $info = $this->getDisplayText($data->updated_at, $data->status);
                        $class = $this->getTextColor($data->updated_at);
                  }
            }

            return [
                  'info' => $info,
                  'class' => $class
            ];
      }

      private function getDisplayText($lastUpdated, $status)
      {
            $now = Carbon::now();
            $diffInDays = $lastUpdated->diffInDays($now);

            if ($diffInDays == 0) {
                  return $status . " Today at " . $lastUpdated->format('H:i');
            } elseif ($diffInDays == 1) {
                  return $status . " Yesterday at " . $lastUpdated->format('H:i');
            } elseif ($diffInDays < 7) {
                  return $status . ' ' . $lastUpdated->translatedFormat('l') . " at " . $lastUpdated->format('H:i');
            } else {
                  return $status . ' ' . $lastUpdated->format('l j F Y') . " at " . $lastUpdated->format('H:i');
            }
      }

      private function getTextColor($lastUpdated)
      {
            $now = Carbon::now();
            $diffInHours = $lastUpdated->diffInHours($now);

            if ($diffInHours > 48) {
                  return 'text-danger';
            } elseif ($diffInHours >= 24 && $diffInHours <= 48) {
                  return 'text-warning';
            } else {
                  return 'text-success';
            }
      }

      public function createOrUpdateData($name)
      {
            $data = UploadedDate::where('name_of_import', $name)->first();
            if ($data) {
                  $status = $data->status === 'Not Yet' ? 'Created' : 'Updated';
                  $data->update([
                        'status' => $status
                  ]);
            } else {
                  UploadedDate::create([
                        'name_of_import' => $name,
                        'status' => 'Not Yet'
                  ]);
            }
      }
}
