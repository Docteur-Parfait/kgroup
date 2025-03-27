<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\TransportModeObserver;

#[ObservedBy([TransportModeObserver::class])]
class TransportMode extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }
}
