<?php

namespace App\Observers;

use App\Models\Agency;
use Illuminate\Support\Str;

class AgencyObserver
{

    public function creating(Agency $model): void
    {
        $model->slug = Str::slug($model->name);
        $model->ref = strtoupper(Str::uuid());
    }
    /**
     * Handle the Agency "created" event.
     */
    public function created(Agency $agency): void
    {
        //
    }

    /**
     * Handle the Agency "updated" event.
     */
    public function updated(Agency $agency): void
    {
        $agency->slug = Str::slug($agency->name);
    }

    /**
     * Handle the Agency "deleted" event.
     */
    public function deleted(Agency $agency): void
    {
        //
    }

    /**
     * Handle the Agency "restored" event.
     */
    public function restored(Agency $agency): void
    {
        //
    }

    /**
     * Handle the Agency "force deleted" event.
     */
    public function forceDeleted(Agency $agency): void
    {
        //
    }
}
