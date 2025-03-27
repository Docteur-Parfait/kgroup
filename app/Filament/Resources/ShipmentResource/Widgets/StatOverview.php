<?php

namespace App\Filament\Resources\ShipmentResource\Widgets;

use App\Models\Booking;
use App\Models\Shipment;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $shipments = Shipment::count();

        $bookings = Booking::count();
        // En transit
        $shipmentsInProgress = Shipment::where('status', 'in_transit')->count();
        // En attente
        $shipmentsWaiting = Shipment::where('status', 'pending')->count();
        return [
            Stat::make('Bookings', $bookings),
            Stat::make('Expéditions', $shipments),
            Stat::make('En transit', $shipmentsInProgress),
            Stat::make('En attente', $shipmentsWaiting),
        ];
    }
}
