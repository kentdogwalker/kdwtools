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

      public function getDogImage($dogPhoto, $dogBreed)
      {
            if ($dogPhoto === null) {
                  $breed = strtolower($dogBreed);
                  $breed_images_path = public_path('assets/img/dogs/breeds/');
                  $arr = scandir($breed_images_path);
                  $maxSimilarity = 43;
                  $matching_file = null;

                  foreach ($arr as $value) {
                        similar_text($breed, $value, $similarity);
                        if ($similarity >= $maxSimilarity) {
                              $maxSimilarity = $similarity;
                              $matching_file = $value;
                        }
                  }

                  if (!empty($matching_file)) {
                        $src_image = asset('assets/img/dogs/breeds/' . $matching_file);
                  } else {
                        $src_image = asset('assets/img/dogs/breeds/default.jpg');
                  }
            } else {
                  $src_image = asset('storage/dog-photos/' . $dogPhoto);
            }
            return $src_image;
      }

      public function getRoomImage($name)
      {
            $room = strtolower($name);
            $room_images_path = public_path('assets/img/room-icons/');
            $arr = scandir($room_images_path);
            // dd($arr);
            $maxSimilarity = 60;
            $matching_file = null;

            foreach ($arr as $value) {
                  similar_text($room, $value, $similarity);
                  if ($similarity >= $maxSimilarity) {
                        $maxSimilarity = $similarity;
                        $matching_file = $value;
                  }
            }

            if (!empty($matching_file)) {
                  $src_image = asset('assets/img/room-icons/' . $matching_file);
            } else {
                  $src_image = asset('assets/img/room-icons/vacant-icon.png');
            }
            // dd($src_image);
            return $src_image;
      }

      public function getPetsDisabilitiesIcon($info)
      {
            $src_image = asset('assets/img/room-icons/disabled-yes.png');
            if ($info == '' || $info == null || $info = 'No' || $info == 'no' || $info == false || $info == 0) {
                  $src_image = asset('assets/img/room-icons/disabled-no.png');
            }
            return $src_image;
      }

      public function getPetsAllergiesIcon($info)
      {
            // dd($info);
            $src_image = asset('assets/img/room-icons/allergies-yes.png');
            if ($info == '' || $info == null || $info = 'No' || $info == 'no' || $info == false || $info == 0) {
                  $src_image = asset('assets/img/room-icons/allergies-no.png');
            }
            return $src_image;
      }
}
