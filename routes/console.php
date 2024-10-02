<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    $oneMonthAgo = Carbon::now()->subMonth();

    $count = DB::table('notifications')->whereDate('created_at', '<=', $oneMonthAgo)->where('read_at', '!=', null)->delete();

    if ($count == 0) {
        Log::channel('schedulelog')->info('No notifications to delete.');
    } else {
        Log::channel('schedulelog')->info('Deleting old notifications.');
    }
})->monthly();
