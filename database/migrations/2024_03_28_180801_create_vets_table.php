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
        Schema::create('vets', function (Blueprint $table) {
            $table->id('VetID');
            $table->string('Practice_Name')->nullable();
            $table->string('Veterinarian_Name')->nullable();
            $table->string('Address_line1')->nullable();
            $table->string('Address_line2')->nullable();
            $table->string('Address_line3')->nullable();
            $table->string('Address_town')->nullable();
            $table->string('Address_state')->nullable();
            $table->string('Address_zip')->nullable();
            $table->string('Phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vets');
    }
};
