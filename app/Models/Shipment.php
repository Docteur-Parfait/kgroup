<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\ShipmentObserver;

#[ObservedBy([ShipmentObserver::class])]
class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ref',
        'sender_id',
        "booking_id",
        'line_id',
        'transport_mode',
        'departure_agency',
        'arrival_agency',
        'ramassage',
        'info_ramassage',
        "emballage_prices",
        'sender_info',
        'receiver_info',
        'weight',
        'other_prices',
        'tracking_info',
        'pictures',
        'payment_status',
        'status',
        'total_cost'
    ];

    protected $casts = [

        'receiver_info' => 'array',
        'other_prices' => 'array',
        'tracking_info' => 'array',
        'payment_info' => 'array',
        'sender_info' => 'array',
        'info_ramassage' => 'array',
        'emballage_prices' => 'array',
        'pictures' => 'array',
    ];


    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function transportMode(): BelongsTo
    {
        return $this->belongsTo(TransportMode::class);
    }

    public function departureAgency(): BelongsTo
    {
        return $this->belongsTo(Agency::class, 'departure_agency_id');
    }

    public function arrivalAgency(): BelongsTo
    {
        return $this->belongsTo(Agency::class, 'arrival_agency_id');
    }

    public function line(): BelongsTo
    {
        return $this->belongsTo(Line::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
