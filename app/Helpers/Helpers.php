<?php

use App\Models\Line;
use App\Models\Stepper;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

function getStepper($id): Stepper
{
    return Stepper::find($id);
}

function transportationMode(): array
{
    return [
        "BATEAU" => "Bateau",
        "AVION" => "Avion"
    ];
}

function getVilles(): array
{
    return [
        "Ottawa" => "Ottawa",
        "Gatineau" => "Gatineau",
        "Quebec" => "Quebec",
        "Sherbrooke" => "Sherbrooke",
        "Granby" => "Granby",
        "Levy" => "Levy",
        "Toronto" => "Toronto",
    ];
}
function getLineTransportMode($line_id): array
{
    $line = Line::find($line_id);
    $transportModes = [];
    foreach ($line->prices as $price) {
        $transportModes[$price["transport_mode"]] = $price["transport_mode"];
    }
    return $transportModes;
}

function getQrCode($ref)
{
    // Generate QR code with text "Hello, Laravel 11!"
    $qrCode = QrCode::size(120)->generate($ref);

    return $qrCode;
}

function generateQrCode($ref)
{
    $qrCode = QrCode::format('svg')->size(300)->generate($ref);

    // Enregistrer le QR code dans le stockage public
    $filePath = "qrcodes/$ref.svg";
    Storage::disk('public')->put($filePath, $qrCode);

    return "okk";
}

function shipSeed(): array
{
    $data = [ // app\Livewire\ShipmentForm.php:213
        "line_id" => "1",
        "transport_mode" => "BATEAU",
        "ramassage" => true,
        "info_ramassage" =>  [
            0 =>  [
                "ville" => "Granby",
                "address" => "Lome-TOGO, Adidogomé Kohé au niveau des rails"
            ]
        ],
        "sender_info" =>  [
            0 =>  [
                "name" => "Parfait Kokou TOKE",
                "address" => "Lome-TOGO",
                "phone" => "96183519",
                "email" => "parfaittoke@gmail.com"
            ]
        ],
        "receiver_info" =>  [
            0 =>  [
                "name" => "Doc",
                "address" => "Lome-TOGO, Adidogomé Kohé au niveau des rails",
                "phone" => "96183519",
                "email" => "parfaittoke18@gmail.com"
            ]
        ],
        "other_prices" =>  [
            0 =>  [
                "product_id" => "1",
                "quantity" => "2"
            ]
        ],
        "emballage_prices" =>  [
            0 =>  [
                "emballage_id" => "1",
                "quantity" => "2"
            ],
            1 =>  [
                "emballage_id" => "5",
                "quantity" => "1"
            ]
        ],
        "details" => "J'aimerais venir"
    ];

    return $data;
}
