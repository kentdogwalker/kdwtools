<?php

namespace App\Services;

class ImageService
{

      public function getImageName($name, $file)
      {

            $imageName = $name . '-' . time() . '.' . $file->extension();
            return $imageName;
      }

      public function uploadImage($file, $imageName, $folder)
      {
            $file->storeAs($folder, $imageName, 'public');
      }
}
