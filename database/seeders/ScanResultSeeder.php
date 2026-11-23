<?php

namespace Database\Seeders;

use App\Models\ScanResult;
use Illuminate\Database\Seeder;

class ScanResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ScanResult::factory()->count(3)->create();
    }
}
