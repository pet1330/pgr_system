<?php

use Carbon\Carbon;
use App\Models\Milestone;
use App\Models\StudentRecord;
use App\Notifications\DueTodayReminder;
use App\Notifications\StartTodayReminder;

if (config('app.proxy_url')) {
    URL::forceRootUrl(config('app.proxy_url'));
}

Artisan::command('reminders:starttoday', function () {
    Milestone::upcoming()->whereHas('type', function ($q) {
        $q->whereNotNull('duration');
    })->get()->filter->startsToday()->each(function (Milestone $m) {
        $m->student->student->notify(
            new StartTodayReminder(
                $m->student->student, $m->student, $m
            )
        );
        $m->student->supervisor(1)->notify(
            new StartTodayReminder(
                $m->student->student, $m->student, $m
            )
        );
        $m->student->school->notify(
            new StartTodayReminder(
                $m->student->student, $m->student, $m
            )
        );
    });
})->describe('Send upcoming milestone reminders');

Artisan::command('reminders:duetoday', function () {
    Milestone::upcoming()
        ->where('due_date', Carbon::today())
        ->get()->each(function (Milestone $m) {
            $m->student->student->notify(
                new DueTodayReminder(
                    $m->student->student, $m->student, $m
                )
            );
            $m->student->supervisor(1)->notify(
                new DueTodayReminder(
                    $m->student->student, $m->student, $m
                )
            );
            $m->student->school->notify(
                new DueTodayReminder(
                    $m->student->student, $m->student, $m
                )
            );
        }
    );
})->describe('Send upcoming milestone reminders');

Artisan::command('pgr:tidy-archive', function () {
    StudentRecord::onlyTrashed()
    ->where('deleted_at', '<', Carbon::today()->subYears(config('app.archive_limit')))
    ->get()->each->forceDelete();
})->describe(sprintf('Permanently removes archived records older than %u years', config('app.archive_limit')));
