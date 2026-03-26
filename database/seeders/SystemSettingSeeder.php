<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemSetting;

class SystemSettingSeeder extends Seeder
{
    public function run(): void
    {
        SystemSetting::updateOrCreate(
            ['id' => 1],
            [
                'company_name' => 'Acme Corporation',
                'fiscal_year' => 'Jan - Dec',
                'currency' => 'USD ($)',
                'time_zone' => 'EST (UTC-5)',
            ]
        );
    }
}