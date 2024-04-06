<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->unsignedBigInteger('ClientID')->after('id');
            $table->foreign('ClientID')->references('ClientID')->on('clients');
            $table->unsignedBigInteger('StaffID')->after('ClientID');
            $table->string('ServiceName', 100)->after('StaffID');
            $table->date('StayStart')->after('ServiceName');
            $table->date('StayEnd')->after('StayStart');
            $table->integer('NominalServiceDuration')->nullable()->after('StayEnd');
            $table->integer('Duration')->after('NominalServiceDuration');
            $table->string('DisplayTime', 100)->after('Duration');
            $table->string('ScheduleTime', 100)->after('DisplayTime');
            $table->string('DiaryRef', 250)->after('ScheduleTime');
            $table->string('StaffFirstName', 100)->after('DiaryRef');
            $table->string('StaffLastName', 100)->after('StaffFirstName');
            $table->boolean('Acknowledged')->after('StaffLastName');
            $table->string('Area', 100)->after('Acknowledged');
            $table->enum('Status', ['Scheduled', 'Completed', 'Cancelled'])->nullable()->after('Area');
            $table->enum('AssignStatus', ['Pending', 'Completed', 'Cencelled'])->after('Status');
            $table->string('CheckIn', 30)->after('AssignStatus')->after('AssignStatus');
            $table->string('CheckOut', 30)->after('CheckIn')->after('CheckIn');;
            $table->integer('Qty')->after('CheckOut')->after('CheckOut');
            $table->float('UnitPrice', 11, 2)->after('Qty');
            $table->float('Total', 11, 2)->after('UnitPrice');
            $table->integer('StafPay')->after('Total');
            $table->string('invoice', 50)->after('StafPay');
            $table->text('Address1')->nullable()->after('Invoice');
            $table->text('Address2')->nullable()->after('Address1');
            $table->text('Address3')->nullable()->after('Address2');
            $table->text('AddressTown')->nullable()->after('Address3');
            $table->text('AddressState')->nullable()->after('AddressTown');
            $table->text('AddressZip')->nullable()->after('AddressState');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign(['ClientID']);
        });
    }
};
