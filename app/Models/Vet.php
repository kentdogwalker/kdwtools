<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vet extends Model
{
    use HasFactory;

    protected $fillable = [
        'VetID', 'Practice_Name', 'Veterinarian_Name', 'Address_line1', 'Address_line2', 'Address_line3',
        'Address_town', 'Address_state', 'Address_zip', 'Phone'
    ];

    protected $primaryKey = 'VetID';

    public function pets()
    {
        return $this->hasMany(Pet::class, 'PetID');
    }
}
