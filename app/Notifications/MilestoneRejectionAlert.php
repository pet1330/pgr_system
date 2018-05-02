<?php

namespace App\Notifications;

use App\Models\Media;
use App\Models\Student;
use App\Models\Milestone;
use App\Models\StudentRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MilestoneRejectionAlert extends Notification implements ShouldQueue
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
        $url = route('student.record.milestone.show',
            [$this->student->university_id,
            $this->record->slug(), 
            $this->milestone->slug()
            ]);

        $message = 'This email is to inform you that your milestone "'.$this->milestone->name.'"" has been REJECTED. You will be required to amend your documentation and submit and updated version. Please liaise with your PGR admin team for further clarification.';

        return (new MailMessage)
            ->line($message)
            ->action('View Milestone', $url)
            ->line('Thanks!')
            ->subject('Milestone REJECTED: ' . $this->milestone->name);
    }
}
