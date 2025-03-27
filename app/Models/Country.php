<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\CountryObserver;

#[ObservedBy([CountryObserver::class])]
class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',

        'slug',
    ];

    public function agencies(): HasMany
    {
        return $this->hasMany(Agency::class);
    }
}
