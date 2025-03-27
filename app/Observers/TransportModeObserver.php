<?php

namespace App\Observers;

use App\Models\TransportMode;

class TransportModeObserver
{
    /**
     * Handle the TransportMode "created" event.
     */
    public function created(TransportMode $transportMode): void
    {
        //
    }

    /**
     * Handle the TransportMode "updated" event.
     */
    public function updated(TransportMode $transportMode): void
    {
        //
    }

    /**
     * Handle the TransportMode "deleted" event.
     */
    public function deleted(TransportMode $transportMode): void
    {
        //
    }

    /**
     * Handle the TransportMode "restored" event.
     */
    public function restored(TransportMode $transportMode): void
    {
        //
    }

    /**
     * Handle the TransportMode "force deleted" event.
     */
    public function forceDeleted(TransportMode $transportMode): void
    {
        //
    }
}
