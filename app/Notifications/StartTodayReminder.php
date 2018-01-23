<?php

namespace App\Notifications;

use Carbon\Carbon;
use App\Models\Student;
use App\Models\Milestone;
use App\Models\StudentRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class StartTodayReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public $record;
    public $student;
    public $milestone;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Student $student,
        StudentRecord $record, Milestone $milestone)
    {
        $this->record = $record;
        $this->student = $student;
        $this->milestone = $milestone;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = route('admin.student.record.milestone.show', [
            $this->student->university_id,
            $this->record->slug(),
            $this->milestone->slug()
        ]);

        
        $duediff = Carbon::today()->diffForHumans(
            $this->milestone->due_date->copy()
            ->addDay(1)->startOfDay(), true);

        return (new MailMessage)
            ->subject('Reminder: Upcoming Milestone')
            ->line('This email is to remind you that the following milestone is due in ' . $duediff . '.')
            ->action('View Milestone', $url)
            ->line('Thanks!');
    }
}