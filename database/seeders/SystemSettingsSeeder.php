<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (SystemSetting::count() > 0) {
            return;
        }

        SystemSetting::create([
            'currency_id' => 97,
            'timezone_id' => 425,
            'clock_format' => 'H:i',
            'date_format' => 'Y-m-d',
            'datetime_format' => 'Y-m-d H:i',
        ]);
    }
}
