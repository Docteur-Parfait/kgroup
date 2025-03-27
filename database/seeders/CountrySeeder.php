<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            "Canada",
            "Togo",
            "Côte d'Ivoire"
        ];

        foreach ($countries as $country) {
            \App\Models\Country::create([
                'name' => $country,
            ]);
        }
    }
}
