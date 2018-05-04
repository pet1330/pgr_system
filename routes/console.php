<?php

use App\Models\Milestone;
use App\Notifications\DueTodayReminder;
use App\Notifications\StartTodayReminder;

Artisan::command('reminders:starttoday', function () {
    Milestone::upcoming()->whereHas('type', function ($q) {
        $q->whereNotNull('duration');
    })->get()->filter->startsToday()->each(function (Milestone $m) {
        $m->student->student->notify(
            new StartTodayReminder(
                $m->student->student, $m->student, $m
            )
        );
    });
})->describe('Send upcoming milestone reminders');

Artisan::command('reminders:duetoday', function () {
    Milestone::upcoming()
        ->where('due_date', Carbon\Carbon::today())
        ->get()->each(function (Milestone $m) {
            $m->student->student->notify(
                new DueTodayReminder(
                    $m->student->student, $m->student, $m
                )
            );
        }
    );
})->describe('Send upcoming milestone reminders');
