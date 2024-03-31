<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Client;
use App\Models\Pet;
use App\Models\Vet;
use League\Csv\Reader;
use League\Csv\Statement;

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

        $csvFile = $request->file('csv_file')->getRealPath();

        try {
            $csv = Reader::createFromPath($csvFile, 'r');
            $csv->setHeaderOffset(0); // Assumes the first record in your CSV is the header
            $csv->setDelimiter(',');
            $csv->setEnclosure('"');
            // No escape character needed based on your CSV's characteristics



            // Fetch the header row and manually handle duplicates
            $headers = $csv->fetchOne(); // Fetches the first row of the CSV

            $uniqueHeaders = [];

            foreach ($headers as $index => $header) {
                $counter = 1;
                $newHeader = $header;
                while (in_array($newHeader, $uniqueHeaders)) {
                    $newHeader = $header . '_' . $counter;
                    $counter++;
                }
                $uniqueHeaders[] = $newHeader;
            }

            // Skipping the actual header row in further processing
            $records = (new Statement())->offset(1)->process($csv);


            DB::table('clients')->truncate(); // Truncate (i.e remove everything from) the clients table


            foreach ($records as $row) {
                if(count($row) !== count($uniqueHeaders)){
                    // Log warning if row and headers count do not match
                    Log::warning("CSV row and headers count mismatch", ['row' => $row]);
                    continue; // Skip to next record
                }

                $record = array_combine($uniqueHeaders, $row);
                // Adjust boolean fields as necessary
                $record['AltCCEmail'] = filter_var($record['AltCCEmail'], FILTER_VALIDATE_BOOLEAN);
                $record['AltKeyHolder'] = filter_var($record['AltKeyHolder'], FILTER_VALIDATE_BOOLEAN);
                $record['Alarmed'] = filter_var($record['Alarmed'], FILTER_VALIDATE_BOOLEAN);
                $record['KDWhasKey'] = filter_var($record['KDWhasKey'], FILTER_VALIDATE_BOOLEAN);
                $record['Emg1CCEmail'] = filter_var($record['Emg1CCEmail'], FILTER_VALIDATE_BOOLEAN);
                $record['Emg1KeyHolder'] = filter_var($record['Emg1KeyHolder'], FILTER_VALIDATE_BOOLEAN);
                $record['Emg2KeyHolder'] = filter_var($record['Emg2KeyHolder'], FILTER_VALIDATE_BOOLEAN);
                $record['Emg3KeyHolder'] = filter_var($record['Emg3KeyHolder'], FILTER_VALIDATE_BOOLEAN);
                $record['RequirePickDrop'] = filter_var($record['RequirePickDrop'], FILTER_VALIDATE_BOOLEAN);
                $record['BringInMail'] = filter_var($record['BringInMail'], FILTER_VALIDATE_BOOLEAN);
                $record['BringInNewspaper'] = filter_var($record['BringInNewspaper'], FILTER_VALIDATE_BOOLEAN);
                $record['TakeOutRubbish'] = filter_var($record['TakeOutRubbish'], FILTER_VALIDATE_BOOLEAN);
                $record['WaterIndoorPlants'] = filter_var($record['WaterIndoorPlants'], FILTER_VALIDATE_BOOLEAN);
                $record['WaterOutdoorPlants'] = filter_var($record['WaterOutdoorPlants'], FILTER_VALIDATE_BOOLEAN);
                $record['AdjustAC'] = filter_var($record['AdjustAC'], FILTER_VALIDATE_BOOLEAN);
                $record['AdjustLights'] = filter_var($record['AdjustLights'], FILTER_VALIDATE_BOOLEAN);
                $record['AdjustCurtains'] = filter_var($record['AdjustCurtains'], FILTER_VALIDATE_BOOLEAN);
                $record['OtherInstructions'] = filter_var($record['OtherInstructions'], FILTER_VALIDATE_BOOLEAN);
                $record['ChargeCardOnFile'] = filter_var($record['ChargeCardOnFile'], FILTER_VALIDATE_BOOLEAN);
                // Continue adjusting and handling other fields similarly

                Client::create([
                    'ClientID' => $record['ClientID'],
                    'AccountID' => $record['AccountID'],
                    'Status' => $record['Status'],
                    'InvoiceType' => $record['InvoiceType'],
                    'PrimaryStaffID' => $record['PrimaryStaffID'],
                    'StaffFirstName' => $record['StaffFirstName'],
                    'StaffLastName' => $record['StaffLastName'],
                    'TeamID' => $record['TeamID'],
                    'TeamMembers' => $record['TeamMembers'],
                    'Area' => $record['Area'],
                    'Type' => $record['Type'],
                    'DiaryRef' => $record['DiaryRef'],
                    'FirstName' => $record['FirstName'],
                    'LastName' => $record['LastName'],
                    'Email' => $record['Email'],
                    'HomePhone' => $record['HomePhone'],
                    'WorkPhone' => $record['WorkPhone'],
                    'MobilePhone' => $record['MobilePhone'],
                    'Address1' => $record['Address1'],
                    'Address2' => $record['Address2'],
                    'Address3' => $record['Address3'],
                    'AddressTown' => $record['AddressTown'],
                    'AddressState' => $record['AddressState'],
                    'AddressZip' => $record['AddressZip'],
                    'Run' => $record['Run'],
                    'AltFirstName' => $record['AltFirstName'],
                    'AltLastName' => $record['AltLastName'],
                    'AltRelationship' => $record['AltRelationship'],
                    'AltEmail' => $record['AltEmail'],
                    'AltHomePhone' => $record['AltHomePhone'],
                    'AltWorkPhone' => $record['AltWorkPhone'],
                    'AltMobilePhone' => $record['AltMobilePhone'],
                    'AltAddress1' => $record['AltAddress1'],
                    'AltAddress2' => $record['AltAddress2'],
                    'AltAddress3' => $record['AltAddress3'],
                    'AltAddressTown' => $record['AltAddressTown'],
                    'AltAddressState' => $record['AltAddressState'],
                    'AltAddressZip' => $record['AltAddressZip'],
                    'AccessDoorImage' => $record['AccessDoorImage'],
                    'LockBoxCodeAndLocation' => $record['LockBoxCodeAndLocation'],
                    'LockBoxImage' => $record['LockBoxImage'],
                    'AlarmInstructions' => $record['AlarmInstructions'],
                    'AlarmImage' => $record['AlarmImage'],
                    'ParkingSpaceImage' => $record['ParkingSpaceImage'],
                    'BuildingAccessInstructions' => $record['BuildingAccessInstructions'],
                    'AccessKey' => $record['AccessKey'],
                    'WalkInfoPhoto' => $record['WalkInfoPhoto'],
                    'WalkInfoKeySafeInstructions' => $record['WalkInfoKeySafeInstructions'],
                    'WalkInfoDogLeft' => $record['WalkInfoDogLeft'],
                    'WalkInfoWalkingInfo' => $record['WalkInfoWalkingInfo'],
                    'WalkInfoFeedingInfo' => $record['WalkInfoFeedingInfo'],
                    'WalkInfoWalkWithOthers' => $record['WalkInfoWalkWithOthers'],
                    'WalkInfoHarnessPhoto' => $record['WalkInfoHarnessPhoto'],
                    'WalkInfoImportantInfo' => $record['WalkInfoImportantInfo'],
                    'What3Words' => $record['What3Words'],
                    'WalkInfoExtraPhoto1' => $record['WalkInfoExtraPhoto1'],
                    'WalkInfoExtraPhoto2' => $record['WalkInfoExtraPhoto2'],
                    'AdminNotes' => $record['AdminNotes'],
                    'StaffNotes' => $record['StaffNotes'],
                    'Emg1FirstName' => $record['Emg1FirstName'],
                    'Emg1LastName' => $record['Emg1LastName'],
                    'Emg1Relationship' => $record['Emg1Relationship'],
                    'Emg1Email' => $record['Emg1Email'],
                    'Emg1HomePhone' => $record['Emg1HomePhone'],
                    'Emg1WorkPhone' => $record['Emg1WorkPhone'],
                    'Emg1MobilePhone' => $record['Emg1MobilePhone'],
                    'Emg1Address1' => $record['Emg1Address1'],
                    'Emg1Address2' => $record['Emg1Address2'],
                    'Emg1Address3' => $record['Emg1Address3'],
                    'Emg1AddressTown' => $record['Emg1AddressTown'],
                    'Emg1AddressState' => $record['Emg1AddressState'],
                    'Emg1AddressZip' => $record['Emg1AddressZip'],
                    'Emg1Notes' => $record['Emg1Notes'],
                    'Emg2FirstName' => $record['Emg2FirstName'],
                    'Emg2LastName' => $record['Emg2LastName'],
                    'Emg2Relationship' => $record['Emg2Relationship'],
                    'Emg2Email' => $record['Emg2Email'],
                    'Emg2HomePhone' => $record['Emg2HomePhone'],
                    'Emg2WorkPhone' => $record['Emg2WorkPhone'],
                    'Emg2MobilePhone' => $record['Emg2MobilePhone'],
                    'Emg2Address1' => $record['Emg2Address1'],
                    'Emg2Address2' => $record['Emg2Address2'],
                    'Emg2Address3' => $record['Emg2Address3'],
                    'Emg2AddressTown' => $record['Emg2AddressTown'],
                    'Emg2AddressState' => $record['Emg2AddressState'],
                    'Emg2AddressZip' => $record['Emg2AddressZip'],
                    'Emg2Notes' => $record['Emg2Notes'],
                    'Emg3FirstName' => $record['Emg3FirstName'],
                    'Emg3LastName' => $record['Emg3LastName'],
                    'Emg3Relationship' => $record['Emg3Relationship'],
                    'Emg3Email' => $record['Emg3Email'],
                    'Emg3HomePhone' => $record['Emg3HomePhone'],
                    'Emg3WorkPhone' => $record['Emg3WorkPhone'],
                    'Emg3MobilePhone' => $record['Emg3MobilePhone'],
                    'Emg3Address1' => $record['Emg3Address1'],
                    'Emg3Address2' => $record['Emg3Address2'],
                    'Emg3Address3' => $record['Emg3Address3'],
                    'Emg3AddressTown' => $record['Emg3AddressTown'],
                    'Emg3AddressState' => $record['Emg3AddressState'],
                    'Emg3AddressZip' => $record['Emg3AddressZip'],
                    'Emg3Notes' => $record['Emg3Notes'],
                    'PickupInstructions' => $record['PickupInstructions'],
                    'DropOffInstructions' => $record['DropOffInstructions'],
                    'WetInstructions' => $record['WetInstructions'],
                    'MailInstructions' => $record['MailInstructions'],
                    'NewspaperInstructions' => $record['NewspaperInstructions'],
                    'RubbishInstructions' => $record['RubbishInstructions'],
                    'IndoorPlantInstructions' => $record['IndoorPlantInstructions'],
                    'OutdoorPlantInstructions' => $record['OutdoorPlantInstructions'],
                    'ACInstructions' => $record['ACInstructions'],
                    'LightsInstructions' => $record['LightsInstructions'],
                    'CurtainInstructions' => $record['CurtainInstructions'],
                    'OtherHouseSitInstructions' => $record['OtherHouseSitInstructions'],
                    'DocsClientReg' => $record['DocsClientReg'],
                    'DocsDaycareTaCs' => $record['DocsDaycareTaCs'],
                    'DocsOffleadTaCs' => $record['DocsOffleadTaCs'],
                    'DocsWalksTaCs' => $record['DocsWalksTaCs'],
                    'DocsBoardingTaCs' => $record['DocsBoardingTaCs'],
                    'DocsGroomingTaCs' => $record['DocsGroomingTaCs'],
                    'DocsOLDTaCs' => $record['DocsOLDTaCs'],
                    'DocsClientCareTaCs' => $record['DocsClientCareTaCs'],
                    'DocsDogAssessTaCs' => $record['DocsDogAssessTaCs'],
                    'DocsOtherNameTaCs' => $record['DocsOtherNameTaCs'],
                    'DocsOtherTaCs' => $record['DocsOtherTaCs'],
                    'PrefPaymentMethod' => $record['PrefPaymentMethod'],
                    'BillingNotes' => $record['BillingNotes'],
                    'BillingType' => $record['BillingType'],
                    // Map other fields from $record as necessary
                ]);
            }
        } catch (\Exception $e) {
            Log::error("Error processing CSV import: {$e->getMessage()}");
            return back()->with('error', 'There was an issue processing your CSV file.');
        }

        return back()->with('success', 'File has been uploaded successfully!');

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




public function uploadVets(Request $request)
{
    $file = $request->file('vets_csv')->getRealPath(); // Get the real path to the file

    try {
        // Open and read the CSV
        if (($handle = fopen($file, 'r')) !== false) {
            // Skip the header row
            fgetcsv($handle);

            while (($row = fgetcsv($handle, 0, ",", '"')) !== false) { // Ensuring encapsulation handling
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

            fclose($handle);
        }
    } catch (\Exception $e) {
        // Log any exceptions to the Laravel log file
        Log::error('Error importing vets CSV: ' . $e->getMessage());

        // Optionally, return an error response or redirect back with an error message
        return back()->with('error', 'An error occurred while importing the CSV. Please check the Laravel log for details.');
    }

    return back()->with('success', 'Vets imported successfully.');
}





}
