<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'RoomID', 'RoomName'
    ];

    protected $primaryKey = 'RoomID';

    public function hotelbookings()
    {
        return $this->hasMany(Hotelbookings::class, 'RoomID');
    }
}
