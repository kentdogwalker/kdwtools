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
        Schema::create('hotelbookings', function (Blueprint $table) {
            $table->id('HotelBookingID');
            $table->unsignedBigInteger('ClientID');
            $table->foreign('ClientID')->references('ClientID')->on('clients');
            $table->unsignedBigInteger('PetID');
            $table->foreign('PetID')->references('PetID')->on('pets');
            $table->unsignedBigInteger('RoomID');
            $table->foreign('RoomID')->references('RoomID')->on('rooms');
            $table->string('DogName', 100);
            $table->integer('Duration');
            $table->date('StayStart');
            $table->date('StayEnd');
            $table->string('DogPhoto')->nullable();
            $table->enum('Status', ['Scheduled', 'Completed', 'Cancelled'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotelbookings');
    }
};
