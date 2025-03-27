<?php

namespace App\Observers;

use App\Models\Shipment;

class ShipmentObserver
{
    public function creating(Shipment $shipment): void
    {
        $ref = strtoupper(uniqid());

        if ($shipment->ref == null) {
            $shipment->ref = $ref;
        }

        generateQrCode($shipment->ref);
    }
    /**
     * Handle the Shipment "created" event.
     */
    public function created(Shipment $shipment): void
    {
        //
    }

    /**
     * Handle the Shipment "updated" event.
     */
    public function updated(Shipment $shipment): void
    {
        //
    }

    /**
     * Handle the Shipment "deleted" event.
     */
    public function deleted(Shipment $shipment): void
    {
        //
    }

    /**
     * Handle the Shipment "restored" event.
     */
    public function restored(Shipment $shipment): void
    {
        //
    }

    /**
     * Handle the Shipment "force deleted" event.
     */
    public function forceDeleted(Shipment $shipment): void
    {
        //
    }
}
