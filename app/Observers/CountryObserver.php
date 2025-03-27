<?php

namespace App\Observers;

use App\Models\Country;
use Illuminate\Support\Str;

class CountryObserver
{
    public function creating(Country $model): void
    {
        $model->slug = Str::slug($model->name);
    }
    /**
     * Handle the Country "created" event.
     */
    public function created(Country $country): void
    {
        //
    }

    /**
     * Handle the Country "updated" event.
     */
    public function updated(Country $model): void
    {
        $model->slug = Str::slug($model->name);
    }

    /**
     * Handle the Country "deleted" event.
     */
    public function deleted(Country $country): void
    {
        //
    }

    /**
     * Handle the Country "restored" event.
     */
    public function restored(Country $country): void
    {
        //
    }

    /**
     * Handle the Country "force deleted" event.
     */
    public function forceDeleted(Country $country): void
    {
        //
    }
}
