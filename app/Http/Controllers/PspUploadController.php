<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Client;
use App\Models\Pet;

class PspUploadController extends Controller
{
    public function showForm()
    {
        return view('uploader.upload'); // Make sure this view path is correct
    }

    public function upload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv_file');

        // Attempt to open the file
        if (($handle = fopen($file->getRealPath(), 'r')) !== FALSE) {
            // Truncate the clients table
            DB::table('clients')->truncate();

            // Skip the header row
            fgetcsv($handle);

            while (($row = fgetcsv($handle, 0, ",", "\"")) !== FALSE) {
                // Handle the case where the row might not have all the expected columns
                if (count($row) < 146) {
                    Log::warning('CSV row has fewer columns than expected: ', $row);
                    continue; // Skip processing this row or handle it as needed
                }

                try {
                    // Adjustments for boolean fields
                    $AltCCEmail = filter_var($row[29], FILTER_VALIDATE_BOOLEAN);
                    $AltKeyHolder = filter_var($row[39], FILTER_VALIDATE_BOOLEAN);
                    $Alarmed = filter_var($row[43], FILTER_VALIDATE_BOOLEAN);
                    $KDWhasKey = filter_var($row[46], FILTER_VALIDATE_BOOLEAN);
                    $Emg1CCEmail = filter_var($row[67], FILTER_VALIDATE_BOOLEAN);
                    $Emg1KeyHolder = filter_var($row[77], FILTER_VALIDATE_BOOLEAN);
                    $Emg2KeyHolder = filter_var($row[92], FILTER_VALIDATE_BOOLEAN);
                    $Emg3KeyHolder = filter_var($row[107], FILTER_VALIDATE_BOOLEAN);
                    $RequirePickDrop = filter_var($row[109], FILTER_VALIDATE_BOOLEAN);

                    $BringInMail = filter_var($row[113], FILTER_VALIDATE_BOOLEAN);
                    $BringInNewspaper = filter_var($row[115], FILTER_VALIDATE_BOOLEAN);
                    $TakeOutRubbish = filter_var($row[117], FILTER_VALIDATE_BOOLEAN);
                    $WaterIndoorPlants = filter_var($row[119], FILTER_VALIDATE_BOOLEAN);
                    $WaterOutdoorPlants = filter_var($row[121], FILTER_VALIDATE_BOOLEAN);
                    $AdjustAC = filter_var($row[123], FILTER_VALIDATE_BOOLEAN);
                    $AdjustLights = filter_var($row[125], FILTER_VALIDATE_BOOLEAN);
                    $AdjustCurtains = filter_var($row[127], FILTER_VALIDATE_BOOLEAN);
                    $OtherInstructions = filter_var($row[129], FILTER_VALIDATE_BOOLEAN);
                    $ChargeCardOnFile = filter_var($row[143], FILTER_VALIDATE_BOOLEAN);

                    // Create the client
                    Client::create([
                        'ClientID' => $row[0],
                        'AccountID' => $row[1],
                        'Status' => $row[2],
                        'InvoiceType' => $row[3],
                        'PrimaryStaffID' => $row[4] === '' ? null : intval($row[4]),
                        'StaffFirstName' => $row[5],
                        'StaffLastName' => $row[6],
                        'TeamID' => $row[7] === '' ? null : intval($row[7]),
                        'TeamMembers' => $row[8],
                        'Area' => $row[9],
                        'Type' => $row[10],
                        'DiaryRef' => $row[11],
                        'FirstName' => $row[12],
                        'LastName' => $row[13],
                        'Email' => $row[14],
                        'HomePhone' => $row[15],
                        'WorkPhone' => $row[16],
                        'MobilePhone' => $row[17],
                        'Address1' => $row[18],
                        'Address2' => $row[19],
                        'Address3' => $row[20],
                        'AddressTown' => $row[21],
                        'AddressState' => $row[22],
                        'AddressZip' => $row[23],
                        'Run' => $row[24],
                        'AltFirstName' => $row[25],
                        'AltLastName' => $row[26],
                        'AltRelationship' => $row[27],
                        'AltEmail' => $row[28],
                        'AltCCEmail' => $AltCCEmail,
                        'AltHomePhone' => $row[30],
                        'AltWorkPhone' => $row[31],
                        'AltMobilePhone' => $row[32],
                        'AltAddress1' => $row[33],
                        'AltAddress2' => $row[34],
                        'AltAddress3' => $row[35],
                        'AltAddressTown' => $row[36],
                        'AltAddressState' => $row[37],
                        'AltAddressZip' => $row[38],
                        'AltKeyHolder' => $AltKeyHolder,
                        'AccessDoorImage' => $row[40],
                        'LockBoxCodeAndLocation' => $row[41],
                        'LockBoxImage' => $row[42],
                        'Alarmed' => $Alarmed,
                        'AlarmInstructions' => $row[44],
                        'AlarmImage' => $row[45],
                        'KDWhasKey' => $KDWhasKey,
                        'ParkingSpaceImage' => $row[47],
                        'BuildingAccessInstructions' => $row[48],
                        'AccessKey' => $row[49],
                        'WalkInfoPhoto' => $row[50],
                        'WalkInfoKeySafeInstructions' => $row[51],
                        'WalkInfoDogLeft' => $row[52],
                        'WalkInfoWalkingInfo' => $row[53],
                        'WalkInfoFeedingInfo' => $row[54],
                        'WalkInfoWalkWithOthers' => $row[55],
                        'WalkInfoHarnessPhoto' => $row[56],
                        'WalkInfoImportantInfo' => $row[57],
                        'What3Words' => $row[58],
                        'WalkInfoExtraPhoto1' => $row[59],
                        'WalkInfoExtraPhoto2' => $row[60],
                        'AdminNotes' => $row[61],
                        'StaffNotes' => $row[62],
                        'Emg1FirstName' => $row[63],
                        'Emg1LastName' => $row[64],
                        'Emg1Relationship' => $row[65],
                        'Emg1Email' => $row[66],
                        'Emg1CCEmail' => $Emg1CCEmail,
                        'Emg1HomePhone' => $row[68],
                        'Emg1WorkPhone' => $row[69],
                        'Emg1MobilePhone' => $row[70],
                        'Emg1Address1' => $row[71],
                        'Emg1Address2' => $row[72],
                        'Emg1Address3' => $row[73],
                        'Emg1AddressTown' => $row[74],
                        'Emg1AddressState' => $row[75],
                        'Emg1AddressZip' => $row[76],
                        'Emg1KeyHolder' => $Emg1KeyHolder,
                        'Emg1Notes' => $row[78],
                        'Emg2FirstName' => $row[79],
                        'Emg2LastName' => $row[80],
                        'Emg2Relationship' => $row[81],
                        'Emg2Email' => $row[82],
                        'Emg2HomePhone' => $row[83],
                        'Emg2WorkPhone' => $row[84],
                        'Emg2MobilePhone' => $row[85],
                        'Emg2Address1' => $row[86],
                        'Emg2Address2' => $row[87],
                        'Emg2Address3' => $row[88],
                        'Emg2AddressTown' => $row[89],
                        'Emg2AddressState' => $row[90],
                        'Emg2AddressZip' => $row[91],
                        'Emg2KeyHolder' => $Emg2KeyHolder,
                        'Emg2Notes' => $row[93],
                        'Emg3FirstName' => $row[94],
                        'Emg3LastName' => $row[95],
                        'Emg3Relationship' => $row[96],
                        'Emg3Email' => $row[97],
                        'Emg3HomePhone' => $row[98],
                        'Emg3WorkPhone' => $row[99],
                        'Emg3MobilePhone' => $row[100],
                        'Emg3Address1' => $row[101],
                        'Emg3Address2' => $row[102],
                        'Emg3Address3' => $row[103],
                        'Emg3AddressTown' => $row[104],
                        'Emg3AddressState' => $row[105],
                        'Emg3AddressZip' => $row[106],
                        'Emg3KeyHolder' => $Emg3KeyHolder,
                        'Emg3Notes' => $row[108],
                        'RequirePickDrop' => $RequirePickDrop,
                        'PickupInstructions' => $row[110],
                        'DropOffInstructions' => $row[111],
                        'WetInstructions' => $row[112],
                        'BringInMail' => $BringInMail,
                        'MailInstructions' => $row[114],
                        'BringInNewspaper' => $BringInMail,
                        'NewspaperInstructions' => $row[116],
                        'TakeOutRubbish' => $TakeOutRubbish,
                        'RubbishInstructions' => $row[118],
                        'WaterIndoorPlants' => $WaterIndoorPlants,
                        'IndoorPlantInstructions' => $row[120],
                        'WaterOutdoorPlants' => $WaterOutdoorPlants,
                        'OutdoorPlantInstructions' => $row[122],
                        'AdjustAC' => $AdjustAC,
                        'ACInstructions' => $row[124],
                        'AdjustLights' => $AdjustLights,
                        'LightsInstructions' => $row[126],
                        'AdjustCurtains' => $AdjustCurtains,
                        'CurtainInstructions' => $row[128],
                        'OtherInstructions' => $OtherInstructions,
                        'OtherHouseSitInstructions' => $row[130],
                        'DocsClientReg' => $row[131],
                        'DocsDaycareTaCs' => $row[132],
                        'DocsOffleadTaCs' => $row[133],
                        'DocsWalksTaCs' => $row[134],
                        'DocsBoardingTaCs' => $row[135],
                        'DocsGroomingTaCs' => $row[136],
                        'DocsOLDTaCs' => $row[137],
                        'DocsClientCareTaCs' => $row[138],
                        'DocsDogAssessTaCs' => $row[139],
                        'DocsOtherNameTaCs' => $row[140],
                        'DocsOtherTaCs' => $row[141],
                        'PrefPaymentMethod' => $row[142],
                        'ChargeCardOnFile' => $ChargeCardOnFile,
                        'BillingNotes' => $row[144],
                        'BillingType' => $row[145],

                    ]);
                } catch (\Exception $e) {
                    Log::error("Error inserting client data: {$e->getMessage()}", ['row' => $row]);
                    // Optionally, add error handling or logging here
                }
            }

            fclose($handle);
            return back()->with('success', 'File has been uploaded successfully!');
        } else {
            return back()->with('error', 'Could not open the uploaded file.');
        }
    }


    public function uploadPets(Request $request)
{
    $request->validate([
        'pets_file' => 'required|file|mimes:csv,txt|max:2048',
    ]);

    $file = $request->file('pets_file');

    if (($handle = fopen($file->getRealPath(), 'r')) !== FALSE) {
        // Optionally, truncate the pets table if you want to replace all data
        // DB::table('pets')->truncate();

        fgetcsv($handle); // Skip the header row

        while (($row = fgetcsv($handle, 0, ",", "\"")) !== FALSE) {

            Log::info('CSV Row:', $row);


            try {

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
            } catch (\Exception $e) {
                Log::error("Error inserting pet data: {$e->getMessage()}", ['row' => $row]);
            }
        }

        fclose($handle);
        return back()->with('success', 'Pets CSV uploaded successfully!');
    } else {
        return back()->with('error', 'Could not open the uploaded file.');
    }
}
}
