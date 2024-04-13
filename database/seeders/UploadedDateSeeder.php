<?php

namespace Database\Seeders;

use App\Models\UploadedDate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UploadedDateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UploadedDate::create([
            'name_of_import' => 'clients',
            'status' => 'Not Yet'
        ]);

        UploadedDate::create([
            'name_of_import' => 'vets',
            'status' => 'Not Yet'
        ]);

        UploadedDate::create([
            'name_of_import' => 'pets',
            'status' => 'Not Yet'
        ]);

        UploadedDate::create([
            'name_of_import' => 'services',
            'status' => 'Not Yet'
        ]);
    }
}
