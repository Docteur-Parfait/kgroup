<?php

namespace Database\Seeders;

use App\Models\Stepper;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StepperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $steps = [
            [
                "name" => "Prise en charge du colis chez le client au Canada",
                "icon" => "fas fa-box", // Icône de colis

                "code" => "SUC1"
            ],
            [
                "name" => "Transport du colis vers l’agence logistique",
                "icon" => "fas fa-truck-moving", // Icône de camion de transport

                "code" => "SUC2"
            ],
            [
                "name" => "Vérification et enregistrement du colis à l’agence",
                "icon" => "fas fa-clipboard-check", // Icône de vérification

                "code" => "SUC3"
            ],
            [
                "name" => "Préparation pour l’expédition (emballage, documents douaniers, etc.)",
                "icon" => "fas fa-boxes", // Icône d’emballage

                "code" => "SUC4"
            ],
            [
                "name" => "Transport vers le port ou l’aéroport",
                "icon" => "fas fa-plane-departure", // Icône d’avion

                "code" => "SUC5"
            ],
            [
                "name" => "Embarquement du colis sur le bateau ou l’avion",
                "icon" => "fas fa-ship", // Icône de bateau

                "code" => "SUC6"
            ],
            [
                "name" => "Transport international du Canada au Togo",
                "icon" => "fas fa-globe-americas", // Icône de voyage

                "code" => "SUC7"
            ],
            [
                "name" => "Arrivée au port ou à l’aéroport au Togo",
                "icon" => "fas fa-warehouse", // Icône d’entrepôt

                "code" => "SUC8"
            ],
            [
                "name" => "Contrôle douanier et formalités d’importation",
                "icon" => "fas fa-file-invoice-dollar", // Icône de documents

                "code" => "SUC9"
            ],
            [
                "name" => "Transport vers le centre de distribution local",
                "icon" => "fas fa-truck-loading", // Icône de chargement

                "code" => "SUC10"
            ],
            [
                "name" => "Acheminement vers l’adresse du destinataire",
                "icon" => "fas fa-map-marker-alt", // Icône d’adresse

                "code" => "SUC11"
            ],
            [
                "name" => "Livraison au client final",
                "icon" => "fas fa-handshake", // Icône de livraison

                "code" => "SUC12"
            ]
        ];

        foreach ($steps as $step) {
            Stepper::create($step);
        }
    }
}
