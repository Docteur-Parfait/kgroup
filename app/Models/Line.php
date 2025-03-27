<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\LineObserver;

#[ObservedBy([LineObserver::class])]
class Line extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'departure_country_id',
        'arrival_country_id',
        'prices',
    ];

    protected $casts = [
        'prices' => 'array',
    ];

    public function departureCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'departure_country_id');
    }

    public function arrivalCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'arrival_country_id');
    }

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }
}
