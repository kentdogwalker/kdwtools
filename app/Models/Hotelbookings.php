<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotelbookings extends Model
{
    use HasFactory;

    protected $fillable = [
        'ClientID',
        'PetID',
        'RoomID',
        'DogName',
        'Duration',
        'StayStart',
        'StayEnd',
        'DogPhoto',
        'Status'
    ];

    protected $primaryKey = 'HotelBookingID';

    public function clients()
    {
        return $this->belongsTo(Client::class, 'ClientID');
    }

    public function pets()
    {
        return $this->belongsTo(Pet::class, 'PetID');
    }

    public function rooms()
    {
        return $this->belongsTo(Room::class, 'RoomID');
    }
}
