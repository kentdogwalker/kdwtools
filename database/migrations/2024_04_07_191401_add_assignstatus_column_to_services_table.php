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
            $table->enum('Status', ['Scheduled', 'Completed', 'Cancelled', 'Void'])->nullable()->after('Area');
            $table->enum('AssignStatus', ['Void', 'Pending', 'Completed', 'Cancelled'])->nullable()->after('Status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            //
        });
    }
};
