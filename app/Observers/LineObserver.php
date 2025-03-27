<?php

namespace App\Observers;

use App\Models\Line;

class LineObserver
{
    public function creating(Line $model): void
    {
        $model->name = $model->departureCountry->name . " - " . $model->arrivalCountry->name;
    }
    /**
     * Handle the Line "created" event.
     */
    public function created(Line $line): void
    {
        //
    }

    /**
     * Handle the Line "updated" event.
     */
    public function updated(Line $line): void
    {
        //
    }

    /**
     * Handle the Line "deleted" event.
     */
    public function deleted(Line $line): void
    {
        //
    }

    /**
     * Handle the Line "restored" event.
     */
    public function restored(Line $line): void
    {
        //
    }

    /**
     * Handle the Line "force deleted" event.
     */
    public function forceDeleted(Line $line): void
    {
        //
    }
}
