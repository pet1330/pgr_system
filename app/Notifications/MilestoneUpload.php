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

class MilestoneUpload extends Notification implements ShouldQueue
{
    use Queueable;

    public $student;
    public $record;
    public $milestone;
    public $file;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Student $student,
        StudentRecord $record, Milestone $milestone, Media $file)
    {
        $this->student = $student;
        $this->record = $record;
        $this->milestone = $milestone;
        $this->file = $file;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = route('admin.student.record.milestone.show',
            [$this->student->university_id,
            $this->record->slug(), 
            $this->milestone->slug()
            ]);
        return (new MailMessage)
            ->line('This is an email to confirm that the attached file has been uploaded to the milestone: ' . $this->milestone->name)
            ->action('View Milestone', $url)
            ->line('Thanks!')
            ->attach($this->file->getAbsolutePath(), [
                'as' => snake_case($this->student->name.' '.$this->file->created_at).'.'.$this->file->extension,
                'mime' => $this->file->mime_type,
            ]);
    }

    public function toDatabase($notifiable)
    {
        return [
            'subject' => "Milestone Updated!",
            'body' => "A new file has been uploaded to your milestone"
            ];
    }
}
