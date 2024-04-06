<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'ClientID',
        'StaffID',
        'ServiceName',
        'StayStart',
        'StayEnd',
        'NominalServiceDuration',
        'Duration',
        'DisplayTime',
        'ScheduleTime',
        'DiaryRef',
        'StaffFirstName',
        'StaffLastName',
        'Acknowledged',
        'Area',
        'Status',
        'AssignStatus',
        'CheckIn',
        'CheckOut',
        'Qty',
        'UnitPrice',
        'Total',
        'Invoice',
        'Address1',
        'Address2',
        'Address3',
        'AddressTown',
        'AddressState',
        'AddressZip'
    ];

    public function clients()
    {
        return $this->belongsTo(Client::class, 'ClientID');
    }
}
