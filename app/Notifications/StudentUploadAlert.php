<?php

namespace App\Notifications;

use App\Models\Media;
use App\Models\Milestone;
use App\Models\Student;
use App\Models\StudentRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StudentUploadAlert extends Notification implements ShouldQueue
{
    use Queueable;

    public $file;
    public $record;
    public $student;
    public $milestone;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Student $student,
        StudentRecord $record, Milestone $milestone, Media $file)
    {
        $this->file = $file;
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
            $this->milestone->slug(),
            ]);

        $message = 'This email is to inform you that '.$this->file->uploader->name.' has submitted a file to your milestone: '.$this->milestone->name;

        return (new MailMessage)
            ->line($message.'.')
            ->line('A copy of the uploaded file is attached.')
            ->action('View Milestone', $url)
            ->line('Thanks!')
            ->attach($this->file->getAbsolutePath(), [
                'as' => snake_case($this->student->name.' '.$this->file->created_at).'.'.$this->file->extension,
                'mime' => $this->file->mime_type,
            ])->subject('Upload Alert - '.$this->milestone->name);
    }
}
