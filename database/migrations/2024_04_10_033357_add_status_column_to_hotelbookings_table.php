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
        Schema::table('hotelbookings', function (Blueprint $table) {
            $table->enum('Status', ['Scheduled', 'Completed', 'Cancelled', 'Void'])->nullable()->after('DogPhoto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotelbookings', function (Blueprint $table) {
            //
        });
    }
};
