<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id('ClientID');
            $table->bigInteger('AccountID');
            $table->string('Status', 20);
            $table->string('InvoiceType', 50);
            $table->integer('PrimaryStaffID')->nullable();
            $table->string('StaffFirstName', 25);
            $table->string('StaffLastName', 25);
            $table->integer('TeamID')->nullable();
            $table->text('TeamMembers');
            $table->text('Area');
            $table->text('Type');
            $table->text('DiaryRef');
            $table->text('FirstName');
            $table->text('LastName');
            $table->text('Email');
            $table->string('HomePhone', 25);
            $table->string('WorkPhone', 25);
            $table->string('MobilePhone', 25);
            $table->text('Address1');
            $table->text('Address2');
            $table->text('Address3');
            $table->text('AddressTown');
            $table->text('AddressState');
            $table->string('AddressZip', 10);
            $table->string('Run', 4);
            $table->text('AltFirstName');
            $table->text('AltLastName');
            $table->text('AltRelationship');
            $table->text('AltEmail');
            $table->boolean('AltCCEmail');
            $table->string('AltHomePhone', 20);
            $table->string('AltWorkPhone', 20);
            $table->string('AltMobilePhone', 20);
            $table->text('AltAddress1');
            $table->text('AltAddress2');
            $table->text('AltAddress3');
            $table->text('AltAddressTown');
            $table->text('AltAddressState');
            $table->string('AltAddressZip', 255);
            $table->boolean('AltKeyHolder');
            $table->string('AccessDoorImage', 1);
            $table->text('LockBoxCodeAndLocation')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('LockBoxImage', 1);
            $table->boolean('Alarmed');
            $table->text('AlarmInstructions')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('AlarmImage', 1);
            $table->boolean('KDWhasKey');
            $table->string('ParkingSpaceImage', 1);
            $table->text('BuildingAccessInstructions')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->text('AccessKey');
            $table->string('WalkInfoPhoto', 1);
            $table->text('WalkInfoKeySafeInstructions')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->text('WalkInfoDogLeft')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->text('WalkInfoWalkingInfo')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->text('WalkInfoFeedingInfo')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->text('WalkInfoWalkWithOthers')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('WalkInfoHarnessPhoto', 1);
            $table->text('WalkInfoImportantInfo')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('What3Words', 100);
            $table->string('WalkInfoExtraPhoto1', 1);
            $table->string('WalkInfoExtraPhoto2', 1);
            $table->text('AdminNotes')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->text('StaffNotes')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->text('Emg1FirstName');
            $table->text('Emg1LastName');
            $table->text('Emg1Relationship');
            $table->text('Emg1Email');
            $table->boolean('Emg1CCEmail');
            $table->string('Emg1HomePhone', 25);
            $table->string('Emg1WorkPhone', 25);
            $table->string('Emg1MobilePhone', 25);
            $table->text('Emg1Address1');
            $table->text('Emg1Address2');
            $table->text('Emg1Address3');
            $table->text('Emg1AddressTown');
            $table->text('Emg1AddressState');
            $table->string('Emg1AddressZip', 255);
            $table->boolean('Emg1KeyHolder');
            $table->text('Emg1Notes')->charset('utf8mb4')->collation('utf8mb4_unicode_ci'); // For long text, including emojis
            $table->string('Emg2FirstName', 50);
            $table->string('Emg2LastName', 50);
            $table->string('Emg2Relationship', 50);
            $table->string('Emg2Email', 100);
            $table->string('Emg2HomePhone', 25);
            $table->string('Emg2WorkPhone', 25);
            $table->string('Emg2MobilePhone', 25);
            $table->text('Emg2Address1');
            $table->text('Emg2Address2');
            $table->text('Emg2Address3');
            $table->text('Emg2AddressTown');
            $table->text('Emg2AddressState');
            $table->string('Emg2AddressZip', 255);
            $table->boolean('Emg2KeyHolder');
            $table->text('Emg2Notes')->charset('utf8mb4')->collation('utf8mb4_unicode_ci'); // For long text, including emojis
            $table->string('Emg3FirstName', 50);
            $table->string('Emg3LastName', 50);
            $table->text('Emg3Relationship');
            $table->text('Emg3Email');
            $table->string('Emg3HomePhone', 25);
            $table->string('Emg3WorkPhone', 25);
            $table->string('Emg3MobilePhone', 25);
            $table->text('Emg3Address1');
            $table->text('Emg3Address2');
            $table->text('Emg3Address3');
            $table->text('Emg3AddressTown');
            $table->text('Emg3AddressState');
            $table->string('Emg3AddressZip', 255);
            $table->boolean('Emg3KeyHolder');
            $table->text('Emg3Notes')->charset('utf8mb4')->collation('utf8mb4_unicode_ci'); // For long text, including emojis
            $table->boolean('RequirePickDrop');
            $table->text('PickupInstructions')->charset('utf8mb4')->collation('utf8mb4_unicode_ci'); // For long text, including emojis
            $table->text('DropOffInstructions')->charset('utf8mb4')->collation('utf8mb4_unicode_ci'); // For long text, including emojis
            $table->text('WetInstructions')->charset('utf8mb4')->collation('utf8mb4_unicode_ci'); // For long text, including emojis
            $table->boolean('BringInMail');
            $table->text('MailInstructions')->charset('utf8mb4')->collation('utf8mb4_unicode_ci'); // For long text, including emojis
            $table->boolean('BringInNewspaper');
            $table->text('NewspaperInstructions')->charset('utf8mb4')->collation('utf8mb4_unicode_ci'); // For long text, including emojis
            $table->boolean('TakeOutRubbish');
            $table->text('RubbishInstructions')->charset('utf8mb4')->collation('utf8mb4_unicode_ci'); // For long text, including emojis
            $table->boolean('WaterIndoorPlants');
            $table->text('IndoorPlantInstructions')->charset('utf8mb4')->collation('utf8mb4_unicode_ci'); // For long text, including emojis
            $table->boolean('WaterOutdoorPlants');
            $table->text('OutdoorPlantInstructions')->charset('utf8mb4')->collation('utf8mb4_unicode_ci'); // For long text, including emojis
            $table->boolean('AdjustAC');
            $table->text('ACInstructions')->charset('utf8mb4')->collation('utf8mb4_unicode_ci'); // For long text, including emojis
            $table->boolean('AdjustLights');
            $table->text('LightsInstructions')->charset('utf8mb4')->collation('utf8mb4_unicode_ci'); // For long text, including emojis
            $table->boolean('AdjustCurtains');
            $table->text('CurtainInstructions')->charset('utf8mb4')->collation('utf8mb4_unicode_ci'); // For long text, including emojis
            $table->boolean('OtherInstructions');
            $table->text('OtherHouseSitInstructions')->charset('utf8mb4')->collation('utf8mb4_unicode_ci'); // For long text, including emojis
            $table->string('DocsClientReg', 1); // For short text fields
            $table->string('DocsDaycareTaCs', 1); // For short text fields
            $table->string('DocsOffleadTaCs', 1); // For short text fields
            $table->string('DocsWalksTaCs', 1); // For short text fields
            $table->string('DocsBoardingTaCs', 1); // For short text fields
            $table->string('DocsGroomingTaCs', 1); // For short text fields
            $table->string('DocsOLDTaCs', 1); // For short text fields
            $table->string('DocsClientCareTaCs', 1); // For short text fields
            $table->string('DocsDogAssessTaCs', 1); // For short text fields
            $table->string('DocsOtherNameTaCs', 1); // For short text fields
            $table->string('DocsOtherTaCs', 1); // For short text fields
            $table->string('PrefPaymentMethod', 1); // For short text fields
            $table->boolean('ChargeCardOnFile');
            $table->text('BillingNotes')->charset('utf8mb4')->collation('utf8mb4_unicode_ci'); // For long text, including emojis
            $table->string('BillingType', 255); // For short text fields


            // Additional fields as per your CSV headers
            // ...

            // Example placeholders for different data types
            // $table->string('ExampleTextShort', 255); // For short text fields
            // $table->text('ExampleTextLong')->charset('utf8mb4')->collation('utf8mb4_unicode_ci'); // For long text, including emojis
            // $table->integer('ExampleInteger');
            // $table->boolean('ExampleBoolean');
            // $table->date('ExampleDate');
            // $table->dateTime('ExampleDateTime');

            // Assuming placeholders are repeated and adapted for all 146 columns

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }

};
