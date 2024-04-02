<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Client;
use App\Models\Pet;
use App\Models\Vet;
use App\Services\CsvToArray;
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
        $csvService = new CsvToArray;
        $records = $csvService->csvToArray($csvFile);
        try {

            DB::table('clients')->truncate(); // Truncate (i.e remove everything from) the clients table

            foreach ($records as $record) {
                // Adjust boolean fields as necessary
                $AltCCEmail = filter_var($record["CC Emails [Spouse / Alternative Contact-Client Details]"], FILTER_VALIDATE_BOOLEAN);
                $AltKeyHolder = filter_var($record["Does this contact hold a key to your home? [Spouse / Alternative Contact-Client Details]"], FILTER_VALIDATE_BOOLEAN);
                $Alarmed = filter_var($record["Is your property alarmed? [Access to Property-Access to Property]"], FILTER_VALIDATE_BOOLEAN);
                $KDWhasKey = filter_var($record["Does KDW have a key? [Access to Property-Access to Property]"], FILTER_VALIDATE_BOOLEAN);
                $Emg1CCEmail = filter_var($record["CC Emails [Emergency Contact 1-Emergency Contacts]"], FILTER_VALIDATE_BOOLEAN);
                $Emg1KeyHolder = filter_var($record["Does this contact hold a key to your home? [Emergency Contact 1-Emergency Contacts]"], FILTER_VALIDATE_BOOLEAN);
                $Emg2KeyHolder = filter_var($record["Does this contact hold a key to your home? [Emergency Contact 2-Emergency Contacts]"], FILTER_VALIDATE_BOOLEAN);
                $Emg3KeyHolder = filter_var($record["Does this contact hold a key to your home? [Emergency Contact 3-Emergency Contacts]"], FILTER_VALIDATE_BOOLEAN);
                $RequirePickDrop = filter_var($record["If you do not need our pick up and drop off service, check this box [Pick Up & Drop Off-Pick Up & Drop Off]"], FILTER_VALIDATE_BOOLEAN);
                $BringInMail = filter_var($record["Bring in Mail? [House Sitting Questions-House Sitting]"], FILTER_VALIDATE_BOOLEAN);
                $BringInNewspaper = filter_var($record["Bring in Newspaper? [House Sitting Questions-House Sitting]"], FILTER_VALIDATE_BOOLEAN);
                $TakeOutRubbish = filter_var($record["Take out the Rubbish? [House Sitting Questions-House Sitting]"], FILTER_VALIDATE_BOOLEAN);
                $WaterIndoorPlants = filter_var($record["Water Indoor Plants? [House Sitting Questions-House Sitting]"], FILTER_VALIDATE_BOOLEAN);
                $WaterOutdoorPlants = filter_var($record["Water Outdoor Plants? [House Sitting Questions-House Sitting]"], FILTER_VALIDATE_BOOLEAN);
                $AdjustAC = filter_var($record["Adjust AC / Heating? [House Sitting Questions-House Sitting]"], FILTER_VALIDATE_BOOLEAN);
                $AdjustLights = filter_var($record["Adjust Lighting? [House Sitting Questions-House Sitting]"], FILTER_VALIDATE_BOOLEAN);
                $AdjustCurtains = filter_var($record["Adjust Curtains / Blinds? [House Sitting Questions-House Sitting]"], FILTER_VALIDATE_BOOLEAN);
                $OtherInstructions = filter_var($record["Other Instructions? [House Sitting Questions-House Sitting]"], FILTER_VALIDATE_BOOLEAN);
                $ChargeCardOnFile = filter_var($record["Charge Card on File? [Billing-Billing & Profile]"], FILTER_VALIDATE_BOOLEAN);
                // Continue adjusting and handling other fields similarly

                Client::create([
                    'ClientID' => $record["ClientID"],
                    'AccountID' => $record["AccountID"],
                    'Status' => $record["Status"],
                    'InvoiceType' => $record["Invoice Type"],
                    'PrimaryStaffID' => $record["PrimaryStaffID"] === '' ? null : intval($record["PrimaryStaffID"]),
                    'StaffFirstName' => $record["Staff FirstName"],
                    'StaffLastName' => $record["Staff LastName"],
                    'TeamID' => $record["TeamID"] === '' ? null : intval($record["TeamID"]),
                    'TeamMembers' => $record["Team Members"],
                    'Area' => $record["Area"],
                    'Type' => $record["Type"],
                    'DiaryRef' => $record["Schedule/Diary Ref [Alias-Client Details]"],
                    'FirstName' => $record["First Name [Main Contact-Client Details]"],
                    'LastName' => $record["Last Name [Main Contact-Client Details]"],
                    'Email' => $record["Email (Used for Login) [Main Contact-Client Details]"],
                    'HomePhone' => substr($record["Home Phone [Main Contact-Client Details]"], 0, 25),
                    'WorkPhone' => substr($record["Work Phone [Main Contact-Client Details]"], 0, 25),
                    'MobilePhone' => substr($record["Mobile Phone [Main Contact-Client Details]"], 0, 25),
                    'Address1' => $record["Address-line1 [Main Contact-Client Details]"],
                    'Address2' => $record["Address-line2 [Main Contact-Client Details]"],
                    'Address3' => $record["Address-line3 [Main Contact-Client Details]"],
                    'AddressTown' => $record["Address-town [Main Contact-Client Details]"],
                    'AddressState' => $record["Address-state [Main Contact-Client Details]"],
                    'AddressZip' => substr($record["Address-zip [Main Contact-Client Details]"], 0, 10),
                    'Run' => $record["Run [Main Contact-Client Details]"],
                    'AltFirstName' => $record["First Name [Spouse / Alternative Contact-Client Details]"],
                    'AltLastName' => $record["Last Name [Spouse / Alternative Contact-Client Details]"],
                    'AltRelationship' => $record["Relationship to you? [Spouse / Alternative Contact-Client Details]"],
                    'AltEmail' => $record["Email [Spouse / Alternative Contact-Client Details]"],
                    'AltCCEmail' => $AltCCEmail,
                    'AltHomePhone' => substr($record["Home Phone [Spouse / Alternative Contact-Client Details]"], 0, 20),
                    'AltWorkPhone' => substr($record["Work Phone [Spouse / Alternative Contact-Client Details]"], 0, 20),
                    'AltMobilePhone' => substr($record["Mobile Phone [Spouse / Alternative Contact-Client Details]"], 0, 20),
                    'AltAddress1' => $record["Address-line1 [Spouse / Alternative Contact-Client Details]"],
                    'AltAddress2' => $record["Address-line2 [Spouse / Alternative Contact-Client Details]"],
                    'AltAddress3' => $record["Address-line3 [Spouse / Alternative Contact-Client Details]"],
                    'AltAddressTown' => $record["Address-town [Spouse / Alternative Contact-Client Details]"],
                    'AltAddressState' => $record["Address-state [Spouse / Alternative Contact-Client Details]"],
                    'AltAddressZip' => $record["Address-zip [Spouse / Alternative Contact-Client Details]"],
                    'AltKeyHolder' => $AltKeyHolder,
                    'AccessDoorImage' => $record["Access Door [Access to Property-Access to Property]"],
                    'LockBoxCodeAndLocation' => $record["Lock Box Code and Location [Access to Property-Access to Property]"],
                    'LockBoxImage' => $record["Lock Box Image [Access to Property-Access to Property]"],
                    'Alarmed' => $Alarmed,
                    'AlarmInstructions' => $record["Alarm Instructions [Access to Property-Access to Property]"],
                    'AlarmImage' => $record["Alarm Image [Access to Property-Access to Property]"],
                    'KDWhasKey' => $KDWhasKey,
                    'ParkingSpaceImage' => $record["Parking space image [Access to Property-Access to Property]"],
                    'BuildingAccessInstructions' => $record["Gated Community and / or Building Access Instructions [Access to Property-Access to Property]"],
                    'AccessKey' => $record["Access key [Keys-Access to Property]"],
                    'WalkInfoPhoto' => $record["Photo [Walk info-Dog Walking Guide]"],
                    'WalkInfoKeySafeInstructions' => $record["Key or Key safe [Walk info-Dog Walking Guide]"],
                    'WalkInfoDogLeft' => $record["Where the dog is kept/should be left  [Walk info-Dog Walking Guide]"],
                    'WalkInfoWalkingInfo' => $record["Walking info [Walk info-Dog Walking Guide]"],
                    'WalkInfoFeedingInfo' => $record["Feeding info [Walk info-Dog Walking Guide]"],
                    'WalkInfoWalkWithOthers' => $record["Can they be walked with other dogs? [Walk info-Dog Walking Guide]"],
                    'WalkInfoHarnessPhoto' => $record["Harness/collar photos [Walk info-Dog Walking Guide]"],
                    'WalkInfoImportantInfo' => $record["Important info [Walk info-Dog Walking Guide]"],
                    'What3Words' => $record["What 3 Words location [Walk info-Dog Walking Guide]"],
                    'WalkInfoExtraPhoto1' => $record["Extra relevant photo [Walk info-Dog Walking Guide]_1"],
                    'WalkInfoExtraPhoto2' => $record["Extra relevant photo [Walk info-Dog Walking Guide]"],
                    'AdminNotes' => $record["Admin Notes [INTERNAL ADMIN NOTES-Notes]"],
                    'StaffNotes' => $record["Staff Notes [STAFF NOTES-Notes]"],
                    'Emg1FirstName' => $record["First Name [Emergency Contact 1-Emergency Contacts]"],
                    'Emg1LastName' => $record["Last Name [Emergency Contact 1-Emergency Contacts]"],
                    'Emg1Relationship' => $record["Relationship to you? [Emergency Contact 1-Emergency Contacts]"],
                    'Emg1Email' => $record["Email Address [Emergency Contact 1-Emergency Contacts]"],
                    'Emg1CCEmail' => $Emg1CCEmail,
                    'Emg1HomePhone' => substr($record["Home Phone [Emergency Contact 1-Emergency Contacts]"], 0, 25),
                    'Emg1WorkPhone' => substr($record["Work Phone [Emergency Contact 1-Emergency Contacts]"], 0, 25),
                    'Emg1MobilePhone' => substr($record["Mobile Phone [Emergency Contact 1-Emergency Contacts]"], 0, 25),
                    'Emg1Address1' => $record["Address-line1 [Emergency Contact 1-Emergency Contacts]"],
                    'Emg1Address2' => $record["Address-line2 [Emergency Contact 1-Emergency Contacts]"],
                    'Emg1Address3' => $record["Address-line3 [Emergency Contact 1-Emergency Contacts]"],
                    'Emg1AddressTown' => $record["Address-town [Emergency Contact 1-Emergency Contacts]"],
                    'Emg1AddressState' => $record["Address-state [Emergency Contact 1-Emergency Contacts]"],
                    'Emg1AddressZip' => $record["Address-zip [Emergency Contact 1-Emergency Contacts]"],
                    'Emg1KeyHolder' => $Emg1KeyHolder,
                    'Emg1Notes' => $record["Notes (Public) [Emergency Contact 1-Emergency Contacts]"],
                    'Emg2FirstName' => $record["First Name [Emergency Contact 2-Emergency Contacts]"],
                    'Emg2LastName' => $record["Last Name [Emergency Contact 2-Emergency Contacts]"],
                    'Emg2Relationship' => $record["Relationship to you? [Emergency Contact 2-Emergency Contacts]"],
                    'Emg2Email' => $record["Email Address [Emergency Contact 2-Emergency Contacts]"],
                    'Emg2HomePhone' => substr($record["Home Phone [Emergency Contact 2-Emergency Contacts]"], 0, 25),
                    'Emg2WorkPhone' => substr($record["Work Phone [Emergency Contact 2-Emergency Contacts]"], 0, 25),
                    'Emg2MobilePhone' => substr($record["Mobile Phone [Emergency Contact 2-Emergency Contacts]"], 0, 25),
                    'Emg2Address1' => $record["Address-line1 [Emergency Contact 2-Emergency Contacts]"],
                    'Emg2Address2' => $record["Address-line2 [Emergency Contact 2-Emergency Contacts]"],
                    'Emg2Address3' => $record["Address-line3 [Emergency Contact 2-Emergency Contacts]"],
                    'Emg2AddressTown' => $record["Address-town [Emergency Contact 2-Emergency Contacts]"],
                    'Emg2AddressState' => $record["Address-state [Emergency Contact 2-Emergency Contacts]"],
                    'Emg2AddressZip' => $record["Address-zip [Emergency Contact 2-Emergency Contacts]"],
                    'Emg2KeyHolder' => $Emg2KeyHolder,
                    'Emg2Notes' => $record["Notes (Public) [Emergency Contact 2-Emergency Contacts]"],
                    'Emg3FirstName' => $record["First Name [Emergency Contact 3-Emergency Contacts]"],
                    'Emg3LastName' => $record["Last Name [Emergency Contact 3-Emergency Contacts]"],
                    'Emg3Relationship' => $record["Relationship to you? [Emergency Contact 3-Emergency Contacts]"],
                    'Emg3Email' => $record["Email Address [Emergency Contact 3-Emergency Contacts]"],
                    'Emg3HomePhone' => substr($record["Home Phone [Emergency Contact 3-Emergency Contacts]"], 0, 25),
                    'Emg3WorkPhone' => substr($record["Work Phone [Emergency Contact 3-Emergency Contacts]"], 0, 25),
                    'Emg3MobilePhone' => substr($record["Mobile Phone [Emergency Contact 3-Emergency Contacts]"], 0, 25),
                    'Emg3Address1' => $record["Address-line1 [Emergency Contact 3-Emergency Contacts]"],
                    'Emg3Address2' => $record["Address-line2 [Emergency Contact 3-Emergency Contacts]"],
                    'Emg3Address3' => $record["Address-line3 [Emergency Contact 3-Emergency Contacts]"],
                    'Emg3AddressTown' => $record["Address-town [Emergency Contact 3-Emergency Contacts]"],
                    'Emg3AddressState' => $record["Address-state [Emergency Contact 3-Emergency Contacts]"],
                    'Emg3AddressZip' => $record["Address-zip [Emergency Contact 3-Emergency Contacts]"],
                    'Emg3KeyHolder' => $Emg3KeyHolder,
                    'Emg3Notes' => $record["Notes (Public) [Emergency Contact 3-Emergency Contacts]"],
                    'RequirePickDrop' => $RequirePickDrop,
                    'PickupInstructions' => $record["Is there anything we should know about picking up or dropping off your dog? [Pick Up & Drop Off-Pick Up & Drop Off]"],
                    'DropOffInstructions' => $record["Is there anywhere specific we should leave your dog if you're not home? [Pick Up & Drop Off-Pick Up & Drop Off]"],
                    'WetInstructions' => $record["If wet, do you want us to leave your dog somewhere different? [Pick Up & Drop Off-Pick Up & Drop Off]"],
                    'BringInMail' => $BringInMail,
                    'MailInstructions' => $record["Mail instructions [House Sitting Questions-House Sitting]"],
                    'BringInNewspaper' => $BringInNewspaper,
                    'NewspaperInstructions' => $record["Newspaper instructions [House Sitting Questions-House Sitting]"],
                    'TakeOutRubbish' => $TakeOutRubbish,
                    'RubbishInstructions' => $record["Rubbish instructions [House Sitting Questions-House Sitting]"],
                    'WaterIndoorPlants' => $WaterIndoorPlants,
                    'IndoorPlantInstructions' => $record["Watering inside instructions [House Sitting Questions-House Sitting]"],
                    'WaterOutdoorPlants' => $WaterOutdoorPlants,
                    'OutdoorPlantInstructions' => $record["Watering outside instructions [House Sitting Questions-House Sitting]"],
                    'AdjustAC' => $AdjustAC,
                    'ACInstructions' => $record["AC/Heating instructions [House Sitting Questions-House Sitting]"],
                    'AdjustLights' => $AdjustLights,
                    'LightsInstructions' => $record["Lighting instructions [House Sitting Questions-House Sitting]"],
                    'AdjustCurtains' => $AdjustCurtains,
                    'CurtainInstructions' => $record["Curtains/blinds instructions [House Sitting Questions-House Sitting]"],
                    'OtherInstructions' => $OtherInstructions,
                    'OtherHouseSitInstructions' => $record["Instructions [House Sitting Questions-House Sitting]"],
                    'DocsClientReg' => $record["Client Registration Form [Contracts & Forms-Contracts & Forms]"],
                    'DocsDaycareTaCs' => $record["Terms & Conditions: Daycare [Contracts & Forms-Contracts & Forms]"],
                    'DocsOffleadTaCs' => $record["Terms & Conditions: Off-Lead [Contracts & Forms-Contracts & Forms]"],
                    'DocsWalksTaCs' => $record["Terms & Conditions: Walks & Visits [Contracts & Forms-Contracts & Forms]"],
                    'DocsBoardingTaCs' => $record["Terms & Conditions: Boarding [Contracts & Forms-Contracts & Forms]"],
                    'DocsGroomingTaCs' => $record["Terms & Conditions: Grooming [Contracts & Forms-Contracts & Forms]"],
                    'DocsOLDTaCs' => $record["Terms & Conditions (OLD) [Contracts & Forms-Contracts & Forms]"],
                    'DocsClientCareTaCs' => $record["Client Care Instructions [Contracts & Forms-Contracts & Forms]"],
                    'DocsDogAssessTaCs' => $record["Dog Assessment Form [Contracts & Forms-Contracts & Forms]"],
                    'DocsOtherNameTaCs' => $record["Other Document Name [Contracts & Forms-Contracts & Forms]"],
                    'DocsOtherTaCs' => $record["Other Document [Contracts & Forms-Contracts & Forms]"],
                    'PrefPaymentMethod' => substr($record["Preferred Payment Method [Billing-Billing & Profile]"], 0, 1),
                    'ChargeCardOnFile' => $ChargeCardOnFile,
                    'BillingNotes' => $record["Billing Notes [Billing-Billing & Profile]"],
                    'BillingType' => $record["Billing Type [Billing-Billing & Profile]"]
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
