<?php

/*
 * This file is part of the IndoRegion package.
 *
 * (c) Azis Hapidin <azishapidin.com | azishapidin@gmail.com>
 *
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Aswadwk\Indonesiaregion\RawDataGetter;
use Illuminate\Support\Facades\DB;

class IndoRegionCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @deprecated
     *
     * @return void
     */
    public function run()
    {
        // Get Data
        $regencies = RawDataGetter::getPostalCodes();

        // Insert Data with Chunk
        DB::transaction(function() use($regencies) {
            $collection = collect($regencies);
            $parts = $collection->chunk(1000);
            foreach ($parts as $subset) {
                DB::table('postal_codes')->insert($subset->toArray());
            }
        });
    }
}
