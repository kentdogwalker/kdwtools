<?php

namespace App\Services;

use App\Models\Client;

class ClientService
{
      public function csvUpdateOrCreate($record)
      {
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

            Client::updateOrCreate(['ClientID' => $record["ClientID"]], [
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
}
