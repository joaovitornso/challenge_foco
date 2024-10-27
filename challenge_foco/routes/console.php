<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();


// Artisan::command('import:xml', function () {
//     Log::info(Inspiring::quote());
// })->purpose('Import XML data');

Schedule::command('app:import-xml')->everyTenMinutes()->after(function () {
    Log::info('Comando app:import-xml executado.');
});

