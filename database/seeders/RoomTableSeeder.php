<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Make sure you have this import for DB facade

class RoomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Define the list of rooms to insert
        $rooms = [
            ['RoomID' => 1, 'RoomName' => 'London Suite'],
            ['RoomID' => 2, 'RoomName' => 'New York Suite'],
            ['RoomID' => 3, 'RoomName' => 'Parisian Suite'],
            ['RoomID' => 4, 'RoomName' => 'Amsterdam Suite'], // Added comma
            ['RoomID' => 5, 'RoomName' => 'Disney Suite'], // Added comma
            ['RoomID' => 6, 'RoomName' => 'Hogwarts Suite'], // Added comma
            ['RoomID' => 7, 'RoomName' => 'Star Wars Suite'], // Added comma
            ['RoomID' => 8, 'RoomName' => 'Safari Suite'] // Corrected last item (no comma needed here)
            // Add more rooms as needed
        ];

        // Insert data into the 'rooms' table
        DB::table('rooms')->insert($rooms);
    }
}
