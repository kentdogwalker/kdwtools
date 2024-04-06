<?php

namespace App\Services;

use App\Models\Pet;

class PetService
{
      public function createCsvToDb($row)
      {
            $Past = filter_var($row[4], FILTER_VALIDATE_BOOLEAN);
            $DOBEstimated = filter_var($row[17], FILTER_VALIDATE_BOOLEAN);
            $PassedAway = filter_var($row[22], FILTER_VALIDATE_BOOLEAN);
            $HotelFeedTimeAM = filter_var($row[34], FILTER_VALIDATE_BOOLEAN);
            $HotelFeedTimeMid = filter_var($row[35], FILTER_VALIDATE_BOOLEAN);
            $HotelFeedTimePM = filter_var($row[36], FILTER_VALIDATE_BOOLEAN);
            $RequireBoardingService = filter_var($row[87], FILTER_VALIDATE_BOOLEAN);
            $AddVac2 = filter_var($row[114], FILTER_VALIDATE_BOOLEAN);
            $AddVac3 = filter_var($row[118], FILTER_VALIDATE_BOOLEAN);
            $AddVac4 = filter_var($row[122], FILTER_VALIDATE_BOOLEAN);
            $dateOfBirth = \DateTime::createFromFormat('d/m/Y', $row[16]);
            $Incident1Date = \DateTime::createFromFormat('d/m/Y', $row[42]);
            $Incident2Date = \DateTime::createFromFormat('d/m/Y', $row[52]);
            $Vac1Date = \DateTime::createFromFormat('d/m/Y', $row[112]);
            $Vac2Date = \DateTime::createFromFormat('d/m/Y', $row[116]);
            $Vac3Date = \DateTime::createFromFormat('d/m/Y', $row[120]);
            $Vac4Date = \DateTime::createFromFormat('d/m/Y', $row[124]);

            $existingPet = self::getExistingPet($row, $Past);
            if (!$existingPet) {
                  Pet::create([
                        'ClientID' => $row[0],
                        'AccountID' => $row[1],
                        'VetID' => $row[2] === '' ? null : intval($row[2]),
                        'Past' => $Past,
                        'PrimarySitterFirstName' => $row[4],
                        'PrimarySitterLastName' => $row[5],
                        'PetPhoto' => $row[6],
                        'Name' => $row[7],
                        'Type' => $row[8],
                        'Breed' => $row[9],
                        'Colour' => $row[10],
                        'Weight' => $row[11],
                        'Gender' => $row[12],
                        'Spayed' => $row[13],
                        'Neutered' => $row[14],
                        'NeuteredNotes' => $row[15],
                        'DateOfBirth' => $dateOfBirth ? $dateOfBirth->format('Y-m-d') : null,
                        'DOBEstimated' => $DOBEstimated,
                        'Microchipped' => $row[18],
                        'ChipNumber' => $row[19] === '' ? null : intval($row[19]),
                        'Insured' => $row[20],
                        'InurancePolicy' => $row[21],
                        'PassedAway' => $PassedAway,
                        'FitnessLevel' => $row[23],
                        'HealthConcerns' => $row[24],
                        'Allergies' => $row[25],
                        'AllergiesNotes' => $row[26],
                        'Disabilities' => $row[27],
                        'DisabilitiesNotes' => $row[28],
                        'Illnesses' => $row[29],
                        'IllnessesNotes' => $row[30],
                        'FeedingInstructions' => $row[31],
                        'LocationFood' => $row[32],
                        'FoodImage' => $row[33],
                        'HotelFeedTimeAM' => $HotelFeedTimeAM,
                        'HotelFeedTimeMid' => $HotelFeedTimeMid,
                        'HotelFeedTimePM' => $HotelFeedTimePM,
                        'CurrentMedication' => $row[37],
                        'MedicationNotes' => $row[38],
                        'MedicationImage' => $row[39],
                        'PetNotes' => $row[40],
                        'ClientPetNotes' => $row[41],
                        'Incident1Date' => $Incident1Date ? $Incident1Date->format('Y-m-d') : null,
                        'Incident1Type' => $row[43],
                        'Incident1Severity' => $row[44],
                        'Incident1Desc' => $row[45],
                        'Incident1Picture' => $row[46],
                        'Incident1Form' => $row[47],
                        'Incident1StaffInstructions' => $row[48],
                        'Incident1ReportingStaff' => $row[49],
                        'Incident1ManagementDec' => $row[50],
                        'AddIncident' => $row[51],
                        'Incident2Date' => $Incident2Date ? $Incident2Date->format('Y-m-d') : null,
                        'PermWalkOfflead' => $row[53],
                        'PermOffleadEnviro' => $row[54],
                        'BittenPeople' => $row[55],
                        'BittenPeopleInfo' => $row[56],
                        'Aggression' => $row[57],
                        'AggressionInfo' => $row[58],
                        'BittenDogs' => $row[59],
                        'BittenDogsInfo' => $row[60],
                        'DogAgression' => $row[61],
                        'DogAgressionInfo' => $row[62],
                        'DogSocial' => $row[63],
                        'DogRecall' => $row[64],
                        'DogFears' => $row[65],
                        'DogPulls' => $row[66],
                        'DogPullsInfo' => $row[67],
                        'DogSlipCollar' => $row[68],
                        'DogSlipCollarInfo' => $row[69],
                        'DogChase' => $row[70],
                        'DogChaseInfo' => $row[71],
                        'DogMobility' => $row[72],
                        'DogMobilityInfo' => $row[73],
                        'DogCarSick' => $row[74],
                        'DogCarSickInfo' => $row[75],
                        'DogHidingPlace' => $row[76],
                        'DogHidingPlaceInfo' => $row[77],
                        'Muzzled' => $row[78],
                        'MuzzledInfo' => $row[79],
                        'DogWalkOtherInfo' => $row[80],
                        'BoardOtherDogs' => $row[81],
                        'BoardOtherDogsInfo' => $row[82],
                        'BoardOtherCats' => $row[83],
                        'BoardOtherCatsInfo' => $row[84],
                        'BoardOtherChildren' => $row[85],
                        'BoardOtherChildrenInfo' => $row[86],
                        'RequireBoardingService' => $RequireBoardingService,
                        'DogSleepLocation' => $row[88],
                        'DogSpecialNeeds' => $row[89],
                        'DogSpecialNeedsInfo' => $row[90],
                        'WalkFreq' => $row[91],
                        'DogFearsHome' => $row[92],
                        'DogFearsHomeInfo' => $row[93],
                        'DogChew' => $row[94],
                        'DogChewInfo' => $row[95],
                        'FoodAgression' => $row[96],
                        'FoodAgressionInfo' => $row[97],
                        'HouseTrained' => $row[98],
                        'HouseTrainedInfo' => $row[99],
                        'ExcessiveBarking' => $row[100],
                        'ExcessiveBarkingInfo' => $row[101],
                        'SeparationAnx' => $row[102],
                        'SeparationAnxInfo' => $row[103],
                        'AllowedOnFurniture' => $row[104],
                        'AllowedUpstairs' => $row[105],
                        'AllowedOnBeds' => $row[106],
                        'DogDigging' => $row[107],
                        'CrateTrained' => $row[108],
                        'UsualWakeTime' => $row[109],
                        'UsualBedTime' => $row[110],
                        'Vac1' => $row[111],
                        'Vac1Date' => $Vac1Date ? $Vac1Date->format('Y-m-d') : null,
                        'Vac1Cert' => $row[113],
                        'AddVac2' => $AddVac2,
                        'Vac2' => $row[115],
                        'Vac2Date' => $Vac2Date ? $Vac1Date->format('Y-m-d') : null,
                        'Vac2Cert' => $row[117],
                        'AddVac3' => $AddVac3,
                        'Vac3' => $row[119],
                        'Vac3Date' => $Vac3Date ? $Vac1Date->format('Y-m-d') : null,
                        'Vac3Cert' => $row[121],
                        'AddVac4' => $AddVac4,
                        'Vac4' => $row[123],
                        'Vac4Date' => $Vac4Date ? $Vac1Date->format('Y-m-d') : null,
                        'Vac4Cert' => $row[125],
                        'GroomingNotes' => $row[126],
                        'GroomingTime' => $row[127],
                        'GroomingPhoto' => $row[128],
                        'GroomingOwnerSpecifics' => $row[129],
                        'GroomingPriceCharged' => $row[130],
                        'GroomingTandCs' => $row[131],
                        'XLBullyExemption' => $row[132],
                  ]);
            }
      }

      public function getExistingPet($row, $past)
      {
            $vetID = $row[2] === '' ? null : intval($row[2]);
            return Pet::where('ClientID', $row[0])
                  ->where('AccountID', $row[1])
                  ->where('VetID', $vetID)
                  ->where('Past', $past)
                  ->where('Name', $row[7])
                  ->where('Type', $row[8])
                  ->where('Breed', $row[9])
                  ->where('Colour', $row[10])
                  ->where('Weight', $row[11])
                  ->where('Gender', $row[12])
                  ->where('Spayed', $row[13])
                  ->where('Neutered', $row[14])
                  ->first();
      }
}
