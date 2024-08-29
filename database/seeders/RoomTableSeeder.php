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
            ['RoomID' => 1, 'RoomName' => 'Disney Suite'],
            ['RoomID' => 2, 'RoomName' => 'Hogwarts Suite'],
            ['RoomID' => 3, 'RoomName' => 'Star Wars Suite'],
            ['RoomID' => 4, 'RoomName' => 'Madagascar Suite'],
            ['RoomID' => 5, 'RoomName' => 'Bangkok Suite'],
            ['RoomID' => 6, 'RoomName' => 'New York Suite'],
            ['RoomID' => 7, 'RoomName' => 'Parisian Suite'],
            ['RoomID' => 8, 'RoomName' => 'London Suite'],
            
            //Changed room names and order to match layout of rooms.

            // Add more rooms as needed
        ];

        // Insert data into the 'rooms' table
        DB::table('rooms')->insert($rooms);
    }
}
